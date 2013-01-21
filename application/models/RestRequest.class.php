<?php

class RestRequest
{
	private $request_vars;
	private $data;
    private $files; 
	private $http_accept;
	private $method;
    private $user;
    private $password;

	public 
    function __construct()
	{
		$this->request_vars = array();
		$this->data         = '';
        $this->files        = '';
		$this->http_accept  = (strpos($_SERVER['HTTP_ACCEPT'], 'json')) ? 'json' : 'xml';
		$this->method       = '';
        $this->user         = '';
        $this->password     = ''; 
	}

	public 
    function setData($data)
	{
		$this->data = $data;
	}
    
	public 
    function setFiles($files)
	{
		$this->files = $files;
	}
    
	public 
    function setMethod($method)
	{
		$this->method = $method;
	}

	public 
    function setRequestVars($request_vars)
	{
		$this->request_vars = $request_vars;
	}

    public 
    function setPassword($password)
	{
		$this->password = $password;
	}

    public 
    function setUser($user)
	{
		$this->user = $user;
	}
    
	public 
    function getData()
	{
		return $this->data;
	}

    public 
    function getFiles()
	{
		return $this->files;
	}
    
	public 
    function getMethod()
	{
		return $this->method;
	}

	public 
    function getHttpAccept()
	{
		return $this->http_accept;
	}

	public 
    function getRequestVars()
	{
		return $this->request_vars;
	}
    
	public 
    function getPassword()
	{
		return $this->password;
	}
    
	public 
    function getUser()
	{
		return $this->user;
	}    
}

