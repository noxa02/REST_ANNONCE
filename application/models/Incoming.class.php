<?php
/**
 * Description of Incoming
 *
 * @author Hait
 */
class Incoming {
    
    private $_id;
    private $_title;
    private $_subtitle;
    private $_content;
    private $_post_date;
    private $_id_announcement;
    private $_id_user;
    
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
    function getIdAnnouncement()
	{
		return $this->_id_announcement;
	}
    
 	public 
    function getIdUser()
	{
		return $this->_id_user;
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
    function setIdAnnouncement($id_announcement_) {
        $this->_id_announcement = $id_announcement_;
    }
  
    public
    function setIdUser($id_user_) {
        $this->_id_user = $id_user_;
    }
}
