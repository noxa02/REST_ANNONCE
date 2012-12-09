<?php 
/**
*  Classe PDO 
*/

class PDO_Mysql
{
	private static $_instancePDO = null;

	public static 
    function init() {
        try {
            self::$_instancePDO  =  new PDO(
                    'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, 
                    array(PDO::ATTR_PERSISTENT => true, 
                          PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
                    );
        } catch(PDOException $e) {
            print $e->getMessage(); exit;
        }
	}

	public static 
    function getInstance() {
		if(is_null(self::$_instancePDO)):
			self::init();
		endif;

		return self::$_instancePDO;
	}
}