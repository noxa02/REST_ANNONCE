<?php 

    switch($http->getMethod())
    {
        case 'delete':
            
            $mapper = new $mapper();
            $method = 'stopFollow';

            if($mapper->$method($url->getIdFirstPart(), $url->getIdSecondPart())) {
                Rest::sendResponse(200);
            }
            
        break;
        default :
            Rest::sendResponse(501);
        break;
    }