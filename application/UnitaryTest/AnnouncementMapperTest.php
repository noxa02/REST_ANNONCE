<?php
    include_once dirname(__FILE__).'/config.php';
    class UserMapperTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}
        
        public
        function testCreateOk() 
        {
           /* $announcement = new Announcement();
            //$announcement->setId('3');
            $announcement->setTitle('Annonce test');
            $announcement->setSubtitle('Description');
            $announcement->setContent('Besoin de mécanicien contre cours de cuisine');
            $announcement->setPostDate('2012-12-14 18:07:27');
            $announcement->setConclued('0');
            //$announcement->setPictures(Array());
            
            $announcementMapper = new AnnouncementMapper();
            $announcementMapper->insertAnnouncement($announcement);
            $announcementMapper->setId(3);
            
            $this->assertEquals($announcement, $announcementMapper->selectAnnouncement());
            */
        }
        
        public
        function testCreateForbidden() 
        {
         
        }
        public
        function testGetOk() 
        {
            $announcement = new Announcement();
            $announcement->setId(2);
            $announcement->setTitle('Première annonce');
            $announcement->setSubtitle('Description annonce');
            $announcement->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam orci eros, interdum a imperdiet et, convallis vitae urna. Nullam gravida justo et neque tempor bibendum. Maecenas arcu mauris, tristique quis elementum nec, hendrerit scelerisque est. Duis pulvinar elit nec leo viverra vestibulum. ');
            $announcement->setPostDate('2012-11-26 11:39:15');
            $announcement->setConclued(0);
            
            $announcementMapper = new AnnouncementMapper();
            $announcementMapper->setId(2);
            
            $this->assertEquals($announcement, $announcementMapper->selectAnnouncement());
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
            
        }
        
        public
        function testDeleteForbidden() 
        {
            
        }
        
        
        
        
    }
?>
