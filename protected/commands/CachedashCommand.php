<?php

class MakecacheCommand extends CConsoleCommand
{
    public function run($args)
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'id,usergroupid';
        $criteria->condition='id<>2';
        $result = SysUser::model()->findAll($criteria);

        foreach($result as $val)
        {
            $cacheId = '';

            //-- make cache id name
            if($val->usergroupid==1)
                $cacheId = 'AdminController_actionDashboard_'.$val->id;
            else
                $cacheId = 'IndexController_actionDashboard_'.$val->id;

            //-- remove old cache data
            Yii::app()->cache->delete($cacheId);

            //-- get summary data 
            if($val->usergroupid==1)
            {
                $params = Calculate::getGeneralSummaryData();
                $params['commission'] = Calculate::getAllCommission();
                $params['weeks'] = Calculate::getOneWeekSwap(date('W'), date('Y'));
            }
            else
            {
                $params = Calculate::getGeneralSummaryData($val->id);
                $params['commission'] = Calculate::getAllCommission($val->id);
                $params['weeks'] = Calculate::getOneWeekSwap(date('W'), date('Y'), $val->id);
            }

            //-- params data format
            $params['summary']['yieldrate'] = number_format($params['summary']['yieldrate'], 2);
            foreach($params['charts'] as $key=>$val)
                $params['charts'][$key] = json_encode($val);

            foreach($params['swapratechart'] as $key=>$val)
                $params['swapratechart'][$key] = json_encode($val);

            $params['commission'] = Calculate::getAllCommission();

            $params['weeks'] = Calculate::getOneWeekSwap(date('W'), date('Y'));
            foreach($params['weeks'] as $k=>$v)
            {
                if($k>0 && $k<5)
                    $params['weeks']['chartstr'] .= floor($v['swap_new']).',';
                elseif($k == 5)
                    $params['weeks']['chartstr'] .= floor($v['swap_new']);
            }
            $params['weeks']['returnrate'] = $params['weeks']['total'] / $params['summary']['capital'] * 100;

            $params['summary']['newswap'] = $params['weeks'][date('N', strtotime($params['summary']['lastuptodate']))]['swap_new'];

            $params['menu'] = Menu::aceMake($val->usergroupid, 'Dashboard'); //Yii::app()->controller->action->id

            Yii::app()->cache->set($cacheId, $params, Yii::app()->params->cachePeriodTime);
        }
    }
}