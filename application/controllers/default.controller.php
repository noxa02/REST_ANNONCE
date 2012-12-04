<?php 
    $body = '';
    $body .= '<h2> REST Service </h2>';
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
    
    $body .= '<h3>Rules</h3>';
    $body .= '<p> URL rules : path/to/web/{model}/{id}/{model}/{id}</p>';
    $body .= '<p> <strong>The PEAR is require ! Need to install XML_Serializer / PHPUnit </strong> </p>';
    $body .= '<p> Check the bootstrap.php to saw the hiearchy of the folder into PEAR to include them. </p>';
    $body .= '<p> <strong> Example of use : </strong> </p>';
    $body .= '<p> To list one "user" with specific "id" : "path/to/web/users/{id}"</p>';
    $body .= '<p> To list all "users" "path/to/web/users"';
    print $body;