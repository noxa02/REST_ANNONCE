<?php 
  
    switch($http->getMethod())
    {
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