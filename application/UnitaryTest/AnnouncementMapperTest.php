<?php
    include_once dirname(__FILE__).'/config.php';
    class AnnouncementMapperTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}
        
        public
        function testCreate() 
        {
            $announcement = new Announcement();
            $announcement->setId('1');
            $announcement->setTitle('Annonce test');
            $announcement->setSubtitle('Description');
            $announcement->setContent('Besoin de mécanicien contre cours de cuisine');
            $announcement->setPostDate('2012-12-14 18:07:27');
            $announcement->setConclued('0');
            
            $announcementMapper = new AnnouncementMapper();
            $announcementMapper->insertAnnouncement($announcement);
            $announcementMapper->setId(1);
            
            $announcement->setPictures(null);
            $this->assertEquals($announcement, $announcementMapper->selectAnnouncement());
            
        }
       
        public
        function testGet() 
        {
            $announcement = new Announcement();
            $announcement->setId('1');
            $announcement->setTitle('Annonce test');
            $announcement->setSubtitle('Description');
            $announcement->setContent('Besoin de mécanicien contre cours de cuisine');
            $announcement->setPostDate('2012-12-14 18:07:27');
            $announcement->setConclued('0');
            
            $announcementMapper = new AnnouncementMapper();
            $announcementMapper->setId(1);
            
            $this->assertEquals($announcement, $announcementMapper->selectAnnouncement());
        }

        public
        function testPut() 
        {
            $announcement = new Announcement();
            $announcement->setId('1');
            $announcement->setTitle('Annonce test');
            $announcement->setSubtitle('Description modifiée');
            $announcement->setContent('Besoin de mécanicien contre cours de cuisine');
            $announcement->setPostDate('2012-12-14 18:07:27');
            $announcement->setConclued('0');
            
            $announcementMapper = new AnnouncementMapper();
            $announcementMapper->setId(1);
            $announcementMapper->updateAnnouncement($announcement);
            
            $this->assertEquals($announcement, $announcementMapper->selectAnnouncement());
        }

        public
        function testDelete() 
        {
            $announcementMapper = new AnnouncementMapper();
            $announcementMapper->setId(1);
            $announcementMapper->deleteAnnouncement();
            
            $this->assertEquals(new Announcement(), $announcementMapper->selectAnnouncement());
        }
    }
?>
