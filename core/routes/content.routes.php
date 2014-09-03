<?php
/**
 * @file
 * Handles backend-routing related to content management
 */
if(has_permission('access_admin_content', Session::get(Config::get('session/session_name')))) {
    if($get_url[1] == 'content') {
        if(isset($get_url[2])) {
            if(isset($get_url[3])) {
                if($get_url[3] == 'edit') {
                    if(has_permission('access_admin_content_edit_own', Session::get(Config::get('session/session_name')))) {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        include_once INCLUDES_PATH.'/admin/edit.admin.php';
                    }
                    else {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        action_denied(true);
                    }
                }
                else if($get_url[3] == 'delete') {
                    if(has_permission('access_admin_content_delete_own', Session::get(Config::get('session/session_name')))) {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        include_once INCLUDES_PATH.'/admin/delete.admin.php';
                    }
                    else {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        action_denied(true);
                    }
                }
                else {
                    http_response_code(404);
                    include_once Theme::errorPage(404);
                }
            }
        }
        else {
            include_once INCLUDES_PATH.'/admin.inc.php';
            include_once INCLUDES_PATH.'/templates/content.admin.php';
        }
    }
    else {
        http_response_code(404);
        include_once Theme::errorPage(404);
    }
}
else {
    include_once INCLUDES_PATH.'/admin.inc.php';
    action_denied(true);
}