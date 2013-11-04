<?php

/**
 * This is the model class for table "test_profitable_rings".
 *
 * The followings are the available columns in table 'test_profitable_rings':
 * @property string $broker
 * @property string $accountnum
 * @property string $symbol_a
 * @property string $symbol_b
 * @property string $symbol_c
 * @property double $longswaptotal
 * @property double $shortswaptotal
 * @property double $expected
 */
class TestProfitableRings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'test_profitable_rings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('longswaptotal, shortswaptotal, expected', 'numerical'),
			array('broker', 'length', 'max'=>48),
			array('accountnum', 'length', 'max'=>20),
			array('symbol_a, symbol_b, symbol_c', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('broker, accountnum, symbol_a, symbol_b, symbol_c, longswaptotal, shortswaptotal, expected', 'safe', 'on'=>'search'),
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
			'broker' => 'Broker',
			'accountnum' => 'Accountnum',
			'symbol_a' => 'Symbol A',
			'symbol_b' => 'Symbol B',
			'symbol_c' => 'Symbol C',
			'longswaptotal' => 'Longswaptotal',
			'shortswaptotal' => 'Shortswaptotal',
			'expected' => 'Expected',
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

		$criteria->compare('broker',$this->broker,true);
		$criteria->compare('accountnum',$this->accountnum,true);
		$criteria->compare('symbol_a',$this->symbol_a,true);
		$criteria->compare('symbol_b',$this->symbol_b,true);
		$criteria->compare('symbol_c',$this->symbol_c,true);
		$criteria->compare('longswaptotal',$this->longswaptotal);
		$criteria->compare('shortswaptotal',$this->shortswaptotal);
		$criteria->compare('expected',$this->expected);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TestProfitableRings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
