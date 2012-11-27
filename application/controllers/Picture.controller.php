<?php 
    $data = Rest::initProcess();
    
    require_once 'XML/Util.php';
    require_once 'XML/Serializer.php';
    
    switch($data->getMethod())
    {
            case 'get':
                $picture_ = new Picture();
                $picture_data_ = $picture_->getPicture($url->getIdFirstPart()); 

                if(!empty($picture_data_)) {
                    
                    if($data->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($picture_data_), 'application/json');  
                    }  
                    else if ($data->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent' => '     ',  
                            'addDecl' => false,  
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                            "defaultTagName"     => "picture",
                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($picture_data_), 'application/xml');   
                    }               
                }
                    break;
            case 'delete':
                
                $picture_ = new Picture();
                if($picture_->deletePicture($url->getIdFirstPart())) {
                    Rest::sendResponse(200);
                } else {
                    Rest::sendResponse(500);
                }
                break;
             case 'put':
                    $picture_ = new Picture();
                    $data_picture_ = $data->getRequestVars();
                    $picture_->updatePicture($data_picture_, $url->getIdFirstPart());
                    Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }