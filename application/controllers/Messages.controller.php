<?php 
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $messageMapper = new MessageMapper();
                $messagesObject = $messageMapper->selectMessage(true);
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
                            "defaultTagName"     => "message",
                        );  

                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($messagesArray), 'application/xml');  
                    }       
                } else {
                    Rest::sendResponse(204);
                }
                    break;
            case 'post':
                try {
                    $message = new Message();
                    $data_message = $http->getRequestVars();
                    $messageObject = initObject($data_message, $message, true);

                    if(!emptyObject($messageObject)) {
                        $messageMapper = new MessageMapper();
                        if($messageMapper->insertMessage($messageObject)) {
                            Rest::sendResponse(200);   
                        }           
                    } else {
                        throw new InvalidArgumentException('Need arguments to POST data !');
                    }
                } catch(InvalidArgumentException $e) {
                    $e->getMessage(); exit;
                }
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }