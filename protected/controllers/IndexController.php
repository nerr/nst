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
		$this->redirect('index.php?r=index/general');
	}

	/**
	 * This is the user general action
	 */
	public function actionGeneral()
	{
		$userid = 1;

		$params = $this->getSummaryData($userid);

		$this->render('general', $params);
	}

	private function getSummaryData($uid)
	{
		$data = array();

		//-- get balance
		$criteria = new CDbCriteria;
		$criteria->select='amount,direction';
		$criteria->condition='userid=:userid';
		$criteria->params=array(':userid' => $uid);
		$result = SysCapitalFlow::model()->findAll($criteria);

		foreach($result as $val)
		{
			if($val->direction == 0)
				$data['summary']['balance'] += $val->amount;
			elseif($val->direction == 1)
				$data['summary']['balance'] -= $val->amount;
		}

		//-- get commission
		$criteria = new CDbCriteria;
		$criteria->select='commission';
		$criteria->condition='userid=:userid';
		$criteria->params=array(':userid' => $uid);
		$result = TaSwapOrder::model()->findAll($criteria);

		$i = 0;
		foreach($result as $val)
		{
			$data['summary']['commission'] += $val->commission;
			$i++;
		}

		//-- get profit swap
		$criteria = new CDbCriteria;
		$criteria->select = 'logdatetime';
		$criteria->condition='userid=:userid';
		$criteria->params=array(':userid' => $uid);
		$criteria->order  = 'logdatetime DESC';
		$criteria->limit  = 1;
		$lastdate = ViewTaSwapOrderDetail::model()->find($criteria);

		$criteria = new CDbCriteria;
		$criteria->select = 'profit,swap,logdatetime';
		$criteria->condition='userid=:userid';
		$criteria->params=array(':userid' => $uid);
		$result = ViewTaSwapOrderDetail::model()->findAll($criteria);

		$data['summary']['lastuptodate'] = $lastdate->logdatetime;

		foreach($result as $val)
		{
			if($val->logdatetime == $lastdate->logdatetime)
			{
				$data['summary']['swap'] += $val->swap;
				$data['summary']['cost'] += $val->profit;
			}

			$tm = strtotime(date('Y-m-d', strtotime($val->logdatetime)));
			$charts['swap'][$tm] += $val->swap;
			$charts['cost'][$tm] += $val->profit;
		}

		$data['charts']['swap'] = array();
		$data['charts']['cost'] = array();
		$data['charts']['netearning'] = array();
		foreach($charts['swap'] as $d=>$v)
		{
			array_push($data['charts']['swap'], array($d, $v));
			array_push($data['charts']['cost'], array($d, $charts['cost'][$d]));
			array_push($data['charts']['netearning'], array($d, $v + $charts['cost'][$d] - $data['summary']['commission']));
		}

		$data['summary']['cost'] -= $data['summary']['commission']; // adjust the cost value

		//-- get net earning
		$data['summary']['netearning'] = $data['summary']['swap'] + $data['summary']['cost'];
		$data['summary']['balance'] += $data['summary']['netearning'];

		//-- data format
		foreach($data['summary'] as $key=>$val)
		{
			if($key!='lastuptodate')
			$data['summary'][$key] = number_format($val, 1);
		}
		foreach($data['charts'] as $key=>$val)
		{
			$data['charts'][$key] = json_encode($val);
		}

		return $data;
	}
}