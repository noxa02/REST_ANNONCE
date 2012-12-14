<?php 

    /**
     * Get the HTTP method and differents data.
     */
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $incoming_ = new Incoming();
                $incomingMapper = new \IncomingMapper();
                $incomingObject = $incomingMapper->selectIncoming();
                $incomingArray = extractData($incomingObject);
                if(!empty($incomingArray)) {
                    
                    if($http->getHttpAccept() == 'json')  {  
                        Rest::sendResponse(200, json_encode($incomingArray), 'application/json');  
                    }  
                    else if ($http->getHttpAccept() == 'xml')  {  

                        $options = array (  
                            'indent'         => '     ',  
                            'addDecl'        => false,  
                            "defaultTagName" => "incoming",
                            XML_SERIALIZER_OPTION_RETURN_RESULT => true,

                        );  
                        $serializer = new XML_Serializer($options);  
                        Rest::sendResponse(200, $serializer->serialize($incomingArray), 'application/xml');   
                    }               
                } else {
                    Rest::sendResponse(204);
                }
                    break;
            case 'delete':
                $incoming_ = new Incoming();
                $incomingMapper = new \IncomingMapper();
                
                if($incomingMapper->deleteIncoming()) {
                    Rest::sendResponse(200);
                } else {
                    Rest::sendResponse(500);
                }
                    break;
             case 'put':
                $incoming_ = new Incoming();
                $data_incoming_ = $http->getRequestVars();
                $incoming_ = initObject($data_incoming_, $incoming_, true);
                $incomingMapper = new \IncomingMapper();
                $incomingMapper->updateIncoming($incoming_);
                
                Rest::sendResponse(200);
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }