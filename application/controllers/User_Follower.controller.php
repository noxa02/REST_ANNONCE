<?php 
    $data = Rest::initProcess();

    switch($data->getMethod())
    {
            case 'get':

                $user_follower= new User_Follower();
                $user_follower_data_= $user_followers_->getUserFollower($url->getIdFirstPart());
                
                if($data->getHttpAccept() == 'json')  {  
                    Rest::sendResponse(200, json_encode($user_follower_data_), 'application/json');  
                }  
                else if ($data->getHttpAccept() == 'xml')  { 
                    
                    $options = array (  
                        'indent' => '     ',  
                        'addDecl' => false,  
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                        "defaultTagName"     => "user",
                    );  
                    
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($user_follower_data_), 'application/xml');  
                }
                    break;
    }