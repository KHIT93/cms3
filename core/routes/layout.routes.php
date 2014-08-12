<?php
/**
 * @file
 * Handles backend-routing for layout, menus, themes and widgets
 */
if($get_url[1] == 'layout') {
    if(isset($get_url[2])) {
        if($get_url[2] == 'menus') {
            if(isset($get_url[3])) {
                if($get_url[4] == 'links') {
                    include INCLUDES_PATH.'/admin.inc.php';
                    include INCLUDES_PATH.'/admin/links.admin.php';
                }
                else if(isset ($get_url[5])) {
                    if($get_url[5] == 'edit') {
                        include INCLUDES_PATH.'/admin.inc.php';
                        include INCLUDES_PATH.'/admin/edit.admin.php';
                    }
                    else if($get_url[5] == 'delete') {
                        include INCLUDES_PATH.'/admin.inc.php';
                        include INCLUDES_PATH.'/admin/delete.admin.php';
                    }
                }
            }
            else {
                include INCLUDES_PATH.'/admin.inc.php';
                include INCLUDES_PATH.'/templates/menus.layout.php';
            }
        }
        else if($get_url[2] == 'widgets') {
            if($get_url[3] == 'add') {
                include INCLUDES_PATH.'/admin.inc.php';
                print Widgets::createWidgetForm();
            }
            else if(is_numeric($get_url[3])) {
                if($get_url[4] == 'edit') {
                    include INCLUDES_PATH.'/admin.inc.php';
                    print Widgets::updateWidgetForm($get_url[3]);
                }
                else if($get_url[4] == 'delete') {
                    include INCLUDES_PATH.'/admin.inc.php';
                    print Forms::form_delete(t('Delete widget'), 'deleteWidget', $get_url[3], getFieldFromDB('widgets', 'widget_title', 'widget_id', $get_url[3]), site_root().'/admin/layout/widgets');
                }
            }
            else {
                include INCLUDES_PATH.'/admin.inc.php';
                include INCLUDES_PATH.'/templates/widgets.layout.php';
            }
        }
        else if($get_url[2] == 'themes') {
            if($get_url[2] == 'themes' && $get_url[4] == 'apply') {
                include INCLUDES_PATH.'/admin.inc.php';
                include INCLUDES_PATH.'/admin/confirm.admin.php';
            }
            else {
                include INCLUDES_PATH.'/admin.inc.php';
                include INCLUDES_PATH.'/templates/themes.layout.php';
            }
        }
        else {
            if($route == FALSE) {
                $mod_route = false;
                //Determine if a module has a route corresponding to this path
                foreach (Modules::activeModules() as $module) {
                    if(Modules::module_route($module, implode('/', $get_url))) {
                        call_user_func($module['module'].'_route', implode('/', $get_url));
                        $mod_route = true;
                        break;
                    }
                }
                if($mod_route === FALSE) {
                    http_response_code(404);
                    include Theme::errorPage(404);
                    exit();
                }
            }
        }
    }
    else {
        include INCLUDES_PATH.'/admin.inc.php';
        include INCLUDES_PATH.'/templates/layout.admin.php';
    }
}
else {
    http_response_code(404);
    include Theme::errorPage(404);
}