<?php
/**
 * @file
 * General functions for core
 */
function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}
function getNextId($table) {
    return (int)DB::getInstance()->query("SHOW TABLE STATUS LIKE 'pages'")->first()->Auto_increment;
}