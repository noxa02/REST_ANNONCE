<?php 
    $http = Rest::initProcess();
    
    switch($http->getMethod())
    {
            case 'get':
                $incomingMapper = new \IncomingMapper();
                $incomingsObject = $incomingMapper->selectIncoming(true);
                $result = true;
                if(is_array($incomingsObject) && !is_null($incomingsObject)) {
                    foreach($incomingsObject as $incomingObject) {
                        $result = emptyObject($incomingObject);
                    }     
                }
                if(!$result) {
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
                } else {
                    Rest::sendResponse(204);
                }

                    break;
            case 'post':
                try {
                    $incoming = new Incoming();
                    $data_incoming = $http->getRequestVars();
                    $incoming = initObject($data_incoming, $incoming, true);
                    
                    if(!emptyObject($incoming)) {
                        $incomingMapper = new IncomingMapper();
                        if($incomingMapper->insertIncoming($incoming)) {
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