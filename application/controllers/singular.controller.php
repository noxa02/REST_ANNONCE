<?php 

try {
    /**
     * Get HTTP informations to define the targeted method.
     */
    $http = Rest::initProcess();
    $mapper = getMapper($model);
    $class = getNameByMapper($mapper);

    if(!existMapper($mapper)) throw new Exception('Mapper doesn\'t exist !');

    switch($http->getMethod())
    {
            case 'get':
                $mapper = new $mapper();
                $method = 'select'.$class;
                
                returnXML($urlObject, $mapper, $class, $method, $array, $http);
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