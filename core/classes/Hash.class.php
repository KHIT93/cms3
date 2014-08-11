<?php
/**
 * @file
 * Handles hashing/one-way-encryption of data
 */
class Hash {
    public static function make($string, $salt = '') {
        return hash('sha256', $string.$salt);
    }
    public static function makePassHash($string) {
        $hash = '';
        if(CRYPT_SHA512 == 1) {
            $salt = rand_str(rand(100,200));
            $hash = crypt($password, '$6$$'.$salt.'$');
        }
        else {
            $hash = crypt($_POST['password']);
        }
        return $hash;
    }
    public static function validateHash($string, $match) {
        return (crypt($string, $match) == $match) ? true : false;
    }
    public static function salt($length) {
        return mcrypt_create_iv($length);
    }
    public static function unique() {
        return self::make(uniqid());
    }
}