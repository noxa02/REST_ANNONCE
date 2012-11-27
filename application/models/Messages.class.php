<?php
/**
 * Description of Incomings
 *
 * @author Hait
 */
class Messages extends Message {
    
    private $SQL;
    
    public
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
    }

    /**
     * GET list of messages
     * @return Array Return an array of all the messages.
     */
    public 
    function getMessages() {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM MESSAGE');
                $q->execute();
                $this->SQL->commit();

                return $q->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
}
