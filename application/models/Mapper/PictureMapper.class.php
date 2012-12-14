<?php
class PictureMapper extends Mapper {
    
    protected $table = 'PICTURE';
    protected $id;
    protected $foreignTable;

    function __construct() {
        parent::__construct();
        global $url;
        $this->id = $url->getIdFirstPart();
        
        if(func_num_args() == 1 && is_object(func_get_arg(0))) {
            $object_ = func_get_arg(0);
            $this->foreignTable =  $object_;
        }
    }
    
   /**
    * 
    * @param Picture $picture_
    * @param array $arrayFilter
    * @throws InvalidArgumentException
    */
    public 
    function insertPicture(Picture $picture_, array $arrayFilter = array()) 
    {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        
        return parent::insert($this->table, $picture_, $arrayFilter);
    } 
    
    /**
     * 
     * @param Picture $picture_
     * @throws InvalidArgumentException
     */
    public 
    function updatePicture(Picture $picture_) 
    {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        if(isset($this->id) && !is_null($this->id)) {
            $where = 'id = '.$this->id;
        }
        
        parent::update($this->table, $picture_, $where);
    } 
    
    /**
     * 
     * @param boolean $all_
     * @return stdClass
     * @throws InvalidArgumentException
     */
    public
    function selectPicture($all_ = false) 
    {
        $where = null;
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        
        if(isset($this->foreignTable) && !is_null($this->foreignTable)) {
            $fkName = 'id_'.strtolower($this->foreignTable->getTable());
            $where  = $fkName.' = '.$this->foreignTable->getId();
        } elseif(isset($this->id) && !is_null($this->id)) {
            $where = 'id = '.$this->id;
        }
        
        return parent::select($this->table, $where, $object = new Picture(), $all_);
    }
    
    /**
     * 
     * @return boolean
     * @throws InvalidArgumentException
     */
    public
    function deletePicture() 
    {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        
        if(isset($this->id) && !is_null($this->id)) {
            $where = 'id = '.$this->id;
        }
        
        $picture = $this->selectPicture();
        $path = $picture->getPath(); 
        $title = $picture->getTitle();
        $ext = $picture->getExtension();
        //Remove to the pictures folders
        if(file_exists(UPLOAD_PATH.$path.$title.'.'.$ext)) {
            if(unlink(UPLOAD_PATH.$path.$title.'.'.$ext)) {
                 return parent::delete($this->table, $where);
            }       
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