<?php
    include_once dirname(__FILE__).'/config.php';
    
    class MessageTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}
        
        public 
        function testGetSetId()
	{
            $message = new Message();
            $message->setId(1);
            $this->assertEquals(1, $message->getId());
	}

	public 
        function testGetSetSubject()
	{
            $message = new Message();
            $message->setSubject('Coucou');
            $this->assertEquals('Coucou', $message->getSubject());
	}

	public 
        function testGetSetContent()
	{
            $message = new Message();
            $message->setContent('Bonjour membre2.');
            $this->assertEquals('Bonjour membre2.', $message->getContent());
	}

	public 
        function testGetSetDatePost()
	{
            $message = new Message();
            $message->setDatePost('2012-12-01 22:22:22');
            $this->assertEquals('2012-12-01 22:22:22', $message->getDatePost());
	}
        
        public
        function testGetSetIdSender()
        {
            $message = new Message();
            $message->setIdSender(1);
            $this->assertEquals(1, $message->getIdSender());            
        }
        
        public
        function testGetSetIdReceiver()
        {
            $message = new Message();
            $message->setIdReceiver(3);
            $this->assertEquals(3, $message->getIdReceiver());            
        }
    }
?>
