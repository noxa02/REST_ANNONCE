<?php
/**
 * Description of Incomings
 *
 * @author Hait
 */
class Incomings extends Incoming {
    
    private $SQL;
    
    public
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
    }

    /**
     * GET list of Incoming
     * @return Array Return an array of all the incomings.
     */
    public 
    function getIncomings() {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM INCOMING');
                $q->execute();
                $this->SQL->commit();

                return $q->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
}

?>
