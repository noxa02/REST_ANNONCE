<?php
    $router = new Router();
    /**
     * Parse the URL and clean it.
     */
     $url = new Url();
     $uriParts = $url->parserUrl(); 
     $urlObject = (($uri = $url->getUri()) && !empty($uri))  
        ? $url->initUrlClass($uri, $uriParts) : throwException('A problem has occured during the initizialition Url Class');
     
    /**
     * Initializer object URL to get argument of the URL 
     * if their here.
     */
    $http = Rest::initProcess();
    $model = $router->constructRoute($urlObject);
    $controller = $router->getControllerByModel($model);
    $mapper = $router->getMapper($model);
    $class = $router->getNameByMapper($mapper);
    $pager = new Pager();

    if($router->existController($controller)) {
        include_once APPLICATION_PATH . '/controllers/' . $controller.'.controller.php';
    } elseif($controller === '') {
        include_once APPLICATION_PATH . '/controllers/default.controller.php';
    } else {
        Rest::sendResponse(404);   
    }