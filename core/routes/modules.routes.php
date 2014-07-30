<?php
/**
 * @file
 * Handles backend-routing for module management
 */
if($get_url[1] == 'modules') {
    if(isset($get_url[2])) {
        if(isset($get_url[3])) {
            if($get_url[3] == 'install') {
                include 'core/inc/admin.inc.php';
                include 'core/inc/admin/confirm.admin.php';
            }
            else if($get_url[3] == 'enable') {
                include 'core/inc/admin.inc.php';
                include 'core/inc/admin/confirm.admin.php';
            }
            else if($get_url[3] == 'config') {
                if(function_exists($get_url[2].'_config')) {
                    include 'core/inc/admin.inc.php';
                    print '<div class="page-head">'
                            . '<h2>'.getFieldFromDB('modules', 'module_hname', 'module_name', $get_url[2]).' '.t('Configuration').'</h2>'
                            . get_breadcrumb()
                        . '</div>'
                        . '<div class="cl-mcont">'
                            . '<div class="col-md-12">';
                    print call_user_func($get_url[2].'_config');
                    print '</div>';
                }
                else {
                    http_response_code(404);
                    include path_to_theme().'/404.php';
                }
            }
            else {
                http_response_code(404);
                include path_to_theme().'/404.php';
            }
        }
        else {
            include 'core/inc/admin.inc.php';
            include 'core/inc/templates/modules.admin.php';
        }
    }
    else {
        include 'core/inc/admin.inc.php';
        include 'core/inc/templates/modules.admin.php';
    }
}
else {
    http_response_code(404);
    include path_to_theme().'/404.php';
}