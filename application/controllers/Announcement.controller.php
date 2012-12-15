<?php 
    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();

    switch($http->getMethod())
    {
            case 'get':
                $announcementMapper = new \AnnouncementMapper();
                $announcementObject = $announcementMapper->selectAnnouncement();
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
                } else {
                    Rest::sendResponse(204);
                }
                    break;
            case 'delete':
                $announcementMapper = new \AnnouncementMapper();
                if($announcementMapper->deleteAnnouncement()) {
                    Rest::sendResponse(200);
                }
                    break;
             case 'put':
                try {
                    $announcement = new Announcement();
                    $data_announcement = $http->getRequestVars();
                    $announcementObject = initObject($data_announcement, $announcement, true);
                    if(!emptyObject($announcementObject)) {
                        $announcementMapper = new \AnnouncementMapper();
                        if($announcementMapper->updateAnnouncement($announcementObject)) {
                            Rest::sendResponse(200);
                        }
                    } else {
                        throw new InvalidArgumentException('Need arguments to UPDATE data !');
                    }
                } catch(InvalidArgumentException $e) {
                    print $e->getMessage(); exit;
                }
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }