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
        spl_autoload_register(function($class){
            if(file_exists(CORE_CLASSES_PATH.'/'.$class.'.class.php')) {
                require_once CORE_CLASSES_PATH.'/'.$class.'.class.php';
            }
        });
        require_once CORE_FUNCTIONS_PATH.'/bootstrapper.function.php';
        require_once CORE_FUNCTIONS_PATH.'/db.function.php';
        require_once CORE_FUNCTIONS_PATH.'/form.function.php';
        require_once CORE_FUNCTIONS_PATH.'/language.function.php';
        require_once CORE_FUNCTIONS_PATH.'/legacy.function.php';
        require_once CORE_FUNCTIONS_PATH.'/menu.function.php';
        require_once CORE_FUNCTIONS_PATH.'/page.function.php';
        require_once CORE_FUNCTIONS_PATH.'/sanitize.function.php';
        require_once CORE_FUNCTIONS_PATH.'/string.function.php';
        require_once CORE_FUNCTIONS_PATH.'/system.function.php';
        require_once CORE_FUNCTIONS_PATH.'/theme.function.php';
        require_once CORE_FUNCTIONS_PATH.'/user.function.php';
        require_once CORE_FUNCTIONS_PATH.'/validate.function.php';
        require_once CORE_INSTALLER_INCLUDES_PATH.'/Install.class.php';
        require_once CORE_INSTALLER_INCLUDES_PATH.'/install.function.php';
        //core_bootstrapper($init, EXEC_BOOTSTRAPPER_INSTALL);
        install_core();
    }
}
