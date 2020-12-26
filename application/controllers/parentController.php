<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once( $DOC_ROOT . '/application/libraries/MemcacheLibrary.php' );
require_once $DOC_ROOT . "/system/libraries/AwsS3.php";

date_default_timezone_set("Asia/Kolkata");

class parentController extends CI_Controller {
    public function fetchForumItems(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        $this->load->library('Logging');
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_PARENT ){
            
            $this->load->model('parentmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = trim($sessionUserData['user_type']);
            $to_time  = ( isset($_POST["to_time"] ) ? trim($_POST["to_time"]) : "" );
            if( $to_time == "" ){
                $to_time = time();
            }
            
            $result = $this->parentmodel->getParentClassId( $school_id, $user_id );
            $class_id = trim($result['class_id']);
            $forum_feed = $this->parentmodel->getClassFeed( $school_id, $class_id, $user_id, $user_type, $to_time, 
                                    _FORUM_PAGE_FEED_SIZE, _FORUM_DEFAULT_COMMENT_SIZE, _FEED_LONG_PARAMS, "false" );
            echo json_encode( $forum_feed );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function addTextPost(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_PARENT
                  || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $this->load->model('parentmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            $text  = ( isset($_POST["text"] ) ? html_entity_decode(trim($_POST["text"])) : "" );
            $post_type = _FORUM_ITEM_TYPE_TEXT;
            $returnArr = $this->parentmodel->addClassForumPost( $school_id, $text, $post_type, $user_id, $user_type );
            $class_id = $returnArr[0];
            $time = time() + 10000;
            $forum_feed = $this->parentmodel->getClassFeed( $school_id, $class_id, $user_id, $user_type, $time, 
                                    _FORUM_PAGE_FEED_SIZE, _FORUM_DEFAULT_COMMENT_SIZE, _FEED_LONG_PARAMS, "false" );
            echo json_encode($forum_feed);
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function postComment(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_PARENT
                  || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $this->load->model('parentmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            $comment  = ( isset($_POST["comment"] ) ? html_entity_decode(trim($_POST["comment"])) : "" );
            $item_id  = ( isset($_POST["item_id"] ) ? trim($_POST["item_id"]) : "" );
            
            $added = $this->parentmodel->addComment( $school_id, $user_id, $user_type, $item_id, $comment );
            echo json_encode( $added );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function getFeedDetails(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_PARENT
                  || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $item_id  = ( isset($_POST["item_id"] ) ? trim($_POST["item_id"]) : "" );
            $this->load->model('parentmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            
            $feedDetails = $this->parentmodel->getFeedDetails( $school_id, $user_id, $item_id );
            echo json_encode( $feedDetails );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function fetchComments(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_PARENT
                  || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $item_id  = ( isset($_POST["item_id"] ) ? trim($_POST["item_id"]) : "" );
            $comment_id  = ( isset($_POST["comment_id"] ) ? trim($_POST["comment_id"]) : "" );
            $this->load->model('parentmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            
            $feedComments = $this->parentmodel->getFeedComments( $school_id, $user_id, $item_id, $comment_id, 
                                _FORUM_DEFAULT_COMMENT_DETAIL_SIZE, _FEED_LONG_PARAMS );
            echo json_encode( $feedComments );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function deletePost(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_PARENT
                  || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $item_id  = ( isset($_POST["item_id"] ) ? trim($_POST["item_id"]) : "" );
            $this->load->model('parentmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            
            $deleted = $this->parentmodel->deletePost( $school_id, $user_id, $item_id );
            $result = $this->parentmodel->getParentClassId( $school_id, $user_id );
            $class_id = trim($result['class_id']);
            $to_time = time() + 10000;
            $forum_feed = $this->parentmodel->getClassFeed( $school_id, $class_id, $user_id, $user_type, $to_time, 
                                    _FORUM_PAGE_FEED_SIZE, _FORUM_DEFAULT_COMMENT_SIZE, _FEED_LONG_PARAMS, "false" );
            echo json_encode( $forum_feed );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function deleteComment(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_PARENT
                  || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $item_id  = ( isset($_POST["item_id"] ) ? trim($_POST["item_id"]) : "" );
            $comment_id  = ( isset($_POST["comment_id"] ) ? trim($_POST["comment_id"]) : "" );
            $this->load->model('parentmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            
            $deleted = $this->parentmodel->deleteComment( $school_id, $user_id, $item_id, $comment_id );
            if( $deleted ){
                echo json_encode("true");
                return;
            }
            
            echo json_encode("false");
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function uploadFeedImage(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_PARENT
                  || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $isValid = $this->validateImage();
            $success = false;
            $pic_class_id = "";
            $class = "";
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            $this->load->model('parentmodel');
                
            if( $user_type == _USER_TYPE_PARENT ){
                $class = $this->parentmodel->getParentClass( $school_id, $user_id );
            }
            if( $user_type == _USER_TYPE_TEACHER || $user_type == _USER_TYPE_SCHOOL ){
                $pic_class_id = ( isset($_POST["pic_class_id"] ) ? trim($_POST["pic_class_id"]) : "" );
                $class = $this->parentmodel->getClassFromId( $school_id, $pic_class_id );
            }
                
            if( $isValid['success'] ){
                $timestamp = time();
                $filename = $timestamp . '_' . $sessionUserData['user_id'] . ".jpg";
                
                //$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
                //$file = $DOC_ROOT . _GENERAL_NOTIFICATION_IMAGE_FOLDER . '/' . $filename;
                if( !file_exists(_FORUM_IMAGE_S3_FOLDER . '/' . $class) ){
                    mkdir( _FORUM_IMAGE_S3_FOLDER . '/' . $class, 0777, true );
                }
                
                if( !file_exists(_FORUM_IMAGE_FOLDER . '/' . $class) ){
                    mkdir( _FORUM_IMAGE_FOLDER . '/' . $class, 0777, true );
                }
                $file = _FORUM_IMAGE_FOLDER . '/' . $class . '/' . $filename;
                $file_s3 = _FORUM_IMAGE_S3_FOLDER . '/' . $class . '/' . $filename;
                $image_size = $_FILES["uploadFeedPic"]["size"];
                //$compression_quality = $this->getCompressionLevel();
                $success = $this->compressAndSaveFile($_FILES['uploadFeedPic']['tmp_name'], $image_size, $file, $file_s3);
                        
                /*$try_count = 3;
                while( $try_count > 0 ){
                    $this->compress($_FILES['uploadFeedPic']['tmp_name'], $file, $compression_quality);
                    if( file_exists($file) ){
                        $success = true;
                        break;
                    }
                    $try_count--;
                }*/
            } 
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $displayData['headerData'] = $headerData;
            $displayData['user_type'] = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            if( $sessionUserData['user_type'] == _USER_TYPE_PARENT ){
                $feed_page = 'parent_home';
            } else if( $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
                $this->load->model('teachermodel');
                $classList = $this->teachermodel->getTeacherClassList($school_id, $user_id);
                $displayData['classList'] = $classList;
                $displayData['selectedClassId'] = $pic_class_id;
                $feed_page = 'teacher_class_forum';
            } else if( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ){
                $this->load->model('schoolmodel');
                $school_id = '0';
                $classList = $this->schoolmodel->getClassListPlain( $school_id );
                $displayData['classList'] = $classList;
                $displayData['selectedClass'] = $class;
                $displayData['selectedClassId'] = $pic_class_id;
                $feed_page = 'school_class_forum';
            }
            if( $success ){
                $caption_text = ( isset($_POST["uploadPicText"] ) ? trim($_POST["uploadPicText"]) : "" );
                $post_type = _FORUM_ITEM_TYPE_PICTURE;
                $pic_url = $class . '/' . $filename;
                $this->parentmodel->insertPicturePost( $school_id, $user_id, $user_type, $post_type, $pic_url, $caption_text, $pic_class_id );
            } else {
                $displayData['message']  = "Sorry!! Unable to upload the picture! " . $isValid['reason'];
            }
            $this->load->view( $feed_page, $displayData );
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function validateImage(){
        $this->load->library('Logging');
        $allowed_image_types = array( "image/gif", "image/jpeg", "image/png", "image/pjpeg" );
        $returnArray = array();
        if( !isset( $_FILES["uploadFeedPic"] ) ){
            $error = "No file uploaded";
            $this->logging->logError($error, __FILE__, __FUNCTION__, __LINE__, "");
            $returnArray['success'] = false;
            $returnArray['reason'] = $error;
            return $returnArray;
        }
        if ( $_FILES["uploadFeedPic"]["error"] > 0) {
            $error = $_FILES["uploadFeedPic"]["error"];
            $this->logging->logError($error, __FILE__, __FUNCTION__, __LINE__, "");
            $returnArray['success'] = false;
            $returnArray['reason'] = $error;
            return $returnArray;
    	}
        if( isset($_FILES['uploadFeedPic'] ) && isset( $_FILES['uploadFeedPic']['tmp_name'] ) &&
                trim( $_FILES['uploadFeedPic']['tmp_name'] ) != "" && isset( $_FILES["uploadFeedPic"]["type"] ) ){
            
            if( !exif_imagetype($_FILES['uploadFeedPic']['tmp_name']) > 0 
                    || !in_array( $_FILES["uploadFeedPic"]["type"], $allowed_image_types ) ){
                
                $error_msg = "Invalid image type : " . $_FILES["uploadFeedPic"]["type"];
                $this->logging->logError($error_msg, __FILE__, __FUNCTION__, __LINE__, "");
                $returnArray['success'] = false;
                $returnArray['reason'] = $error_msg;
                return $returnArray;
            }
            
            if( isset($_FILES["uploadFeedPic"]["size"]) && $_FILES["uploadFeedPic"]["size"] > _FORUM_IMAGE_MAX_SIZE ){
                $error_msg = "Invalid image size : " . $_FILES["uploadFeedPic"]["size"];
                $this->logging->logError($error_msg, __FILE__, __FUNCTION__, __LINE__, "");
                $returnArray['success'] = false;
                $returnArray['reason'] = $error_msg;
                return $returnArray;
            }
            
            $returnArray['success'] = true;
            $returnArray['reason'] = "";
            return $returnArray;
        } else {
            $error_msg = "Invalid image size : " . $_FILES["uploadFeedPic"]["size"];
            $this->logging->logError($error_msg, __FILE__, __FUNCTION__, __LINE__, "");
            $returnArray['success'] = false;
            $returnArray['reason'] = $error_msg;
            return $returnArray;
        }
                
    }
    
    public function getCompressionLevel($image_size){
        //$image_size = $_FILES["uploadFeedPic"]["size"];
        if( $image_size > _FORUM_IMAGE_COMPRESSION_SIZE_CUTOFF_LEVEL_9 ){
            return _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_9;
        } else if( $image_size > _FORUM_IMAGE_COMPRESSION_SIZE_CUTOFF_LEVEL_8 ){
            return _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_8;
        } else if( $image_size > _FORUM_IMAGE_COMPRESSION_SIZE_CUTOFF_LEVEL_7 ){
            return _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_7;
        } else if( $image_size > _FORUM_IMAGE_COMPRESSION_SIZE_CUTOFF_LEVEL_6 ){
            return _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_6;
        } else if( $image_size > _FORUM_IMAGE_COMPRESSION_SIZE_CUTOFF_LEVEL_5 ){
            return _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_5;
        } else if( $image_size > _FORUM_IMAGE_COMPRESSION_SIZE_CUTOFF_LEVEL_4 ){
            return _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_4;
        } else if( $image_size > _FORUM_IMAGE_COMPRESSION_SIZE_CUTOFF_LEVEL_3 ){
            return _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_3;
        } else if( $image_size > _FORUM_IMAGE_COMPRESSION_SIZE_CUTOFF_LEVEL_2 ){
            return _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_2;
        } else if( $image_size > _FORUM_IMAGE_COMPRESSION_SIZE_CUTOFF_LEVEL_1 ){
            return _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_1;
        } else {
            return _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_0;
        }
    }
    
    public function move_to_s3($img_file, $file_s3_path){
        $awsS3Client = new AwsS3();
        $moved = $awsS3Client->setKey($file_s3_path, $img_file);
        return $moved;
    }
    
    public function saveFile($source, $file, $file_s3){
        $file_content = fopen($source, "r");
        $try_count = 3;
        $success = false;
        if(_USE_AWS_S3){
            while( $try_count > 0 ){
                $moved = $this->move_to_s3($file_content, $file_s3);
                if( $moved ){
                    $success = true;
                    break;
                }
                $try_count--;
            }
        } else {
            while( $try_count > 0 ){
                move_uploaded_file($source, $file);
                if( file_exists($file) ){
                    $success = true;
                    break;
                }
                $try_count--;
            }
        }
        fclose($file_content);
        return $success;
    }
    
    public function compress($source, $file_server, $quality, $file_s3) {
        $info = getimagesize($source);
        if( $quality == _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_0 ){
            $saved = $this->saveFile($source, $file_server, $file_s3);
            return $saved;
        }
        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
        } else if ($info['mime'] == 'image/gif') { 
            $image = imagecreatefromgif($source);
        } else if ($info['mime'] == 'image/png'){
            $image = imagecreatefrompng($source);
        }

        $imageWidth = imagesx( $image );
        $imageHeight = imagesy( $image );
        
        $scaleFactor = $this->getScaleFactor( $imageWidth * $imageHeight * 3 );
        //$scaledHeight = intval($imageHeight/$scaleFactor);
        $scaledWidth = intval($imageWidth/$scaleFactor);
        $scaledImage = imagescale( $image, $scaledWidth);
        
        $imageWidth = imagesx( $scaledImage );
        $imageHeight = imagesy( $scaledImage );
        
        //imagejpeg($image, $file_server, $quality);
        imagejpeg($scaledImage, $file_server, _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_0);
        $new_size = filesize($file_server);
        $quality = $this->getCompressionLevel($new_size);
        imagejpeg($scaledImage, $file_server, $quality);
        if(_USE_AWS_S3){
            $img_file = fopen($file_server, "r");
            $awsS3Client = new AwsS3();
            $awsS3Client->setKey($file_s3, $img_file);
            fclose($img_file);
        } 

	return $file_server;
    }
    
    public function getScaleFactor( $bitmapByteCount ){
        $scaleFactor = 1;
        if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_14 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_14;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_13 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_13;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_12 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_12;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_11 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_11;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_10 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_10;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_9 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_9;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_8 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_8;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_7 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_7;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_6 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_6;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_5 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_5;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_4 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_4;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_3 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_3;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_2 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_2;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_1 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_1;
        } else if( $bitmapByteCount > _BITMAP_IMAGE_COMP_SIZE_0 ){
            $scaleFactor = _BITMAP_SCALE__FACTOR_0;
        }

        return $scaleFactor;
    }
    
    public function compressAndSaveFile($file_content, $image_size, $file, $file_s3){
        $compression_quality = $this->getCompressionLevel( $image_size );
        $try_count = 3;
        $success = false;
        while( $try_count > 0 ){
            $saved = $this->compress($file_content, $file, $compression_quality, $file_s3);
            if( $saved === TRUE || file_exists($file) ){
                $success = true;
                break;
            }
            $try_count--;
        }
        
        if(_USE_AWS_S3 && $saved !== TRUE){
            unlink($file);
        }
        
        return $success;
    }
    
    /*
    public function compress($source, $destination, $quality) {
	$info = getimagesize($source);

	if ($info['mime'] == 'image/jpeg') 
		$image = imagecreatefromjpeg($source);

	elseif ($info['mime'] == 'image/gif') 
		$image = imagecreatefromgif($source);

	elseif ($info['mime'] == 'image/png') 
		$image = imagecreatefrompng($source);

        
	imagejpeg($image, $destination, $quality);

	return $destination;
    }*/
    
    public function parent_home_work(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_PARENT ){
            
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $this->load->model('teachermodel');
            $this->load->model('parentmodel');
            $school_id = '0';
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $subject_id  = ( isset($_POST["subject_id"] ) ? trim($_POST["subject_id"]) : "" );
            $last_hw_id = ( isset($_POST["last_hw_id"] ) ? trim($_POST["last_hw_id"]) : -1 );
            $parent_user_id = trim($sessionUserData['user_id']);
            
            $last_hw_id_fetched = -1;
            $subjectList = $this->parentmodel->getParentSubjectList($school_id, $parent_user_id);
            $homeworkList = array();
            if( $class_id != "" && $subject_id == "" ){
                $homeworkList = $this->teachermodel->getHomeWorkList( $school_id, $teacher_user_id, $class_id, 
                                    $subject_id, $last_hw_id, _HOME_WORK_FEED_SIZE, $last_hw_id_fetched, _GENERIC_LONG_PARAMS, "false" );
            }
            
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['subjectList'] = $subjectList;
            $displayData['postedDateArray'] = $this->getPostedDateArray();
            $displayData['completionDateArray'] = $this->getCompletionDateArray();
            $displayData['homeworkList'] = $homeworkList;
            $this->load->view('parent_home_work', $displayData);
            
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    private function getPostedDateArray(){
        $postedDateArray = array();
        $cur_date_obj = new DateTime( "Asia/Kolkata" );
        for( $i=1; $i <= 10; $i++ ){
            if( $i != 1 ){
                $cur_date_obj->sub( new DateInterval( "P1D" ) );
            }
            $date_str = $cur_date_obj->format( "D j, M" );
            //$date = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
            $date = $cur_date_obj->format( 'Y-m-d' );
            $date_desc = $date_str;
            if( $i == 1 ){
                $date_desc = "Today ( " . $date_str . " )";
            }
            if( $i == 2 ){
                $date_desc = "Yesterday ( " . $date_str . " )";
            }
            $postedDateArray[$i] = array( "date_desc" => $date_desc, "date" => $date );
        }
        
        ksort($postedDateArray);
        return $postedDateArray;
    }
    
    private function getCompletionDateArray(){
        $completionDateArray = array();
        $cur_date_obj = new DateTime( "Asia/Kolkata" );
        for( $i=1; $i <= 10; $i++ ){
            if( $i != 1 ){
                $cur_date_obj->add( new DateInterval( "P1D" ) );
            }
            $date_str = $cur_date_obj->format( "D j, M" );
            //$date = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
            $date = $cur_date_obj->format( 'Y-m-d' );
            $date_desc = $date_str;
            if( $i == 1 ){
                $date_desc = "Today ( " . $date_str . " )";
            }
            if( $i == 2 ){
                $date_desc = "Tomorrow ( " . $date_str . " )";
            }
            $completionDateArray[$i] = array( "date_desc" => $date_desc, "date" => $date );
        }
        
        $cur_date_obj1 = new DateTime( "Asia/Kolkata" );
        $cur_date_obj1->sub( new DateInterval( "P1D" ) );
        $completionDateArray['-1'] = array( "date_desc" => "Yesterday ( " . $cur_date_obj1->format( "D j, M" ) . " ) ", 
                                            "date" => $cur_date_obj1->format( 'Y-m-d' ) );
        
        $cur_date_obj1->sub( new DateInterval( "P1D" ) );
        $completionDateArray['-2'] = array( "date_desc" => $cur_date_obj1->format( "D j, M" ), 
                                            "date" => $cur_date_obj1->format( 'Y-m-d' ) );
        
        ksort($completionDateArray);
        return $completionDateArray;
    }
    
    public function fetchSubjectHW(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_PARENT ){
            $this->load->model('parentmodel');
            $school_id = '0';
            $parent_user_id = trim($sessionUserData['user_id']);
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $subject_id  = ( isset($_POST["subject_id"] ) ? trim($_POST["subject_id"]) : "" );
            $last_hw_id = ( isset($_POST["last_hw_id"] ) ? trim($_POST["last_hw_id"]) : -1 );
            
            $last_hw_id_fetched = -1;
            if( $class_id != '' && $subject_id != '' ){
                $homeWork = $this->parentmodel->getSubjectHomeWork( $school_id, $class_id, $subject_id, 
                                                       $parent_user_id, $last_hw_id, _HOME_WORK_FEED_SIZE, $last_hw_id_fetched );
            
                $returnArray = array('hw_details' => $homeWork, 'last_hw_id_fetched' => $last_hw_id_fetched );
                echo json_encode( $returnArray );
            } else {
                echo json_encode("false");
            }
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function fetchHWByTimeParent(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_PARENT ){
            
            $this->load->model('parentmodel');
            $school_id = '0';
            $parent_user_id = $sessionUserData['user_id'];
            //postedDate=' + encodeURIComponent(postedDate) + '&completionDate=' + encodeURIComponent(completionDate);
            $postedDate = ( isset($_POST["postedDate"] ) ? html_entity_decode( trim($_POST["postedDate"]) ) : "" );
            $completionDate  = ( isset($_POST["completionDate"] ) ? html_entity_decode(trim($_POST["completionDate"])) : "" );
            
            $actualPostedDate = "";
            $actualcompletionDate = "";
            
            if( $postedDate != "" ){
                $postedDateArr = $this->getPostedDateArray();
                $actualPostedDate = $postedDateArr[$postedDate]["date"];
            }
            if( $completionDate != "" ){
                $completionDateArr = $this->getCompletionDateArray();
                $actualcompletionDate = $completionDateArr[$completionDate]["date"];
            }
            $hwByTimeFeed = $this->parentmodel->fetchHWByTime( $school_id, $parent_user_id, $actualPostedDate, $actualcompletionDate );
            
            error_log( "hw time feed : " . print_r( $hwByTimeFeed, true ) );
            echo json_encode( $hwByTimeFeed );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function parent_timetable(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_PARENT ){
            
            $displayData = array();
            $message = "";
            $headerData = array();
            $school_id = '0';
            $parent_user_id = trim( $sessionUserData['user_id'] );
            
            $this->load->model('parentmodel');
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $parentTimeTable = $this->parentmodel->getParentClassTimeTable( $school_id, $parent_user_id );
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['parentTimeTable']  = $parentTimeTable;
            $this->load->view( "parent_timetable", $displayData );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function parent_score_card(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_PARENT ){
            
            
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function parent_students(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_PARENT ){
            $displayData = array();
            $message = "";
            $headerData = array();
            $school_id = '0';
            $parent_user_id = trim( $sessionUserData['user_id'] );
            
            $this->load->model('parentmodel');
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $students = $this->parentmodel->getParentStudents( $school_id, $parent_user_id );
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['students']  = $students;
            $this->load->view( "parent_students", $displayData );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
        
}

?>