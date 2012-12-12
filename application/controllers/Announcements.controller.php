<?php 
    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();

    switch($http->getMethod())
    {
            case 'get':
                $announcementMapper = new \AnnouncementMapper();
                $announcementsObject = $announcementMapper->select(true);
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
                    break;
                    
            case 'post':
                
                exit;
                $announcement = new Announcement();
                $data_announcement = $http->getRequestVars();
                $announcement = initObject($data_announcement, $announcement, true);

                $announcementMapper = new \AnnouncementMapper();
                if($announcementMapper->insert($announcement_)) {
                    Rest::sendResponse(200);   
                }
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }