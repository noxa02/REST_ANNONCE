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
                $userObject = $userMapper->selectUser();
                $userArray = extractData($userObject);
                
                if(!empty($userArray)) {
                    if($http->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($userArray), 'application/json');  
                    }  
                    else if ($http->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent'         => '     ',  
                            'addDecl'        => false,  
                            "defaultTagName" => "user",
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,

                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($userArray), 'application/xml');   
                    }               
                } else {
                    Rest::sendResponse(204);
                }
                    break;
            case 'delete':
                $user_ = new \User();
                $userMapper = new \UserMapper();
                if($userMapper->delete()) {
                    Rest::sendResponse(200);
                }
                    break;
             case 'put':
                try {
                    $user = new \User();
                    $data_user = $http->getRequestVars();
                    $userObject = initObject($data_user, $user, true);

                    if(!emptyObject($userObject)) {
                        $userMapper = new \UserMapper();
                        if($userMapper->updateUser($userObject)) {
                            Rest::sendResponse(200);
                        }
                    } else {
                        throw new InvalidArgumentException('Need arguments to UPDATE data !');
                    }
                } catch(InvalidArgumentException $e) {
                    print $e->getMessage(); exit;
                }
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }