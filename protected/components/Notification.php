<?php

class Notification
{
    public static function nSendSms($mobile, $text)
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

    public static function nSmsfetion($mobile, $msg, $trytime = 2)
    {
        $fAccount = Yii::app()->params->fetionAccount;
        $fPassword = Yii::app()->params->fetionPassword;

        Yii::import('ext.phpfetion.PHPFetion'); 
        $fetion = new PHPFetion($fAccount, $fPassword);
        try
        {
            $result = $fetion->send($mobile, $msg);
            $count = 0;
            while(!Notification::nCheckFetionStatus($result) && $count < $trytime )
            {
                $count++;
                sleep(2);
                //echo "Sleep 2s, Re Send\n";
                $result = $fetion->send($mobile, $msg);
            }
            if($count != ($trytime - 1))
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

    public static function nCheckFetionStatus($status_code)
    {
        preg_match('/^.*HTTP\/1\.1 200 OK.*$/si', $status_code, $status);
        if(isset($status[0]))
            return true;
        else
        {
            //echo "Result:$status_code\n";
            return false;
        }
    }

    public static function nSendMail($title, $body, $to, $cc = array(), $attach = '')
    {
        if(count($to) == 0)
            return false;

        try {
            $mailer = Yii::app()->phpMailer->_mailer;
            $mailer->Subject = $title;
            $mailer->Body = $body;

            foreach($to as $v)
                $mailer->AddAddress($v);

            if(count($cc) > 0)
            {
                foreach($cc as $v)
                    $mailer->AddCC($v);
            }

            if(strlen($attach) > 0)
                $mailer->AddAttachment($attach);

            return $mailer->send();
        }
        catch (phpmailerException $e) 
        {
            Notification::nSmsfetion(Yii::app()->params->fetionAccount, $e, 1); //Pretty error messages from PHPMailer
        }
        catch (Exception $e)
        {
            Notification::nSmsfetion(Yii::app()->params->fetionAccount, $e, 1); //Boring error messages from anything else!
        }
    }
}