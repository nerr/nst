<?php

/**
 * This is the model class for table "nst_sys_capital_flow".
 *
 * The followings are the available columns in table 'nst_sys_capital_flow':
 * @property integer $id
 * @property integer $accountid
 * @property integer $userid
 * @property double $amount
 * @property integer $direction
 * @property string $when
 */
class SysCapitalFlow extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SysCapitalFlow the static model class
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
		return 'nst_sys_capital_flow';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accountid, userid, amount, direction, when', 'required'),
			array('accountid, userid, direction', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, accountid, userid, amount, direction, when', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'accountid' => 'Accountid',
			'userid' => 'Userid',
			'amount' => 'Amount',
			'direction' => 'Direction',
			'when' => 'When',
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
		$criteria->compare('userid',$this->userid);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('direction',$this->direction);
		$criteria->compare('when',$this->when,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}