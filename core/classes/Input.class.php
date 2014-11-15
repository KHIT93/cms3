<?php
/**
 * @file
 * Handles the usage of inputs
 */
class Input {
    public static function exists($type = 'post') {
        switch ($type) {
            case 'post':
                return ($_POST) ? true : false;
            break;
            case 'get':
                return ($_GET) ? true : false;
            break;
            default:
                return false;
            break;
        }
    }
    public static function get($item) {
        if(isset($_POST[$item])) {
            return $_POST[$item];
        }
        else if(isset($_GET[$item])) {
            return $_GET[$item];
        }
        return false;
    }
}