<?php 
    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();

    switch($http->getMethod())
    {
            case 'get':
                $announcementMapper = new \AnnouncementMapper();
                $announcementsObject = $announcementMapper->selectAnnouncement(true);
                $result = true;
                if(is_array($announcementsObject) && !is_null($announcementsObject)) {
                    foreach($announcementsObject as $announcementObject) {
                        $result = emptyObject($announcementObject);
                    }     
                }
                if(!$result) {
                    foreach($announcementsObject as $announcementObject) {
                        $announcementsArray[] = extractData($announcementObject);
                    }
                    if($http->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($announcementsArray), 'application/json');  
                    }  
                    else if ($http->getHttpAccept() == 'xml')  { 

                        $options = array (  
                            'indent' => '     ',  
                            'addDecl' => false,  
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                            "defaultTagName"     => "announcement",
                        );  

                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($announcementsArray), 'application/xml');  
                    }     
                } else {
                    Rest::sendResponse(204);
                }
                    break;
                    
            case 'post':
                try {
                    $announcement = new Announcement();
                    $data_announcement = $http->getRequestVars();
                    $announcementsObject = initObject($data_announcement, $announcement, true);

                    if(!emptyObject($announcementsObject)) {
                        $announcementMapper = new \AnnouncementMapper();
                        if($announcementMapper->insertAnnouncement($announcementsObject)) {
                            Rest::sendResponse(200);   
                        }             
                    } else {
                        throw new InvalidArgumentException('Need arguments to POST data !');
                    }
                } catch(InvalidArgumentException $e) {
                    $e->getMessage(); exit;
                }
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }