<?php
class Help {
    public static function index() {
        $data = array();
        $data['core'] = '<ul>'.self::coreHelp().'</ul>';
        
        $output = '<ul>';
        $count = 0;
        foreach(Module::activeModules() as $module) {
            if(Module::moduleImplements($module, 'help')) {
                $output .= '<li><a href="/admin/help/modules/'.$module->module.'">'.$module->name.'</a></li>';
                $count++;
            }
        }
        $output .= '</ul>';
        $data['modules'] = ($count > 0) ? $output : t('No modules have implemented help or documentation');
        return $data;
    }
    public static function coreHelp() {
        $output = '<li><a href="/admin/help/core/content">'.t('Content').'</a></li>';
        $output .= '<li><a href="/admin/help/core/layout">'.t('Layout').'</a></li>';
        $output .= '<li><a href="/admin/help/core/menus">'.t('Menus').'</a></li>';
        $output .= '<li><a href="/admin/help/core/themes">'.t('Themes').'</a></li>';
        $output .= '<li><a href="/admin/help/core/widgets">'.t('Widget').'</a></li>';
        $output .= '<li><a href="/admin/help/core/modules">'.t('Modules').'</a></li>';
        $output .= '<li><a href="/admin/help/core/users">'.t('Users').'</a></li>';
        $output .= '<li><a href="/admin/help/core/roles">'.t('Roles').'</a></li>';
        $output .= '<li><a href="/admin/help/core/permissions">'.t('Permissions').'</a></li>';
        return $output;
    }
    public static function contentHelp() {
        
    }
    public static function layoutHelp() {
        
    }
    public static function menusHelp() {
        
    }
    public static function themesHelp() {
        
    }
    public static function widgetsHelp() {
        
    }
    public static function modulesHelp() {
        
    }
    public static function usersHelp() {
        
    }
    public static function rolesHelp() {
        
    }
    public static function permissionsHelp() {
        
    }
}