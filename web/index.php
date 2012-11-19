<?php
    include_once '../Application/bootstrap.php';

    $data = Rest::initProcess();
   
    print_logex($data);
    
    if(isset($controller_)) {
  
        include_once($controller_); 
    }