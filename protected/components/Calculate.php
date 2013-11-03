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

    public static function getGeneralSummaryData($uid = 0)
    {
        //-- init data
        $data = array();

        //-- get data if no cache 
        $criteria = new CDbCriteria;
        $criteria->select = 'orderticket,profit,swap,logdatetime,orderstatus,closedate,getswap,endprofit,commission';
        if($uid > 0)
        {
            $criteria->condition = 'userid=:userid';
            $criteria->params = array(':userid' => $uid);
        }
        else
            $criteria->condition = 'userid<>2';

        $criteria->order  = 'logdatetime';
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
                $serial['spread'][$d] += $v->profit;
                $serial['commission'][$d] += $v->commission;
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
            if($uid > 0)
            {
                $criteria->condition = 'userid=:userid';
                $criteria->params = array(':userid' => $uid);
            }
            else
                $criteria->condition = 'userid<>2';
            $criteria->order  = 'flowtime DESC';
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
            }

            //--
            foreach($serial['cost'] as $k=>$v)
                $serial['netearning'][$k] = $serial['cost'][$k] + $serial['swap'][$k];

            //--
            $lastdate = date('Y-m-d', strtotime($values['lastuptodate']));
            $values['swap'] = $serial['swap'][$lastdate];
            $values['cost'] = $serial['cost'][$lastdate];
            $values['netearning'] = $values['cost'] + $values['swap'];
            $values['balance'] = $values['netearning'] + $values['capital'];
            $values['spread'] = $serial['spread'][$lastdate];
            $values['commission'] = $serial['commission'][$lastdate] + array_sum($closed['commission']);
            
            //--
            $data['summary'] = $values;
            //-- get swap rate chart data
            $data['swapratechart'] = Calculate::getSwapRateChartData();

            $data['table'] = $serial;

            if($data['summary']['capital'] > 0)
                $data['summary']['yieldrate'] = $data['summary']['netearning'] / $data['summary']['capital'] * 100;

            foreach($serial as $c=>$val)
            {
                foreach($val as $k=>$v)
                    $data['charts'][$c][] = array($k, $v);
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

    public static function getUserReport($uid = 0)
    {
        $data = Calculate::getGeneralSummaryData($uid);

        if(count($data) > 0)
        {
            $params['summary']['capital'] = $data['summary']['capital'];
            $params['summary']['yield'] = $data['summary']['netearning'];
            if($data['summary']['capital'] != 0)
                $params['summary']['yieldrate'] = $params['summary']['yield'] / $data['summary']['capital'] * 100;


            $yestordayswap = 0;
            foreach($data['table']['swap'] as $d=>$v) //-- newswap totalswap pl
            {
                $params['detail'][$d]['totalswap'] = $v;
                $params['detail'][$d]['totalpl'] = $data['table']['netearning'][$d];

                if($yestordayswap == 0)
                    $params['detail'][$d]['newswap'] = 0;
                else
                    $params['detail'][$d]['newswap'] = $params['detail'][$d]['totalswap'] - $yestordayswap;

                $yestordayswap = $params['detail'][$d]['totalswap'];
            }
        }

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


    public static function getSwapAvg()
    {
        $avg = array();

        $criteria = new CDbCriteria;
        $criteria->select='symbol,longswap,shortswap';
        $criteria->condition = 'accountid=2';
        $result = TaSwapRate::model()->findAll($criteria);

        if($result)
        {
            foreach($result as $val)
            {
                $swap[$val->symbol]['long'][] = $val->longswap;
                $swap[$val->symbol]['short'][] = $val->shortswap;
            }

            foreach($swap as $key=>$val)
            {
                if(sizeof($val['long']) > 0)
                    $avg[$key]['long'] = array_sum($val['long']) / sizeof($val['long']);
                if(sizeof($val['short']) > 0)
                    $avg[$key]['short'] = array_sum($val['short']) / sizeof($val['short']);
            }
        }

        return $avg;
    }

    public static function getAllCommission($uid = 0)
    {
        $criteria = new CDbCriteria;
        $criteria->select='commission';
        if($uid > 0 )
            $criteria->condition = 'userid='.$uid;
        else
            $criteria->condition = 'userid<>2';
        $result = TaSwapOrder::model()->findAll($criteria);

        if(!$result)
            return 0;
        foreach($result as $val)
        {
            $commission += $val->commission;
        }

        return $commission;
    }

    public static function getOneWeekSwap($week_num, $year, $uid = 0)
    {
        //-- check effective week number
        if($week_num <= 0 and $week_num >= 53)
            return false;
        //--
        $week_start = new DateTime();
        $week_start->setISODate($year,$week_num);

        $weeks[1]['date'] = $week_start->format('Y-m-d');
        for($i = 2; $i <= 5; $i++)
            $weeks[$i]['date'] = date('Y-m-d', strtotime($weeks[$i-1]['date'].'+1 days'));

        foreach($weeks as $k=>$w)
        {
            if(date('N', strtotime($w['date'])) == 1)
                $tomorrow = date('Y-m-d', strtotime($w['date'].'-3 days'));
            else
                $tomorrow = date('Y-m-d', strtotime($w['date'].'-1 days'));

            $weeks[$k]['swap_lastday'] = Calculate::getOneDaySwap($tomorrow, $uid);
            $weeks[$k]['swap_today'] = Calculate::getOneDaySwap($w['date'], $uid);
            if($weeks[$k]['swap_today'] > 0)
                $weeks[$k]['swap_new'] = $weeks[$k]['swap_today'] - $weeks[$k]['swap_lastday'];
            else
                $weeks[$k]['swap_new'] = 0;
            $weeks['total'] += $weeks[$k]['swap_new'];
        }

        return $weeks;
    }

    public static function getOneDaySwap($date, $uid = 0)
    {
        $tomorrow = date('Y-m-d', strtotime($date.'+1 days'));
        $criteria = new CDbCriteria;
        $criteria->select='swap';
        if($uid > 0 )
            $criteria->condition = 'userid='.$uid;
        else
            $criteria->condition = 'userid<>2';
        $criteria->condition .= " and logdatetime > '$date' and logdatetime < '$tomorrow'";
        $result = ViewTaSwapOrderDetail::model()->findAll($criteria);
        if($result)
        {
            $dayswap = 0;
            foreach($result as $val)
            {
                $dayswap += $val->swap;
            }
        }
        return $dayswap;
    }

    public static function getMovingAverage($sourceArr, $period)
    {
        $c = count($sourceArr);
        if($c<=0)
            return false;

        $begin = $period - 1;
        for($i = $begin; $i < $c; $i++)
        {
            $total = 0;
            for($ii = 0; $ii < $begin; $ii++)
                $total += $sourceArr[$i-$ii][1];

            $avg[] = array($sourceArr[$i][0], $total / $period);
        }

        return $avg;
    }

    public static function getAllSpreadlose($uid = 0)
    {

    }

    public static function findProfitableRings($data)
    {
        if(count($data) <= 0)
            return false;

        foreach($data as $symbola=>$detaila)
        {
            $a1 = substr($symbola, 0, 3);
            $a2 = substr($symbola, 3, 3);
            $ext = substr($symbola, 6);

            foreach($data as $symbolb=>$detailb)
            {
                if($symbola == $symbolb) break;

                $b1 = substr($symbolb, 0, 3);
                $b2 = substr($symbolb, 3, 3);

                if(count($data[$b2.$a2.$ext]) > 1 && $a1 == $b1)
                {
                    unset($ring);
                    $ring = array(
                        'symbols' => array(
                            'A' => $symbola,
                            'B' => $symbolb,
                            'C' => $b2.$a2.$ext
                        )
                    );

                    if(isset($data[$symbola][0]['swap']) && isset($data[$symbolb][1]['swap']) && isset($data[$b2.$a2.$ext][1]['swap']))
                        $ring['long'] = $data[$symbola][0]['swap'] + $data[$symbolb][1]['swap'] + $data[$b2.$a2.$ext][1]['swap'] * $data[$symbolb][1]['openprice'];

                    if(isset($data[$symbola][1]['swap']) && isset($data[$symbolb][0]['swap']) && isset($data[$b2.$a2.$ext][0]['swap']))
                        $ring['short'] = $data[$symbola][1]['swap'] + $data[$symbolb][0]['swap'] + $data[$b2.$a2.$ext][0]['swap'] * $data[$symbolb][0]['openprice'];

                    //-- 
                    $ring['maincurrency'] = $a1;

                    //--
                    $ring['cost'] = 3;
                    if(isset($data[$a1.'USD'.$ext][0]['openprice']))
                        $ring['cost'] *= $data[$a1.'USD'.$ext][0]['openprice'];
                    elseif(isset($data[$a1.'USD'.$ext][1]['openprice']))
                        $ring['cost'] *= $data[$a1.'USD'.$ext][1]['openprice'];
                    elseif(isset($data['USD'.$a1.$ext][0]['openprice']))
                        $ring['cost'] /= $data['USD'.$a1.$ext][0]['openprice'];
                    elseif(isset($data['USD'.$a1.$ext][1]['openprice']))
                        $ring['cost'] /= $data['USD'.$a1.$ext][1]['openprice'];

                    $ring['cost'] *= 100000;

                    //--
                    if($ring['long'] > 0)
                    {
                        $ring['oneswapuse'] = $ring['cost'] / $ring['long'];
                        $ring['profitrate'] = 360 / ( $ring['oneswapuse'] / $data[$symbola][0]['leverage'] ) * 100;
                    }
                    elseif($ring['short'] > 0)
                    {
                        $ring['oneswapuse'] = $ring['cost'] / $ring['short'];
                        $ring['profitrate'] = 360 / ( $ring['oneswapuse'] / $data[$symbola][0]['leverage'] ) * 100;
                    }

                    //-- 




                    if($ring['long'] > 0 || $ring['short'] > 0)
                        $rings[] = $ring;
                }
            }
        }
        return $rings;
    }
}