<?php 
try 
{
    $http = Rest::initProcess();
    $mapper = getMapper($model);
    $class = getNameByMapper($mapper);

    if(!existMapper($mapper)) throw new Exception('Mapper doesn\'t exist !');
    switch($http->getMethod())
    {
        case 'get':
            $mapper = new $mapper();
            $method = 'getFollowers';
            $conditions = ' WHERE id IN (SELECT id_user_follower '.
                                'FROM TO_FOLLOW WHERE id_user_followed = '.$urlObject->getIdFirstPart().')';
            returnXML($urlObject, $mapper, $class, $method, $array, $http, $conditions);
            
        case 'post':
            try 
            {
                $stdClass = new stdClass();
                $data = $http->getRequestVars();
                $objectFollow = initObject($data, $stdClass, true);

                if(!emptyObject($objectFollow)) {
                    $mapperInstancied = new $mapper();
                    if($mapperInstancied->goFollow($objectFollow)) {
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