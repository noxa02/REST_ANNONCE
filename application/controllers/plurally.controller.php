<?php 
  
    switch($http->getMethod())
    {
            case 'get':

                $query  = new Query();
                $data   = new Data();
                $options = array (  
                    'indent'         => '     ',  
                    'addDecl'        => false,  
                    "defaultTagName" => strtolower($class),
                     XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                );
                
                $pager->setTotalItems(count($query->getAllItems($mapper->getTable())));
                $limit =  $pager->getLimit();
                $nbPages = (isset($limit) && $limit > 0) ? ceil($pager->getTotalItems() / $pager->getLimit()) : 1;
                $pager->setNbPages($nbPages);
                
                $args = $http->getRequestVars();
                $conditions = (isset($args) && !empty($args)) 
                    ? $query->initCondition($url, $pager, $mapper) : null;

                $items = $mapper->select($mapper->getTable(), true, $conditions);
                $data->setData($items);
                $data->setFormat($http->getHttpAccept());
                $data->setOptions($options);
                $data->sendData();               
                
            break;
                    
            case 'post':

                $query  = new Query();
                $classInstancied = new $class();
                $method = 'insert'.$class;
                $args = $http->getRequestVars();
                $object = initObject($args, $classInstancied, true);
                
                if(!emptyObject($object) && method_exists($mapper, $method)) {
                    if($mapper->$method($object)) {
                        Rest::sendResponse(201);   
                    }             
                } else {
                    Rest::sendResponse(400, 'Need arguments to POST data !');
                }
                
            break;
            default :
                Rest::sendResponse(501);
            break;
    }