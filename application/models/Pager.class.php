<?php

class Pager {
    
     private $_totalItems;
     private $_limit;
     private $_nbPages; 
     private $_currentPage;
     
     function __construct() {
         global $http;
         Hydrate::init($http->getRequestVars()); 
     }

     /**
     * 
     * Méthodes GET
     */
    
	public 
    function getTotalItems()
	{
		return $this->_totalItems;
	}

	public 
    function getLimit()
	{
		return $this->_limit;
	}

	public 
    function getNbPages()
	{
		return $this->_nbPages;
	}

	public 
    function getCurrentPage()
	{
		return $this->_currentPage;
	}
    
    /**
     * Méthodes SET
     */

	public 
    function setTotalItems($totalItems) {
		$this->_totalItems = $totalItems;
	}

	public 
    function setLimit($limit)
	{
        if(is_numeric($limit)) {
            $this->_limit = $limit;
        } else {
            throwException('Limit value must be an numeric value !');
        }
	}

	public 
    function setNbPages($nbPages)
	{
		$this->_nbPages = $nbPages;
	}

    public 
    function setCurrentPage($currentPage)
	{
        if(is_numeric($currentPage)) {
            $this->_currentPage = ($currentPage == 1) ? 0 : $currentPage - 1;
        } else {
            throwException('Page value must be an numeric value !');
        }
	}
}
