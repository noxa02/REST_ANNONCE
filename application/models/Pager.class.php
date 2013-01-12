<?php

class Pager {
    
     private $_totalItems;
     private $_limit;
     private $_nbPages; 
     private $_currentPage;
    
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
    function setTotalItems($totalItems_) {
		$this->_totalItems = $totalItems_;
	}

	public 
    function setLimit($limit_)
	{
		$this->_limit = $limit_;
	}

	public 
    function setNbPages($nbPages_)
	{
		$this->_nbPages = $nbPages_;
	}

	public 
    function setCurrentPage($currentPage_)
	{
        $this->_currentPage = ($currentPage_ == 1) ? 0 : $currentPage_ - 1;  
	}
}
