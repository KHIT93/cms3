<?php
if($get_url[1] == 'editor') {
    $editor = new Editor(Input::get('type'), Input::get('item'), ((isset($_GET['file']) ? Input::get('file') : NULL)));
    include INCLUDES_PATH.'/admin.inc.php';
    print $editor->render();
}
else {
    http_response_code(404);
    include Theme::errorPage(404);
}