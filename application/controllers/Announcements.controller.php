<?php 
    $data = Rest::initProcess();

    switch($data->getMethod())
    {
            case 'get':
                $announcements_ = new Announcements();
                $announcements_list_ = $announcements_->getAnnouncements();

                if($data->getHttpAccept() == 'json')  {  
                    Rest::sendResponse(200, json_encode($announcements_list_), 'application/json');  
                }  
                else if ($data->getHttpAccept() == 'xml')  { 
                    
                    $options = array (  
                        'indent' => '     ',  
                        'addDecl' => false,  
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                        "defaultTagName"     => "announcement",
                    );  
                    
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($announcements_list_), 'application/xml');  
                }
                    break;
                    
            case 'post':
                    $announcement_ = new Announcement();
                    $data_announcement_ = $data->getRequestVars();
                   
                    if(isset($data_announcement_) && count($data_announcement_) > 0) {

                        foreach ($data_announcement_ as $key => $value) {

                            $_methodName = ucfirst($key);
                            $_method = 'set'.ucfirst($key);
                            
                            if(method_exists($announcement_, 'set'.$_methodName)) {
                               
                                $announcement_->$_method($value);
                            }
                        }
                    }
                    
                    $announcement_->createAnnouncement();
                    Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }