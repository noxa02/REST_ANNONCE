<?php
    include_once dirname(__FILE__).'/config.php';
    class CommentMapperTest extends PHPUnit_Framework_TestCase {
        public function setUp(){}
        public function tearDown(){}

        public
        function testCreate() 
        {
            $comment = new Comment();
            $comment->setId(50);
            $comment->setContent('Très bien');
            $comment->setPostDate('2012-12-21 00:00:00');
            $comment->setIdUser(1);
            $comment->setIdAnnouncement(10);
            
            $commentMapper = new CommentMapper();
            $commentMapper->insertComment($comment);
            $commentMapper->setId(50);
            
            $this->assertEquals($comment,$commentMapper->selectComment());
        }
        
        public
        function testGet() 
        {
            $comment = new Comment();
            $comment->setId(50);
            $comment->setContent('Très bien');
            $comment->setPostDate('2012-12-21 00:00:00');
            $comment->setIdUser(1);
            $comment->setIdAnnouncement(10);
            
            $commentMapper = new CommentMapper();
            $commentMapper->setId(50);
            
            $this->assertEquals($comment,$commentMapper->selectComment());
        }
        
        public
        function testPut() 
        {
            $comment = new Comment();
            $comment->setId(50);
            $comment->setContent('Très bien');
            $comment->setPostDate('2012-12-21 00:00:00');
            $comment->setIdUser(1);
            $comment->setIdAnnouncement(10);
            
            $commentMapper = new CommentMapper();
            $commentMapper->setId(50);
            $commentMapper->updateComment($comment);
            
            $this->assertEquals($comment,$commentMapper->selectComment());
        }
        
        public
        function testDelete() 
        {
            $commentMapper = new CommentMapper();
            $commentMapper->setId(50);
            $commentMapper->deleteComment();

            $this->assertEquals(new Comment(),$commentMapper->selectComment());
        }
    }
