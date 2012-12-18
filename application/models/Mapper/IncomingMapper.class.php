<?php 
class IncomingMapper extends Mapper {
    
    protected $table = 'INCOMING';
    protected $id;

    function __construct() {
        parent::__construct();
    }
    
   /**
    * 
    * @param Incoming $incoming_
    * @param array $arrayFilter
    * @throws InvalidArgumentException
    */
    public 
    function insertIncoming(Incoming $incoming_, array $arrayFilter = array()) 
    {
        try {
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            $userMapper = new UserMapper();
            $userMapper->setId($incoming_->getIdUser());
            $user = $userMapper->selectUser();

            if(!is_null($user->getId())) {
                return parent::insert($this->table, $incoming_, $arrayFilter);
            } elseif(isset($user) && is_null($user->getId())) {
                throw new Exception('User does not exist !');
            }
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @param Incoming $incoming_
     * @throws InvalidArgumentException
     */
    public 
    function updateIncoming(Incoming $incoming_) 
    {
        try {
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(isset($this->id) && !is_null($this->id)) {
                $where = 'id = '.$this->id;
            }

            return parent::update($this->table, $incoming_, $where);    
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
    function selectIncoming($all_ = false) 
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

            return parent::select($this->table, $where, $object = new Incoming(), $all_);    
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
    function deleteIncoming() 
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