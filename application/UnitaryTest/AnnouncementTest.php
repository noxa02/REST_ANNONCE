<?php
    include_once 'config.php';
    include_once dirname(__FILE__).'/../bootstrap.php';
 
    class AnnouncementTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}

        public 
        function testGetSetId()
        {
            $announcement_= new Announcement();
            $announcement_->setId(1);
            $this->assertEquals(1,$announcement_->getId());
        }

        public 
        function testGetSetTitle()
        {
            $announcement_= new Announcement();
            $announcement_->setTitle('Echange de consoles');
            $this->assertEquals('Echange de consoles',$announcement_->getTitle());
        }

        public 
        function testGetSetSubTitle()
        {
            $announcement_= new Announcement();
            $announcement_->setSubTitle('Un échange');
            $this->assertEquals('Un échange',$announcement_->getSubTitle());
        }

        public 
        function testGetSetContent()
        {
            $announcement_= new Announcement();
            $announcement_->setContent('J\'échange une PS3 slim contre une Wii U.');
            $this->assertEquals('J\'échange une PS3 slim contre une Wii U.',$announcement_->getContent());
        }

        public 
        function testGetSetPostDate()
        {
            $announcement_= new Announcement();
            $announcement_->setPostDate('2012-11-29 22:22:22');
            $this->assertEquals('2012-11-29 22:22:22',$announcement_->getPostDate());
        }

        public 
        function testGetSetConclued()
        {
            $announcement_= new Announcement();
            $announcement_->setConclued(0);
            $this->assertEquals(0,$announcement_->getConclued());
        }
        
        
        public 
        function testGetAnnouncement()
        {
            
        }
        
        public 
        function testCreateAnnouncement()
        {
            
        }
        
        public 
        function testUpdateAnnouncement()
        {
            
        }
        
        public 
        function testDeleteAnnouncement()
        {
            
        }
    }
?>
