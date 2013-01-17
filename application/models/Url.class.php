<?php
/**
 * Description of Url
 *
 * @author Hait
 */
class Url {
    
    private $modelFirstPart;
    private $modelSecondPart;
    private $idFirstpart;
    private $idSecondpart;
    private $urlArguments;
    
    public 
    function getModelFirstPart() {
        return $this->modelFirstPart;
    } 
    
    public 
    function getModelSecondPart() {
        return $this->modelSecondPart;
    } 
    
    public 
    function getIdFirstPart() {
        return $this->idFirstpart;
    } 
 
    public 
    function getIdSecondPart() {
        return $this->idSecondpart;
    } 
    
    public 
    function getUrlArguments() {
        return $this->urlArguments;
    }
    public 
    function setModelFirstPart($modelFirstPart_) {
        $this->modelFirstPart = $modelFirstPart_;
    } 
    
    public 
    function setModelSecondPart($modelSecondPart_) {
        $this->modelSecondPart = $modelSecondPart_;
    } 
    
    public 
    function setIdFirstPart($idFirstpart_) {
        $this->idFirstpart = $idFirstpart_;
    } 
 
    public 
    function setIdSecondPart($idSecondpart_) {
        $this->idSecondpart = $idSecondpart_;
    } 
    
    public
    function setUrlArguments($urlArguments_) {
        $this->urlArguments = $urlArguments_;
    }
    
    public
    function parserUrl() {
        try 
        {
            $uri = (($uri = prepareRequestUri()) && !empty($uri)) 
                ? prepareRequestUri() : throwException('URI doesn\'t be null ! A problem has occured.');
            $url = (($url = prepareBaseUrl()) && !empty($url)) 
                ? prepareBaseUrl() : throwException('URL doesn\'t be null ! A problem has occured.');

            $uriFiltered = str_replace($url, '', $uri);
            $uriArgs = explode('/', $uriFiltered);

            (is_array($uriArgs)) ? cleanArray($uriArgs, '') : throwException('URL arguments doesn\'t be null !');

            return $uriArgs;

        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    public
    function getUri() {
        $uri = (($uri = prepareRequestUri()) && !empty($uri)) 
            ? prepareRequestUri() : throwException('URI doesn\'t be null ! A problem has occured.');
        $url = (($url = prepareBaseUrl()) && !empty($url)) 
            ? prepareBaseUrl() : throwException('URL doesn\'t be null ! A problem has occured.');

        $uri_filtered = str_replace($url, '', $uri);

        return (isset($uri_filtered) && !empty($uri_filtered)) 
            ? $uri_filtered : throwException('URI doesn\'t be null ! A problem has occured.');
    }
    
    public
    function initUrlClass($uriFiltered, $uriParts) 
    {
        try {

            $url = new Url;
            if(strpos($uriFiltered, '?')) {
                
                $args = explode('?', $uriFiltered);

                if(isset($args) && is_array($args) && count($args) > 1) {
                    if(strpos($args[1], '&')) {
                        $temp = explode('&', $args[1]);
                        if(isset($temp) && is_array($temp) && !empty($temp)) {
                            $url->setUrlArguments($temp);            
                        }
                    }
                }         
            }

            $uriParts  = refreshArrayKeys($uriParts);
            foreach ($uriParts as $key => $value) {
                /**
                 * Check if url contains some arguments 
                 * Example : /path/to/web/model/?order=DESC
                 */
                if(strpos($value, '?') !== false) {
                    $value = strstr($value, '?', true);
                }
                /**
                 * Use the object URL and set the different parts of the URL 
                 * to associate attributes.
                 */
                if(!is_string($value) && is_numeric($value) || !is_string($value)) {
                  throw new InvalidArgumentException('First Argument must be a string !');  
                } elseif($key === 0 && !is_numeric($value) && is_string($value)) { 
                    $url->setModelFirstPart($value);
                } elseif($key % 2 != 0) { 
                    if(!empty($value) && !is_numeric($value)) {
                        throw new InvalidArgumentException('Second Argument must be an integer !');
                    } elseif($key === 1 && is_numeric($value)) {
                        $url->setIdFirstPart($value);
                    } elseif(is_numeric($value)) {
                        $url->setIdSecondPart($value);
                    }
                } elseif($key % 2 == 0) {
                    if($key === 2 && !is_numeric($value)) {
                        $url->setModelSecondPart($value);
                    }
                }
            }

            return $url;
            
        } catch (InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        }
    }
}

?>
