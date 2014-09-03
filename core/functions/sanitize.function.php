<?php
/**
 * @file
 * Functions for sanitizing input/output to/from the database and/or forms
 */
function strip_dangerous_protocols($uri) {
    return Sanitize::stripDangerousProtocols($uri);
}
function check_plain($string) {
    return Sanitize::checkPlain($string);
}
function string_placeholder($string) {
    return Sanitize::stringPlaceholder($string);
}