<?php
/**
 * Description of Member
 *
 * @author Hait
 */
class Announcement {
    
    private $_id;
    private $_title;
    private $_subtitle;
    private $_content;
    private $_post_date;
    private $_type;
    private $_conclued;
    private $_id_user;
    private $_pictures; 
    
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

	public 
    function getSubtitle()
	{
		return $this->_subtitle;
	}

	public 
    function getContent()
	{
		return $this->_content;
	}

	public 
    function getPostDate()
	{
		return $this->_post_date;
	}
    
	public 
    function getConclued()
	{
		return $this->_conclued;
	}

	public 
    function getType()
	{
		return $this->_type;
	}
    
	public 
    function getIdUser()
	{
		return $this->_id_user;
	}
    
    public 
    function getPictures()
	{
		return $this->_pictures;
	}
/**
 * Méthodes SET
 */

	public 
    function setId($id_) {
		$this->_id = $id_;
	}

	public 
    function setTitle($title_)
	{
		$this->_title = $title_;
	}

	public 
    function setSubtitle($_subtitle)
	{
		$this->_subtitle = $_subtitle;
	}

	public 
    function setContent($content_)
	{
		$this->_content = $content_;
	}

	public 
    function setPostDate($postDate_)
	{
		$this->_post_date = $postDate_;
	}

	public 
    function setType($type)
	{
		$this->_type = $type;
	}
    
	public 
    function setIdUser($id_user)
	{
		$this->_id_user = $id_user;
	}
    
    public 
    function setConclued($conclued_)
	{
		$this->_conclued = $conclued_;
	}
 
    public 
    function setPictures($pictures_)
	{
		$this->_pictures = $pictures_;
	}
}
