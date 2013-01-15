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

            $uri_filtered = str_replace($url, '', $uri);
            $uri_args = explode('/', $uri_filtered);

            (is_array($uri_args)) ? cleanArray($uri_args, '') : throwException('URL arguments doesn\'t be null !');

            return $uri_args;

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
}

?>
