<?php 
    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();

    switch($http->getMethod())
    {
        case 'get':
            $userMapper = new UserMapper();
            $userMessageObject = $userMapper->getMessage();
            $userMessageArray = extractData($userMessageObject);
            
            if(!empty($userMessageArray)) {

                if($http->getHttpAccept() == 'json')  {  

                    Rest::sendResponse(200, json_encode($userMessageArray), 'application/json');  
                }  
                else if ($http->getHttpAccept() == 'xml')  {  

                    $options = array (  
                        'indent'         => '     ',  
                        'addDecl'        => false,  
                        "defaultTagName" => "user_message",
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,

                    );  
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($userMessageArray), 'application/xml');   
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
                    $userMapper = new UserMapper();
                    if($userMapper->sendMessage($messageObject)) {
                        Rest::sendResponse(200);   
                    }       
                } else {
                    throw new InvalidArgumentException('Need arguments to POST data !');
                }
            } catch(InvalidArgumentException $e) {
                print $e->getMessage(); exit;
            }
                break;
         default :
            Rest::sendResponse(501);
                break;
    }