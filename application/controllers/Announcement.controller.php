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
                $announcementMapper = new \AnnouncementMapper();
                
                if($announcementMapper->delete()) {
                    Rest::sendResponse(200);
                } else {
                    Rest::sendResponse(500);
                }
                    break;
             case 'put':
                $announcement = new Announcement();
                $data_announcement = $http->getRequestVars();
                $announcement = initObject($data_announcement, $announcement, true);
                $announcementMapper = new \AnnouncementMapper();
                $announcementMapper->update($announcement);
                
                Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }