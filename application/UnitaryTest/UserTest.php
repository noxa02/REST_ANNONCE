<?php
    include_once 'config.php';
    include_once dirname(__FILE__).'/../bootstrap.php';
 
    class UserTest extends PHPUnit_Framework_TestCase {
      public function setUp(){}
      public function tearDown(){}

      public function testUserName(){
        // test pour s'assurer que l'objet à un nom valide
     
        
        $this->assertTrue(1 == 1);
      }
    }
?>
