<?php 
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $pictureMapper = new \PictureMapper();
                $picturesObject = $pictureMapper->selectPicture(true);
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
                            "defaultTagName"     => "picture",
                        );  

                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($picturesArray), 'application/xml');  
                    }             
                } else {
                    Rest::sendResponse(204);
                }
                    break;
            case 'post':
                try {
                    $picture = new Picture();
                    $data_picture = $http->getRequestVars();
                    $pictureObject = initObject($data_picture, $picture, true);

                    if(!emptyObject($pictureObject)) {
                       $pictureMapper = new PictureMapper();
                       if($pictureMapper->insertPicture($pictureObject)) {
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