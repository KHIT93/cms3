<?php
/**
 * @file
 * Handles redirection
 */
class Redirect {
    public static function to($location = null) {
        if($location) {
            if(is_numeric($location)) {
                Theme::errorPage($location);
            }
            header('Location: '.$location);
            exit();
        }
    }
    public static function splitURL() {
        return (isset($_GET['q'])) ? explode('/', $_GET['q']) : page_front();
    }
}