<?php
$settings = new settings();
if(isset($get_url[2])) {
    //Find correct settings page
    switch ($get_url[2]) {
        case 'system':
            print $settings->system();
        break;
        case 'content':
            print $settings->wysiwyg();
        break;
        case 'development':
            print $settings->development();
        break;
        case 'search':
            print $settings->search_meta();
        break;
        case 'language':
            print $settings->language();
        break;
        default :
            print '<div class="page-head">'.get_breadcrumb().'</div><div class="cl-mcont">'.print_messages().'<div class="col-md-12">'.implode('', $settings->settingList()).'</div>';
        break;
    }
}
else {
    print '<div class="page-head">'.get_breadcrumb().'</div><div class="cl-mcont">'.print_messages().'<div class="col-md-12">'.implode('', $settings->settingList()).'</div>';
}
?>