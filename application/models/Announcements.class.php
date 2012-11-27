<?php
/**
 * Description of Announcements
 *
 * @author Hait
 */
class Announcements extends Announcement {
    
    private $SQL;
    
    public
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
    }

    /**
     * GET list of Announcements
     * @return Array Return an array of all the announcements.
     */
    public 
    function getAnnouncements() {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM ANNOUNCEMENT');
                $q->execute();
                $this->SQL->commit();

                return $q->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
}

?>
