<?php
/**
 * @file
 * Handles redirection
 */
class Redirect {
    public static function to($location = null, $reponsse_code = NULL) {
        http_response_code((($reponsse_code) ? $reponsse_code : 200));
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