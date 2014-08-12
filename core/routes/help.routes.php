<?php
/**
 * @file
 * Handles backend-routing related to help and documentation
 */
if($get_url[1] == 'help') {
    if(isset($get_url[2])) {
        
    }
    else {
        include INCLUDES_PATH.'/admin.inc.php';
        include INCLUDES_PATH.'/templates/help.admin.php';
    }
}
else {
    http_response_code(404);
    include Theme::errorPage(404);
}
