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
 * 
 * @param strign $model
 * @return boolean
 * Check if the model exist
 */
function existModel($model) {
    
    if(is_readable(APPLICATION_PATH . '/models/' . $model.'.class.php')) {
        return true;
    }
    return false;
}
/**
 * 
 * @param string $model
 * @return boolean
 * Check if the controller exist
 */
function existController($model) {
    
    if(is_readable(APPLICATION_PATH . '/controllers/' . $model.'.controller.php')) {
        return true;
    }
    return false;
}
/**
 * 
 * @param strign $model
 * @return boolean
 * Check if the model exist
 */
function existMapper($name) {
    try {
        if(is_null($name)) throw new Exception('Mapper name doesn\'t be null !');
        if(is_readable(APPLICATION_PATH . '/models/Mapper/' . $name.'.class.php')) {
            return true;
        }
        return false;
    } catch(Exception $e) {
        print $e->getMessage(); exit;
    }

}
/**
 * 
 * @param string $url_
 * @return string
 * Parse the URL to return the model to use.
 */
function constructRoute($url) {
    $model = '';

    $firstModel = $url->getModelFirstPart();  
    $secondModel = $url->getModelSecondPart();
    $firstId = $url->getIdFirstPart();
    $secondId = $url->getIdSecondPart();
    
    if(!is_null($firstModel)) {
        
        if(!is_null($firstId)) {
            $model .= ucfirst(substr_replace($firstModel , '', -1));
        } else {
            $model .= ucfirst($firstModel); 
        }
    }

    if(!is_null($secondModel)) {

        if(!is_null($secondId)) {
            if(strrchr($secondModel, 's')) {
                $model .= '_'.ucfirst(substr_replace($secondModel , '', -1));
            } else { 
                $model .= '_'.ucfirst($secondModel);
            }
            
        } else {
            $model .= '_'.ucfirst($secondModel); 
        }
    }
    
    return $model;
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


function resizeAvatar($file, $_user) {
	if(!empty($file)):
	  	if ($file['error'] <= 0):
	    	if ($file['size'] <= 2097152):
	        $avatar = $file['name'];
			$extensionList = array('jpg' => 'image/jpeg', 
								   'jpeg' => 'image/jpeg', 
								   'png' => 'image/png', 
								   'gif' => 'image/gif');
			$extensionListIE = array('jpg' => 'image/pjpg', 
									 'jpeg'=>'image/pjpeg'); 

			$extension = explode('.', $avatar);
			$extension = strtolower($extension[1]);
				if ($extension == 'jpg' 
					|| $extension == 'jpeg' 
						|| $extension == 'pjpg' 
							|| $extension == 'pjpeg' 
								|| $extension == 'gif' 
									|| $extension == 'png'):
					$_avatar = getimagesize($file['tmp_name']);
					if($_avatar['mime'] == $extensionList[$extension]  
						|| $_avatar['mime'] == $extensionListIE[$extension]):
						$_avatarR = imagecreatefrompng($file['tmp_name']);
						$widthAvatar = getimagesize($file['tmp_name']);
						$newWidth = 100;
						$newHeigth = 100;
						$reduce = (($newWidth * 100) / $widthAvatar[0] );
						$newWidth = (($widthAvatar[1] * $reduce)/100 );
						$newAvatar = imagecreatetruecolor($newWidth , $newHeigth);
						imagecopyresampled($newAvatar , $_avatarR, 0, 0, 0, 0, $newWidth, $newHeigth, $widthAvatar[0],$widthAvatar[1]);
						imagedestroy($_avatarR);
						imagepng($newAvatar , UPLOAD_FILES.'/avatar/'.strtolower($_user->getLogin()).'.'.$extension, 9);
					endif;
				endif;
			endif;
		endif;
	endif;
}

function getControllerByModel($modelName_) {
    try {
        
        if(is_null($modelName_)) throw new Exception('Model name doesn\'t be null !');
        $folderAssociation = 'associations/';
        
        switch ($modelName_) {
         case 'Users':
         case 'Announcements' :
         case 'Tags' :
         case 'Messages' :
         case 'Pictures' :
         case 'Comments' :
                return 'pluraly';
             break;
         case 'User' :
         case 'Announcement'  : 
         case 'Tag'  :
         case 'Message'  :
         case 'Picture'  :
         case 'Comment'  :
                return 'singular';
             break;
         default:
             return $folderAssociation.$modelName_;
             break;
        }
    } catch (Exception $e) {
        print $e->getMessage(); exit;
    }
}

function getMapper($modelName_) {
    try 
    {
        if(is_null($modelName_)) throw new Exception('Model name doesn\'t be null !');
        
        switch ($modelName_) {
         case 'Users':
         case 'User' :
         case 'User_Messages' :  
         case 'User_Followers' :
         case 'User_Comments' :
                return 'UserMapper';
             break;
         case 'Announcements' :
         case 'Announcement'  : 
         case 'Announcement_Tags' :
         case 'Announcement_Apply' :
                return 'AnnouncementMapper';
             break;
         case 'Tags' :
         case 'Tag'  :
                return 'TagMapper';
             break;
         case 'Messages' :
         case 'Message'  :
                return 'MessageMapper';  
             break;
         case 'Pictures' :
         case 'Picture'  :
                return 'PictureMapper';
             break;
         case 'Comments' :
         case 'Comment'  :
                return 'CommentMapper';
             break;       
         default:
             break;
        }
    } catch (Exception $e) {
        print $e->getMessage(); exit;
    }
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

function initUrlClass($uri_filtered_, $uri_parts_) {
    try {
        
        $url = new Url;
        if(strpos($uri_filtered_, '?')) {
            $args = explode('?', $uri_filtered_);

            if(isset($args) && is_array($args) && count($args) > 1) {
                if(strpos($args[1], '&')) {
                    $temp = explode('&', $args[1]);
                    if(isset($temp) && is_array($temp) && !empty($temp)) {
                        $url->setUrlArguments($temp);            
                    }
                }
            }         
        }
        
        $uri_parts_  = refreshArrayKeys($uri_parts_);
        foreach ($uri_parts_ as $key => $value) {
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

function refreshArrayKeys(Array $array_) {
    return array_values($array_);
}

function getNameByMapper($mapper_) {
    try {
        return  strstr($mapper_, 'Mapper', true);
    } catch(Exception $e) {
        print $e->getMessage(); exit;
    }
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