<?php

/**
 * This is the model class for table "nst_ta_swap_safe_margin_note".
 *
 * The followings are the available columns in table 'nst_ta_swap_safe_margin_note':
 * @property string $logtime
 * @property double $profitloss
 * @property double $commission
 * @property integer $accountnum
 * @property double $margin
 * @property double $freemargin
 * @property double $equity
 * @property double $swap
 * @property double $balance
 */
class TaSwapSafeMarginNote extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TaSwapSafeMarginNote the static model class
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
		return 'nst_ta_swap_safe_margin_note';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accountnum', 'numerical', 'integerOnly'=>true),
			array('profitloss, commission, margin, freemargin, equity, swap, balance', 'numerical'),
			array('logtime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('logtime, profitloss, commission, accountnum, margin, freemargin, equity, swap, balance', 'safe', 'on'=>'search'),
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
			'logtime' => 'Logtime',
			'profitloss' => 'Profitloss',
			'commission' => 'Commission',
			'accountnum' => 'Accountnum',
			'margin' => 'Margin',
			'freemargin' => 'Freemargin',
			'equity' => 'Equity',
			'swap' => 'Swap',
			'balance' => 'Balance',
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

		$criteria->compare('logtime',$this->logtime,true);
		$criteria->compare('profitloss',$this->profitloss);
		$criteria->compare('commission',$this->commission);
		$criteria->compare('accountnum',$this->accountnum);
		$criteria->compare('margin',$this->margin);
		$criteria->compare('freemargin',$this->freemargin);
		$criteria->compare('equity',$this->equity);
		$criteria->compare('swap',$this->swap);
		$criteria->compare('balance',$this->balance);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}