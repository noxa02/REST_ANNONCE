<?php
class UserMapper extends Mapper {
    
    protected $table = 'USER';
    
    function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Allow to create an user.
     * @param User $user
     */
    public 
    function insertUser(User $user) 
    {
        $conditions = ' WHERE login = "'.$user->getLogin().'"';
        if(!parent::exist('USER', 'User', 'userMapper', $conditions)) {
            return parent::insert($this->getTable(), $user);
        } else {
            Rest::sendResponse(409, 'User already exist with login : '.$user->getLogin());
        }
    } 
    
    /**
     * 
     * @param User $user
     * @param string $conditions
     * @return bool
     */
    public 
    function updateUser(User $user, $conditions = null) 
    {
        if(method_exists($this, 'getId') && !is_null($this->getId()) && is_null($conditions)) {
            $conditions = ' WHERE id = '.$this->getId();
        }

        if(!is_null($conditions) && parent::exist('USER', 'User', 'userMapper', $conditions)) {
            return parent::update($this->getTable(), $user, $conditions);
        } else {
            Rest::sendResponse(204, 'User does not exist !');
        }          
    } 
    
    /**
     * 
     * @param string $conditions
     * @return bool
     */
    public 
    function deleteUser($conditions = null) 
    {
        if(method_exists($this, 'getId') && !is_null($this->getId()) && is_null($conditions)) {
            $conditions = ' WHERE id = '.$this->getId();
        }

        $user = ($user = $this->select($this->getTable(), false, $conditions)) 
                ? initObject($user, new User(), true, false) : null;   

        if(!is_null($user) && !emptyObjectMethod($user)) {
            return parent::delete($this->getTable(), $conditions);  
        } else {
            Rest::sendResponse(204, 'User doesn\'t exist !');
        }
    }
    
    /**
     * 
     * @param stdClass $objectToFollow
     * @return bool
     */
    public
    function getFollower(stdClass $objectToFollow) 
    {
        if(!parent::exist('USER', 'User', 'userMapper', 'WHERE id = '.$objectToFollow->id_user_follower)) {
            Rest::sendResponse(204, 'User follower doesn\'t exist !');
        }

        $id_user_followed = (isset($objectToFollow->id_user_followed) 
                                && !empty($objectToFollow->id_user_followed)) 
                            ? $objectToFollow->id_user_followed :  $this->getFirstId();

        if(isset($id_user_followed) && !empty($id_user_followed) 
                && isset($objectToFollow->id_user_follower) && !empty($objectToFollow->id_user_follower)) {

            $conditions = ' WHERE id = (SELECT id_user_follower '.
                            'FROM TO_FOLLOW WHERE id_user_followed = '.$id_user_followed.' '.
                                                 'AND id_user_follower = '.$objectToFollow->id_user_follower.')';

            return $this->select($this->getTable(), false, $conditions); 
        }
    }
    
    public
    function getFollowers($conditions = null) 
    {
        $conditions = (isset($conditions) && !is_null($conditions)) ? $conditions : 
                        ' WHERE id IN (SELECT id_user_follower '.
                                      'FROM TO_FOLLOW WHERE id_user_followed = '.$this->getFirstId().')';
                                      
        return parent::select($this->getTable(), true, $conditions);
    }
   
    /**
     * 
     * @param stdClass $objectFollow
     * @return bool
     */
    public 
    function goFollow(stdClass $objectFollow) 
    {
        $requiered = array('id_user_follower');
        if(isRequired($requiered, $objectFollow)) {
            if(!parent::exist('USER', 'User', 'userMapper', 
                    ' WHERE id = '.$objectFollow->id_user_follower)) {
                Rest::sendResponse(204, 'User follower doesn\'t exist !');
            }
            if(!parent::exist('USER', 'User', 'userMapper', 'WHERE id = '.$this->getFirstId())) {
                Rest::sendResponse(204, 'User follewed doesn\'t exist !');
            }        

            $objectFollow->id_user_followed = $this->getFirstId();
            $user = $this->getFollower($objectFollow);

            if(!$user) {
                 return parent::insert('TO_FOLLOW', $objectFollow);
            } else {
                Rest::sendResponse(409 ,'User is already followed by this user !');
            }   
        }
    }
    
    /**
     * 
     * @param string $id_followed
     * @param string $id_follower
     * @return bool
     */
    public
    function stopFollow($id_followed, $id_follower) 
    {
        if(!parent::exist('USER', 'User', 'userMapper', ' WHERE id = '.$id_follower)) {
            Rest::sendResponse(204, 'User follower doesn\'t exist !');
        }
        if(!parent::exist('USER', 'User', 'userMapper', ' WHERE id = '.$id_followed)) {
            Rest::sendResponse(204, 'User follewed doesn\'t exist !');
        }        

        $objectFollow = new stdClass();
        $objectFollow->id_user_followed = $id_followed;
        $objectFollow->id_user_follower = $id_follower;
        $user = $this->getFollower($objectFollow);

        if(isset($user) && !empty($user)) {

            $conditions = ' WHERE id_user_followed = '.$id_followed.' AND '.
                                 'id_user_follower = '.$id_follower;
            
            if(!parent::delete('TO_FOLLOW', $conditions)) {
                return false;
            }
            
        } else {
            Rest::sendResponse(204, 'Ressource does not exist !');
        }   
        
        return true;
    }
    
    /**
     * 
     * @param Message $messageObject
     * @return bool
     */
    public
    function sendMessage(Message $message) 
    {
        if(!parent::exist('USER', 'User', 'userMapper', ' WHERE id = '.$message->getIdReceiver())) {
            Rest::sendResponse(204, 'User receiver doesn\'t exist !');
        }
        if(!parent::exist('USER', 'User', 'userMapper', ' WHERE id = '.$this->getFirstId())) {
            Rest::sendResponse(204, 'User sender doesn\'t exist !');
        }        

        $message->setIdSender($this->getFirstId());
        $currentDate = date("Y-m-d H:i:s"); 
        $conditions = ' WHERE id_sender = '.$message->getIdSender().
                        ' AND id_receiver = '.$message->getIdReceiver().
                        ' AND date_post = "'.$currentDate.'"';
        $messageArray = $this->getMessage($conditions);

        if(!emptyObjectMethod($message) && empty($messageArray)) {
            $messageMapper = new MessageMapper();
            return $messageMapper->insertMessage($message);
        } else {
            Rest::sendResponse(409, 'Message is already existant for this user !');
        }   
    }
}