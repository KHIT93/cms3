<?php
/**
 * @file
 * Handles initial routing the backend
 */
if(has_permission('access_admin', Session::get(Config::get('session/session_name')))) {
    $get_url = splitURL();
    if(isset($get_url[1])) {
        $route = false;
        $mod_route = false;
        //Determine if a module has a route corresponding to this path
        foreach (Module::activeModules() as $module) {
            //print 'module-custom-path-each-begin';
            if(Module::module_route($module)) {
                //$mod_route = true;
                $function = $module['module'].'_route';

                if($function(implode('/', $get_url)) != FALSE) {
                    $mod_route = true;
                    include_once INCLUDES_PATH.'/admin.inc.php';
                    $function = $module['module'].'_route';
                    print $function(implode('/', $get_url));
                }
                else {
                    $mod_route = false;
                }
            }
        }
        $route = ($mod_route === false) ? false : true;
        if($route === FALSE) {
            switch ($get_url[1]) {
                case 'content':
                    $route = true;
                    include_once 'content.routes.php';
                    break;
                case 'layout':
                    $route = true;
                    include_once 'layout.routes.php';
                    break;
                case 'modules':
                    $route = true;
                    include_once 'modules.routes.php';
                    break;
                case 'users':
                    $route = true;
                    include_once 'users.routes.php';
                    break;
                case 'settings':
                    $route = true;
                    include_once 'settings.routes.php';
                    break;
                case 'help':
                    $route = true;
                    include_once 'help.routes.php';
                    break;
                case 'reports':
                    $route = true;
                    include_once 'reports.routes.php';
                    break;
                case 'editor':
                    include_once 'editor.routes.php';
                break;
                default:
                    http_response_code(404);
                    Theme::errorPage(404);
                    break;
            }
        }
    }
    else {
        include_once INCLUDES_PATH.'/admin.inc.php';
        include_once INCLUDES_PATH.'/templates/admin.php';
    }
    include_once Theme::path_to_theme().'/footer.tpl.php';
}
else {
    include_once INCLUDES_PATH.'/admin.inc.php';
    action_denied(true);
    include_once Theme::path_to_theme().'/footer.tpl.php';
}