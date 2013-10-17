<?php

class CachedashCommand extends CConsoleCommand
{
    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'id';
        $criteria->condition='id in (5)';
        $result = SysUser::model()->findAll($criteria);

        foreach($result as $val)
        {
            $cacheId = $trace[0]["class"].'_'.$trace[0]["function"].'_'.Yii::app()->user->id;
        	$params = Yii::app()->cache->get($cacheId);
        }
    }
}