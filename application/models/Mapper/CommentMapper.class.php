<?php
class CommentMapper extends Mapper {
    
    protected $table = 'COMMENT';

    function __construct() {
        parent::__construct();
    }
    
    /**
     * 
     * @param Comment $comment
     * @param array $arrayFilter
     * @return bool
     */
    public 
    function insertComment(Comment $comment, array $arrayFilter = array()) 
    {
        if(!parent::exist('USER', 'User', 'userMapper', 
                ' WHERE id = '.$comment->getIdUser())) {
            Rest::sendResponse(404, 'User doesn\'t exist !');
        }
        if(!parent::exist('ANNOUNCEMENT', 'Announcement', 'announcementMapper', 
                ' WHERE id = '.$comment->getIdAnnouncement())) {
            Rest::sendResponse(404, 'Announcement doesn\'t exist !');
        }
        
        return parent::insert($this->getTable(), $comment, $arrayFilter);
    } 
    
    /**
     * 
     * @param Comment $comment
     * @param string $conditions
     * @return bool
     */
    public 
    function updateComment(Comment $comment, $conditions = null) 
    {
        if(method_exists($this, 'getId') && !is_null($this->getId()) && is_null($conditions)) {
            $conditions = ' WHERE id = '.$this->getId();
        }
            
        if(!is_null($conditions) && parent::exist('COMMENT', 'Comment', 'commentMapper', $conditions)) {
            return parent::update($this->getTable(), $user, $conditions);
        } else {
            Rest::sendResponse(404, 'Comment does not exist !');
        }
    } 

    /**
     * 
     * @return bool
     */
    public
    function deleteComment() 
    {
        if(method_exists($this, 'getId') && !is_null($this->getId()) && is_null($conditions)) {
            $conditions = ' WHERE id = '.$this->getId();
        }

        $comment = ($comment = $this->select($this->getTable(), false, $conditions)) 
                   ? initObject($comment, new Comment(), true, false) : null;   

        if(!is_null($comment) && !emptyObjectMethod($comment)) {
            return parent::delete($this->getTable(), $conditions);    
        } else {
            Rest::sendResponse(404, 'Comment doesn\'t exist !');
        }
    }    
}