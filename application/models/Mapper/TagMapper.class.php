<?php

class TagMapper extends Mapper {
    
    protected $table = 'TAG';

    function __construct() {
        parent::__construct();
    }
    
   /**
    * Allow to create a tag.
    * @param Tag $tag_
    * @param array $arrayFilter
    * @throws InvalidArgumentException
    */
    public 
    function insertTag(Tag $tag_, array $arrayFilter = array()) 
    {
        try 
        {
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }

            return parent::insert($this->table, $tag_, $arrayFilter);
            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * Allow to update a tag.
     * @param Tag $tag_
     * @throws InvalidArgumentException
     */
    public 
    function updateTag(Tag $tag_) 
    {
        try {
            
            if(is_null($this->getTable())) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(!is_null($this->getFirstId())) {
                $where = 'id = '.$this->getFirstId();
            }
            
            if(parent::exist('TAG', 'Tag', 'tagMapper', $where)) {
                return parent::update($this->getTable(), $tag_, $where);
            } else {
                throw new Exception('Tag does not exist !');
            }
            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        } catch(Exception $e) {
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
    function selectTag($all_ = false) 
    {   
        try {
            $where = null;
            if(is_null($this->getTable())) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(!is_null($this->getFirstId())) {
                $where = 'id = '.$this->getFirstId();
            }

            return parent::select($this->getTable(), $where, $object = new Tag(), $all_);        
            
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
    function deleteTag() 
    {
        try {
            if(is_null($this->getTable())) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }

            if(!is_null($this->getFirstId())) {
                $where = 'id = '.$this->getFirstId();
            }

            return parent::delete($this->getTable(), $where);  
            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        }

    }    
}