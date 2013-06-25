<?php

class Calculate
{
	public static function getFundLog($uid)
	{
		//-- get log
		$criteria = new CDbCriteria;
		$criteria->select = 'amount,directioinname,flowtime,memo';
		$criteria->condition='userid=:userid';
		$criteria->params = array(':userid' => $uid);
		$criteria->order  = 'flowtime DESC';
		$result = ViewTaSwapCapitalFlow::model()->findAll($criteria);

		return $result;
	}
}