<?php
/**
 * @file
 * Handles backend-routing for module management
 */
if(has_permission('access_admin_modules', Session::get(Config::get('session/session_name')))) {
    if($get_url[1] == 'modules') {
        if(isset($get_url[2])) {
            if(isset($get_url[3])) {
                if($get_url[3] == 'install') {
                    if(has_permission('access_admin_modules_install', Session::get(Config::get('session/session_name')))) {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        include_once INCLUDES_PATH.'/admin/confirm.admin.php';
                    }
                    else {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        action_denied(true);
                    }
                }
                else if($get_url[3] == 'uninstall') {
                    if(has_permission('access_admin_modules_uninstall', Session::get(Config::get('session/session_name')))) {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        include_once INCLUDES_PATH.'/admin/confirm.admin.php';
                    }
                    else {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        action_denied(true);
                    }
                }
                else if($get_url[3] == 'enable') {
                    if(has_permission('access_admin_modules_enable', Session::get(Config::get('session/session_name')))) {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        include_once INCLUDES_PATH.'/admin/confirm.admin.php';
                    }
                    else {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        action_denied(true);
                    }
                }
                else if($get_url[3] == 'disable') {
                    if(has_permission('access_admin_modules_disable', Session::get(Config::get('session/session_name')))) {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        include_once INCLUDES_PATH.'/admin/confirm.admin.php';
                    }
                    else {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        action_denied(true);
                    }
                }
                else if($get_url[3] == 'config') {
                    if(function_exists($get_url[2].'_config')) {
                        include_once INCLUDES_PATH.'/admin.inc.php';
                        print '<div class="page-head">'
                                . '<h2>'.t('@name Configuration', array('@name' => DB::getInstance()->getField('modules', 'name', 'module', $get_url[2]))).'</h2>'
                                . get_breadcrumb()
                            . '</div>'
                            . '<div class="cl-mcont">'
                                . '<div class="col-md-12">';
                        print call_user_func($get_url[2].'_config');
                        print '</div>';
                    }
                    else {
                        http_response_code(404);
                        include_once Theme::errorPage(404);
                    }
                }
                else {
                    http_response_code(404);
                    include_once Theme::errorPage(404);
                }
            }
            else {
                include_once INCLUDES_PATH.'/admin.inc.php';
                include_once INCLUDES_PATH.'/templates/modules.admin.php';
            }
        }
        else {
            include_once INCLUDES_PATH.'/admin.inc.php';
            include_once INCLUDES_PATH.'/templates/modules.admin.php';
        }
    }
    else {
        http_response_code(404);
        Theme::errorPage(404);
    }
}
else {
    include_once INCLUDES_PATH.'/admin.inc.php';
    action_denied(true);
}