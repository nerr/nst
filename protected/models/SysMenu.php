<?php

/**
 * This is the model class for table "nst_sys_menu".
 *
 * The followings are the available columns in table 'nst_sys_menu':
 * @property integer $id
 * @property string $menuname
 * @property string $menuurl
 * @property integer $usergroupid
 * @property integer $menusort
 * @property string $icon
 * @property string $title
 *
 * The followings are the available model relations:
 * @property SysUsergroup $usergroup
 */
class SysMenu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SysMenu the static model class
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
		return 'nst_sys_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usergroupid, menusort', 'numerical', 'integerOnly'=>true),
			array('menuname, icon, title', 'length', 'max'=>48),
			array('menuurl', 'length', 'max'=>80),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, menuname, menuurl, usergroupid, menusort, icon, title', 'safe', 'on'=>'search'),
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
			'usergroup' => array(self::BELONGS_TO, 'SysUsergroup', 'usergroupid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'menuname' => 'Menuname',
			'menuurl' => 'Menuurl',
			'usergroupid' => 'Usergroupid',
			'menusort' => 'Menusort',
			'icon' => 'Icon',
			'title' => 'Title',
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
		$criteria->compare('menuname',$this->menuname,true);
		$criteria->compare('menuurl',$this->menuurl,true);
		$criteria->compare('usergroupid',$this->usergroupid);
		$criteria->compare('menusort',$this->menusort);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}