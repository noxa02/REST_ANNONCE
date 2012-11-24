<?php
/**
 * Description of Members
 *
 * @author Hait
 */
class Users extends User {
    
    private $_members_list;
    private $SQL;
    
    public
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
        $this->_members_list = array();
    }

    /**
     * GET list of members
     */
    public 
    function getMembers() {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM user');
                $q->execute();
                $this->SQL->commit();

                return $q->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
}

?>
