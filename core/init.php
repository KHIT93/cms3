<?php
/**
 * @file
 * File that includes all files needed for initial functions
 */
if(version_compare(phpversion(), '5.4.0', '<')) {
    session_start();
    if(!file_exists('core/config/config.php')) {
        if(isset($_GET['q']) && $_GET['q'] != 'install') {
            header('Location: install');
        }
        else if(!isset ($_GET['q'])) {
            header('Location: install');
        }
    }
    else {
        $GLOBALS['config'] = array(
            'db' => array(
                'host' => '127.0.0.1',
                'username' => 'root',
                'password' => 'root',
                'name' => 'cms3'
            ),
            'cookies' => array(
                'cookie_name' => 'hash',
                'cookie_expiry' => 604800
            ),
            'session' => array(
                'session_name' => 'user',
                'token_name' => 'token'
            )
        );
        spl_autoload_register(function($class){
            require_once SITE_ROOT.'/core/classes/'.$class.'.class.php';
        });
        if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
            $hash = Cookie::get(Config::get('remember/cookie_name'));
            $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));
            if($hashCheck->count()) {
                $user = new User($hashCheck->first()->user_id);
                $user->login();
            }
        }

        if($_GET['q'] == 'logout') {
            log_out();
            header('Location: '.site_root());
            exit();
        }
    }
}
else {
    die('Your server does not meet the requirements to run this system. Please make sure that your webhost is running PHP 5.4.0 or above');
}