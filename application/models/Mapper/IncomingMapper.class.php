<?php 
class IncomingMapper extends Mapper {
    
    protected $table = 'INCOMING';
    protected $id;
    protected $id_user;
    protected $id_announcement;

    function __construct() {
        parent::__construct();
        global $url;
        $this->id = $url->getIdFirstPart();
    }
    
   /**
    * 
    * @param Incoming $incoming_
    * @param array $arrayFilter
    * @throws InvalidArgumentException
    */
    public 
    function insert(Incoming $incoming_, array $arrayFilter = array()) 
    {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        $userMapper = new UserMapper();
        $userMapper->setId($incoming_->getIdUser());
        $user = $userMapper->select();
        $announcementMapper = new AnnouncementMapper();
        $announcementMapper->setId($incoming_->getIdAnnouncement());
        $announcement = $announcementMapper->select();

        if(!is_null($user->getId()) && !is_null($announcement->getId())) {
            return parent::insert($this->table, $incoming_, $arrayFilter);
        }
    } 
    
    /**
     * 
     * @param Incoming $incoming_
     * @throws InvalidArgumentException
     */
    public 
    function update(Incoming $incoming_) 
    {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        if(isset($this->id) && !is_null($this->id)) {
            $where = 'id = '.$this->id;
        }
        
        parent::update($this->table, $incoming_, $where);
    } 
    
    /**
     * 
     * @param boolean $all_
     * @return stdClass
     * @throws InvalidArgumentException
     */
    public
    function select($all_ = false) 
    {
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
    }
    
    /**
     * 
     * @return boolean
     * @throws InvalidArgumentException
     */
    public
    function delete() 
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