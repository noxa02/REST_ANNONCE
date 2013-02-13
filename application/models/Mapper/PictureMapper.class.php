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
            $files = (method_exists('Mapper','getFiles')) ? $this->getFiles() : array();
            if(!$skipInit && count($files) == 1 && !isset($files['files']['name']) 
                    || !$skipInit && isset($files['files']['name']) && count($files['files']['name']) == 1) {
                /**
                 * Single upload by Ajax request
                 */
                if(isset($files['files']['name'])) {
                    $id_announcement = $_POST['id_announcement'];
                    $keys = array_keys($files['files']);
                    for($i = 0; $i < count($files['files'][$keys[0]]); $i++) {
                        $file = array();
                        $picture = new Picture();
                        foreach ($keys as $k => $v) {
                            switch ($v) {
                                case 'tmp_name':
                                    $picture->setTmpName($files['files'][$v][$i]);
                                    $dimension = getimagesize($files['files'][$v][$i]);
                                    $picture->setWidth($dimension[0]);
                                    $picture->setHeight($dimension[1]);
                                break;
                                case 'type':
                                    $picture->setType($files['files'][$v][$i]);
                                break;
                            }
                        }
                            $pictureExt = substr(strrchr($picture->getType(), "/"), 1); 
                            $picture->setPath('/announcement/original/');
                            $picture->setTitle(uniqid());
                            $picture->setIdAnnouncement($id_announcement);
                            $picture->setExtension($pictureExt);
                    }
                /**
                 *  Basic multiple upload
                 */
                } else {
                    $keys = array_keys($files);
                    $file = $files[$keys[0]];
                    $dimension = getimagesize($file['tmp_name']);
                    $picture = initObject($file, $picture, true, false);
                    $picture->setWidth($dimension[0]);
                    $picture->setHeight($dimension[1]);
                    $pictureExt = substr(strrchr($picture->getType(), "/"), 1); 
                    $picture->setPath('/announcement/original/');
                    $picture->setTitle(uniqid()); 
                    $picture->setExtension($pictureExt);
                }

            } elseif(!$skipInit && count($files) > 1 && !isset($files['files']['name']) 
                    || !$skipInit && isset($files['files']['name']) && count($files['files']['name']) > 1) {
                /**
                 * Multiple upload by Ajax request
                 */
                $pictures = array();
                $id_announcement = $_POST['id_announcement'];
                if(isset($files['files']['name'])) {
                    $keys = array_keys($files['files']);
                    for($i = 0; $i < count($files['files'][$keys[0]]); $i++) {
                        $file = array();
                        $picture = new Picture();
                        foreach ($keys as $k => $v) {
                            switch ($v) {
                                case 'tmp_name':
                                    $picture->setTmpName($files['files'][$v][$i]);
                                    $dimension = getimagesize($files['files'][$v][$i]);
                                    $picture->setWidth($dimension[0]);
                                    $picture->setHeight($dimension[1]);
                                break;
                                case 'type':
                                    $picture->setType($files['files'][$v][$i]);
                                break;
                            }
                        }
                            $pictureExt = substr(strrchr($picture->getType(), "/"), 1); 
                            $picture->setPath('/announcement/original/');
                            $picture->setTitle(uniqid()); 
                            $picture->setIdAnnouncement($id_announcement);
                            $picture->setExtension($pictureExt);
                            $pictures[] = $picture;
                    }
                /**
                 *  Basic multiple upload
                 */
                } else {
                    $pictures = array();
                    $id_announcement = $picture->getIdAnnouncement();
                    foreach($files as $key => $file) {
                        $picture = new Picture();
                        $dimension = getimagesize($file['tmp_name']);
                        $picture = initObject($file, $picture, true, false);
                        $picture->setWidth($dimension[0]);
                        $picture->setHeight($dimension[1]);
                        $pictureExt = substr(strrchr($picture->getType(), "/"), 1); 
                        $picture->setPath('/announcement/original/');
                        $picture->setTitle(uniqid()); 
                        $picture->setExtension($pictureExt); 
                        $picture->setIdAnnouncement($id_announcement);
                        $pictures[] = $picture;
                    }
                }

                $allUploaded = true;
                foreach ($pictures as $key => $picture) {
                    if(move_uploaded_file(
                        $picture->getTmpName(), 
                        UPLOAD_PATH .'/announcement/original/'.$picture->getTitle().'.'.$picture->getExtension()
                    )) {
                        if(!parent::insert($this->getTable(), $picture, array('tmp_name', 'size', 'type', 'file_title'))) {
                            $allUploaded = false;
                        }  
                    }
                }

                if($allUploaded) {
                    Rest::sendResponse(201, 'Pictures were been uploaded !');
                }
            }
            if(count($files) == 1 && !isset($files['files']['name']) 
                    || isset($files['files']['name']) && count($files['files']['name']) == 1) {
                if(move_uploaded_file(
                    $picture->getTmpName(), 
                    UPLOAD_PATH .'/announcement/original/'.$picture->getTitle().'.'.$picture->getExtension()
                )) {
                    return parent::insert($this->getTable(), $picture, array('tmp_name', 'size', 'type', 'file_title'));   

                } else {
                    throw new Exception('A problem occurred during the picture upload');
                }  
            }
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @param Picture $picture_
     * @throws InvalidArgumentException
     */
    public 
    function updatePicture(Picture $picture, $conditions = null) 
    {
        try 
        {
            if(method_exists($this, 'getId') && !is_null($this->getId()) && is_null($conditions)) {
                $conditions = ' WHERE id = '.$this->getId();
            }
            
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
            
            return parent::update($this->getTable(), $picture, $conditions); 
            
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
    function deletePicture($conditions = null) 
    {
        if(method_exists($this, 'getId') && !is_null($this->getId()) && is_null($conditions)) {
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
             
            $conditionsChilds = ' WHERE title = "'.$title.'" AND path != "'.$path.'"';
            $childs_picture = $this->select($this->getTable(), true, $conditionsChilds);
            if(isset($childs_picture) && !empty($childs_picture)) {
                foreach ($childs_picture as $key => $picture) {
                    $picture = initObject($picture, new Picture(), true, false);
                    $path = $picture->getPath(); 
                    $title = $picture->getTitle();
                    $ext = $picture->getExtension();
                    $conditionsChildPicture = ' WHERE id = '.$picture->getId();
                    if(parent::delete($this->getTable(), $conditionsChildPicture)) {
                        if(file_exists(UPLOAD_PATH.$path.$title.'.'.$ext)) {
                            unlink(UPLOAD_PATH.$path.$title.'.'.$ext);
                        }           
                    } else {
                        Rest::sendResponse(409, 'Failed to remove resized picture, id : '.$picture->getId().' !'); exit;
                    }
                }
            }
            
            if(parent::delete($this->getTable(), $conditions)) {
                //Remove to the pictures folders
                if(file_exists(UPLOAD_PATH.$path.$title.'.'.$ext)) {
                    unlink(UPLOAD_PATH.$path.$title.'.'.$ext);
                }
            }

        } else {
            Rest::sendResponse(404, 'Picture doesn\'t exist !');
        }
    }
    
    public
    function resizePicture(Picture $picture, $width, $height) 
    {
        if(!empty($width) && !empty($height)) {
            $picture->setWidth($width);
            $picture->setHeight($height);
            $conditions = ' WHERE id_announcement = '.$picture->getIdAnnouncement().
                            ' AND width = '.$picture->getWidth().' AND height = '.$picture->getHeight().
                            ' AND title = "'.$picture->getTitle().'"';
            
            if(!parent::exist('PICTURE', 'Picture', 'pictureMapper', $conditions)) {
                
                $extension = $picture->getExtension();
                $title = $picture->getTitle();
                $folder = $width.'x'.$height;
                $path = $picture->getPath();
                $path_resize = UPLOAD_PATH.'/announcement/'.$folder.'/'.$title.'.'.$extension;
                
                if(!file_exists(UPLOAD_PATH.'/announcement/'.$folder)) {
                    mkdir(UPLOAD_PATH.'/announcement/'.$folder, 0755);
                }
                $imagine = new Imagine\Gd\Imagine();
                $size = new Imagine\Image\Box($width, $height);
                
                $imagine->open(UPLOAD_PATH.'/'.$path.$title.'.'.$extension)
                        ->resize($size)
                        ->save(UPLOAD_PATH.'/announcement/'.$folder.'/'.$title.'.'.$extension, array('quality' => 72));
                
                if(file_exists($path_resize)) {
                    $picture->setPath('/announcement/'.$folder.'/');
                    $picture->setId(NULL);
                    return parent::insert($this->getTable(), $picture);   
                }
                
            } else {
                Rest::sendResponse(409, 'Picture already exist !');
            }
        }
    }
}