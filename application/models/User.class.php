<?php
/**
 * Description of Member
 *
 * @author Hait
 */
class User {
    
    private $_login ,$_password ,$_name ,$_firstname ,$_email;
    private $SQL;
    
    public 
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
        $this->_login = $this->_password = '';
        $this->_name  = $this->_firstname  = $this->_email = '';
        $this->_id    = null;
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
    function getName()
	{
		return $this->_name;
	}

	public 
    function getFirstname()
	{
		return $this->_firstname;
	}

	public 
    function getLogin()
	{
		return $this->_login;
	}

	public 
    function getPassword()
	{
		return $this->_password;
	}

/**
 * Méthodes SET
 */

	public 
    function setId($_id) {
		$this->_id = $_id;
	}

	public 
    function setName($_name)
	{
		$this->_name = $_name;
	}

	public 
    function setFirstname($_firstname)
	{
		$this->_firstname = $_firstname;
	}

	public 
    function setLogin($_login)
	{
		$this->_login = $_login;
	}

	public 
    function setPassword($_password)
	{
		$this->_password = $_password;
	}
    
    /**
     * GET data of user
     */
    public 
    function getUser($id_) {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM user WHERE id = :id');
                $q->bindValue('id', $id_);
                $q->execute();
                $this->SQL->commit();
                
                return $q->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
    
    /**
     * POST (Create) user
     */
    public 
    function createUser() {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('INSERT INTO user'.
                                         '(name, firstname, login, password) '.
                                         'VALUES(:name, :firstname, :login, :password)');
                $q->bindValue('name', $this->_name, PDO::PARAM_STR);
                $q->bindValue('firstname', $this->_firstname, PDO::PARAM_STR);
                $q->bindValue('login', $this->_login,PDO::PARAM_STR);
                $q->bindValue('password', sha1_password($this->_password), PDO::PARAM_STR);
                $q->execute();
                $this->SQL->commit();
                
        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
    
    /**
     * PUT (Update) user
     */
    public 
    function updateUser($data_, $id_) {
        try {
            $i = 0;
            $q = 'UPDATE user SET ';

            if(is_array($data_)) { 
                foreach ($data_ as $key => $value) {
                    if(!empty($value)) {
                        $_login = $data_['login'];
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
     * POST (Create) user
     */
    public 
    function deleteUser($id_) {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('DELETE FROM user '.
                                         'WHERE id = :id');
                $q->bindValue('id', $id_, PDO::PARAM_INT);
                $q->execute();
                $this->SQL->commit();
                
        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
}
