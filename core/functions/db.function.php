<?php
function get_datatype($var) {
    $type = strtolower(gettype($var));
    $result;
    switch($type) {
        case 'string' :
            $result = PDO::PARAM_STR;
        break;
        case 'integer' :
            $result = PDO::PARAM_INT;
        break;
        case 'boolean' :
            $result = PDO::PARAM_BOOL;
        break;
        case 'null' :
            $result = PDO::PARAM_NULL;
        break;
        default :
            $result = PDO::PARAM_STR;
        break;
    }
    return $result;
}