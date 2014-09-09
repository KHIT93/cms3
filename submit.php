<?php
/**
 * @file Handles processing and returning data in connection with AJAX requests
 */
define('SITE_ROOT', getcwd());
require_once SITE_ROOT.'/core/includes/constants.inc.php';
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
$GLOBALS['config']['db'] = Config::setDBConfig();
if(Input::exists('post')) {
    //VALID CORE JSON OBJECT
    //{
    //"status":true,
    //"percentage":"13",
    //"message":"Completed 5 of 40.",
    //"label":"Installed \u003Cem class=\u0022placeholder\u0022\u003EFilter\u003C\/em\u003E module."
    //"next_url" : 'optional URL to use for redirection'
    //}
    $function = Input::get('form_id').'_ajax';
    $result = $function($_POST);
    print (String::isJSON($result)) ? $result: json_encode($result);
    //return json_encode(print_r($_POST));
}
else {
    print 'Nothing to see here!';
}