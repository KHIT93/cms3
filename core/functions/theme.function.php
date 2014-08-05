<?php
/**
 * @file
 * Functions for handling the theme engine
 */
function theme_add_css(&$styles, $media, $add) {
    $styles[$media][] = $add;
}
function theme_rm_css(&$styles, $media, $remove) {
    $item_id = array_search($remove, $styles[$media]);
    $styles[$media][$item_id] = NULL;
}
function theme_add_js(&$jscripts, $add) {
    $jscripts[] = $add;
}
function theme_add_js_custom(&$jscripts_custom, $key, $add, $position = 'bottom') {
    $jscripts_custom[$position][$key] = $add;
}
function theme_rm_js(&$jscripts, $remove) {
    $item_id = array_search($remove, $jscripts);
    unset($jscripts[$item_id]);
}
function theme_rm_js_custom(&$jscripts_custom, $key, $remove) {
    unset($jscripts_custom[$key]);
}
function theme_header_alter(&$header, $theme, $core = false) {
    $theme = themeDetails($theme, $core);
    $template_func = $theme['machine_name'].'_theme_header_alter';
    foreach (Modules::activeModules() as $module) {
        $func_name = $module['module'].'_theme_header_alter';
        if(Modules::moduleImplements($module['module'], 'theme_header_alter')) {
            $func_name();
        }
    }
    if(function_exists($template_func)) {
        $template_func($header);
    }
}
function render(&$element) {
    return Theme::render($element);
}
function array_render($array) {
    return Theme::array_render($array);
}