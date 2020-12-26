<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once( $DOC_ROOT . '/application/libraries/MemcacheLibrary.php' );
require_once $DOC_ROOT . "/system/libraries/AwsSNS.php";
//require_once $DOC_ROOT . "/vendor/autoload.php";
require_once $DOC_ROOT . "/application/libraries/getallheaders.php";

date_default_timezone_set("Asia/Kolkata");

/**
 * Description of generalController
 *
 * @author vinayakahegde
 */
class generalController extends CI_Controller {
    public function index(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $displayData = array();
        $headerData = array();
        $headerData['logged_in'] = false;
        $displayData['headerData'] = $headerData;
        $displayData['homeData'] = array();
        $this->load->view('home', $displayData);
    }
    
    private function generalNotifications(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('basicmodel');
        $notifications = $this->basicmodel->getGeneralNotifications( $school_id );
        
        return $notifications;       
    }
    
    public function generalNotificationsREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        if( $requestParams ){
            $school_id = "0";
            $parameters = $requestParams['data'];
            
            if( array_key_exists( 'school_id', $parameters) && is_string( $parameters['school_id'] ) ){
                $school_id = trim($parameters['school_id']);
            }
            
            $this->load->model('generalmodel');
            $notifications = $this->generalmodel->getGeneralNotifications( $school_id );
            $notificationsJson = json_encode( $notifications );
            $this->restutilities->sendResponse( 200, 
                            '{"success": "true", "notifications" : ' . $notificationsJson . ' }' );
        }
    }
    
    public function images( $image_num, $image_name, $image_name_1 = "" ){
        $this->load->library('session');
        /*$sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }*/

        $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
        ob_clean();
        if( _USE_AWS_S3 && ( $image_num == _IMAGE_SCHOOL_PROFILE_PICTURE_NUM || 
                   $image_num == _IMAGE_SCHOOL_CLASS_FEED_NUM ) ){
            
            if( $image_num == _IMAGE_SCHOOL_PROFILE_PICTURE_NUM ){
                $image_url = "https://" . _AWS_S3_BUCKET_NAME . _AWS_S3_BASE_SUB_URL . _PROFILE_PICTURE_S3_FOLDER . "/$image_name";
                header('Location:' . $image_url);
                return;
            }
            
            if( $image_num == _IMAGE_SCHOOL_CLASS_FEED_NUM ){
                $image_url = "https://" . _AWS_S3_BUCKET_NAME . _AWS_S3_BASE_SUB_URL . _FORUM_IMAGE_S3_FOLDER . "/$image_name/$image_name_1";
                header('Location:' . $image_url);
                return;
            }
        }
        
        switch( $image_num ){
            case _IMAGE_SCHOOL_LOGO_URL_NUM : 
                $imgpath = $DOC_ROOT . _IMAGE_SCHOOL_LOGO_FILE_PATH . "/$image_name";
                break;
            
            case _IMAGE_SCHOOL_FAVICON_URL_NUM :
                $imgpath = $DOC_ROOT . _IMAGE_SCHOOL_FAVICON_FILE_PATH . "/$image_name";
                break;
            
            case _IMAGE_SCHOOL_BOARD_MEMBER_NUM :
                $imgpath = $DOC_ROOT . _IMAGE_SCHOOL_BOARD_MEMBER_PATH . "/$image_name";
                break;
            
            case _IMAGE_SCHOOL_NOTIFICATION_NUM :
                $imgpath = $DOC_ROOT . _IMAGE_SCHOOL_NOTIFICATION_PATH . "/$image_name";
                break;
            
            case _IMAGE_SCHOOL_PRINCIPAL_NUM :
                $imgpath = $DOC_ROOT . _IMAGE_SCHOOL_PRINCIPAL_PATH . "/$image_name";
                break;
            
            case _IMAGE_SCHOOL_FACULTY_GENERAL_NUM :
                $imgpath = $DOC_ROOT . _IMAGE_SCHOOL_FACULTY_GENERAL_PATH . "/$image_name";
                break;
            
            case _IMAGE_SCHOOL_FACILITIES_NUM :
                $imgpath = $DOC_ROOT . _IMAGE_SCHOOL_FACILITIES_PATH . "/$image_name";
                break;
            
            case _IMAGE_SCHOOL_CLASS_FEED_NUM :
                $imgpath = _FORUM_IMAGE_FOLDER . "/$image_name/$image_name_1";
                break;
            
            case _IMAGE_SCHOOL_PROFILE_PICTURE_NUM :
                $imgpath = _PROFILE_PICTURE_FOLDER . "/$image_name";
                break;
            
            default :
                $imgpath = $DOC_ROOT . _IMAGE_SCHOOL_LOGO_FILE_PATH . "/$image_name";
                break;
                
        }
        
        /*if( trim($image_num) == "favicon.ico" ){
            $imgpath = $DOC_ROOT . "/public/images/vvshs_favicon.ico";
        } else {
            $imgpath = $DOC_ROOT . "/public/images/vvs_banner_2.jpg";   //vvshs_image.jpg";
        }*/

        // Get the mimetype for the file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);  // return mime type ala mimetype extension
        $mime_type = finfo_file($finfo, $imgpath);
        
        
        finfo_close($finfo);

        switch ($mime_type){
            case "image/jpeg":
                // Set the content type header - in this case image/jpg
                header('Content-Type: image/jpeg');

                // Get image from file
                $img = imagecreatefromjpeg($imgpath);

                // Output the image
                imagejpeg($img);

                break;
            case "image/png":
                // Set the content type header - in this case image/png
                header('Content-Type: image/png');

                // Get image from file
                $img = imagecreatefrompng($imgpath);

                // integer representation of the color black (rgb: 0,0,0)
                $background = imagecolorallocate($img, 0, 0, 0);

                // removing the black from the placeholder
                imagecolortransparent($img, $background);

                // turning off alpha blending (to ensure alpha channel information 
                // is preserved, rather than removed (blending with the rest of the 
                // image in the form of black))
                imagealphablending($img, false);

                // turning on alpha channel information saving (to ensure the full range 
                // of transparency is preserved)
                imagesavealpha($img, true);

                // Output the image
                imagepng($img);

                break;
            case "image/gif":
                // Set the content type header - in this case image/gif
                header('Content-Type: image/gif');

                // Get image from file
                $img = imagecreatefromgif($imgpath);

                // integer representation of the color black (rgb: 0,0,0)
                $background = imagecolorallocate($img, 0, 0, 0);

                // removing the black from the placeholder
                imagecolortransparent($img, $background);

                // Output the image
                imagegif($img);

                break;
            
            case "image/x-icon":
                header('Content-type: image/x-icon');
                header('Content-Disposition: inline; filename="' . $image_name . '"');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . filesize($imgpath));
                header('Accept-Ranges: bytes');

                @readfile($imgpath);
                break;
        }
        
        ob_end_flush();
        // Free up memory
        imagedestroy($img);
    }
    
    public function generalInformation(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('generalmodel');
        $this->load->model('basicmodel');
        $gen_info = $this->generalmodel->getGeneralInformation( $school_id );
        $notifications = $this->basicmodel->getGeneralNotifications( $school_id );
        
        $displayData = array();
        $displayData['general_information'] = $gen_info;
        $displayData['notifications']       = $notifications;
        
        $this->load->view( 'general_information', $displayData );
    }
    
    public function events(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('generalmodel');
        $this->load->model('basicmodel');
        $event_info = $this->generalmodel->getEventInformation( $school_id );
        $notifications = $this->basicmodel->getGeneralNotifications( $school_id );
        
        $displayData = array();
        $displayData['event_information']   = $event_info;
        $displayData['notifications']       = $notifications;
        
        $this->load->view( 'events', $displayData );
    }
    
    public function aboutUs(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('generalmodel');
        $board_info = $this->generalmodel->getBoardInformation( $school_id );
        
        $displayData = array();
        $displayData['board_information']   = $board_info;
        
        $this->load->view( 'about_us', $displayData );
    }
    
    public function ourPrincipal(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('generalmodel');
        $board_info = $this->generalmodel->getBoardInformation( $school_id );
        
        $displayData = array();
        $displayData['board_information']   = $board_info;
        
        $this->load->view( 'our_principal', $displayData );
    }
    
    public function ourBoard(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('generalmodel');
        $board_info = $this->generalmodel->getBoardInformation( $school_id );
        
        $displayData = array();
        $displayData['board_information']   = $board_info;
        
        $this->load->view( 'our_board', $displayData );
    }
    
    public function our_teachers(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('generalmodel');
        $faculty_info = $this->generalmodel->getFacultyInformation( $school_id );
        
        $displayData = array();
        $displayData['faculty_information']   = $faculty_info;
        
        $this->load->view( 'our_teachers', $displayData );
    }
    
    public function school_calendar(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('generalmodel');
        $this->load->model('basicmodel');
        $calendar_info = $this->generalmodel->getSchoolCalendar( $school_id );
        $notifications = $this->basicmodel->getGeneralNotifications( $school_id );
        /*
short_desc, description, date_format( calendar_date_from, '%Y-%m-%d' ) as from_date, "
                . " date_format( calendar_date_to, '%Y-%m-%d' ), item_type
         *          */
        $displayData = array();
        $displayData['notifications']   = $notifications;
        $displayData['calendar_info']   = $calendar_info['events'];
        $displayData['calendar_start']  = $calendar_info['cal_date_from'];
        $displayData['calendar_end']    = $calendar_info['cal_date_to']; 
                
        $this->load->view( 'school_calendar', $displayData );
    }
    
    public function code_of_conduct(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('generalmodel');
        $this->load->model('basicmodel');
        $notifications = $this->basicmodel->getGeneralNotifications( $school_id );
        
        $displayData = array();
        $displayData['notifications']   = $notifications;
                
        $this->load->view( 'code_of_conduct', $displayData );
    }
    
    public function school_tour(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('generalmodel');
        $this->load->model('basicmodel');
        $notifications = $this->basicmodel->getGeneralNotifications( $school_id );
        
        $displayData = array();
        $displayData['notifications']   = $notifications;
                
        $this->load->view( 'school_tour', $displayData );
    }
    
    public function clubs(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('generalmodel');
        $this->load->model('basicmodel');
        $notifications = $this->basicmodel->getGeneralNotifications( $school_id );
        
        $displayData = array();
        $displayData['notifications']   = $notifications;
                
        $this->load->view( 'clubs', $displayData );
    }
    
    public function ps_home(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $displayData = array();
        $this->load->view( 'ps_home', $displayData );
    }
    
    public function setupSNSPlatformApp(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->load->model('schoolmodel');
            $snsClient = new AwsSNS();
            $current_token = "";
            $next_token = "";
            $platformApplications = $snsClient->listPlatformApplications($current_token, $next_token);
            error_log("platformApplications : " . print_r($platformApplications, true));
            if( $platformApplications == null || count($platformApplications) == 0 ){
                //$platformApplicationArn = $snsClient->createAndroidPlatformApplication();
            } else {
                /* $platformApplicationArn = "";
                for( $i=0; $i < count($platformApplications); $i++ ){
                    $platformApplicationArn = $platformApplications[$i]['PlatformApplicationArn'];
                    error_log( "platormAppArn :  " . $platformApplications[$i]['PlatformApplicationArn'] );
                    break;
                } */
                
                //Onep token
                //$token = "cMDJ17symEQ:APA91bEhYrJ1mdvCbLDXm3wW1iIVZ6N53YXtwGOcpZ9oyAoGvrHPRtMKFR05CNglbef63Nj7fjzTkuJMlb5vnystEsSlB3TNfJ-0pC_9TlXQNhZGOuletFZNaFMc9hbmcRkV19j5nH0F";
                //$endPointArn = $snsClient->createPlatformEndpoint( $platformApplicationArn, $token, trim($sessionUserData['user_id']) );
                //$endPointArn = "arn:aws:sns:ap-southeast-1:080212279106:endpoint/GCM/PaathshaalaAPI/67be268c-f04f-3632-8b19-69efdea36773";
                ////error_log( "token : " . $token );
                //error_log( "endPointArn : " . $endPointArn );
                
                //Moto token
                //$token = "fEo9L-jkay8:APA91bGAw_FtPW1LoWumrod_YIdi0SIMoO7m8e47sc3AelxIvTCSd49f1dH4YXSNxqsLECE2VpYzpAmk9eHQKPSVhQd_PIc1vSRl0QnFzXA7cuzuE3vc9czhQPFGgS9zsS6jiyle-Mjm";
                //$endPointArn = $snsClient->createPlatformEndpoint( $platformApplicationArn, $token, trim($sessionUserData['user_id']) );
                //error_log( "endPointArn : " . $endPointArn );
                //createPlatformEndpoint( $platformApplicationArn, $token, $user_id )
            }
            
            /*$platformApplicationArn = "arn:aws:sns:ap-southeast-1:080212279106:app/GCM/PaathshaalaAPI";
            $token = "cMDJ17symEQ:APA91bEhYrJ1mdvCbLDXm3wW1iIVZ6N53YXtwGOcpZ9oyAoGvrHPRtMKFR05CNglbef63Nj7fjzTkuJMlb5vnystEsSlB3TNfJ-0pC_9TlXQNhZGOuletFZNaFMc9hbmcRkV19j5nH0F";
            $user_id = "35";
            try {
                $endPointArn = $snsClient->createPlatformEndpoint( $platformApplicationArn, $token, $user_id );
            } catch( Exception $e ){//Aws\Sns\Exception\Sns
                error_log( "createAndSavePlatformEndpointsBatch api exception. Exc : " . print_r($e->getMessage(), true) );
            } */
            //$endPointArn = "arn:aws:sns:ap-southeast-1:080212279106:endpoint/GCM/PaathshaalaAPI/632fdf06-a684-394f-8b96-1c6aa1045174";
            /*$snsClient->setEndpointAttributes($endPointArn, "false", "");
            $next_token = "";
            $endPoints = $snsClient->listEndpointsByPlatformApplication($platformApplicationArn, "", $next_token);
            error_log( "endPoints : " . print_r( $endPoints, true ) ); */
            //$topicArn = "arn:aws:sns:ap-southeast-1:080212279106:TestTopic";
                    //$snsClient->createTopic("TestTopic");
            //error_log("topicArn : $topicArn");
            $topic_arn = "arn:aws:sns:ap-southeast-1:080212279106:TestTopic";
            $endpoint_arn = "arn:aws:sns:ap-southeast-1:080212279106:endpoint/GCM/PaathshaalaAPI/67be268c-f04f-3632-8b19-69efdea36773";
                    //"arn:aws:sns:ap-southeast-1:080212279106:endpoint/GCM/PaathshaalaAPI/632fdf06-a684-394f-8b96-1c6aa1045174";
            $endpointEnabled = $snsClient->isEndpointAttributeEnabled($endpoint_arn);
            $endpointAttrs = $snsClient->getEndpointAttributes($endpoint_arn);
            error_log( "endpointAttrs : " . print_r($endpointAttrs, true) );
            error_log( "endpointEnabled : " . $endpointEnabled );
            
            $subscriptionArn = $snsClient->subscribeToTopic($topic_arn, $endpoint_arn);
            error_log("subscriptionArn : $subscriptionArn");
            
            //$token = "fEo9L-jkay8:APA91bGAw_FtPW1LoWumrod_YIdi0SIMoO7m8e47sc3AelxIvTCSd49f1dH4YXSNxqsLECE2VpYzpAmk9eHQKPSVhQd_PIc1vSRl0QnFzXA7cuzuE3vc9czhQPFGgS9zsS6jiyle-Mjm";
            //$subscriptionArn = $snsClient->confirmSubscription($topic_arn, $token);
            $message_json = '{ "notif_type" : "homework", "data" : { "date" : "15", "month" : "4", "year" : "2017", "num_hw" : "3" } }';
            //$message_json = '{ "notif_type" : "scorecard", "data" : { "test_id" : "85", "test_name" : "Mid-Term Exam", "subject_id" : "21", "subject_name" : "Science" } }';
            //$message_json = '{ "notif_type" : "inbox", "data" : { "timestamp" : "14634433255", "unreadMsgs" : "8" } }';
            $subject = "Sample subject";
            /*try{
                $messageId = $snsClient->publish("", $endPointArn, $message_json, $subject );
            } catch( Aws\Sns\Exception\SnsException $e ){
                error_log( "exception: " . print_r($e, true));
            }
            //$messageId = $snsClient->publish($topicArn, "", $message_json, $subject );
            error_log("messageId : " . $messageId ); */
        } else {
            echo "false";
        }
    }
}

?>