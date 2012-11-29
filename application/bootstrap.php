<?php
include_once dirname(__FILE__).'/../config.php';

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
require_once 'XML/Unserializer.php';
require_once 'PHPUnit.php';

include_once APPLICATION_PATH.'/includes/template.php';
include_once APPLICATION_PATH.'/includes/autoloader.php';


if(!UNITARY_TEST) {
    include_once APPLICATION_PATH.'/library/symphony/functions.php';
    include_once APPLICATION_PATH.'/includes/dispatcher_mvc.php';
}

