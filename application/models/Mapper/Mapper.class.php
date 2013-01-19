<?php

class Mapper
{
    protected $statement;
    protected $id;
    protected $firstId; 
    protected $secondId;
    protected $foreignTable;
    protected $files;
    
    function __construct() 
    {
        global $urlObject;
        $this->id = $urlObject->getIdFirstPart();
        $this->firstId = $urlObject->getIdFirstPart();
        $this->secondId = $urlObject->getIdSecondPart();
        $this->statement = PDO_Mysql::getInstance();
        global $http;
        $this->files = $http->getFiles();
        if(func_num_args() == 1 && is_object(func_get_arg(0))) {
            $object_ = func_get_arg(0);
            $this->foreignTable =  $object_;
        }
    }

    /**
     * 
     * @return PDOObject Initialize a PDO object
     */
    public  
    function connect() 
    {
        if(!is_null($this->statement)) {
            return $this->statement;
        }
        
        return $this->statement = PDO_Mysql::getInstance();
    }
    
    /**
     * Destroy the current PDO statement
     */
    public  
    function disconnect() 
    {
        if(!is_null($this->statement)) {
            $this->statement = null;
        }
    }
    
    /**
     * 
     * @return PDOObject Return the current PDO statement
     * @throws PDOException
     */
    public
    function getStatement() 
    {
        try {
            
            if(is_null($this->statement)) {
                throw new PDOException('PDOStatement isn\'t initialized ! Currently null.');
            }
            
            return $this->statement;      
            
        } catch(PDOException $e) {
            print $e->getMessage(); exit;
        }

    }
    
    /**
     * 
     * @param string $name_
     * @return string Last ID insert with the current statement PDO
     * @throws PDOException
     */
    public 
    function getlastInsertId($name_ = null) 
    {
        try {
            
            if(!$this->statement instanceof PDO) {
                throw new PDOException('$statement isn\'t a PDO Object !');
            }
            if(!is_null($this->getStatement())) {
                return $this->statement->lastInsertId();
            }    
            
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
    
    /**
     * 
     * @param string $table_
     * @param stdClass $object_
     * @param array $arrayFilter
     * @param boolean $return
     * @return boolean
     */
    public
    function insert($table, $object, array $arrayFilter = array(), $return = false) 
    {
        try 
        {
            if(is_a($object, 'stdClass')) {
                $data = (array) $object;
            } else {
                $data = extractData($object, $arrayFilter);
            }
            
            $stmt = $this->connect();
            foreach($data as $key => $value) {
                if(!empty($arrayFilter) && in_array($key, $arrayFilter)) {
                    unset($data[$key]);
                }
            }
            
            $columns = implode(', ', array_keys($data));
            $values  = implode(', :', array_keys($data));

            foreach ($data as $column => $value) {
                unset($data[$column]);
                    $data[":" . $column] = $value;
            }
            
            $query = 'INSERT INTO '.$table.' '.
                   '('.$columns.')  VALUES (:'.$values.')';
            
            return $this->statement->prepare($query)
                                   ->execute($data);
            
        } catch(PDOException $e) {
            print $e->getMessage(); exit;
        }
    }
    
    /**
     * 
     * @param string $table_
     * @param $object_
     * @param array $where_
     * @throws InvalidArgumentException
     */
    public 
    function update($table_, $object_, $where_ = null) 
    {
        try {
            
            $set = array();
            $data = extractData($object_);

            if(isset($data) && empty($data) || is_null($data)) {
                throw new InvalidArgumentException('Must 1 or more arguments to execute an update query !');
            }
            
            foreach ($data as $column => $value) {
                unset($data[$column]);
                $data[":" . $column] = $value;
                $set[] = $column . " = :" . $column;
            }
          
            $query = 'UPDATE '.$table_.' SET '. implode(', ', $set).' '.
                   (($where_) ? ' WHERE '.$where_ : ' ');

            return $this->statement->prepare($query)
                                   ->execute($data); 
            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        } catch(PDOException $e) {
            print $e->getMessage(); exit;
        }
    }
    
    /**
     * 
     * @param string $table
     * @param boolean $all
     * @param string $conditions
     * @return stdClass
     */
    public 
    function select($table, $all = false, $conditions = null) 
    {
        try 
        {   
            $limit = (strpos($conditions, 'LIMIT')) ? strstr($conditions, 'LIMIT') : null;
            $conditions = (strpos($conditions, 'LIMIT')) ? strstr($conditions, 'LIMIT', true) : $conditions;
            $query = 'SELECT * FROM '.$table.
                      (($conditions) ? ' '. $conditions  : '') . ((!is_null($limit)) ? $limit : '');
            
            $q = $this->statement->prepare($query);
            $q->execute();
            
            return ($all) ? $q->fetchAll(PDO::FETCH_ASSOC) : $q->fetch(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            print $e->getMessage(); exit;
        }
    }
    
    /**
     * 
     * @param string $table
     * @param string $where
     * @return boolean 
     */
    public 
    function delete($table, $conditions = null) 
    {
        try 
        {
            $query = 'DELETE FROM '.$table. 
                      (($conditions) ? $conditions  : '');
              
            return $this->statement->prepare($query)
                                   ->execute();     
        } catch(PDOException $e) {
            print $e->getMessage(); exit; 
        }

    }
    
    /**
     * 
     * @param string $table
     */
    public 
    function getColumns() {
        try
        {
            $query = 'SHOW COLUMNS FROM '.$this->getTable();
            
            $q = $this->statement->prepare($query);
            $q->execute();     
            
            return $q->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            print $e->getMessage(); exit; 
        } 
    }

    /**
     * 
     * @return string
     * @throws Exception
     */
    public  
    function getTable() 
    {
        try 
        {
            if(!property_exists($this, 'table')) {
                throw new Exception('Missing attribut "table" to the Mapper !');
            }
            
            return $this->table; 
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
    /**
     * 
     * @return string
     * @throws Exception
     */
    public  
    function getId() 
    {
        try 
        {
            if(!property_exists($this, 'id')) {
                throw new Exception('Missing attribut "id" to the Mapper !');
            }
            
            return $this->id; 
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
 
    /**
     * 
     * @return type
     * @throws Exception
     */
    public
    function getFirstId() {
        try 
        {
            if(!property_exists($this, 'firstId')) {
                throw new Exception('Missing attribut "id" to the Mapper !');
            }
            
            return $this->firstId; 
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }    
    }

    /**
     * 
     * @return string
     * @throws Exception
     */
    public
    function getSecondId() {
        try 
        {
            if(!property_exists($this, 'secondId')) {
                throw new Exception('Missing attribut "id" to the Mapper !');
            }
            
            return $this->secondId; 
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }    
    }
    
    /**
     * 
     * @return Picture
     * @throws Exception
     */
    public  
    function getFiles() 
    {
        try 
        {
            if(!property_exists($this, 'files')) {
                throw new Exception('Missing attribut "files" to the Mapper !');
            }
            
            return $this->files; 
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
   
   /**
    * 
    * @param string $table_
    * @throws Exception
    */ 
   public  
   function setTable($table_) 
   {
        try 
       {
            if(!property_exists($this, 'table')) {
                throw new Exception('Missing attribut "table" to the Mapper !');
            }
            
            $this->table = $table_; 
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
    /**
     * 
     * @param string $id_ 
     * @throws Exception
     */
    public  
    function setId($id_) 
    {
        try 
        {
            if(!property_exists($this, 'id')) {
                throw new Exception('Missing attribut "id" to the Mapper !');
            }
            
            $this->id = $id_; 
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
    /**
     * 
     * @param Picture $files_ 
     * @throws Exception
     */
    public  
    function setFiles($files_) 
    {
        try 
        {
            if(!property_exists($this, 'files')) {
                throw new Exception('Missing attribut "files" to the Mapper !');
            }
            
            $this->files = $files_; 
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
    /**
     * Allow to check if the propertie exist in the class.
     * @param class $class_
     * @param string $property_
     * @return boolean 
     */
    public
    function property_exists($class_, $property_)
    {
      if (!property_exists($class_, $property_)) {
        $reflClass = new ReflectionClass($class);
        return $reflClass->hasProperty($prop);
      } else {
          return property_exists($class_, $property_);
      }
    }
    
    /**
     * Allow to check if the ... exist in the DATABASE.
     * @param string $table
     * @param class $object
     * @param class $mapper
     * @param string $condition
     * @param boolean $multiple
     * @return boolean True if exist | false
     */
    public 
    function exist($table, $object, $mapper, $condition = null, $multiple = false) {
        try 
        {
            $mapper = new $mapper();
            $object = new $object();

            $object = $this->select($table, $condition, $object, $multiple);
            $array = extractData($object);
            
            if(!empty($array)) {
                return true;
            }
            
            return false;
        } catch(Exeception $e) {
            
        }
    }
    
    public
    function getPrimaryKey() 
    {
        $query = 'SHOW KEYS FROM '.$this->getTable().' WHERE Key_name = "PRIMARY"';
        $q = $this->statement->prepare($query);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        
        return (isset($data['Column_name']) && !empty($data['Column_name'])) 
            ? $data['Column_name'] : null;
    }
}