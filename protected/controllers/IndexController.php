<?php

class IndexController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions'=>array('index', 'dashboard', 'report', 'funds', 'excel'),
                'users'=>array('?'),
            ),
            array('allow',
                'actions'=>array('index', 'dashboard', 'report', 'funds', 'excel'),
                'users'=>array('@'),
            ),
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->redirect('index/dashboard');
    }

    /**
     * This is the user general action
     */
    public function actionDashboard()
    {
        $trace = debug_backtrace();
        $cacheId = $trace[0]["class"].'_'.$trace[0]["function"].'_'.Yii::app()->user->id;
        $params = Yii::app()->cache->get($cacheId);
        //-- check cache            
        if($params===false)
        {
            $params = Calculate::getGeneralSummaryData(Yii::app()->user->id);

            //-- params data format
            $params['summary']['yieldrate'] = number_format($params['summary']['yieldrate'], 2);
            foreach($params['charts'] as $key=>$val)
                $params['charts'][$key] = json_encode($val);

            foreach($params['swapratechart'] as $key=>$val)
                $params['swapratechart'][$key] = json_encode($val);

            $params['commission'] = Calculate::getAllCommission(Yii::app()->user->id);

            $params['weeks'] = Calculate::getOneWeekSwap(date('W'), date('Y'), Yii::app()->user->id);
            foreach($params['weeks'] as $k=>$v)
            {
                if($k>0 && $k<5)
                    $params['weeks']['chartstr'] .= floor($v['swap_new']).',';
                elseif($k == 5)
                    $params['weeks']['chartstr'] .= floor($v['swap_new']);
            }
            $params['weeks']['returnrate'] = $params['weeks']['total'] / $params['summary']['capital'] * 100;

            $params['summary']['newswap'] = $params['weeks'][date('N', strtotime($params['summary']['lastuptodate']))]['swap_new'];

            $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Dashboard'); //Yii::app()->controller->action->id

            Yii::app()->cache->set($cacheId, $params, Yii::app()->params->cachePeriodTime);
        }

        $this->render('dashboard', $params);
    }

    public function actionReport()
    {
        $params = Calculate::getUserReport(Yii::app()->user->id);

        //-- get menu
        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Report');

        //-- adjust detail data format
        if(count($params['detail']) > 0)
        {
            foreach($params['detail'] as $k=>$v)
            {
                foreach($v as $key => $val)
                    $params['detail'][$k][$key] = number_format($val, 2);
            }
        }

        foreach($params['summary'] as $k=>$v)
        {
            $params['summary'][$k] = number_format($v, 2);
        }

        $params['url']['funds'] = $this->createUrl('index/funds');
        $params['url']['excel'] = $this->createUrl('index/excel');

        $this->render('report', $params);
    }

    public function actionFunds()
    {
        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Funds');
        $params['table'] = Calculate::getFundLog(Yii::app()->user->id);
        $this->render('funds', $params);
    }

    
    public function actionExcel()
    {
        Excel::weekly(Yii::app()->user->id, 'D');
    }
}