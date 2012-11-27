<?php
/**
 * Description of Members
 *
 * @author Hait
 */
class User_Followers extends User {
    
    private $SQL;
    
    public
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
    }

    /**
     * GET list of members who follow the user
     */
    public 
    function getUsersFollowers($id_) {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM USER '.
                                         'WHERE id IN (SELECT id_user_follower '.
                                                      'FROM TO_FOLLOW WHERE id_user_followed = :id)');
                $q->bindValue('id', $id_);
                $q->execute();
                $this->SQL->commit();

                return $q->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
}

?>
