<?php
/**
 * @file
 * Handles communication with the global configuration
 */
class Config {
    public static function get($path = NULL, $return_as_array = false) {
        if($path) {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);
            
            foreach($path as $bit) {
                if(isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            if(is_array($config)) {
                return ($return_as_array == true) ? $config : false;
            }
            else {
                return $config;
            }
            
        }
        else {
            return false;
        }
    }
    public static function set($path = NULL, $value) {
        //Set new items in the global config
        if($path) {
            $path = explode('/', $path);
            if(isset($values)) {
                foreach ($path as $key) {
                    if(count($path) > 1) {
                        unset($path[0]);
                        $GLOBALS['config'][$key] = self::set(implode('/', $path), $value);
                    }
                    else {
                        $GLOBALS['config'][$key] = $value;
                    }
                }
            }
        }
        else {
            return false;
        }
    }
    public static function setSiteConfig() {
        $query = DB::getInstance()->getAll('config');
        $return = array();
        if(!$query->error()) {
            foreach($query->results() as $data) {
                $return[$data->property] = $data->contents;
            }
            return $return;
        }
        return false;
    }
    public static function setDBConfig() {
        return File::parse_info_file('core/config/config.info')['db'];
    }
}