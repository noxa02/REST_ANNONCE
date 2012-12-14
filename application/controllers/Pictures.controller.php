<?php 
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $pictureMapper = new \PictureMapper();
                $picturesObject = $pictureMapper->selectPicture(true);
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
                        "defaultTagName"     => "picture",
                    );  
                    
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($picturesArray), 'application/xml');  
                }
                    break;
            case 'post':
                    $picture = new Picture();
                    $data_picture = $http->getRequestVars();
                    $picture = initObject($data_picture, $picture, true);
                    
                    $pictureMapper = new PictureMapper();
                    if($pictureMapper->insertPicture($picture)) {
                        Rest::sendResponse(200);   
                    }
                    
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }