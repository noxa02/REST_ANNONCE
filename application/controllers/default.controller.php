<?php 
    $body = '';
    $body .= '<h2> REST Service </h2>';
    $body .= '<br><br>';
    $body .= '<strong>List of available controllers :</strong>';
    $body .= '<ul>';
    $dir = APPLICATION_PATH.'/controllers';
    if (is_dir($dir)) {
       if ($dh = opendir($dir)) {
           while (($file = readdir($dh)) !== false) {
               if(strpos($file, '.controller.'))
               $body .= '<li>'.strstr($file, '.controller.', true).'</li>';
           }
           closedir($dh);
       }
   }
    $body .= '</ul>';
    
    $body .= '<strong> Example of use : </strong> <br>';
    $body .= '<p> To list one "user" with specific "id" : "path/to/web/users/{id}"</p>';
    $body .= '<p> To list all "users" "path/to/web/users"';
    print $body;