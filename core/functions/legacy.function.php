<?php
/**
 * @file
 * Contains functions which purpose is to provide legacy functions to components and modules until they have been converted
 */
function splitURL() {
    return (isset($_GET['q'])) ? explode('/', $_GET['q']) : array(0 => page_front());
}
function throw_error($error_code) {
    http_response_code($error_code);
    Theme::errorPage($error_code);
}
function parse_info_file($readin) {
    return File::parse_info_file($readin);
}
function addMessage($type, $message, $error = NULL) {
    System::addMessage($type, $message, $error);
}
function print_messages() {
    System::print_messages();
}
function print_messages_simple() {
    System::print_messages_simple();
}