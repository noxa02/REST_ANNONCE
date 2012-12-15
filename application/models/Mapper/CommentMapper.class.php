<?php
class CommentMapper extends Mapper {
    
    protected $table = 'COMMENT';
    protected $id;
    protected $id_user;
    protected $id_announcement;
    protected $foreignTable;

    function __construct() {
        parent::__construct();
        global $url;
        $this->id = $url->getIdFirstPart();
        
        if(func_num_args() == 1 && is_object(func_get_arg(0))) {
            $object_ = func_get_arg(0);
            $this->foreignTable =  $object_;
        }
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
            $userMapper = new UserMapper();
            $userMapper->setId($comment_->getIdUser());
            $user = $userMapper->selectUser();
            $userMapper->setId($comment_->getIdAnnouncement());
            $announcement = $userMapper->selectUser();

            if(!is_null($user->getId()) && !is_null($announcement->getId())) {
                return parent::insert($this->table, $comment_, $arrayFilter);
            }         
        } catch(InvalidArgumentException $e) {
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
            if(isset($this->id) && !is_null($this->id)) {
                $where = 'id = '.$this->id;
            }

            return parent::update($this->table, $comment_, $where);        
        } catch(InvalidArgumentException $e) {
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
    function selectComment($all_ = false) 
    {
        try {
            $where = null;
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }

            if(isset($this->foreignTable) && !is_null($this->foreignTable)) {
                $fkName = 'id_'.strtolower($this->foreignTable->getTable());
                $where  = $fkName.' = '.$this->foreignTable->getId();
            } elseif(isset($this->id) && !is_null($this->id)) {
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