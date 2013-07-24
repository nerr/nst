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
		//-- get menu
		$params['menu'] = Menu::make(Yii::app()->user->gid, 'Report');

		//-- 
		$criteria = new CDbCriteria;
		$criteria->select = 'profit,swap,logdatetime';
		$criteria->condition='userid=:userid';
		$criteria->order = 'logdatetime desc';
		$criteria->params = array(':userid' => Yii::app()->user->id);
		$result = ViewTaSwapOrderDetail::model()->findAll($criteria);

		$dateArr = array();
		foreach($result as $val)
		{
			$date = date('Y-m-d', strtotime($val->logdatetime));

			$detail[$date]['totalswap'] += $val->swap;
			$detail[$date]['pl'] += $val->profit;


			if(!in_array($date, $dateArr))
				$dateArr[] = $date;
			
			if(count($detail) > 11)
				break;
		}

		$data = Calculate::getGeneralSummaryData(Yii::app()->user->id);

		$i = 0;
		if(count($detail) > 0)
		{
			reset($detail);
			while(list($k, $v) = each($detail))
			{
				$detail[$k]['totalswap'] += Calculate::appendCloseSwap($k, $data['summary']['closedswap']);
				$detail[$k]['pl'] += Calculate::appendCloseProfit($k, $data['summary']['closedprofit']);
			}

			reset($detail);
			while(list($k, $v) = each($detail))
			{
				$params['detail'][$k] = $v;

				$params['detail'][$k]['newswap'] = $v['totalswap'] - $detail[$dateArr[$i+1]]['totalswap'];
				$params['detail'][$k]['totalpl'] = $v['totalswap'] + $v['pl'] + $data['summary']['commission'];

				if($i == 0)
					$params['summary']['yield'] = $params['detail'][$k]['totalpl'];

				if($i >= 9)
					break;
				else
					$i++;
			}
		}


		//-- adjust detail data format
		if(count($params['detail']) > 0)
		{
			foreach($params['detail'] as $k=>$v)
			{
				foreach($v as $key => $val)
					$params['detail'][$k][$key] = number_format($val, 2);
			}
		}

		$params['summary']['capital'] = $data['summary']['capital'];

		$params['summary']['yield'] += Calculate::getCapitalCommission(Yii::app()->user->id) + $data['summary']['closed'];
		if($data['summary']['capital'] > 0)
			$params['summary']['yieldrate'] = $params['summary']['yield'] / $data['summary']['capital'] * 100;

		foreach($params['summary'] as $k=>$v)
		{
			$params['summary'][$k] = number_format($v, 2);
		}
		$params['url']['funds'] = $this->createUrl('index/funds');

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
		Excel::weekly(Yii::app()->user->id);
	}

	
}