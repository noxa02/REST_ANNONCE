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
            
            $pager->setTotalItems(count($query->getAllItems('TO_EVALUATE')));
            $limit =  $pager->getLimit();
            $nbPages = (isset($limit) && $limit > 0) ? ceil($pager->getTotalItems() / $pager->getLimit()) : 1;
            $pager->setNbPages($nbPages);

            $args = $url->getUrlArguments();
            $args[] = 'id_announcement='.$mapper->getFirstId();
            $url->setUrlArguments($args);
            $conditions =  $query->initCondition($url, $pager, $mapper, true);

            $items = $mapper->select('TO_EVALUATE', true, $conditions);
            $data->setData($items);
            $data->setFormat($http->getHttpAccept());
            $data->setOptions($options);
            $data->sendData();
            
         break;
        case 'post':
                
            $query  = new Query();
            $classInstancied = new stdClass();
            $method = 'goEvaluate';
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
