<?php

function print_log($vars_) 
{
    print '<pre>';
        var_dump($vars_);
    print '</pre>';
}

function print_logex($vars_) 
{
    print '<pre>';
        var_dump($vars_);
    print '</pre>';
    exit;
}

function sha1_password($password) 
{
    $GDS_1 = 'sdafazc532D2deq';
    $GDS_2 = 'qsfqsgugre8795h';
    
    return sha1(sha1($password.$GDS_2).sha1($GDS_1.$GDS_2));
}

function existModel($model) {
    
    if(is_readable(APPLICATION_PATH . '/models/' . $model.'.class.php')) {
        return true;
    }
    return false;
}

function existController($model) {
    
    if(is_readable(APPLICATION_PATH . '/controllers/' . $model.'.controller.php')) {
        return true;
    }
    return false;
}

function constructRoute($url_) {
    
    $model = '';
    if($url_->getModelFirstPart() != null) {
        
        if($url_->getIdFirstPart() != null) {

            $model .= ucfirst(substr_replace($url_->getModelFirstPart() , '', -1));
        } else {

            $model .= ucfirst($url_->getModelFirstPart()); 
        }
    }

    if($url_->getModelSecondPart() != null) {

        if($url_->getIdSecondPart() != null) {

            $model .= '_'.ucfirst(substr_replace($url_->getModelSecondPart() , '', -1));
        } else {

            $model .= '_'.ucfirst($url_->getModelSecondPart()); 
        }
    }
    
    return $model;
}

function is_admin() {
  $result = false;
  
  if (isset($_SERVER["PHP_AUTH_USER"])) {
      
    $result = $_SERVER["PHP_AUTH_USER"] == "admin" && $_SERVER["PHP_AUTH_PW"] == "admin";
  }
  
  return $result;
}

function extractData($object_) {
    $data = null;
    foreach (get_class_methods($object_) as $key => $value) {
        if(strpos($value, 'get') !== false) {
            if(method_exists($object_, $value)) {
                $method = $object_->$value();
                if(!is_null($method)) {
                    $key = strtolower(str_replace('get', '', $value));
                    $data[$key] = $object_->$value(); 
                }
            }
        }
    }
        return $data;
}

function initObject($data_, $object_, $return = false) {
    $object_ = new $object_();
    if(isset($data_) && count($data_) > 0) {
       foreach ($data_ as $key => $value) {
           $_methodName = ucfirst($key);
           if(strpos($key, '_')) {
               $beginMethod = strstr($key, '_', true);
               $endMethod = ucfirst(str_replace('_', '', strstr($key, '_')));
               $_methodName = $beginMethod.$endMethod;
           }
           $_method = 'set'.$_methodName;
           if(method_exists($object_, $_method)) {
               $object_->$_method($value);
           }
       }
    }
    
    if($return) {
        return $object_;
    }
}