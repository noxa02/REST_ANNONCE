<?php 
    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();

    switch($http->getMethod())
    {
        case 'delete':
            $userMapper = new UserMapper();
            if($userMapper->stopFollow($url->getIdFirstPart(), $url->getIdSecondPart())) {
                Rest::sendResponse(200);
            }
               break;
         case 'post':
            try {
                $stdClass = new stdClass();
                $data = $http->getRequestVars();
                $objectApply = initObject($data, $stdClass, true);
               
                if(!emptyObject($objectApply)) {
                    $announcementMapper = new AnnouncementMapper();
                    if($announcementMapper->goApply($objectApply)) {
                        Rest::sendResponse(200);   
                    }       
                } else {
                    throw new InvalidArgumentException('Need arguments to POST data !');
                }
            } catch(InvalidArgumentException $e) {
                print $e->getMessage(); exit;
            }
                break;
         default :
            Rest::sendResponse(501);
                break;
    }