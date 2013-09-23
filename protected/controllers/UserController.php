<?php

class UserController extends Controller
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
                'actions'=>array('index', 'general', 'report', 'funds'),
                'users'=>array('?'),
            ),
            array('allow',
                'actions'=>array('index', 'general', 'report', 'funds'),
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

    public function actionLoadinfo()
    {
        $user = SysUser::model()->findByAttributes(array('id'=>Yii::app()->user->id));
        $res['mobile'] = $user->mobile;
        $res['emaillist'] = $user->emaillist;

        echo json_encode($res);
    }

    public function actionUpdate()
    {
        $res['updatestatus'] = false;

        $user = SysUser::model()->findByPk(Yii::app()->user->id);

        $user->mobile = $_POST['mobile'];
        $user->emaillist = $_POST['emaillist'];

        if($_POST['newpass'] != '' && $user->password == trim($_POST['oldpass']))
            $user->password = trim($_POST['newpass']);

        $user->save();

        $res['updatestatus'] = true;

        echo json_encode($res);
    }

    public function actionProfile()
    {
        //-- get menu
        $params['menu'] = Menu::aceMake(Yii::app()->user->gid, 'User Profile');
        //-- get date
        $user = SysUser::model()->findByAttributes(array('id'=>Yii::app()->user->id));

        $params['user'] = $user;
        $this->render('profile', $params);
    }
}