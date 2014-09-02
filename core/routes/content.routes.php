<?php
/**
 * @file
 * Handles backend-routing related to content management
 */
if($get_url[1] == 'content') {
    if(isset($get_url[2])) {
        if(isset($get_url[3])) {
            if($get_url[3] == 'edit') {
                include INCLUDES_PATH.'/admin.inc.php';
                include INCLUDES_PATH.'/admin/edit.admin.php';
            }
            else if($get_url[3] == 'delete') {
                include INCLUDES_PATH.'/admin.inc.php';
                include INCLUDES_PATH.'/admin/delete.admin.php';
            }
            else {
                http_response_code(404);
                include Theme::errorPage(404);
            }
        }
    }
    else {
        include INCLUDES_PATH.'/admin.inc.php';
        include INCLUDES_PATH.'/templates/content.admin.php';
    }
}
else {
    http_response_code(404);
    include Theme::errorPage(404);
}
