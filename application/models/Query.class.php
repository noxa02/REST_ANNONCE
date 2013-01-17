<?php

class Query {
   
    public
    function getAllItems($table) {
        $mapper = new Mapper();
        $items = $mapper->select($table, true);
        
        return $items;
    }
    
    public
    function getAllItemsWithConditions($table, $conditions) {
        $mapper = new Mapper();
        $items = $mapper->select($table, true, $conditions);

        return $items;  
    }
    
    public
    function initCondition(Url $url, Pager $pager = null, $mapper, $skipColumns = false) {
        try 
        {
            $urlKeys = array_values($url->getUrlArguments()); 
            $filters = array('current_page');
            
            if(!$skipColumns) {
                $tableColumns = $mapper->getColumns();
                $columns = array();
                
                if(isset($tableColumns) && is_array($tableColumns) && !empty($tableColumns)) {
                    foreach ($tableColumns as $tableColumn) {
                        if(isset($tableColumn['Field'])) {
                            $columns[] = $tableColumn['Field']; 
                        }
                    }
                }       
            }
            
            if(isset($urlKeys) && is_array($urlKeys) && !empty($urlKeys)) {
                foreach($urlKeys as $key => $value) {
                    $temp[] = explode('=', $value, 2);
                    $conditions[$temp[$key][0]] = $temp[$key][1];
                }
            }
            
            if(isset($conditions) && is_array($conditions) && !empty($conditions)) {
                
                $i = 0;
                $filters = array('limit', 'current_page', 'order', 'operator', 'main_key');
                $where = null;
                $set = array();
                foreach ($conditions as $condition => $value) {
                    if(!in_array($condition, $filters)) { 
                            if(isset($columns) && !empty($columns)) {
                                if(!in_array($condition, $columns)) throwException ('Column '.$condition.' doesn\'t exist in the table '.$mapper->getTable().'!');
                            }
                            $value = (isset($conditions['operator']) && $conditions['operator'] == 'LIKE') 
                                ? '%'.urldecode($value).'%' : urldecode($value);
                            $value = (is_numeric($value)) ? $value : '"'.$value.'"';
                            if(isset($conditions['operator']) && $conditions['operator'] == 'LIKE') {
                                $set[$condition] = $condition.' LIKE '.$value;   
                            } else {
                                $set[$condition] = $condition.' = '.$value;   
                            }     
                            $i++; 
                    }
                }
                
                if(isset($set) && is_array($set) && empty($set)) {
                   $mapper->getPrimaryKey();
                }
                
                $operator = (isset($conditions['separator'])) ? $conditions['separator'] : ' AND '; 
                $where = (isset($conditions['limit']) && isset($set) && count($set) > 0) ? ' WHERE ' : '';
                $where .= (isset($set) && !empty($set)) ? implode($operator, $set) : null;
                
                if(isset($conditions['order']) && !empty($conditions['order'])) {
                    $where .= ' ORDER BY '.urldecode($conditions['order']);
                }
                
                if(isset($conditions['limit']) && !empty($conditions['limit']) && !is_null($pager)) {
                    
                    $total = (!is_null($pager->getTotalItems())) ? $pager->getTotalItems() : 0;
                    
                    if($total > 0) {
                        if(!is_null($pager->getCurrentPage()) && !is_null($pager->getLimit())) {
                            $where .= ' LIMIT '.($pager->getCurrentPage() * $pager->getLimit()).', '.$pager->getLimit();
                        }
                    }
                    
                }
            }

            return $where;

        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
}