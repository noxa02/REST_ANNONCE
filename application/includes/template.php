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
 * @param string $url_
 * @return string
 * Parse the URL to return the model to use.
 */
function constructRoute($url_) {
    
    $model = '';
    if($url_->getModelFirstPart() != null) {
        
        if($url_->getIdFirstPart() != null) {
            $model .= ucfirst(substr_replace($url_->getModelFirstPart() , '', -1));
        } else {
            $model .= ucfirst($url_->getModelFirstPart()); 
        }
    }

    if($url_->getModelSecondPart() != null) {

        if($url_->getIdSecondPart() != null) {
            $model .= '_'.ucfirst(substr_replace($url_->getModelSecondPart() , '', -1));
        } else {
            $model .= '_'.ucfirst($url_->getModelSecondPart()); 
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
 * @param object $object_
 * @param array $arrayFilter
 * @return array
 * Extract object data to return an array
 */
function extractData($object_, array $arrayFilter = array(), $multiple = false) {
$data = null;
    if(!$multiple) {
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
    } elseif($multiple) {
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
function initObject($data_, $object_, $return = false, $initObject = true, $opts_ = array()) {
    if(is_a($object_, 'stdClass')) {
        $object_ = new stdClass();
        if(isset($data_) && !empty($data_)) {
           foreach ($data_ as $key => $value) { 
               $object_->$key = $value;
           }
        }
    } else {
        if($initObject) {
            $object_ = new $object_(); 
        }
        if(isset($data_) && !empty($data_)) {
           foreach ($data_ as $key => $value) {
               $_methodName = ucfirst($key);
               if(strpos($key, '_')) {
                   $beginMethod = ucfirst(strstr($key, '_', true));
                   $endMethod = ucfirst(str_replace('_', '', strstr($key, '_')));
                   $_methodName = $beginMethod.$endMethod;
               }

               $_method = 'set'.$_methodName;
               if(method_exists($object_, $_method)) {
                   if(in_array('password', $opts_)) {
                       $object_->$_method($value, true);
                   }
                   $object_->$_method($value);
               }
           }
        }     
    }
    
    if($return) {
        return $object_;
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

function emptyObject($object_) {
    $ref = new ReflectionObject($object_);
    $properties = $ref->getProperties();

    if(isset($object_) && is_object($object_) && !empty($properties)) {
            return false;
    }
    return true;
}


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
