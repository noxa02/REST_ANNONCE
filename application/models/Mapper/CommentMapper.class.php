<?php
class CommentMapper extends Mapper {
    
    protected $table = 'COMMENT';

    function __construct() {
        parent::__construct();
    }
    
   /**
    * 
    * @param Comment $comment_
    * @param array $arrayFilter
    * @throws InvalidArgumentException
    */
    public 
    function insertComment(Comment $comment_, array $arrayFilter = array()) 
    {
        try {
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            
            $user = parent::exist('USER', 'User', 'userMapper', 'id = '.$comment_->getIdUser());
            $announcement = parent::exist('ANNOUNCEMENT', 'Announcement', 'announcementMapper', 'id = '.$comment_->getIdUser());
            
            if($user && $announcement) {
                return parent::insert($this->table, $comment_, $arrayFilter);
            } elseif(!$user) {
                throw new Exception('User is inexistant !');
            } elseif(!$announcement) {
                throw new Exception('Announcement is inexistant !');
            } 
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @param Comment $comment_
     * @throws InvalidArgumentException
     */
    public 
    function updateComment(Comment $comment_) 
    {
        try {
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(!is_null($this->getId())) {
                $where = 'id = '.$this->getId();
            }
            
            $comment = $this->selectComment();
            if(!emptyObjectMethod($comment)) {
                return parent::update($this->getTable(), $comment_, $where);   
            } else {
                throw new Exception('Comment doesn\'t exist !');
            }
        
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @param boolean $all_
     * @return stdClass
     * @throws InvalidArgumentException
     */
    public
    function selectComment($all_ = false, $where_ = null) 
    {
        try {
            $where = null;
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(isset($where_) && !empty($where_)) {
                $where = $where_;
            } elseif(isset($this->id) && !is_null($this->id) && empty($where_)) {
                $where = 'id = '.$this->id;
            }

            return parent::select($this->table, $where, $object = new Comment(), $all_);     
            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        }
    }
    
    /**
     * 
     * @return boolean
     * @throws InvalidArgumentException
     */
    public
    function deleteComment() 
    {
        try {
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }

            if(isset($this->id) && !is_null($this->id)) {
                $where = 'id = '.$this->id;
            }

            return parent::delete($this->table, $where);         
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        }
    }    
}