<?php
/**
 * Description of User
 *
 * @author Hait
 */
class User {
    
    private $_id, $_login ,$_password ,$_name ,$_firstname ,$_mail;
    private $_address ,$_phone ,$_portable ,$_subscriptionDate ,$_hash;
    private $_newsletter, $SQL;
    
    public 
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
        $this->_login = $this->_password = '';
        $this->_name  = $this->_firstname  = $this->_mail = '';
        $this->_address  = $this->_phone  = $this->_portable = '';
        $this->_subscriptionDate  = $this->_hash  = $this->_newsletter = '';
        $this->_id = $this->_role = '';
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
    
	public 
    function getMail()
	{
		return $this->_mail;
	}
    
 	public 
    function getAddress()
	{
		return $this->_address;
	}
    
    public 
    function getPhone()
	{
		return $this->_phone;
	}
    
    public 
    function getPortable()
	{
		return $this->_portable;
	}
    
    public 
    function getSubscriptionDate()
	{
		return $this->_subscriptionDate;
	}
    
    public 
    function getHash()
	{
		return $this->_hash;
	}
    
    public 
    function getNewsletter()
	{
		return $this->_newsletter;
	}
    
    public 
    function getRole()
	{
		return $this->_role;
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

    public 
    function setMail($mail_)
	{
		$this->_mail = $mail_;
	}
    
 	public 
    function setAddress($address_)
	{
		$this->_address = $address_;
	}
    
    public 
    function setPhone($phone_)
	{
		$this->_phone = $phone_;
	}
    
    public 
    function setPortable($portable_)
	{
		$this->_portable = $portable_;
	}
    
    public 
    function setSubscriptionDate($subscriptionDate_)
	{
		$this->_subscriptionDate = $subscriptionDate_;
	}
    
    public 
    function setHash($hash_)
	{
		$this->_hash = $hash_;
	}
    
    public 
    function setNewsletter($newsletter_)
	{
		$this->_newsletter = $newsletter_;
	}
    
    public 
    function setRole($role_)
	{
		$this->_role = $role_;
	}
    
    /**
     * GET data of user
     */
    public 
    function getUser($id_) {
        try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM USER WHERE id = :id');
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
                $q = $this->SQL->prepare('INSERT INTO USER '.
                                         '(name, firstname, login, password, mail, address, phone,  '.
                                         'portable, subscription_date, hash, newsletter, role) '.
                                         'VALUES(:name, :firstname, :login, :password, :mail, '.
                                         ':address , :phone, :portable, NOW(), :hash, '.
                                         ':newsletter, :role)');
                $q->bindValue('name', $this->_name, PDO::PARAM_STR);
                $q->bindValue('firstname', $this->_firstname, PDO::PARAM_STR);
                $q->bindValue('login', $this->_login,PDO::PARAM_STR);
                $q->bindValue('password', sha1_password($this->_password), PDO::PARAM_STR);
                $q->bindValue('mail', $this->_mail, PDO::PARAM_STR);
                $q->bindValue('address', $this->_address, PDO::PARAM_STR);
                $q->bindValue('phone', $this->_phone, PDO::PARAM_STR);
                $q->bindValue('portable', $this->_portable, PDO::PARAM_STR);
                $q->bindValue('hash', $this->_hash, PDO::PARAM_STR);
                $q->bindValue('newsletter', $this->_newsletter, PDO::PARAM_INT);
                $q->bindValue('role', $this->_role, PDO::PARAM_STR);

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
            $q = 'UPDATE USER SET ';

            if(is_array($data_)) { 
                foreach ($data_ as $key => $value) {
                    if(!empty($value)) {
                        if($key === 'password') {
                            $value = sha1_password($value);
                        }
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
     * POST (Delete) user
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
                
                return true;
                
        } catch (PDOException $e) {
            $this->SQL->rollback();
        }	       
    }
}
