<?php
    include_once dirname(__FILE__).'/config.php';
    class PictureMapperTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}

        public
        function testCreate() 
        {
            $picture = new Picture();
            $picture->setId(1);
            $picture->setTitle('announcement_1_1');
            $picture->setPath('/announcement/original/');
            $picture-> setAlternative('Un texte alternatif');
            $picture->setIdAnnouncement(10);
            $picture->setExtension('gif');
            
            $pictureMapper = new PictureMapper();
            $pictureMapper->insertPicture($picture);
            $pictureMapper->setId(1);
            
            $this->assertEquals($picture,$pictureMapper->selectPicture());
        }
        
        public
        function testGet() 
        {
            $picture = new Picture();
            $picture->setId(1);
            $picture->setTitle('announcement_1_1');
            $picture->setPath('/announcement/original/');
            $picture-> setAlternative('Un texte alternatif');
            $picture->setIdAnnouncement(10);
            $picture->setExtension('gif');
            
            $pictureMapper = new PictureMapper();
            $pictureMapper->setId(1);
            
            $this->assertEquals($picture,$pictureMapper->selectPicture());
        }
        
        public
        function testPut() 
        {
            $picture = new Picture();
            $picture->setId(1);
            $picture->setTitle('announcement_1_1');
            $picture->setPath('/announcement/original/');
            $picture-> setAlternative('Un texte alternatif modifié');
            $picture->setIdAnnouncement(10);
            $picture->setExtension('gif');
            
            $pictureMapper = new PictureMapper();
            $pictureMapper->setId(1);
            $pictureMapper->updatePicture($picture);
            
            $this->assertEquals($picture,$pictureMapper->selectPicture());
        }
        
        public
        function testDelete() 
        {
            $pictureMapper = new PictureMapper();
            $pictureMapper->setId(1);
            $pictureMapper->deletePicture();

            $this->assertEquals(new Picture(),$pictureMapper->selectPicture());
        }
    }