<?php

/**
 * This is the model class for table "nst_view_ta_swap_order_detail".
 *
 * The followings are the available columns in table 'nst_view_ta_swap_order_detail':
 * @property integer $orderticket
 * @property string $logdatetime
 * @property double $currentprice
 * @property double $profit
 * @property double $swap
 * @property integer $userid
 * @property integer $orderstatus
 * @property string $closedate
 * @property double $getswap
 * @property double $endprofit
 * @property double $commission
 */
class ViewTaSwapOrderDetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ViewTaSwapOrderDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nst_view_ta_swap_order_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orderticket, userid, orderstatus', 'numerical', 'integerOnly'=>true),
			array('currentprice, profit, swap, getswap, endprofit, commission', 'numerical'),
			array('logdatetime, closedate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('orderticket, logdatetime, currentprice, profit, swap, userid, orderstatus, closedate, getswap, endprofit, commission', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'orderticket' => 'Orderticket',
			'logdatetime' => 'Logdatetime',
			'currentprice' => 'Currentprice',
			'profit' => 'Profit',
			'swap' => 'Swap',
			'userid' => 'Userid',
			'orderstatus' => 'Orderstatus',
			'closedate' => 'Closedate',
			'getswap' => 'Getswap',
			'endprofit' => 'Endprofit',
			'commission' => 'Commission',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('orderticket',$this->orderticket);
		$criteria->compare('logdatetime',$this->logdatetime,true);
		$criteria->compare('currentprice',$this->currentprice);
		$criteria->compare('profit',$this->profit);
		$criteria->compare('swap',$this->swap);
		$criteria->compare('userid',$this->userid);
		$criteria->compare('orderstatus',$this->orderstatus);
		$criteria->compare('closedate',$this->closedate,true);
		$criteria->compare('getswap',$this->getswap);
		$criteria->compare('endprofit',$this->endprofit);
		$criteria->compare('commission',$this->commission);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}