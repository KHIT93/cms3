<?php
/**
 * @file Procedural methods required for the installer to work
 */
function install_core() {
    //Initializes the installation of core
    install_submit();
    $head = '<meta charset="'.((isset($header['charset'])) ? $header['charset']."\n" : 'utf-8').'">'."\n"
            .'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">'."\n"
            .'<meta name="robots" content="noindex,nofollow">'."\n"
            .'<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $header_title = '<title>Installation</title>'."\n";
    $install = new Install(EXEC_BOOTSTRAPPER_INSTALL, ((isset($_GET['step'])) ? $_GET['step']: 1));
    require_once CORE_INSTALLER_INCLUDES_PATH.'/templates/head.tpl.php';
    //require_once CORE_INSTALLER_INCLUDES_PATH.'/templates/page.tpl.php';
    require_once CORE_INSTALLER_INCLUDES_PATH.'/templates/test.tpl.php';
    require_once CORE_INSTALLER_INCLUDES_PATH.'/templates/footer.tpl.php';
}
function rt($string, $args = array()) {
    //Translates strings using a registry file
    return $string;
}
function install_submit() {
    if(Input::exists('post')) {
        //if(Token::check(Input::get(Config::get('session/token_name')))) {
            //Validate form
            $form_validate = Input::get('form_id').'_validate';
            $form_submit = Input::get('form_id').'_submit';
            if(function_exists($form_validate)) {
                if($form_validate()) {
                    if(function_exists($form_submit)) {
                        $form_submit($_POST);
                    }
                }
            }
            else {
                if(function_exists($form_submit)) {
                    $form_submit($_POST);
                }
            }
        //}
        //else {
          //  System::addMessage('error', 'Sorry, the form you have submitted is invalid');
        //}
    }
}
function get_installer_languages() {
    $languages = Definition::loadRegistry(CORE_INSTALLER_INCLUDES_PATH.'/registry/languages.registry');
    $output = array();
    foreach ($languages as $code => $language) {
        $output[$code] = $language;
    }
    return $output;
}
function welcomeForm_submit($formdata) {
    Session::put('lang', $formdata['lang']);
    Redirect::to('install.php?step=2&lang='.$formdata['lang']);
    exit();
}
function licenseForm_validate() {
    $accepted = false;
    if(hasValue(Input::get('app_license'))) {
        $accepted = true;
    }
    else {
        System::addMessage('error', 'You must accept the application license in order to proceed');
    }
    if(!hasValue(Input::get('bootstrap_license'))) {
        System::addMessage('error', 'You must accept the Twitter Bootstrap license in order to proceed');
        $accepted = false;
    }
    return $accepted;
}
function licenseForm_submit($formdata) {
    Redirect::to('install.php?step=3&lang='.Session::get('lang'));
    exit();
}
function requirements_submit() {
    Redirect::to('install.php?step=4&lang='.Session::get('lang'));
    exit();
}
function dbCredentials_validate() {
    //Test DB Connection
    try {
        $pdo = new PDO(Input::get('driver').':host='.Input::get('host').';dbname='.Input::get('db').';charset=utf8', Input::get('username'), Input::get('password'));
        return true;
    }
    catch (PDOException $e) {
        System::addMessage('error', rt('Could not connect to the database').':<br/>'.$e->getMessage());
        return false;
    }
}
function dbCredentials_submit($formdata) {
    //Create config file
    $config = ';Database configuration'."\n"
            . 'db[host] = '.(($formdata['host'] == 'localhost') ? '127.0.0.1': $formdata['host']).(($formdata['port'] == 3306) ? '': ':'.$formdata['port'])."\n"
            . 'db[username] = '.$formdata['username']."\n"
            . 'db[password] = '.$formdata['password']."\n"
            . 'db[name] = '.$formdata['db']."\n"
            . 'db[driver] = '.$formdata['driver'];
    $file = new File('core/config/config.info', 'w');
    $file->write($config);
    Redirect::to('install.php?step=5&lang='.Session::get('lang'));
    exit();
}