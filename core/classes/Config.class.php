<?php
/**
 * @file
 * Handles communication with the global configuration
 */
class Config {
    public static function get($path = NULL) {
        if($path) {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);
            
            foreach($path as $bit) {
                if(isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        else {
            return false;
        }
    }
    public static function set($path = NULL) {
        //Set new items in the global config
    }
}