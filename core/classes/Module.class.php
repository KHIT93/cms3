<?php
class Module {
    public static function moduleImplements($module, $function) {
       $name = (is_array($module)) ? $module['module'].'_'.$function : $module.'_'.$function;
       return (function_exists($name)) ? true : false;
   }
}