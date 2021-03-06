<?php
class UserMapper extends Mapper {
    
    protected $table = 'USER';
    
    function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * 
     * @param User $user_
     * @throws InvalidArgumentException
     */
    public 
    function insertUser(User $user_) 
    {
        try {
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }

            return parent::insert($this->table, $user_);            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @param User $user_
     * @param string $where_
     * @throws InvalidArgumentException
     */
    public 
    function updateUser(User $user_, $where_ = null) 
    {
        try {
            $where = null;
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(isset($this->id) && !is_null($this->id) && is_null($where_)) {
                $where = 'id = '.$user_->getId();
            } elseif(isset($where_) && !empty($where_)) {
                $where = $where_;
            }
            $userObject = $this->selectUser($where_);
            $userArray = extractData($userObject);
            if(!empty($userArray)) {
                parent::update($this->table, $user_, $where);
            } else {
                throw new Exception('User does not exist !');
            }          
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @param string $all_
     * @return boolean
     * @throws InvalidArgumentException
     */
    public
    function selectUser($all_ = false, $where_ = null) 
    {
        try {
            $where = null;
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }

            if(isset($this->id) && !is_null($this->id) && is_null($where_)) {
                $where = 'id = '.$this->id;
            } elseif(isset($where_) && !is_null($where_)) {
                $where = $where_;
            }

            return parent::select($this->table, $where, $object = new User(), $all_);        
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
    function deleteUser($where_ = null) {
        try {
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }

            if(isset($this->id) && !is_null($this->id) && is_null($where_)) {
                $where = 'id = '.$this->id;
            } elseif(isset($where_) && !empty ($where_)) {
                $where = $where_;
            }

            return parent::delete($this->table, $where);     
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        }
    }
    
    public
    function getFollower() {
        $where = 'id = (SELECT id_user_follower '.
                       'FROM TO_FOLLOW WHERE id_user_followed = '.$this->getFirstId().' '.
                       'AND id_user_follower = '.$this->getSecondId().')';
        
        return $this->selectUser(false, $where);
    }
    
    public
    function getFollowers() {
        $where = 'id IN (SELECT id_user_follower '.
                        'FROM TO_FOLLOW WHERE id_user_followed = '.$this->getFirstId().')';
        
        return $this->selectUser(true, $where);
    }
    
    public 
    function goFollow($id_followed_, $id_follower_) {
        try {
            $userFollow = new stdClass();
            $userFollow->id_user_followed = $id_followed_;
            $userFollow->id_user_follower = $id_follower_;
          
            $user = $this->getFollower();
            if(is_null($user->getId())) {
                 return parent::insert('TO_FOLLOW', $userFollow);
            } else {
                throw new Exception('The user is already followed by this user !');
            }     
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
    public
    function stopFollow($id_followed_, $id_follower_) {
        $where = 'id_user_followed = '.$id_followed_.' AND '.
                 'id_user_follower = '.$id_follower_;
        
        return parent::delete('TO_FOLLOW', $where);
    }
    
    /**
     * POST a User Message
     * @param Message $messageObject_
     * @return boolean
     */
    public
    function sendMessage(Message $messageObject_) {

        if(!emptyObject($messageObject_)) {
            new UserMapper;
            $messageMapper = new MessageMapper();
            $messageObject_->setIdSender($this->getFirstId());
            $messageObject_->setIdReceiver($this->getSecondId());
            if($messageMapper->insertMessage($messageObject_)) {
                return true;
            } 
        } 
    }
    
    public 
    function getMessages() {
        $messageMapper = new MessageMapper();
        $where = 'id_sender = '.$this->getFirstId();
        $messagesObjects = $messageMapper->selectMessage(true, $where);
        
        return $messagesObjects;
    }
    
    /**
     * 
     * @return array 
     */
    public 
    function getMessage() {
        $messageMapper = new MessageMapper();
        $where = 'id_sender = '.$this->getFirstId(). ' AND id_receiver = '.$this->getSecondId();
        $messagesObjects = $messageMapper->selectMessage(true, $where);

        return $messagesObjects;
    }  
    
    public
    function getComments() {
        $commentMapper = new CommentMapper();
        $where = 'id_user = '.$this->getFirstId();
        $commentsObjects = $commentMapper->selectComment(true, $where);
        return $commentsObjects;
    }
    
    public
    function getComment() {
        $commentMapper = new CommentMapper();
        $where = 'id_user = '.$this->getFirstId().' AND id = '.$this->getSecondId();
        $commentsObjects = $commentMapper->selectComment(false, $where);
        return $commentsObjects;
    }
}
