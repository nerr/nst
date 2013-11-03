<?php

/**
 * This is the model class for table "nst_ta_swap_rate".
 *
 * The followings are the available columns in table 'nst_ta_swap_rate':
 * @property integer $id
 * @property integer $accountid
 * @property string $symbol
 * @property double $longswap
 * @property string $logdatetime
 * @property double $shortswap
 */
class TaSwapRate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TaSwapRate the static model class
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
		return 'nst_ta_swap_rate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accountid, symbol, longswap, logdatetime, shortswap', 'required'),
			array('accountid', 'numerical', 'integerOnly'=>true),
			array('longswap, shortswap', 'numerical'),
			array('symbol', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, accountid, symbol, longswap, logdatetime, shortswap', 'safe', 'on'=>'search'),
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
			'symbol' => 'Symbol',
			'longswap' => 'Longswap',
			'logdatetime' => 'Logdatetime',
			'shortswap' => 'Shortswap',
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
		$criteria->compare('symbol',$this->symbol,true);
		$criteria->compare('longswap',$this->longswap);
		$criteria->compare('logdatetime',$this->logdatetime,true);
		$criteria->compare('shortswap',$this->shortswap);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}