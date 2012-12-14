<?php
    include_once dirname(__FILE__).'/config.php';
    class UserMapperTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}

        public
        function testGetOk() 
        {
            $user = new \User();
            $user->setId('1');
            $user->setName('Fred');
            $user->setFirstname('Jimmy');
            $user->setLogin('noxa02');
            $user->setPassword('ogame17', true);
            $user->setMail('Masson.Xavier.91@gmail.com');
            $user->setAddress('3 rue meissonnier');
            $user->setPhone('0169486412');
            $user->setPortable('0676564534');
            $user->setSubscriptionDate('2012-11-26 10:29:37');
            $user->setHash('ec457d0a974c48d5685a7efa03d137dc8bbde7e3');
            $user->setNewsletter('1');
            $user->setRole('administrator');
            $userMapper = new UserMapper();
            $userMapper->setId(1);            
         
            $this->assertEquals($user,$userMapper->selectUser());
        }
        
        public
        function testGetBadRequest() 
        {
            
        }
        
        public
        function testPutOk() 
        {
            $user = new User();
            $user->setId('4');
            $user->setName('Chea');
            $user->setFirstname('Caroline');
            $user->setLogin('kimitsu');
            $user->setPassword('lily', true);
            $user->setMail('caroline.chea90@gmail.com');
            $user->setAddress('9 rue de la pochette');
            $user->setPhone('0143523213');
            $user->setPortable('0625884536');
            $user->setSubscriptionDate('2012-11-27 08:39:00');
            $user->setHash('79457832847b44a73ccfeef57c03033db88cad08');
            $user->setNewsletter('1');
            $user->setRole('user');
            
            $userMapper = new UserMapper();
            $userMapper->setId(4);
            $userMapper->updateUser($user, NULL);
            
            $this->assertEquals($user,$userMapper->selectUser());
        }
        
        public
        function testPutBadRequest() 
        {
            
        }
        
        public
        function testCreateOk() 
        {
            $user = new User();
            $user->setId('7');
            $user->setName('Chea');
            $user->setFirstname('Caroline');
            $user->setLogin('caro');
            $user->setPassword('lily', true);
            $user->setMail('caroline.chea90@gmail.com');
            $user->setAddress('9 rue de la pochette');
            $user->setPhone('0143523213');
            $user->setPortable('0625884536');
            $user->setSubscriptionDate('2012-11-27 08:39:00');
            $user->setHash('79457832847b44a73ccfeef57c03033db88cad08');
            $user->setNewsletter('1');
            $user->setRole('user');
            
            
            $userMapper = new UserMapper();
            $userMapper->insertUser($user);
            $userMapper->setId(7);
            $this->assertEquals($user,$userMapper->selectUser());
            
        }
        
        public
        function testCreateForbidden() 
        {
            
        }
        
        public
        function testDeleteOk() 
        {
             $userMapper = new UserMapper();
            $userMapper->setId(7);
            $userMapper->deleteUser(NULL);
            
            $this->assertEquals(new User(),$userMapper->selectUser());
        }
        
        public
        function testDeleteForbidden() 
        {
            
        }
    }