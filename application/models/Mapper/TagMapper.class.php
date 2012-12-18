<?php

class TagMapper extends Mapper {
    
    protected $table = 'TAG';

    function __construct() {
        parent::__construct();
    }
    
   /**
    * 
    * @param Tag $tag_
    * @param array $arrayFilter
    * @throws InvalidArgumentException
    */
    public 
    function insertTag(Tag $tag_, array $arrayFilter = array()) 
    {
        try {
            
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }

            return parent::insert($this->table, $tag_, $arrayFilter);
            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @param Tag $tag_
     * @throws InvalidArgumentException
     */
    public 
    function updateTag(Tag $tag_) 
    {
        try {
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(isset($this->id) && !is_null($this->id)) {
                $where = 'id = '.$this->id;
            }
            
            $tagMapper = new TagMapper();
            $tagMapper->setId($message_->getIdSender());
            $tag = $tagMapper->selectTag();
            
            if(!is_null($tag->getId())) {
                return parent::update($this->table, $tag_, $where);
            } elseif(is_null($tag->getId())) {
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
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(isset($this->id) && !is_null($this->id)) {
                $where = 'id = '.$this->id;
            }

            return parent::select($this->table, $where, $object = new Tag(), $all_);        
            
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