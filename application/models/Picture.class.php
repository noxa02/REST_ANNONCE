<?php

class Picture {
    
     private $_id;
     private $_title;
     private $_alternative;
     private $_path;
     private $_extension;
     private $_tmp_name;
     private $_size;
     private $_type;
     private $_id_announcement;
     
    /**
     * 
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

	public 
    function getAlternative()
	{
		return $this->_alternative;
	}

	public 
    function getPath()
	{
		return $this->_path;
	}

	public 
    function getTmpName()
	{
		return $this->_tmp_name;
	}

    public 
    function getSize()
	{
		return $this->_size;
	}
    
	public 
    function getType()
	{
		return $this->_type;
	}
    
    public
    function getIdAnnouncement() {
        return $this->_id_announcement;
    }
    
    public
    function getExtension() {
        return $this->_extension;
    }
/**
 * Méthodes SET
 */

	public 
    function setId($_id) {
		$this->_id = $_id;
	}

	public 
    function setTitle($_title)
	{
		$this->_title = $_title;
	}

	public 
    function setPath($_path)
	{
		$this->_path = $_path;
	}

	public 
    function setAlternative($_alternative)
	{
		$this->_alternative = $_alternative;
	}
   
	public 
    function setTmpName($tmp_name_)
	{
		$this->_tmp_name = $tmp_name_;
	}

    public 
    function setSize($size_)
	{
		$this->_size = $size_;
	}
    
	public 
    function setType($type_)
	{
		$this->_type = $type_;
	}
    
    public
    function setIdAnnouncement($idAnnouncement_) {
        $this->_id_announcement = $idAnnouncement_;
    }
    
    public
    function setExtension($extension_) {
        $this->_extension = $extension_;
    }
}
