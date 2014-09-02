<?php
/**
 * @file
 * Handles routing for login and registration
 */
$get_url = splitURL();
if(isset($get_url[1]) && $get_url[1] == 'register') {
    include_once INCLUDES_PATH.'/register.inc.php';
}
else if($get_url[0] == 'login') {
    include_once INCLUDES_PATH.'/login.inc.php';
}
else {
    http_response_code(404);
    include_once Theme::errorPage(404);
}