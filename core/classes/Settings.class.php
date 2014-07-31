<?php
class Settings {
    public static function editGlobalUser($formdata) {
        $db = db_connect();
        $query = $db->prepare("UPDATE `config` SET `config_value`=:optionsUser WHERE `config_name`='create_user'");
        $query->bindValue(':optionsUser', $formdata['optionsUser'], PDO::PARAM_INT);
        try {
            $query->execute();
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while updating the site configuration'), $e);
        }
        $db = NULL;
    }
    public static function updateSite($formdata) {
        $db = db_connect();
        global $site_data;    
        $title = check_plain($formdata['title']);
        $slogan = check_plain($formdata['slogan']);
        $frontpage = check_plain($formdata['frontpage']);
        try {
            $db->beginTransaction();
            if($formdata['title'] != $site_data['site_name']) {
                $db->query("UPDATE `config` SET `config_value`={$title} WHERE `config_name`='site_name'");
            }
            if($formdata['slogan'] != $site_data['site_slogan']) {
                $db->query("UPDATE `config` SET `config_value`={$slogan} WHERE `config_name`='site_slogan'");
            }
            if($formdata['frontpage'] != $site_data['site_front']) {
                $db->query("UPDATE `config` SET `config_value`={$frontpage} WHERE `config_name`='site_front'");
            }
            $db->commit();
            addMessage('success', t('Site information has been updated'));
        }
        catch(Exception $e) {
            $db->rollback();
            addMessage('error', t('There was an error while updating the site configuration'), $e);
            //die($e->getMessage());
        }
        $db = NULL;
    }
    public static function enableWysiwyg($formdata) {
        $db = db_connect();
        $query = $db->prepare("UPDATE `config` SET `config_value`=:wysiwyg WHERE `config_name`='enable_wysiwyg'");
        $query->bindValue(':wysiwyg', $formdata['inputWysiwyg'], PDO::PARAM_INT);
        try {
            $query->execute();
            addMessage('success', t('Changes have been saved'));
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while updating the content configuration'), $e);
        }
        $db = NULL;
    }
    function settingList() {
        //Get a list of all settings
        $settings = array(
            'system' => array(),
            'content' => array(),
            'development' => array(),
            'search' => array(),
            'language' => array()
        );
        if(has_permission('access_admin_settings_system', $_SESSION['uid']) === true) {
            $settings['system'][] = array(
                'title' => t('Site configuration'),
                'description' => t('Use this setting to configure generic site settings such as sitename and site slogan.'),
                'link' => site_root().'/admin/settings/system'
            );
        }
        /*$settings['system'][] = array(
            'title' => t('Performance'),
            'description' => t('Use this setting to configure performance settings and caching.'),
            'link' => site_root().'/admin/settings/system/perf'
        );*/
        if(has_permission('access_admin_settings_system_users', $_SESSION['uid']) === true) {
            $settings['system'][] = array(
                'title' => t('Users'),
                'description' => t('Configure global settings for users and select how new users can be created.'),
                'link' => site_root().'/admin/settings/system/users'
            );
        }
        if(has_permission('access_admin_settings_system_systemcheck', $_SESSION['uid']) === true) {
            $settings['system'][] = array(
                'title' => t('System check'),
                'description' => t('Check if all files and folders exist and if they have the correct permissions.'),
                'link' => site_root().'/admin/settings/system/systemcheck'
            );
        }
        if(has_permission('access_admin_settings_content_wysiwyg', $_SESSION['uid']) === true) {
            $settings['content'][] = array(
                'title' => t('WYSIWYG settings'),
                'description' => t('Configure the built-in CKEditor.'),
                'link' => site_root().'/admin/settings/content/wysiwyg'
            );
        }
        if(has_permission('access_admin_settings_development', $_SESSION['uid']) === true) {
            $settings['development'][] = array(
                'title' => t('Development Mode'),
                'description' => t('Enable or disable Development Mode.'),
                'link' => site_root().'/admin/settings/development'
            );
        }
        if(has_permission('access_admin_settings_development_maintenance', $_SESSION['uid']) === true) {
            $settings['development'][] = array(
                'title' => t('Maintenance'),
                'description' => t('Configure maintenance mode for the website and enable/disable maintenance mode.'),
                'link' => site_root().'/admin/settings/development/maintenance'
            );
        }
        if(has_permission('access_admin_settings_cron', $_SESSION['uid']) === true) {
            $settings['development'][] = array(
                'title' => t('Cron'),
                'description' => t('Manage automatic site maintenance tasks.'),
                'link' => site_root().'/admin/settings/cron'
            );
        }
        if(has_permission('access_admin_settings_search_redirect', $_SESSION['uid']) === true) {
            $settings['search'][] = array(
                'title' => t('URL Redirect'),
                'description' => t('Configure URL Redirect of different types'),
                'link' => site_root().'/admin/settings/search/redirect'
            );
        }
        if(has_permission('access_admin_settings_search_metadata', $_SESSION['uid']) === true) {
            $settings['search'][] = array(
                'title' => t('Meta-tags'),
                'description' => t('Configure metadata for the entire site. Change settings for search robots.'),
                'link' => site_root().'/admin/settings/search/metadata'
            );
        }
        if(has_permission('access_admin_settings_search_errorpages', $_SESSION['uid']) === true) {
            $settings['search'][] = array(
                'title' => t('Error pages'),
                'description' => t('Configure custom pages for HTTP errors such as 404, 403 and 500'),
                'link' => site_root().'/admin/settings/search/error-pages'
            );
        }
        if(has_permission('access_admin_settings_language', $_SESSION['uid']) === true) {
            $settings['language'][] = array(
                'title' => t('Language'),
                'description' => t('Configure website language.'),
                'link' => site_root().'/admin/settings/language'
            );
        }
        if(has_permission('access_admin_settings_language_translate', $_SESSION['uid']) === true) {
            $settings['language'][] = array(
                'title' => t('Translation'),
                'description' => t('Use the translation console to translate strings from modules and themes into active site language.'),
                'link' => site_root().'/admin/settings/language/translate'
            );
        }
        foreach (Modules::activeModules() as $module) {
            if(Modules::moduleImplements($module, 'settings_alter')) {
                //call_user_func($module['module'].'_settings_alter', $settings);
                //call_user_func_array($module['module'].'_settings_alter', $settings);
                $function = $module['module'].'_settings_alter';
                $function($settings);
            }
        }
        $system = array();
        $content = array();
        $development = array();
        $search = array();
        $language = array();
        
        foreach ($settings['system'] as $setting) {
            $system[] = '<a href="'.$setting['link'].'" class="list-group-item"><h4 class="list-group-item-heading">'.$setting['title'].'</h4>'.'<p class="list-group-item-text">'.$setting['description'].'</p></a>';
        }
        foreach ($settings['content'] as $setting) {
            $content[] = '<a href="'.$setting['link'].'" class="list-group-item"><h4 class="list-group-item-heading">'.$setting['title'].'</h4>'.'<p class="list-group-item-text">'.$setting['description'].'</p></a>';
        }
        foreach ($settings['development'] as $setting) {
            $development[] = '<a href="'.$setting['link'].'" class="list-group-item"><h4 class="list-group-item-heading">'.$setting['title'].'</h4>'.'<p class="list-group-item-text">'.$setting['description'].'</p></a>';
        }
        foreach ($settings['search'] as $setting) {
            $search[] = '<a href="'.$setting['link'].'" class="list-group-item"><h4 class="list-group-item-heading">'.$setting['title'].'</h4>'.'<p class="list-group-item-text">'.$setting['description'].'</p></a>';
        }
        foreach ($settings['language'] as $setting) {
            $language[] = '<a href="'.$setting['link'].'" class="list-group-item"><h4 class="list-group-item-heading">'.$setting['title'].'</h4>'.'<p class="list-group-item-text">'.$setting['description'].'</p></a>';
        }
        
        $data = array(
            'system' => '<div class="col-md-6"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'.t('System').'</h3></div><div class="list-group">'. implode('', $system).'</div></div></div>',
            'content' => '<div class="col-md-6"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'.t('Content Mangement').'</h3></div><div class="list-group">'. implode('', $content).'</div></div></div>',
            'search' => '<div class="col-md-6"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'.t('Search & Metadata').'</h3></div><div class="list-group">'. implode('', $search).'</div></div></div>',
            'development' => '<div class="col-md-6"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'.t('Development & maintenance').'</h3></div><div class="list-group">'. implode('', $development).'</div></div></div>',
            'language' => '<div class="col-md-6"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'.t('Regional').'</h3></div><div class="list-group">'. implode('', $language).'</div></div></div>'
        );
        
        return $data;
    }
    function system() {
        $db = db_connect();
        $csrf = Csrf::addCsrf();
        $token_id = $csrf->get_token_id();
        global $site_data;
        $editSite = $site_data;
        $get_url = splitURL();
        if(isset($get_url[3])) {
            if($get_url[3] == 'perf') {
                $output = $this->systemPerformance();
            }
            else if($get_url[3] == 'users') {
                $output = $this->systemUsers();
            }
            else if($get_url[3] == 'systemcheck') {
                $output = $this->systemCheck();
            }
            else {
                $output = 'System settings 404';
            }
        }
        else {
            
            $output = '<div class="page-head">'
                    . '<h2>'.t('Site configuration').'</h2>'
                    . get_breadcrumb()
                    . '</div>'
                    . '<div class="cl-mcont">'
                    . print_messages()
                    . '<div class="col-md-12">'
                    . '<p>'.t('Use this setting to configure generic site settings such as sitename and site slogan.').'</p>'
                    . '<form name="editSite" method="POST" action="" role="form">'
                    . '<div id="siteName" class="form-group form600">'
                    . '<label for="inputTitle">'.t('Site name').'</label>'
                    . '<input type="text" class="form-control form300" name="title" value="'.$editSite['site_name'].'">'
                    . '<p class="help-block">'.t('Enter the website name. This is often a human readable name or the domain').'</p>'
                    . '</div>'
                    . '<div id="siteSlogan" class="form-group form600">'
                    . '<label for="inputSlogan">'.t('Site slogan').'</label>'
                    . '<input type="text" class="form-control form300" name="slogan" value="'.$editSite['site_slogan'].'">'
                    . '<p class="help-block">'.t('If your site has a slogan this will be entered here. Please note that the slogan will only be displayed in the browser title if the active theme is printing it on the page').'</p>'
                    . '</div>'
                    . '<div id="siteFrontpage" class="form-group form-inline">'
                    . '<label for="inputFrontpage">'.t('Site frontpage').'</label>'
                    . '<p>http://'.$_SERVER['HTTP_HOST'].site_root().'/<input type="text" class="form-control form300" name="frontpage" value="'.$editSite['site_front'].'"></p>'
                    . '<p class="help-block">'.t('Enter the relative path for the page that you want to use').'</p>'
                    . '</div>'
                    . '<input type="hidden" name="form-token" value="'.$csrf->get_token($token_id).'">'
                    . '<div class="form-actions">'
                    . '<button type="submit" name="editPage" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> '.t('Save changes').'</button>'
                    . '</div>'
                    . '</form>'
                    . '</div>';
        }
        $db = NULL;
        return $output;
    }
    function systemPerformance() {
        $db = db_connect();
        $output = '<div class="page-head">'
                . '<h2>'.t('Performance').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                    . print_messages()
                . '<div class="col-md-12">'.
                t('Under development')
                . '</div>';
        $db = NULL;
        return $output;
    }
    function systemUsers() {
        $db = db_connect();
        $csrf = Csrf::addCsrf();
        $token_id = $csrf->get_token_id();
        global $site_data;
        $output = '<div class="page-head">'
                . '<h2>'.t('Users').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                    . print_messages()
                . '<div class="col-md-12">';
        
        $output .= '<form name="globalUser" role="form" action="" method="POST">';
        $output .= '<div class="radio"><label>'
                . '<input type="radio" name="optionsUser" id="optionsUser1" value="0"';
        $output .= ($site_data['create_user'] == 0) ? 'checked>' : '>';
        $output .= t('Only admin can create new users')
                . '</label>'
                . '</div>';
        $output .= '<div class="radio"><label>'
                . '<input type="radio" name="optionsUser" id="optionsUser1" value="1"';
        $output .= ($site_data['create_user'] == 1) ? 'checked>' : '>';
        $output .= t('Users can create an account, but it requires approval from admin')
                . '</label>'
                . '</div>';
        $output .= '<div class="radio"><label>'
                . '<input type="radio" name="optionsUser" id="optionsUser1" value="2"';
        $output .= ($site_data['create_user'] == 2) ? 'checked>' : '>';
        $output .= t('Users can create an account without approval from admin')
                . '</label>'
                . '</div>'
                . '<input type="hidden" name="form-token" value="'.$csrf->get_token($token_id).'">';
        $output .= '<div class="form-group">'
                . '<button type="submit" name="globalUser" class="btn btn-rad btn-sm btn-primary">'.t('Save').'</button>'
                . '</div>'
                . '</form>'
                . '</div>';
        $db = NULL;
        return $output;
    }
    function systemCheck() {
        $db = db_connect();
        $output = '<div class="page-head">'
                . '<h2>'.t('Systemcheck').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                    . print_messages()
                . '<div class="col-md-12">'.
                t('Under development')
                . '</div>';
        $db = NULL;
    }
    function contentWysiwyg() {
        $db = db_connect();
        $csrf = Csrf::addCsrf();
        $token_id = $csrf->get_token_id();
        //Show settings for content management
        $output = '<div class="page-head">'
                    . '<h2>'.t('WYSIWYG settings').'</h2>'
                    . get_breadcrumb()
                    . '</div>'
                    . '<div class="cl-mcont">'
                    . print_messages()
                    . '<div class="col-md-12">';
        $query = $db->query("SELECT `config_value` FROM `config` WHERE `config_name`='enable_wysiwyg'");
        $wysiwyg = $query->fetchColumn();
        $output .= t('Here you can either enable or disable the built-in CKEditor. CKEditor is a Graphical editor for textareas which makes you create content like in any other texteditor.');
        $output .= '<form name="enableWysiwyg" action="" method="POST" role="form">'
                . '<div class="checkbox">'
                . '<label>'
                . t('Enable CKEditor').'?<br/>';
        $output .= ($wysiwyg == 1) ? '<input type="checkbox" name="inputWysiwyg" class="switch" value="1" checked>' : '<input type="checkbox" name="inputWysiwyg" class="switch" value="1">';
        $output .= '</label>'
                . '</div>'
                . '<input type="hidden" name="form-token" value="'.$csrf->get_token($token_id).'">'
                . '<div class="form-group">'
                . '<button type="submit" name="editPage" class="btn btn-rad btn-sm btn-primary">'
                . '<span class="glyphicon glyphicon-floppy-saved"></span> '.t('Save changes')
                . '</button>'
                . '</form>'
                . '</div>';
        $db = NULL;
        return $output;
    }
    function development() {
        $db = db_connect();
        $csrf = Csrf::addCsrf();
        $token_id = $csrf->get_token_id();
        $get_url = splitURL();
        $site_data = getSiteConfig();
        if(isset($get_url[3])) {
            if($get_url[3] == 'maintenance') {
                $output = $this->maintenance();
            }
            else {
                $mode = $site_data['dev_mode'];
                $output = '<div class="page-head">'
                        . '<h2>'.t('Development Mode').'</h2>'
                        . get_breadcrumb()
                        . '</div>'
                        . '<div class="cl-mcont">'
                        . print_messages()
                        . '<div class="col-md-12">';
                $output .= t('Use Development Mode to enable the usage of developer modules.');
                $output .='<form method="POST" name="setDevMode" action="" role="form">'
                        . '<label class="checkbox">'.t('Enable Development Mode').'</label>';
                $output .= ($mode == 1) ? '<input type="checkbox" class="switch" name="inputDevMode" value="1" checked>': '<input type="checkbox" class="switch" name="inputDevMode" value="1">';
                $output .= '<input type="hidden" name="form-token" value="'.$csrf->get_token($token_id).'">'
                        . '<br/><br/><button type="submit" name="setDevMode" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> '.  t('Save changes').'</button>'
                          .'</form>'
                        . '</div>';
            }
        }
        else {
            $mode = $site_data['dev_mode'];
            $output = '<div class="page-head">'
                    . '<h2>'.t('Development Mode').'</h2>'
                    . get_breadcrumb()
                    . '</div>'
                    . '<div class="cl-mcont">'
                    . print_messages()
                    . '<div class="col-md-12">';
            $output .= t('Use Development Mode to enable the usage of developer modules.');
            $output .= '<form method="POST" name="setDevMode" action="" role="form">'
                    . '<label class="checkbox">'.t('Enable Development Mode').'</label>';
            $output .= ($mode == 1) ? '<input type="checkbox" class="switch" name="inputDevMode" value="1" checked>': '<input type="checkbox" class="switch" name="inputDevMode" value="1">';
            $output .= '<input type="hidden" name="form-token" value="'.$csrf->get_token($token_id).'">'
                    . '<br/><br/><button type="submit" name="setDevMode" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> '.  t('Save changes').'</button>'
                      .'</form>'
                    . '</div>';
        }
        $db = NULL;
        return $output;
    }
    function developmentMaintenance() {
        $csrf = Csrf::addCsrf();
        $token_id = $csrf->get_token_id();
        global $site_data;
        global $adv_data;
        $mode = $site_data['maintenance'];
        $output = ($mode == '1') ? '<div class="alert alert-info alert-box"><p>'.t('Maintenance mode is enabled').'</p></div>' : '';
        $message = getFieldFromDB('adv_config', 'adv_value', 'config_name', 'maintenance');
        $output .= '<div class="page-head">'
                . '<h2>'.t('Maintenance Mode').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                    . print_messages()
                . '<div class="col-md-12">'
                .'<p>'.t('On this page you can enable or disable the maintenance mode for this website. You will also be able to specify if the maintenance applies to the site and the database and to define a custom message that will be shown to the visitors').'</p>'
                .'<form method="POST" name="setMaintenance" action="" role="form">'
                . '<label class="checkbox">'.t('Enable Maintenance Mode').'</label>';
        $output .= ($mode == '1') ? '<input type="checkbox" class="switch" name="inputMaintenance" value="1" checked>': '<input type="checkbox" class="switch" name="inputMaintenance" value="1">';
        $adv_data['maintenance'] = (isset($adv_data['maintenance'])) ? $adv_data['maintenance'] : '';
        $output .= '<div class="form-group"><label for="inputMessage">'.t('Maintenance message').':</label><br><textarea class="form-control" name="message">'.$adv_data['maintenance'].'</textarea></div>';
        $output .= '<input type="hidden" name="form-token" value="'.$csrf->get_token($token_id).'">'
                . '<button type="submit" name="setMaintenance" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> '.  t('Save changes').'</button>'
                  .'</form>'
                . '</div>';
        return $output;
    }
    function search_meta() {
        //Show settings for search engines and metadata
        $output = '<div class="page-head">'
                . '<h2>'.t('Search & Metadata').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                    . print_messages()
                . '<div class="col-md-12">'
                . 'search and metadata settings'
                . '</div>';
        return $output;
    }
    function search_metaData() {
        
    }
    function search_metaRedirect() {
        
    }
    function search_errorPages() {
        
    }
    function language() {
        $get_url = splitURL();
        $output = '';
        if($get_url[3] == 'translate') {
            if(isset($get_url[4]) && isset($get_url[5]) && is_numeric($get_url[5])) {
                $output = $this->translate();
            }
            else {
                //Show regional settings
                //$translations = getTranslations(get_lang());
                //$data = pagination(10, 'translation', '*', 't_locale', get_lang());
                $output .= '<div class="page-head">'
                        . '<h2>'.t('Translation').'</h2>'
                        . get_breadcrumb()
                        . '</div>'
                        . '<div class="cl-mcont">'
                        . print_messages()
                        . '<div class="col-md-12">';
                $output .= '<div class="hidden-xs">';
                $data = pagination(20, 'translation', '*');
                $translations = $data['data'];
                $output .= '<table class="table table-striped table-hover">'
                        . '<thead style="background-color: #CCC;">'
                             .'<tr>'
                                 .'<th><strong>'.t('String').'</strong></th>'
                                 .'<th><strong>'.t('Translation').'</strong></th>'
                                 .'<th></th>'
                             .'</tr>'
                        . '</thead>'
                        . '<tbody>';
                foreach($translations as $translation) {
                    $output .= '<tr>'
                                  .'<td>'.check_plain($translation['t_string']).'</td>'
                                  .'<td>'.check_plain($translation['t_translation']).'</td>'
                                  .'<td>'
                                      .'<a href="'.site_root().'/admin/settings/language/translate/'.$translation['t_locale'].'/'.$translation['t_id'].'/edit" class="btn btn-rad btn-sm btn-default">'.t('Translate').'</a>'
                                  .'</td>';
                }
                $output .= '</tbody></table>';
                $output .= $data['controls'];
                $output .= '</div>';
                $output .= '<div class="visible-xs"><p>'.t('Interface translation is not available on mobile devices and screens with low resolution.').'</p></div>'
                        . '</div>';
            }
        }
        else {
            $output = '<div class="page-head">'
                    . '<h2>'.t('Language').'</h2>'
                    . get_breadcrumb()
                    . '</div>'
                    . '<div class="cl-mcont">'
                    . print_messages()
                    . '<div class="col-md-12">'
                    . 'Language settings'
                    . '</div>';
        }
        return $output;
    }
    function translate() {
        $get_url = splitURL();
        $db = db_connect();
        $csrf = Csrf::addCsrf();
        $token_id = $csrf->get_token_id();
        $translation = array();
        $query = $db->prepare("SELECT * FROM `translation` WHERE `t_locale`=:locale AND `t_id`=:field");
        $query->bindValue(':locale', check_plain($get_url[4]), PDO::PARAM_STR);
        $query->bindValue(':field', (int)$get_url[5], PDO::PARAM_INT);
        try {
        $query->execute(); //Executes query

        $translation = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while processing the request'), $e);
            die($e->getMessage());
        }
        $translation['t_translation'] = ((isset($translation['t_translation']) && !empty($translation['t_translation'])) OR (isset($translation['t_translation']) && $translation['t_translation'] != '')) ? $translation['t_translation'] : 'empty';
        //$output = krumo($translation);
        $output = '<div class="page-head">'
                . '<h2>'.t('Translation').'</h2>'
                . '</div>'
                . '<div class="cl-mcont">'
                    . print_messages()
                . '<div class="col-md-12">'
                . '<form method="POST" name="editTranslation" action="" role="form">'
                       .'<div class="form-group">'
                           .'<label for="inputString">'.  t('Original string').':</label>'
                           .'<p class="form-control-static">'.$translation[0]['t_string'].'</p>'
                       .'</div>'
                       .'<div class="form-group">'
                           .'<label for="inputTranslation">'.  t('Translated string').':</label><br/>'
                           .'<textarea class="form-control" name="translation">'.$translation[0]['t_translation'].'</textarea>'
                       .'</div>'
                       .'<input type="hidden" name="t_id" value="'.$get_url[5].'">'
                       .'<input type="hidden" name="t_locale" value="'.$get_url[4].'">'
                       .'<input type="hidden" name="form-token" value="'.$csrf->get_token($token_id).'">'
                       .'<div class="form-actions">'
                           .'<button type="submit" name="editTranslation" class="btn btn-rad btn-sm btn-primary">'.t('Save changes').'</button>'
                       .'</div>'
                 .'</form>'
                . '</div>';
        $db = NULL;
        return $output;
    }
    function developmentCron() {
        $csrf = Csrf::addCsrf();
        $token_id = $csrf->get_token_id();
        $intervals = array(
            0 => t('never'),
            1 => '1 '.t('hour'),
            3 => '3 '.t('hours'),
            6 => '6 '.t('hours'),
            12 => '12 '.t('hours'),
            24 => '1 '.t('day')
        );
        $options = '';
        $current = getFieldFromDB('config', 'config_value', 'config_name', 'cron');
        foreach ($intervals as $key => $value) {
            if($key == $current) {
                $options .= '<option value="'.$key.'" selected >'.$value.'</option>';
            }
            else {
                $options .= '<option value="'.$key.'">'.$value.'</option>';
            }
        }
        $output = '<div class="page-head">'
                . '<h2>'.t('Cron').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                    . print_messages()
                . '<div class="col-md-12">'
                . '<p>'.t('Cron takes care of running periodic tasks like checking for updates and indexing content for search.').'</p>'
                . '<form name="runCron" method="POST" action="" role="form">'
                    .'<input type="hidden" name="form-token" value="'.$csrf->get_token($token_id).'">'
                    . '<button type="submit" name="runCron" class="btn btn-rad btn-default">'.t('Run cron').'</button>'
                . '</form>'
                . '<form method="POST" name="editCron" action="" role="form">'
                       .'<div class="form-group">'
                           .'<p>'.t('Run cron automatically each').' '
                           .'<select name="inputCronTime" class="select2">'
                              .$options
                           .'</select>'
                       .'</div>'
                       .'<input type="hidden" name="form-token" value="'.$csrf->get_token($token_id).'">'
                       .'<div class="form-actions">'
                           .'<button type="submit" name="editCron" class="btn btn-rad btn-sm btn-primary">'.t('Save changes').'</button>'
                       .'</div>'
                 .'</form>'
                . '</div>';
        
        return $output;
    }
}