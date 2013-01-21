<?php
    $router = new Router();
    /**
     * Parse the URL and clean it.
     */
     $url = new Url();
     $uriParts = $url->parserUrl(); 
     $url = (($uri = $url->getUri()) && !empty($uri))  
            ? $url->initUrlClass($uri, $uriParts) : throwException('A problem has occured during the initizialition Url Class');
     
    /**
     * Initializer object URL to get argument of the URL 
     * if their here.
     */
    $http = Rest::initProcess();
    $model = $router->constructRoute($url);
    $controller = $router->getControllerByModel($model);
    $mapper = $router->getMapper($model);
    $class = $router->getNameByMapper($mapper);
    $pager = new Pager();
    
    try 
    {
        if(!$router->existMapper($mapper)) throw new Exception('Mapper doesn\'t exist !');
        
    } catch(Exception $e) {
        print $e->getMessage(); exit;
    }
    
    /**
     * Check if the user is authorized to make DB request
     */
    $mapper = new $mapper();
    if(!$mapper->exist('USER', 'User', 'userMapper', 
            ' WHERE login = "'.$http->getUser().'" AND password = "'.$http->getPassword().'"')) {
        Rest::sendResponse (401);
    }

    if($router->existController($controller)) {
        include_once APPLICATION_PATH . '/controllers/' . $controller.'.controller.php';
    } elseif($controller === '') {
        include_once APPLICATION_PATH . '/controllers/default.controller.php';
    } else {
        Rest::sendResponse(404);   
    }