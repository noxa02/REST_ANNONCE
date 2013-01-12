<?php
class UserMapper extends Mapper {
    
    protected $table = 'USER';
    
    function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Allow to create a user.
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
     * Allow to modify a user.
     * @param User $user_
     * @param string $where_ Query condition.
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
            if(isset($this->id) && !is_null($this->id) && !is_null($where_)) {
                $where = $where_;
            } elseif(is_null($where_)) {
                $where = 'id = '.$this->getFirstId();
            }
            
            if(parent::exist('USER', 'User', 'userMapper', $where)) {
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
    function getFollower(stdClass $objectToFollow) {
        try 
        {
            if(!parent::exist('USER', 'User', 'userMapper', 'WHERE id = '.$objectToFollow->id_user_follower)) {
                throw new Exception('User follower doesn\'t exist !');
            }
            
            $where = 'WHERE id = (SELECT id_user_follower '.
                        'FROM TO_FOLLOW WHERE id_user_followed = '.$this->getFirstId().' '.
                        'AND id_user_follower = '.$objectToFollow->id_user_follower.')';
        
            return $this->selectUser(false, $where); 
        
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
    public
    function getFollowers() {
        $where = 'WHERE id IN (SELECT id_user_follower '.
                    'FROM TO_FOLLOW WHERE id_user_followed = '.$this->getFirstId().')';
        
        return $this->selectUser(true, $where);
    }
   
    /**
     * Allow a user to follow a other user.
     * @param string $id_followed_ User followed
     * @param string $id_follower_ User follower
     * @return boolean True the query is executed | False
     * @throws Exception
     */
    public 
    function goFollow(stdClass $objectFollow) {
        try 
        {
            $requiered = array('id_user_follower');
            if(isRequired($requiered, $objectFollow)) {
                if(!parent::exist('USER', 'User', 'userMapper', 'WHERE id = '.$objectFollow->id_user_follower)) {
                    throw new Exception('User follower doesn\'t exist !');
                }
                if(!parent::exist('USER', 'User', 'userMapper', 'WHERE id = '.$this->getFirstId())) {
                    throw new Exception('User follewed doesn\'t exist !');
                }        

                $objectFollow->id_user_followed = $this->getFirstId();
                $user = $this->getFollower($objectFollow);

                if(is_null($user->getId())) {
                     return parent::insert('TO_FOLLOW', $objectFollow);
                } else {
                    throw new Exception('User is already followed by this user !');
                }   
            }
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
    /**
     * Allow a user to stop follower another user.
     * @param string $id_followed_ User followed
     * @param string $id_follower_ User follower
     * @return boolean True the query is executed | False
     */
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
    function getMessages($conditions = null) {
        $messageMapper = new MessageMapper();
        $messagesObjects = $messageMapper->selectMessage(true, $conditions);
        
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
    function getComments($conditions = null) {
        $commentMapper = new CommentMapper();
        $commentsObjects = $commentMapper->selectComment(true, $conditions);
        
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
