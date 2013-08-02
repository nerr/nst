<?php

class Notification
{
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
}