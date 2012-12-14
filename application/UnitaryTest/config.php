<?php
    define('UNITARY_TEST', true);
    include_once dirname(__FILE__).'/../bootstrap.php';
    global $url;
    $url = new Url();
    $http = Rest::initProcess();
?>
