<?php
function traverse($array, $class = NULL, $toggle = false) {
    $get_url = splitURL();
    if(empty($get_url[1]) OR !isset($get_url[1])) {
        $active = $get_url[0];
    }
    else {
        $active = implode('/', $get_url);
    }
    $str = '<ul class="'.$class.'">';
    foreach($array as $item) {
        if($active == $item['link']) {
            $str .= '<li class="active"><a href="'.site_root().'/'.$item['link'].'"'.(isset($item['children'])&&$toggle==true?' class="dropdown-toggle" data-toggle="dropdown"':'').'>'.$item['title'].'</a>'.(isset($item['children'])&&$item['children']?traverse($item['children'], 'dropdown-menu'):'').'</li>';
        }
        else {
            $str .= '<li><a href="'.site_root().'/'.$item['link'].'"'.(isset($item['children'])&&$toggle==true?' class="dropdown-toggle" data-toggle="dropdown"':'').'>'.$item['title'].'</a>'.(isset($item['children'])&&$item['children']?traverse($item['children'], 'dropdown-menu'):'').'</li>';
        }
    }
    $str .= '</ul>';
    return $str;
}
function sidebar_traverse($array, $class = NULL) {
    $get_url = splitURL();
    if(empty($get_url[1]) OR !isset($get_url[1])) {
        $active = $get_url[0];
    }
    else {
        $active = implode('/', $get_url);
    }
    $str = '<ul class="'.$class.'">';
    foreach($array as $item) {
        if($active == $item['link']) {
            $str .= '<li class="active"><a href="'.site_root().'/'.$item['link'].'"'.(isset($item['children'])?' class="parent"':'').'>'.$item['title'].'</a>'.(isset($item['children'])&&$item['children']?traverse($item['children'], 'sub-menu'):'').'</li>';
        }
        else {
            $str .= '<li><a href="'.site_root().'/'.$item['link'].'"'.(isset($item['children'])?' class="parent"':'').'>'.$item['title'].'</a>'.(isset($item['children'])&&$item['children']?traverse($item['children'], 'sub-menu'):'').'</li>';
        }
    }
    $str .= '</ul>';
    return $str;
}