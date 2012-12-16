<?php 

    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $comment_ = new Comment();
                $commentMapper = new \CommentMapper();
                $commentObject = $commentMapper->selectComment();
                $commentArray = extractData($commentObject);
                
                if(!empty($commentArray)) {
                    
                    if($http->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($commentArray), 'application/json');  
                    }  
                    else if ($http->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent'         => '     ',  
                            'addDecl'        => false,  
                            "defaultTagName" => "comment",
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,

                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($commentArray), 'application/xml');   
                    }               
                } else {
                    Rest::sendResponse(204);
                }
                    break;
            case 'delete':
                $commentMapper = new \CommentMapper();
                if($commentMapper->deleteComment()) {
                    Rest::sendResponse(200);
                }
                    break;
             case 'put':
                try {
                    $comment_ = new Comment();
                    $data_comment_ = $http->getRequestVars();
                    $commentObject = initObject($data_comment_, $comment_, true);

                    if(!emptyObject($commentObject)) {
                        $commentMapper = new \CommentMapper();
                        if($commentMapper->updateComment($commentObject)) {
                            Rest::sendResponse(200);
                        }
                    } else {
                        throw new InvalidArgumentException('Need arguments to UPDATE data !');
                    }
                } catch(InvalidArgumentException $e) {
                    print $e->getComment(); exit;
                }
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }