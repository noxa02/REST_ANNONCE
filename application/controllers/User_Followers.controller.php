<?php 
    $http = Rest::initProcess();
   
    switch($http->getMethod())
    {
        case 'get':
            $userMapper = new UserMapper();
            $usersObject = $userMapper->getFollowers();
            $result = true;
            if(is_array($usersObject) && !is_null($usersObject)) {
                foreach($usersObject as $userObject) {
                    $result = emptyObject($userObject);
                }     
            }
            if(!$result) {
                foreach($usersObject as $userObject) {
                    $usersArray[] = extractData($userObject);
                }
                if($http->getHttpAccept() == 'json')  {  
                    Rest::sendResponse(200, json_encode($usersArray), 'application/json');  
                }  
                else if ($http->getHttpAccept() == 'xml')  { 

                    $options = array (  
                        'indent' => '     ',  
                        'addDecl' => false,  
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                        "defaultTagName"     => "user",
                    );  

                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($usersArray), 'application/xml');  
                }
            } else {
                Rest::sendResponse(204);
            }
                break;
            default :
                Rest::sendResponse(501);
                    break;
    }