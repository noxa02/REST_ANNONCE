<?php 
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $messageMapper = new MessageMapper();
                $messagesObject = $messageMapper->selectMessage(true);
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
                        "defaultTagName"     => "message",
                    );  
                    
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($messagesArray), 'application/xml');  
                }
                    break;
            case 'post':
                    $message = new Message();
                    $data_message = $http->getRequestVars();
                    $message = initObject($data_message, $message, true);
                   
                    $messageMapper = new MessageMapper();
                    if($messageMapper->insertMessage($message)) {
                        Rest::sendResponse(200);   
                    }
                    
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }