<?php
function form_validate($rules = array()) {
    $validate = new Validate();
    $validation = $validate->check($_POST, $rules);
    if($validation->passed()) {
        return true;
    }
    else {
        foreach($validation->errors() as $error) {
            System::addMessage('error', $error);
        }
        return false;
    }
}