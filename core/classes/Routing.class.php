<?php
/**
 * @file
 * Handles path-based routing
 */
class Routing {
    public static function frontend($url) {
        if($url[0] == 'login') {
            if(isset($_SESSION['logged_in'])) {
                if(has_permission('access_admin', $_SESSION['uid']) === true) {
                    Redirect::to(site_root().'/admin');
                    header('Location: '.site_root().'/admin');
                    exit();
                }
                else {
                    header('Location: '.site_root());
                    exit();
                }
            }
        }
        else if($url[0] == 'maintenance') {
            http_response_code(503);
            include 'maintenance.php';
            die();
        }
        else if($url[0] == 'logout') {
            log_out();
            header('Location: '.site_root());
            exit();
        }
        else {
            throw new PageNotFoundException(t('No content was found at @url', array('@url' => $url)));
        }
    }
    public static function backend($url) {
        if($url[0] == 'login') {
            if(isset($_SESSION['logged_in'])) {
                if(has_permission('access_admin', $_SESSION['uid']) === true) {
                    header('Location: /admin');
                    exit();
                }
                else {
                    header('Location: '.site_root());
                    exit();
                }
            }
            else {
                include_once 'core/routes/login.routes.php';
            }
        }
        else if($url[0] == 'admin') {
            if(!Session::exists(Config::get('session/session_name'))) {
                http_response_code(403);
                Theme::errorPage(403);
                exit();
            }
            else {
                if(has_permission('access_admin', Session::get(Config::get('session/session_name'))) === true) {
                    include_once 'core/routes/admin.routes.php';
                }
                else {
                    http_response_code(403);
                    Theme::errorPage(403);
                    exit();
                }
            }
        }
        else if($url[0] == 'logout') {
            log_out();
            Redirect::to('/home');
            exit();
        }
        else {
            throw new PageNotFoundException(t('No content was found at @url', array('@url' => $url)));
        }
    }
    public static function moduleRoute($module) {
       if(Module::moduleImplements($module, 'route')) {
           //call_user_func($module.'_route', $path);
           return true;
       }
       else {
           return false;
       }
   }
}