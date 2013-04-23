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
			array('deny',
				'actions'=>array('index', 'general', 'report', 'funds','swap'),
				'users'=>array('?'),
			),
			array('allow',
				'actions'=>array('index', 'general', 'swap', 'user'),
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
		$this->redirect('admin/general');
	}


	public function actionGeneral()
	{
		var_dump(Yii::app()->user->gid);

		$uid = Yii::app()->user->id;
		$gid = Yii::app()->user->gid;

		$params['menu'] = Menu::make($gid, 'General');
		$this->render('general', $params);
	}

	public function actionUser()
	{
		//var_dump(Yii::app()->user->gid);

		$uid = Yii::app()->user->id;
		$gid = Yii::app()->user->gid;

		$params['menu'] = Menu::make($gid, 'User');
		$this->render('User', $params);
	}

	public function actionSwap()
	{	
		$uid = Yii::app()->user->id;
		$gid = Yii::app()->user->gid;

		$params['menu'] = Menu::make($gid, 'Swap');
		$this->render('swap', $params);


		
	}
}