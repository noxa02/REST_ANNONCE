<?php

class Mapper
{
    protected $statement;

    function __construct() 
    {
        $this->statement = PDO_Mysql::getInstance();
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

        $this->statement->prepare($query)
                        ->execute($data);
        
        if($return) {
            return $this->getlastInsertId();
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
            
            if(isset($data) && empty($data)) {
                throw new InvalidArgumentException('Must 1 or more arguments to execute an update query !');
            }
            
            foreach ($data as $column => $value) {
                unset($data[$column]);
                $data[":" . $column] = $value;
                $set[] = $column . " = :" . $column;
            }
          
            $query = 'UPDATE '.$table_.' SET '. implode(', ', $set).' '.
                   (($where_) ? ' WHERE '.$where_ : ' ');
            
            $this->statement->prepare($query)
                            ->execute($data); 
            
        } catch(InvalidArgumentException $e) {
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
        $query = 'SELECT * FROM '.$table_.
                  (($where_) ? ' WHERE '. $where_  : '');
        
        $q = $this->statement->prepare($query);
        $q->execute();
        
         if(!$all_) {
             $data = $q->fetch(PDO::FETCH_ASSOC);
             $object = initObject($data, $object_, true);
        } else {
             $datas = $q->fetchAll(PDO::FETCH_ASSOC);
             foreach ($datas as $data) {
                $object[] = initObject($data, $object_, true);
             }
        }
        
        return $object;
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