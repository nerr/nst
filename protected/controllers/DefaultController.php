<?php

class DefaultController extends Controller
{
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
		$this->redirect('index.php?r=index/general');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		//var_dump(Yii::app()->user);

		if(!Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->homeUrl);

		$formSubmitUrl = $this->createUrl('default/auth');
		$sucessUrl = Yii::app()->user->returnUrl;

		// display the login page
		$this->renderPartial('login', array('formSubmitUrl'=>$formSubmitUrl, 
											'sucessUrl'=>$sucessUrl)
		);
	}

	/**
	 * Displays the login page
	 */
	public function actionAuth()
	{
		$authproof = $_POST['proof'];

		$criteria = new CDbCriteria;
		$criteria->select='id,usergroupid';
		$criteria->condition='email=:email AND password=:password';
		$criteria->params=array(':email'=>$authproof['email'], ':password'=>$authproof['password']);
		$result = SysUser::model()->find($criteria);
		//echo $authproof['password'];
		echo count($result);
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}