<?php 
    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $tag_ = new Tag();
                $tagMapper = new \TagMapper();
                $tagObject = $tagMapper->selectTag();
                $tagArray = extractData($tagObject);
                
                if(!empty($tagArray)) {
                    if($http->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($tagArray), 'application/json');  
                    }  
                    else if ($http->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent'         => '     ',  
                            'addDecl'        => false,  
                            "defaultTagName" => "tag",
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,

                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($tagArray), 'application/xml');   
                    }               
                } else {
                    Rest::sendResponse(204);
                }
                    break;
            case 'delete':
                $tag_ = new \Tag();
                $tagMapper = new \TagMapper();
                if($tagMapper->deleteTag()) {
                    Rest::sendResponse(200);
                }
                    break;
             case 'put':
                try {
                    $tag = new \Tag();
                    $data_tag = $http->getRequestVars();
                    $tagObject = initObject($data_tag, $tag, true);
                    if(!emptyObject($tagObject)) {
                        $tagMapper = new \TagMapper();
                        if($tagMapper->updateTag($tagObject)) {
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