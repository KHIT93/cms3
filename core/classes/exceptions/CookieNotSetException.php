<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UnknownCookieException
 *
 * @author Kenneth
 */
class CookieNotSetException extends Exception {
    public function __construct($message, $code = 'SYS-COOKIE-NOT-SET', $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
