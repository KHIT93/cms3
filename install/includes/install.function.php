<?php
/**
 * @file Procedural methods required for the installer to work
 */
function install_core() {
    //Initializes the installation of core
    if(!Session::exists('installer')) {
        Session::put('installer', 'new');
    }
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
    Session::put('config', $config);
    Session::put('db/host', (($formdata['host'] == 'localhost') ? '127.0.0.1': $formdata['host']).(($formdata['port'] == 3306) ? '': ':'.$formdata['port']));
    Session::put('db/username', $formdata['username']);
    Session::put('db/password', $formdata['password']);
    Session::put('db/name', $formdata['db']);
    Session::put('db/driver', $formdata['driver']);
    $file = new File('core/config/config.info', 'w');
    $file->write($config);
    Redirect::to('install.php?step=5&lang='.Session::get('lang'));
    exit();
}
function siteInformation_validate() {
    //Validates the site information entered
    return true;
}
function siteInformation_submit() {
    //Adds the information entered in the siteInformation form to the session and proceeds for ajax-based installation
    Redirect::to('install.php?step=7&lang='.Session::get('lang'));
}
function configure_db_ajax($formdata = NULL) {
    if(configure_db() == true) {
        $return = array(
            'status' => true,
            'percentage' => 100,
            'message' => rt('Completed'),
            'label' => rt('Configured the database'),
            'next_url' => 'install.php?step=6&lang='.$formdata['lang']
        );
        return $return;
    }
    return array(
        'status' => false,
        'percentage' => 0,
        'message' => rt('An error occurred'),
        'label' => rt('Could not configure the database due to an error'),
        'next_url' => 'install.php?step=error&lang='.$formdata['lang']
    );
}
function configure_db() {
    //Configures the database and adds default system data.
    //Old data is deleted before adding the new db structure
    $db = DB::getInstance();
    //$file = new File(CORE_INSTALLER_FILES_PATH.'/db/init.sql', 'r');
    if(!$db->query(file_get_contents(CORE_INSTALLER_FILES_PATH.'/db/init.sql'))->error()) {
        return true;
    }
    return false;
}
function install_site_ajax($formdata = NULL) {
    if(install_site() == true) {
        $return = array(
            'status' => true,
            'percentage' => 100,
            'message' => rt('Completed'),
            'label' => rt('Finished configuring the site and installing modules'),
            'next_url' => 'install.php?step=8&lang='.$formdata['lang']
        );
        return $return;
    }
    return array(
        'status' => false,
        'percentage' => 0,
        'message' => rt('An error occurred'),
        'label' => rt('Something went wrong during the site installation'),
        'next_url' => 'install.php?step=error&lang='.$formdata['lang']
    );
}
function install_site() {
    //Configures the site and installs core modules
    $db = DB::getInstance();
    $site_config = array(
        'name' => Sanitize::checkPlain($_POST['name']),
        'slogan' => Sanitize::checkPlain($_POST['slogan']),
        'lang' => Session::get('lang'),
        'theme' => 'core',
        'adminUser' => Sanitize::checkPlain($_POST['adminUser']),
        'adminName' => Sanitize::chechPlain($_POST['adminName']),
        'adminEmail' => Sanitize::checkPlain($_POST['adminEmail']),
        'adminPassword' => Hash::makePassHash(Sanitize::checkPlain($_POST['adminPassword']))
    );
    $sql = "INSERT INTO `config` (`property`, `contents`) VALUES "
            . "('?', '?'),"
            . "('?', '?'),"
            . "('?', '?'),"
            . "('?', '?'),";
    if(!$db->query($sql, array('site_name', $site_config['name'], 'site_slogan', $site_config['slogan'], 'site_language', $site_config['lang'], 'site_theme', $site_config['theme']))->error()) {
        //Create admin user
        $fields = array(
            'username' => $site_config['adminUser'],
            'password' => $site_config['adminPassword'],
            'role' => DEFAULT_ADMIN_RID,
            'email' => $site_config['adminEmail'],
            'name' => $site_config['adminName'],
            'language' => Session::get('lang'),
            'active' => 1
        );
        $new_user = new User();
        if($new_user->create($fields)) {
            return true;
        }
        else {
            System::addMessage('error', rt('The site administrator could not be created. Please verify that your server meets the requirements for the application and that your database user has sufficient permissions ot make changes in the database'));
        }
    }
    else {
        //Return error
        System::addMessage('error', rt('The website could not be configured. Please make sure that you have entered all the information correctly and that you have supplied a database username and password with sufficient permissions to make changes in the database'));
    }
    return false;
}