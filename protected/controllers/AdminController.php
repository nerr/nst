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
                'actions'=>array('index', 'general', 'swap', 'user'),
                'users'=>array('leon@nerrsoft.com'),
            ),
            array('deny',
                'actions'=>array('index', 'general', 'report', 'funds','swap'),
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

        $this->render('user', $params);
    }

    public function actionSwap()
    {   
        $params['menu'] = Menu::make(Yii::app()->user->gid, 'Swap');
        $this->render('swap', $params);
    }
}