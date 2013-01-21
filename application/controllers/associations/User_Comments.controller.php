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
            
            $pager->setTotalItems(count($query->getAllItems($mapper->getTable())));
            $limit =  $pager->getLimit();
            $nbPages = (isset($limit) && $limit > 0) ? ceil($pager->getTotalItems() / $pager->getLimit()) : 1;
            $pager->setNbPages($nbPages);

            $args = $url->getUrlArguments();
            $args[] = 'id_receiver='.$mapper->getId();
            $url->setUrlArguments($args);
            $conditions =  $query->initCondition($url, $pager, $mapper, true);

            $items = $mapper->select($mapper->getTable(), true, $conditions);
            $data->setData($items);
            $data->setFormat($http->getHttpAccept());
            $data->setOptions($options);
            $data->sendData(); 
            
        break;
        default :
            Rest::sendResponse(501);
        break;
    }