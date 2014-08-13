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
    
}
function editPage_submit() {
    
}
function deletePage_submit() {
    
}
function deleteMenu_submit() {
    
}
function addMenuItem_submit() {
    
}
function editMenuItem_submit() {
    
}
function deleteMenuItem_submit() {
    
}
function applyTheme_submit() {
    
}
function editSections_submit() {
    
}
function addWidget_submit() {
    
}
function editWidget_submit() {
    
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
    
}
function editUser_submit() {
    
}
function editUserPassword_submit() {
    
}
function deleteUser_submit() {
    
}
function addRole_submit() {
    
}
function editPermissions_submit() {
    
}
