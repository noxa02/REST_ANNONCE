<?php 

    switch($http->getMethod())
    {
        case 'delete':
            
            if($mapper->removeApply($url->getIdFirstPart(), $url->getIdSecondPart())) {
                Rest::sendResponse(200);
            }
            
        break;
        case 'post':
            
            $stdClass = new stdClass();
            $data = $http->getRequestVars();
            $objectApply = initObject($data, $stdClass, true);

            if(!emptyObject($objectApply)) {
                if($mapper->goApply($objectApply)) {
                    Rest::sendResponse(200);   
                }       
            } else {
                Rest::sendResponse(400, 'Need arguments to POST data !');
            }
            
         break;
         default :
            Rest::sendResponse(501);
         break;
    }