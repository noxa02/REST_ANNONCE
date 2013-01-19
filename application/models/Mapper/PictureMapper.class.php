<?php
class PictureMapper extends Mapper {
    
    protected $table = 'PICTURE';

    function __construct() {
        parent::__construct();
    }
    
   /**
    * 
    * @param Picture $picture_
    * @param array $arrayFilter
    * @throws InvalidArgumentException
    */
    public 
    function insertPicture(Picture $picture, array $arrayFilter = array(), $skipInit = false) 
    {
        try 
        {   
            if(is_null($this->getTable())) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            
            $file = (method_exists('Mapper','getFiles')) ? $this->getFiles() : array();

            if(!$skipInit) {
                
                if(!empty($file)) {

                    $keys = array_keys($file);
                    $file = $file[$keys[0]];

                    $picture = initObject($file, $picture, true, false);
                    $pictureExt = substr(strrchr($picture->getType(), "/"), 1); 
                    $picture->setPath('/announcement/original/');
                    $picture->setTitle(uniqid()); 
                    $picture->setExtension($pictureExt);
                }
                
            }
            
            if(move_uploaded_file(
                $picture->getTmpName(), 
                UPLOAD_PATH .'/announcement/original/'.$picture->getTitle().'.'.$picture->getExtension()
            )) {
                
                return parent::insert($this->getTable(), $picture, array('tmp_name', 'size', 'type', 'file_title'));   

            } else {
                throw new Exception('A problem occurred during the picture upload');
            }     
            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @param Picture $picture_
     * @throws InvalidArgumentException
     */
    public 
    function updatePicture(Picture $picture_) 
    {
        try {
            
            if(isset($this->table) && is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(isset($this->id) && !is_null($this->id)) {
                $where = 'id = '.$this->id;
            }
            
            //Existance test
            $picture = $this->selectPicture();
            if(!emptyObjectMethod($picture)) { 
                $picture = $this->selectPicture();
                $path = $picture->getPath(); 
                $title = $picture->getTitle();
                $ext = $picture->getExtension();
            
                if(file_exists(UPLOAD_PATH.$path.$title.'.'.$ext)) {
                    if(!is_null($picture_->getTitle()) && $title !== $picture_->getTitle()) {
                        if(!rename(UPLOAD_PATH.$path.$title.'.'.$ext, UPLOAD_PATH.$path.$picture_->getTitle().'.'.$ext)) {
                            throw new Exception('A problem occurred when renaming !');
                        }
                    }
                } 
            } else {
                throw new Exception('Picture doesn\'t exist !');
            }
            
            return parent::update($this->table, $picture_, $where); 
            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @return boolean
     * @throws InvalidArgumentException
     */
    public
    function deletePicture() 
    {
        try 
        {
            if(method_exists($this, 'getId') && !is_null($this->getId())) {
                $conditions = ' WHERE id = '.$this->getId();
            }
            
            //Init a object of picture to delete the picture in the folder.
            //Needed to reconsitued the path.
            $picture = ($picture = $this->select($this->getTable(), false, $conditions)) 
                    ? initObject($picture, new Picture(), true, false) : null;
            
            if(!is_null($picture) && !emptyObjectMethod($picture)) {
                
                $path = $picture->getPath(); 
                $title = $picture->getTitle();
                $ext = $picture->getExtension();

                //Remove to the pictures folders
                if(file_exists(UPLOAD_PATH.$path.$title.'.'.$ext)) {
                    unlink(UPLOAD_PATH.$path.$title.'.'.$ext);
                }

                return parent::delete($this->getTable(), $conditions);
                
            } else {
                Rest::sendResponse(204, 'Picture doesn\'t exist !');
            }
     
            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        }
    }    
}

//	if(!empty($file)):
//	  	if ($file['error'] <= 0):
//	    	if ($file['size'] <= 2097152):
//	        $avatar = $file['name'];
//			$extensionList = array('jpg' => 'image/jpeg', 
//								   'jpeg' => 'image/jpeg', 
//								   'png' => 'image/png', 
//								   'gif' => 'image/gif');
//			$extensionListIE = array('jpg' => 'image/pjpg', 
//									 'jpeg'=>'image/pjpeg'); 
//
//			$extension = explode('.', $avatar);
//			$extension = strtolower($extension[1]);
//				if ($extension == 'jpg' 
//					|| $extension == 'jpeg' 
//						|| $extension == 'pjpg' 
//							|| $extension == 'pjpeg' 
//								|| $extension == 'gif' 
//									|| $extension == 'png'):
//					$_avatar = getimagesize($file['tmp_name']);
//					if($_avatar['mime'] == $extensionList[$extension]  
//						|| $_avatar['mime'] == $extensionListIE[$extension]):
//						$_avatarR = imagecreatefrompng($file['tmp_name']);
//						$widthAvatar = getimagesize($file['tmp_name']);
//						$newWidth = 100;
//						$newHeigth = 100;
//						$reduce = (($newWidth * 100) / $widthAvatar[0] );
//						$newWidth = (($widthAvatar[1] * $reduce)/100 );
//
//						$newAvatar = imagecreatetruecolor($newWidth , $newHeigth);
//						imagecopyresampled($newAvatar , $_avatarR, 0, 0, 0, 0, $newWidth, $newHeigth, $widthAvatar[0],$widthAvatar[1]);
//						imagedestroy($_avatarR);
//						imagepng($newAvatar , UPLOAD_FILES.'/avatar/'.strtolower($_user->getLogin()).'.'.$extension, 9);
//					endif;
//				endif;
//			endif;
//		endif;