<?php 
    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();

    switch($http->getMethod())
    {
        case 'get':
            $userMapper = new UserMapper();
            $userFollowerObject = $userMapper->getFollower();
            $userFollowerArray = extractData($userFollowerObject);

            if(!empty($userFollowerArray)) {

                if($http->getHttpAccept() == 'json')  {  

                    Rest::sendResponse(200, json_encode($userFollowerArray), 'application/json');  
                }  
                else if ($http->getHttpAccept() == 'xml')  {  

                    $options = array (  
                        'indent'         => '     ',  
                        'addDecl'        => false,  
                        "defaultTagName" => "user_follower",
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,

                    );  
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($userFollowerArray), 'application/xml');   
                }               
            } else {
                Rest::sendResponse(204);
            }
                break;
        case 'delete':
            $userMapper = new UserMapper();

            if($userMapper->stopFollow($url->getIdFirstPart(), $url->getIdSecondPart())) {
                Rest::sendResponse(200);
            } else {
                Rest::sendResponse(500);
            }
               break;
         case 'put':
            $user_follower_ = new User_follower();
            $data_user_follower_ = $http->getRequestVars();
            $user_follower_ = initObject($data_user_follower_, $user_follower_, true);
            $user_followerMapper = new \User_followerMapper();
            $user_followerMapper->update($user_follower_);

            Rest::sendResponse(200);
                break;
         case 'post':
            $userMapper = new UserMapper();
            if($userMapper->goFollow($url->getIdFirstPart(), $url->getIdSecondPart())) {
                Rest::sendResponse(200);   
            }
                break;
         default :
            Rest::sendResponse(501);
                    break;
    }