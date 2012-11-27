<?php 
    $data = Rest::initProcess();
    
    switch($data->getMethod())
    {
            case 'get':
                $message_ = new Message();
                $message_data_ = $message_->getMessage($url->getIdFirstPart()); 

                if(!empty($message_data_)) {
                    
                    if($data->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($message_data_), 'application/json');  
                    }  
                    else if ($data->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent' => '     ',  
                            'addDecl' => false,  
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                            "defaultTagName"     => "message",
                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($message_data_), 'application/xml');   
                    }               
                }
                    break;
            case 'delete':
                
                $message_ = new Message();
                if($message_->deleteMessage($url->getIdFirstPart())) {
                    Rest::sendResponse(200);
                } else {
                    Rest::sendResponse(500);
                }
                break;
             case 'put':
                    $message_ = new Message();
                    $data_message_ = $data->getRequestVars();
                    $message_->updateMessage($data_message_, $url->getIdFirstPart());
                    Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }