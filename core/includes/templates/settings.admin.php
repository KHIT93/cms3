<?php
if(isset($get_url[2])) {
    //Find correct settings page
    switch ($get_url[2]) {
        case 'system':
            print Settings::system();
        break;
        case 'content':
            print Settings::wysiwyg();
        break;
        case 'development':
            print Settings::development();
        break;
        case 'search':
            print Settings::search_meta();
        break;
        case 'language':
            print Settings::language();
        break;
        default :
            print '<div class="page-head">'.get_breadcrumb().'</div><div class="cl-mcont">'.print_messages().'<div class="col-md-12">'.implode('', Settings::settingList()).'</div>';
        break;
    }
}
else {
    print '<div class="page-head">'.get_breadcrumb().'</div><div class="cl-mcont">'.print_messages().'<div class="col-md-12">'.implode('', Settings::settingList()).'</div>';
}
?>