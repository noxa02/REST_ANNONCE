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
                $messageMapper = new \MessageMapper();
                if($messageMapper->deleteMessage()) {
                    Rest::sendResponse(200);
                }
                    break;
             case 'put':
                try {
                    $message_ = new Message();
                    $data_message_ = $http->getRequestVars();
                    $messageObject = initObject($data_message_, $message_, true);

                    if(!emptyObject($messageObject)) {
                        $messageMapper = new \MessageMapper();
                        if($messageMapper->updateMessage($messageObject)) {
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