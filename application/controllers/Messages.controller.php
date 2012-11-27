<?php 
    $data = Rest::initProcess();

    switch($data->getMethod())
    {
            case 'get':
                $messages_ = new Messages();
                $messages_list_ = $messages_->getMessages();

                if($data->getHttpAccept() == 'json')  {  
                    Rest::sendResponse(200, json_encode($messages_list_), 'application/json');  
                }  
                else if ($data->getHttpAccept() == 'xml')  { 
                    
                    $options = array (  
                        'indent' => '     ',  
                        'addDecl' => false,  
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                        "defaultTagName"     => "message",
                    );  
                    
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($messages_list_), 'application/xml');  
                }
                    break;
                    
            case 'post':
                    $messages_ = new Message();
                    $data_message_ = $data->getRequestVars();
                   
                    if(isset($data_message_) && count($data_message_) > 0) {

                        foreach ($data_message_ as $key => $value) {

                            $_methodName = ucfirst($key);
                            $_method = 'set'.ucfirst($key);
                            
                            if(method_exists($messages_, 'set'.$_methodName)) {
                               
                                $messages_->$_method($value);
                            }
                        }
                    }
                    
                    if($messages_->createMessage()) {
                        
                        Rest::sendResponse(200);
                    }
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }