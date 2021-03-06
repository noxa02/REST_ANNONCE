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
            }
               break;
         case 'put':
            try {
                $user_follower_ = new User_follower();
                $data_user_follower_ = $http->getRequestVars();
                $user_follower_ = initObject($data_user_follower_, $user_follower_, true);

                if(!emptyObject($user_follower_)) {
                    $user_followerMapper = new \User_followerMapper();
                    if($user_followerMapper->update($user_follower_)) {
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
                $user = new User();
                $data_user = $http->getRequestVars();
                $user = initObject($data_user, $user, true);
                
                if(!emptyObject($user)) {
                    $userMapper = new UserMapper();
                    if($userMapper->goFollow($url->getIdFirstPart(), $url->getIdSecondPart())) {
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