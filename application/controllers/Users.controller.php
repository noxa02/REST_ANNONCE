<?php 
    $data = Rest::initProcess();
    
    require_once 'XML/Util.php';
    require_once 'XML/Serializer.php';

    switch($data->getMethod())
    {
            case 'get':
                $users_ = new Users();
                $users_list_ = $users_->getMembers();

                if($data->getHttpAccept() == 'json')  {  
                    Rest::sendResponse(200, json_encode($users_list_), 'application/json');  
                }  
                else if ($data->getHttpAccept() == 'xml')  { 
                    
                    $options = array (  
                        'indent' => '     ',  
                        'addDecl' => false,  
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                        "defaultTagName"     => "user",
                    );  
                    
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($users_list_), 'application/xml');  
                }
                    break;
            case 'post':
                    $user_ = new User();
                    $data_user_ = $data->getRequestVars();

                    if(isset($data_user_) && count($data_user_) > 0) {

                        foreach ($data_user_ as $key => $value) {

                            $_methodName = ucfirst($key);
                            $_method = 'set'.ucfirst($key);
                            
                            if(method_exists($user_, 'set'.$_methodName)) {
                                $user_->$_method($value);
                            }
                        }
                    }
                    $user_->createUser();
                    break;
    }