<?php
    include_once dirname(__FILE__).'/config.php';
 
    class IncomingTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}
        
        public 
        function testGetSetId()
	{
            $incoming_ = new Incoming();
            $incoming_->setId(1);
            $this->assertEquals(1, $incoming_->getId());
	}

	public 
        function testGetSetTitle()
	{
            $incoming_ = new Incoming();
            $incoming_->setTitle('Titre incoming');
            $this->assertEquals('Titre incoming', $incoming_->getTitle());
	}

	public 
        function testGetSetSubTitle()
	{
            $incoming_ = new Incoming();
            $incoming_->setSubTitle('subtitle');
            $this->assertEquals('subtitle', $incoming_->getSubTitle());
	}

	public 
        function testGetSetContent()
	{
            $incoming_ = new Incoming();
            $incoming_->setContent('Incoming content');
            $this->assertEquals('Incoming content', $incoming_->getContent());
	}

	public 
        function testGetSetPostDate()
	{
            $incoming_ = new Incoming();
            $incoming_->setPostDate('2012-12-01 12:00:00');
            $this->assertEquals('2012-12-01 12:00:00', $incoming_->getPostDate());
	}
    
	public 
        function testGetSetIdAdministrator()
	{
            $incoming_ = new Incoming();
            $incoming_->setIdAdministrator(1);
            $this->assertEquals(1, $incoming_->getIdAdministrator());
	}
        
        public 
        function testGetIncoming() 
        {
            
        }
    
   
        public 
        function testCreateIncoming() 
        {
       	}
    
        public 
        function testUpdateIncoming() 
        {
        }
    
   
        public 
        function testDeleteIncoming() 
        {
        }
    }
?>
