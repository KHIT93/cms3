<?php
/**
 * @file
 * Handles backend-routing related to content management
 */
if($get_url[1] == 'content') {
    if(isset($get_url[2])) {
        if(isset($get_url[3])) {
            if($get_url[3] == 'edit') {
                include 'core/inc/admin.inc.php';
                include 'core/inc/admin/edit.admin.php';
            }
            else if($get_url[3] == 'delete') {
                include 'core/inc/admin.inc.php';
                include 'core/inc/admin/delete.admin.php';
            }
            else {
                http_response_code(404);
                include path_to_theme().'/404.php';
            }
        }
    }
    else {
        include 'core/inc/admin.inc.php';
        include 'core/inc/templates/content.admin.php';
    }
}
else {
    http_response_code(404);
    include path_to_theme().'/404.php';
}
