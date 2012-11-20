<?php
    include_once '../Application/bootstrap.php';
      
      print prepareRequestUri().'</br>';
      print prepareBaseUrl().'<br/>';
      print_log(parseUrl());
      $data = Rest::initProcess();
//    $raw_data = file_get_contents('php://input');
//    parse_str($raw_data, $put_data);
//    print_log($data);
//    print_logex($put_data);
//    
//    print_logex($_SERVER['REQUEST_URI']);
    //
    //Rest::sendResponse();
    
    
    if(isset($controller_)) {
  
        include_once($controller_); 
    }