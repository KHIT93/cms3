<?php
/**
 * @file Handles processing and returning data in connection with AJAX requests
 */
if(Input::exists('post')) {
    //VALID CORE JSON OBJECT
    //{
    //"status":true,
    //"percentage":"13",
    //"message":"Completed 5 of 40.",
    //"label":"Installed \u003Cem class=\u0022placeholder\u0022\u003EFilter\u003C\/em\u003E module."
    //}
    $function = Input::get('form_id').'_ajax';
    $result = $function($_POST);
    return (String::isJSON($result)) ? $result: json_encode($result);
}