<?php
    
    /**
     * Parse the URL and clean it.
     */
     $uri_parts= parserUrl(); 
     
     $urlObject = (($uri = getUri()) && !empty($uri))  
        ? initUrlClass($uri, $uri_parts) : throwException('A problem has occured during the initizialition Url Class');
    /**
     * Initializer object URL to get argument of the URL 
     * if their here.
     */
    $model = constructRoute($urlObject);
    $controller = getControllerByModel($model);
    $array = $urlObject->getUrlArguments();

    if(existController($controller)) {
        include_once APPLICATION_PATH . '/controllers/' . $controller.'.controller.php';
    } elseif($controller === '') {
        include_once APPLICATION_PATH . '/controllers/default.controller.php';
    } else {
        Rest::sendResponse(404);   
    }