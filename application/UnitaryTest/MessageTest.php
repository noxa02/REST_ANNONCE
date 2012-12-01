<?php
    include_once dirname(__FILE__).'/config.php';
    
    class MessageTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}
        
        public 
        function testGetSetId()
	{
            $message_ = new Message();
            $message_->setId(1);
            $this->assertEquals(1, $message_->getId());
	}

	public 
        function testGetSetSubject()
	{
            $message_ = new Message();
            $message_->setSubject('Coucou');
            $this->assertEquals('Coucou', $message_->getSubject());
	}

	public 
        function testGetSetContent()
	{
            $message_ = new Message();
            $message_->setContent('Bonjour membre2.');
            $this->assertEquals('Bonjour membre2.', $message_->getContent());
	}

	public 
        function testGetSetDatePost()
	{
            $message_ = new Message();
            $message_->setDatePost('2012-12-01 22:22:22');
            $this->assertEquals('2012-12-01 22:22:22', $message_->getDatePost());
	}
        
        public 
        function testCreateMessage() {

        }

        public 
        function testUpdateMessage() {

        }

        public 
        function testDeleteMessage() {

        }
    }
?>
