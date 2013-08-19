<?php

class AdminController extends Controller
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
            array('allow',
                'actions'=>array('index', 'general', 'swap', 'user', 'report', 'funds'),
                'users'=>array('leon@nerrsoft.com'),
            ),
            array('deny',
                'actions'=>array('index', 'general', 'report', 'funds', 'swap'),
                'users'=>array('?','@'),
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
        $this->redirect('admin/general');
    }


    public function actionGeneral()
    {
        $params = Calculate::getGeneralSummaryData();

        //-- params data format
        $params['summary']['yieldrate'] = number_format($params['summary']['yieldrate'], 2);
        foreach($params['summary'] as $key=>$val)
        {
            if($key!='lastuptodate' && $key != 'closedswap' && $key != 'closedprofit' && $key != 'yieldrate')
                $params['summary'][$key] = number_format($val, 1);
        }
        foreach($params['charts'] as $key=>$val)
        {
            $params['charts'][$key] = json_encode($val);
        }

        foreach($params['swapratechart'] as $key=>$val)
        {
            $params['swapratechart'][$key] = json_encode($val);
        }

        $reportdata = Calculate::getUserReport();

        $params['summary']['newswap'] = $reportdata['detail'][date('Y-m-d', strtotime($params['summary']['lastuptodate']))]['newswap'];
        $params['summary']['newswap'] = number_format($params['summary']['newswap'], 2);

        $params['menu'] = Menu::make(Yii::app()->user->gid, 'General');

        $this->render('general', $params);
    }

    public function actionUser()
    {
        //--  get menu data
        $params['menu'] = Menu::make(Yii::app()->user->gid, 'User');
        //-- get user list
        $criteria = new CDbCriteria;
        $criteria->order = 'id';
        $userlist = ViewSysUserList::model()->findAll($criteria);
        //-- get login log
        $criteria = new CDbCriteria;
        $criteria->order = 'logintime';
        $loginlog = SysLoginLog::model()->findAll($criteria);

        $params['loginlog'] = $loginlog;
        $params['userlist'] = $userlist;
        $params['userinfourl'] = $this->createUrl('admin/userinfo');

        $this->render('user', $params);
    }

    public function actionUserinfo()
    {
        //--  get menu data
        $params['menu'] = Menu::make(Yii::app()->user->gid, 'User');
        echo $_GET['uid'];
        /*//-- get user list
        $criteria = new CDbCriteria;
        $criteria->order = 'id';
        $userlist = ViewSysUserList::model()->findAll($criteria);
        //-- get login log
        $criteria = new CDbCriteria;
        $criteria->order = 'logintime';
        $loginlog = SysLoginLog::model()->findAll($criteria);

        $params['loginlog'] = $loginlog;
        $params['userlist'] = $userlist;

        $this->render('user', $params);*/
    }

    public function actionSwap()
    {   
        //-- get swap rate avg (two main symbols)
        $params['swapavg'] = Calculate::getSwapAvg();
        //Debug::dump($data);

        //-- get swap rate chart data
        $data = Calculate::getGeneralSummaryData();
        foreach($data['swapratechart'] as $key=>$val)
            $params['swapratechart'][$key] = json_encode($val);

        $params['menu'] = Menu::make(Yii::app()->user->gid, 'Swap');
        $this->render('swap', $params);
    }

    public function actionTest()
    {
        $s = Calculate::getGeneralSummaryData();
        $r = Calculate::getUserReport();

        echo $r['detail'][date('Y-m-d', strtotime($s['summary']['lastuptodate']))]['newswap'];
        Debug::dump($r);
    }


    public function actionFunds()
    {
        $criteria = new CDbCriteria;
        $result = ViewSysAllUsersFundFlow::model()->findAll($criteria);

        if(!$result)
            return false;

        foreach($result as $val)
        {
            $table[$val->email]['row'][] = array(
                'time' => $val->flowtime,
                'direction' => $val->directioinname,
                'amount' => $val->amount,
                'memo' => $val->memo
            );
            $table[$val->email]['total'] += $val->amount;
        }

        $params['data'] = $table;
        $params['menu'] = Menu::make(Yii::app()->user->gid, 'Funds');
        $this->render('funds', $params);
    }

}