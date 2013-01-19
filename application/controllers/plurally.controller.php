<?php 
try 
{   
    if(!$router->existMapper($mapper)) throw new Exception('Mapper doesn\'t exist !');

    switch($http->getMethod())
    {
            case 'get':
                
                $mapper = new $mapper();
                $query  = new Query();
                $data   = new Data();
                $options = array (  
                    'indent' => '     ',  
                    'addDecl' => false,  
                    XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                    "defaultTagName"     => strtolower($class),
                );
                
                $pager->setTotalItems(count($query->getAllItems($mapper->getTable())));
                $pager->setNbPages(ceil($pager->getTotalItems() / $pager->getLimit()));
                
                $args = $http->getRequestVars();
                $conditions = (isset($args) && !empty($args)) 
                    ? $query->initCondition($urlObject, $pager, $mapper, true) : null;
                
                $items = $mapper->select($mapper->getTable(), true, $conditions);
                $data->setData($items);
                $data->setFormat($http->getHttpAccept());
                $data->setOptions($options);
                $data->sendData();               
                
            break;
                    
            case 'post':
                
                $mapper = new $mapper();
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
                        throw new InvalidArgumentException('Need arguments to POST data !');
                    }
            default :
                Rest::sendResponse(501);
                    break;
    }
} catch (Exception $e) {
    print $e->getMessage(); exit;
} catch(InvalidArgumentException $e) {
    print $e->getMessage(); exit;
}  