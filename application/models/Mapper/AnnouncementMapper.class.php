<?php
class AnnouncementMapper extends Mapper {
    
    protected $table = 'ANNOUNCEMENT';

    function __construct() {
        parent::__construct();
    }
    
    /**
     * 
     * @param Announcement $announcement_
     * @throws InvalidArgumentException
     * Insert an announcement and if some pictures are upload they're upload 
     * on the Upload/announcement/original/ folder
     */
    public 
    function insertAnnouncement(Announcement $announcement_) 
    {
        try {
            
            $pictures = array();
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }

            if(parent::insert($this->table, $announcement_, array(), true)) {
                $idAnnouncement = parent::getlastInsertId(); 
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
                        $value->setTitle(uniqid());
                        $value->setExtension($pictureExt);
                        move_uploaded_file(
                            $value->getTmpName(), 
                            UPLOAD_PATH .'/announcement/original/'.$value->getTitle().'.'.$pictureExt
                        );

                        $pictureMapper = new PictureMapper();
                        $pictureMapper->insertPicture($value, array('tmp_name', 'size', 'type'), false);      
                    }
                }   
                
                return true;
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
    function updateAnnouncement(Announcement $announcement_) 
    {
        try {
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(isset($this->id) && !is_null($this->id)) {
                $where_ = 'id = '.$this->id;
            }

            return parent::update($this->table, $announcement_, $where_);            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * 
     * @param boolean $all Set True to return all values of the table
     * @return boolean If True -> Success Query / False -> Fail Query
     * @throws InvalidArgumentException
     */
    public
    function selectAnnouncement($all_ = false) 
    {
        try {
            $where = null;
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(isset($this->id) && !is_null($this->id)) {
                $where = 'id = '.$this->id;
            }

            return parent::select($this->table, $where, $object = new Announcement(), $all_);
        } catch(InvalidArgumentException $e) {
            $e->getMessage(); exit;
        }
    }
    
    /**
     * Triggered 
     * @return Boolean If True -> Success Query / False -> Fail Query
     * @throws InvalidArgumentException
     */
    public
    function deleteAnnouncement() 
    {
        try {
            if(is_null($this->table)) {
                throw new InvalidArgumentException('Attribute "table" can\'t be NULL !');
            }
            if(isset($this->id) && !is_null($this->id)) {
                $where = 'id = '.$this->getId();
            }
            
            $pictureMapper = new PictureMapper($this);
            $pictures = $pictureMapper->selectPicture(true, 'id_announcement = '.$this->getId());
            
            if(isset($pictures) && !empty($pictures)) {
                foreach ($pictures as $key => $value) {
                    $idPicture = $value->getId();
                    $path = $value->getPath(); 
                    $title = $value->getTitle();
                    $ext = $value->getExtension();
                    
                    //Remove to the pictures folders
                    if(file_exists(UPLOAD_PATH.$path.$title.'.'.$ext)) {
                        unlink(UPLOAD_PATH.$path.$title.'.'.$ext);
                    }
                    //Remove to database
                    $pictureMapper = new PictureMapper();
                    $pictureMapper->setId($idPicture);
                    if($pictureMapper->deletePicture()) {
                        continue;
                    } else {
                        throw new Exception('Problem on the delete picture query !');
                    }
                }
            }
            
            return parent::delete($this->table, $where);   
            
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    public
    function getPictures(PictureMapper $pictureMapper_) {
        $picturesObjects = $pictureMapper_->selectPicture(true);
        return $picturesObjects;
    }
    
    public 
    function getTags() {
        $tag = new Tag();
        $where = 'id_announcement = '.$this->getFirstId();
        return parent::select('TO_ASSOCIATE', $where, $tag);
        
    }
    
    public
    function goAssociate(stdClass $object_) {
        try {
            if(isset($object_) && !emptyObject($object_)) {
                $announcementMapper = new AnnouncementMapper();
                $announcementMapper->setId($object_->id_announcement);
                $announcement = $announcementMapper->selectAnnouncement();
                $tagMapper = new TagMapper();
                $tagMapper->setId($object_->id_tag);
                $tag = $tagMapper->selectTag();

                if(!is_null($announcement->getId()) && !is_null($tag->getId())) {
                if(is_null($user->getId())) {
                     return parent::insert('TO_ASSOCIATE', $object_);
                } else {
                    throw new Exception('The user is already followed by this user !');
                }   
                    return parent::insert($this->table, $message_, $arrayFilter);
                } elseif(is_null($announcement->getId())) {
                    throw new Exception('Announcement is inexistant !');
                } elseif(is_null($tag->getId())) {
                    throw new Exception('Tag is inexistant !');
                } 
                
            } elseif(empty ($id_announcement_)) {
                throw new Exception('Id announcement is required !');
            } elseif(empty ($id_tag_)) {
                throw new Exception('Id tag is required !');
            }
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        } 
    }
}
