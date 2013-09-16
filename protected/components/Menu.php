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
        $criteria->select = 'id,menuname,menuurl,icon,title,parentid';
        $criteria->condition='usergroupid=:usergroupid';
        $criteria->params=array(':usergroupid' => $gid);
        $criteria->order  = 'parentid,menusort';
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


    /*
     * menu funcs for ace theme
     *
     */

    public static function aceStructureMenu($mdata, $active)
    {
        //$active = ucwords($active);

        if(count($mdata)==0)
            return 'Load menu data error.';

        //-- get menu data
        foreach($mdata as $val)
        {
            $menudata[] = array(
                'id' => $val->id, 
                'menuname' => $val->menuname, 
                'menuurl' => $val->menuurl, 
                'icon' => $val->icon, 
                'title' => $val->title, 
                'parentid' => $val->parentid);
        }

        //-- sort menu items
        foreach($menudata as $val)
        {
            if($val['parentid'] == 0)
                $menuarr[$val['id']] = $val;
            else
                $menuarr[$val['parentid']]['sub'][$val['id']] = $val;
        }

        //-- make html menu code
        $html = '<ul class="nav nav-list">'."\r";
        foreach($menuarr as $val)
        {
            if(count($val['sub']) == 0)
            {
                if($val['menuname'] == $active)
                {
                    $html .= '<li class="active">';
                    $result['info'] = array('name' => $val['menuname'], 'desc' => $val['title']);
                }
                else
                    $html .= '<li>';

                $url = Yii::app()->createUrl($val['menuurl']);

                $html .= '<a href="'.$url.'">
                                <i class="'.$val['icon'].'"></i>
                                <span class="menu-text"> '.$val['menuname'].' </span>
                            </a>
                        </li>';
            }
            elseif(count($val['sub']) > 0)
            {
                $url = Yii::app()->createUrl($val['menuurl']);

                $html .= '<li>
                            <a href="'.$url.'" class="dropdown-toggle">
                                <i class="'.$val['icon'].'"></i>
                                <span class="menu-text"> '.$val['menuname'].' </span>

                                <b class="arrow icon-angle-down"></b>
                            </a>

                            <ul class="submenu">';

                //-- level two
                foreach($val['sub'] as $val)
                {
                    if($val['menuname'] == $active)
                    {
                        $html .= '<li class="active">';
                        $result['info'] = array('name' => $val['menuname'], 'desc' => $val['title']);
                    }
                    else
                        $html .= '<li>';

                    $url = Yii::app()->createUrl($val['menuurl']);
                    $html .= '
                                    <a href="'.$url.'">
                                        <i class="'.$val['icon'].'"></i>
                                        '.$val['menuname'].' 
                                    </a>
                                </li>';
                }                
                                
                $html .= '</ul>
                        </li>';
            }
        }
        $html .= "\r".'</ul>';

        $result['html'] = $html;

        return $result;
    }

    public static function aceMake($gid, $activeitem)
    {
        $menudata = Menu::getMenuData($gid);
        $menu = Menu::aceStructureMenu($menudata, $activeitem);

        return $menu;
    }
}