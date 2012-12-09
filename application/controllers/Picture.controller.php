<?php 

    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $picture_ = new Picture();
                $pictureMapper = new \PictureMapper();
                $pictureObject = $pictureMapper->select();
                $pictureArray = extractData($pictureObject);
                if(!empty($pictureArray)) {
                    
                    if($http->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($pictureArray), 'application/json');  
                    }  
                    else if ($http->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent'         => '     ',  
                            'addDecl'        => false,  
                            "defaultTagName" => "picture",
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,

                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($pictureArray), 'application/xml');   
                    }               
                } else {
                    Rest::sendResponse(204);
                }
                    break;
            case 'delete':
                $picture_ = new Picture();
                $pictureMapper = new \PictureMapper();
                
                if($pictureMapper->delete()) {
                    Rest::sendResponse(200);
                } else {
                    Rest::sendResponse(500);
                }
                    break;
             case 'put':
                $picture_ = new Picture();
                $data_picture_ = $http->getRequestVars();
                $picture_ = initObject($data_picture_, $picture_, true);
                $pictureMapper = new \PictureMapper();
                $pictureMapper->update($picture_);
                
                Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }