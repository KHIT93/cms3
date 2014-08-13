<?php
function hasValue($string = NULL) {
    return (!empty($string) || $string != '' || $string != NULL || $string != false) ? true : false;
}
function generateURL($string) {
    $title = 'Titlen skal være rigtig';

    $from = array('"', "'", " ", "æ", "Æ", "ø", "Ø", "å", "Å");
    $to = array("", "", "-", "ae", "Ae", "oe", "Oe", "aa", "Aa");
    return strtolower(str_replace($from, $to, $title));
}