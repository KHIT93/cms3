<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessDeniedException
 *
 * @author Kenneth
 */
class AccessDeniedException extends Exception {
    public function __construct($message, $code = 'SYS-ACCESS-DENIED', $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
