<?php
class AnnouncementMapper extends Mapper {
    
    protected $table = 'ANNOUNCEMENT';

    function __construct() {
        parent::__construct();
    }
    
    /**
     * Allow to create an announcement / if sereval pictures are upload, they're moved on 
     * the Upload/announcement/original/ folder.
     * @param Announcement $announcement_
     * @throws InvalidArgumentException
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
                        
                        if(move_uploaded_file(
                            $value->getTmpName(), 
                            UPLOAD_PATH .'/announcement/original/'.$value->getTitle().'.'.$pictureExt
                        )) {
                            
                            $pictureMapper = new PictureMapper();
                            $pictureMapper->insertPicture($value, array('tmp_name', 'size', 'type'), false);          
                            
                        } else {
                            throw new Exception('A problem occurred during the picture upload');
                        }
                    }
                }   
                
                return true;
            }
        } catch(InvalidArgumentException $e) {
            print $e->getMessage(); exit;
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    } 
    
    /**
     * Allow to modify an announcement
     * @param Announcement $announcement_
     * @param string $where Query condition 
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
     * Allow to get an announcement or several announcements if defined true
     * @param boolean $all Set TRUE to return all table values
     * @return boolean True the query is executed | False
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
     * Allows to delete an announcement and images 
     * Triggered 
     * @return boolean True the query is executed | False
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
    
    /**
     * Allows to get all pictures
     * @param PictureMapper $pictureMapper_
     * @return array Returns an array of objects
     */
    public
    function getPictures(PictureMapper $pictureMapper_) {
        
        $picturesObjects = $pictureMapper_->selectPicture(true);
        
        return $picturesObjects;
    }
    
    /**
     * Allows to get all Tag
     * @return boolean True the query is executed | False
     * @throws Exception
     */
    public 
    function getTags() {
        try {
            
            if(is_null($this->getFirstId())) {
                throw new Exception('ID Announcement musn\'t be null !');
            }
            
            $tag = new Tag();
            $where = 'id_announcement = '.$this->getFirstId();
            
            return parent::select('TO_ASSOCIATE', $where, $tag);
            
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
    /**
     * Allows to apply an ad
     * @param stdClass $object_
     * @throws Exception
     */
    public
    function goApply(stdClass $object_) {
        try {
            
            if(!parent::exist('USER', 'User', 'userMapper', 'id = '.$object_->id_user)) {
                throw new Exception('User doesn\'t exist !');
            }
            
            if(!parent::exist('ANNOUNCEMENT', 'Announcement', 'announcementMapper', 'id = '.$this->getFirstId())) {
                throw new Exception('Announcement doesn\'t exist !');
            }
            
            $object_->id_announcement = $this->getFirstId();
            return parent::insert('TO_APPLY', $object_);
            
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
//    public
//    function goAssociate(stdClass $object_) {
//        try {
//            
//            if(isset($object_) && !emptyObjectMethod($object_)) {
//                
//                $announcementMapper = new AnnouncementMapper();
//                $announcementMapper->setId($object_->id_announcement);
//                $announcement = $announcementMapper->selectAnnouncement();
//                $tagMapper = new TagMapper();
//                $tagMapper->setId($object_->id_tag);
//                $tag = $tagMapper->selectTag();
//
//                if(!is_null($announcement->getId()) && !is_null($tag->getId())) {
//                     parent::insert('TO_ASSOCIATE', $object_);
//                } elseif(is_null($announcement->getId())) {
//                    throw new Exception('Announcement is inexistant !');
//                } elseif(is_null($tag->getId())) {
//                    throw new Exception('Tag is inexistant !');
//                } 
//                
//            } elseif(empty ($id_announcement_)) {
//                throw new Exception('Id announcement is required !');
//            } elseif(empty ($id_tag_)) {
//                throw new Exception('Id tag is required !');
//            }
//        } catch(Exception $e) {
//            print $e->getMessage(); exit;
//        } 
//    }
}
