<?php
/**
 * Description of User
 *
 * @author Hait
 */
class User {
    
    private $_id;
    private $_login;
    private $_password;
    private $_name;
    private $_firstname;
    private $_mail;
    private $_address;
    private $_phone;
    private $_portable;
    private $_subscriptionDate;
    private $_hash;
    private $_newsletter;
    private $_role;
      
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
    function setId($_id) 
    {
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
            $this->_password = sha1_password($_password);
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
}