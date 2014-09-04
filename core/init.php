<?php
/**
 * @file
 * File that includes all files needed for initialization
 */
require_once SITE_ROOT.'/core/includes/constants.inc.php';

if(version_compare(phpversion(), '5.4.0', '>')) {
    session_start();
    if(!file_exists('core/config/config.info')) {
        http_response_code(200);
        header('Location: /install.php');
        exit();
//        if(isset($_GET['q']) && $_GET['q'] != 'install') {
//            header('Location: install');
//        }
//        else if(!isset ($_GET['q'])) {
//            header('Location: install');
//        }
    }
    else {
        $GLOBALS['config'] = array(
            'cookies' => array(
                'cookie_name' => 'hash',
                'cookie_expiry' => 604800
            ),
            'session' => array(
                'session_name' => 'user',
                'token_name' => 'form-token'
            ),
            'assets' => array(
                'styles' => array(
                    'screen' => array(
                        CORE_CSS_PATH.'/bootstrap.min.css',
                        CORE_CSS_PATH.'/core.css',
                        CORE_CSS_PATH.'/font-awesome.min.css'
                    )
                ),
                'scripts' => array(
                    CORE_JS_PATH.'/bootstrap/bootstrap.min.js',
                    CORE_JS_PATH.'/modernizr/modernizr.min.js'
                )
            ),
            'default_reports' => array(
                'config',
                'not_found_errors',
                'access_denied_errors',
                'sysguard',
                'translation',
                'status'
            )
        );
        require_once INCLUDES_PATH.'/autoload.inc.php';
        
        //Set DB and Site configuration
        $GLOBALS['config']['db'] = Config::setDBConfig();
        $GLOBALS['config']['site'] = Config::setSiteConfig();
        //Include core parameters
        $GLOBALS['config']['param']['mode'] = (splitURL()[0] == 'admin' || splitURL()[0] == 'login') ? splitURL()[0] : 'page';
        if(Cookie::exists(Config::get('cookies/cookie_name')) && !Session::exists(Config::get('cookies/session_name'))) {
            $hash = Cookie::get(Config::get('remember/cookie_name'));
            $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));
            if($hashCheck->count()) {
                $user = new User($hashCheck->first()->user_id);
                $user->login();
            }
        }
        else if(Session::exists(Config::get('session/session_name'))) {
            $user = new User(Session::get(Config::get('session/session_name')));
        }

        if(isset($_GET['q']) && $_GET['q'] == 'logout') {
            log_out();
            Redirect::to(page_front());
            exit();
        }
        require_once INCLUDES_PATH.'/systemforms.inc.php';
    }
}
else {
    require_once 'core/classes/Theme.class.php';
    Theme::errorPage('generic', '<p>Your server does not meet the requirements to run this system. Please make sure that your webhost is running PHP 5.4.0 or above<br/>Your current PHP version has been detected as '.phpversion().'</p>');
    die();
}