<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NonExistingFormException
 *
 * @author Kenneth
 */
class NonExistingFormException extends Exception {
    public function __construct($message, $code = 'SYS-FORM-NONEXISTING', $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
