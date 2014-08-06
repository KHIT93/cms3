<?php
/**
 * @file
 * Primary file handling all requests
 */
error_reporting(E_ALL);
define('SITE_ROOT', getcwd());
$init = array();
include 'core/modules/krumo/class.krumo.php';
require_once SITE_ROOT.'/core/init.php';
core_bootstrapper($init, EXEC_BOOTSTRAPPER_FULL);
finalize_page($init);
//krumo(Theme::getTheme());
?>