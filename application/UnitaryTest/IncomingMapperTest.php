<?php
    include_once dirname(__FILE__).'/config.php';
    class IncomingMapperTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}
        
        public
        function testCreate() 
        {
            $incoming = new Incoming();
            $incoming->setId('1');
            $incoming->setTitle('News test');
            $incoming->setSubtitle('subtitle');
            $incoming->setContent('une news');
            $incoming->setPostDate('2012-12-14 18:07:27');
            $incoming->setIdUser(1);
 
            $incomingMapper = new IncomingMapper();
            $incomingMapper->insertIncoming($incoming);
            $incomingMapper->setId(1);
            
            $this->assertEquals($incoming, $incomingMapper->selectIncoming());
            
        }
       
        public
        function testGet() 
        {
            $incoming = new Incoming();
            $incoming->setId('1');
            $incoming->setTitle('News test');
            $incoming->setSubtitle('subtitle');
            $incoming->setContent('une news');
            $incoming->setPostDate('2012-12-14 18:07:27');
            $incoming->setIdUser(1);
 
            $incomingMapper = new IncomingMapper();
            $incomingMapper->setId(1);
            
            $this->assertEquals($incoming, $incomingMapper->selectIncoming());
        }

        public
        function testPut() 
        {
            $incoming = new Incoming();
            $incoming->setId('1');
            $incoming->setTitle('News test');
            $incoming->setSubtitle('subtitle');
            $incoming->setContent('une news');
            $incoming->setPostDate('2012-12-14 18:07:27');
            $incoming->setIdUser(1);
 
            $incomingMapper = new IncomingMapper();
            $incomingMapper->setId(1);
            $incomingMapper->updateIncoming($incoming);
            
            $this->assertEquals($incoming, $incomingMapper->selectIncoming());
        }

        public
        function testDelete() 
        {
            $incomingMapper = new IncomingMapper();
            $incomingMapper->setId(1);
            $incomingMapper->deleteIncoming();
            
            $this->assertEquals(new Incoming(), $incomingMapper->selectIncoming());
        }
    }