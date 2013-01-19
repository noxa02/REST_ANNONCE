<?php

function print_log($vars_) 
{
    print '<pre>';
        var_dump($vars_);
    print '</pre>';
}

function print_logex($vars_) 
{
    print '<pre>';
        var_dump($vars_);
    print '</pre>';
    exit;
}
/**
 * 
 * @param string $password
 * @return string crypted
 * Crypt the password
 */
function sha1_password($password) 
{
    $GDS_1 = 'sdafazc532D2deq';
    $GDS_2 = 'qsfqsgugre8795h';
    
    return sha1(sha1($password.$GDS_2).sha1($GDS_1.$GDS_2));
}
/**
 * @todo Check if the request had the right
 * @return type
 */
function is_admin() {
  $result = false;
  
  if (isset($_SERVER["PHP_AUTH_USER"])) {
      
    $result = $_SERVER["PHP_AUTH_USER"] == "admin" && $_SERVER["PHP_AUTH_PW"] == "admin";
  }
  
  return $result;
}
/**
 * 
 * @param class $object_
 * @param array $arrayFilter
 * @param boolean $multiple
 * @return array
 */
function extractData($object_, array $arrayFilter = array(), $multiple = false) {
$data = null;
    if(!$multiple && is_object($object_) && !is_a($object_, 'stdClass')) {
        foreach (get_class_methods($object_) as $key => $value) {
                if(strpos($value, 'get') !== false) {
                    if(method_exists($object_, $value)) {
                        $method = $object_->$value();
                        if(!is_null($method)) {
                            $key = strtolower(str_replace_limit('_','',preg_replace('/([A-Z])/', '_$1', 
                                                     str_replace('get', '', $value)), 1));
                            $data[$key] = $object_->$value(); 
                        }
                    }
                }
        }
    } elseif($multiple && is_object($object_) && !is_a($object_, 'stdClass')) {
        $temp = null;
        foreach ($object_ as $object) {
            foreach (get_class_methods($object) as $key => $value) {
                    if(strpos($value, 'get') !== false) {
                        if(method_exists($object, $value)) {
                            $method = $object->$value();
                            if(!is_null($method)) {
                                $key = strtolower(str_replace_limit('_','',preg_replace('/([A-Z])/', '_$1', 
                                                         str_replace('get', '', $value)), 1));
                                $temp[$key] = $object->$value(); 
                            }
                        }
                    }
            }     
            $data[] = $temp;
        }
    } elseif(is_a($object_, 'stdClass')) {
        foreach ($object_ as $key => $value) {
            $data[$key] = $value; 
        }
    }
        
        return $data;
}
/**
 * 
 * @param array $data_
 * @param object $object_
 * @param boolean $return (if we want a return = true)
 * @return object $object_
 * Extract array values to return an initialized object
 */
function initObject($data, $object, $return = false, $initObject = true, $opts = array()) {
    if(is_a($object, 'stdClass')) {
        $object = new stdClass();
        if(isset($data) && !empty($data)) {
           foreach ($data as $key => $value) { 
               $object->$key = $value;
           }
        }
    } else {
        if($initObject) {
            $object = new $object(); 
        }
        if(isset($data) && !empty($data)) {
           foreach ($data as $key => $value) {
               $_methodName = ucfirst($key);
               if(strpos($key, '_')) {
                   $beginMethod = ucfirst(strstr($key, '_', true));
                   $endMethod = ucfirst(str_replace('_', '', strstr($key, '_')));
                   $_methodName = $beginMethod.$endMethod;
               }

               $_method = 'set'.$_methodName;
               if(method_exists($object, $_method)) {
                   if($_method == 'setPassword') {
                       $object->$_method($value, true);
                   } else {
                       $object->$_method($value);
                   }
                   
               }
           }
        }     
    }
    
    if($return) {
        return $object;
    }
}

function str_replace_limit($search,$replace,$subject,$limit,&$count = null)
{
    $count = 0;
    if ($limit <= 0) return $subject;
    $occurrences = substr_count($subject,$search);
    if ($occurrences === 0) return $subject;
    else if ($occurrences <= $limit) return str_replace($search,$replace,$subject,$count);
    //Do limited replace
    $position = 0;
    //Iterate through occurrences until we get to the last occurrence of $search we're going to replace
    for ($i = 0; $i < $limit; $i++)
        $position = strpos($subject,$search,$position) + strlen($search);
    $substring = substr($subject,0,$position + 1);
    $substring = str_replace($search,$replace,$substring,$count);
    return substr_replace($subject,$substring,0,$position+1);
}

/**
 * 
 * @param object $object_
 * @return boolean Empty object return TRUE | FALSE
 */
function emptyObject($object_) {
    $ref = new ReflectionObject($object_);
    $properties = $ref->getProperties();

    if(isset($object_) && is_object($object_) && !empty($properties)) {
            return false;
    }
    return true;
}

/**
 * 
 * @param object $object_
 * @return boolean Empty object return TRUE | FALSE
 */
function emptyObjectMethod($object_) {
    $ref = new ReflectionObject($object_);
    $properties = $ref->getProperties();
    
    $temp = true;
    foreach ($properties as $propertie) {
        $propertie->setAccessible(true);
        if(!is_null($propertie->getValue($object_))) {
                $temp = false;
        }
    }
    
    return $temp;
}

function throwException($message_) {
    throw new Exception($message_); exit;
}

function cleanArray(&$array_, $value_) {
    
    if(is_array($array_)) {
        foreach($array_ as $key=>&$arrayElement) {
            if(is_array($arrayElement)) {
                cleanArray($arrayElement, $value_);
            } else {
                if($arrayElement == $value_) {
                    unset($array_[$key]);
                }
            }
        }
    }
}

function refreshArrayKeys(Array $array_) {
    return array_values($array_);
}

function isRequired($requiered, $haystack) {
    try 
    {
        if(isset($haystack) && !emptyObjectMethod($haystack)
                    && isset($requiered) && !empty($requiered)) {
            $array = extractData($haystack);
            
            foreach ($requiered as $key => $value) {
                if(!array_key_exists($value, $array)) {
                    throwException($value. ' argument is requiered !');
                }
            }
            
            return true;
        } 
    } catch(Exception $e) {
        print $e->getMessage(); exit;
    }
}