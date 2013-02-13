<?php 
  
    switch($http->getMethod())
    {
        case 'get':

            $classInstancied = new $class();
            $method = 'resizePicture';
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
            
            $originalPicture = $mapper->select($mapper->getTable(), false, 
                    ' WHERE id_announcement = '.$args['id_announcement'].' AND path = "/announcement/original/"
                        AND title = "'.$args['title'].'"');
            $originalPicture = initObject($originalPicture, $classInstancied, true);
            $item = $mapper->select($mapper->getTable(), false, $conditions);
            if($item && $originalPicture) {
                $data->setData($item);
                $data->setFormat($http->getHttpAccept());
                $data->setOptions($options);
                $data->sendData(); 
            } else if(!$item && $originalPicture) {
                $width = (isset($args['width']) && is_numeric($args['width'])) ? $args['width'] : null;
                $height = (isset($args['height']) && is_numeric($args['height'])) ? $args['height'] : null;
                if(!emptyObject($originalPicture) && method_exists($mapper, $method)) {
                    if($mapper->$method($originalPicture, $width, $height)) {
                        $item = $mapper->select($mapper->getTable(), false, $conditions);
                        $data->setData($item);
                        $data->setFormat($http->getHttpAccept());
                        $data->setOptions($options);
                        $data->sendData(); 
                    }             
                } else {
                    Rest::sendResponse(400, 'Need arguments to POST data !');
                }
            }
            
        break;
        case 'post':

            $classInstancied = new $class();
            $method = 'resizePicture';
            $args = $http->getRequestVars();
            $width = (isset($args['width']) && is_integer($args['width'])) ? $args['width'] : null;
            $height = (isset($args['height']) && is_integer($args['height'])) ? $args['height'] : null;
            $object = initObject($args, $classInstancied, true);

            if(!emptyObject($object) && method_exists($mapper, $method)) {
                if($mapper->$method($object, $width, $height)) {
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