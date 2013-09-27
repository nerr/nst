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
                'actions'=>array('index', 'dashboard', 'swap', 'user', 'report', 'funds', 'investors'),
                'users'=>array('leon@nerrsoft.com','vickey@nerrsoft.com'),
            ),
            array('deny',
                'actions'=>array('index', 'dashboard', 'swap', 'user', 'report', 'funds', 'investors'),
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
        $this->redirect('admin/dashboard');
    }


    public function actionDashboard()
    {
        $params = Calculate::getGeneralSummaryData();

        //-- params data format
        $params['summary']['yieldrate'] = number_format($params['summary']['yieldrate'], 2);
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

        $params['commission'] = Calculate::getAllCommission();
        //$params['spreadlose'] = Calculate::getAllSpreadlose();

        //Debug::dump($params['summary']);
        $params['weeks'] = Calculate::getOneWeekSwap(date('W'), date('Y'));
        foreach($params['weeks'] as $k=>$v)
        {
            if($k>0 && $k<5)
                $params['weeks']['chartstr'] .= floor($v['swap_new']).',';
            elseif($k == 5)
                $params['weeks']['chartstr'] .= floor($v['swap_new']);
        }
        $params['weeks']['returnrate'] = $params['weeks']['total'] / $params['summary']['capital'] * 100;

        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Dashboard'); //Yii::app()->controller->action->id

        $this->render('dashboard', $params);
    }

    public function actionUsers()
    {
        //--  get menu data
        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Users');
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

    public function actionSwaprate()
    {   
        //-- get swap rate avg (two main symbols)
        $params['swapavg'] = Calculate::getSwapAvg();

        //-- get swap rate chart data
        $data = Calculate::getGeneralSummaryData();
        foreach($data['swapratechart'] as $key=>$val)
            $params['swapratechart'][$key] = json_encode($val);

        $movingaverage['EURMXNshort'] = Calculate::getMovingAverage($data['swapratechart']['EURMXNshort'], 7);
        $movingaverage['USDMXNshort'] = Calculate::getMovingAverage($data['swapratechart']['USDMXNshort'], 7);
        foreach($movingaverage as $key=>$val)
            $params['movingaverage'][$key] = json_encode($val);

        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Swap Rate');
        $this->render('swap', $params);
    }


    public function actionFunds()
    {
        $criteria = new CDbCriteria;
        $result = ViewSysAllUsersFundFlow::model()->findAll($criteria);

        if(!$result)
            return false;

        foreach($result as $val)
        {
            $table_detail[$val->email]['row'][] = array(
                'time' => $val->flowtime,
                'direction' => $val->directioinname,
                'amount' => $val->amount,
                'memo' => $val->memo
            );
            $table_detail[$val->email]['total'] += $val->amount;

            
            if($val->directioinname == 'Deposit')
                $table_summary['deposit'] += $val->amount;
            elseif($val->directioinname == 'Withdraw')
                $table_summary['withdraw'] += $val->amount;
            elseif($val->directioinname == 'Commission')
                $table_summary['commission'] += $val->amount;
        }

        foreach($table_detail as $key=>$val)
            $chart[] = array('label' => $key, 'data' => $val['total']);

        $params['detail'] = $table_detail;
        $params['summary'] = $table_summary;
        $params['chart'] = json_encode($chart);
        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Funds');

        $this->render('funds', $params);
    }

    public function actionGlobalpl()
    {
        $params = Calculate::getUserReport();

        //-- get menu
        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Global P/L Report');

        $params['url']['funds'] = $this->createUrl('admin/funds');
        $params['url']['excel'] = $this->createUrl('admin/reportexcel');

        $this->render('report', $params);
    }

    public function actionInvestors()
    {
        //-- get user list
        $criteria = new CDbCriteria;
        $criteria->select = 'id,email,username';
        $criteria->condition='usergroupid=2 and id<>2';
        $criteria->order = 'id';
        $userlist = ViewSysUserList::model()->findAll($criteria);

        if($userlist)
        {
            foreach($userlist as $user)
            {
                $data[$user->id]['user'] = array('email'=>$user->email, 'username'=>$user->username);
                $data[$user->id]['schema'] = Calculate::getGeneralSummaryData($user->id);
                $data[$user->id]['weeks'] = Calculate::getOneWeekSwap(date('W'), date('Y'), $user->id);

                foreach($data[$user->id]['weeks'] as $k=>$v)
                {
                    if($k>0 && $k<5)
                        $data[$user->id]['weeks']['chartstr'] .= floor($v['swap_new']).',';
                    elseif($k == 5)
                        $data[$user->id]['weeks']['chartstr'] .= floor($v['swap_new']);
                }

                if($data[$user->id]['schema']['summary']['capital'] > 0)
                {
                    $data[$user->id]['weeks']['returnrate'] = $data[$user->id]['weeks']['total'] / $data[$user->id]['schema']['summary']['capital'] * 100;
                    $data[$user->id]['schema']['summary']['costrate'] = $data[$user->id]['schema']['summary']['cost'] / $data[$user->id]['schema']['summary']['capital'] * -100;
                }
            }
        }

        $params['data'] = $data;
        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Investors'); //Yii::app()->controller->action->id

        $this->render('investors', $params);
    }

    public function actionTest()
    {
        $s = Calculate::getOneWeekSwap(date('W'), date('Y'));
        Debug::dump($s);
    }

}