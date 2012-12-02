<?php

class Picture {
    
     private $_id, $_title ,$_alternative ,$_path ,$_height ,$_width;
    
    
    public 
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
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
    function getHeight()
	{
		return $this->_height;
	}
    
	public 
    function getWidth()
	{
		return $this->_width;
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
    function setHeight($_height)
	{
		$this->_height = $_height;
	}

    public 
    function setWidth($_width)
	{
		$this->_width = $_width;
	}
   
    
    /**
     * POST (Create) picture
     */
    public 
    function createPicture() {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('INSERT INTO PICTURE '.
                                         '(title, alternative, path, height, width) '.
                                         'VALUES(:title, :alternative, :path, :height, :width)');
                $q->bindValue('title', $this->_title, PDO::PARAM_STR);
                $q->bindValue('alternative', $this->_alternative, PDO::PARAM_STR);
                $q->bindValue('path', $this->_path,PDO::PARAM_STR);
                $q->bindValue('height', $this->_height, PDO::PARAM_STR);
                $q->bindValue('width', $this->_width, PDO::PARAM_STR);
                $q->execute();
                $this->SQL->commit();
                
        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
    
    /**
     * PUT (Update) picture
     */
    public 
    function updatePicture($data_, $id_) {
        try {
            $i = 0;
            $q = 'UPDATE PICTURE SET ';

            if(is_array($data_)) { 
                foreach ($data_ as $key => $value) {
                    if(!empty($value)) {
                        
                        $_title = $data_['title'];
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
     * POST (Delete) picture
     */
    public 
    function deletePicture($id_) {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('DELETE FROM Picture '.
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
