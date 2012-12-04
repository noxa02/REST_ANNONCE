<?php 
    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();

    switch($http->getMethod())
    {
            case 'get':
                $user_ = new User();
                $userMapper = new \UserMapper();
                $where = $url->getUrlArguments();
                $usersObject = $userMapper->select(true);
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
                    break;
                    
            case 'post':
                    $user_ = new User();
                    $data_user_ = $http->getRequestVars();
                    initObject($data_user_, $user_);
  
                    $userMapper = new \UserMapper();
                    $userMapper->insert($user_);
                    Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }