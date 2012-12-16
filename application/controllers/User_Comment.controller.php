<?php 
    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();

    switch($http->getMethod())
    {
        case 'get':
            $userMapper = new UserMapper();
            $userCommentObject = $userMapper->getComment();
            $userCommentArray = extractData($userCommentObject);
            
            if(!empty($userCommentArray)) {

                if($http->getHttpAccept() == 'json')  {  

                    Rest::sendResponse(200, json_encode($userCommentArray), 'application/json');  
                }  
                else if ($http->getHttpAccept() == 'xml')  {  

                    $options = array (  
                        'indent'         => '     ',  
                        'addDecl'        => false,  
                        "defaultTagName" => "user_comment",
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,

                    );  
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($userCommentArray), 'application/xml');   
                }               
            } else {
                Rest::sendResponse(204);
            }
                break;
        case 'delete':
            $userMapper = new UserMapper();
            if($userMapper->stopFollow($url->getIdFirstPart(), $url->getIdSecondPart())) {
                Rest::sendResponse(200);
            }
               break;
         case 'put':
            try {
                $user_comment_ = new User_comment();
                $data_user_comment_ = $http->getRequestVars();
                $user_comment_ = initObject($data_user_comment_, $user_comment_, true);

                if(!emptyObject($user_comment_)) {
                    $user_commentMapper = new \User_commentMapper();
                    if($user_commentMapper->update($user_comment_)) {
                        Rest::sendResponse(200);      
                    }
                } else {
                    throw new InvalidArgumentException('Need arguments to UPDATA data !');
                }  
            } catch(InvalidArgumentException $e) {
                print $e->getMessage(); exit;
            }
                break;
         case 'post':
            try {
                $comment = new Comment();
                $data_comment = $http->getRequestVars();
                $commentObject = initObject($data_comment, $comment, true);
                
                if(!emptyObject($commentObject)) {
                    $userMapper = new UserMapper();
                    if($userMapper->sendComment($commentObject)) {
                        Rest::sendResponse(200);   
                    }       
                } else {
                    throw new InvalidArgumentException('Need arguments to POST data !');
                }
            } catch(InvalidArgumentException $e) {
                print $e->getMessage(); exit;
            }
                break;
         default :
            Rest::sendResponse(501);
                break;
    }