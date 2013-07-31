<?php

/**
 * This is the model class for table "nst_view_sys_user_list".
 *
 * The followings are the available columns in table 'nst_view_sys_user_list':
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property string $memo
 * @property string $mobile
 * @property string $groupname
 * @property integer $usergroupid
 */
class ViewSysUserList extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ViewSysUserList the static model class
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
		return 'nst_view_sys_user_list';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, usergroupid', 'numerical', 'integerOnly'=>true),
			array('email', 'length', 'max'=>45),
			array('username, groupname', 'length', 'max'=>48),
			array('memo, mobile', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, username, memo, mobile, groupname, usergroupid', 'safe', 'on'=>'search'),
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
			'email' => 'Email',
			'username' => 'Username',
			'memo' => 'Memo',
			'mobile' => 'Mobile',
			'groupname' => 'Groupname',
			'usergroupid' => 'Usergroupid',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('memo',$this->memo,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('groupname',$this->groupname,true);
		$criteria->compare('usergroupid',$this->usergroupid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}