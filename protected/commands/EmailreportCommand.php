<?php

class EmailreportCommand extends CConsoleCommand
{
    public function weekly()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'id,emaillist';
        //$criteria->condition='usergroupid=2 and id<>2';
        $criteria->condition='id=9';
        $uid = SysUser::model()->findAll($criteria);

        if($uid)
        {
            $title = 'NST Weekly Report';
            $body = '';

            foreach($uid as $u)
            {
                $attachment = Yii::app()->params->xlsxPath.'NST.Weekly.'.date('Y-m-d').'-'.$uid;

                if(!file_exists($attachment)
                    Excel::weekly($u->id, 'W');

                if(!file_exists($attachment) continue; //-- if not exist behend create it that maybe some problem there.

                //$to = $this->pregEmailAddress($u->emaillist);
                $to = array('vickey@nerrsoft.com');

                Notification::nSendMail($title, $body, $to, array('leon@nerrsoft.com'), $attachment);
            }
        }
    }

    protected function pregEmailAddress($str)
    {

    }
}