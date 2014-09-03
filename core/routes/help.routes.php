<?php
/**
 * @file
 * Handles backend-routing related to help and documentation
 */
if($get_url[1] == 'help') {
    if(isset($get_url[2])) {
        if($get_url[2] == 'core') {
            $function = $get_url[3].'Help';
            print Help::$function();
        }
        if($get_url[2] == 'modules') {
            $function = $get_url[3].'_help';
            print $function();
        }
    }
    else {
        include INCLUDES_PATH.'/admin.inc.php';
        include INCLUDES_PATH.'/templates/help.admin.php';
    }
}
else {
    http_response_code(404);
    include Theme::errorPage(404);
}
