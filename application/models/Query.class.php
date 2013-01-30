<?php

class Query extends Mapper {
   
    public
    function getAllItems($table) {
        $items = $this->select($table, true);
        
        return $items;
    }
    
    public
    function getAllItemsWithConditions($table, $conditions) {
        $items = $this->select($table, true, $conditions);

        return $items;  
    }
    
    public
    function initCondition(Url $url, Pager $pager = null, $mapper, $skipColumns = false) {
        try 
        {
            $where = null;
            $args = $url->getUrlArguments();
            $args = (isset($args) && !is_array($args)) 
                       ? array($args) : $args;

            if(isset($args) && (!empty($args) && !is_null($args))) {
                $urlKeys = ( is_array($args)) 
                           ? array_values($args) : array($args);     
            }
            
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
                $filters = array('limit', 'current_page', 'order', 'operator', 'main_key', 'date_operator', 'post_date_end');
                $exceptions = array('post_date_begin');
                $set = array();
                foreach ($conditions as $condition => $value) {
                    if(!in_array($condition, $filters) && !in_array($conditions, $exceptions)) { 
                            if(isset($columns) && !empty($columns) && !in_array($condition, $exceptions)) {
                                if(!in_array($condition, $columns)) throwException ('Column '.$condition.' doesn\'t exist in the table '.$mapper->getTable().'!');
                            }
                            $value = (isset($conditions['operator']) && $conditions['operator'] == 'LIKE') 
                                ? '%'.urldecode($value).'%' : urldecode($value);
                            $value = (is_numeric($value)) ? $value : '"'.$value.'"';
                            if($condition == 'post_date' || $condition == 'post_date_begin') {
                                if(isset($conditions['date_operator'])) {
                                    $set[$condition] = $condition.' '.urldecode($conditions['date_operator']).' '.$value;
                                } else if(isset($conditions['post_date_begin']) 
                                        && isset($conditions['post_date_end']) && $condition == 'post_date_begin') {
                                    $set[$condition] = 'post_date BETWEEN '.
                                    'DATE_FORMAT('.$value.', "%Y-%m-%d-%H-%i-%s") AND '.
                                    'DATE_FORMAT("'.urldecode($conditions['post_date_end']).'", "%Y-%m-%d-%H-%i-%s")';
                                }
                            } else if(isset($conditions['operator']) && $conditions['operator'] == 'LIKE') {
                                $set[$condition] = $condition.' LIKE '.$value;   
                            } else {
                                $set[$condition] = $condition.' = '.$value;   
                            }     
                            $i++; 
                    }
                }

                $operator = (isset($conditions['separator'])) ? $conditions['separator'] : ' AND '; 
                $where = (isset($set) && count($set) > 0) ? ' WHERE ' : '';
                $where .= (isset($set) && !empty($set)) ? implode($operator, $set) : null;
                
                if(isset($conditions['order']) && !empty($conditions['order'])) {
                    $where .= ' ORDER BY '.urldecode($conditions['order']);
                }
                
                if(isset($conditions['limit']) && !empty($conditions['limit']) && !is_null($pager)) {
                    
                    $total = (!is_null($pager->getTotalItems())) ? $pager->getTotalItems() : 0;
                    if($total > 0) {
                        if(!is_null($pager->getCurrentPage()) && !is_null($pager->getLimit())) {
                            $where .= ' LIMIT '.($pager->getCurrentPage() * $pager->getLimit()).', '.$pager->getLimit();
                        } else {
                            $where .= ' LIMIT '.(0 * $pager->getLimit()).', '.$pager->getLimit();
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