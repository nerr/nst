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
        //--
        $criteria = new CDbCriteria;
        $criteria->select = 'orderticket,profit,swap,logdatetime,orderstatus,closedate,getswap,endprofit,commission';
        $criteria->condition = 'userid=:userid';
        $criteria->order  = 'logdatetime';
        $criteria->params = array(':userid' => $uid);
        $result = ViewTaSwapOrderDetail::model()->findAll($criteria);

        if($result)
        {
            //--  init var
            $closed = array('swap' => array(), 'profit' => array(), 'commission' => array(), 'wirefee' => array()); //-- middle value for calculate
            $serial = array(); //-- for chart data
            $values = array(); //-- summary data

            foreach($result as $v)
            {
                //-- get closed data
                $closedate = date('Y-m-d', strtotime($v->closedate));
                if($v->orderstatus == 1 && $closed['swap'][$closedate][$v->orderticket] == 0)
                {
                    $closed['swap'][$closedate][$v->orderticket] = $v->getswap;
                    $closed['profit'][$closedate][$v->orderticket] = $v->endprofit;
                    $closed['commission'][$closedate][$v->orderticket] = $v->commission;
                }

                //-- get searial data
                $d = date('Y-m-d', strtotime($v->logdatetime));
                $serial['swap'][$d] += $v->swap;
                $serial['cost'][$d] += $v->profit + $v->commission;
            }
            $values['lastuptodate'] = $v->logdatetime;


            //-- 
            foreach($closed['swap'] as $d=>$vv)
            {
                $closetm = strtotime($d);
                foreach($serial['swap'] as $k=>$v)
                {
                    if(strtotime($k) > $closetm)
                        $serial['swap'][$k] += array_sum($vv);
                }
            }

            
            //-- 
            foreach($closed['profit'] as $d=>$vv)
            {
                $closetm = strtotime($d);
                foreach($serial['cost'] as $k=>$v)
                {
                    if(strtotime($k) > $closetm)
                        $serial['cost'][$k] += array_sum($vv);
                }
            }

            //--
            $criteria = new CDbCriteria;
            $criteria->select = 'amount,directionid,flowtime';
            $criteria->condition = 'userid=:userid';
            $criteria->order  = 'flowtime DESC';
            $criteria->params = array(':userid' => $uid);
            $result = SysCapitalFlow::model()->findAll($criteria);

            foreach($result as $v)
            {
                $d = date('Y-m-d', strtotime($v->flowtime));
                if($v->directionid == 3)
                    $closed['wirefee'][$d] += $v->amount;
                else
                    $values['capital'] += $v->amount;
            }

            if(count($closed['wirefee']) > 0)
            {
                foreach($closed['wirefee'] as $d=>$vv)
                {
                    $closetm = strtotime($d);
                    foreach($serial['cost'] as $k=>$v)
                    {
                        if(strtotime($k) > $closetm)
                            $serial['cost'][$k] += $vv;
                    }
                }
                $values['cost'] = $serial['cost'][$k];
            }

            //--
            foreach($serial['cost'] as $k=>$v)
                $serial['netearning'][$k] = $serial['cost'][$k] + $serial['swap'][$k];

            //--
            $values['swap'] = $serial['swap'][date('Y-m-d', strtotime($values['lastuptodate']))];
            $values['netearning'] = $values['cost'] + $values['swap'];
            $values['balance'] = $values['netearning'] + $values['capital'];
            
            
            //-- init data
            $data = array();
            //--
            $data['summary'] = $values;
            //-- get swap rate chart data
            $data['swapratechart'] = Calculate::getSwapRateChartData();

            foreach($serial as $c=>$val)
            {
                foreach($val as $k=>$v)
                    $data['charts'][$c][] = array(strtotime($k), $v);
            }
        }

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
        if(is_array($closedswap))
        {
            foreach($closedswap as $d=>$v)
            {
                if($tm>=strtotime($d))
                    $append = $v;
            }
        }
        else
            $append = 0;

        return $append;
    }

    public static function appendCloseProfit($date, $closedproft)
    {
        $append = 0;
        $tm = strtotime($date);
        if(is_array($closedswap))
        {
            foreach($closedproft as $d=>$v)
            {
                if($tm>=strtotime($d))
                    $append = $v;
            }
        }
        else
            $append = 0;

        return $append;
    }

    public static function getUserReport($uid)
    {
        $data = Calculate::getGeneralSummaryData($uid);
        $params['summary']['capital'] = $data['summary']['capital'];
        $params['summary']['yield'] = $data['summary']['netearning'];
        if($data['summary']['capital'] != 0)
            $params['summary']['yieldrate'] = $params['summary']['yield'] / $data['summary']['capital'] * 100;

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

                if($i >= 9)
                    break;
                else
                    $i++;
            }
        }

        $params['summary']['capital'] = $data['summary']['capital'];

        $params['summary']['yield'] = $data['summary']['netearning'];
        if($data['summary']['capital'] != 0)
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


    //-- get closed ring profit (proft+getswap+commission)
    public static function settleClosed($uid)
    {
        $criteria = new CDbCriteria;
        $criteria->select    = 'getswap,endprofit,commission,closedate';
        $criteria->condition = 'userid=:userid and orderstatus=1';
        $criteria->order     = 'closedate';
        $criteria->params    = array(':userid' => $uid);
        $result = TaSwapOrder::model()->findAll($criteria);

        foreach($result as $val)
        {
            //-- summary closed data
            $data['closed'] += $val->getswap + $val->endprofit + $val->commission;

            //-- get history closed order swap data
            $date = date('Y-m-d', strtotime($val->closedate.'+1 day'));

            /*$data['closedswap'][$date] += $val->getswap;
            $data['closedprofit'][$date] += $val->endprofit + $val->commission;*/
            
            if($idate == '')
            {
                $data['closedswap'][$date] = $val->getswap;
                $data['closedprofit'][$date] = $val->endprofit + $val->commission;
            }
            elseif($idate != $date)
            {
                $data['closedswap'][$date] = $closedswap;
                $data['closedprofit'][$date] = $closedprofit;
            }
            else
            {
                $data['closedswap'][$date] += $val->getswap;
                $data['closedprofit'][$date] += $val->endprofit + $val->commission;
            }

            $closedswap += $val->getswap;
            $closedprofit += $val->endprofit + $val->commission;
            $idate = $date;
        }

        return $data;
    }

    //-- get commission
    public static function getCommission($uid)
    {
        $criteria = new CDbCriteria;
        $criteria->select    = 'commission';
        $criteria->condition = 'userid=:userid and orderstatus=0';
        $criteria->params    = array(':userid' => $uid);
        $result = TaSwapOrder::model()->findAll($criteria);

        $commission = 0;
        foreach($result as $val)
            $commission += $val->commission;
        
        return $commission;
    }
}