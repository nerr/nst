<?php

class SmsreportCommand extends CConsoleCommand
{
    public function run($args)
    {
        echo "It's just a test.";

        $arr = $this->getGeneralSummaryData(5);

        var_dump($arr);
    }



    //-- send sms
    protected function sendSms($mobile, $text)
    {
        $msg = urlencode($text);

        $url  = 'http://210.5.158.31/hy/?expid=0&encode=utf8';
        $url .= '&uid='.Yii::app()->params['smsAccount'];
        $url .= '&auth='.Yii::app()->params['smsPassword'];
        $url .= '&mobile='.$mobile;
        $url .= '&msg='.$msg;
        
        try{

            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
            $statuscode = curl_exec($ch);
            curl_close($ch);

            $code = explode(',', $statuscode);

            if($code[0]==0)
                //echo "Date:".date('Y-m-d H:i:s', time()).";Finished\n";
                return true;
            else
                //echo "Date:".date('Y-m-d H:i:s', time()).";Failed\n";
                return false;
        }
        catch( Exception $e)
        {
            //echo "Date:".date('Y-m-d H:i:s', time()).";ERROR:".$e."\n";
            return false;
        }
    }

    //-- sendsms fetion version 
    /*protected function sendSms_fetion($mobile, $msg)
    {
        $fetion = new PHPFetion(Yii::app()->params['fetionAccount'], Yii::app()->params['fetionPassword']);
        try
        {
            $result = $fetion->send($mobile, $msg);
            $count = 0;
            while(!$this->checkStatus($result) && $count < 3 )
            {
                $count++;
                sleep(2);
                //echo "Sleep 2s, Re Send\n";
                $result = $result = $fetion->send($mobile, $msg);
            }
            if ($count != (3 - 1))
            {
                //echo "Date:".date('Y-m-d H:i:s', time()).";Finished\n";
                return true;
            }
            else
            {
                //echo "Date:".date('Y-m-d H:i:s', time()).";Failed\n";
                return false;
            }
        }
        catch( Exception $e)
        {
            //echo "Date:".date('Y-m-d H:i:s', time()).";ERROR:".$e."\n";
            return false;
        }
    }

    protected function checkStatus($status_code)
    {
        preg_match('/^.*HTTP\/1\.1 200 OK.*$/si', $status_code, $status);
        if(isset($status[0]))
            return true;
        else
        {
            //echo "Result:$status_code\n";
            return false;
        }
    }*/

    private function getGeneralSummaryData($uid)
    {
        $data = array();

        //-- get closed ring profit (proft+getswap+commission)
        $criteria = new CDbCriteria;
        $criteria->select = 'getswap,endprofit,commission,closedate';
        $criteria->condition = 'userid=:userid and orderstatus=:orderstatus';
        $criteria->order = 'closedate';
        $criteria->params = array(':userid' => Yii::app()->user->id,
                                ':orderstatus' => 1);
        $result = TaSwapOrder::model()->findAll($criteria);
/*
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
        $data['summary']['capital'] = $this->getCapital();

        $data['summary']['balance'] = $data['summary']['capital'] + $data['summary']['closed'];


        //-- get commission
        $criteria = new CDbCriteria;
        $criteria->select='commission,opendate';
        $criteria->condition = 'userid=:userid and orderstatus=:orderstatus';
        $criteria->params = array(':userid' => Yii::app()->user->id, 
                                ':orderstatus' => 0);
        $result = TaSwapOrder::model()->findAll($criteria);

        foreach($result as $val)
        {
            $commission[$val->opendate] += $val->commission;
        }
        $data['summary']['commission'] = array_sum($commission);

        //-- get profit swap
        $criteria = new CDbCriteria;
        $criteria->select = 'logdatetime';
        $criteria->condition='userid=:userid and orderstatus=:orderstatus';
        $criteria->params = array(':userid' => Yii::app()->user->id,
                                ':orderstatus' => 0);
        $criteria->order  = 'logdatetime DESC';
        $criteria->limit  = 1;
        $lastdate = ViewTaSwapOrderDetail::model()->find($criteria);

        $data['summary']['lastuptodate'] = $lastdate->logdatetime;

        $criteria = new CDbCriteria;
        $criteria->select = 'profit,swap,logdatetime';
        $criteria->condition='userid=:userid';
        $criteria->params=array(':userid' => $uid);
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

        end($data['summary']['closedswap']);
        list(,$cs) = each($data['summary']['closedswap']);
        $data['summary']['swap'] += $cs;

        end($data['summary']['closedprofit']);
        list(,$cp) = each($data['summary']['closedprofit']);
        $data['summary']['cost'] += $cp;


        //-- adjust swap (add closed swap)


        if(count($charts['swap']) > 0)
        {
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
        $data['summary']['balance'] += $data['summary']['netearning'];*/


        return $data;
    }

    private function getCapital()
    {
        //-- get init balance
        $criteria = new CDbCriteria;
        $criteria->select='amount,directionid';
        $criteria->condition='userid=:userid';
        $criteria->params=array(':userid' => 5);
        $result = SysCapitalFlow::model()->findAll($criteria);

        foreach($result as $val)
        {
            if($val->directionid == 1)
                $capital += $val->amount;
            elseif($val->directionid == 2)
                $capital -= $val->amount;
        }

        return $capital;
    }
}