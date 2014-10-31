<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBQueryException
 *
 * @author Kenneth
 */
class DBQueryException extends Exception {
    public function __construct($message = 'The requested form does not exist', $code = 'SYS-DBQUERY-ERROR', $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
