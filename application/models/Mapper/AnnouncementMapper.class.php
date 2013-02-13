<?php
class AnnouncementMapper extends Mapper {
    
    protected $table = 'ANNOUNCEMENT';

    function __construct() {
        parent::__construct();
    }
    
    /**
     * Allow to create an announcement / if sereval pictures are upload, they're moved on 
     * the Upload/announcement/original/ folder.
     * @param Announcement $announcement
     * @return boolean
     */
    public 
    function insertAnnouncement(Announcement $announcement) 
    {
        $pictures = array();
        if(parent::insert($this->getTable(), $announcement, array(), true)) {

            $idAnnouncement = parent::getlastInsertId(); 
            $announcement->setId($idAnnouncement);
            $files = $this->getFiles();

            if(isset($files) && is_array($files) && !empty($files)) {
                foreach($files as $file) {
                    $picture = new Picture();
                    $picture = initObject($file, $picture, true);
                    $pictures[] = $picture;
                }
            }

            $announcement->setPictures($pictures);
            if(isset($pictures) && !empty($pictures)) {

                foreach ($pictures as $key => $value) {

                    $pictureExt = substr(strrchr($value->getType(), "/"), 1); 
                    $value->setFileTitle($key);
                    $value->setIdAnnouncement($idAnnouncement);
                    $value->setPath('/announcement/original/');
                    $value->setTitle(uniqid());
                    $value->setExtension($pictureExt);

                    $pictureMapper = new PictureMapper();
                    $pictureMapper->insertPicture($value, array(), true);          

                }
            }   
            
            Rest::sendResponse(201, $announcement->getId());
            return true;
        }
    } 
    
    /**
     * 
     * @param Announcement $announcement
     * @param string $conditions
     * @return bool
     */
    public 
    function updateAnnouncement(Announcement $announcement, $conditions = null) 
    {
        if(method_exists($this, 'getId') && !is_null($this->getId()) && is_null($conditions)) {
            $conditions = ' WHERE id = '.$this->getId();
        }

        return parent::update($this->getTable(), $announcement, $conditions);  
    } 
    
    /**
     * Allows to delete an announcement and images 
     * Triggered 
     * @return boolean True the query is executed | False
     * @throws InvalidArgumentException
     */
    public
    function deleteAnnouncement($conditions = null) 
    {
        if(method_exists($this, 'getId') && !is_null($this->getId()) && is_null($conditions)) {
            $conditions = ' WHERE id = '.$this->getId();
        }

        $pictureMapper = new PictureMapper($this);
        $pictures = $this->select('PICTURE', true, ' WHERE id_announcement = '.$this->getId());

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
                    Rest::sendResponse(409, 'Problem on the delete picture query !');
                }
            }
        } else {
            Rest::sendResponse(404, 'Announcement doesn\'t exist !');
        }
        
        return parent::delete($this->getTable(), $conditions);   
    } 
    
    /**
     * Allows to get all pictures
     * @param PictureMapper $pictureMapper_
     * @return array Returns an array of objects
     */
    public
    function getPictures(PictureMapper $pictureMapper) {
        
        $picturesObjects = $pictureMapper->selectPicture(true);
        
        return $picturesObjects;
    }
    
    /**
     * Allows to get all Tag
     * @return boolean True the query is executed | False
     */
    public 
    function getAnnouncementTags($idAnnouncement, $conditions = null) 
    {
        $conditions = ' WHERE id_announcement = '.$idAnnouncement;

        return parent::select('TO_ASSOCIATE', true, $conditions);
    }
    
    /**
     * 
     * @param type $user
     * @param type $announcement
     * @return boolean
     */
    public
    function getApply($user, $announcement) 
    {
        $conditions = ' WHERE id IN (SELECT id_announcement '.
                        'FROM TO_APPLY WHERE id_announcement = '.$announcement->getId().'
                                             AND id_user = '.$user->getId().')';
        
        return $this->select($this->getTable(), false, $conditions);
    }
    
    /**
     * 
     * @param stdClass $objectApply
     * @return boolean
     */
    public
    function goApply(stdClass $objectApply) 
    {
        $requiered = array('id_user');
        if(isRequired($requiered, $objectApply)) {

            if(!parent::exist('USER', 'User', 'userMapper', 
                    ' WHERE id = '.$objectApply->id_user)) {
                Rest::sendResponse(404, 'User doesn\'t exist !');
            }
            if(!parent::exist('ANNOUNCEMENT', 'Announcement', 'announcementMapper', 
                    ' WHERE id = '.$this->getFirstId())) {
                Rest::sendResponse(404, 'Announcement doesn\'t exist !');
            }

            $objectApply->id_announcement = $this->getFirstId();

            if(!parent::exist('TO_APPLY', 'stdClass', 'announcementMapper', 
                    ' WHERE id_user = '.$objectApply->id_user.
                    ' AND id_announcement = '.$objectApply->id_announcement)) {
                Rest::sendResponse(409, 'Apply is already existing !');
            }         

            $user = $this->getApply($objectApply);

            if(isset($user) && is_null($user->getId())) {
                 return parent::insert('TO_APPLY', $objectApply);
            } else {
                Rest::sendResponse(409, 'User have already apply for this announcement !');
            }  
        }
    }
    
    public
    function goAssociate(stdClass $objectAssociate) 
    {
        $requiered = array('id_tag');
        if(isRequired($requiered, $objectAssociate)) {

            if(!parent::exist('TAG', 'Tag', 'tagMapper', 
                    ' WHERE id = '.$objectAssociate->id_tag)) {
                Rest::sendResponse(404, 'Tag doesn\'t exist !');
            }
            if(!parent::exist('ANNOUNCEMENT', 'Announcement', 'announcementMapper', 
                    ' WHERE id = '.$this->getFirstId())) {
                Rest::sendResponse(404, 'Announcement doesn\'t exist !');
            }

            $objectAssociate->id_announcement = $this->getFirstId();

            if(!parent::exist('TO_ASSOCIATE', 'stdClass', 'announcementMapper', 
                    ' WHERE id_tag = '.$objectAssociate->id_tag.
                    ' AND id_announcement = '.$objectAssociate->id_announcement)) {
                return parent::insert('TO_ASSOCIATE', $objectAssociate);
            } else {
                Rest::sendResponse(409, 'Announcement is already associate with this tag !');
            }         
        }
    }
    
    public
    function goEvaluate(stdClass $objectEvaluate) 
    {
        $requiered = array('id_user', 'mark');
        if(isRequired($requiered, $objectEvaluate)) {

            if(!parent::exist('USER', 'User', 'userMapper', 
                    ' WHERE id = '.$objectEvaluate->id_user)) {
                Rest::sendResponse(404, 'Tag doesn\'t exist !');
            }
            if(!parent::exist('ANNOUNCEMENT', 'Announcement', 'announcementMapper', 
                    ' WHERE id = '.$this->getFirstId())) {
                Rest::sendResponse(404, 'Announcement doesn\'t exist !');
            }

            $objectEvaluate->id_announcement = $this->getFirstId();

            if(!parent::exist('TO_EVALUATE', 'stdClass', 'announcementMapper', 
                    ' WHERE id_user = '.$objectEvaluate->id_user.
                    ' AND id_announcement = '.$objectEvaluate->id_announcement)) {
                return parent::insert('TO_EVALUATE', $objectEvaluate);
            } else {
                Rest::sendResponse(409, 
                        'An mark already exist for : 
                            announcement -> id = '.$objectEvaluate->id_announcement.'
                            user -> id = '.$objectEvaluate->id_user.' !');
            }         
        }
    }

    public
    function removeApply($id_announcement, $id_user) 
    {
        if(!parent::exist('ANNOUNCEMENT', 'Announcement', 'announcementMapper', 
                ' WHERE id = '.$id_announcement)) {
            Rest::sendResponse(404, 'Announcement doesn\'t exist !');
        }
        if(!parent::exist('USER', 'User', 'userMapper', ' WHERE id = '.$id_user)) {
            Rest::sendResponse(404, 'User doesn\'t exist !');
        }        

        $apply = $this->getApply($id_announcement, $id_user);
        if(isset($apply) && !empty($apply)) {

            $conditions = ' WHERE id_announcement = '.$id_announcement.' AND '.
                                 'id_user = '.$id_user;
            
            if(!parent::delete('TO_FOLLOW', $conditions)) {
                return false;
            }
            
        } else {
            Rest::sendResponse(404, 'Ressource does not exist !');
        }   
        
        return true;
    }
       
}

