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
                $pager = new Pager();
                
                if(isset($arguments['limit']) && !empty($arguments['limit'])
                    && is_numeric($arguments['limit'])) {
                    $pager->setLimit($arguments['limit']);
                }
                if(isset($arguments['page']) && !empty($arguments['page'])
                    && is_numeric($arguments['page'])) {
                    $pager->setCurrentPage($arguments['page']);
                }
                $totalItems = $mapper->$method(true);
                (isset($totalItems) && count($totalItems) > 0) 
                    ? $pager->setTotalItems(count($totalItems)): Rest::sendResponse(204);

                $conditions = (isset($array) && !empty($array)) ? initCondition($urlObject, $pager, $mapper) : null;
                $arrayObjects = $mapper->$method(true, $conditions);
                
                if(is_array($arrayObjects) && !is_null($arrayObjects)) {
                    foreach($arrayObjects as $arrayObject) {
                        $result = emptyObject($arrayObject);
                    }     
                }
                
                if(!$result) {
                    
                    foreach($arrayObjects as $arrayObject) {
                        $dataArray[] = extractData($arrayObject);
                    }
                    
                    if($http->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($dataArray), 'application/json');  
                    } else if ($http->getHttpAccept() == 'xml')  { 

                        $options = array (  
                            'indent' => '     ',  
                            'addDecl' => false,  
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                            "defaultTagName"     => strtolower($class),
                        );  

                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($dataArray), 'application/xml');  
                        
                    }     
                } else {
                    Rest::sendResponse(204);
                }
                    break;
                    
            case 'post':
                    $classInstancied = new $class();
                    $method = 'insert'.$class;
                    $data = $http->getRequestVars();
                    $object = initObject($data, $classInstancied, true);

                    if(!emptyObject($object)) {
                        $mapper = new $mapper();
                        if($mapper->$method($object)) {
                            Rest::sendResponse(200);   
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