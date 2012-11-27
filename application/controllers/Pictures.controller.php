<?php 
    $data = Rest::initProcess();

    switch($data->getMethod())
    {
            case 'get':
                $pictures_ = new Pictures();
                $pictures_list_ = $pictures_->getPictures();

                if($data->getHttpAccept() == 'json')  {  
                    Rest::sendResponse(200, json_encode($pictures_list_), 'application/json');  
                }  
                else if ($data->getHttpAccept() == 'xml')  { 
                    
                    $options = array (  
                        'indent' => '     ',  
                        'addDecl' => false,  
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                        "defaultTagName"     => "picture",
                    );  
                    
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($pictures_list_), 'application/xml');  
                }
                    break;
                    
            case 'post':
                    $pictures_ = new Picture();
                    $data_picture_ = $data->getRequestVars();
                   
                    if(isset($data_picture_) && count($data_picture_) > 0) {

                        foreach ($data_picture_ as $key => $value) {

                            $_methodName = ucfirst($key);
                            $_method = 'set'.ucfirst($key);
                            
                            if(method_exists($pictures_, 'set'.$_methodName)) {
                               
                                $pictures_->$_method($value);
                            }
                        }
                    }
                    
                    if($pictures_->createPicture()) {
                        
                        Rest::sendResponse(200);
                    }
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }