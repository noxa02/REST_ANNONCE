<?php
class MessageMapper extends Mapper {
    
    protected $table = 'MESSAGE';
    protected $id;
    protected $id_sender;
    protected $id_receiver;
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
        
        if(isset($this->id) && !is_null($this->id)) {
            $where = 'id = '.$this->id;
        }
        
        return parent::update($this->table, $message_, $where);
    } 
    
    /**
     * 
     * @param boolean $all_
     * @throws InvalidArgumentException
     */
    public
    function selectMessage($all_ = false, $where_ = '') 
    {
        try {
            $where = null;
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            
            if(isset($where_) && !empty($where_)) {
                $where = $where_;
            } elseif(isset($this->foreignTable) && !is_null($this->foreignTable)) {
                $fkName = 'id_'.strtolower($this->foreignTable->getTable());
                $where  = $fkName.' = '.$this->foreignTable->getId();
            } elseif(isset($this->id) && !is_null($this->id)) {
                $where = 'id = '.$this->id;
            }

            return parent::select($this->table, $where, $object = new Message(), $all_);         
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
    function deleteMessage() 
    {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        
        if(isset($this->id) && !is_null($this->id)) {
            $where = 'id = '.$this->id;
        }
       
        return parent::delete($this->table, $where);
    }    
}