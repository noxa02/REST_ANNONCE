<?php 
try 
{
    $http = Rest::initProcess();
    $mapper = getMapper($model);
    $class = getNameByMapper($mapper);
    
    if(!existMapper($mapper)) throw new Exception('Mapper doesn\'t exist !');
    switch($http->getMethod())
    {
        case 'delete':
            $mapper = new $mapper();
            $method = 'stopFollow';
            
            
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