<?php
    /**
     * Parse the URL and clean it.
     */
    $uri_ = prepareRequestUri();
    $url_ = prepareBaseUrl();
    $uri_filtred = str_replace($url_, '', $uri_);
    $uri_args = explode('/', $uri_filtred);
    array_shift($uri_args);
    
    /**
     * Initializer object URL to get argument of the URL 
     * if their here.
     */
try {
    $url = new Url();
    $args = explode('?', $uri_filtred);
    
    if(count($args) > 1) {
        $temp = explode('&', $args[1]);
        $url->setUrlArguments($temp);
    }

    foreach ($uri_args as $key => $value) {
        /**
         * Check if url contains some arguments 
         * Example : /path/to/web/model/?order=DESC
         */
        if(strpos($value, '?') !== false) {
            $value = strstr($value, '?', true);
        }
        /**
         * Use the object URL and set the different parts of the URL 
         * to associate attributes.
         */
        if($key === 0 && !is_numeric($value)) { 
            $url->setModelFirstPart($value);
        } elseif($key % 2 != 0) { 
            if(!empty($value) && !is_numeric($value)) {
                throw new InvalidArgumentException('The second argument must be a integer "ID" !');
            } elseif($key === 1 && is_numeric($value)) {
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
} catch (InvalidArgumentException $e) {
    print $e->getMessage();
    exit;
}
    /**
     * Define the used model by analyze the object URL
     * and his attributes. After include the controller to use.
     */
    $model = constructRoute($url);
    if(existModel($model) && existController($model)) {
        include_once APPLICATION_PATH . '/controllers/' . $model.'.controller.php';
    } elseif($model === '') {
        include_once APPLICATION_PATH . '/controllers/default.controller.php';
    } else {
        Rest::sendResponse(404);   
    }