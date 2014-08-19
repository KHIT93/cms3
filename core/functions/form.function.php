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
function addPage_submit() {
    Page::create($_POST);
}
function editPage_submit() {
    Page::update($_POST);
}
function deletePage_submit() {
    Page::delete($_POST['inputId']);
}
function deleteMenu_submit() {
    Menu::delete($_POST['inputId']);
}
function addMenuItem_submit() {
    Menu::addMenuItem($_POST);
}
function editMenuItem_submit() {
    Menu::updateMenuItem($_POST);
}
function deleteMenuItem_submit() {
    Menu::deleteMenuItem($_POST['inputId']);
}
function applyTheme_submit() {
    Theme::applyTheme($_POST['inputTheme']);
}
function editSections_submit() {
    addMessage('info',print_r($_POST));
}
function addWidget_submit() {
    Widget::createWidget($_POST);
}
function editWidget_submit() {
    Widget::updateWidget($_POST);
}
function enableModule_submit() {
    
}
function disableModule_submit() {
    
}
function installModule_submit() {
    
}
function uninstallModule_submit() {
    
}
function addUser_submit() {
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
}
function editUser_submit() {
    $fields = array(
        'username' => $_POST['username'],
        'role' => $_POST['role'],
        'email' => $_POST['email'],
        'name' => $_POST['name'],
        'language' => $_POST['language']
    );
    $update_user = User::getInstance();
    $update_user->update($fields, $_POST['uid']);
}
function editUserPassword_submit() {
    $fields = array(
        'password' => Hash::makePassHash($_POST['password'])
    );
    $update_user = User::getInstance();
    $update_user->update($fields, $_POST['uid']);
}
function deleteUser_submit() {
    $delete_user = User::getInstance();
    $delete_user->delete($_POST['inputId']);
}
function addRole_submit() {
    Permission::add_role($_POST);
}
function editPermissions_submit() {
    Permission::updatePermissions($_POST);
}
