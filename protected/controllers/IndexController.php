<?php

class IndexController extends Controller
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
		$this->redirect('index.php?r=default/general');
	}

	/**
	 * This is the user general action
	 */
	public function actionGeneral()
	{
		$userid = 1;


		$params['summary'] = array(
			'balance' => '111',
			'equity' => '100',
			'swap' => '20',
			'profit' => '-1'
			);
		//$params['imgpath'] = Yii::app()->request->baseUrl."/themes/kanrisha/img/";
		$this->render('general', $params);
	}
}