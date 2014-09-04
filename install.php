<?php
error_reporting(E_ALL);
if(version_compare(phpversion(), '5.4.0', '>')) {
    if(file_exists('core/config/config.info')) {
        //Render information about existing installation
    }
    else {
        define('SITE_ROOT', getcwd());
        require_once SITE_ROOT.'/core/includes/constants.inc.php';
        //Include classes using autoload
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
        include_once 'core/modules/krumo/class.krumo.php';
        install_core();
    }
}
