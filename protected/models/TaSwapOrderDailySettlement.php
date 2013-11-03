<?php

/**
 * This is the model class for table "nst_ta_swap_order_daily_settlement".
 *
 * The followings are the available columns in table 'nst_ta_swap_order_daily_settlement':
 * @property integer $id
 * @property integer $accountid
 * @property integer $orderticket
 * @property string $logdatetime
 * @property double $currentprice
 * @property double $profit
 * @property double $swap
 *
 * The followings are the available model relations:
 * @property TaSwapOrder $orderticket0
 * @property SysAccount $account
 */
class TaSwapOrderDailySettlement extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TaSwapOrderDailySettlement the static model class
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
		return 'nst_ta_swap_order_daily_settlement';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accountid, orderticket, logdatetime, currentprice, profit, swap', 'required'),
			array('accountid, orderticket', 'numerical', 'integerOnly'=>true),
			array('currentprice, profit, swap', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, accountid, orderticket, logdatetime, currentprice, profit, swap', 'safe', 'on'=>'search'),
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
			'orderticket0' => array(self::BELONGS_TO, 'TaSwapOrder', 'orderticket'),
			'account' => array(self::BELONGS_TO, 'SysAccount', 'accountid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'accountid' => 'Accountid',
			'orderticket' => 'Orderticket',
			'logdatetime' => 'Logdatetime',
			'currentprice' => 'Currentprice',
			'profit' => 'Profit',
			'swap' => 'Swap',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('accountid',$this->accountid);
		$criteria->compare('orderticket',$this->orderticket);
		$criteria->compare('logdatetime',$this->logdatetime,true);
		$criteria->compare('currentprice',$this->currentprice);
		$criteria->compare('profit',$this->profit);
		$criteria->compare('swap',$this->swap);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}