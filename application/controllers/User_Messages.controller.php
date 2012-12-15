<?php 
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
        case 'get':
            $userMapper = new UserMapper();
            $messageMapper = new MessageMapper($userMapper);
            $messagesObject = $userMapper->getMessages($messageMapper);
           
            $result = true;
            if(is_array($messagesObject) && !is_null($messagesObject)) {
                foreach($messagesObject as $messageObject) {
                    $result = emptyObject($messageObject);
                }     
            }
            if(!$result) {
                foreach($messagesObject as $messageObject) {
                    $messagesArray[] = extractData($messageObject);
                }
                if($http->getHttpAccept() == 'json')  {  
                    Rest::sendResponse(200, json_encode($messagesArray), 'application/json');  
                }  
                else if ($http->getHttpAccept() == 'xml')  { 

                    $options = array (  
                        'indent' => '     ',  
                        'addDecl' => false,  
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                        "defaultTagName"     => "user",
                    );  

                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($messagesArray), 'application/xml');  
                }
            } else {
                Rest::sendResponse(204);
            }
                break;
            default :
                Rest::sendResponse(501);
                    break;
    }