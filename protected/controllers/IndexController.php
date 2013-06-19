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
		$params = $this->getGeneralSummaryData(Yii::app()->user->id);

		/*echo '<pre>';
		var_dump($params);
		echo '</pre>';*/

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

		foreach($params['swapratechart'] as $key=>$val)
		{
			$params['swapratechart'][$key] = json_encode($val);
		}

		$params['menu'] = Menu::make(Yii::app()->user->gid, 'General');

		$this->render('general', $params);
	}

	public function actionReport()
	{
		$uid = Yii::app()->user->id;
		$gid = Yii::app()->user->gid;

		//-- get menu
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
		if(count($detail) > 0)
		{
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
		$uid = Yii::app()->user->id;
		$gid = Yii::app()->user->gid;

		//-- get log
		$criteria = new CDbCriteria;
		$criteria->select = 'amount,directioinname,flowtime,memo';
		$criteria->condition='userid=:userid';
		$criteria->params = array(':userid' => $uid);
		$criteria->order  = 'flowtime DESC';
		$result = ViewTaSwapCapitalFlow::model()->findAll($criteria);

		$params['menu'] = Menu::make($gid, 'Funds');
		$params['table'] = $result;
		$this->render('funds', $params);
	}

	private function getGeneralSummaryData($uid)
	{
		$data = array();
		$data['charts']['swap'] = array();
		$data['charts']['cost'] = array();
		$data['charts']['netearning'] = array();

		//-- get closed ring profit (proft+getswap+commission)
		$criteria = new CDbCriteria;
		$criteria->select = 'getswap,endprofit,commission';
		$criteria->condition = 'userid=:userid and orderstatus=:orderstatus';
		$criteria->params = array(':userid' => Yii::app()->user->id,
								':orderstatus' => 1);
		$result = TaSwapOrder::model()->findAll($criteria);

		foreach($result as $val)
		{
			$data['summary']['closed'] += $val->getswap + $val->endprofit + $val->commission;
		}

		//-- get init balance (real capital + closed profit)
		$data['summary']['balance'] = $this->getCapital() + $data['summary']['closed'];

		$data['summary']['capital'] = $data['summary']['balance'];


		//-- get commission
		$criteria = new CDbCriteria;
		$criteria->select='commission,opendate';
		$criteria->condition = 'userid=:userid and orderstatus=:orderstatus';
		$criteria->params = array(':userid' => Yii::app()->user->id, 
								':orderstatus' => 0);
		$result = TaSwapOrder::model()->findAll($criteria);

		foreach($result as $val)
		{
			$commission[$val->opendate] += $val->commission;
		}
		$data['summary']['commission'] = array_sum($commission);

		//-- get profit swap
		$criteria = new CDbCriteria;
		$criteria->select = 'logdatetime';
		$criteria->condition='userid=:userid and orderstatus=:orderstatus';
		$criteria->params = array(':userid' => Yii::app()->user->id,
								':orderstatus' => 0);
		$criteria->order  = 'logdatetime DESC';
		$criteria->limit  = 1;
		$lastdate = ViewTaSwapOrderDetail::model()->find($criteria);

		$data['summary']['lastuptodate'] = $lastdate->logdatetime;

		$criteria = new CDbCriteria;
		$criteria->select = 'profit,swap,logdatetime';
		$criteria->condition='userid=:userid';
		$criteria->params=array(':userid' => $uid);
		$result = ViewTaSwapOrderDetail::model()->findAll($criteria);

		foreach($result as $val)
		{
			if(date('Y-m-d', strtotime($val->logdatetime)) == date('Y-m-d', strtotime($lastdate->logdatetime)))
			{
				$data['summary']['swap'] += $val->swap;
				$data['summary']['cost'] += $val->profit;
			}

			$tm = strtotime(date('Y-m-d', strtotime($val->logdatetime)));
			$charts['swap'][$tm] += $val->swap;
			$charts['cost'][$tm] += $val->profit;
		}

		echo '<prd>';
		var_dump($data['summary']);
		echo '</prd>';
		

		if(count($charts['swap']) > 0)
		{
			foreach($charts['swap'] as $d=>$v)
			{
				array_push($data['charts']['swap'], array($d, $v));
				array_push($data['charts']['cost'], array($d, $charts['cost'][$d] + $data['summary']['commission']));
				array_push($data['charts']['netearning'], array($d, $v + $charts['cost'][$d] + $data['summary']['commission']));
			}
		}

		$data['summary']['cost'] += $data['summary']['commission']; // adjust the cost value

		//-- get net earning
		$data['summary']['netearning'] = $data['summary']['swap'] + $data['summary']['cost'];
		$data['summary']['balance'] += $data['summary']['netearning'];

		//--
		$data['swapratechart'] = $this->getSwapRateChartData();

		return $data;
	}

	private function getSwapRateChartData()
	{
		$aid = 1; //-- account id

		$criteria = new CDbCriteria;
		$criteria->select='symbol,logdatetime,longswap,shortswap';
		$criteria->condition = 'accountid=:accountid';
		$criteria->params = array(':accountid' => $aid);
		$result = TaSwapRate::model()->findAll($criteria);

		foreach($result as $val)
		{
			$logdate = strtotime(date('Y-m-d', strtotime($val->logdatetime)));

			$swaprate[$val->symbol.'long'][] = array($logdate, $val->longswap);
			$swaprate[$val->symbol.'short'][] = array($logdate, $val->shortswap);
		}

		/*foreach($swaprate as $k=>$v)
		{
			$swaprate[$k][1] = (int)$swaprate[$k][1];
		}*/

		return $swaprate;
	}

	private function getCapital()
	{
		//-- get init balance
		$criteria = new CDbCriteria;
		$criteria->select='amount,directionid';
		$criteria->condition='userid=:userid';
		$criteria->params=array(':userid' => Yii::app()->user->id);
		$result = SysCapitalFlow::model()->findAll($criteria);

		foreach($result as $val)
		{
			if($val->directionid == 1)
				$capital += $val->amount;
			elseif($val->directionid == 2)
				$capital -= $val->amount;
		}

		return $capital;
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