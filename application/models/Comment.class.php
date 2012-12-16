<?php

class Comment {
    
     private $_id;
     private $_content; 
     private $_date_post;
     private $_id_user;
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
    function getContent()
	{
		return $this->_content;
	}

	public 
    function getDatePost()
	{
		return $this->_date_post;
	}

	public 
    function getIdUser()
	{
		return $this->_id_user;
	} 

    public 
    function getIdAnnouncement()
	{
		return $this->_id_announcement;
	} 
/**
 * Méthodes SET
 */

	public 
    function setId($id_) {
		$this->_id = $id_;
	}

	public 
    function setContent($content_)
	{
		$this->_content = $content_;
	}

	public 
    function setDatePost($date_post_)
	{
		$this->_date_post = $date_post_;
	}

	public 
    function setIdUser($id_user_)
	{
		$this->_id_user = $id_user_;
	}
    
 	public 
    function setIdAnnouncement($id_announcement_)
	{
		$this->_id_announcement = $id_announcement_;
	}
}
