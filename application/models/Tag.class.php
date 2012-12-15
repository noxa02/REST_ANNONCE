<?php
/**
 * Description of User
 *
 * @author Hait
 */
class Tag {
    
    private $_id;
    private $_title;
      
/**
 * Méthodes GET
 */
    
    public 
    function getId() 
    {
            return $this->_id;
    }

    public 
    function getTitle()
    {
            return $this->_title;
    }

/**
 * Méthodes SET
 */

    public 
    function setId($id_) 
    {
            $this->_id = $id_;
    }

    public 
    function setTitle($title_)
    {
            $this->_title = $title_;
    }

}