<?php 
    $mapper = new $mapper();
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

                $conditions = ' WHERE '.$mapper->getPrimaryKey().' = '.$url->getIdFirstPart();
                $items = $mapper->select($mapper->getTable(), false, $conditions);
                $data->setData($items);
                $data->setFormat($http->getHttpAccept());
                $data->setOptions($options);
                $data->sendData();               

            break;
            case 'delete':
                
                $method = 'delete'.$class;

                if($mapper->$method()) {
                    Rest::sendResponse(200);
                }
                
            break;
            case 'put':

               $classInstancied = new $class();
               $args = $http->getRequestVars();
               $object = initObject($args, $classInstancied, true);

               if(!emptyObjectMethod($object)) {
                   if($mapper->update($mapper->getTable(), $object)) {
                       Rest::sendResponse(200);
                   }
               } else {
                   Rest::sendResponse(400, 'Arguments are requiered to make a UPDATE !');
               }

            break;
            default :
               Rest::sendResponse(501);
            break;
    }