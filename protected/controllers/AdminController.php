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
        $trace = debug_backtrace();
        $cacheId = $trace[0]["class"].'_'.$trace[0]["function"].'_'.Yii::app()->user->id;
        $params = Yii::app()->cache->get($cacheId);
        //-- check cache            
        if($params===false)
        {
            $params = Calculate::getGeneralSummaryData();

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

            $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Dashboard'); //Yii::app()->controller->action->id

            Yii::app()->cache->set($cacheId, $params, Yii::app()->params->cachePeriodTime);
        }

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

        $this->render('user', $params);
    }

    public function actionUseredit()
    {
        //--  get menu data
        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Users');
        //-- get date
        $user = SysUser::model()->findByAttributes(array('id'=>$_GET['id']));

        $params['user'] = $user;
        $params['avatar'] = Tools::tGetGavatar($user->email);
        $this->render('useredit', $params);
    }

    public function actionUserupdate()
    {
        $res['updatestatus'] = false;

        $user = SysUser::model()->findByPk($_POST['userid']);

        $user->mobile = $_POST['mobile'];
        $user->emaillist = $_POST['emaillist'];

        if($_POST['newpass'] != '' && $user->password == trim($_POST['oldpass']))
            $user->password = trim($_POST['newpass']);

        $user->save();

        $res['updatestatus'] = true;

        echo json_encode($res);
    }

    public function actionSwaprate()
    {   
        //-- get swap rate avg (two main symbols)
        $params['swapavg'] = Calculate::getSwapAvg();

        //-- get swap rate chart data
        $data = Calculate::getGeneralSummaryData();
        foreach($data['swapratechart'] as $key=>$val)
            $params['swapratechart'][$key] = json_encode($val);

        $movingaverage['EURMXNshort'] = Calculate::getMovingAverage($data['swapratechart']['EURMXNshort'], 30);
        $movingaverage['USDMXNshort'] = Calculate::getMovingAverage($data['swapratechart']['USDMXNshort'], 30);
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
        $trace = debug_backtrace();
        $cacheId = $trace[0]["class"].'_'.$trace[0]["function"].'_'.Yii::app()->user->id;
        $params = Yii::app()->cache->get($cacheId);

        if($params===false)
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

            Yii::app()->cache->set($cacheId, $params, Yii::app()->params->cachePeriodTime);
        }

        $this->render('investors', $params);
    }

    public function actionSnowball()
    {
        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Snowball');
        
    }

    public function action7070detail()
    {
        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, '7070 Detail');
        
        $this->render('7070detail', $params);
    }

    public function actionTestswap()
    {
        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Test Swap');

        //-- get user list
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->order = 'broker,accountnum,orderticket';
        $result = TestOrderinfo::model()->findAll($criteria);

        //
        if($result)
        {
            foreach($result as $val)
            {
                $info[$val->broker][$val->accountnum][$val->symbol][$val->ordertype] = array(
                    'lots' => $val->lots,
                    'swap' => $val->swap,
                    'openprice' => $val->openprice,
                    'profit' => $val->profit,
                    'longswap' => $val->longswap, 
                    'shortswap' => $val->shortswap,
                    'leverage' => $val->leverage           
                );
            }
        }

        foreach($info as $broker=>$accounts)
        {
            foreach($accounts as $account=>$val)
            {
                $params['data'][$broker][$account] = Calculate::findProfitableRings($val);
            }
        }

        //Debug::dump($params['data']);
        
        $this->render('testswap', $params);
    }

    public function actionLogProfitableRings()
    {
        //-- get user list
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->order = 'broker,accountnum,orderticket';
        $result = TestOrderinfo::model()->findAll($criteria);

        //
        if($result)
        {
            foreach($result as $val)
            {
                $info[$val->broker][$val->accountnum][$val->symbol][$val->ordertype] = array(
                    'lots' => $val->lots,
                    'swap' => $val->swap,
                    'openprice' => $val->openprice,
                    'profit' => $val->profit,
                    'longswap' => $val->longswap, 
                    'shortswap' => $val->shortswap,
                    'leverage' => $val->leverage           
                );
            }
        }

        foreach($info as $broker=>$accounts)
        {
            foreach($accounts as $account=>$val)
            {
                $params['data'][$broker][$account] = Calculate::findProfitableRings($val);
            }
        }

        $data = $params['data'];
        //--
        
        foreach($data as $broker=>$accounts){
            foreach($accounts as $account=>$val){
                if(is_array($val)){
                    foreach($val as $v){
                        unset($attr);
                        $attr = array(
                            'broker' => $broker,
                            'accountnum' => $account,
                            'symbol_a' => $v['symbols']['A'],
                            'symbol_b' => $v['symbols']['B'],
                            'symbol_c' => $v['symbols']['C'],
                            'longswaptotal' => $v['long'],
                            'shortswaptotal' => $v['short'],
                            'expected' => $v['profitrate']
                        );
                        $model = new TestProfitableRings;
                        $model->attributes = $attr;
                        $model->save();

                        //Debug::dump($attr);
                    }
                }
            }
        }




        

    }

    public function actionTest()
    {
        $trace = debug_backtrace();
        $cacheId = $trace[0]["class"].'_'.$trace[0]["function"].'_'.Yii::app()->user->id;
        $params = Yii::app()->cache->get($cacheId);
        //-- check cache            
        if($params===false)
        {
            $params = Calculate::getGeneralSummaryData(0);

            Debug::dump($params);

            /*//-- params data format
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

            $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'Dashboard'); //Yii::app()->controller->action->id

            Yii::app()->cache->set($cacheId, $params, Yii::app()->params->cachePeriodTime);*/
        }

        //$this->render('dashboard', $params);
    }

}