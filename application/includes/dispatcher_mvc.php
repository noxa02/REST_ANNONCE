<?php
//    if(!is_admin()) {
//        Rest::sendResponse(401);   
//    }

    $uri_ = prepareRequestUri();
    $url_ = prepareBaseUrl();
    $uri_filtred = str_replace($url_, '', $uri_);
    $uri_args = explode('/', $uri_filtred);
    array_shift($uri_args);
    $last_occurence_ = substr(strrchr($uri_, "/"), 1);
    /**
     * Init route 
     */
    $url = new Url();
    $args = explode('?', $uri_filtred);
    if(count($args) > 1) {
        $temp = explode('&', $args[1]);
        $url->setUrlArguments($temp);
    }
 
    foreach ($uri_args as $key => $value) {
        if(strpos($value, '?') !== false) {
            $value = strstr($value, '?', true);
        }
        if($key === 0 && !is_numeric($value)) { //Model
            $url->setModelFirstPart($value);
        } elseif($key % 2 != 0) { //ID
            if($key === 1 && is_numeric($value)) {
                $url->setIdFirstPart($value);
            } elseif(is_numeric($value)) {
                $url->setIdSecondPart($value);
            }
        } elseif($key % 2 == 0) {
            if($key === 2 && !is_numeric($value)) {
                $url->setModelSecondPart($value);
            }
        }
    }

    $model = constructRoute($url);
    if(existModel($model) && existController($model)) {
        
        include_once APPLICATION_PATH . '/controllers/' . $model.'.controller.php';
    } elseif($model === '') {
        
        include_once APPLICATION_PATH . '/controllers/default.controller.php';
    }
      else {
        Rest::sendResponse(404);   
    }