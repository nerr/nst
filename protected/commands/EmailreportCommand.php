<?php

class EmailreportCommand extends CConsoleCommand
{
    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'id,emaillist';
        $criteria->condition='usergroupid=2 and id<>2';
        $uid = SysUser::model()->findAll($criteria);

        if($uid)
        {
            $title = 'NST Weekly Report '.date('Y-m-d');
            $body = '这是系统自动发送的邮件，请勿回复。';

            foreach($uid as $u)
            {
                $attachment = Yii::app()->params->xlsxPath.'NST.Weekly.'.date('Y-m-d').'.'.$u->id.'.xlsx';

                if(!file_exists($attachment))
                    Excel::weekly($u->id, 'W');

                if(!file_exists($attachment))
                {
                    echo 'no attachment file '."\r\n";
                    continue; //-- if not exist behend create it that maybe some problem there.
                }

                $to = Tools::tPregEmailAddress($u->emaillist);
                $cc = array('leon@nerrsoft.com');

                $res = Notification::nSendMail($title, $body, $to, $cc, $attachment);

                if(!$res)
                    Notification::nSmsfetion(Yii::app()->params->fetionAccount, 'Send email report fail. User id is ['.$u->id.'].');
            }
        }
    }
}