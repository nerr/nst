<?php

class Calculate
{
    public static function getFundLog($uid)
    {
        //-- get log
        $criteria = new CDbCriteria;
        $criteria->select = 'amount,directioinname,flowtime,memo';
        $criteria->condition='userid=:userid';
        $criteria->params = array(':userid' => $uid);
        $criteria->order  = 'flowtime DESC';
        $result = ViewTaSwapCapitalFlow::model()->findAll($criteria);

        return $result;
    }

    public static function getGeneralSummaryData($uid)
    {
        $data = array();
        $data['charts']['swap'] = array();
        $data['charts']['cost'] = array();
        $data['charts']['netearning'] = array();

        //-- get closed ring profit (proft+getswap+commission)
        $criteria = new CDbCriteria;
        $criteria->select = 'getswap,endprofit,commission,closedate';
        $criteria->condition = 'userid=:userid and orderstatus=:orderstatus';
        $criteria->order = 'closedate';
        $criteria->params = array(':userid' => $uid,
                                ':orderstatus' => 1);
        $result = TaSwapOrder::model()->findAll($criteria);

        $idate = '';
        $closedswap = 0;
        $closedprofit = 0;
        foreach($result as $val)
        {
            //-- summary closed data
            $data['summary']['closed'] += $val->getswap + $val->endprofit + $val->commission;

            //-- get history closed order swap data
            $date = date('Y-m-d', strtotime($val->closedate.'+1 day'));
            
            if($idate == '')
            {
                $data['summary']['closedswap'][$date] = $val->getswap;
                $data['summary']['closedprofit'][$date] = $val->endprofit + $val->commission;
            }
            elseif($idate != $date)
            {
                $data['summary']['closedswap'][$date] = $closedswap;
                $data['summary']['closedprofit'][$date] = $closedprofit;
            }
            else
            {
                $data['summary']['closedswap'][$date] += $val->getswap;
                $data['summary']['closedprofit'][$date] += $val->endprofit + $val->commission;
            }

            $closedswap += $val->getswap;
            $closedprofit += $val->endprofit + $val->commission;
            $idate = $date;
        }

        //-- get init balance (real capital + closed profit)
        $data['summary']['capital'] = Calculate::getCapital($uid);

        $data['summary']['balance'] = $data['summary']['capital']; //-- + $data['summary']['closed'];


        //-- get commission
        $criteria = new CDbCriteria;
        $criteria->select='commission,opendate';
        $criteria->condition = 'userid=:userid and orderstatus=:orderstatus';
        $criteria->params = array(':userid' => $uid, 
                                ':orderstatus' => 0);
        $result = TaSwapOrder::model()->findAll($criteria);

        foreach($result as $val)
        {
            $commission[$val->opendate] += $val->commission;
        }
        if(count($commission) > 0)
            $data['summary']['commission'] = array_sum($commission);
        else
            $data['summary']['commission'] = 0;

        //-- get profit swap
        $criteria = new CDbCriteria;
        $criteria->select = 'logdatetime';
        $criteria->condition='userid=:userid and orderstatus=:orderstatus';
        $criteria->params = array(':userid' => $uid,
                                ':orderstatus' => 0);
        $criteria->order  = 'logdatetime DESC';
        $criteria->limit  = 1;
        $lastdate = ViewTaSwapOrderDetail::model()->find($criteria);

        $data['summary']['lastuptodate'] = $lastdate->logdatetime;

        $criteria = new CDbCriteria;
        $criteria->select = 'profit,swap,logdatetime';
        $criteria->condition = 'userid=:userid';
        $criteria->order  = 'logdatetime';
        $criteria->params = array(':userid' => $uid);
        $result = ViewTaSwapOrderDetail::model()->findAll($criteria);

        foreach($result as $val)
        {
            if(date('Y-m-d', strtotime($val->logdatetime)) == date('Y-m-d', strtotime($lastdate->logdatetime)))
            {
                $data['summary']['swap'] += $val->swap;
                $data['summary']['cost'] += $val->profit;
            }

            $tm = strtotime(date('Y-m-d', strtotime($val->logdatetime)));
            $charts['swap'][$tm] += $val->swap;
            $charts['cost'][$tm] += $val->profit;
        }
        //--
        $capitalcommission = Calculate::getCapitalCommission($uid);
        $data['summary']['cost'] += $data['summary']['closed'] + $capitalcommission;
        $charts['cost'][$tm] += $data['summary']['closed'] + $capitalcommission;

        if(is_array($data['summary']['closedswap']))
        {
            end($data['summary']['closedswap']);
            list(,$cs) = each($data['summary']['closedswap']);
            $data['summary']['swap'] += $cs;
        }

        if(is_array($data['summary']['closedprofit']))
        {       
            end($data['summary']['closedprofit']);
            list(,$cp) = each($data['summary']['closedprofit']);
            $data['summary']['cost'] += $cp;
        }

        

        //-- adjust swap (add closed swap)


        if(count($charts['swap']) > 0)
        {
            //-- append history data to swap and cost
            foreach($charts['swap'] as $t=>$v)
            {
                $charts['swap'][$t] += Calculate::appendCloseSwap(date('Y-m-d', $t), $data['summary']['closedswap']);
                $charts['cost'][$t] += Calculate::appendCloseProfit(date('Y-m-d', $t), $data['summary']['closedprofit']);
            }
        
            foreach($charts['swap'] as $d=>$v)
            {
                array_push($data['charts']['swap'], array($d, $v));
                array_push($data['charts']['cost'], array($d, $charts['cost'][$d] + $data['summary']['commission']));
                array_push($data['charts']['netearning'], array($d, $v + $charts['cost'][$d] + $data['summary']['commission']));
            }
        }

        $data['summary']['cost'] += $data['summary']['commission']; // adjust the cost value

        //-- get net earning
        $data['summary']['netearning'] = $data['summary']['swap'] + $data['summary']['cost'];
        $data['summary']['balance'] += $data['summary']['netearning'];

        //--
        $data['swapratechart'] = Calculate::getSwapRateChartData();

        return $data;
    }

    public static function getSwapRateChartData()
    {
        $aid = 2; //-- account id

        $criteria = new CDbCriteria;
        $criteria->select='symbol,logdatetime,longswap,shortswap';
        $criteria->condition = 'accountid=:accountid';
        $criteria->order = 'logdatetime';
        $criteria->params = array(':accountid' => $aid);
        $result = TaSwapRate::model()->findAll($criteria);

        foreach($result as $val)
        {
            $logdate = strtotime(date('Y-m-d', strtotime($val->logdatetime)));

            $swaprate[$val->symbol.'long'][] = array($logdate, $val->longswap);
            $swaprate[$val->symbol.'short'][] = array($logdate, $val->shortswap);
        }

        /*foreach($swaprate as $k=>$v)
        {
            $swaprate[$k][1] = (int)$swaprate[$k][1];
        }*/

        return $swaprate;
    }

    public static function getCapital($uid)
    {
        //-- get init balance
        $criteria = new CDbCriteria;
        $criteria->select='amount,directionid';
        $criteria->condition='userid=:userid and directionid<>3'; //-- without commission
        $criteria->params=array(':userid' => $uid);
        $result = SysCapitalFlow::model()->findAll($criteria);

        foreach($result as $val)
        {
            $capital += $val->amount;
        }

        return $capital;
    }

    public static function getCapitalCommission($uid)
    {
        $criteria = new CDbCriteria;
        $criteria->select='amount,directionid';
        $criteria->condition='userid=:userid and directionid=3'; //-- without commission
        $criteria->params=array(':userid' => $uid);
        $result = SysCapitalFlow::model()->findAll($criteria);

        foreach($result as $val)
        {
            $capital += $val->amount;
        }

        return $capital;
    }

    public static function appendCloseSwap($date, $closedswap)
    {
        $append = 0;
        $tm = strtotime($date);
        foreach($closedswap as $d=>$v)
        {
            if($tm>=strtotime($d))
                $append = $v;
        }

        return $append;
    }

    public static function appendCloseProfit($date, $closedproft)
    {
        $append = 0;
        $tm = strtotime($date);
        foreach($closedproft as $d=>$v)
        {
            if($tm>=strtotime($d))
                $append = $v;
        }

        return $append;
    }

    public static function getUserReport($uid)
    {
        //-- 
        $criteria = new CDbCriteria;
        $criteria->select = 'profit,swap,logdatetime';
        $criteria->condition='userid=:userid';
        $criteria->order = 'logdatetime desc';
        $criteria->params = array(':userid' => $uid);
        $result = ViewTaSwapOrderDetail::model()->findAll($criteria);

        $dateArr = array();
        foreach($result as $val)
        {
            $date = date('Y-m-d', strtotime($val->logdatetime));

            $detail[$date]['totalswap'] += $val->swap;
            $detail[$date]['pl'] += $val->profit;


            if(!in_array($date, $dateArr))
                $dateArr[] = $date;
            
            if(count($detail) > 11)
                break;
        }

        $data = Calculate::getGeneralSummaryData($uid);

        $i = 0;
        if(count($detail) > 0)
        {
            reset($detail);
            while(list($k, $v) = each($detail))
            {
                $detail[$k]['totalswap'] += Calculate::appendCloseSwap($k, $data['summary']['closedswap']);
                $detail[$k]['pl'] += Calculate::appendCloseProfit($k, $data['summary']['closedprofit']);
            }

            reset($detail);
            while(list($k, $v) = each($detail))
            {
                $params['detail'][$k] = $v;

                $params['detail'][$k]['newswap'] = $v['totalswap'] - $detail[$dateArr[$i+1]]['totalswap'];
                $params['detail'][$k]['totalpl'] = $v['totalswap'] + $v['pl'] + $data['summary']['commission'];

                if($i == 0)
                    $params['summary']['yield'] = $params['detail'][$k]['totalpl'];

                if($i >= 9)
                    break;
                else
                    $i++;
            }
        }

        $params['summary']['capital'] = $data['summary']['capital'];

        $params['summary']['yield'] += Calculate::getCapitalCommission(Yii::app()->user->id) + $data['summary']['closed'];
        if($data['summary']['capital'] > 0)
            $params['summary']['yieldrate'] = $params['summary']['yield'] / $data['summary']['capital'] * 100;

        return $params;
    }

    public static function getSafeMarginLog()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'logtime, profitloss, commission, balance';
        $criteria->condition='accountnum=:accountnum and balance>0';
        $criteria->order = 'logtime';
        $criteria->params = array(':accountnum' => 7956);
        $result = TaSwapSafeMarginNote::model()->findAll($criteria);

        foreach($result as $val)
            $data[] = array(
                'logtime' => $val->logtime, 
                'profitloss' => $val->profitloss, 
                'commission' => $val->commission, 
                'balance' => $val->balance
            );

        return $data;
    }
}