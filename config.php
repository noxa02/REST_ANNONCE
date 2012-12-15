<?php 
    /**
     * Set the environment application
     */
    define ('DEVELOPMENT_ENVIRONMENT', true);
    defined('UNITARY_TEST') or define('UNITARY_TEST', false);
    
    /**
     * Constants variables to connect the database.
     */
    define('DB_HOST', 'localhost');
    define('DB_PORT', '8889');
    define('DB_USER', 'root');
    define('DB_NAME', 'asimpletrade');
    define('DB_PASSWORD', 'root');

    /**
     * Constants to multiples path.
     */
    define('DS', DIRECTORY_SEPARATOR);
    define('PATH_ROOT', dirname(__FILE__));
    define("APPLICATION_PATH", PATH_ROOT . DS .'application');
    define("UPLOAD_PATH", PATH_ROOT . DS .'upload');