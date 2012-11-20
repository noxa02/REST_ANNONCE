<?php 
    switch($data->getMethod())
    {
            case 'get':
                $member_ = new Member();
                $members_list_ = getMembersList(); // assume this returns an array  

                if($data->getHttpAccept == 'json')  {  
                    Rest::sendResponse(200, json_encode($members_list_), 'application/json');  
                }  
                else if ($data->getHttpAccept == 'xml')  {  
                    // using the XML_SERIALIZER Pear Package  
                    $options = array (  
                        'indent' => '     ',  
                        'addDecl' => false,  
                        'rootName' => $fc->getAction(),  
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true  
                    );  
                    
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($members_list_), 'application/xml');  
                }
                    break;
            case 'post':
                    $member_ = new Member();
                    $member_->setUserData($data)
                            ->save();
                    break;
    }