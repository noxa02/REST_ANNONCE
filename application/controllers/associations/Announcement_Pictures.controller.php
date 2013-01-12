<?php 
    $http = Rest::initProcess();
   
    switch($http->getMethod())
    {
        case 'get':
            $announcementMapper = new AnnouncementMapper();
            $announcementObject = $announcementMapper->selectAnnouncement();
            
            if(!emptyObject($announcementObject)) {
                $pictureMapper = new PictureMapper($announcementMapper);
                $picturesObject = $announcementMapper->getPictures($pictureMapper);
            }
           
            $result = true;
            if(is_array($picturesObject) && !is_null($picturesObject)) {
                foreach($picturesObject as $pictureObject) {
                    $result = emptyObject($pictureObject);
                }     
            }
            if(!$result) {
                foreach($picturesObject as $pictureObject) {
                    $picturesArray[] = extractData($pictureObject);
                }
                if($http->getHttpAccept() == 'json')  {  
                    Rest::sendResponse(200, json_encode($picturesArray), 'application/json');  
                }  
                else if ($http->getHttpAccept() == 'xml')  { 

                    $options = array (  
                        'indent' => '     ',  
                        'addDecl' => false,  
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                        "defaultTagName"     => "user",
                    );  

                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($picturesArray), 'application/xml');  
                }
            } else {
                Rest::sendResponse(204);
            }
                break;
            default :
                Rest::sendResponse(501);
                    break;
    }