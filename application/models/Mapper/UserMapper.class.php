<?php
class UserMapper extends Mapper {
    
    protected $table = 'USER';
    protected $id;
    protected $id_user_follower;
    protected $id_user_followed;
    
    function __construct() 
    {
        global $url;
        parent::__construct();
        $this->id = $url->getIdFirstPart();
        $this->id_user_followed = $url->getIdFirstPart();
        $this->id_user_follower = $url->getIdSecondPart();
    }
    
    /**
     * 
     * @param User $user_
     * @throws InvalidArgumentException
     */
    public 
    function insert(User $user_) 
    {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        
        parent::insert($this->table, $user_);
    } 
    
    /**
     * 
     * @param User $user_
     * @param string $where_
     * @throws InvalidArgumentException
     */
    public 
    function update(User $user_, $where_) 
    {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        if(isset($this->id) && !is_null($this->id)) {
            $where_ = 'id = '.$this->id;
        }
        
        parent::update($this->table, $user_, $where_);
    } 
    
    /**
     * 
     * @param string $all_
     * @return boolean
     * @throws InvalidArgumentException
     */
    public
    function select($all_ = false, $where_ = null) 
    {
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
    }
    
    /**
     * 
     * @return boolean
     * @throws InvalidArgumentException
     */
    public 
    function delete() {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        
        if(isset($this->id) && !is_null($this->id) && is_null($where_)) {
            $where = 'id = '.$this->id;
        } else {
            $where = $where_;
        }
        
        return parent::delete($this->table, $where);
    }
    
    public
    function getFollower() {
        $where = 'id = (SELECT id_user_follower '.
                       'FROM TO_FOLLOW WHERE id_user_followed = '.$this->id_user_followed.' '.
                       'AND id_user_follower = '.$this->id_user_follower.')';
        
        return $this->select(false, $where);
    }
    
    public
    function getFollowers() {
        $where = 'id IN (SELECT id_user_follower '.
                        'FROM TO_FOLLOW WHERE id_user_followed = '.$this->id_user_followed.')';
        
        return $this->select(true, $where);
    }
    
    public 
    function goFollow($id_followed_, $id_follower_) {
        try {
            $userFollow = new stdClass();
            $userFollow->id_user_followed = $id_followed_;
            $userFollow->id_user_follower = $id_follower_;
          
            $user = $this->getFollower();
            if(is_null($user->getId())) {
                 parent::insert('TO_FOLLOW', $userFollow);
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
}
