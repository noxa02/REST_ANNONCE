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
            $file = (method_exists('Mapper','getFiles')) ? $this->getFiles() : array();
            if(!$skipInit) {
                if(!empty($file)) {
                    $keys = array_keys($file);
                    $file = $file[$keys[0]];
                    $dimension = getimagesize($file['tmp_name']);
                    $picture = initObject($file, $picture, true, false);
                    $picture->setWidth($dimension[0]);
                    $picture->setHeight($dimension[1]);
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

            //Remove to the pictures folders
            if(file_exists(UPLOAD_PATH.$path.$title.'.'.$ext)) {
                unlink(UPLOAD_PATH.$path.$title.'.'.$ext);
            }

            return parent::delete($this->getTable(), $conditions);

        } else {
            Rest::sendResponse(404, 'Picture doesn\'t exist !');
        }
    }
    
    public
    function resizePicture(Picture $picture, $height, $width) 
    {
        $conditions = ' WHERE id = '.$this->getFirstId();
        $original_picture = $this->select($this->getTable(), false, $conditions);
        $picture = initObject($original_picture, $picture, true, false);
        
        if(!empty($width) && !empty($height)) {
            
            $picture->setWidth($width);
            $picture->setHeight($height);
            $conditions = ' WHERE id_announcement = '.$picture->getIdAnnouncement().
                            ' AND width = '.$picture->getWidth().' AND height = '.$picture->getHeight();
            
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
                $imagine->open(UPLOAD_PATH.$path.$title.'.'.$extension)
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