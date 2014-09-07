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
function get_db_drivers() {
    //Get all enabled database drivers from php.ini
    $output = array();
    if(extension_loaded('pdo_mysql')) {
        $output['mysql'] = 'MySQL';
    }
    if(extension_loaded('pdo_sqlite')) {
        $output['sqlite'] = 'SQLite';
    }
    if(extension_loaded('pdo_oci')) {
        $output['oci'] = 'Oracle Call Interface';
    }
    if(extension_loaded('pdo_firebird')) {
        $output['firebird'] = 'Firebird';
    }
    if(extension_loaded('pdo_odbc')) {
        $output['odbc'] = 'ODBC v3 (IBM DB2, unixODBC and win32 ODBC)';
    }
    if(extension_loaded('pdo_pgsql')) {
        $output['pgsql'] = 'PostgreSQL';
    }
    return $output;
}