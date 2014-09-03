<?php
/**
 * @file Procedural methods required for the installer to work
 */
function install_core() {
    //Initializes the installation of core
    $head = '<meta charset="'.((isset($header['charset'])) ? $header['charset']."\n" : 'utf-8').'">'."\n"
            .'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">'."\n"
            .'<meta name="robots" content="noindex,nofollow">'."\n"
            .'<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $header_title = '<title>Installation</title>'."\n";
    
    require_once CORE_INSTALLER_INCLUDES_PATH.'/templates/head.tpl.php';
    require_once CORE_INSTALLER_INCLUDES_PATH.'/templates/page.tpl.php';
    require_once CORE_INSTALLER_INCLUDES_PATH.'/templates/footer.tpl.php';
}