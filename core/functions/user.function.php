<?php
/**
 * @file
 * Functions for users
 */
function rand_str($lenght, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
    $str = '';
    $count = strlen($charset);
    while($lenght--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}
function getSaltedHash($password) {
    return Hash::makePassHash($password);
}
function MakeRandPass($upper = 3, $lower = 3, $numeric = 3, $other = 2) {
    return User::MakeRandPass($upper, $lower, $numeric, $other);
}
function logged_in() {
    return (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) ? true: false;
}
function not_active_logout() {
    session_destroy();
    addMessage('error', t('You have been logged out because your account is not activated'));
}
function user_login_validate() {
    return form_validate(array(
        'username' => array('required' => true),
        'password' => array('required' => true)
        ));
}
function user_login_submit($formdata) {
    $user = new User();
    if($user->login(Input::get('username'), Input::get('password'), Input::get('remember-me'))) {
        System::addMessage('info', 'Login success');
        Redirect::to('/admin');
    }
    else {
        System::addMessage('info', 'Login failed');
    }
    
    
}