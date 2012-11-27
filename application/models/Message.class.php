<?php

class Message {
    
     private $_id, $_subject ,$_content ,$_date_post;
    
    
    public 
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
        $this->_subject = $this->_content = '';
        $this->_date_post = '';
        $this->_id = '';
    }
    
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


/**
 * Méthodes SET
 */

	public 
    function setId($_id) {
		$this->_id = $_id;
	}

	public 
    function setSubject($_subject)
	{
		$this->_subject = $_subject;
	}

	public 
    function setContent($_content)
	{
		$this->_content = $_content;
	}

	public 
    function setDatePost($_date_post)
	{
		$this->_date_post = $_date_post;
	}

   
    
    /**
     * POST (Create) message
     */
    public 
    function createMessage() {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('INSERT INTO MESSAGE '.
                                         '(subject, content, date_post) '.
                                         'VALUES(:subject, :content, NOW())');
                $q->bindValue('subject', $this->_subject, PDO::PARAM_STR);
                $q->bindValue('content', $this->_content, PDO::PARAM_STR);
                $q->execute();
                $this->SQL->commit();
                
        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
    
    /**
     * PUT (Update) message
     */
    public 
    function updateMessage($data_, $id_) {
        try {
            $i = 0;
            $q = 'UPDATE MESSAGE SET ';

            if(is_array($data_)) { 
                foreach ($data_ as $key => $value) {
                    if(!empty($value)) {
                        
                        $_content = $data_['content'];
                        if(sizeof($data_) == 1) {
                            $q .= $key.' = "'.$value.'"';
                        } elseif(sizeof($data_) > 1 && $i != (sizeof($data_) - 1)) {
                            $q .= $key.' = "'.$value.'", ';
                        } elseif($i == (sizeof($data_) - 1)) {
                            $q .= $key.' = "'.$value.'" ';
                        }
                    }
                    $i++;
                }
                $q .= ' WHERE id = '.$id_;
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare($q);
                $q->execute();
                $this->SQL->commit();
            }
        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
    
    /**
     * POST (Delete) message
     */
    public 
    function deleteMessage($id_) {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('DELETE FROM MESSAGE '.
                                         'WHERE id = :id');
                $q->bindValue('id', $id_, PDO::PARAM_INT);
                $q->execute();
                $this->SQL->commit();
                
                return true;
                
        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
    
}
