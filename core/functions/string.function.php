<?php
function hasValue($string = NULL) {
    return ($string || $string != '' || $string != NULL || $string != false) ? true : false;
}
function generateURL($string) {
    $from = array('"', "'", " ", "æ", "Æ", "ø", "Ø", "å", "Å");
    $to = array("", "", "-", "ae", "Ae", "oe", "Oe", "aa", "Aa");
    return strtolower(str_replace($from, $to, $string));
}
function output_languages_as_select($languages) {
    if(count($languages)) {
        $output = array();
        foreach ($languages as $language) {
            $output[$language['code']] = $language['name'];
        }
        return $output;
    }
    return false;
}