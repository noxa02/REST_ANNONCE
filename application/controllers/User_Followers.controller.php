<?php 
    $data = Rest::initProcess();

    switch($data->getMethod())
    {
            case 'get':
                $user_followers_ = new User_Followers();
                $users_followers_list_ = $user_followers_->getUsersFollowers($url->getIdFirstPart());
                
                if($data->getHttpAccept() == 'json')  {  
                    Rest::sendResponse(200, json_encode($users_followers_list_), 'application/json');  
                }  
                else if ($data->getHttpAccept() == 'xml')  { 
                    
                    $options = array (  
                        'indent' => '     ',  
                        'addDecl' => false,  
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                        "defaultTagName"     => "user",
                    );  
                    
                    $serializer = new XML_Serializer($options); 
                    Rest::sendResponse(200, $serializer->serialize($users_followers_list_), 'application/xml');  
                
                }
                    break;
    }