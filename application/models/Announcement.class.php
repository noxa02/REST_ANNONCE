<?php
/**
 * Description of Member
 *
 * @author Hait
 */
class Announcement {
    
    private $_id, $_title, $_subtitle, $_content;
    private $_post_date, $_conclued, $SQL;
    
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
    function getConclued()
	{
		return $this->_conclued;
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
    function setConclued($conclued_)
	{
		$this->_conclued = $conclued_;
	}
 
    
    /**
     * GET data of announcement
     */
    public 
    function getAnnouncement($id_) {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM ANNOUNCEMENT WHERE id = :id');
                $q->bindValue('id', $id_);
                $q->execute();
                $this->SQL->commit();
                
                return $q->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
    
    /**
     * POST (Create) Announcement
     */
    public 
    function createAnnouncement() {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('INSERT INTO ANNOUNCEMENT '.
                                         '(title, subtitle, content, post_date, conclued) '.
                                         'VALUES(:title, :subtitle, :content, NOW(), :conlued)');
                $q->bindValue('title', $this->_title, PDO::PARAM_STR);
                $q->bindValue('subtitle', $this->_subtitle, PDO::PARAM_STR);
                $q->bindValue('content', $this->_content,PDO::PARAM_STR);
                $q->bindValue('conlued', $this->_conclued, PDO::PARAM_INT);

                $q->execute();
                $this->SQL->commit();
                
        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
    
    /**
     * PUT (Update) Announcement
     * @param Array $data_ Array of data announcement
     * @param int $id_ Id of announcement
     */
    public 
    function updateAnnouncement($data_, $id_) {
        try {
            $i = 0;
            $q = 'UPDATE ANNOUNCEMENT SET ';

            if(is_array($data_)) { 
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
                $q = $this->SQL->prepare($q);
                $q->execute();
                $this->SQL->commit();
            }
        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
    
    /**
     * POST (Delete) Announcement
     * @param int $id_ Id of announcement 
     */
    public 
    function deleteAnnouncement($id_) {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('DELETE FROM ANNOUNCEMENT '.
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
