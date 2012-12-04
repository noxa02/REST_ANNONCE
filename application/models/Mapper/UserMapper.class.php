<?php
class UserMapper extends Mapper {
    
    protected $table = 'USER';
    protected $id;

    function __construct() {
        parent::__construct();
        global $url;
        $this->id = $url->getIdFirstPart();
    }
    
    public 
    function insert(User $user_) {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        parent::insert($this->table, $user_);
    } 
    
    public 
    function update(User $user_, $where) {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        parent::update($this->table, $user_, $where);
    } 
    
    public
    function select($all = false) {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        if(isset($this->id) && !is_null($this->id)) {
            $where = 'id = '.$this->id;
        }
        return parent::select($this->table, $where, $object = new User(), $all);
    }
    
    public
    function getFollowers() {
        //TODO
    }
}
