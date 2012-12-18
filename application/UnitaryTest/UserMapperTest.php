<?php
    include_once dirname(__FILE__).'/config.php';
    class UserMapperTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}

        public
        function testCreate() 
        {
            $user = new User();
            $user->setId('2');
            $user->setName('Doe');
            $user->setFirstname('John');
            $user->setLogin('jDoe');
            $user->setPassword('2112', true);
            $user->setMail('johndoe@gmail.com');
            $user->setAddress('9 rue de la pochette');
            $user->setPhone('0143523213');
            $user->setPortable('0625884536');
            $user->setSubscriptionDate('2012-11-27 08:39:00');
            $user->setHash('79457832847b44a73ccfeef57c03033db88cad08');
            $user->setNewsletter('1');
            $user->setRole('user');
            
            $userMapper = new UserMapper();
            $userMapper->insertUser($user);
            $userMapper->setId(2);
            
            $this->assertEquals($user,$userMapper->selectUser());
        }
        
        public
        function testGet() 
        {
            $user = new \User();
            $user->setId('2');
            $user->setName('Doe');
            $user->setFirstname('John');
            $user->setLogin('jDoe');
            $user->setPassword('2112', true);
            $user->setMail('johndoe@gmail.com');
            $user->setAddress('9 rue de la pochette');
            $user->setPhone('0143523213');
            $user->setPortable('0625884536');
            $user->setSubscriptionDate('2012-11-27 08:39:00');
            $user->setHash('79457832847b44a73ccfeef57c03033db88cad08');
            $user->setNewsletter('1');
            $user->setRole('user');
            
            $userMapper = new UserMapper();
            $userMapper->setId(2);            
         
            $this->assertEquals($user,$userMapper->selectUser());
        }
        
        public
        function testPut() 
        {
            $user = new User();
            $user->setId('2');
            $user->setName('Doe');
            $user->setFirstname('John');
            $user->setLogin('jDoe');
            $user->setPassword('3131', true);
            $user->setMail('johndoe@gmail.com');
            $user->setAddress('9 rue de la pochette');
            $user->setPhone('0143523213');
            $user->setPortable('0625884536');
            $user->setSubscriptionDate('2012-11-27 08:39:00');
            $user->setHash('79457832847b44a73ccfeef57c03033db88cad08');
            $user->setNewsletter('1');
            $user->setRole('user');
            
            $userMapper = new UserMapper();
            $userMapper->setId(2);
            $userMapper->updateUser($user);
            
            $this->assertEquals($user,$userMapper->selectUser());
        }
        
        public
        function testDelete() 
        {
            $userMapper = new UserMapper();
            $userMapper->setId(2);
            $userMapper->deleteUser();
            
            $this->assertEquals(new User(),$userMapper->selectUser());
        }
    }
