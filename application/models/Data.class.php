<?php
/**
 * Description of Data
 *
 * @author Hait
 */
class Data {
    private $format;
    private $options;
    private $data;
    
    public
    function getFormat() {
        return $this->format;
    }
    
    public
    function getOptions() {
        return $this->options;
    }
    
    public
    function getData() {
        return $this->data;
    }
    
    public
    function setFormat($format) {
        $this->format = $format;
    }
    
    public
    function setOptions($options) {
        $this->options = $options;
    }
    
    public
    function setData($data) {
        $this->data = $data;
    }
    
    public 
    function sendData() {

        if($this->getFormat() == 'json')  {
            
             Rest::sendResponse(200, json_encode($this->getData()), 'application/json');  
             
         } elseif($this->getFormat()== 'xml')  { 
             
             $serializer = new XML_Serializer($this->getOptions());  
             Rest::sendResponse(200, $serializer->serialize($this->getData()), 'application/xml');  

         }            
    }
}

?>
