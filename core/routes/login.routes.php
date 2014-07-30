<?php
/**
 * @file
 * Handles routing for login and registration
 */
$get_url = splitURL();
if(isset($get_url[1]) && $get_url[1] == 'register') {
    include 'core/inc/register.inc.php';
}
else if($get_url[0] == 'login') {
    include 'core/inc/login.inc.php';
}
else {
    http_response_code(404);
    include path_to_theme().'/404.php';
}