<?php 

    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $message_ = new Message();
                $messageMapper = new \MessageMapper();
                $messageObject = $messageMapper->selectMessage();
                $messageArray = extractData($messageObject);
                if(!empty($messageArray)) {
                    
                    if($http->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($messageArray), 'application/json');  
                    }  
                    else if ($http->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent'         => '     ',  
                            'addDecl'        => false,  
                            "defaultTagName" => "message",
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,

                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($messageArray), 'application/xml');   
                    }               
                } else {
                    Rest::sendResponse(204);
                }
                    break;
            case 'delete':
                $message_ = new Message();
                $messageMapper = new \MessageMapper();
                
                if($messageMapper->deleteMessage()) {
                    Rest::sendResponse(200);
                } else {
                    Rest::sendResponse(500);
                }
                    break;
             case 'put':
                $message_ = new Message();
                $data_message_ = $http->getRequestVars();
                $message_ = initObject($data_message_, $message_, true);
                $messageMapper = new \MessageMapper();
                $messageMapper->updateMessage($message_);
                
                Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }