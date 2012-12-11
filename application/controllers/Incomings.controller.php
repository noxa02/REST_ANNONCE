<?php 
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $incomingMapper = new \IncomingMapper();
                $incomingsObject = $incomingMapper->select(true);
                foreach($incomingsObject as $incomingObject) {
                    $incomingsArray[] = extractData($incomingObject);
                }
                if($http->getHttpAccept() == 'json')  {  
                    Rest::sendResponse(200, json_encode($incomingsArray), 'application/json');  
                }  
                else if ($http->getHttpAccept() == 'xml')  { 
                    
                    $options = array (  
                        'indent' => '     ',  
                        'addDecl' => false,  
                        XML_SERIALIZER_OPTION_RETURN_RESULT => true,
                        "defaultTagName"     => "incoming",
                    );  
                    
                    $serializer = new XML_Serializer($options);  
                    Rest::sendResponse(200, $serializer->serialize($incomingsArray), 'application/xml');  
                }
                    break;
            case 'post':
                    $incoming = new Incoming();
                    $data_incoming = $http->getRequestVars();
                    $incoming = initObject($data_incoming, $incoming, true);
                    
                    $incomingMapper = new IncomingMapper();
                    if($incomingMapper->insert($incoming)) {
                        Rest::sendResponse(200);   
                    }
                    
                    break;
            default :
                Rest::sendResponse(501);
                    break;
    }