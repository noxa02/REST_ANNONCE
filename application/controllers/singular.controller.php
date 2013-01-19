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
                
                $conditions = ' WHERE '.$mapper->getPrimaryKey().' = '.$urlObject->getIdFirstPart();
                $items = $mapper->select($mapper->getTable(), false, $conditions);
                $data->setData($items);
                $data->setFormat($http->getHttpAccept());
                $data->setOptions($options);
                $data->sendData();               
                
            break;
            case 'delete':
                $mapper = new $mapper();
                $method = 'delete'.$class;

                if($mapper->$method()) {
                    Rest::sendResponse(200);
                }
                    break;
             case 'put':
                try {
                    $method = 'update'.$class;
                    $classInstancied = new $class();
                    $data = $http->getRequestVars();
                    $object = initObject($data, $classInstancied, true);
                    
                    if(!emptyObject($announcementObject)) {
                        $mapper = new $mapper();
                        if($mapper->$method($object)) {
                            Rest::sendResponse(200);
                        }
                    } else {
                        throw new InvalidArgumentException('Arguments are required to make a UPDATE !');
                    }
                } catch(InvalidArgumentException $e) {
                    print $e->getMessage(); exit;
                }
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }
} catch(Exception $e) {
    print $e->getMessage(); exit;
}    