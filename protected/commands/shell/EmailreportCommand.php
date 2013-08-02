<?php

class EmailreportCommand extends CConsoleCommand
{
    public function weekly()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'id,emaillist';
        $criteria->condition='usergroupid=2 and id<>2';
        $uid = SysUser::model()->findAll($criteria);

        if($uid)
        {
            $title = 'NST Weekly Report';
            $sender = 'info@nerrsoft.com';

            foreach($uid as $u)
            {
                $attachment = Yii::app()->params->xlsxPath.'NST.Weekly.'.date('Y-m-d').'-'.$uid;

                if(!file_exists($attachment)
                    Excel::weekly($u->id, 'W');

                if(!file_exists($attachment) continue; //-- if not exist behend create it that maybe some problem there.

                $emailArr = $this->pregEmailAddress($u->emaillist);

                $this->sendEmail($title, $emailArr, $attachment, $sender);
            }
        }
    }

    protected function sendEmail($title, $emailArr, $sender)
    {
        
    }

    protected function pregEmailAddress($str)
    {

    }
}