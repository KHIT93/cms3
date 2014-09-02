<?php
/**
 * @file
 * Handles routing related to user management
 */
if(has_permission('access_admin_users', Session::get(Config::get('session/session_name')))) {
    if($get_url[1] == 'users') {
        if(isset($get_url[2])) {
            if(isset($get_url[3])) {
                if($get_url[3] == 'edit') {
                    include_once INCLUDES_PATH.'/admin.inc.php';
                    include_once INCLUDES_PATH.'/admin/edit.admin.php';
                }
                else if($get_url[3] == 'delete') {
                    include_once INCLUDES_PATH.'/admin.inc.php';
                    include_once INCLUDES_PATH.'/admin/delete.admin.php';
                }
                else if($get_url[3] == 'enable') {
                    include_once INCLUDES_PATH.'/admin.inc.php';
                    include_once INCLUDES_PATH.'/admin/confirm.admin.php';
                }
                else if($get_url[3] == 'disable') {
                    include_once INCLUDES_PATH.'/admin.inc.php';
                    include_once INCLUDES_PATH.'/admin/confirm.admin.php';
                }
            }
        }
        else {
            include_once INCLUDES_PATH.'/admin.inc.php';
            include_once INCLUDES_PATH.'/templates/users.admin.php';
        }
    }
    else {
        http_response_code(404);
        include_once path_to_theme().'/404.php';
    }
}
else {
    include_once INCLUDES_PATH.'/admin.inc.php';
    action_denied(true);
}