<?php
include_once '../config.php';

if (DEVELOPMENT_ENVIRONMENT == true) {
    error_reporting(E_ALL);
    ini_set('display_errors','On');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors','Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', PATH_ROOT.'/tmp/logs/error.log');
}  
require_once 'XML/Util.php';
require_once 'XML/Serializer.php';
include_once APPLICATION_PATH.'/includes/template.php';
include_once APPLICATION_PATH.'/library/symphony/functions.php';
include_once APPLICATION_PATH.'/includes/autoloader.php';
include_once APPLICATION_PATH.'/includes/dispatcher_mvc.php';
