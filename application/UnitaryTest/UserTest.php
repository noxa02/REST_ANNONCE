<?php
    include_once '../bootstrap.php';
    include_once '../models/User.class.php';
 
    class UserTest extends PHPUnit_Framework_TestCase {
      public function setUp(){}
      public function tearDown(){}

      public function testUserName(){
        // test pour s'assurer que l'objet à un nom valide
        $userName = 'blognt';
        $user     = new User();
        $user->setName($userName);
        
        $this->assertTrue($user->getUserName() !== false);
      }
    }
?>
