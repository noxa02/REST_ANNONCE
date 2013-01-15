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
    function insertUser(User $user) 
    {
        try 
        {
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            $conditions = ' WHERE login = "'.$user->getLogin().'"';
            if(!parent::exist('USER', 'User', 'userMapper', $conditions)) {
                return parent::insert($this->getTable(), $user);
            } else {
                throw new Exception('User already exist with login : '.$user->getLogin());
            }
              
            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        } catch(Exception $e) {
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
    function updateUser(User $user_, $conditions = null) 
    {
        try {
            $where = null;
            if(function_exists($this->getTable()) && is_null($this->getTable())) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(function_exists($this->getId()) && !is_null($this->getId()) 
                    && isset($conditions) && is_null($conditions)) {
                $where = ' WHERE id = '.$this->getFirstId();
            } elseif(isset($conditions) && !is_null($conditions)) {
                $where = $conditions;
            }
            
            if(!is_null($where) && parent::exist('USER', 'User', 'userMapper', $where)) {
                parent::update($this->getTable(), $user, $where);
            } else {
                Rest::sendResponse(204, 'User does not exist !');
            }          
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @return boolean
     * @throws InvalidArgumentException
     */
    public 
    function deleteUser($conditions = null) {
        try {
            $where = null;
            if(function_exists($this->getTable()) && is_null($this->getTable())) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(function_exists($this->getId()) && !is_null($this->getId()) 
                    && isset($conditions) && is_null($conditions)) {
                $where = ' WHERE id = '.$this->getFirstId();
            } elseif(isset($conditions) && !is_null($conditions)) {
                $where = $conditions;
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
            $id_user_followed = (isset($objectToFollow->id_user_followed) 
                                    && !empty($objectToFollow->id_user_followed)) 
            ? $objectToFollow->id_user_followed :  $this->getFirstId();
            
            if(isset($id_user_followed) && !empty($id_user_followed) 
                    && isset($objectToFollow->id_user_follower) && !empty($objectToFollow->id_user_follower)) {
                $where = ' WHERE id = (SELECT id_user_follower '.
                             'FROM TO_FOLLOW WHERE id_user_followed = '.$id_user_followed.' '.
                             'AND id_user_follower = '.$objectToFollow->id_user_follower.')';

                return $this->selectUser(false, $where); 
            }
        
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
    public
    function getFollowers($conditions = null) {
        $conditions = (isset($conditions) && !is_null($conditions)) ? $conditions : 
                        ' WHERE id IN (SELECT id_user_follower '.
                                      'FROM TO_FOLLOW WHERE id_user_followed = '.$this->getFirstId().')';
                                      
        return parent::select('USER', $conditions, new User(), true);
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
    function stopFollow($id_followed, $id_follower) {
        try 
        {
                if(!parent::exist('USER', 'User', 'userMapper', ' WHERE id = '.$id_follower)) {
                    throw new Exception('User follower doesn\'t exist !');
                }
                if(!parent::exist('USER', 'User', 'userMapper', ' WHERE id = '.$id_followed)) {
                    throw new Exception('User follewed doesn\'t exist !');
                }        
                $objectFollow = new stdClass();
                $objectFollow->id_user_followed = $id_followed;
                $objectFollow->id_user_follower = $id_follower;
                $user = $this->getFollower($objectFollow);

                if(isset($user) && is_null($user->getId())) {
                    $conditions = 'id_user_followed = '.$id_followed_.' AND '.
                                  'id_user_follower = '.$id_follower_;
                    return parent::delete('TO_FOLLOW', $conditions);
                } else {
                    Rest::sendResponse(404, 'Ressource does not exist !');
                }   
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }

        
        return parent::delete('TO_FOLLOW', $where);
    }
    
    /**
     * POST a User Message
     * @param Message $messageObject_
     * @return boolean
     */
    public
    function sendMessage(Message $messageObject_) {
        try 
        {
            if(!parent::exist('USER', 'User', 'userMapper', ' WHERE id = '.$messageObject->getIdReceiver())) {
                throw new Exception('User receiver doesn\'t exist !');
            }
            if(!parent::exist('USER', 'User', 'userMapper', ' WHERE id = '.$this->getFirstId())) {
                throw new Exception('User sender doesn\'t exist !');
            }        

            $messageObject->setIdSender($this->getFirstId())   ;
            $currentDate = date("Y-m-d H:i:s"); 
            $condition = ' WHERE id_sender = '.$messageObject->getIdSender().
                            ' AND id_receiver = '.$messageObject->getIdReceiver().
                            ' AND date_post = "'.$currentDate.'"';
            $message = $this->getMessage($condition);

            if(!emptyObjectMethod($messageObject) && emptyObjectMethod($message)) {
                $messageMapper = new MessageMapper();

                return $messageMapper->insertMessage($messageObject);
            } else {
                throw new Exception('Message is already existant for this user !');
            }   
            
        } catch(Exception $e) {
            print $e->getMessage(); exit;
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
    function getComment($conditions = null) {
        $commentMapper = new CommentMapper(); 
        if(isset($conditions) && !is_null($conditions)) {
            $where = $conditions;
        } else {
            $where = ' WHERE id_user = '.$this->getFirstId().' AND id = '.$this->getSecondId();
        }
        
        $commentsObjects = $commentMapper->selectComment(false, $where);
        return $commentsObjects;
    }
}