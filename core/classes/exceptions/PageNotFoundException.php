<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageNotFoundException
 *
 * @author Kenneth
 */
class PageNotFoundException extends Exception{
    public function __construct($message, $code = 'SYS-PAGE-NOT-FOUND', $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
