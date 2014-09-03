<?php
function formBootstrapping($formdata) {
    Form::submit($formdata);
}
function form_delete($title, $name, $value, $item, $return_url) {
    Form::formDelete($title, $name, $value, $item, $return_url);
}


//Submit handlers
function user_login_submit() {
    $user = new User();
    if($user->login(Input::get('username'), Input::get('password'), Input::get('remember-me'))) {
        System::addMessage('success', t('You have been successfully logged in'));
        Redirect::to('/admin');
    }
    else {
        System::addMessage('error', t('Login failed. Please check username and password'));
    }
}
function user_register_submit() {
    
}
function addPage_submit() {
    if(has_permission('access_admin_content_add', Session::get(Config::get('session/session_name')))) {
        Page::create($_POST);
        Redirect::to('/admin/content');
    }
    else {
        action_denied();
    }
}
function editPage_submit() {
    if(User::getInstance()->uid() == DB::getInstance()->getField('pages', 'author', 'pid', $_POST['pid'])) {
        if(has_permission('access_admin_content_edit_own', Session::get(Config::get('session/session_name')))) {
            Page::update($_POST);
            Redirect::to('/admin/content');
        }
        else {
            action_denied();
        }
    }
    else {
        if(has_permission('access_admin_content_edit_all', Session::get(Config::get('session/session_name')))) {
            Page::update($_POST);
            Redirect::to('/admin/content');
        }
        else {
            action_denied();
        }
    }
}
function deletePage_submit() {
    if(User::getInstance()->uid() == DB::getInstance()->getField('pages', 'author', 'pid', $_POST['pid'])) {
        if(has_permission('access_admin_content_delete_own', Session::get(Config::get('session/session_name')))) {
            Page::delete($_POST['inputId']);
            Redirect::to('/admin/content');
        }
        else {
            action_denied();
        }
    }
    else {
        if(has_permission('access_admin_content_delete_all', Session::get(Config::get('session/session_name')))) {
            Page::delete($_POST['inputId']);
            Redirect::to('/admin/content');
        }
        else {
            action_denied();
        }
    }
    
}
function deleteMenu_submit() {
    if(has_permission('access_admin_layout_menus_delete', Session::get(Config::get('session/session_name')))) {
        Menu::delete($_POST['inputId']);
        Redirect::to('/admin/layout/menus');
    }
    else {
        action_denied();
    }
}
function addMenuItem_submit() {
    if(has_permission('access_admin_layout_menus_items_add', Session::get(Config::get('session/session_name')))) {
        Menu::addMenuItem($_POST);
        Redirect::to('/admin/layout/menus/'.Input::get('mid').'/items');
    }
    else {
        action_denied();
    }
}
function editMenuItem_submit() {
    if(has_permission('access_admin_layout_menus_items_edit', Session::get(Config::get('session/session_name')))) {
        Menu::updateMenuItem($_POST);
        Redirect::to('/admin/layout/menus/'.Input::get('mid').'/items');
    }
    else {
        action_denied();
    }
}
function deleteMenuItem_submit() {
    if(has_permission('access_admin_layout_menus_items_delete', Session::get(Config::get('session/session_name')))) {
        Menu::deleteMenuItem($_POST['inputId']);
        Redirect::to('/admin/layout/menus/'.Input::get('mid').'/items');
    }
    else {
        action_denied();
    }
}
function applyTheme_submit() {
    if(has_permission('access_admin_layout_themes_change', Session::get(Config::get('session/session_name')))) {
        Theme::applyTheme($_POST['inputTheme']);
        Redirect::to('/admin/layout/themes');
    }
    else {
        action_denied();
    }
}
function editSections_submit() {
    if(has_permission('access_admin_layout_widgets_move', Session::get(Config::get('session/session_name')))) {
        addMessage('warning', t('Submit handler is missing'));
        //Redirect::to('/admin/layout/widgets');
        //krumo($_POST);
    }
    else {
        action_denied();
    }
}
function addWidget_submit() {
    if(has_permission('access_admin_layout_widgets_add', Session::get(Config::get('session/session_name')))) {
        Widget::createWidget($_POST);
        Redirect::to('/admin/layout/widgets');
    }
    else {
        action_denied();
    }
}
function editWidget_submit() {
    if(has_permission('access_admin_layout_widgets_edit', Session::get(Config::get('session/session_name')))) {
        Widget::updateWidget($_POST);
        Redirect::to('/admin/layout/widgets');
    }
    else {
        action_denied();
    }
}
function enableModule_submit() {
    if(has_permission('access_admin_modules_enable', Session::get(Config::get('session/session_name')))) {
        $core = ($formdata['inputModuleCore'] == 'core') ? true : false;
        Module::enable($formdata['inputModule'], $core);
        Redirect::to('/admin/modules');
    }
}
function disableModule_submit() {
    if(has_permission('access_admin_modules_disable', Session::get(Config::get('session/session_name')))) {
        $core = ($formdata['inputModuleCore'] == 'core') ? true : false;
        Module::disable($formdata['inputModule'], $core);
        Redirect::to('/admin/modules');
    }
}
function installModule_submit() {
    if(has_permission('access_admin_modules_install', Session::get(Config::get('session/session_name')))) {
        $core = ($formdata['inputModuleCore'] == 'core') ? true : false;
        Module::install($formdata['inputModule'], $core);
        Redirect::to('/admin/modules');
    }
}
function uninstallModule_submit() {
    if(has_permission('access_admin_modules_uninstall', Session::get(Config::get('session/session_name')))) {
        $core = ($formdata['inputModuleCore'] == 'core') ? true : false;
        Module::unInstall($formdata['inputModule'], $core);
        Redirect::to('/admin/modules');
    }
}
function addUser_submit() {
    if(has_permission('access_admin_users_add', Session::get(Config::get('session/session_name')))) {
        $fields = array(
            'username' => $_POST['username'],
            'password' => Hash::makePassHash($_POST['password']),
            'role' => $_POST['role'],
            'email' => $_POST['email'],
            'name' => $_POST['name'],
            'language' => $_POST['language']
        );
        $add_user = User::getInstance();
        $add_user->create($fields);
        Redirect::to('/admin/users');
    }
    else {
        action_denied();
    }
}
function editUser_submit() {
    if(User::getInstance()->uid() == DB::getInstance()->getField('pages', 'author', 'pid', $_POST['pid'])) {
        if(has_permission('access_admin_users_edit_own', Session::get(Config::get('session/session_name')))) {
            $fields = array(
                'username' => $_POST['username'],
                'role' => $_POST['role'],
                'email' => $_POST['email'],
                'name' => $_POST['name'],
                'language' => $_POST['language']
            );
            $update_user = User::getInstance();
            $update_user->update($fields, $_POST['uid']);
            Redirect::to('/admin/users');
        }
        else {
            action_denied();
        }
    }
    else {
        if(has_permission('access_admin_users_edit_all', Session::get(Config::get('session/session_name')))) {
            $fields = array(
                'username' => $_POST['username'],
                'role' => $_POST['role'],
                'email' => $_POST['email'],
                'name' => $_POST['name'],
                'language' => $_POST['language']
            );
            $update_user = User::getInstance();
            $update_user->update($fields, $_POST['uid']);
            Redirect::to('/admin/users');
        }
        else {
            action_denied();
        }
    }
    
}
function editUserPassword_submit() {
    if(User::getInstance()->uid() == DB::getInstance()->getField('pages', 'author', 'pid', $_POST['pid'])) {
        if(has_permission('accces_admin_users_change_password_own', Session::get(Config::get('session/session_name')))) {
            $fields = array(
                'password' => Hash::makePassHash($_POST['password'])
            );
            $update_user = User::getInstance();
            $update_user->update($fields, $_POST['uid']);
            Redirect::to('/admin/users');
        }
        else {
            action_denied();
        }
    }
    else {
        if(has_permission('access_admin_users_change_password_all', Session::get(Config::get('session/session_name')))) {
            $fields = array(
                'password' => Hash::makePassHash($_POST['password'])
            );
            $update_user = User::getInstance();
            $update_user->update($fields, $_POST['uid']);
            Redirect::to('/admin/users');
        }
        else {
            action_denied();
        }
    }
    
}
function deleteUser_submit() {
    if(has_permission('access_admin_content_delete_own', Session::get(Config::get('session/session_name')))) {
        $delete_user = User::getInstance();
        $delete_user->delete($_POST['inputId']);
        Redirect::to('/admin/users');
    }
    else {
        action_denied();
    }
}
function enableUser_submit() {
    
}
function disableUser_submit() {
    
}
function addRole_submit() {
    if(has_permission('access_admin_users_roles_add', Session::get(Config::get('session/session_name')))) {
        Permission::add_role($_POST);
        Redirect::to('/admin/users');
    }
    else {
        action_denied();
    }
}
function editPermissions_submit() {
    if(has_permission('access_admin_users_permissions_change', Session::get(Config::get('session/session_name')))) {
        Permission::updatePermissions($_POST);
        Redirect::to('/admin/users');
    }
    else {
        action_denied();
    }
}
function editTranslation_submit() {
    if(has_permission('access_admin_settings_language_translate_edit', Session::get(Config::get('session/session_name'))) === true) {
        String::saveTranslation($_POST);
        Redirect::to('/admin/settings/language/translate');
    }
    else {
        action_denied();
    }
}
function templateEditor_submit() {
    if(has_permission('access_admin_editor', Session::get(Config::get('session/session_name')))) {
        Editor::submit('template', $_POST);
        Redirect::to('/admin');
    }
    else {
        action_denied();
    }
}
function editSite_submit() {
    
}
function globalUser_submit() {
    
}
function enableWysiwyg_submit() {
    //May be removed later
}
function setDevMode_submit() {
    
}
function setMaintenance_submit() {
    
}
function runCron_submit() {
    
}
function editCron_submit() {
    
}