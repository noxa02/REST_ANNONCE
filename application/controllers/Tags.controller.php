<?php 
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $tagMapper = new \TagMapper();
                $tagsObject = $tagMapper->selectTag(true);
                $result = true;
                if(is_array($tagsObject) && !is_null($tagsObject)) {
                    foreach($tagsObject as $tagObject) {
                        $result = emptyObject($tagObject);
                    }     
                }
                if(!$result) {
                    foreach($tagsObject as $tagObject) {
                        $tagsArray[] = extractData($tagObject);
                    }
                    if($http->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($tagsArray), 'application/json');  
                    }  
                    else if ($http->getHttpAccept() == 'xml')  { 

                        $options = array (  
                            'indent' => '     ',  
                            'addDecl' => false,  
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                            "defaultTagName"     => "tag",
                        );  

                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($tagsArray), 'application/xml');  
                    }
                } else {
                    Rest::sendResponse(204);
                }
                    break;
            case 'post':
                try {
                    $tag = new Tag();
                    $data_tag = $http->getRequestVars();
                    $tagObject = initObject($data_tag, $tag, true);

                    if(!emptyObject($tagObject)) {
                        $tagMapper = new TagMapper();
                        if($tagMapper->insertTag($tagObject)) {
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