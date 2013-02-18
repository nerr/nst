<?php

class SysMenu
{
	const ACTIVEITEM = 'active_tab ';
	
	//
	public static function make($groupid, $activeitem)
	{
		$menuArr = SysMenu::getMenuData($groupid);
		$menuhtml = SysMenu::structureMenu($menuArr, $selectItem);
		$menuhtml = '<ul class="tab_nav">'.$menu.'</ul>';

		return $menuhtml;
	}

	public static function getMenuData($gid)
	{

	}
	
	public static function structureMenu($menudata, $active)
	{
		if(count($data)==0)
			return 'Load menu data error.';

		$menu = '';
		
		foreach($menudata as $val)
		{
			if($val->menuname==$active)
				$a = 'active_tab ';
			else
				$a = '';

			$menu = $menu.'<li class="'.$a.'i_32_'.$val->icon.'">
					<a href="inbox.html" title="">
						<span class="tab_label">'.Yii::t('common', $val->menuname);.'</span>
						<span class="tab_info">'.Yii::t('common', $val->menuname);.'</span>
					</a>
				</li>';
		}
		return $menu;
	}

}