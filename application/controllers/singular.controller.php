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
                $result = true;
                $arguments = $http->getRequestVars();
                
                $conditions = (isset($array) && !empty($array)) ? initCondition($urlObject, null, $mapper) : null;
                $arrayObject = $mapper->$method(false, $conditions);
                if(!emptyObject($arrayObject)) {
                    $dataArray = extractData($arrayObject);
                }
                
                if(!empty($dataArray)) {
                    
                    if($http->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($dataArray), 'application/json');  
                    }  
                    else if ($http->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent'         => '     ',  
                            'addDecl'        => false,  
                            "defaultTagName" => strtolower($class),
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,

                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($dataArray), 'application/xml');   
                    }               
                } else {
                    Rest::sendResponse(204);
                }
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