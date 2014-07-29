<?php
$get_url = splitURL();
$csrf = Csrf::addCsrf();
$token_id = $csrf->get_token_id();
if(isset($get_url[1])) {
    $route = false;
    $mod_route = false;
    //Determine if a module has a route corresponding to this path
    foreach (Modules::activeModules() as $module) {
        //print 'module-custom-path-each-begin';
        if(Modules::module_route($module)) {
            //$mod_route = true;
            $function = $module['module'].'_route';
            
            if($function(implode('/', $get_url)) != FALSE) {
                $mod_route = true;
                include 'core/inc/admin.inc.php';
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
                include 'content.routes.php';
                break;
            case 'layout':
                $route = true;
                include 'layout.routes.php';
                break;
            case 'modules':
                $route = true;
                include 'modules.routes.php';
                break;
            case 'users':
                $route = true;
                include 'users.routes.php';
                break;
            case 'settings':
                $route = true;
                include 'settings.routes.php';
                break;
            case 'help':
                $route = true;
                include 'help.routes.php';
                break;
            default:
                http_response_code(404);
                include path_to_theme().'/404.php';
                break;
        }
    }
}
else {
    include 'core/inc/admin.inc.php';
    include 'core/inc/templates/admin.php';
}
include_once path_to_theme().'/footer.tpl.php';