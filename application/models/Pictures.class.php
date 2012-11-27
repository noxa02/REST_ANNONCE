<?php
/**
 * Description of Incomings
 *
 * @author Hait
 */
class Pictures extends Picture {
    
    private $SQL;
    
    public
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
    }

    /**
     * GET list of pictures
     * @return Array Return an array of all the pictures.
     */
    public 
    function getPictures() {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM PICTURE');
                $q->execute();
                $this->SQL->commit();

                return $q->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
}

