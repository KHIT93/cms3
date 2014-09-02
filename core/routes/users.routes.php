<?php
/**
 * @file
 * Handles routing related to user management
 */
if($get_url[1] == 'users') {
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
            else if($get_url[3] == 'enable') {
                include INCLUDES_PATH.'/admin.inc.php';
                include INCLUDES_PATH.'/admin/confirm.admin.php';
            }
            else if($get_url[3] == 'disable') {
                include INCLUDES_PATH.'/admin.inc.php';
                include INCLUDES_PATH.'/admin/confirm.admin.php';
            }
        }
    }
    else {
        include INCLUDES_PATH.'/admin.inc.php';
        include INCLUDES_PATH.'/templates/users.admin.php';
    }
}
else {
    http_response_code(404);
    include path_to_theme().'/404.php';
}