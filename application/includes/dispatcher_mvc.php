<?php
/**
 * Url GET : http://xxxxxx.fr/m=myMethod&a=myAction&arg1=value1&etc...
 * 
 */    
try {
    if(isset($_GET['m'])) { //method
        
        $controller = $view = strtolower($_GET['m']);
        $extController = '.controller.php';
        $extView = '.view.php';
        
        if(isset($_GET['a'])) { //action
  
            $action = $_GET['a'];
            
            if(is_readable(APPLICATION_PATH . '/controllers/' . ucfirst($controller) . '/' . $action . $extController)) {  

                $controller_ = APPLICATION_PATH . '/controllers/' . ucfirst($controller) . '/' . $action . $extController;
            }
        }
        
    } else { //default  controller
            
        $controller_ = APPLICATION_PATH . '/controllers/default/default.controller.php';
        
    }
    
} catch (Exception $e) {

    print '<strong>' . $e->getMessage() . '</strong>';
}

