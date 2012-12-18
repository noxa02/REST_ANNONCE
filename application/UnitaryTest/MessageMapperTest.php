<?php
    include_once dirname(__FILE__).'/config.php';
    class MessageMapperTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}
        
        public
        function testCreate() 
        {
            $message = new Message();
            $message->setId(1);
            $message->setSubject('Un message');
            $message->setContent('Bonjour.');
            $message->setDatePost('2012-12-14 19:45:45');
            $message->setIdSender(1);
            $message->setIdReceiver(3);
            
            $messageMapper = new MessageMapper();
            $messageMapper->insertMessage($message);
            $messageMapper->setId(1);
            
            $this->assertEquals($message,$messageMapper->selectMessage());
        }
        
        public
        function testGet() 
        {
            $message = new Message();
            $message->setId(1);
            $message->setSubject('Un message');
            $message->setContent('Bonjour.');
            $message->setDatePost('2012-12-14 19:45:45');
            $message->setIdSender(1);
            $message->setIdReceiver(3);
            
            $messageMapper = new MessageMapper();
            $messageMapper->setId(1);
            
            $this->assertEquals($message, $messageMapper->selectMessage());
        }

        public
        function testPut() 
        {
            $message = new Message();
            $message->setId(1);
            $message->setSubject('Un message');
            $message->setContent('Bonjour. Une modification');
            $message->setDatePost('2012-12-14 19:45:45');
            $message->setIdSender(1);
            $message->setIdReceiver(3);
            
            $messageMapper = new MessageMapper();
            $messageMapper->setId(1);
            $messageMapper->updateMessage($message);
            
            $this->assertEquals($message,$messageMapper->selectMessage());
        }

        public
        function testDelete() 
        {
            $messageMapper = new MessageMapper();
            $messageMapper->setId(1);
            $messageMapper->deleteMessage();
            
            $this->assertEquals(new Message(),$messageMapper->selectMessage());
        }
 
    }