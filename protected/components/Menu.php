<?php

class Menu
{
	//const ACTIVEITEM = 'active_tab ';
	
	//
	public static function make($gid, $activeitem)
	{
		$menudata = Menu::getMenuData($gid);
		$menuhtml = Menu::structureMenu($menudata, $activeitem);

		return $menuhtml;
	}

	public static function getMenuData($gid)
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'menuname,menuurl,icon,title';
		$criteria->condition='usergroupid=:usergroupid';
		$criteria->params=array(':usergroupid' => $gid);
		$criteria->order  = 'menusort';
		$result = SysMenu::model()->findAll($criteria);

		return $result;
	}
	
	public static function structureMenu($mdata, $active)
	{
		if(count($mdata)==0)
			return 'Load menu data error.';

		$menu = '';
		
		foreach($mdata as $val)
		{
			if($val->menuname == $active)
				$a = 'active_tab ';
			else
				$a = '';


			$url = Yii::app()->createUrl($val->menuurl);
			$menu .= '<li class="'.$a.$val->icon.'">
					<a href="'.$url.'" title="">
						<span class="tab_label">'.Yii::t('common', $val->menuname).'</span>
						<span class="tab_info">'.Yii::t('common', $val->title).'</span>
					</a>
				</li>';
		}

		return $menu;
	}

}