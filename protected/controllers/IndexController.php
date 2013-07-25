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
				'actions'=>array('index', 'general', 'report', 'funds', 'excel'),
				'users'=>array('?'),
			),
			array('allow',
				'actions'=>array('index', 'general', 'report', 'funds', 'excel'),
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
		$this->redirect('index/general');
	}

	/**
	 * This is the user general action
	 */
	public function actionGeneral()
	{
		$params = Calculate::getGeneralSummaryData(Yii::app()->user->id);

		//-- params data format
		foreach($params['summary'] as $key=>$val)
		{
			if($key!='lastuptodate' && $key !='closedswap' && $key !='closedprofit')
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

		$params['menu'] = Menu::make(Yii::app()->user->gid, 'General');

		$this->render('general', $params);
	}

	public function actionReport()
	{
		$params = Calculate::getUserReport(Yii::app()->user->id);

		//-- get menu
		$params['menu'] = Menu::make(Yii::app()->user->gid, 'Report');

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
		$params['menu'] = Menu::make(Yii::app()->user->gid, 'Funds');
		$params['table'] = Calculate::getFundLog(Yii::app()->user->id);
		$this->render('funds', $params);
	}

	
	public function actionExcel()
	{
		Excel::weekly(Yii::app()->user->id, 'D');
	}

	
}