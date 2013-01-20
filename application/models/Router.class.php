<?php
class Router {
   
    public
    function getControllerByModel($modelName) 
    {
        try {

            if(is_null($modelName)) throw new Exception('Model name doesn\'t be null !');
            $folderAssociation = 'associations/';

            switch ($modelName) {
             case 'Users':
             case 'Announcements' :
             case 'Tags' :
             case 'Messages' :
             case 'Pictures' :
             case 'Comments' :
             case 'Incomings' :
                    return 'plurally';
                 break;
             case 'User' :
             case 'Announcement'  : 
             case 'Tag'  :
             case 'Message'  :
             case 'Picture'  :
             case 'Comment'  :
             case 'Incoming' :
                    return 'singular';
                 break;
             default:
                 return $folderAssociation.$modelName;
                 break;
            }
        } catch (Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
    public
    function getMapper($modelName) 
    {
        try 
        {
            if(is_null($modelName)) throw new Exception('Model name doesn\'t be null !');

            switch ($modelName) {
                case 'Users':
                case 'User' :
                case 'User_Followers' :
                case 'User_Follower' :
                       return 'UserMapper';
                    break;
                case 'Announcements' :
                case 'Announcement'  : 
                case 'Announcement_Tags' :
                case 'Announcement_Apply' :
                       return 'AnnouncementMapper';
                    break;
                case 'Tags' :
                case 'Tag'  :
                       return 'TagMapper';
                    break;
                case 'Messages' :
                case 'Message'  :
                case 'User_Messages' :  
                       return 'MessageMapper';  
                 break;
                case 'Pictures' :
                case 'Picture'  :
                       return 'PictureMapper';
                    break;
                case 'Comments' :
                case 'Comment'  :
                case 'User_Comments' :
                       return 'CommentMapper';
                    break;       
                case 'Incomings' :
                case 'Incoming'  :
                       return 'IncomingMapper';
                    break;    
                default:
                    break;
            }
        } catch (Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
    public
    function getNameByMapper($mapper) 
    {
        try 
        {
            return  strstr($mapper, 'Mapper', true);

        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }
    }
    
    /**
     * 
     * @param string $url_
     * @return string
     * Parse the URL to return the model to use.
     */
    public
    function constructRoute($url) 
    {
        $model = '';

        $firstModel = $url->getModelFirstPart();  
        $secondModel = $url->getModelSecondPart();
        $firstId = $url->getIdFirstPart();
        $secondId = $url->getIdSecondPart();

        if(!is_null($firstModel)) {

            if(!is_null($firstId)) {
                $model .= ucfirst(substr_replace($firstModel , '', -1));
            } else {
                $model .= ucfirst($firstModel); 
            }
        }

        if(!is_null($secondModel)) {

            if(!is_null($secondId)) {
                if(strrchr($secondModel, 's')) {
                    $model .= '_'.ucfirst(substr_replace($secondModel , '', -1));
                } else { 
                    $model .= '_'.ucfirst($secondModel);
                }

            } else {
                $model .= '_'.ucfirst($secondModel); 
            }
        }

        return $model;
    }

    /**
     * 
     * @param strign $model
     * @return boolean
     * Check if the model exist
     */
    function existModel($model) 
    {
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
    function existController($model) 
    {

        if(is_readable(APPLICATION_PATH . '/controllers/' . $model.'.controller.php')) {
            return true;
        }
        
        return false;
    }
    /**
     * 
     * @param strign $model
     * @return boolean
     * Check if the model exist
     */
    function existMapper($name) 
    {
        try 
        {
            if(is_null($name)) throw new Exception('Mapper name doesn\'t be null !');
            if(is_readable(APPLICATION_PATH . '/models/Mapper/' . $name.'.class.php')) {
                return true;
            }
            return false;
        } catch(Exception $e) {
            print $e->getMessage(); exit;
        }

    }    
}