<?php
    include_once dirname(__FILE__).'/config.php';
    class UserMapperTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}
        
        public
        function testCreateOk() 
        {
            $message = new Message();
            $message->setId(3);
            $message->setSubject('Un message');
            $message->setContent('Bonjour.');
            $message->setDatePost('2012-12-14 19:45:45');
            $message->setIdSender(1);
            $message->setIdReceiver(3);
            
            $messageMapper = new MessageMapper();
            $messageMapper->insertMessage($message);
            $messageMapper->setId(3);
            
            $this->assertEquals($message,$messageMapper->selectMessage());
        }
        
        public
        function testCreateForbidden() 
        {
         
        }
        public
        function testGetOk() 
        {
            $message = new Message();
            $message->setId(1);
            $message->setSubject('Premier contact');
            $message->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean rhoncus pulvinar odio, non ornare massa tincidunt ac. Pellentesque suscipit neque non leo sagittis sed ullamcorper ligula tristique. Sed a dolor sapien, nec fermentum velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer porta sollicitudin odio quis tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean vitae mi vel risus dictum pulvinar at eget nunc.');
            $message->setDatePost('2012-12-13 11:23:45');
            $message->setIdSender(1);
            $message->setIdReceiver(3);
            
            $messageMapper = new MessageMapper();
            $messageMapper->setId(1);
            
            $this->assertEquals($message, $messageMapper->selectMessage());
        }
        
        public
        function testGetBadRequest() 
        {
            
        }
        
        public
        function testPutOk() 
        {
            
        }
        
        public
        function testPutBadRequest() 
        {
            
        }
        
        public
        function testDeleteOk() 
        {
            $messageMapper = new MessageMapper();
            $messageMapper->setId(3);
            $messageMapper->deleteMessage();
            
            $this->assertEquals(new Message(),$messageMapper->selectMessage());
        }
        
        public
        function testDeleteForbidden() 
        {
            
        }   
    }
?>
