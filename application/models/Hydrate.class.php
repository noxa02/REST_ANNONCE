<?php
class Hydrate {
    
	public 
    function init()
	{
		$countArgs = func_num_args();
		$data = func_get_args();
		$array = func_get_arg(0);

        if(isset($array) && is_array($array)) {
            foreach ($array as $key => $value)
            { 	
                if(strpos($key, '_')) {
                    $beginMethod = ucfirst(strstr($key, '_', true));
                    $endMethod = ucfirst(str_replace('_', '', strstr($key, '_')));
                    $methodName = $beginMethod.$endMethod;
                } else {
                    $methodName = ucfirst($key);
                }
                
                $method = 'set'.$methodName;
                if(method_exists($this, $method))
                {
                    $this->$method($value);
                }

            }         
        }
	}
}

