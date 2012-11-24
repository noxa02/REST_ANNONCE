<?php
/**
 * Description of Members
 *
 * @author Hait
 */
class User_Follower extends User {
    
    private $SQL;
    
    public
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
    }

    /**
     * GET user who follow the user
     */
    public 
    function getUserFollower($id_) {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM user '.
                                         'WHERE id = :id');
                $q->bindValue('id', $id_);
                $q->execute();
                $this->SQL->commit();

                return $q->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
}

?>
