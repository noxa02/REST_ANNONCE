<?php 
try 
{
    switch($http->getMethod())
    {
        case 'get':
            $mapper = new $mapper();
            $query  = new Query();
            $data   = new Data();
            $method = 'getFollowers';
            $options = array (  
                'indent'         => '     ',  
                'addDecl'        => false,  
                "defaultTagName" => strtolower($class),
                 XML_SERIALIZER_OPTION_RETURN_RESULT => true,
            );
            
            $items = $mapper->$method();
            $data->setData($items);
            $data->setFormat($http->getHttpAccept());
            $data->setOptions($options);
            $data->sendData();      
        break;
        case 'post':

            $mapper = new $mapper();
            $query  = new Query();
            $classInstancied = new $class();
            $method = 'goFollow';
            $args = $http->getRequestVars();
            $object = initObject($args, new stdClass(), true);

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
} catch (Exception $e) {
    print $e->getMessage(); exit;
} catch(InvalidArgumentException $e) {
    print $e->getMessage(); exit;
}  