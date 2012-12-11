<?php

class Message {
    
     private $_id;
     private $_subject;
     private $_content; 
     private $_date_post;
     private $_id_sender;
     private $_id_receiver;
    
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
    function getSubject()
	{
		return $this->_subject;
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
    function getIdSender()
	{
		return $this->_id_sender;
	} 

    public 
    function getIdReceiver()
	{
		return $this->_id_receiver;
	} 
/**
 * Méthodes SET
 */

	public 
    function setId($id_) {
		$this->_id = $id_;
	}

	public 
    function setSubject($subject_)
	{
		$this->_subject = $subject_;
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
    function setIdSender($id_sender_)
	{
		$this->_id_sender = $id_sender_;
	}
    
 	public 
    function setIdReceiver($id_receiver_)
	{
		$this->_id_receiver = $id_receiver_;
	}
}
