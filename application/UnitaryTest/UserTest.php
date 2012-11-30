<?php
    include_once dirname(__FILE__).'/config.php';
    include_once dirname(__FILE__).'/../bootstrap.php';
    
    class UserTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}


        public 
        function testGetSetId() 
        {
            $user_ = new User();
            $user_->setId(1);
            $this->assertEquals(1,$user_->getId());
        }

        public 
        function testGetSetName()
        {
            $user_ = new User();
            $user_->setName('Pierre');
            $this->assertEquals('Pierre',$user_->getName());
        }

        public 
        function testGetSetFirstname()
        {
            $user_ = new User();
            $user_->setFirstname('Jean');
            $this->assertEquals('Jean',$user_->getFirstname());
        }

        public 
        function testGetSetLogin()
        {
            $user_ = new User();
            $user_->setFirstname('Jean');
            $this->assertEquals('Jean',$user_->getFirstname());
        }

        public 
        function testGetSetPassword()
        {
            $user_ = new User();
            $user_->setPassword('monmotdepasse');
            $this->assertEquals('monmotdepasse',$user_->getPassword());
        }

        public 
        function testGetSetMail()
        {
            $user_ = new User();
            $user_->setMail('jeanpierre@gmail.com');
            $this->assertEquals('jeanpierre@gmail.com',$user_->getMail());
        }

        public 
        function testGetSetAddress()
        {
            $user_ = new User();
            $user_->setAddress('9 rue de la pochette');
            $this->assertEquals('9 rue de la pochette',$user_->getAddress());
        }

        public 
        function testGetSetPhone()
        {
            $user_ = new User();
            $user_->setPhone('0143523213');
            $this->assertEquals('0143523213',$user_->getPhone());
        }

        public 
        function testGetSetPortable()
        {
            $user_ = new User();
            $user_->setPortable('0624523213');
            $this->assertEquals('0624523213',$user_->getPortable());
        }

        public 
        function testGetSetSubscriptionDate()
        {
            $user_ = new User();
            $user_->setSubscriptionDate('2012-11-29 11:11:11');
            $this->assertEquals('2012-11-29 11:11:11',$user_->getSubscriptionDate());
        }

        public 
        function testGetSetHash()
        {
            $user_ = new User();
            $user_->setHash('ec457d0a974c48d5685a7efa03d137dc8bbde7e3');
            $this->assertEquals('ec457d0a974c48d5685a7efa03d137dc8bbde7e3',$user_->getHash());
        }

        public 
        function testGetSetNewsletter()
        {
            $user_ = new User();
            $user_->setNewsletter(0);
            $this->assertEquals(0,$user_->getNewsletter());
        }

        public 
        function testGetSetRole()
        {
            $user_ = new User();
            $user_->setRole('user');
            $this->assertEquals('user',$user_->getRole());
        }

        
        /**
         * 
         */
        public
        function testGetUser()
        {

        }

        /**
         * 
         */
        public
        function testCreateUser() 
        {

        }
        
        /**
         * 
         */
        public
        function testUpdateUser() 
        {

        }
        
        /**
         * 
         */
        public
        function testDeleteUser() 
        {

        }
    }
?>
