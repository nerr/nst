<?php

/**
 * This is the model class for table "nst_ta_swap_order".
 *
 * The followings are the available columns in table 'nst_ta_swap_order':
 * @property integer $id
 * @property integer $userid
 * @property integer $orderticket
 * @property double $usemargin
 * @property string $opendate
 * @property integer $orderstatus
 * @property string $closedate
 * @property double $getswap
 * @property string $memo
 * @property integer $ordertype
 * @property double $openprice
 * @property string $commission
 *
 * The followings are the available model relations:
 * @property SysUser $user
 * @property TaSwapOrderDailySettlement[] $taSwapOrderDailySettlements
 */
class TaSwapOrder extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TaSwapOrder the static model class
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
		return 'nst_ta_swap_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, orderticket, usemargin, opendate, orderstatus', 'required'),
			array('userid, orderticket, orderstatus, ordertype', 'numerical', 'integerOnly'=>true),
			array('usemargin, getswap, openprice', 'numerical'),
			array('memo', 'length', 'max'=>256),
			array('commission', 'length', 'max'=>45),
			array('closedate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userid, orderticket, usemargin, opendate, orderstatus, closedate, getswap, memo, ordertype, openprice, commission', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'SysUser', 'userid'),
			'taSwapOrderDailySettlements' => array(self::HAS_MANY, 'TaSwapOrderDailySettlement', 'orderticket'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userid' => 'Userid',
			'orderticket' => 'Orderticket',
			'usemargin' => 'Usemargin',
			'opendate' => 'Opendate',
			'orderstatus' => 'Orderstatus',
			'closedate' => 'Closedate',
			'getswap' => 'Getswap',
			'memo' => 'Memo',
			'ordertype' => 'Ordertype',
			'openprice' => 'Openprice',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('userid',$this->userid);
		$criteria->compare('orderticket',$this->orderticket);
		$criteria->compare('usemargin',$this->usemargin);
		$criteria->compare('opendate',$this->opendate,true);
		$criteria->compare('orderstatus',$this->orderstatus);
		$criteria->compare('closedate',$this->closedate,true);
		$criteria->compare('getswap',$this->getswap);
		$criteria->compare('memo',$this->memo,true);
		$criteria->compare('ordertype',$this->ordertype);
		$criteria->compare('openprice',$this->openprice);
		$criteria->compare('commission',$this->commission,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}