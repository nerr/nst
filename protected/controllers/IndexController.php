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

		$params['summary'] = $this->getOrderInfo($userid);

		$this->render('general', $params);

		$this->getOrderInfo($userid);
	}

	private function getBalance($uid)
	{
		$criteria = new CDbCriteria;
		$criteria->select='amount,direction';
		$criteria->condition='userid=:userid';
		$criteria->params=array(':userid' => $uid);
		$result = SysCapitalFlow::model()->findAll($criteria);

		$balance = 0;
		foreach($result as $val)
		{
			if($val->direction == 0)
				$balance += $val->amount;
			elseif($val->direction == 1)
				$balance -= $val->amount;
		}
		return $balance;
	}

	private function getCommission($uid)
	{
		$criteria = new CDbCriteria;
		$criteria->select='commission';
		$criteria->condition='userid=:userid';
		$criteria->params=array(':userid' => $uid);
		$result = TaSwapOrder::model()->findAll($criteria);

		$commission = 0;
		foreach($result as $val)
		{
			$commission += $val->commission;
		}

		return $commission;
	}

	private function getOrderInfo($userid)
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'logdatetime';
		$criteria->order = 'logdatetime DESC';
		$criteria->limit = 1;
		$lastdate = TaSwapOrderDailySettlement::model()->find($criteria);

		$criteria = new CDbCriteria;
		$criteria->select = 'profit,swap';
		$criteria->condition = 'logdatetime=:logdatetime';
		$criteria->params = array(':logdatetime' => $lastdate->logdatetime);
		$result = TaSwapOrderDailySettlement::model()->findAll($criteria);

		$summary = array();
		$summary['balance'] = 0;
		$summary['swap'] = 0;
		$summary['cost'] = 0;
		$summary['netearning'] = 0;
		$summary['lastupdatedate'] = $lastdate->logdatetime;

		foreach($result as $val)
		{
			$summary['swap'] += $val->swap;
			$summary['cost'] += $val->profit;
		}

		$summary['cost'] -= $this->getCommission($userid);
		$summary['netearning'] = $summary['swap'] + $summary['cost'];
		$summary['netearning'] = number_format($summary['netearning'], 1);
		$summary['swap'] = number_format($summary['swap'], 1);
		$summary['cost'] = number_format($summary['cost'], 1);
		$summary['balance'] = number_format($this->getBalance($userid), 1);


		return $summary;
	}
}