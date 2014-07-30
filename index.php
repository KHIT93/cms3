<?php
/**
 * @file
 * Primary file handling all requests
 */
error_reporting(E_ALL);
define('SITE_ROOT', getcwd());
$init = array();
require_once SITE_ROOT.'/core/dev/init.dev.php';
core_bootstrapper($init, EXEC_BOOTSTRAPPER_FULL);
finalize_page($init);
?>