<?php

/**
 * This is the model class for table "test_order_info".
 *
 * The followings are the available columns in table 'test_order_info':
 * @property integer $orderticket
 * @property string $opendate
 * @property string $symbol
 * @property double $lots
 * @property double $commission
 * @property double $swap
 * @property integer $ordertype
 * @property double $openprice
 * @property double $sl
 * @property double $tp
 * @property double $profit
 * @property string $ordercomment
 * @property string $broker
 * @property string $accountnum
 * @property double $longswap
 * @property double $shortswap
 */
class TestOrderInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'test_order_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orderticket', 'required'),
			array('orderticket, ordertype', 'numerical', 'integerOnly'=>true),
			array('lots, commission, swap, openprice, sl, tp, profit, longswap, shortswap', 'numerical'),
			array('opendate', 'length', 'max'=>6),
			array('symbol', 'length', 'max'=>10),
			array('ordercomment', 'length', 'max'=>200),
			array('broker', 'length', 'max'=>48),
			array('accountnum', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('orderticket, opendate, symbol, lots, commission, swap, ordertype, openprice, sl, tp, profit, ordercomment, broker, accountnum, longswap, shortswap', 'safe', 'on'=>'search'),
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
			'opendate' => 'Opendate',
			'symbol' => 'Symbol',
			'lots' => 'Lots',
			'commission' => 'Commission',
			'swap' => 'Swap',
			'ordertype' => 'Ordertype',
			'openprice' => 'Openprice',
			'sl' => 'Sl',
			'tp' => 'Tp',
			'profit' => 'Profit',
			'ordercomment' => 'Ordercomment',
			'broker' => 'Broker',
			'accountnum' => 'Accountnum',
			'longswap' => 'Longswap',
			'shortswap' => 'Shortswap',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('orderticket',$this->orderticket);
		$criteria->compare('opendate',$this->opendate,true);
		$criteria->compare('symbol',$this->symbol,true);
		$criteria->compare('lots',$this->lots);
		$criteria->compare('commission',$this->commission);
		$criteria->compare('swap',$this->swap);
		$criteria->compare('ordertype',$this->ordertype);
		$criteria->compare('openprice',$this->openprice);
		$criteria->compare('sl',$this->sl);
		$criteria->compare('tp',$this->tp);
		$criteria->compare('profit',$this->profit);
		$criteria->compare('ordercomment',$this->ordercomment,true);
		$criteria->compare('broker',$this->broker,true);
		$criteria->compare('accountnum',$this->accountnum,true);
		$criteria->compare('longswap',$this->longswap);
		$criteria->compare('shortswap',$this->shortswap);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TestOrderInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
