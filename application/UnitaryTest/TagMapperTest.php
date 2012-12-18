<?php
    include_once dirname(__FILE__).'/config.php';
    class TagMapperTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}

        public
        function testCreate() 
        {
            $tag = new Tag();
            $tag->setId(50);
            $tag->setTitle('test');
            
            $tagMapper = new TagMapper();
            $tagMapper->insertTag($tag);
            $tagMapper->setId(50);
            
            $this->assertEquals($tag,$tagMapper->selectTag());
        }
        
        public
        function testGet() 
        {
            $tag = new Tag();
            $tag->setId(50);
            $tag->setTitle('test');
            
            $tagMapper = new TagMapper();
            $tagMapper->setId(50);
            
            $this->assertEquals($tag,$tagMapper->selectTag());
        }
        
        public
        function testPut() 
        {
            $tag = new Tag();
            $tag->setId(50);
            $tag->setTitle('test modifié');
            
            $tagMapper = new TagMapper();
            $tagMapper->setId(50);
            $tagMapper->updateTag($tag);
            
            $this->assertEquals($tag,$tagMapper->selectTag());
        }
        
        public
        function testDelete() 
        {
            $tagMapper = new TagMapper();
            $tagMapper->setId(50);
            $tagMapper->deleteTag();

            $this->assertEquals(new Tag(),$tagMapper->selectTag());
        }
    }
