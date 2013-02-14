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
                "encoding"        => "UTF-8",
                 XML_SERIALIZER_OPTION_RETURN_RESULT => true,
            );

            $pager->setTotalItems(count($query->getAllItems($mapper->getTable())));
            $limit =  $pager->getLimit();
            $nbPages = (isset($limit) && $limit > 0) ? ceil($pager->getTotalItems() / $pager->getLimit()) : 1;
            $pager->setNbPages($nbPages);
            
            $associationsTags = $mapper->getAnnouncementTags($mapper->getFirstId());
            foreach ($associationsTags as $key => $value) {
                $tags[] = $mapper->select('TAG', false, ' WHERE id = '.$value['id_tag']);
            }
            
            $data->setData($tags);
            $data->setFormat($http->getHttpAccept());
            $data->setOptions($options);
            $data->sendData(); 
            
         break;
        case 'post':
                
            $query  = new Query();
            $classInstancied = new stdClass();
            $method = 'goAssociate';
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
