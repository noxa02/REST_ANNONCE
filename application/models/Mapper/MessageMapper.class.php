<?php
class MessageMapper extends Mapper {
    
    protected $table = 'MESSAGE';
    protected $id;
    protected $id_sender;
    protected $id_receiver;
    protected $foreignTable;

    function __construct() {
        parent::__construct();
    }
    
   /**
    * 
    * @param Message $message_
    * @param array $arrayFilter
    * @throws InvalidArgumentException
    */
    public 
    function insertMessage(Message $message_, array $arrayFilter = array()) 
    {
        try {
            
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            
            $userMapper = new UserMapper();
            $userMapper->setId($message_->getIdSender());
            $user_sender = $userMapper->selectUser();
            $userMapper->setId($message_->getIdReceiver());
            $user_receiver = $userMapper->selectUser();
            
            if(!is_null($user_sender->getId()) && !is_null($user_receiver->getId())) {
                return parent::insert($this->table, $message_, $arrayFilter);
            } elseif(is_null($user_sender->getId())) {
                throw new Exception('User sender does not exist !');
            } elseif(is_null($user_receiver->getId())) {
                throw new Exception('User receiver does not exist !');
            }
            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @param Message $message_
     * @throws InvalidArgumentException
     */
    public 
    function updateMessage(Message $message_) 
    {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        $id = $this->getFirstId();
        if(isset($id) && !is_null($id)) {
            $where = 'id = '.$id;
        }
        
        return parent::update($this->table, $message_, $where);
    } 
    
    /**
     * 
     * @return boolean
     * @throws InvalidArgumentException
     */
    public
    function deleteMessage() 
    {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        
        if(isset($this->id) && !is_null($this->id)) {
            $where = 'id = '.$this->getFirstId();
        }
       
        return parent::delete($this->table, $where);
    }    
}