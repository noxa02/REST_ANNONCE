<?php
    include_once dirname(__FILE__).'/config.php';
 
    class AnnouncementTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}

        public 
        function testGetSetId()
        {
            $announcement = new Announcement();
            $announcement->setId(1);
            $this->assertEquals(1,$announcement->getId());
        }

        public 
        function testGetSetTitle()
        {
            $announcement = new Announcement();
            $announcement->setTitle('Echange de consoles');
            $this->assertEquals('Echange de consoles',$announcement->getTitle());
        }

        public 
        function testGetSetSubtitle()
        {
            $announcement = new Announcement();
            $announcement->setSubtitle('Un échange');
            $this->assertEquals('Un échange',$announcement->getSubtitle());
        }

        public 
        function testGetSetContent()
        {
            $announcement = new Announcement();
            $announcement->setContent('J\'échange une PS3 slim contre une Wii U.');
            $this->assertEquals('J\'échange une PS3 slim contre une Wii U.',$announcement->getContent());
        }

        public 
        function testGetSetPostDate()
        {
            $announcement = new Announcement();
            $announcement->setPostDate('2012-11-29 22:22:22');
            $this->assertEquals('2012-11-29 22:22:22',$announcement->getPostDate());
        }

        public 
        function testGetSetConclued()
        {
            $announcement = new Announcement();
            $announcement->setConclued(0);
            $this->assertEquals(0,$announcement->getConclued());
        }
    }
?>
