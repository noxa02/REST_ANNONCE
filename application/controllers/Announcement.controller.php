<?php 
    $data = Rest::initProcess();
    
    switch($data->getMethod())
    {
            case 'get':
                $announcement_ = new Announcement();
                $announcement_data_ = $announcement_->getAnnouncement($url->getIdFirstPart()); 
                
                if(!empty($announcement_data_)) {
                    
                    if($data->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($announcement_data_), 'application/json');  
                    }  
                    else if ($data->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent' => '     ',  
                            'addDecl' => false,  
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                            "defaultTagName"     => "announcement",
                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($announcement_data_), 'application/xml');   
                    }               
                }
                    break;
            case 'delete':
                
                $announcement_ = new Announcement();
                if($announcement_->deleteAnnouncement($url->getIdFirstPart())) {
                    Rest::sendResponse(200);
                } else {
                    Rest::sendResponse(500);
                }
                break;
             case 'put':
                    $announcement_ = new Announcement();
                    $data_announcement_ = $announcement_->getRequestVars();
                    $announcement_->updateAnnouncement($data_announcement_, $url->getIdFirstPart());
                    Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }