<?php 
    $data = Rest::initProcess();
    
    switch($data->getMethod())
    {
            case 'get':
                $user_ = new User();
                $user_data_ = $user_->getUser($url->getIdFirstPart()); 

                if(!empty($user_data_)) {
                    
                    if($data->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($user_data_), 'application/json');  
                    }  
                    else if ($data->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent' => '     ',  
                            'addDecl' => false,  
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                            "defaultTagName"     => "user",
                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($user_data_), 'application/xml');   
                    }               
                }
                    break;
            case 'delete':
                
                $user_ = new User();
                if($user_->deleteUser($url->getIdFirstPart())) {
                    Rest::sendResponse(200);
                } else {
                    Rest::sendResponse(500);
                }
                break;
             case 'put':
                    $user_ = new User();
                    $data_user_ = $data->getRequestVars();
                    $user_->updateUser($data_user_, $url->getIdFirstPart());
                    Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }