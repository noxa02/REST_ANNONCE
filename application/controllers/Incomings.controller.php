<?php 
    $data = Rest::initProcess();

    switch($data->getMethod())
    {
            case 'get':
                $incomings_ = new Incomings();
                $incomings_list_ = $incomings_->getIncomings();

                if($data->getHttpAccept() == 'json')  {  
                    Rest::sendResponse(200, json_encode($incomings_list_), 'application/json');  
                }  
                else if ($data->getHttpAccept() == 'xml')  { 
                    
                    $options = array (  
                        'indent' => '     ',  
                        'addDecl' => false,  
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                        "defaultTagName"     => "incoming",
                    );  
                    
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($incomings_list_), 'application/xml');  
                }
                    break;
                    
            case 'post':
                    $incoming_ = new Incoming();
                    $data_incoming_ = $data->getRequestVars();
                   
                    if(isset($data_incoming_) && count($data_incoming_) > 0) {

                        foreach ($data_incoming_ as $key => $value) {

                            $_methodName = ucfirst($key);
                            $_method = 'set'.ucfirst($key);
                            
                            if(method_exists($incoming_, 'set'.$_methodName)) {
                               
                                $incoming_->$_method($value);
                            }
                        }
                    }
                    
                    if($incoming_->createIncoming()) {
                        
                        Rest::sendResponse(200);
                    }
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }