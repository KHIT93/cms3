<?php
if($get_url[1] == 'layout') {
    if(isset($get_url[2])) {
        if($get_url[2] == 'menus') {
            if(isset($get_url[3])) {
                if($get_url[4] == 'links') {
                    include 'core/inc/admin.inc.php';
                    include 'core/inc/admin/links.admin.php';
                }
                else if(isset ($get_url[5])) {
                    if($get_url[5] == 'edit') {
                        include 'core/inc/admin.inc.php';
                        include 'core/inc/admin/edit.admin.php';
                    }
                    else if($get_url[5] == 'delete') {
                        include 'core/inc/admin.inc.php';
                        include 'core/inc/admin/delete.admin.php';
                    }
                }
            }
            else {
                include 'core/inc/admin.inc.php';
                include 'core/inc/templates/menus.layout.php';
            }
        }
        else if($get_url[2] == 'widgets') {
            if($get_url[3] == 'add') {
                include 'core/inc/admin.inc.php';
                print Widgets::createWidgetForm();
            }
            else if(is_numeric($get_url[3])) {
                if($get_url[4] == 'edit') {
                    include 'core/inc/admin.inc.php';
                    print Widgets::updateWidgetForm($get_url[3]);
                }
                else if($get_url[4] == 'delete') {
                    include 'core/inc/admin.inc.php';
                    print Forms::form_delete(t('Delete widget'), 'deleteWidget', $get_url[3], getFieldFromDB('widgets', 'widget_title', 'widget_id', $get_url[3]), site_root().'/admin/layout/widgets');
                }
            }
            else {
                include 'core/inc/admin.inc.php';
                include 'core/inc/templates/widgets.layout.php';
            }
        }
        else if($get_url[2] == 'themes') {
            if($get_url[2] == 'themes' && $get_url[4] == 'apply') {
                include 'core/inc/admin.inc.php';
                include 'core/inc/admin/confirm.admin.php';
            }
            else {
                include 'core/inc/admin.inc.php';
                include 'core/inc/templates/themes.layout.php';
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
                    include path_to_theme().'/404.php';
                    exit();
                }
            }
        }
    }
    else {
        include 'core/inc/admin.inc.php';
        include 'core/inc/templates/layout.admin.php';
    }
}
else {
    http_response_code(404);
    include path_to_theme().'/404.php';
}