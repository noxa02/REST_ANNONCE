<?php
class AnnouncementMapper extends Mapper {
    
    protected $table = 'ANNOUNCEMENT';
    protected $id;
    protected $files;

    function __construct() {
        parent::__construct();
        global $url;
        $this->id = $url->getIdFirstPart();
        global $http;
        $this->files = $http->getFiles();
    }
    
    /**
     * 
     * @param Announcement $announcement_
     * @throws InvalidArgumentException
     * Insert an announcement and if some pictures are upload they're upload 
     * on the Upload/announcement/original/ folder
     */
    public 
    function insert(Announcement $announcement_) 
    {
        try {
            $pictures = array();
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }

            $idAnnouncement = parent::insert($this->table, $announcement_, array(), true);
            $announcement_->setId($idAnnouncement);

            if(isset($this->files) && !empty($this->files)) {
                foreach($this->files as $file) {
                    $picture = new Picture();
                    $picture = initObject($file, $picture, true);
                    $pictures[] = $picture;
                }
            }
            
            $announcement_->setPictures($pictures);
            if(!is_null($announcement_->getPictures())) {
                foreach ($announcement_->getPictures() as $key => $value) {
                    $pictureExt = substr(strrchr($value->getType(), "/"), 1); 
                    $value->setIdAnnouncement($idAnnouncement);
                    $value->setPath('/announcement/original/');
                    $value->setTitle('announcement_'.$announcement_->getId().'_'.$key);
                    $value->setExtension($pictureExt);
                    move_uploaded_file(
                        $value->getTmpName(), 
                        UPLOAD_PATH .'/announcement/original/'.$value->getTitle().'.'.$pictureExt
                    );

                    $pictureMapper = new PictureMapper();
                    $pictureMapper->insert($value, array('tmp_name', 'size', 'type'));      
                }
            }   
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @param Announcement $announcement_
     * @param string $where
     * @throws InvalidArgumentException
     */
    public 
    function update(Announcement $announcement_, $where_) 
    {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        if(isset($this->id) && !is_null($this->id)) {
            $where_ = 'id = '.$this->id;
        }
        
        parent::update($this->table, $announcement_, $where_);
    } 
    
    /**
     * 
     * @param boolean $all Set True to return all values of the table
     * @return boolean If True -> Success Query / False -> Fail Query
     * @throws InvalidArgumentException
     */
    public
    function select($all_ = false) 
    {
        $where = null;
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        if(isset($this->id) && !is_null($this->id)) {
            $where = 'id = '.$this->id;
        }
        
        return parent::select($this->table, $where, $object = new Announcement(), $all_);
    }
    
    /**
     * 
     * @return Boolean If True -> Success Query / False -> Fail Query
     * @throws InvalidArgumentException
     */
    public
    function delete() 
    {
        if(is_null($this->table)) {
            throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
        }
        if(isset($this->id) && !is_null($this->id)) {
            $where = 'id = '.$this->id;
        }
        
        $pictureMapper = new PictureMapper($this);
        $pictures = $pictureMapper->select(true);

        if(isset($pictures) && !empty($pictures)) {
            foreach ($pictures as $key => $value) {
                $idPicture = $value->getId();
                $path = $value->getPath(); 
                $title = $value->getTitle();
                $ext = $value->getExtension();
                //Remove to the pictures folders
                unlink(UPLOAD_PATH.$path.$title.'.'.$ext);
                //Remove to database
                $pictureMapper = new PictureMapper();
                $pictureMapper->setId($idPicture);
                $pictureMapper->delete();
            }
        }
        
        return parent::delete($this->table, $where);
    }    
}
