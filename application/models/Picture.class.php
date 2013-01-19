<?php

class Picture {
    
     private $_id;
     private $_file_title;
     private $_title;
     private $_alternative;
     private $_path;
     private $_extension;
     private $_tmp_name;
     private $_size;
     private $_type;
     private $_id_announcement;
     
    /**
     * 
     * Méthodes GET
     */
    
	public 
    function getId()
	{
		return $this->_id;
	}

	public 
    function getFileTitle()
	{
		return $this->_file_title;
	}
    
	public 
    function getTitle()
	{
		return $this->_title;
	}

	public 
    function getAlternative()
	{
		return $this->_alternative;
	}

	public 
    function getPath()
	{
		return $this->_path;
	}

	public 
    function getTmpName()
	{
		return $this->_tmp_name;
	}

    public 
    function getSize()
	{
		return $this->_size;
	}
    
	public 
    function getType()
	{
		return $this->_type;
	}
    
    public
    function getIdAnnouncement() {
        return $this->_id_announcement;
    }
    
    public
    function getExtension() {
        return $this->_extension;
    }
/**
 * Méthodes SET
 */

	public 
    function setId($_id) {
		$this->_id = $_id;
	}

	public 
    function setFileTitle($_file_title)
	{
		$this->_file_title = $_file_title;
	}
    
	public 
    function setTitle($_title)
	{
		$this->_title = $_title;
	}

	public 
    function setPath($_path)
	{
		$this->_path = $_path;
	}

	public 
    function setAlternative($_alternative)
	{
		$this->_alternative = $_alternative;
	}
   
	public 
    function setTmpName($tmp_name_)
	{
		$this->_tmp_name = $tmp_name_;
	}

    public 
    function setSize($size_)
	{
		$this->_size = $size_;
	}
    
	public 
    function setType($type_)
	{
		$this->_type = $type_;
	}
    
    public
    function setIdAnnouncement($idAnnouncement_) {
        $this->_id_announcement = $idAnnouncement_;
    }
    
    public
    function setExtension($extension_) {
        $this->_extension = $extension_;
    }
    
    /**
     * TODO 
     * @param type $file
     * @param type $user
     */
    public
    function resizeAvatar($file, $user) {
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
                            imagepng($newAvatar , UPLOAD_FILES.'/avatar/'.strtolower($user->getLogin()).'.'.$extension, 9);
                        endif;
                    endif;
                endif;
            endif;
        endif;
    }
}
