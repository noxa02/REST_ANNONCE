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
    
    function __construct() {
        $this->modelFirstPart = $this->modelSecondPart = null;
        $this->idFirstpart = $this->idSecondpart     = null;
    }
    
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
}

?>
