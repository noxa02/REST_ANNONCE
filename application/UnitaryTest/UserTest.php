<?php
    include_once dirname(__FILE__).'/config.php';
    
    class UserTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}


        public 
        function testGetSetId() 
        {
            $user = new User();
            $user->setId(1);
            $this->assertEquals(1,$user->getId());
        }

        public 
        function testGetSetName()
        {
            $user = new User();
            $user->setName('Pierre');
            $this->assertEquals('Pierre',$user->getName());
        }

        public 
        function testGetSetFirstname()
        {
            $user = new User();
            $user->setFirstname('Jean');
            $this->assertEquals('Jean',$user->getFirstname());
        }

        public 
        function testGetSetLogin()
        {
            $user = new User();
            $user->setFirstname('Jean');
            $this->assertEquals('Jean',$user->getFirstname());
        }

        public 
        function testGetSetPassword()
        {
            $user = new User();
            $user->setPassword('monmotdepasse', true);
            $this->assertEquals(sha1_password('monmotdepasse'),$user->getPassword());
        }

        public 
        function testGetSetMail()
        {
            $user = new User();
            $user->setMail('jeanpierre@gmail.com');
            $this->assertEquals('jeanpierre@gmail.com',$user->getMail());
        }

        public 
        function testGetSetAddress()
        {
            $user = new User();
            $user->setAddress('9 rue de la pochette');
            $this->assertEquals('9 rue de la pochette',$user->getAddress());
        }

        public 
        function testGetSetPhone()
        {
            $user = new User();
            $user->setPhone('0143523213');
            $this->assertEquals('0143523213',$user->getPhone());
        }

        public 
        function testGetSetPortable()
        {
            $user = new User();
            $user->setPortable('0624523213');
            $this->assertEquals('0624523213',$user->getPortable());
        }

        public 
        function testGetSetSubscriptionDate()
        {
            $user = new User();
            $user->setSubscriptionDate('2012-11-29 11:11:11');
            $this->assertEquals('2012-11-29 11:11:11',$user->getSubscriptionDate());
        }

        public 
        function testGetSetHash()
        {
            $user = new User();
            $user->setHash('ec457d0a974c48d5685a7efa03d137dc8bbde7e3');
            $this->assertEquals('ec457d0a974c48d5685a7efa03d137dc8bbde7e3',$user->getHash());
        }

        public 
        function testGetSetNewsletter()
        {
            $user = new User();
            $user->setNewsletter(0);
            $this->assertEquals(0,$user->getNewsletter());
        }

        public 
        function testGetSetRole()
        {
            $user = new User();
            $user->setRole('user');
            $this->assertEquals('user',$user->getRole());
        }      
    }
?>
