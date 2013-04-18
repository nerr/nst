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
		if(Yii::app()->user->gid==1)
			$this->redirect('index.php?r=admin/general');
		else
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

		$identity = new UserIdentity($authproof['email'], $authproof['password']);
		$authproof['loginstatus'] = $identity->authenticate();
		if($authproof['loginstatus']==100)
			Yii::app()->user->login($identity);

		$authproof['ipaddress'] = $this->getClientIp();
		$this->logLogin($authproof);

		echo $authproof['loginstatus'];
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}


	private function logLogin($attr)
	{
		$model = new SysLoginLog;
		$model->attributes = $attr;
		$model->save();
	}

	private function getClientIp()
	{
		if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']))
			return $_SERVER['HTTP_CLIENT_IP'];
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			return strtok($_SERVER['HTTP_X_FORWARDED_FOR'], ',');
		if (isset($_SERVER['HTTP_PROXY_USER']) && !empty($_SERVER['HTTP_PROXY_USER']))
			return $_SERVER['HTTP_PROXY_USER'];
		if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']))
			return $_SERVER['REMOTE_ADDR'];
		else
			return "0.0.0.0";
	}
}