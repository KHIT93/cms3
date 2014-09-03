<?php
if(has_permission('access_admin_editor', Session::get(Config::get('session/session_name')))) {
    if($get_url[1] == 'editor') {
        $editor = new Editor(Input::get('type'), Input::get('item'), ((isset($_GET['file']) ? Input::get('file') : NULL)));
        include_once INCLUDES_PATH.'/admin.inc.php';
        print $editor->render();
    }
    else {
        http_response_code(404);
        include_once Theme::errorPage(404);
    }
}
else {
    include_once INCLUDES_PATH.'/admin.inc.php';
    action_denied(true);
}