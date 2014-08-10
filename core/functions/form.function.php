<?php
function formBootstrapping($formdata) {
    Form::submit($formdata);
}
function form_delete($title, $name, $value, $item, $return_url) {
    Form::formDelete($title, $name, $value, $item, $return_url);
}