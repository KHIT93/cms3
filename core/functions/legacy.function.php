<?php
/**
 * @file
 * Contains functions which purpose is to provide legacy functions to components and modules until they have been converted
 */
function splitURL() {
    return explode('/', $_GET['q']);
}
function throw_error($error_code) {
    http_response_code($error_code);
    Theme::errorPage($error_code);
}
function parse_info_file($readin) {
    return File::parse_info_file($readin);
}