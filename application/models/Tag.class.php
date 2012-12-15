<?php
/**
 * Description of User
 *
 * @author Hait
 */
class Tag {
    
    private $_id;
    private $_libelle;
      
/**
 * Méthodes GET
 */
    
    public 
    function getId() 
    {
            return $this->_id;
    }

    public 
    function getLibelle()
    {
            return $this->_libelle;
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
    function setLibelle($libelle_)
    {
            $this->_libelle = $libelle_;
    }

}