<?php 
    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();

    switch($http->getMethod())
    {
            case 'get':
                $announcementMapper = new \AnnouncementMapper();
                $announcementObject = $announcementMapper->select();
                $announcementArray = extractData($announcementObject);
                
                if(!empty($announcementArray)) {
                    
                    if($http->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($announcementArray), 'application/json');  
                    }  
                    else if ($http->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent'         => '     ',  
                            'addDecl'        => false,  
                            "defaultTagName" => "announcement",
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,

                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($announcementArray), 'application/xml');   
                    }               
                }
                    break;
            case 'delete':
                $announcement_ = new Announcement();
                $announcementMapper = new \AnnouncementMapper();
                
                if($announcementMapper->delete()) {
                    Rest::sendResponse(200);
                } else {
                    Rest::sendResponse(500);
                }
                    break;
             case 'put':
                $announcement_ = new Announcement();
                $data_announcement_ = $http->getRequestVars();
                $announcement_ = initObject($data_announcement_, $announcement_, true);
                $announcementMapper = new \AnnouncementMapper();
                $announcementMapper->update($announcement_);
                
                Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }