<?php

class Mapper
{
    protected $statement;

    function __construct() {
        $this->statement = PDO_Mysql::getInstance();
    }

    public  
    function connect() {
        if(!is_null($this->statement)) {
            return $this->statement;
        }
        
        return $this->statement = PDO_Mysql::getInstance();
    }
    
    public  
    function disconnect() {
        if(!is_null($this->statement)) {
            $this->statement = null;
        }
    }
    
    public
    function getStatement() {
        if(is_null($this->statement)) {
            throw new PDOException('PDOStatement isn\'t initialized ! Currently null.');
        }
        return $this->statement;
    }
    
    public 
    function getlastInsertId($name_ = null) {
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
    
    public
    function insert($table_, $object_) {
        $data = extractData($object_);
        $stmt = $this->connect();
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
    }
    
    public 
    function update($table_, $object_, $where_ = null) {
        $set = array();
        $data = extractData($object_);
        foreach ($data as $column => $value) {
            unset($data[$column]);
            $data[":" . $column] = $value;
            $set[] = $column . " = :" . $column;
        }
        $where = array();
        foreach ($where_ as $column => $value) {
            unset($where_[$column]);
            $where_[':' . $column] = $value;
            $where[] = $column . ' = ' . $value;
        }
        $query = 'UPDATE '.$table_.' SET '. implode(', ', $set).' '.
               (($where) ? ' WHERE '.implode('AND ', $where) : ' ');

        $this->statement->prepare($query)
                        ->execute($data);
    }
    
    public 
    function select($table_, $where_, $object, $all = false) {
        $query = 'SELECT * FROM '.$table_;
        $q = $this->statement->prepare($query);
        $q->execute();
        
         if(!$all) {
             $data = $q->fetch(PDO::FETCH_ASSOC);
             $object_ = initObject($data, $object, true);
        } else {
             $datas = $q->fetchAll(PDO::FETCH_ASSOC);
             foreach ($datas as $data) {
                $object_[] = initObject($data, $object, true);
             }
        }
        return $object_;
    }
    
    public 
    function delete($table_, $where_ = null) {
        $where = array();
        foreach ($where_ as $column => $value) {
            unset($where_[$column]);
            $where_[":" . $column] = $value;
            $where[] = $column . " = " . $value;
        }
        $query = 'DELETE FROM '.$table_. (($where)) ? 'WHERE'.implode('AND ', $where) : '';
    
        $this->statement->prepare($query)
                        ->execute();
    }
}

//
//  public 
//    function select($table_, $where_, $object, $all = false) {
//        $where = ''; 
//        $count = 0;
//        foreach ($where_ as $column => $value) {
//            if(strpos($value, 'operator') !== false) {
//                $value = str_replace('operator=', '', $value);
//                $operators = explode('+', urldecode($value));
//                unset($where_[$column]);
//            } 
//        }
//
//        foreach ($where_ as $column => $value) {
//            if($column !== 'id') {
//                
//                $temp = explode('=', $value);
//                (!is_integer($temp[1])) ? $temp[1] = '"'.$temp[1].'"' : $temp[1];
//                
//                if($count !== count($where_) - 1) {
//                    $where .= $temp[0]. ' = '. $temp[1] . ' ' . $operators[$count]. ' ';
//                    $count++;
//                } else {
//                    $where .= $temp[0]. ' = '. $temp[1];        
//                }  
//            } else {
//                
//                if($count !== count($where_) - 1) {
//                    $where .= $column. ' = '. $value .' ' . $operators[$count];  
//                    $count++;
//                } else {
//                    $where .= $column. ' = '. $value;   
//                }
//                
//            }
//        }
//        $query = 'SELECT * FROM '.$table_.' '.
//                  (($where_) ? ' WHERE '. $where  : ' ');
//        $q = $this->statement->prepare($query);
//        $q->execute();
//        
//         if(!$all) {
//             $data = $q->fetch(PDO::FETCH_ASSOC);
//             $object_ = initObject($data, $object, true);
//        } else {
//             $datas = $q->fetchAll(PDO::FETCH_ASSOC);
//             foreach ($datas as $data) {
//                $object_[] = initObject($data, $object, true);
//             }
//        }
//        return $object_;
//    }