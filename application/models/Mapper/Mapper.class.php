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
        global $url;
        $this->id = $url->getIdFirstPart();
        $this->firstId = $url->getIdFirstPart();
        $this->secondId = $url->getIdSecondPart();
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
        if(is_null($this->statement)) {
            throw new PDOException('PDOStatement isn\'t initialized ! Currently null.');
        }
        return $this->statement;
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
            if(!is_null($this->statement)) {
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
    function insert($table_, $object_, array $arrayFilter = array(), $return = false) 
    {
        try {
            if(is_a($object_, 'stdClass')) {
                $data = (array) $object_;
            } else {
                $data = extractData($object_, $arrayFilter);
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
            
            $query = 'INSERT INTO '.$table_.' '.
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
     * @param string $table_
     * @param string $where_
     * @param stdClass $object_
     * @param boolean $all_
     * @return stdClass
     */
    public 
    function select($table_, $where_ = null, $object_, $all_ = false) 
    {
        try {
            $query = 'SELECT * FROM '.$table_.
                      (($where_) ? ' WHERE '. $where_  : '');
            
            $q = $this->statement->prepare($query);
            $q->execute();
            
            $object = array();
             if(!$all_) {
                 $data = $q->fetch(PDO::FETCH_ASSOC);
                 $object = initObject($data, $object_, true);
            } else {
                 $datas = $q->fetchAll(PDO::FETCH_ASSOC);
                 foreach ($datas as $data) {
                     array_push($object, initObject($data, $object_, true)); 
                 }
            }
            
            return $object;            
        } catch(PDOException $e) {
            $e->getMessage(); exit;
        }
    }
    
    /**
     * 
     * @param string $table_
     * @param string $where_
     * @return boolean 
     */
    public 
    function delete($table_, $where_ = null) 
    {
        try {
            $query = 'DELETE FROM '.$table_. 
                      (($where_) ? ' WHERE '. $where_  : '');
            
            return $this->statement->prepare($query)
                                   ->execute();     
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
        try {
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
        try {
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
        try {
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
        try {
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
        try {
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
        try {
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
        try {
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
        try {
            if(!property_exists($this, 'files')) {
                throw new Exception('Missing attribut "files" to the Mapper !');
            }
            
            $this->files = $files_; 
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
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
}