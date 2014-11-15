<?php
/**
 * @file
 * Primary file handling all requests
 */
error_reporting(E_ALL);
ini_set('display_errors', 'on');
define('SITE_ROOT', getcwd());
$init = array();
include_once 'core/modules/krumo/class.krumo.php';
require_once SITE_ROOT.'/core/init.php';
core_bootstrapper($init, EXEC_BOOTSTRAPPER_FULL);
finalize_page($init);
?>