<?php

class SmsreportCommand extends CConsoleCommand
{
    public function run($args)
    {
        echo "It's just a test.";
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