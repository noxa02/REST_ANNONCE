<?php

define('DS_', DIRECTORY_SEPARATOR);
define('PATH_ROOT_', dirname(dirname(__FILE__). DS_ . '..'. DS_ . '..'. DS_ . '..'));

require_once(realpath(PATH_ROOT_). DS_ .'config.php');

$backupFile = PATH_ROOT . DS .'application'. DS .'sql'. DS . DB_NAME .date("-YmdHis").'.sql';
print $backupFile;
$command = '/Applications/MAMP/Library/bin/mysqldump --opt -h'.DB_HOST.' -u'.DB_USER.' -p'.DB_PASSWORD.' '.DB_NAME.' > '.$backupFile;
print $command;
system($command);

