<?php
/**
 * @file
 * Handles backend-routing for settings and configuration
 */
include_once INCLUDES_PATH.'/admin.inc.php';
if(has_permission('access_admin_settings', Session::get(Config::get('session/session_name')))) {
    $settings = new Settings();
    if(isset($get_url[2])) {
        //Find correct settings page
        switch ($get_url[2]) {
            case 'system':
                if(isset($get_url[3])) {
                    switch($get_url[3]) {
                        case 'users':
                            print Settings::systemUsers();
                        break;
                        case 'systemcheck':
                            print Settings::systemCheck();
                        break;
                        default :
                            http_response_code(404);
                            Theme::errorPage(404);
                        break;
                    }
                }
                else {
                    print Settings::system();
                }
            break;
            case 'content':
                if(isset($get_url[3])) {
                    switch($get_url[3]) {
                        case 'wysiwyg':
                            print Settings::contentWysiwyg();
                        break;
                        default :
                            http_response_code(404);
                            include_once path_to_theme().'/404.php';
                        break;
                    }
                }
                else {
                    http_response_code(404);
                    include_once path_to_theme().'/404.php';
                }
            break;
            case 'development':
                if(isset($get_url[3])) {
                    switch($get_url[3]) {
                        case 'maintenance':
                            print Settings::developmentMaintenance();
                        break;
                        case 'db':
                            print Settings::developmentDBManagement();
                        break;
                        default :
                            http_response_code(404);
                            include_once path_to_theme().'/404.php';
                        break;
                    }
                }
                else {
                    print Settings::development();
                }

            break;
            case 'search':
                if(isset($get_url[3])) {
                    switch($get_url[3]) {
                        case 'redirect':
                            print Settings::search_metaRedirect();
                        break;
                        case 'metadata':
                            print Settings::search_metaData();
                        break;
                        case 'error-pages':
                            print Settings::search_errorPages();
                        break;
                        default :
                            http_response_code(404);
                            include_once path_to_theme().'/404.php';
                        break;
                    }
                }
                else {
                    http_response_code(404);
                    include_once path_to_theme().'/404.php';
                }
            break;
            case 'language':
                print Settings::language();
            break;
            case 'cron':
                print Settings::developmentCron();
            break;
            default :
                http_response_code(404);
                include_once path_to_theme().'/404.php';
            break;
        }
    }
    else {
        print '<div class="page-head">'.get_breadcrumb().'</div><div class="cl-mcont">'.implode('', Settings::settingList());
        //krumo(Settings::settingList());
    }
}
else {
    action_denied(true);
}