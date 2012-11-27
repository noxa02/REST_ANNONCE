<?php 
    $data = Rest::initProcess();
    
    switch($data->getMethod())
    {
            case 'get':
                $incoming_ = new Incoming();
                $incoming_data_ = $incoming_->getIncoming($url->getIdFirstPart()); 

                if(!empty($incoming_data_)) {
                    
                    if($data->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($incoming_data_), 'application/json');  
                    }  
                    else if ($data->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent' => '     ',  
                            'addDecl' => false,  
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                            "defaultTagName"     => "incoming",
                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($incoming_data_), 'application/xml');   
                    }               
                }
                    break;
            case 'delete':
                
                $incoming_ = new Incoming();
                if($incoming_->deleteIncoming($url->getIdFirstPart())) {
                    Rest::sendResponse(200);
                } else {
                    Rest::sendResponse(500);
                }
                break;
             case 'put':
                 
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
                    $incoming_->updateIncoming($data_incoming_, $url->getIdFirstPart());
                    Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }