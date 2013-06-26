<?php

class SmsreportCommand extends CConsoleCommand
{
    public function run($args)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'id,mobile';
        $criteria->condition='id in (1)';
        $result = SysUser::model()->findAll($criteria);

        foreach($result as $val)
        {
            $data = Calculate::getGeneralSummaryData($val->id);

            $msg = '截止'.$data['summary']['lastuptodate']."\r";
            $msg .= '账户余额: '.number_format($data['summary']['balance'], 2)."\r";
            $msg .= '交易成本: '.number_format($data['summary']['cost'], 2)."\r";
            $msg .= '累计获得掉期: '.number_format($data['summary']['swap'], 2)."\r";
            $msg .= '浮动收益: '.number_format($data['summary']['netearning'], 2);
            $msg .= '[NST]';

            $this->sendSms($val->mobile, $msg);
        }
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
}