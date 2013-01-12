<?php 
try 
{
    $http = Rest::initProcess();
    $mapper = getMapper($model);
    $class = getNameByMapper($mapper);
    
    switch($http->getMethod())
    {
        case 'get':
            $mapper = new $mapper();
            $method = 'getTags';
           
            returnXML($urlObject, $mapper, $class, $method, $array, $http);
         break;
         case 'post':
            try {
                $announcement = new Announcement();
                $data = $http->getRequestVars();
                $toAssociate = initObject($data, new stdClass(), true);

                if(!emptyObject($toAssociate)) {
                    $announcementMapper = new AnnouncementMapper();
                    if($announcementMapper->goAssociate($toAssociate)) {
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
} catch (Exception $e) {
    print $e->getMessage(); exit;
} catch(InvalidArgumentException $e) {
    print $e->getMessage(); exit;
}     