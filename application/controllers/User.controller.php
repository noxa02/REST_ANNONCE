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
                $userObject = $userMapper->select();
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
                }
                    break;
            case 'delete':
                $user_ = new \User();
                $userMapper = new \UserMapper();
                $where = array('id' => $url->getIdFirstPart());
                $userMapper->update($user_, $where);
                    break;
             case 'put':
                $user = new \User();
                $data_user = $http->getRequestVars();
                $user = initObject($data_user, $user, true);
                $userMapper = new \UserMapper();
                $userMapper->update($user);
                
                Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }