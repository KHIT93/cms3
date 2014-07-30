<?php
function rand_str($lenght, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
    $str = '';
    $count = strlen($charset);
    while($lenght--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}
function getSaltedHash($password) {
    return Hash::makePassHash($password);
}
function MakeRandPass($upper = 3, $lower = 3, $numeric = 3, $other = 2) {
    return User::MakeRandPass($upper, $lower, $numeric, $other);
}