<?php 
    $data = Rest::initProcess();
    
    switch($data->getMethod())
    {
            case 'get':
                $user_ = new User();
                $userMapper = new \UserMapper();
                $userObject = $userMapper->select();
                $userArray = extractData($userObject);
                if(!empty($userArray)) {
                    
                    if($data->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($userArray), 'application/json');  
                    }  
                    else if ($data->getHttpAccept() == 'xml')  {  

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
                $user_ = new User();
                $userMapper = new \UserMapper();
                $where = array('id' => $url->getIdFirstPart());
                $userMapper->update($user_, $where);
                    break;
             case 'put':
                $user_ = new User();
                $data_user_ = $data->getRequestVars();
                initObject($data_user_, $user_);

                $userMapper = new \UserMapper();
                $where = array('id' => $url->getIdFirstPart());
                $userMapper->update($user_, $where);
                Rest::sendResponse(200);

                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }