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
    public static function settingList() {
        //Get a list of all settings
        $settings = array(
            'system' => array(),
            'content' => array(),
            'development' => array(),
            'search' => array(),
            'language' => array()
        );
        if(has_permission('access_admin_settings_system', Session::exists(Config::get('session/session_name'))) === true) {
            $settings['system'][] = array(
                'title' => t('Site configuration'),
                'description' => t('Use this setting to configure generic site settings such as sitename and site slogan.'),
                'link' => '/admin/settings/system'
            );
        }
        /*$settings['system'][] = array(
            'title' => t('Performance'),
            'description' => t('Use this setting to configure performance settings and caching.'),
            'link' => site_root().'/admin/settings/system/perf'
        );*/
        if(has_permission('access_admin_settings_system_users', Session::exists(Config::get('session/session_name'))) === true) {
            $settings['system'][] = array(
                'title' => t('Users'),
                'description' => t('Configure global settings for users and select how new users can be created.'),
                'link' => '/admin/settings/system/users'
            );
        }
        if(has_permission('access_admin_settings_system_systemcheck', Session::exists(Config::get('session/session_name'))) === true) {
            $settings['system'][] = array(
                'title' => t('System check'),
                'description' => t('Check if all files and folders exist and if they have the correct permissions.'),
                'link' => '/admin/settings/system/systemcheck'
            );
        }
        if(has_permission('access_admin_settings_content_wysiwyg', Session::exists(Config::get('session/session_name'))) === true) {
            $settings['content'][] = array(
                'title' => t('WYSIWYG settings'),
                'description' => t('Configure the built-in CKEditor.'),
                'link' => '/admin/settings/content/wysiwyg'
            );
        }
        if(has_permission('access_admin_settings_development', Session::exists(Config::get('session/session_name'))) === true) {
            $settings['development'][] = array(
                'title' => t('Development Mode'),
                'description' => t('Enable or disable Development Mode.'),
                'link' => '/admin/settings/development'
            );
        }
        if(has_permission('access_admin_settings_development_maintenance', Session::exists(Config::get('session/session_name'))) === true) {
            $settings['development'][] = array(
                'title' => t('Maintenance'),
                'description' => t('Configure maintenance mode for the website and enable/disable maintenance mode.'),
                'link' => '/admin/settings/development/maintenance'
            );
        }
        if(has_permission('access_admin_settings_cron', Session::exists(Config::get('session/session_name'))) === true) {
            $settings['development'][] = array(
                'title' => t('Cron'),
                'description' => t('Manage automatic site maintenance tasks.'),
                'link' => '/admin/settings/cron'
            );
        }
        if(has_permission('access_admin_settings_search_redirect', Session::exists(Config::get('session/session_name'))) === true) {
            $settings['search'][] = array(
                'title' => t('URL Redirect'),
                'description' => t('Configure URL Redirect of different types'),
                'link' => '/admin/settings/search/redirect'
            );
        }
        if(has_permission('access_admin_settings_search_metadata', Session::exists(Config::get('session/session_name'))) === true) {
            $settings['search'][] = array(
                'title' => t('Meta-tags'),
                'description' => t('Configure metadata for the entire site. Change settings for search robots.'),
                'link' => '/admin/settings/search/metadata'
            );
        }
        if(has_permission('access_admin_settings_search_errorpages', Session::exists(Config::get('session/session_name'))) === true) {
            $settings['search'][] = array(
                'title' => t('Error pages'),
                'description' => t('Configure custom pages for HTTP errors such as 404, 403 and 500'),
                'link' => '/admin/settings/search/error-pages'
            );
        }
        if(has_permission('access_admin_settings_language', Session::exists(Config::get('session/session_name'))) === true) {
            $settings['language'][] = array(
                'title' => t('Language'),
                'description' => t('Configure website language.'),
                'link' => '/admin/settings/language'
            );
        }
        if(has_permission('access_admin_settings_language_translate', Session::exists(Config::get('session/session_name'))) === true) {
            $settings['language'][] = array(
                'title' => t('Translation'),
                'description' => t('Use the translation console to translate strings from modules and themes into active site language.'),
                'link' => '/admin/settings/language/translate'
            );
        }
        foreach (Module::activeModules() as $module) {
            if(Module::moduleImplements($module, 'settings_alter')) {
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
    public static function system() {
        $editSite = Config::get('site');
        $get_url = splitURL();
        if(isset($get_url[3])) {
            if($get_url[3] == 'users') {
                $output = self::systemUsers();
            }
            else if($get_url[3] == 'systemcheck') {
                $output = self::systemCheck();
            }
            else {
                $output = 'System settings 404';
            }
        }
        else {
            
            $output = '<div class="page-head">'
                    . '<h2>'.t('Site configuration for @site_name', array('@site_name' => Config::get('site/site_name'))).'</h2>'
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
                    . '<p>'.System::siteURL().'/<input type="text" class="form-control form300" name="frontpage" value="'.$editSite['site_front'].'"></p>'
                    . '<p class="help-block">'.t('Enter the relative path for the page that you want to use').'</p>'
                    . '</div>'
                    . '<input type="hidden" name="form-token" value="'.Token::generate().'">'
                    . '<input type="hidden" name="form_id" value="editSite">'
                    . '<div class="form-actions">'
                    . '<button type="submit" name="editSite" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> '.t('Save changes').'</button>'
                    . '</div>'
                    . '</form>'
                    . '</div>';
        }
        return $output;
    }
    public static function systemUsers() {
        $site_data = Config::get('site');
        $output = '<div class="page-head">'
                . '<h2>'.t('Users').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                    . print_messages()
                . '<div class="col-md-12">';
        
        $output .= '<form name="globalUser" role="form" action="" method="POST">';
        $output .= '<div class="radio"><label>'
                . '<input type="radio" name="optionsUser" class="icheck" id="optionsUser1" value="0"';
        $output .= (Config::get('site/create_user') == 0) ? 'checked>' : '>';
        $output .= t('Only admin can create new users')
                . '</label>'
                . '</div>';
        $output .= '<div class="radio"><label>'
                . '<input type="radio" name="optionsUser" class="icheck" id="optionsUser1" value="1"';
        $output .= (Config::get('site/create_user') == 1) ? 'checked>' : '>';
        $output .= t('Users can create an account, but it requires approval from admin')
                . '</label>'
                . '</div>';
        $output .= '<div class="radio"><label>'
                . '<input type="radio" name="optionsUser" class="icheck" id="optionsUser1" value="2"';
        $output .= (Config::get('site/create_user') == 2) ? 'checked>' : '>';
        $output .= t('Users can create an account without approval from admin')
                . '</label>'
                . '</div>'
                . '<input type="hidden" name="form-token" value="'.Token::generate().'">'
                . '<input type="hidden" name="form_id" value="globalUser">';
        $output .= '<div class="form-group">'
                . '<button type="submit" name="globalUser" class="btn btn-rad btn-sm btn-primary">'.t('Save').'</button>'
                . '</div>'
                . '</form>'
                . '</div>';
        $db = NULL;
        return $output;
    }
    public static function systemCheck() {
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
    public static function contentWysiwyg() {
        //Show settings for content management
        $output = '<div class="page-head">'
                    . '<h2>'.t('WYSIWYG settings').'</h2>'
                    . get_breadcrumb()
                    . '</div>'
                    . '<div class="cl-mcont">'
                    . print_messages()
                    . '<div class="col-md-12">';
        $wysiwyg = 0 /*Config::get('site/wysiwyg')*/;
        $output .= t('Here you can either enable or disable the built-in CKEditor. CKEditor is a Graphical editor for textareas which makes you create content like in any other texteditor.');
        $output .= '<form name="enableWysiwyg" action="" method="POST" role="form">'
                . '<div class="checkbox">'
                . '<label>'
                . t('Enable CKEditor').'?<br/>';
        $output .= ($wysiwyg == 1) ? '<input type="checkbox" name="inputWysiwyg" class="switch" value="1" checked>' : '<input type="checkbox" name="inputWysiwyg" class="switch" value="1">';
        $output .= '</label>'
                . '</div>'
                . '<input type="hidden" name="form-token" value="'.Token::generate().'">'
                . '<input type="hidden" name"form_id" value="enableWysiwyg">'
                . '<div class="form-group">'
                . '<button type="submit" name="editPage" class="btn btn-rad btn-sm btn-primary">'
                . '<span class="glyphicon glyphicon-floppy-saved"></span> '.t('Save changes')
                . '</button>'
                . '</form>'
                . '</div>';
        $db = NULL;
        return $output;
    }
    public static function development() {
        $get_url = splitURL();
        $site_data = Config::get('site', true);
        if(isset($get_url[3])) {
            if($get_url[3] == 'maintenance') {
                $output = self::maintenance();
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
                $output .= '<input type="hidden" name="form-token" value="'.Token::generate().'">'
                        . '<input type="hidden" name="form_id" value="setDevMode">'
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
            $output .= '<input type="hidden" name="form-token" value="'.Token::generate().'">'
                    . '<input type="hidden" name="form_id" value="setDevMode">'
                    . '<br/><br/><button type="submit" name="setDevMode" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> '.  t('Save changes').'</button>'
                      .'</form>'
                    . '</div>';
        }
        $db = NULL;
        return $output;
    }
    public static function developmentMaintenance() {
        $site_data = Config::get('site', true);
        $mode = $site_data['maintenance'];
        $output = ($mode == 1) ? '<div class="alert alert-info alert-box"><p>'.t('Maintenance mode is enabled').'</p></div>' : '';
        $message = $site_data['maintenance_message'];
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
        //$adv_data['maintenance'] = (isset($adv_data['maintenance'])) ? $adv_data['maintenance'] : '';
        $output .= '<div class="form-group"><label for="inputMessage">'.t('Maintenance message').':</label><br><textarea class="form-control" name="message">'.'</textarea></div>';
        $output .= '<input type="hidden" name="form-token" value="'.Token::generate().'">'
                . '<input type="hidden" name="form_id" value="setMaintenace">'
                . '<button type="submit" name="setMaintenance" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> '.  t('Save changes').'</button>'
                  .'</form>'
                . '</div>';
        return $output;
    }
    public static function search_meta() {
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
    public static function search_metaData() {
        //Form-ID = globalMetaData
        $form = new Form(System::getForm('globalMetaData'));
        $output = '<div class="page-head">'
                . '<h2>'.t('Meta tags').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                    . System::print_messages()
                . '<div class="col-md-12">'
                . $form->render()
                . '</div>';
        
        return $output;
    }
    public static function search_metaRedirect() {
        $get_url = splitURL();
        if(isset($get_url[4])) {
            if(is_numeric($get_url[4]) && isset($get_url[5])) {
                if($get_url[5] == 'edit') {
                    $output = self::search_metaRedirectEdit($get_url[4]);
                }
                else if($get_url[5] == 'delete') {
                    $output = self::search_metaRedirectDelete($get_url[4]);
                }
            }
            else if($get_url[4] == 'add') {
                $output = self::search_metaRedirectAdd();
            }
        }
        else {
            $count = DB::getInstance()->getAll('url_alias')->count();
            $limit = 25;
            $data = pagination($limit, 'url_alias', '*');
            $output = '<div class="page-head">'
                    . '<h2>'.t('URL Redirect').'</h2>'
                    . get_breadcrumb()
                    . '</div>'
                    . '<div class="cl-mcont">'
                        . System::print_messages()
                    . '<div class="col-md-12">'
                    . '<a href="/admin/settings/search/redirect/add"><span class="glyphicon glyphicon-plus"></span> '.t('Add redirect').'</a><br/><br/>';
            $output .= '<table class="table table-striped table-hover">'
                        . '<thead style="background-color: #CCC;">'
                             .'<tr>'
                                 .'<th><strong>'.t('From').'</strong></th>'
                                 .'<th><strong>'.t('To').'</strong></th>'
                                 .'<th><strong>'.t('Language').'</strong></th>'
                                 .'<th><strong>'.t('Actions').'</strong></th>'
                             .'</tr>'
                        . '</thead>'
                        . '<tbody>';
            foreach ($data['data'] as $alias) {
                $output .= '<tr>'
                            .'<td>'.$alias['source'].'</td>'
                            .'<td>'.$alias['alias'].'</td>'
                            .'<td>'.(($alias['language'] == 0)? t('All') : DB::getInstance()->getField('languages', 'name', 'code', $alias['language'])).'</td>'
                            .'<td>'
                                .'<a href="/admin/settings/search/redirect/'.$alias['aid'].'/edit" class="btn btn-rad btn-sm btn-default">'.t('Edit').'</a>'
                                .'<a href="/admin/settings/search/redirect/'.$alias['aid'].'/delete" class="btn btn-rad btn-sm btn-danger">'.t('Delete').'</a>'
                            .'</td>';
            }
            $output .= '</tbody></table>';
            $output .= (($count > $limit) ? $data['controls'] : '')
                    . '</div>';
        }
        return $output;
    }
    public static function search_metaRedirectAdd() {
        $form = new Form(System::getForm('addMetaRedirect'));
        $output = '<div class="page-head">'
                . '<h2>'.t('URL Redirect').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                    . System::print_messages()
                . '<div class="col-md-12">'
                . $form->render()
                . '</div>';
        
        return $output;
    }
    public static function search_metaRedirectEdit($aid) {
        $data = DB::getInstance()->get('url_alias', array('aid', '=', $aid))->first();
        $formdata = System::getForm('editMetaRedirect');
        $formdata['elements'][0]['#value'] = $data->source;
        $formdata['elements'][1]['#value'] = $data->alias;
        $form = new Form($formdata);
        $output = '<div class="page-head">'
                . '<h2>'.t('URL Redirect').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                    . System::print_messages()
                . '<div class="col-md-12">'
                . $form->render()
                . '</div>';
        
        return $output;
    }
    public static function search_metaRedirectDelete($aid) {
        //Call delete form
        return Form::formDelete(t('Delete URL Alias'), 'deleteMetaRedirect', $aid, DB::getInstance()->getField('url_alias', 'alias', 'aid', $aid), '/admin/settings/search/redirect', 'deleteMetaRedirect');
    }
    public static function search_errorPages() {
        //Form-ID = globalErrorPages
        $form = new Form(System::getForm('globalErrorPages'));
        $output = '<div class="page-head">'
                . '<h2>'.t('Error pages').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                    . System::print_messages()
                . '<div class="col-md-12">'
                . $form->render()
                . '</div>';
        
        return $output;
    }
    public static function language() {
        $get_url = splitURL();
        $output = '';
        if($get_url[3] == 'translate') {
            if(isset($get_url[4]) && isset($get_url[5]) && is_numeric($get_url[5])) {
                $output = self::translate();
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
                $limit = 25;
                $count = DB::getInstance()->getAll('translation');
                $data = pagination($limit, 'translation', '*');
                $translations = $data['data'];
                $output .= '<table class="table table-striped table-hover">'
                        . '<thead style="background-color: #CCC;">'
                             .'<tr>'
                                 .'<th><strong>'.t('Original string').'</strong></th>'
                                 .'<th><strong>'.t('Translation').'</strong></th>'
                                 .'<th></th>'
                             .'</tr>'
                        . '</thead>'
                        . '<tbody>';
                foreach($translations as $translation) {
                    $output .= '<tr>'
                                  .'<td>'.Sanitize::checkPlain($translation['string']).'</td>'
                                  .'<td>'.Sanitize::checkPlain($translation['translation']).'</td>'
                                  .'<td>'
                                      .'<a href="/admin/settings/language/translate/'.$translation['language'].'/'.$translation['tid'].'/edit" class="btn btn-rad btn-sm btn-default">'.t('Translate').'</a>'
                                  .'</td>';
                }
                $output .= '</tbody></table>';
                $output .= (($count > $limit) ? $data['controls'] : '');
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
    public static function translate() {
        $db = DB::getInstance();
        $get_url = splitURL();
        $translation = $db->query("SELECT * FROM `translation` WHERE `language`=? AND `tid`=?", array($get_url[4], $get_url[5]), PDO::FETCH_ASSOC)->first();
        $translation['translation'] = ((isset($translation['translation']) && !empty($translation['translation'])) OR (isset($translation['translation']) && $translation['translation'] != '')) ? $translation['translation'] : NULL;
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
                           .'<p class="form-control-static">'.$translation['string'].'</p>'
                       .'</div>'
                       .'<div class="form-group">'
                           .'<label for="inputTranslation">'.  t('Translated string').':</label><br/>'
                           .'<textarea class="form-control" name="translation">'.$translation['translation'].'</textarea>'
                       .'</div>'
                       .'<input type="hidden" name="t_id" value="'.$get_url[5].'">'
                       .'<input type="hidden" name="t_locale" value="'.$get_url[4].'">'
                       .'<input type="hidden" name="form-token" value="'.Token::generate().'">'
                       . '<input type="hidden" name="form_id" value="editTranslation">'
                       .'<div class="form-actions">'
                           .'<button type="submit" name="editTranslation" class="btn btn-rad btn-sm btn-primary">'.t('Save changes').'</button>'
                       .'</div>'
                 .'</form>'
                . '</div>';
        return $output;
    }
    function developmentCron() {
        $token = Token::generate();
        $intervals = array(
            0 => t('never'),
            1 => '1 '.t('hour'),
            3 => '3 '.t('hours'),
            6 => '6 '.t('hours'),
            12 => '12 '.t('hours'),
            24 => '1 '.t('day')
        );
        $options = '';
        $current = Config::get('site/cron');
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
                    .'<input type="hidden" name="form-token" value="'.$token.'">'
                    . '<input type="hidden" name="form_id" value="runCron">'
                    . '<button type="submit" name="runCron" class="btn btn-rad btn-default">'.t('Run cron').'</button>'
                . '</form>'
                . '<form method="POST" name="editCron" action="" role="form">'
                       .'<div class="form-group">'
                           .'<p>'.t('Run cron automatically each').' '
                           .'<select name="inputCronTime" class="select2">'
                              .$options
                           .'</select>'
                       .'</div>'
                       .'<input type="hidden" name="form-token" value="'.$token.'">'
                       .'<input type="hidden" name="form_id" value="editCron">'
                       .'<div class="form-actions">'
                           .'<button type="submit" name="editCron" class="btn btn-rad btn-sm btn-primary">'.t('Save changes').'</button>'
                       .'</div>'
                 .'</form>'
                . '</div>';
        
        return $output;
    }
}