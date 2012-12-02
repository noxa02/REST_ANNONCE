<?php
/**
 * Description of Incoming
 *
 * @author Hait
 */
class Incoming {
    
    private $_id, $_title, $_subtitle, $_content;
    private $_post_date, $SQL, $_id_administrator;
    
    public 
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
    }
    
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
    function getSubTitle()
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
    function getIdAdministrator()
	{
		return $this->_id_administrator;
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
    function setSubTitle($_subtitle)
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
    function setIdAdministrator($idAdministrator_)
	{
		$this->_id_administrator = $idAdministrator_;
	}   
    
    /**
     * GET data of an Incoming
     */
    public 
    function getIncoming($id_) {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM INCOMING WHERE id = :id');
                $q->bindValue('id', $id_);
                $q->execute();
                $this->SQL->commit();
                
                return $q->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
    
    /**
     * POST (Create) Incoming
     */
    public 
    function createIncoming() {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('INSERT INTO INCOMING '.
                                         '(title, subtitle, content, post_date, id_administrator) '.
                                         'VALUES(:title, :subtitle, :content, NOW(), :idAdministrator)');

                $q->bindValue('title', $this->_title, PDO::PARAM_STR);
                $q->bindValue('subtitle', $this->_subtitle, PDO::PARAM_STR);
                $q->bindValue('content', $this->_content,PDO::PARAM_STR);
                $q->bindValue('idAdministrator', $this->_id_administrator, PDO::PARAM_INT);
                if($q->execute()) {
                    $this->SQL->commit();
                    return true;
                } 
                return false;
                
        } catch (PDOException $e) {
            
            $this->SQL->rollback();
        }	       
    }
    
    /**
     * PUT (Update) Incoming
     * @param Array $data_ Array of data an Incoming
     * @param int $id_ Id of an Incoming
     */
    public 
    function updateIncoming($id_) {
        try {
            $i = 0;
            $q = 'UPDATE INCOMING SET ';
            $newData = Array();
            foreach ($this as $key => $value) {
                $_methodName = ucfirst($key);
                print str_replace('_', '', $_methodName).'<br/>';
                $_method = 'get'.ucfirst($key);
                
                if(method_exists($this, 'get'.$_methodName)) {

                    $newData[$key][] = $incoming_->$_method($value);
                }
            }

            foreach ($data_ as $key => $value) {
                if(!empty($value)) {
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
            print_log($q); exit;
            $q = $this->SQL->prepare($q);
            $q->execute();
            $this->SQL->commit();
        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
    
    /**
     * POST (Delete) Incoming
     * @param int $id_ Id of an Incoming 
     */
    public 
    function deleteIncoming($id_) {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('DELETE FROM INCOMING '.
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
