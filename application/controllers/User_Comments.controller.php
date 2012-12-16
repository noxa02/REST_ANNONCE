<?php 
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $userMapper = new UserMapper();
                $commentsObject = $userMapper->getComments();
                $result = true;
                if(is_array($commentsObject) && !is_null($commentsObject)) {
                    foreach($commentsObject as $commentObject) {
                        $result = emptyObject($commentObject);
                    }     
                }
                if(!$result) {
                    foreach($commentsObject as $commentObject) {
                        $commentsArray[] = extractData($commentObject);
                    }
                    if($http->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($commentsArray), 'application/json');  
                    }  
                    else if ($http->getHttpAccept() == 'xml')  { 

                        $options = array (  
                            'indent' => '     ',  
                            'addDecl' => false,  
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                            "defaultTagName"     => "comment",
                        );  

                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($commentsArray), 'application/xml');  
                    }       
                } else {
                    Rest::sendResponse(204);
                }
                    break;
            case 'post':
                try {
                    $comment = new Comment();
                    $data_comment = $http->getRequestVars();
                    $commentObject = initObject($data_comment, $comment, true);
                    if(!emptyObject($commentObject)) {
                        $commentMapper = new CommentMapper();
                        if($commentMapper->insertComment($commentObject)) {
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