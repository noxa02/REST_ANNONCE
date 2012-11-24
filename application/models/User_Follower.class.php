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
    function getUserFollower($id_followed_, $id_follower_) {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM user '.
                                         'WHERE id = (SELECT id_user_follower '.
                                                      'FROM TO_FOLLOW WHERE id_user_followed = :id_followed '.
                                         'AND id_user_follower = :id_follower)');
                $q->bindValue('id_followed', $id_followed_);
                $q->bindValue('id_follower', $id_follower_);
                $q->execute();
                $this->SQL->commit();

                return $q->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
}

?>
