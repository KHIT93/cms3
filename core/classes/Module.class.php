<?php
class Module {
    public static function moduleImplements($module, $function) {
       $name = (is_array($module)) ? $module['module'].'_'.$function : $module.'_'.$function;
       return (function_exists($name)) ? true : false;
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