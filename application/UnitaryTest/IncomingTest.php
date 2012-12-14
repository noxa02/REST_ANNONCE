<?php
    include_once dirname(__FILE__).'/config.php';
 
    class IncomingTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}
        
        public 
        function testGetSetId()
	{
            $incoming = new Incoming();
            $incoming->setId(1);
            $this->assertEquals(1, $incoming->getId());
	}

	public 
        function testGetSetTitle()
	{
            $incoming = new Incoming();
            $incoming->setTitle('Titre incoming');
            $this->assertEquals('Titre incoming', $incoming->getTitle());
	}

	public 
        function testGetSetSubtitle()
	{
            $incoming = new Incoming();
            $incoming->setSubtitle('subtitle');
            $this->assertEquals('subtitle', $incoming->getSubtitle());
	}

	public 
        function testGetSetContent()
	{
            $incoming = new Incoming();
            $incoming->setContent('Incoming content');
            $this->assertEquals('Incoming content', $incoming->getContent());
	}

	public 
        function testGetSetPostDate()
	{
            $incoming = new Incoming();
            $incoming->setPostDate('2012-12-01 12:00:00');
            $this->assertEquals('2012-12-01 12:00:00', $incoming->getPostDate());
	}
        
    }
?>
