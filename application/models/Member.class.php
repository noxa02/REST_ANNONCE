<?php
/**
 * Description of Member
 *
 * @author Hait
 */
class Member {
    
    private $_login ,$_password ,$_name ,$_firstname ,$_email;
    private $SQL;
    
    public 
    function __construct() {
        $this->SQL = PDO_Mysql::getInstance();
        $this->_login = $this->_password = '';
        $this->_name  = $this->_firstname  = $this->_email = '';
        $this->_id;
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
    
  	public 
    function setUserData($data_) 
    {
        
		if(isset($data_) && count($data_) > 0) {
            
            foreach ($data_ as $key => $value) {
                $_methodName = ucfirst($key);
                $_method = 'set'.ucfirst($key);

                if(method_exists($this, 'set'.$_methodName)) {
                    $this->$_method($value);
                }            
            }
        }
	}
  
   	public 
    function initUserData($login_) 
    {
		$userData = $this->getUserData($login_,true);
        
		if(isset($userData) && count($userData) > 0) {
            
			foreach ($userData as $key => $value) {
                
				$_methodName = ucfirst($key);
				$_method = 'set'.ucfirst($key);
                
				if(method_exists($this, 'set'.$_methodName)) {
					$this->$_method($value);
                }
            }
			return true;
        }
	}
    
/**
 * Méthodes diverses
 */
    
	public 
    function getUserData() 
    {
		try {
                $this->SQL->beginTransaction();
                $q = $this->SQL->prepare('SELECT * FROM user '.
                                         'WHERE id = :id');
                $q->bindValue(':id', mysql_real_escape_string($this->id));
                $q->execute();
                $this->SQL->commit();

                return $q->fetch(PDO::FETCH_ASSOC);
                
		} catch (PDOException $e) {
			$this->SQL->rollback();
		}		
	}

	public function updateUserData() {	
        
		$dataToModify = func_get_args(0);
		$dataToModify = $dataToModify[0];
		$i = 0;
		$q = 'UPDATE user SET ';

		if(is_array($dataToModify)) { 
			foreach ($dataToModify as $key => $value) {
				if(!empty($value)) {
					$_login = $dataToModify['login'];
					if(sizeof($dataToModify) == 1) {
						$q .= $key.' = "'.$value.'"';
                    } elseif(sizeof($dataToModify) > 1 && $i != (sizeof($dataToModify) - 1)) {
						$q .= $key.' = "'.$value.'", ';
                    } elseif($i == (sizeof($dataToModify) - 1)) {
						$q .= $key.' = "'.$value.'" ';
                    }
                }
				$i++;
			}
			$q .= ' WHERE id = '.$this->getId();
			
			$this->SQL->beginTransaction();
			$q2 = $this->SQL->prepare($q);
			$q2->execute();
			$this->SQL->commit();

			$this->setUserData($_login); 
         }
	}

	public 
    function checkUserData($login, $password) 
    {
		if($login != $this->getLogin() 
			|| $password != $this->getPassword()) {
			return false;
        } else {
			return true;
        }
	}
    
    public
    function save() {
        print_logex($this);
    }
}

?>
