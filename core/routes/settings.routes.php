<?php
/**
 * @file
 * Handles backend-routing for settings and configuration
 */
include 'core/inc/admin.inc.php';
$settings = new Settings();
if(isset($get_url[2])) {
    //Find correct settings page
    switch ($get_url[2]) {
        case 'system':
            if(isset($get_url[3])) {
                switch($get_url[3]) {
                    case 'users':
                        print $settings->systemUsers();
                    break;
                    case 'systemcheck':
                        print $settings->systemCheck();
                    break;
                    default :
                        http_response_code(404);
                        include path_to_theme().'/404.php';
                    break;
                }
            }
            else {
                print $settings->system();
            }
        break;
        case 'content':
            if(isset($get_url[3])) {
                switch($get_url[3]) {
                    case 'wysiwyg':
                        print $settings->contentWysiwyg();
                    break;
                    default :
                        http_response_code(404);
                        include path_to_theme().'/404.php';
                    break;
                }
            }
            else {
                http_response_code(404);
                include path_to_theme().'/404.php';
            }
        break;
        case 'development':
            if(isset($get_url[3])) {
                switch($get_url[3]) {
                    case 'maintenance':
                        print $settings->developmentMaintenance();
                    break;
                    default :
                        http_response_code(404);
                        include path_to_theme().'/404.php';
                    break;
                }
            }
            else {
                print $settings->development();
            }
            
        break;
        case 'search':
            if(isset($get_url[3])) {
                switch($get_url[3]) {
                    case 'redirect':
                        print $settings->search_metaRedirect();
                    break;
                    case 'metadata':
                        print $settings->search_metaData();
                    break;
                    case 'error-pages':
                        print $settings->search_errorPages();
                    break;
                    default :
                        http_response_code(404);
                        include path_to_theme().'/404.php';
                    break;
                }
            }
            else {
                http_response_code(404);
                include path_to_theme().'/404.php';
            }
        break;
        case 'language':
            print $settings->language();
        break;
        case 'cron':
            print $settings->developmentCron();
        break;
        default :
            http_response_code(404);
            include path_to_theme().'/404.php';
        break;
    }
}
else {
    print '<div class="page-head">'.get_breadcrumb().'</div><div class="cl-mcont">'.implode('', $settings->settingList());
    //krumo($settings->settingList());
}