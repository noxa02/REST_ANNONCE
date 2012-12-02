<?php
/**
 * Description of Users
 *
 * @author Hait
 */
class Users {
    
    private $SQL;
    
    public
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
    }

    /**
     * GET list of Users
     */
    public 
    function getUsers() {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM USER');
                $q->execute();
                $this->SQL->commit();

                return $q->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
}

?>
