<?php
class Module {
    public static function moduleImplements($module, $function) {
       $name = (is_array($module)) ? $module['module'].'_'.$function : $module.'_'.$function;
       return (function_exists($name)) ? true : false;
   }
    public static function allModules() {
        $sysdir = scandir('core/modules/', SCANDIR_SORT_ASCENDING);
        if(isset($sysdir[0])) {
            unset ($sysdir[0]);
        }
        if(isset($sysdir[1])) {
            unset ($sysdir[1]);
        }
        if(isset($sysdir[2]) && $sysdir[2] == '.DS_Store') {
            unset ($sysdir[2]);
        }
        $output = array();
        foreach ($sysdir as $folder) {
            $output[] = self::moduleDetails($folder, true);
        }
        $dir = scandir('modules/', SCANDIR_SORT_ASCENDING);
        if(isset($dir[0])) {
            unset ($dir[0]);
        }
        if(isset($dir[1])) {
            unset ($dir[1]);
        }
        if(isset($dir[2]) && $dir[2] == '.DS_Store') {
            unset ($dir[2]);
        }
        foreach ($dir as $folder) {
            $output[] = self::moduleDetails($folder);
        }
        return $output;
    }
    public static function moduleDetails($modulepath, $core = false) {
        $output = array();
        $readin = ($core === true) ? 'core/modules/'.$modulepath.'/'.$modulepath.'.info' : 'modules/'.$modulepath.'/'.$modulepath.'.info';
        $output = File::parse_info_file($readin);
        $output['core'] = ($core === true) ? 1 : 0;
        $output['module'] = $modulepath;
        $output['installed'] = (DB::getInstance()->countItems('modules', '*', 'name', $modulepath) == 1) ? true : false ;
        if($output['installed'] === true) {
            $output['enabled'] = (DB::getInstance()->getField('modules', 'active', 'name', $modulepath) == 1) ? true : false ;
        }
        else {
            $output['enabled'] = false;
        }
        
        return $output;
    }
    public static function activeModules() {
       return DB::getInstance()->get('modules', array('active', '=', 1));
    }
    public static function loadModules($active_modules) {
        if(is_object($active_modules)) {
            foreach($active_modules as $module) {
                if($module->core == 1) {
                    include_once CORE_MODULE_PATH.'/'.$module->module.'/'.$module->file;
                }
                else {
                    include_once MODULE_PATH.'/'.$module->module.'/'.$module->file;
                }
            }
        }
        else if(is_array($active_modules)) {
            foreach($active_modules as $module) {
                if($module['core'] == 1) {
                    include_once CORE_MODULE_PATH.'/'.$module['module'].'/'.$module['file'];
                }
                else {
                    include_once MODULE_PATH.'/'.$module['module'].'/'.$module['file'];
                }
            }
        }
        else {
            addMessage('error', t('No modules were loaded. Expected object or array.'));
        }
   }
}