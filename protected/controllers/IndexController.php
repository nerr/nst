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
		$this->redirect('index/general');
	}

	/**
	 * This is the user general action
	 */
	public function actionGeneral()
	{
		$uid = 2;
		$gid = 2;

		$params = $this->getGeneralSummaryData($uid);
		//-- params data format
		foreach($params['summary'] as $key=>$val)
		{
			if($key!='lastuptodate')
				$params['summary'][$key] = number_format($val, 1);
		}
		foreach($params['charts'] as $key=>$val)
		{
			$params['charts'][$key] = json_encode($val);
		}

		$params['menu'] = Menu::make($gid, 'General');

		$this->render('general', $params);
	}

	public function actionReport()
	{
		$uid = 2;
		$gid = 2;

		$params['menu'] = Menu::make($gid, 'Report');

		$criteria = new CDbCriteria;
		$criteria->select = 'profit,swap,logdatetime';
		$criteria->condition='userid=:userid';
		$criteria->order = 'logdatetime desc';
		$criteria->params=array(':userid' => $uid);
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

		$data = $this->getGeneralSummaryData($uid);

		$i = 0;
		while (list($k, $v) = each($detail))
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


		// adjust detail data format
		foreach($params['detail'] as $k=>$v)
		{
			foreach($v as $key => $val)
				$params['detail'][$k][$key] = number_format($val, 2);
		}

		$params['summary']['capital'] = $data['summary']['capital'];
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
		$uid = 2;
		$gid = 2;

		//-- get log
		$criteria = new CDbCriteria;
		$criteria->select = 'amount,directioinname,flowtime,memo';
		$criteria->condition='userid=:userid';
		$criteria->params=array(':userid' => $uid);
		$criteria->order  = 'flowtime DESC';
		$result = ViewTaSwapCapitalFlow::model()->findAll($criteria);

		$params['menu'] = Menu::make($gid, 'Funds');
		$params['table'] = $result;
		$this->render('funds', $params);
	}

	private function getGeneralSummaryData($uid)
	{
		$data = array();

		//-- get balance
		$criteria = new CDbCriteria;
		$criteria->select='amount,directionid';
		$criteria->condition='userid=:userid';
		$criteria->params=array(':userid' => $uid);
		$result = SysCapitalFlow::model()->findAll($criteria);

		foreach($result as $val)
		{
			if($val->direction == 1)
				$data['summary']['balance'] += $val->amount;
			elseif($val->direction == 2)
				$data['summary']['balance'] -= $val->amount;
		}

		$data['summary']['capital'] = $data['summary']['balance'];

		//-- get commission
		$criteria = new CDbCriteria;
		$criteria->select='commission,opendate';
		$criteria->condition='userid=:userid';
		$criteria->params=array(':userid' => $uid);
		$result = TaSwapOrder::model()->findAll($criteria);

		$i = 0;
		foreach($result as $val)
		{
			$data['summary']['commission'] += $val->commission;
			$commission[$val->opendate] += $val->commission;
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
			array_push($data['charts']['cost'], array($d, $charts['cost'][$d] + $data['summary']['commission']));
			array_push($data['charts']['netearning'], array($d, $v + $charts['cost'][$d] + $data['summary']['commission']));
		}

		$data['summary']['cost'] += $data['summary']['commission']; // adjust the cost value

		//-- get net earning
		$data['summary']['netearning'] = $data['summary']['swap'] + $data['summary']['cost'];
		$data['summary']['balance'] += $data['summary']['netearning'];

		

		return $data;
	}

	/*
	public function actionTest()
	{
		echo "begin..."."<br>";

		$menu = Menu::make(2, 'General');

		echo $menu;


		echo Yii::t('common', 'General');
	}*/
}