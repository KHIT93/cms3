<?php
/**
 * @file
 * Handles backend-routing related to help and documentation
 */
if($get_url[1] == 'help') {
    if(isset($get_url[2])) {
        
    }
    else {
        include 'core/inc/admin.inc.php';
        include 'core/inc/templates/help.admin.php';
    }
}
else {
    http_response_code(404);
    include path_to_theme().'/404.php';
}
