<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once( $DOC_ROOT . '/application/libraries/MemcacheLibrary.php' );
require_once $DOC_ROOT . "/system/libraries/AwsS3.php";
require_once $DOC_ROOT . "/system/libraries/AwsSNS.php";
//require_once $DOC_ROOT . "/vendor/autoload.php";
require_once $DOC_ROOT . "/application/libraries/getallheaders.php";

date_default_timezone_set("Asia/Kolkata");

class schoolController extends CI_Controller {
    
    public function index(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            //do something - this is new year
                     
        } else {
            
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;   
            
        }
    }
    
    public function getPhpInfo(){
        echo phpinfo();
    }
    
    public function notifications( $pageNo, $pageSize, $message = "" ){
        $this->load->library('session');
        $this->load->library('Logging');        
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $notificationPeriod      = ( isset($_POST["notificationPeriod"]) ? trim($_POST["notificationPeriod"]) : "" );
            $notificationStatus      = ( isset($_POST["notificationStatus"]) ? trim($_POST["notificationStatus"]) : "" );
            $notificationPriority    = ( isset($_POST["notificationPriority"]) ? trim($_POST["notificationPriority"]) : "" );
            $notificationRemoveBy    = ( isset($_POST["notificationRemoveBy"]) ? trim($_POST["notificationRemoveBy"]) : "" );
            $notificationType        = ( isset($_POST["notificationType"]) ? trim($_POST["notificationType"]) : "" );
            $notificationDisplayOnHome = ( isset($_POST["notificationDisplayOnHome"]) ? trim($_POST["notificationDisplayOnHome"]) : "" );
            
            $school_id = '0';
            $fromSearch = "";
            $toSearch = "";
            $fromRemoveBy = "";
            $toRemoveBy = "";
            
            $this->load->library('DateUtilities');
            $this->dateutilities->setDateRange( $notificationPeriod, $fromSearch, $toSearch, false );
            if( $notificationPeriod == "" ){
                $fromSearch = _SCHOOL_DEFAULT_START_DATE . " 00:00:00";
            }
            if( $notificationRemoveBy != "" )
                $this->dateutilities->setDateRange( $notificationRemoveBy, $fromRemoveBy, $toRemoveBy, true );
            
            $this->load->model('schoolmodel');
            $notificationCount = 0;
            $notificationDetails = $this->schoolmodel->getGeneralNotifications( $school_id, $fromSearch, $toSearch, $notificationStatus,
                    $notificationPriority, $fromRemoveBy, $toRemoveBy, $notificationType, $notificationDisplayOnHome,
                    $notificationCount, $pageNo, $pageSize );
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['pageNo']     = $pageNo;
            $displayData['pageSize']   = $pageSize;
            $displayData['notificationDetails']   = $notificationDetails;
            $displayData['notificationCount']   = $notificationCount;            
            
            if( $notificationPeriod !== "" ){
                $displayData['notificationPeriod']   = $notificationPeriod;
            }
            
            if( $notificationStatus !== "" ){
                $displayData['notificationStatus']   = $notificationStatus;
            }
            
            if( $notificationPriority !== "" ){
                $displayData['notificationPriority']   = $notificationPriority;
            }
            
            if( $notificationRemoveBy !== "" ){
                $displayData['notificationRemoveBy']   = $notificationRemoveBy;
            }
            
            if( $notificationType !== "" ){
                $displayData['notificationType']   = $notificationType;
            }
            
            if( $notificationDisplayOnHome !== "" ){
                $displayData['notificationDisplayOnHome'] = $notificationDisplayOnHome;
            }
            
            $this->load->view('general_notifications', $displayData);
                     
        } else {
            
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;   
            
        }
    }
    
    public function notificationsREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        if( $requestParams ){
            $notificationPeriod        = '';
            $notificationStatus        = '';
            $notificationPriority      = '';    
            $notificationRemoveBy      = '';     
            $notificationType          = '';        
            $notificationDisplayOnHome = '';
            $pageNo                    = '';
            $pageSize                  = '';
            
            $school_id = '0';
            $fromSearch = '';
            $toSearch = '';
            $fromRemoveBy = '';
            $toRemoveBy = '';
            
            $parameters = $requestParams['data'];
            if( array_key_exists( 'notificationPeriod', $parameters) && is_string( $parameters['notificationPeriod'] ) ){
                $notificationPeriod = trim($parameters['notificationPeriod']);
            }
            
            if( array_key_exists( 'notificationStatus', $parameters) && is_string( $parameters['notificationStatus'] ) ){
                $notificationStatus = trim($parameters['notificationStatus']);
            }
            
            if( array_key_exists( 'notificationPriority', $parameters) && is_string( $parameters['notificationPriority'] ) ){
                $notificationPriority = trim($parameters['notificationPriority']);
            }
            
            if( array_key_exists( 'notificationRemoveBy', $parameters) && is_string( $parameters['notificationRemoveBy'] ) ){
                $notificationRemoveBy = trim($parameters['notificationRemoveBy']);
            }
            
            if( array_key_exists( 'notificationType', $parameters) && is_string( $parameters['notificationType'] ) ){
                $notificationType = trim($parameters['notificationType']);
            }
            
            if( array_key_exists( 'notificationDisplayOnHome', $parameters) && is_string( $parameters['notificationDisplayOnHome'] ) ){
                $notificationDisplayOnHome = trim($parameters['notificationDisplayOnHome']);
            }
            
            if( array_key_exists( 'pageNo', $parameters) && is_string( $parameters['pageNo'] ) ){
                $pageNo = trim($parameters['pageNo']);
            }
            
            if( array_key_exists( 'pageSize', $parameters) && is_string( $parameters['pageSize'] ) ){
                $pageSize = trim($parameters['pageSize']);
            }
            
            if( array_key_exists( 'school_id', $parameters) && is_string( $parameters['school_id'] ) ){
                $school_id = trim($parameters['school_id']);
            }
            
            if( $pageNo == "" || $pageSize == "" ){
                $this->logging->logDebug( "Page size or page no. not given ", __FILE__, __FUNCTION__, __LINE__, 
                        "pageNo : $pageNo, pageSize : $pageSize" );
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false", "error" : "Invalid Input" }' );
                return;
            }
            
            $this->load->library('DateUtilities');
            $this->dateutilities->setDateRange( $notificationPeriod, $fromSearch, $toSearch, false );
            if( $notificationRemoveBy != "" )
                $this->dateutilities->setDateRange( $notificationRemoveBy, $fromRemoveBy, $toRemoveBy, true );
            
            $this->load->model('schoolmodel');
            $notificationCount = 0;
            $notificationDetails = $this->schoolmodel->getGeneralNotifications( $school_id, $fromSearch, $toSearch, $notificationStatus,
                    $notificationPriority, $fromRemoveBy, $toRemoveBy, $notificationType, $notificationDisplayOnHome,
                    $notificationCount, $pageNo, $pageSize );
            
            $notificationDetailsJson = json_encode($notificationDetails);  
            $this->logging->logDebug( "Success - got notifications ", __FILE__, __FUNCTION__, __LINE__, 
                        "notificationDetailsJson : $notificationDetailsJson" );
            $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "notification_details" : ' . $notificationDetailsJson . 
                                ', "notification_count" : "' . $notificationCount . '" }' );
            
        }
        
    }
    
    public function addOrUpdateNotification(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $notificationID          = ( isset($_POST["notificationID"]) ? trim($_POST["notificationID"]) : "" );
            $notificationHeading     = ( isset($_POST["editNotificationHeading"]) ? trim($_POST["editNotificationHeading"]) : "" );
            $notificationText        = ( isset($_POST["editNotificationText"]) ? trim($_POST["editNotificationText"]) : "" );
            $notificationType        = ( isset($_POST["editNotificationType"]) ? trim($_POST["editNotificationType"]) : "" );
            $notificationPriority    = ( isset($_POST["editNotificationPriority"]) ? trim($_POST["editNotificationPriority"]) : "" );
            $notificationRemoveBy    = ( isset($_POST["editRemoveNotif"]) ? trim($_POST["editRemoveNotif"]) : "" );  
            $notificationDisplayOnHome  = ( isset($_POST["editDisplayOnHome"]) ? trim($_POST["editDisplayOnHome"]) : "" ); 
            
            if( $notificationHeading == "" ){
                $message = "Please enter the notification heading to create a notification";
                $this->notifications( 1, _GENERAL_NOTIFICATION_PAGE_SIZE, $message );
                return;
            }
            $school_id = '0';
            $filename  = "";
            $file_saved = true;
            if( isset($_FILES['editNotificationImageUpload'] ) && isset( $_FILES['editNotificationImageUpload']['tmp_name'] ) &&
                    trim( $_FILES['editNotificationImageUpload']['tmp_name'] ) != "" &&
                    exif_imagetype($_FILES['editNotificationImageUpload']['tmp_name']) > 0 &&
                    $_FILES["editNotificationImageUpload"]["size"] <= _GENERAL_NOTIFICATION_IMAGE_MAX_SIZE ){
                
                $timestamp = time();
                $filename = $timestamp . '_' . $_FILES["editNotificationImageUpload"]["name"];
                $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
                $file = $DOC_ROOT . _GENERAL_NOTIFICATION_IMAGE_FOLDER . '/' . $filename;
                $try_count = 3;
                $file_saved = false;
                while( !$file_saved && $try_count > 0 ){
                    $file_saved = move_uploaded_file($_FILES['editNotificationImageUpload']['tmp_name'], $file) ;
                    if( !$file_saved )
                        sleep(2);
                    $try_count-- ;
                }
            } else {
                $error_msg = "Error uploading notification image file";
                $this->logging->logError($error_msg, __FILE__, __FUNCTION__, __LINE__, "");
            }
            
            $success = false;
            $this->load->model('schoolmodel');
            if( $notificationID == "" ){
                $success = $this->schoolmodel->addNotification( $school_id, $notificationHeading, $notificationText, $notificationType, 
                                            $notificationPriority, $notificationRemoveBy, $notificationDisplayOnHome, $filename );
            } else {
                $success = $this->schoolmodel->updateNotification( $school_id, $notificationID, $notificationHeading, $notificationText,  
                                            $notificationType, $notificationPriority, $notificationRemoveBy, $notificationDisplayOnHome, $filename );
            }
               
            $message = "";
            if( $file_saved && $success ){
                if( $notificationID == "" ){
                    $message = "Successfully added the notification";
                } else {
                    $message = "Successfully updated the notification";
                }
                
                $this->logging->logDebug($message, __FILE__, __FUNCTION__, __LINE__, $notificationID);
                $this->notifications( 1, _GENERAL_NOTIFICATION_PAGE_SIZE, $message );
            } else {
                if( $notificationID == "" ){
                    $message = "Unable to add the notification";
                } else {
                    $message = "Unable to update the notification";
                }
                
                $this->logging->logError($message, __FILE__, __FUNCTION__, __LINE__, $notificationID);
                $this->notifications( 1, _GENERAL_NOTIFICATION_PAGE_SIZE, $message );
            }
            
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
                
    }
    
    public function deleteNotifications(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $notificationIDs          = ( isset($_POST["notification_ids"]) ? trim($_POST["notification_ids"]) : "" );
            $school_id = '0';
            $this->load->model('schoolmodel');
            if( $notificationIDs != "" ){
                $this->schoolmodel->deleteNotifications( $school_id, $notificationIDs );
                $this->logging->logDebug("Notification deleted successfully", __FILE__, __FUNCTION__, __LINE__, $notificationIDs);
                echo json_encode("true");
            } else {
                $this->logging->logError("Unable to delete notification", __FILE__, __FUNCTION__, __LINE__, $notificationIDs);
                echo json_encode("false~~Unable to delete notification");
            }
            
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function genNotificationDetails( $notification_id ){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $this->load->model('schoolmodel');
        $notificationDetails = $this->schoolmodel->getNotificationDetails( $notification_id );
        
        $headerData = array();
        $displayData = array();
        $headerData['logged_in'] = false;
        $displayData['headerData'] = $headerData;
        $displayData['notificationDetails'] = $notificationDetails;
        $this->load->view('gen_notification_details', $displayData);
        return;
    }
    
    public function edit_calendar(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            $calendarTerm = $this->schoolmodel->getCalendarTerm( $school_id );
            $calendarEvents = $this->schoolmodel->getCalendarEvents( $school_id, $calendarTerm );
            /*$notificationIDs          = ( isset($_POST["notification_ids"]) ? trim($_POST["notification_ids"]) : "" );
            $school_id = '0';
            $this->load->model('schoolmodel');
            if( $notificationIDs != "" ){
                $this->schoolmodel->deleteNotifications( $school_id, $notificationIDs );
                $this->logging->logDebug("Notification deleted successfully", __FILE__, __FUNCTION__, __LINE__, $notificationIDs);
                echo json_encode("true");
            } else {
                $this->logging->logError("Unable to delete notification", __FILE__, __FUNCTION__, __LINE__, $notificationIDs);
                echo json_encode("false~~Unable to delete notification");
            }*/
            
            $month_wise_event_array = array();
            $calendar_start_arr = explode( "-", $calendarTerm['from_date'] );
            $calendar_end_arr   = explode( "-", $calendarTerm['to_date'] );
            
            $calendar_start_year = trim($calendar_start_arr[0]);
            $calendar_end_year = trim($calendar_end_arr[0]);
            
            $calendar_start_month = trim($calendar_start_arr[1]);
            $calendar_end_month = trim($calendar_end_arr[1]);
            
            $monthArray = array( 1 => "January",
                                 2 => "February",
                                 3 => "March",
                                 4 => "April",
                                 5 => "May",
                                 6 => "June",
                                 7 => "July",
                                 8 => "August",
                                 9 => "September",
                                 10 => "October",
                                 11 => "November",
                                 12 => "December" );
            
            if( $calendar_start_year == $calendar_end_year ){
                for( $i = intval($calendar_start_month); $i <= intval($calendar_end_month); $i++ ){
                    $month_wise_event_array[ $monthArray[intval($i)] . ", " . $calendar_start_year ] = array();
                }
            } else {
                for( $i = intval($calendar_start_month); $i <= 12; $i++ ){
                    $month_wise_event_array[ $monthArray[intval($i)] . ", " . $calendar_start_year ] = array();
                }
                for( $i = 1; $i <= intval($calendar_end_month); $i++ ){
                    $month_wise_event_array[ $monthArray[intval($i)] . ", " . $calendar_end_year ] = array();
                }
            }
            
            for( $i = 0; $i < count($calendarEvents); $i++ ){
                $event_from_date = trim( $calendarEvents[$i]['from_date'] );
                $event_to_date   = trim( $calendarEvents[$i]['to_date'] );
                
                $event_from_date_arr = explode( "-", $event_from_date );
                $event_to_date_arr   = explode( "-", $event_to_date );
                
                $month_wise_array_from_key = $monthArray[intval(trim($event_from_date_arr[1]))] . ", " . trim($event_from_date_arr[0]);
                $month_wise_array_to_key = $monthArray[intval(trim($event_to_date_arr[1]))] . ", " . trim($event_to_date_arr[0]);
                $event_from_date_day = intval( trim($event_from_date_arr[2]) );
                $event_to_date_day = intval( trim($event_to_date_arr[2]) );
                
                if( array_key_exists( $month_wise_array_from_key, $month_wise_event_array ) ){
                    $month_wise_event_array[ $month_wise_array_from_key ][$event_from_date_day] = $calendarEvents[$i];
                }
                
                if( trim($event_from_date_arr[1]) != trim($event_to_date_arr[1]) ){
                    if( array_key_exists( $month_wise_array_to_key, $month_wise_event_array ) ){
                        $month_wise_event_array[ $month_wise_array_to_key ][$event_to_date_day] = $calendarEvents[$i];
                    }
                }
            }
                                            
            $displayData = array();
            $displayData['calendar_start'] = $calendarTerm['from_date'];
            $displayData['calendar_end'] = $calendarTerm['to_date'];
            $displayData['month_wise_event_array'] = $month_wise_event_array;
            $message = "";
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $this->load->view('edit_calendar', $displayData);
            
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function changeCalendarPeriod(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $from_period = ( isset($_POST["from_period"]) ? trim($_POST["from_period"]) : "" );
            $to_period   = ( isset($_POST["to_period"]) ? trim($_POST["to_period"]) : "" );
            
            $calTermFromDateObj = date_create( $from_period );
            $calTermToDateObj = date_create( $to_period );
            
            if( is_bool($calTermFromDateObj) && $calTermFromDateObj == FALSE ){
                echo json_encode("false~~Invalid From Date");
                return;
            }
            if( is_bool($calTermToDateObj) && $calTermToDateObj == FALSE ){
                echo json_encode("false~~Invalid To Date");
                return;
            }
            if( $calTermToDateObj < $calTermFromDateObj ){
                echo json_encode("false~~To event date should be later than from event date");
                return;
            }
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            $response = $this->schoolmodel->changeCalendarPeriod( $school_id, $from_period, $to_period );
            echo $response;
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
     
    public function addOrEditCalEvent(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
                        
            $from_event_date     = ( isset($_POST["from_event_date"]) ? trim($_POST["from_event_date"]) : "" );
            $to_event_date       = ( isset($_POST["to_event_date"]) ? trim($_POST["to_event_date"]) : "" );
            $event_name          = ( isset($_POST["event_name"]) ? trim($_POST["event_name"]) : "" );
            $event_description   = ( isset($_POST["event_description"]) ? trim($_POST["event_description"]) : "" );
            $event_id            = ( isset($_POST["event_id"]) ? trim($_POST["event_id"]) : "" );
            $event_type          = ( isset($_POST["event_type"]) ? trim($_POST["event_type"]) : "" );
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            
            $calendarTerm = $this->schoolmodel->getCalendarTerm( $school_id );
            $calTermFromDateObj = date_create( trim( $calendarTerm['from_date'] ) );
            $calTermToDateObj = date_create( trim( $calendarTerm['to_date'] ) );
            
            $from_event_date_obj = date_create( trim( $from_event_date ) );
            $to_event_date_obj = date_create( trim( $to_event_date ) );
            
            if( is_bool($from_event_date_obj) && $from_event_date_obj == FALSE ){
                echo json_encode("false~~Invalid From Date");
                return;
            }
            if( is_bool($to_event_date_obj) && $to_event_date_obj == FALSE ){
                echo json_encode("false~~Invalid To Date");
                return;
            }
            if( $to_event_date_obj < $from_event_date_obj ){
                echo json_encode("false~~To event date should be later than from event date");
                return;
            }
            if( $calTermFromDateObj > $from_event_date_obj ){
                echo json_encode("false~~The event should be within the calendar term");
                return;
            }
            if( $calTermToDateObj < $to_event_date_obj ){
                echo json_encode("false~~The event should be within the calendar term");
                return;
            }
            if( $event_id == "-1" ){
                $response = $this->schoolmodel->addCalendarEvent( $school_id, $from_event_date, $to_event_date, 
                                                    $event_name, $event_description, $event_type );
            } else {
                $response = $this->schoolmodel->editCalendarEvent( $school_id, $event_id, $from_event_date, 
                                                    $to_event_date, $event_name, $event_description, $event_type );
            }
            echo json_encode($response);
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
    
    public function teachers(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || 
                      $sessionUserData['user_type'] == _USER_TYPE_TEACHER || $sessionUserData['user_type'] == _USER_TYPE_PARENT  ) ) ){
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            $teacherNameSearch = ( isset($_POST["teacherNameSearch"]) ? trim($_POST["teacherNameSearch"]) : "" );
            $teacherClassSearch = ( isset($_POST["teacherClassSearch"]) ? trim($_POST["teacherClassSearch"]) : "" );
            $teacherSectionSearch = ( isset($_POST["teacherSectionSearch"]) ? trim($_POST["teacherSectionSearch"]) : "" );
            $teacherSubjectSearch = ( isset($_POST["teacherSubjectSearch"]) ? trim($_POST["teacherSubjectSearch"]) : "" );
            $classArray = ( isset($_POST["classArray"]) ? trim($_POST["classArray"]) : "" );
            $teacherMap = ( isset($_POST["teacherCompleteList"]) ? trim($_POST["teacherCompleteList"]) : "" );
            
            $subjects = $this->schoolmodel->getSubjectList( $school_id, true );
            $subjects = $subjects[0];
            $teachers = $this->schoolmodel->getTeacherList( $school_id, $teacherNameSearch, 
                                                   $teacherClassSearch, $teacherSectionSearch, $teacherSubjectSearch, "0" );
            
            if( $classArray != "" && count( $classArray ) > 0 ){
                $classes = $classArray;
            } else {
                $classes = $this->schoolmodel->getClasses( $school_id );
                $classes = json_encode($classes);
            }
            
            if( $teacherMap == ""  ){
                 $teacherMap = $this->schoolmodel->getTeacherListPlain( $school_id, false );
                 $teacherMap = json_encode( $teacherMap );
            } 
            
            $searchCriteria = "None";
            if( $teacherNameSearch != "" ){
                $searchCriteria = "NAME : <mark>" . $teacherNameSearch . "</mark>";
            } else if( $teacherClassSearch != "" ){
                $classMap = array();
                $classMap[_ADMISSION_APPLY_PRE_KG] = "Pre-KG";
                $classMap[_ADMISSION_APPLY_LKG] = "LKG";
                $classMap[_ADMISSION_APPLY_UKG] = "UKG";
                $classMap[_ADMISSION_APPLY_CLASS_1] = "Class I";
                $classMap[_ADMISSION_APPLY_CLASS_2] = "Class II";
                $classMap[_ADMISSION_APPLY_CLASS_3] = "Class III";
                $classMap[_ADMISSION_APPLY_CLASS_4] = "Class IV";
                $classMap[_ADMISSION_APPLY_CLASS_5] = "Class V";
                $classMap[_ADMISSION_APPLY_CLASS_6] = "Class VI";
                $classMap[_ADMISSION_APPLY_CLASS_7] = "Class VII";
                $classMap[_ADMISSION_APPLY_CLASS_8] = "Class VIII";
                $classMap[_ADMISSION_APPLY_CLASS_9] = "Class IX";
                $classMap[_ADMISSION_APPLY_CLASS_10] = "Class X";
                $classMap[_ADMISSION_APPLY_CLASS_11] = "Class XI";
                $classMap[_ADMISSION_APPLY_CLASS_12] = "Class XII";
                $classMap[_ADMISSION_APPLY_PLAY_HOME] = "Play Home";
                
                $searchCriteria = "CLASS : <mark>" . $classMap[$teacherClassSearch] . "</mark>";
                if( $teacherSectionSearch != "" ){
                    $searchCriteria .= ", SECTION : <mark>" . $teacherSectionSearch . "</mark>";
                }
                if( $teacherSubjectSearch != "" ){
                    $searchCriteria .= ", SUBJECT : <mark>" . $subjects[$teacherSubjectSearch] . "</mark>";
                }
            }
            //$displayData[']
            //$teacherSearchByClass
            //$selectedSection
            //$teacherNameEntered
            //$selectedSubject
            //$teachers = $this->schoolmodel->getTeacherList( $school_id );
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['subjectList'] = $subjects;
            $displayData['teachers'] = $teachers;
            $displayData['classes'] = $classes;
            $displayData['teachersComplete'] = $teacherMap;
            $displayData['teacherSearchByClass'] = $teacherClassSearch;
            $displayData['selectedSection'] = $teacherSectionSearch;
            $displayData['teacherNameEntered'] = $teacherNameSearch;
            $displayData['selectedSubject'] = $teacherSubjectSearch;
            $displayData['searchCriteria'] = $searchCriteria;
            
            $this->load->view('teachers', $displayData);
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function teachersREST(){
        error_log("in teachersRest" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();

	error_log( "req params : " . print_r( $requestParams, true ) . "\n" );        
        if( $requestParams ){
            $school_id = '0';
            $teacherNameSearch = "";
            $teacherClassSearch = "";
            $teacherSectionSearch = "";
            $teacherSubjectSearch = "";
            $lastUpdatedTimestamp = "";
            
            $parameters = $requestParams['data'];
            error_log( " params : " . print_r( $parameters, true ) );
            if( array_key_exists( 'teacherNameSearch', $parameters) && is_string( $parameters['teacherNameSearch'] ) ){
                $teacherNameSearch = trim( $parameters['teacherNameSearch'] );
            }
            if( array_key_exists( 'teacherClassSearch', $parameters) && is_string( $parameters['teacherClassSearch'] ) ){
                $teacherClassSearch = trim( $parameters['teacherClassSearch'] );
            }
            if( array_key_exists( 'teacherSectionSearch', $parameters) && is_string( $parameters['teacherSectionSearch'] ) ){
                $teacherSectionSearch = trim( $parameters['teacherSectionSearch'] );
            }
            if( array_key_exists( 'teacherSubjectSearch', $parameters) && is_string( $parameters['teacherSubjectSearch'] ) ){
                $teacherSubjectSearch = trim( $parameters['teacherSubjectSearch'] );
            }
            if( array_key_exists( 'lastUpdatedTimestamp', $parameters) && is_string( $parameters['lastUpdatedTimestamp'] ) ){
                $lastUpdatedTimestamp = trim( $parameters['lastUpdatedTimestamp'] );
            }
            
	    error_log( "teacherNameSearch : " . $teacherNameSearch . " :: teacherClassSearch : " . $teacherClassSearch . 
			" teacherSectionSearch : " . $teacherSectionSearch . " teacherSubjectSearch : " . $teacherSubjectSearch );
     
            $this->load->model( 'schoolmodel' );
            $teachers = $this->schoolmodel->getTeacherList( $school_id, $teacherNameSearch, 
                                                   $teacherClassSearch, $teacherSectionSearch, $teacherSubjectSearch, $lastUpdatedTimestamp );
            
            $teacherJson = json_encode($teachers);
            
            $updated_timestamp = $this->schoolmodel->getUpdatedTimestamp( $school_id, _TEACHERS_TABLE_ID );
            $updated_timestamp = $updated_timestamp[0]['update_timestamp'];
            $this->restutilities->sendResponse( 200, 
                    '{"success": "true", "updated_timestamp": "' . $updated_timestamp . '", "teachers" : ' . $teacherJson .' }' );
            return;
        }
    }
    
    public function addTeacher(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $first_name          = ( isset($_POST["addTeacherFirstName"]) ? trim($_POST["addTeacherFirstName"]) : "" );
            $middle_name         = ( isset($_POST["addTeacherMiddleName"]) ? trim($_POST["addTeacherMiddleName"]) : "" );
            $last_name           = ( isset($_POST["addTeacherLastName"]) ? trim($_POST["addTeacherLastName"]) : "" );
            $address             = ( isset($_POST["addTeacherAddress"]) ? trim($_POST["addTeacherAddress"]) : "" );
            $pincode             = ( isset($_POST["addTeacherPincode"]) ? trim($_POST["addTeacherPincode"]) : "" );
            $phone_num           = ( isset($_POST["addTeacherPhone"]) ? trim($_POST["addTeacherPhone"]) : "" );            
            $email_id            = ( isset($_POST["addTeacherEmail"]) ? trim($_POST["addTeacherEmail"]) : "" );
            $twitter_handle      = ( isset($_POST["addTeacherTwitter"]) ? trim($_POST["addTeacherTwitter"]) : "" );
            $blog                = ( isset($_POST["addTeacherBlog"]) ? trim($_POST["addTeacherBlog"]) : "" );
            $date_of_birth       = ( isset($_POST["addTeacherDateOfBirth"]) ? trim($_POST["addTeacherDateOfBirth"]) : "" );
            $date_of_joining     = ( isset($_POST["addTeacherDateOfJoining"]) ? trim($_POST["addTeacherDateOfJoining"]) : "" );
            $experience          = ( isset($_POST["addTeacherExperience"]) ? trim($_POST["addTeacherExperience"]) : "" );
            $qualification       = ( isset($_POST["addTeacherQualification"]) ? trim($_POST["addTeacherQualification"]) : "" );
            $added_subjects      = ( isset($_POST["addedSubjects"]) ? trim($_POST["addedSubjects"]) : "" );
            
            $this->load->model('schoolmodel');
            $this->load->model('basicmodel');
            $school_id = '0';
            $subjects = $this->schoolmodel->getSubjectList( $school_id, true );
            $subjects = $subjects[0];
            $teachers = $this->schoolmodel->getTeacherList( $school_id, "", "", "", "", "0" );
            $classes = $this->schoolmodel->getClasses( $school_id );
            $classes = json_encode($classes);
            $teacherMap = $this->schoolmodel->getTeacherListPlain( $school_id, false );
            $teacherMap = json_encode( $teacherMap );
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['subjectList'] = $subjects;
            $displayData['teachers'] = $teachers;
            $displayData['classes'] = $classes;
            $displayData['teachersComplete'] = $teacherMap;
            
            $user_name = $this->basicmodel->getValidUsername( $first_name, $last_name );
            if( trim( $user_name ) == "" ){
                $message = "Unable to add teacher. Please contact the technology";
                $displayData['header_message'] = $message;
                $displayData['headerData'] = $headerData;
                $this->logging->logError( "Error getting username ", __FILE__, __FUNCTION__, __LINE__, "schoolid : $school_id" );
                $this->load->view('teachers', $displayData);
                return;
            }
            $password = $this->basicmodel->generateRandomPassword();
            $user_id = $this->basicmodel->addUser( $school_id, $user_name, $password, $email_id, $phone_num, _USER_TYPE_TEACHER );
            if( $first_name == "" || $last_name == "" || $phone_num == "" || $date_of_joining == "" 
                    || $experience == "" || $qualification == "" ){
                
                $message = "Unable to add teacher. Please input all the required fields.";
                $displayData['header_message'] = $message;
                $displayData['headerData'] = $headerData;
                $this->logging->logError( "Error : All required fields not input ", __FILE__, __FUNCTION__, __LINE__, "schoolid : $school_id" );
                $this->load->view('teachers', $displayData);
                return;
            }
            $inserted = $this->schoolmodel->addTeacher( $school_id, $user_id, $first_name, $middle_name, $last_name, $address, $pincode,
                                            $phone_num, $email_id, $twitter_handle, $blog, $date_of_birth, $date_of_joining,
                                            $experience, $qualification, $added_subjects );
            if( !$inserted ){
                $message = "Unable to add teacher. Please try again.";
                $displayData['header_message'] = $message;
                $displayData['headerData'] = $headerData;
                $this->load->view('teachers', $displayData);
                return;
            } else {
                $message = "Teacher added successfully!!";
                $displayData['header_message'] = $message;
                $displayData['headerData'] = $headerData;
                $this->load->view('teachers', $displayData);
                return;
            }
            
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function classes(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        $displayData = array();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $classes = $this->schoolmodel->getClasses( $school_id );
            $teacherList = $this->schoolmodel->getTeacherListPlain( $school_id, true );
            $subjectList = $this->schoolmodel->getSubjectlist( $school_id, false );
            //$classSubjectList = $this->schoolmodel->getClassSubjectlist( $school_id,  );
            $headerData = array();
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            $displayData['headerData'] = $headerData;
            $displayData['classes'] = $classes;
            $displayData['subjectList'] = str_replace("'", "", json_encode($subjectList));
            $displayData['teacherList'] = str_replace("'", "", json_encode($teacherList));
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $this->load->view('classes', $displayData);
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
    
    public function classDetails(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $timetable_meta = $this->schoolmodel->getTimetableMeta( $school_id, $class_id );
            $maxPeriods = $timetable_meta[0]['num_periods'];
            $maxDays = $timetable_meta[0]['num_days'];
            $timetable = $this->schoolmodel->getTimetable( $school_id, $class_id );
            $classSubjects = $this->schoolmodel->getClassSubjects( $school_id, $class_id );
            $classSyllabus = $this->schoolmodel->getClassSyllabus( $school_id, $class_id );
            $classesToSelectFrom = $this->schoolmodel->getSectionsWithSyllabus( $school_id, $class_id );
            $returnArray = array( 'timetable' => $timetable,
                                  'maxPeriods' => $maxPeriods,
                                  'maxDays' => $maxDays,
                                  'classSubjects' => $classSubjects,
                                  'classSyllabus' => $classSyllabus,
                                  'classesToSelectFrom' => $classesToSelectFrom );
            
            echo json_encode( $returnArray );
            return;            
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }  
    
    public function deleteClassSubject(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $subject_id  = ( isset($_POST["subject_id"] ) ? trim($_POST["subject_id"]) : "" );
            $deleted = $this->schoolmodel->deleteClassSubject( $school_id, $class_id, $subject_id );
            if( $deleted ){
                echo json_encode( "true" );
            } else {
                echo json_encode( "false" );
            }
            return;            
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function changeSubTeacher(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $subject_id  = ( isset($_POST["subject_id"] ) ? trim($_POST["subject_id"]) : "" );
            $teacher_id  = ( isset($_POST["teacher_id"] ) ? trim($_POST["teacher_id"]) : "" );
            $changed = $this->schoolmodel->changeSubTeacher( $school_id, $class_id, $subject_id, $teacher_id );
            if( $changed ){
                echo json_encode( "true" );
            } else {
                echo json_encode( "false" );
            }
            return;            
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function addClassSubject(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $subject_id  = ( isset($_POST["subject_id"] ) ? trim($_POST["subject_id"]) : "" );
            $teacher_id  = ( isset($_POST["teacher_id"] ) ? trim($_POST["teacher_id"]) : "" );
            $added = $this->schoolmodel->addClassSubject( $school_id, $class_id, $subject_id, $teacher_id );
            if( $added ){
                echo json_encode( "true" );
            } else {
                echo json_encode( "false" );
            }
            return;            
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function changeTTSubject(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $subject_id  = ( isset($_POST["subject_id"] ) ? trim($_POST["subject_id"]) : "" );
            $day_id  = ( isset($_POST["day_id"] ) ? trim($_POST["day_id"]) : "" );
            $period_id  = ( isset($_POST["period_id"] ) ? trim($_POST["period_id"]) : "" );
            $added = $this->schoolmodel->changeTTSubject( $school_id, $class_id, $subject_id, $day_id, $period_id );
            echo json_encode($added);
            return;            
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function getClassSyllabus(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $classSyllabus = $this->schoolmodel->getClassSyllabus( $school_id, $class_id );
            echo json_encode( $classSyllabus );
            return;            
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function saveSyllabusEdit(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $subject_id  = ( isset($_POST["subject_id"] ) ? trim($_POST["subject_id"]) : "" );
            $content  = ( isset($_POST["content"] ) ? html_entity_decode(trim($_POST["content"])) : "" );
            $isComplete  = ( isset($_POST["isComplete"] ) ? html_entity_decode(trim($_POST["isComplete"])) : "" );
            $weights  = ( isset($_POST["weights"] ) ? html_entity_decode(trim($_POST["weights"])) : "" );
            $syllabus_ids  = ( isset($_POST["syllabus_ids"] ) ? html_entity_decode(trim($_POST["syllabus_ids"])) : "" );
            $contentNew  = ( isset($_POST["contentNew"] ) ? html_entity_decode(trim($_POST["contentNew"])) : "" );
            $isCompleteNew  = ( isset($_POST["isCompleteNew"] ) ? html_entity_decode(trim($_POST["isCompleteNew"])) : "" );
            $weightsNew  = ( isset($_POST["weightsNew"] ) ? html_entity_decode(trim($_POST["weightsNew"])) : "" );
            $syllabusIdsDeleted = ( isset($_POST["syllabusIdsDeleted"] ) ? html_entity_decode(trim($_POST["syllabusIdsDeleted"])) : "" );
            
            $saved = $this->schoolmodel->saveSyllabusEdit( $school_id, $class_id, $subject_id, $content, $isComplete,
                                                $weights, $syllabus_ids, $contentNew, $isCompleteNew, $weightsNew, $syllabusIdsDeleted );
            echo json_encode( $saved );
            return;            
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function importSyllabus(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $subject_id  = ( isset($_POST["subject_id"] ) ? trim($_POST["subject_id"]) : "" );
            $importFromCls  = ( isset($_POST["importFromCls"] ) ? trim($_POST["importFromCls"]) : "" );
            
            error_log(" class_id : $class_id :: subject_id : $subject_id :: importFromCls : $importFromCls ");
            $imported = $this->schoolmodel->importSyllabus( $school_id, $class_id, $subject_id, $importFromCls );
            echo json_encode( $imported );
            return;            
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function students(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && 
                        ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $studentNameSearch = ( isset($_POST["studentNameSearch"]) ? trim($_POST["studentNameSearch"]) : "" );
            $studentParentNameSearch = ( isset($_POST["studentParentNameSearch"]) ? trim($_POST["studentParentNameSearch"]) : "" );
            $studentClassSearch = ( isset($_POST["studentClassSearch"]) ? trim($_POST["studentClassSearch"]) : "" );
            $studentSectionSearch = ( isset($_POST["studentSectionSearch"]) ? trim($_POST["studentSectionSearch"]) : "" );
            $studentRollNoEntered = ( isset($_POST["studentRollNoEntered"]) ? trim($_POST["studentRollNoEntered"]) : "" );
            $classArray = ( isset($_POST["classArray"]) ? trim($_POST["classArray"]) : "" );
            
            if( $classArray != "" && count( $classArray ) > 0 ){
                $classes = $classArray;
            } else {
                $classes = $this->schoolmodel->getClasses( $school_id );
                $classes = json_encode($classes);
            }
            
            $students = $this->schoolmodel->getStudentList( $school_id, $studentParentNameSearch, $studentNameSearch, 
                                                            $studentClassSearch, $studentSectionSearch, $studentRollNoEntered );
            /*$subjects = $this->schoolmodel->getSubjectList( $school_id, true );
            $subjects = $subjects[0];*/
            
            $searchCriteria = "";
            if( $studentNameSearch != "" ){
                $searchCriteria .= " STUDENT NAME : <mark>" . $studentNameSearch . "</mark>";
            }
            
            if( $studentParentNameSearch != ""){
                if( $searchCriteria != "" ){
                    $searchCriteria .= ", PARENT NAME : <mark>" . $studentParentNameSearch . "</mark>"; 
                } else {
                    $searchCriteria .= " PARENT NAME : <mark>" . $studentParentNameSearch . "</mark>"; 
                }
            }
                
            if( $studentClassSearch != "" ){
                $classMap = array();
                $classMap[_ADMISSION_APPLY_PRE_KG] = "Pre-KG";
                $classMap[_ADMISSION_APPLY_LKG] = "LKG";
                $classMap[_ADMISSION_APPLY_UKG] = "UKG";
                $classMap[_ADMISSION_APPLY_CLASS_1] = "Class I";
                $classMap[_ADMISSION_APPLY_CLASS_2] = "Class II";
                $classMap[_ADMISSION_APPLY_CLASS_3] = "Class III";
                $classMap[_ADMISSION_APPLY_CLASS_4] = "Class IV";
                $classMap[_ADMISSION_APPLY_CLASS_5] = "Class V";
                $classMap[_ADMISSION_APPLY_CLASS_6] = "Class VI";
                $classMap[_ADMISSION_APPLY_CLASS_7] = "Class VII";
                $classMap[_ADMISSION_APPLY_CLASS_8] = "Class VIII";
                $classMap[_ADMISSION_APPLY_CLASS_9] = "Class IX";
                $classMap[_ADMISSION_APPLY_CLASS_10] = "Class X";
                $classMap[_ADMISSION_APPLY_CLASS_11] = "Class XI";
                $classMap[_ADMISSION_APPLY_CLASS_12] = "Class XII";
                $classMap[_ADMISSION_APPLY_PLAY_HOME] = "Play Home";
                
                $searchCriteria .= " CLASS : <mark>" .$classMap[$studentClassSearch] . "</mark>";
                if( $studentSectionSearch != "" ){
                    if( $searchCriteria != "" ){
                        $searchCriteria .= ", SECTION : <mark>" . $studentSectionSearch . "</mark>";
                    } else {
                        $searchCriteria .= " SECTION : <mark>" . $studentSectionSearch . "</mark>"; 
                    }
                    
                }
                if( $studentRollNoEntered != "" ){
                    if( $searchCriteria != "" ){
                        $searchCriteria .= ", ROLL NO. : <mark>" . $studentRollNoEntered . "</mark>";
                    } else {
                        $searchCriteria .= " ROLL NO. : <mark>" . $studentRollNoEntered . "</mark>";
                    }
                }
            }
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['students'] = $students;
            $displayData['classes'] = $classes;
            $displayData['studentSearchByClass'] = $studentClassSearch;
            $displayData['selectedSection'] = $studentSectionSearch;
            $displayData['studentNameEntered'] = $studentNameSearch;
            $displayData['studentParentNameEntered'] = $studentParentNameSearch;
            $displayData['studentRollNoEntered'] = $studentRollNoEntered;
            $displayData['searchCriteria'] = $searchCriteria;
            
            //$displayData['subjectList'] = $subjects;
            
            $this->load->view('students', $displayData);          
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function fetchAllStudents(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_TEACHER || $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $students = $this->schoolmodel->getAllStudents( $school_id );
            echo json_encode($students);
            return;
        } else if( $sessionUserData['user_type'] == _USER_TYPE_PARENT ){
            echo "false";
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo "false";
            return;
        }
    }
    
    public function fetchAllParents(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_TEACHER || $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $parents = $this->schoolmodel->getAllParents( $school_id );
            echo json_encode($parents);
            return;
        } else if( $sessionUserData['user_type'] == _USER_TYPE_PARENT ){
            echo "false";
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo "false";
            return;
        }
    }
    
    public function addStudent(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $school_id = '0';
            $first_name          = ( isset($_POST["addStudentFirstName"]) ? trim($_POST["addStudentFirstName"]) : "" );
            $middle_name         = ( isset($_POST["addStudentMiddleName"]) ? trim($_POST["addStudentMiddleName"]) : "" );
            $last_name           = ( isset($_POST["addStudentLastName"]) ? trim($_POST["addStudentLastName"]) : "" );
            $father_first_name   = ( isset($_POST["addFatherFirstName"]) ? trim($_POST["addFatherFirstName"]) : "" );
            $father_middle_name  = ( isset($_POST["addFatherMiddleName"]) ? trim($_POST["addFatherMiddleName"]) : "" );
            $father_last_name    = ( isset($_POST["addFatherLastName"]) ? trim($_POST["addFatherLastName"]) : "" );
            $mother_first_name   = ( isset($_POST["addMotherFirstName"]) ? trim($_POST["addMotherFirstName"]) : "" );
            $mother_middle_name  = ( isset($_POST["addMotherMiddleName"]) ? trim($_POST["addMotherMiddleName"]) : "" );
            $mother_last_name    = ( isset($_POST["addMotherLastName"]) ? trim($_POST["addMotherLastName"]) : "" );
            
            $father_email    = ( isset($_POST["addFatherEmail"]) ? trim($_POST["addFatherEmail"]) : "" );
            $mother_email   = ( isset($_POST["addMotherEmail"]) ? trim($_POST["addMotherEmail"]) : "" );
            $student_email  = ( isset($_POST["addStudentEmail"]) ? trim($_POST["addStudentEmail"]) : "" );
            
            $father_phone = ( isset($_POST["addStudentFatherPhone"]) ? trim($_POST["addStudentFatherPhone"]) : "" );
            $mother_phone = ( isset($_POST["addStudentMotherPhone"]) ? trim($_POST["addStudentMotherPhone"]) : "" );
            
            $student_class    = ( isset($_POST["addStudentClass"]) ? trim($_POST["addStudentClass"]) : "" );
            $student_section   = ( isset($_POST["addStudentSection"]) ? trim($_POST["addStudentSection"]) : "" );
            
            $student_roll  = ( isset($_POST["addStudentRoll"]) ? trim($_POST["addStudentRoll"]) : "" );
            $student_exam_roll  = ( isset($_POST["addExamRollNum"]) ? trim($_POST["addExamRollNum"]) : "" );
            
            $this->load->model('schoolmodel');
            $this->load->model('basicmodel');
            
            $student_user_name = $this->basicmodel->getValidUsername( $first_name, $last_name, $student_email );
            $father_user_name = $this->basicmodel->getValidUsername( $father_first_name, $father_last_name, $father_email );
            $mother_user_name = $this->basicmodel->getValidUsername( $mother_first_name, $mother_last_name, $mother_email );
            
            $added = $this->schoolmodel->validateAndInsertStudent( $school_id, $first_name, $middle_name, $last_name, $father_first_name, 
                                                $father_middle_name, $father_last_name, $mother_first_name, $mother_middle_name, 
                                                $mother_last_name, $father_email, $mother_email, $student_email, $father_phone,
                                                $mother_phone, $student_class, $student_section, $student_roll, $student_exam_roll,
                                                $student_user_name, $father_user_name, $mother_user_name );
            
            
            $classes = $this->schoolmodel->getClasses( $school_id );
            $classes = json_encode($classes);
            
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['students'] = array();
            $displayData['classes'] = $classes;
            
            if( !$added ){
                $message = "Unable to add student. Please try again.";
                $displayData['header_message'] = $message;
                $displayData['headerData'] = $headerData;
                $this->load->view('students', $displayData);
                return;
            } else {
                $message = "Student added successfully!!";
                $displayData['header_message'] = $message;
                $displayData['headerData'] = $headerData;
                $this->load->view('students', $displayData);
                return;
            }
            
            /*$displayData['studentSearchByClass'] = $studentClassSearch;
            $displayData['selectedSection'] = $studentSectionSearch;
            $displayData['studentNameEntered'] = $studentNameSearch;
            $displayData['studentParentNameEntered'] = $studentParentNameSearch;
            $displayData['studentRollNoEntered'] = $studentRollNoEntered;*/
            //$displayData['subjectList'] = $subjects;
            
            $this->load->view('students', $displayData); 
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function edit_school_tests(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            $classList = $this->schoolmodel->getClassListPlain( $school_id );
            $testDetails = $this->schoolmodel->getCompleteTestList( $school_id );
            
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['students'] = array();
            $displayData['classList'] = $classList;
            $displayData['testDetails'] = json_encode($testDetails);
            error_log("test det : \n" . $displayData['testDetails']  );
            $this->load->view('edit_school_tests', $displayData);
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function addSchoolTest(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $school_id = '0';
            $addTestName          = ( isset($_POST["addTestName"]) ? trim($_POST["addTestName"]) : "" );
            $addTestGradeType     = ( isset($_POST["addTestGradeType"]) ? trim($_POST["addTestGradeType"]) : "" );
            $addedClassTests      = ( isset($_POST["addedClassTests"]) ? trim($_POST["addedClassTests"]) : "" );
            $addTestFromDate      = ( isset($_POST["addTestFromDate"]) ? trim($_POST["addTestFromDate"]) : "" );
            $addTestToDate        = ( isset($_POST["addTestToDate"]) ? trim($_POST["addTestToDate"]) : "" );
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $this->load->model('schoolmodel');
            $inserted = $this->schoolmodel->addClassTest( $school_id, $addTestName, $addTestGradeType, $addedClassTests, 
                                                                $addTestFromDate, $addTestToDate);
            $classList = $this->schoolmodel->getClassListPlain( $school_id );
            $testDetails = $this->schoolmodel->getCompleteTestList( $school_id );
            
            if( $inserted != "true" ){
                $message_arr = explode("~~", $inserted);
                if( count($message_arr) > 1 ){
                    $message = trim($message_arr[1]);
                }
            }
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['students'] = array();
            $displayData['classList'] = $classList;
            $displayData['testDetails'] = json_encode($testDetails);
            error_log("test det : \n" . $displayData['testDetails']  );
            $this->load->view('edit_school_tests', $displayData);
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
        
    }
    
    public function editSchoolTest(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $school_id = '0';
            $editTestName          = ( isset($_POST["editTestName"]) ? trim($_POST["editTestName"]) : "" );
            $editTestGradeType     = ( isset($_POST["editTestGradeType"]) ? trim($_POST["editTestGradeType"]) : "" );
            $editTestFromDate      = ( isset($_POST["editTestFromDate"]) ? trim($_POST["editTestFromDate"]) : "" );
            $editTestToDate        = ( isset($_POST["editTestToDate"]) ? trim($_POST["editTestToDate"]) : "" );
            $editTestId            = ( isset($_POST["editTestId"]) ? trim($_POST["editTestId"]) : "" );
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $this->load->model('schoolmodel');
            $updated = $this->schoolmodel->editClassTest( $school_id, $editTestId, $editTestName, $editTestGradeType,  
                                                                $editTestFromDate, $editTestToDate );
            $classList = $this->schoolmodel->getClassListPlain( $school_id );
            $testDetails = $this->schoolmodel->getCompleteTestList( $school_id );
            
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['students'] = array();
            $displayData['classList'] = $classList;
            $displayData['testDetails'] = json_encode($testDetails);
            error_log("test det : \n" . $displayData['testDetails']  );
            $this->load->view('edit_school_tests', $displayData);
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
        
    }
    
    public function getTestDetails(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $school_id = '0';
            $test_id = ( isset($_POST["test_id"]) ? trim($_POST["test_id"]) : "" );
            $this->load->model('schoolmodel');
            $testDetails = $this->schoolmodel->getTestDetails( $school_id, $test_id );
            echo json_encode($testDetails);
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo "false";
            return;
        }
    }
    
    public function editSchoolTestDetail(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $school_id = '0';
            $editSubTestGradeType = ( isset($_POST["editSubTestGradeType"]) ? trim($_POST["editSubTestGradeType"]) : "" );
            $editSubTestDate = ( isset($_POST["editSubTestDate"]) ? trim($_POST["editSubTestDate"]) : "" );
            $editSubTestFromHour = ( isset($_POST["editSubTestFromHour"]) ? trim($_POST["editSubTestFromHour"]) : "" );
            $editSubTestFromMinute = ( isset($_POST["editSubTestFromMinute"]) ? trim($_POST["editSubTestFromMinute"]) : "" );
            $editSubTestFromAMPM = ( isset($_POST["editSubTestFromAMPM"]) ? trim($_POST["editSubTestFromAMPM"]) : "" );
            $editSubTestToHour = ( isset($_POST["editSubTestToHour"]) ? trim($_POST["editSubTestToHour"]) : "" );
            $editSubTestToMinute = ( isset($_POST["editSubTestToMinute"]) ? trim($_POST["editSubTestToMinute"]) : "" );
            $editSubTestToAMPM = ( isset($_POST["editSubTestToAMPM"]) ? trim($_POST["editSubTestToAMPM"]) : "" );
            $selectedTestId = ( isset($_POST["selectedTestId"]) ? trim($_POST["selectedTestId"]) : "" );
            $selectedSubjectId = ( isset($_POST["selectedSubjectId"]) ? trim($_POST["selectedSubjectId"]) : "" );
                        
            $this->load->model('schoolmodel');
            $edited = $this->schoolmodel->editTestDetails( $school_id, $selectedTestId, $selectedSubjectId, $editSubTestGradeType,
                                                    $editSubTestDate, $editSubTestFromHour, $editSubTestFromMinute, $editSubTestFromAMPM,
                                                    $editSubTestToHour, $editSubTestToMinute, $editSubTestToAMPM );
            
            echo json_encode($edited);
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function getScoreCardDetails(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            //get test names and test ids
            //get score cards of the student for each test and each subject within test
            //return the json
            
            $school_id = '0';
            $student_id = ( isset($_POST["student_id"]) ? trim($_POST["student_id"]) : "" );
            $this->load->model('schoolmodel');
            $testDetails = $this->schoolmodel->getStudentTestDetails( $school_id, $student_id );
            error_log( "test details : " . print_r($testDetails, true) );
            echo json_encode( $testDetails );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function school_class_forum(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $school_id = '0';
            $this->load->model('schoolmodel');
            $classList = $this->schoolmodel->getClassListPlain( $school_id );
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['students'] = array();
            $displayData['classList'] = $classList;
            $this->load->view('school_class_forum', $displayData);
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function addForumPost(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $pic_added = false;
            $school_id = '0';
            $displayData = array();
            $addForumPostText = ( isset($_POST["addForumPostText"]) ? trim($_POST["addForumPostText"]) : "" );
            $addedClasses = ( isset($_POST["addedClasses"]) ? trim($_POST["addedClasses"]) : "" );
            
            if( $addedClasses == "" ){
                $this->school_class_forum();
                return;
            }
            $this->load->model("schoolmodel");
            $classArray = $this->schoolmodel->getClassesFromIds( $school_id, $addedClasses );
            $classMap = $classArray['classMap'];
            $classes = $classArray['classes'];
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            $isValid['success'] = false;
            
            if( isset( $_FILES["addForumPostPic"] ) && isset($_FILES["addForumPostPic"]["error"])
                    && $_FILES["addForumPostPic"]["error"] == 0 ){
                $pic_added = true;
                $isValid = $this->validateImage( "addForumPostPic", _FORUM_IMAGE_MAX_SIZE );
            }
            $success = true;
            $post_type = _FORUM_ITEM_TYPE_TEXT;
            if( $pic_added ){
                $success = false;
                $post_type = _FORUM_ITEM_TYPE_PICTURE;
                if( $isValid['success'] ){
                    $timestamp = time();
                    $filename = $timestamp . '_' . $sessionUserData['user_id'] . ".jpg";
                    if( !file_exists(_FORUM_IMAGE_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME) ){
                        mkdir( _FORUM_IMAGE_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME, 0777, true );
                    }

                    if( !file_exists(_FORUM_IMAGE_S3_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME) ){
                        mkdir( _FORUM_IMAGE_S3_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME, 0777, true );
                    }
                    
                    $file = _FORUM_IMAGE_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME . '/' . $filename;
                    $file_s3 = _FORUM_IMAGE_S3_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME . '/' . $filename;
                    $image_size = $_FILES["addForumPostPic"]["size"];
                    $success = $this->compressAndSaveFile($_FILES['addForumPostPic']['tmp_name'], $image_size, $file, $file_s3);
                    
                    /* $compression_quality = $this->getCompressionLevel( $image_size );
                    $try_count = 3;
                    while( $try_count > 0 ){
                        $this->compress($_FILES['addForumPostPic']['tmp_name'], $file, $compression_quality, $file_s3);
                        if( file_exists($file) ){
                            $success = true;
                            break;
                        }
                        $try_count--;
                    } */
                } else {
                    $displayData['message']  = "Sorry!! Unable to upload the picture! " . $isValid['reason'];
                }
            }
            if( $pic_added && $success ){
                /*for( $i=0; $i < count($classes); $i++ ){
                    $cmd = 'cp ' . _FORUM_IMAGE_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME . '/' . $filename . ' ' .
                                    _FORUM_IMAGE_FOLDER . '/' . trim($classes[$i]) . '/' . $filename;
                    
                    exec( $cmd );
                }*/
                
                foreach( $classMap as $class_id => $details ){
                    //$classMap[$class_id]['pic_url'] = trim($details['class']) . '/' . $filename;
                    $classMap[$class_id]['pic_url'] = _SCHOOL_POST_PIC_UPLOAD_DIR_NAME . '/' . $filename;
                }
                
            }
            if( $pic_added && !$success ) {
                $displayData['header_message']  = "Sorry!! Unable to upload the picture! " . $isValid['reason'];
            }
            
            if( $pic_added && $success ) {
                $displayData['header_message']  = "Successfully added the post!";
            }
            
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $classList = $this->schoolmodel->getClassListPlain( $school_id );
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['students'] = array();
            $displayData['classList'] = $classList;
            
            $postAdded = false;
            if( $success ){
                $postAdded = $this->schoolmodel->insertSchoolPost( $school_id, $user_id, $post_type, $classMap, $addForumPostText );
            }
            
            if( $postAdded ){
                $displayData['header_message']  = "Successfully added the post!";
            } else {
                $displayData['header_message']  = "Sorry!! Unable to upload the picture! ";
            }
            $this->load->view('school_class_forum', $displayData);
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function validateImage( $filename, $file_max_size, $is_rest_upload=false ){
        $this->load->library('Logging');
        $allowed_image_types = array( "image/gif", "image/jpeg", "image/png", "image/pjpeg" );
        if( $is_rest_upload ){
            $allowed_image_types[] = "multipart/form-data";
        }
        $returnArray = array();
        if( !isset( $_FILES[$filename] ) ){
            $error = "No file uploaded";
            $this->logging->logError($error, __FILE__, __FUNCTION__, __LINE__, "");
            $returnArray['success'] = false;
            $returnArray['reason'] = $error;
            return $returnArray;
        }
        if ( $_FILES[$filename]["error"] > 0) {
            $error = $_FILES[$filename]["error"];
            $this->logging->logError($error, __FILE__, __FUNCTION__, __LINE__, "");
            $returnArray['success'] = false;
            $returnArray['reason'] = $error;
            return $returnArray;
    	}
        if( isset($_FILES[$filename] ) && isset( $_FILES[$filename]['tmp_name'] ) &&
                trim( $_FILES[$filename]['tmp_name'] ) != "" && isset( $_FILES[$filename]["type"] ) ){
            
            $this->logging->logError("exif img type : " . exif_imagetype($_FILES[$filename]['tmp_name']), 
                        __FILE__, __FUNCTION__, __LINE__, "");
            if( !( exif_imagetype($_FILES[$filename]['tmp_name']) > 0 ) 
                    || !in_array( $_FILES[$filename]["type"], $allowed_image_types ) ){
                
                $error_msg = "Invalid image type : " . $_FILES[$filename]["type"];
                $this->logging->logError($error_msg, __FILE__, __FUNCTION__, __LINE__, "");
                $returnArray['success'] = false;
                $returnArray['reason'] = $error_msg;
                return $returnArray;
            }
            
            if( isset($_FILES[$filename]["size"]) && $_FILES[$filename]["size"] > $file_max_size ){
                $error_msg = "Invalid image size : " . $_FILES[$filename]["size"];
                $this->logging->logError($error_msg, __FILE__, __FUNCTION__, __LINE__, "");
                $returnArray['success'] = false;
                $returnArray['reason'] = $error_msg;
                return $returnArray;
            }
            
            $returnArray['success'] = true;
            $returnArray['reason'] = "";
            return $returnArray;
        } else {
            $error_msg = "Invalid image size : " . $_FILES[$filename]["size"];
            $this->logging->logError($error_msg, __FILE__, __FUNCTION__, __LINE__, "");
            $returnArray['success'] = false;
            $returnArray['reason'] = $error_msg;
            return $returnArray;
        }
                
    }
    
    public function getCompressionLevel( $image_size ){
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
    
    public function compress($source, $file_server, $quality, $file_s3) {
        $info = getimagesize($source);
        if( $quality == _FORUM_IMAGE_COMPRESSION_QUALITY_LEVEL_0 ){
            error_log("compress : source - " . $source . " :: file_server - " . $file_server . " :: file_s3 - " . $file_s3);
            $saved = $this->saveFile($source, $file_server, $file_s3);
            return $saved;
        }
        
        error_log("compress :: comp qual - " . $quality);
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
        
        if(_USE_AWS_S3 && $saved !== TRUE ){
            unlink($file);
        }
        
        return $success;
    }
    
    private function getProfileMetaData( $sessionUserData, &$displayData, &$profile_page ){
        $headerData = array();
        
        $headerData['logged_in'] = $sessionUserData['logged_in'];
        $headerData['username'] = $sessionUserData['username'];
        $headerData['user_type'] = $sessionUserData['user_type'];
        $headerData['user_id'] = $sessionUserData['user_id'];
        
        $school_id = '0';
        $this->load->model('schoolmodel');
        $user_id = trim($sessionUserData['user_id']);
        $user_type = trim($sessionUserData['user_type']);
        if( $user_type == _USER_TYPE_SCHOOL ){
            $profileDetails = $this->schoolmodel->getSchoolLoginProfileDetails( $school_id, $user_id );
            $profile_page = 'school_profile';
        } else if( $user_type == _USER_TYPE_TEACHER ){
            $profileDetails = $this->schoolmodel->getTeacherProfileDetails( $school_id, $user_id );
        } else if( $user_type == _USER_TYPE_PARENT ){
            if( $profile_page != 'student_profile' ){
                $profile_page = 'parent_profile';
                $profileDetails = $this->schoolmodel->getParentProfileDetails( $school_id, $user_id );
            } else {
                $profileDetails = $this->schoolmodel->getStudentProfileDetails( $school_id, $user_id );
            }
            
        } else if( $user_type == _USER_TYPE_SCHOOL ){
            $profileDetails = array();
        }
        
        error_log("profile Details : " . print_r( $profileDetails, true ) );
        //$classList = $this->schoolmodel->getClassListPlain( $school_id );
        $displayData['headerData'] = $headerData;
        $displayData['user_type']  = $sessionUserData['user_type'];
        $displayData['user_id']  = $sessionUserData['user_id'];
        $displayData['profileDetails'] = $profileDetails;
        $displayData['students'] = array();
    }
    
    public function getPrivacySettings(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && ( $sessionUserData['user_type'] == _USER_TYPE_PARENT
                || $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ) ){
            
            $school_id = '0';
            $this->load->model('schoolmodel');
            $user_id = trim($sessionUserData['user_id']);
            $user_type = trim($sessionUserData['user_type']);
            $privacySettings = $this->schoolmodel->getPrivacySettings( $school_id, $user_id, $user_type );
            echo json_encode($privacySettings);
            return;
        } else {
            echo "false";
            return;
        }
    }
    
    public function changePrivacy(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && ( $sessionUserData['user_type'] == _USER_TYPE_PARENT
                || $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ) ){
            
            $school_id = '0';
            $this->load->model('schoolmodel');
            $user_id = trim($sessionUserData['user_id']);
            $user_type = trim($sessionUserData['user_type']);
            
            error_log("post values : " . print_r( $_POST, true ) );
            /* $privacySettings = $this->schoolmodel->getPrivacySettings( $school_id, $user_id, $user_type );
            echo json_encode($privacySettings); */
            return "true";
        } else {
            echo "false";
            return;
        }
    }
    
    public function showProfile(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && ( $sessionUserData['user_type'] == _USER_TYPE_PARENT
                || $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ) ){
            
            $displayData = array();
            $profile_page = 'profile';
            $this->getProfileMetaData( $sessionUserData, $displayData, $profile_page );
            /*$headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $school_id = '0';
            $this->load->model('schoolmodel');
            $user_id = trim($sessionUserData['user_id']);
            $user_type = trim($sessionUserData['user_type']);
            $profile_page = 'profile';
            if( $user_type == _USER_TYPE_TEACHER ){
                $profileDetails = $this->schoolmodel->getTeacherProfileDetails( $school_id, $user_id );
            } else if( $user_type == _USER_TYPE_PARENT ){
                $profile_page = 'parent_profile';
                $profileDetails = $this->schoolmodel->getParentProfileDetails( $school_id, $user_id );
            } else if( $user_type == _USER_TYPE_SCHOOL ){
                $profileDetails = array();
            }
            
            error_log("profile Details : " . print_r( $profileDetails, true ) );
            //$classList = $this->schoolmodel->getClassListPlain( $school_id );
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['profileDetails'] = $profileDetails;
            $displayData['students'] = array();*/
            $this->load->view($profile_page, $displayData);
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
    
    public function showStudentProfile(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_PARENT ) ){
            
            $displayData = array();
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $school_id = '0';
            $this->load->model('schoolmodel');
            $user_id = trim($sessionUserData['user_id']);
            $user_type = trim($sessionUserData['user_type']);
            
            $profileDetails = $this->schoolmodel->getStudentProfileDetails( $school_id, $user_id );
            
            //$classList = $this->schoolmodel->getClassListPlain( $school_id );
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['profileDetails'] = $profileDetails;
            $displayData['students'] = array();
            $this->load->view('student_profile', $displayData);
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
    
    public function saveProfileField(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && ( $sessionUserData['user_type'] == _USER_TYPE_PARENT
                || $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ) ){
            
            $school_id = '0';
            $user_type  = ( isset($_POST["user_type"] ) ? html_entity_decode(trim($_POST["user_type"])) : "" );
            $fieldName  = ( isset($_POST["fieldName"] ) ? html_entity_decode(trim($_POST["fieldName"])) : "" );
            $fieldValue  = ( isset($_POST["fieldValue"] ) ? html_entity_decode(trim($_POST["fieldValue"])) : "" );
            
            $this->load->model('schoolmodel');
            if( $user_type == 'school' ){
                $teacher_user_id = trim($sessionUserData['user_id']);
                $updated = $this->schoolmodel->updateSchoolProfileField( $school_id, $teacher_user_id, $fieldName, $fieldValue );
            }
            
            if( $user_type == 'teacher' ){
                $teacher_user_id = trim($sessionUserData['user_id']);
                $updated = $this->schoolmodel->updateTeacherProfileField( $school_id, $teacher_user_id, $fieldName, $fieldValue );
            }
            
            if( $user_type == 'parent' ){
                $parent_user_id = trim($sessionUserData['user_id']);
                $updated = $this->schoolmodel->updateParentProfileField( $school_id, $parent_user_id, $fieldName, $fieldValue );
            }
            
            if( $user_type == 'student' ){
                $parent_user_id = trim($sessionUserData['user_id']);
                $updated = $this->schoolmodel->updateStudentProfileField( $school_id, $parent_user_id, $fieldName, $fieldValue );
            }
            
            echo json_encode( $updated );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function uploadProPic(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && ( $sessionUserData['user_type'] == _USER_TYPE_PARENT
                || $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ) ){
            
            $upload_user_type = ( isset($_POST["upload_user_type"] ) ? html_entity_decode(trim($_POST["upload_user_type"])) : "" );
            $isValid = $this->validateImage( "uploadProPic", _PROFILE_PIC_MAX_SIZE );
            $success = false;
            if( $upload_user_type != "" && $isValid['success'] ){
                $school_id = '0';
                $user_id = $sessionUserData['user_id'];
                $user_type = $sessionUserData['user_type'];
                $this->load->model('schoolmodel');
                
                $timestamp = time();
                $filename = $timestamp . '_' . $sessionUserData['user_id'] . ".jpg";
                if( !file_exists(_PROFILE_PICTURE_FOLDER) ){
                    mkdir( _PROFILE_PICTURE_FOLDER, 0777, true );
                }

                if( !file_exists( _PROFILE_PICTURE_S3_FOLDER ) ){
                    mkdir( _PROFILE_PICTURE_S3_FOLDER, 0777, true );
                }
                    
                $file = _PROFILE_PICTURE_FOLDER . '/' . $filename;
                $file_s3 = _PROFILE_PICTURE_S3_FOLDER . '/' . $filename;
                $image_size = $_FILES["uploadProPic"]["size"];
                $success = $this->compressAndSaveFile($_FILES['uploadProPic']['tmp_name'], $image_size, $file, $file_s3);
                
                
                /*$compression_quality = $this->getCompressionLevel( $image_size );
                $try_count = 3;
                while( $try_count > 0 ){
                    $this->compress($_FILES['uploadProPic']['tmp_name'], $file, $compression_quality, $file_s3);
                    if( file_exists($file) ){
                        $success = true;
                        break;
                    }
                    $try_count--;
                }*/
            } 
            /*$headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $displayData['headerData'] = $headerData;
            $displayData['user_type'] = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];*/
            $displayData = array();
            $profile_page = 'profile';
            if( $success ){
                $pic_url = $filename;
                if( $upload_user_type == 'school' ){
                    $teacher_user_id = trim($sessionUserData['user_id']);
                    $profile_page = 'school_profile';
                    $fieldName = 'pic_url';
                    $fieldValue = $pic_url;
                    $updated = $this->schoolmodel->updateSchoolProfileField( $school_id, $teacher_user_id, $fieldName, $fieldValue );
                }
                if( $upload_user_type == 'teacher' ){
                    $teacher_user_id = trim($sessionUserData['user_id']);
                    $fieldName = 'pic_url';
                    $fieldValue = $pic_url;
                    $updated = $this->schoolmodel->updateTeacherProfileField( $school_id, $teacher_user_id, $fieldName, $fieldValue );
                }

                if( $upload_user_type == 'parent' ){
                    $parent_user_id = trim($sessionUserData['user_id']);
                    $profile_page = 'parent_profile';
                    $fieldName = 'pic_url';
                    $fieldValue = $pic_url;
                    $updated = $this->schoolmodel->updateParentProfileField( $school_id, $parent_user_id, $fieldName, $fieldValue );
                }

                if( $upload_user_type == 'student' ){
                    $parent_user_id = trim($sessionUserData['user_id']);
                    $profile_page = 'student_profile';
                    $fieldName = 'pic_url';
                    $fieldValue = $pic_url;
                    $updated = $this->schoolmodel->updateStudentProfileField( $school_id, $parent_user_id, $fieldName, $fieldValue );
                }
                if( !$updated ){
                    $displayData['message']  = "Sorry!! Unable to upload the picture! ";
                }
            } else {
                $displayData['message']  = "Sorry!! Unable to upload the picture! " . $isValid['reason'];
            }
            $this->getProfileMetaData( $sessionUserData, $displayData, $profile_page );
            $this->load->view( $profile_page, $displayData );
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function saveBulkEdit(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && ( $sessionUserData['user_type'] == _USER_TYPE_PARENT
                || $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ) ){
            
            $user_type  = ( isset($_POST["user_type"] ) ? html_entity_decode(trim($_POST["user_type"])) : "" );
            $fieldArray = array();
            for( $i=1; $i <= _TEACHER_HOBBY_ACHIEVEMENT_COUNT; $i++ ){
                $fieldName  = ( isset($_POST["fieldName" . $i] ) ? trim($_POST["fieldName" . $i]) : "" );
                $fieldValue  = ( isset($_POST["fieldValue" . $i] ) ? html_entity_decode(trim($_POST["fieldValue" . $i])) : "" );
                if( $fieldName != "" && $fieldValue != "" ){
                    $fieldArray[$fieldName] = $fieldValue;
                }
            }
            $school_id = '0';
            $teacher_user_id = $sessionUserData['user_id'];
            $this->load->model("schoolmodel");
            
            if( $user_type == 'school' ){
                $teacher_user_id = trim($sessionUserData['user_id']);
                $saved = $this->schoolmodel->saveSchoolBulkEdit( $school_id, $teacher_user_id, $fieldArray );
            }
            
            if( $user_type == 'teacher' ){
                $teacher_user_id = trim($sessionUserData['user_id']);
                $saved = $this->schoolmodel->saveTeacherBulkEdit( $school_id, $teacher_user_id, $fieldArray );
            }
            
            /*if( $user_type == 'parent' ){
                $parent_user_id = trim($sessionUserData['user_id']);
                $saved = $this->schoolmodel->saveBulkEdit( $school_id, $teacher_user_id, $fieldArray );
            }
             * 
             */
            
            if( $user_type == 'student' ){
                $parent_user_id = trim($sessionUserData['user_id']);
                $saved = $this->schoolmodel->saveStudentBulkEdit( $school_id, $parent_user_id, $fieldArray );
            }
            
            echo json_encode( $saved );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function saveProfileDate(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && ( $sessionUserData['user_type'] == _USER_TYPE_PARENT
                || $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ) ){
            
            $user_type  = ( isset($_POST["user_type"] ) ? html_entity_decode(trim($_POST["user_type"])) : "" );
            $fieldName  = ( isset($_POST["fieldName"] ) ? trim($_POST["fieldName"]) : "" );
            $fieldValue  = ( isset($_POST["fieldValue"] ) ? html_entity_decode(trim($_POST["fieldValue"])) : "" );
                
            $date = DateTime::createFromFormat('j-M-Y', $fieldValue);
            $date_desc = $date->format( 'Y-m-d' );
            $school_id = '0';
            
            $this->load->model("schoolmodel");
            if( $user_type == 'school' ){
                $teacher_user_id = trim($sessionUserData['user_id']);
                $updated = $this->schoolmodel->updateSchoolProfileField( $school_id, $teacher_user_id, $fieldName, $date_desc );
            }
            
            if( $user_type == 'teacher' ){
                $teacher_user_id = trim($sessionUserData['user_id']);
                $updated = $this->schoolmodel->updateTeacherProfileField( $school_id, $teacher_user_id, $fieldName, $date_desc );
            }
            
            if( $user_type == 'parent' ){
                $parent_user_id = trim($sessionUserData['user_id']);
                $updated = $this->schoolmodel->updateParentProfileField( $school_id, $parent_user_id, $fieldName, $date_desc );
            }
            
            if( $user_type == 'student' ){
                $parent_user_id = trim($sessionUserData['user_id']);
                $updated = $this->schoolmodel->updateStudentProfileField( $school_id, $parent_user_id, $fieldName, $date_desc );
            }
            
            echo json_encode( $updated );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function changePassword(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && ($sessionUserData['user_type'] == _USER_TYPE_TEACHER 
                        || $sessionUserData['user_type'] == _USER_TYPE_PARENT || $sessionUserData['user_type'] == _USER_TYPE_SCHOOL )) ){
            
            $oldPassword      = ( isset($_POST["oldPassword"] ) ? html_entity_decode(trim($_POST["oldPassword"])) : "" );
            $newPassword      = ( isset($_POST["newPassword"] ) ? html_entity_decode(trim($_POST["newPassword"])) : "" );
            $confirmPassword  = ( isset($_POST["confirmPassword"] ) ? html_entity_decode(trim($_POST["confirmPassword"])) : "" );
            
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            
            if( $oldPassword == "" ){
                echo "false~~Please enter the old password";
                return;
            }
            if( $newPassword == "" ){
                echo "false~~Please enter the new password";
                return;
            }
            if( $confirmPassword == "" ){
                echo "false~~Please enter the new password again";
                return;
            }
            
            if( $newPassword != $confirmPassword ){
                echo "false~~The new password and the confirmed password do not match";
                return;
            }
            
            $this->load->model("schoolmodel");
            $changed = $this->schoolmodel->changePassword( $school_id, $user_id, $oldPassword, $newPassword, false );
            echo $changed;
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo "false";
            return;
        }
    }
    
    public function getClassStudents(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $class_id      = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $school_id = '0';
            $this->load->model('schoolmodel');
            $studentList = $this->schoolmodel->getClassStudentList( $school_id, $class_id );
            echo json_encode( $studentList );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function fetchSchoolForumItems(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        $session_id = session_id();
        error_log("fetchSchoolForumItems session id " . $session_id );
        $this->load->library('Logging');
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] ==  _USER_TYPE_TEACHER ) ){
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = trim($sessionUserData['user_type']);
            $to_time  = ( isset($_POST["to_time"] ) ? trim($_POST["to_time"]) : "" );
            if( $to_time == "" ){
                $to_time = time();
            }
            //$class_id = $this->parentmodel->getParentClassId( $school_id, $user_id );
            $fetch_fwd = "false";
            $forum_feed = $this->schoolmodel->getSchoolFeed( $school_id, $user_id, _FEED_FETCH_BY_USER_ID, $user_type, $to_time, 
                                                        _FORUM_PAGE_FEED_SIZE, _FORUM_DEFAULT_COMMENT_SIZE, _FEED_LONG_PARAMS, $fetch_fwd );
            echo json_encode( $forum_feed );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function addTextPostSchool(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            $text  = ( isset($_POST["text"] ) ? html_entity_decode(trim($_POST["text"])) : "" );
            $post_type = _FORUM_ITEM_TYPE_TEXT;
            $item_id = $this->schoolmodel->addSchoolForumPost( $school_id, $text, $post_type, $user_id, $user_type );
            $time = time() + 10000;
            $fetch_fwd = "false";
            $forum_feed = $this->schoolmodel->getSchoolFeed( $school_id, $user_id, _FEED_FETCH_BY_USER_ID, $user_type, $time, 
                                                    _FORUM_PAGE_FEED_SIZE, _FORUM_DEFAULT_COMMENT_SIZE, _FEED_LONG_PARAMS, $fetch_fwd );
            echo json_encode($forum_feed);
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function postSchoolComment(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            $comment  = ( isset($_POST["comment"] ) ? html_entity_decode(trim($_POST["comment"])) : "" );
            $item_id  = ( isset($_POST["item_id"] ) ? trim($_POST["item_id"]) : "" );
            
            $added = $this->schoolmodel->addSchoolComment( $school_id, $user_id, $user_type, $item_id, $comment );
            echo json_encode( $added );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function getSchoolFeedDetails(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $item_id  = ( isset($_POST["item_id"] ) ? trim($_POST["item_id"]) : "" );
            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            
            $feedDetails = $this->schoolmodel->getSchoolFeedDetails( $school_id, $user_id, $item_id );
            echo json_encode( $feedDetails );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function fetchSchoolComments(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $item_id  = ( isset($_POST["item_id"] ) ? trim($_POST["item_id"]) : "" );
            $comment_id  = ( isset($_POST["comment_id"] ) ? trim($_POST["comment_id"]) : "" );
            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            
            $feedComments = $this->schoolmodel->getSchoolFeedComments( $school_id, $user_id, $item_id, 
                                                    $comment_id, _FORUM_DEFAULT_COMMENT_DETAIL_SIZE, _FEED_LONG_PARAMS );
            echo json_encode( $feedComments );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function deleteSchoolPost(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $item_id  = ( isset($_POST["item_id"] ) ? trim($_POST["item_id"]) : "" );
            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            
            $deleted = $this->schoolmodel->deleteSchoolPost( $school_id, $user_id, $item_id );
            //$class_id = $this->schoolmodel->getParentClassId( $school_id, $user_id );
            $to_time = time() + 10000;
            $fetch_fwd = "false";
            $forum_feed = $this->schoolmodel->getSchoolFeed( $school_id, $user_id, _FEED_FETCH_BY_USER_ID, $user_type, $to_time, 
                                                    _FORUM_PAGE_FEED_SIZE, _FORUM_DEFAULT_COMMENT_SIZE, _FEED_LONG_PARAMS, $fetch_fwd );
            echo json_encode( $forum_feed );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function deleteSchoolComment(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $item_id  = ( isset($_POST["item_id"] ) ? trim($_POST["item_id"]) : "" );
            $comment_id  = ( isset($_POST["comment_id"] ) ? trim($_POST["comment_id"]) : "" );
            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            
            $deleted = $this->schoolmodel->deleteSchoolComment( $school_id, $user_id, $item_id, $comment_id );
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
    
    public function uploadSchoolFeedImage(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $isValid['success'] = false;
            $isValid['reason'] = "Invalid upload";
            if( isset( $_FILES["uploadFeedPic"] ) && isset($_FILES["uploadFeedPic"]["error"])
                    && $_FILES["uploadFeedPic"]["error"] == 0 ){
                $isValid = $this->validateImage( "uploadFeedPic", _FORUM_IMAGE_MAX_SIZE );
            }
            $success = false;
            if( $isValid['success'] ){
                $school_id = '0';
                $user_id = $sessionUserData['user_id'];
                $user_type = $sessionUserData['user_type'];
                $this->load->model('schoolmodel');//_SCHOOL_POST_PIC_UPLOAD_DIR_NAME
                
                $timestamp = time();
                $filename = $timestamp . '_' . $sessionUserData['user_id'] . ".jpg";
                
                //$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
                //$file = $DOC_ROOT . _GENERAL_NOTIFICATION_IMAGE_FOLDER . '/' . $filename;
                if( !file_exists(_FORUM_IMAGE_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME) ){
                    mkdir( _FORUM_IMAGE_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME, 0777, true );
                }

                if( !file_exists( _FORUM_IMAGE_S3_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME ) ){
                    mkdir( _FORUM_IMAGE_S3_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME, 0777, true );
                }
                
                $file = _FORUM_IMAGE_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME . '/' . $filename;
                $file_s3 = _FORUM_IMAGE_S3_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME . '/' . $filename;
                $image_size = $_FILES["uploadFeedPic"]["size"];
                $success = $this->compressAndSaveFile($_FILES['uploadFeedPic']['tmp_name'], $image_size, $file, $file_s3);
                /*
                $compression_quality = $this->getCompressionLevel( $image_size );
                $try_count = 3;
                while( $try_count > 0 ){
                    $this->compress($_FILES['uploadFeedPic']['tmp_name'], $file, $compression_quality, $file_s3);
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
            
            if( $success ){
                $caption_text = ( isset($_POST["uploadPicText"] ) ? trim($_POST["uploadPicText"]) : "" );
                $post_type = _FORUM_ITEM_TYPE_PICTURE;
                $pic_url = _SCHOOL_POST_PIC_UPLOAD_DIR_NAME . "/" . $filename;
                $this->schoolmodel->insertSchoolPicturePost( $school_id, $user_id, $user_type, $post_type, $pic_url, $caption_text );
            } else {
                $displayData['message']  = "Sorry!! Unable to upload the picture! " . $isValid['reason'];
            }
            $this->load->view( 'school_home', $displayData );
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function fetchTeacherDetails(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || 
                    $sessionUserData['user_type'] == _USER_TYPE_TEACHER || $sessionUserData['user_type'] ==  _USER_TYPE_PARENT ) ){
            
            $teacher_id  = ( isset($_POST["teacher_id"] ) ? trim($_POST["teacher_id"]) : "" );
            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            
            $teacherProfileDetails = $this->schoolmodel->getTeacherProfileDetailsByTid( $school_id, $teacher_id );
            $teacherTimeTable = $this->schoolmodel->getTeacherTimeTable( $school_id, $teacher_id );
            
            $returnArray = array( "teacherProfileDetails" => $teacherProfileDetails,
                                  "teacherTimeTable" => $teacherTimeTable );
            
            echo json_encode( $returnArray );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function fetchStudentDetails(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || 
                    $sessionUserData['user_type'] == _USER_TYPE_TEACHER || $sessionUserData['user_type'] ==  _USER_TYPE_PARENT ) ){
                    
            $student_id  = ( isset($_POST["student_id"] ) ? trim($_POST["student_id"]) : "" );
            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            
            $studentAndParentDetails = $this->schoolmodel->getStudentAndParentDetails( $school_id, $student_id );
            $studentSCDetails = array();
            if(  $sessionUserData['user_type'] !=  _USER_TYPE_PARENT ){
                $studentSCDetails = $this->schoolmodel->getStudentTestDetails( $school_id, $student_id );
            }
            
            $returnArray = array( "studentAndParentDetails" => $studentAndParentDetails,
                                  "studentSCDetails" => $studentSCDetails );
            
            echo json_encode( $returnArray );
            return;
            
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function fetchSchoolNotifications(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            
            $schoolNotifications = $this->schoolmodel->getSchoolNotifications( $school_id );
            
            echo json_encode( $schoolNotifications );
            return;
            
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function fetchClassNotifications(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_PARENT || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            $class_id = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $user_type = $sessionUserData['user_type'];
            $user_id = $sessionUserData['user_id'];
            if( $user_type == _USER_TYPE_PARENT ){
                $schoolNotifications = $this->schoolmodel->getClassNotificationsById( $school_id, $user_id );
            } else {
                $schoolNotifications = $this->schoolmodel->getClassNotifications( $school_id, $class_id );
            }
            
            echo json_encode( $schoolNotifications );
            return;
            
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function lastUpdatedREST(){
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            error_log("in lastupdated err");
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
	error_log( "req params : " . print_r( $requestParams, true ) . "\n" );        
        if( $requestParams ){
            $school_id = '0';
            $table_id = '0';
            
            $parameters = $requestParams['data'];
            error_log( " params : " . print_r( $parameters, true ) );
            if( array_key_exists( 'data_id', $parameters) && is_string( $parameters['data_id'] ) ){
                $table_id = trim( $parameters['data_id'] );
            }
       
	    error_log( "table_id : " . $table_id );
     
            $this->load->model( 'schoolmodel' );
            $lastUpdated = $this->schoolmodel->getUpdatedTimestamp( $school_id, $table_id );
            
            error_log( "lastUpdated  :  " . json_encode($lastUpdated) );
            $this->restutilities->sendResponse( 200, 
                    '{"success": "true", "updated_timestamp": ' . json_encode($lastUpdated) . ' }' );
            return;
        }
    }
    
    public function getClassSubjectsREST(){
        error_log("in getClassSubjectsREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            error_log("in lastupdated err");
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        error_log( "req params : " . print_r( $requestParams, true ) . "\n" );        
        if( $requestParams ){
            $school_id = '0';
            $parameters = $requestParams['data'];
     
            $this->load->model( 'schoolmodel' );
            $classSubjects = $this->schoolmodel->getClassSubjectsComplete( $school_id );            
            $updated_timestamp = $this->schoolmodel->getUpdatedTimestamp( $school_id, _CLASS_SUBJECTS_TABLE_ID );
            $updated_timestamp = $updated_timestamp[0]['update_timestamp'];
            $this->restutilities->sendResponse( 200, 
                    '{"success": "true", "updated_timestamp": "' . $updated_timestamp . '", "class_subjects": ' . json_encode($classSubjects) . ' }' );
            return;
        }
    }
    
    public function createClassMetaTextDump(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_ADMIN ) ){
            $school_id = '0';
            $this->load->model('schoolmodel');
            $class_meta_data = $this->schoolmodel->getClassMetaData( $school_id );
            $query_str = "";
            for( $i=0; $i < count($class_meta_data); $i++ ){
                $query_str .= "SELECT " . trim($class_meta_data[$i]['class_id']) . ", '" . trim($class_meta_data[$i]['class_desc']) . "', '";
                $query_str .= trim($class_meta_data[$i]['class_desc_short']) . "' ";
                if( $i < count($class_meta_data) - 1 ){
                    $query_str .= " UNION ALL ";
                } 
            }

            $file = fopen( _DUMP_FILE_PATH . _CLASS_META_TABLE_DUMP_FILE, "w" ) or die ("createClassMetaTextDump : Unable to open file ");
            fwrite( $file, $query_str );
            fclose( $file );
            echo "success";
            return;
        }
        echo "failed";
        return;
    }
    
    public function createClassTextDump(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_ADMIN ) ){
            $school_id = '0';
            $this->load->model('schoolmodel');
            $subject_data = $this->schoolmodel->getClassData( $school_id );//class_id, class, section 
            $query_str = "";
            for( $i=0; $i < count($subject_data); $i++ ){
                $query_str .= "SELECT " . trim($subject_data[$i]['class_id']) . ", '" . trim($subject_data[$i]['class']) 
                                . "', '" . trim($subject_data[$i]['section']) . "' ";

                if( $i < count($subject_data) - 1 ){
                    $query_str .= " UNION ALL ";
                } 
            }

            $file = fopen( _DUMP_FILE_PATH . _CLASS_TABLE_DUMP_FILE, "w" ) or die ("createClassTextDump : Unable to open file ");
            fwrite( $file, $query_str );
            fclose( $file );
            echo "success";
            return;
        }
                
        echo "failed";
    }
    
    public function createSubjectTextDump(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                &&( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_ADMIN ) ){
            $school_id = '0';
            $this->load->model('schoolmodel');
            $subject_data = $this->schoolmodel->getSubjectData( $school_id );
            $query_str = "";
            for( $i=0; $i < count($subject_data); $i++ ){
                $query_str .= "SELECT " . trim($subject_data[$i]['subject_id']) . ", '" . trim($subject_data[$i]['subject_name']) 
                                . "', '" . trim($subject_data[$i]['subject_short']) . "' ";

                if( $i < count($subject_data) - 1 ){
                    $query_str .= " UNION ALL ";
                } 
            }

            $file = fopen( _DUMP_FILE_PATH . _SUBJECTS_TABLE_DUMP_FILE, "w" ) or die ("createSubjectTextDump : Unable to open file ");
            fwrite( $file, $query_str );
            fclose( $file );
            echo "success";
            return;
        }
        echo "failed";
    }
    
    public function getRequestSessionID(){
        $headers = getallheaders();
        
    }
    
    public function validateLoginREST(){
        error_log("in validateLoginREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        error_log( "req params : " . print_r( $requestParams, true ) . "\n" );        
        if( $requestParams ){
            $school_id = '0';
            $parameters = $requestParams['data'];
            if( array_key_exists( 'username', $parameters) && is_string( $parameters['username'] ) ){
                $username = trim( $parameters['username'] );
            }
            
            if( array_key_exists( 'password', $parameters) && is_string( $parameters['password'] ) ){
                $password = trim( $parameters['password'] );
            }
            
            $this->load->model( 'basicmodel' );
            $user_details = array();
            $valid = $this->basicmodel->authenticateREST( $username, $password, $user_details );
            error_log( "user_details : " . print_r($user_details, true) );
            $is_valid = "false";
            if( $valid == 1 ){
                $is_valid = "true";
            } else {
                $this->restutilities->sendResponse( 200, 
                    '{"success": "false"}');
                return;
            }
            
            $current_timestamp = time();
            $session_expiry = trim($user_details['session_expiry']);
            $session_id = trim($user_details['session_id']);
            
            if( _MEMCACHE_ENABLED ){
                $memcache = new MemcacheLibrary();
            }
            
            if( $session_expiry == '0' || trim($user_details['session_id']) == '' || 
                    $current_timestamp > $session_expiry - _USER_SESSION_EXPIRY_CHECK_PERIOD ){
                $session_id = $this->basicmodel->generateAndInsertSessionID( $school_id, $username, $current_timestamp );
                $session_expiry = $current_timestamp + ( _USER_SESSION_EXPIRY_PERIOD * _ONE_DAY_SECONDS );
                if( _MEMCACHE_ENABLED ){
                    $session_user_id_key = _SESSION_KEY_PREFIX . $session_id . "_" . _MEMCACHE_SESSIONS_USER_ID;
                    
                    $session_session_expiry_key = _SESSION_KEY_PREFIX . $session_id . "_" . _MEMCACHE_SESSIONS_SESSION_EXPIRY;
                    
                    $session_school_id_key = _SESSION_KEY_PREFIX . $session_id . "_" . _MEMCACHE_SESSIONS_SCHOOL_ID;
                    ///_MEMCACHE_SESSIONS_SCHOOL_ID
                    
                    $session_id_key = _USERS_KEY_PREFIX .  $school_id . "_" . trim($user_details['user_id']) .
                                        "_" . _MEMCACHE_USERS_SESSION_ID;
                    
                    $session_expiry_key = _USERS_KEY_PREFIX .  $school_id . "_" . trim($user_details['user_id']) .
                                        "_" . _MEMCACHE_USERS_SESSION_EXPIRY;
                    
                    $memcache->deleteKey($session_user_id_key);
                    $memcache->deleteKey($session_session_expiry_key);
                    $memcache->deleteKey($session_school_id_key);
                    $memcache->deleteKey($session_id_key);
                    $memcache->deleteKey($session_expiry_key);
                    
                    $memcache->setKey($session_user_id_key, trim($user_details['user_id']));
                    $memcache->setKey($session_session_expiry_key, $session_expiry);
                    $memcache->setKey($session_school_id_key, $school_id);
                    $memcache->setKey($session_id_key, $session_id);
                    $memcache->setKey($session_expiry_key, $session_expiry);
                }
            }
            
            $success = "false";
            if( $session_id != "" ){
                $success = "true";
            }
            $this->load->library('session');
            $sessionUserData['user_id'] = $user_details['user_id'];
            $sessionUserData['username'] = $user_details['username'];               
            $sessionUserData['user_type'] = $user_details['user_type'];              
            $sessionUserData['last_login'] = $user_details['last_login'];             
            $sessionUserData['last_login_ip'] = $user_details['last_login_ip'];          
            $sessionUserData['init_password_changed'] = $user_details['init_password_changed']; 
            $sessionUserData['logged_in'] = true;
            
            $class_id = "";
            $student_id = "";
            if( trim($user_details['user_type']) == _USER_TYPE_PARENT ){
                if( _MEMCACHE_ENABLED ){
                    $memcache = new MemcacheLibrary();
                    $user_key = _USERS_KEY_PREFIX . $school_id . "_" . trim($user_details['user_id']) .
                                        "_" . _MEMCACHE_USERS_ID;
                    
                    $parent_id = $memcache->getKey($user_key);
                    if( $parent_id != null && $parent_id != FALSE ){
                        $parent_class_key = _PARENTS_KEY_PREFIX . $school_id . "_" . $parent_id .
                                                "_" . _MEMCACHE_PARENTS_CLASS_ID;
                        
                        $parent_student_id_key = _PARENTS_KEY_PREFIX . $school_id . "_" . $parent_id .
                                                    "_" . _MEMCACHE_PARENTS_STUDENT_ID;
                        
                        $class_id = $memcache->getKey($parent_class_key);
                        $student_id = $memcache->getKey($parent_student_id_key);
                    }
                } 
                
                if( $class_id == FALSE || $class_id == "" || $student_id == FALSE || $student_id == "" ){
                    $this->load->model("parentmodel");
                    $result = $this->parentmodel->getParentClassId( $school_id, trim($user_details['user_id']) );
                    $class_id = trim($result['class_id']);
                    $student_id = trim($result['student_id']);
                }
            }
            
            error_log( "resp : " . '{"success": "' . $success . '", "session_id": "' . $session_id . '", "session_expiry": "' . $session_expiry . 
                    '", "current_server_time": "' . $current_timestamp . '", "is_valid": "' . $is_valid . 
                    '", "user_id": "' . $user_details['user_id'] . '", "user_type": "' . $user_details['user_type'] . 
                    '", "class_id": "' . $class_id . '", "student_id" : "' . $student_id . '" }' );
            
            //$session_expiry = "0";
            $this->restutilities->sendResponse( 200, 
                    '{"success": "' . $success . '", "session_id": "' . $session_id . '", "session_expiry": "' . $session_expiry . 
                    '", "current_server_time": "' . $current_timestamp . '", "is_valid": "' . $is_valid . 
                    '", "user_id": "' . $user_details['user_id'] . '", "user_type": "' . $user_details['user_type'] . 
                    '", "class_id": "' . $class_id . '", "student_id" : "' . $student_id . 
                    '", "token" : "' .  $user_details['token'] . '" }' );
            return;
        }
    }
    
    public function fetchTeacherDetailsREST(){
        error_log("in validateLoginREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        error_log( "fetchTeacherDetailsREST req headers : " . print_r( $request_headers, true ) . "\n" );
        error_log( "fetchTeacherDetailsREST req params : " . print_r( $requestParams, true ) . "\n" );        
        if( $requestParams ){
            $school_id = '0';
            $parameters = $requestParams['data'];
            $success = "false";
            $teacherProfileDetails = array();
            //$teacherTimeTable = array();
            if( array_key_exists( 'teacher_id', $parameters) && is_string( $parameters['teacher_id'] ) ){
                $teacher_id = trim( $parameters['teacher_id'] );
                $this->load->model('schoolmodel');
                $teacherProfileDetails = $this->schoolmodel->getTeacherProfileDetailsByTid( $school_id, $teacher_id );
                error_log( "teacherProfileDetails : " . print_r($teacherProfileDetails, true));
                //$teacherTimeTable = $this->schoolmodel->getTeacherTimeTable( $school_id, $teacher_id );
                $success = "true";
            }
            
            $this->restutilities->sendResponse( 200, 
                    '{"success": "' . $success . '", "teacherProfileDetails": ' . json_encode($teacherProfileDetails) . ' }' );
            return;
            
        }
    }
    
    public function fetchTeacherTTREST(){
        error_log("in validateLoginREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        error_log( "req params : " . print_r( $requestParams, true ) . "\n" );        
        if( $requestParams ){
            $school_id = '0';
            $parameters = $requestParams['data'];
            $success = "false";
            //$teacherProfileDetails = array();
            $teacherTimeTable = array();
            if( array_key_exists( 'teacher_id', $parameters) && is_string( $parameters['teacher_id'] ) ){
                $teacher_id = trim( $parameters['teacher_id'] );
                $this->load->model('schoolmodel');
                //$teacherProfileDetails = $this->schoolmodel->getTeacherProfileDetailsByTid( $school_id, $teacher_id );
                $teacherTimeTable = $this->schoolmodel->getTeacherTimeTableShort( $school_id, $teacher_id, false );
                $success = "true";
            }
            
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $success . '", "hasChanged" : "true", "teacherTimeTable": ' 
                                . json_encode($teacherTimeTable) . ' }' );
            return;
            
        }
    }
    
    public function fetchSchoolFeedREST(){
        error_log("in fetchSchoolFeedREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( $requestParams ){
            $school_id = '0';
            $parameters = $requestParams['data'];
            $success = "true";
            $forum_feed = '{ "fi" : [], "l" : "0", "f" : "0" }';
            /*if( array_key_exists( 'username', $parameters) && array_key_exists( 'last_timestamp', $parameters ) 
                    && is_string( $parameters['username'] ) && is_string( $parameters['last_timestamp'] ) ){*/
            if( array_key_exists( 'last_timestamp', $parameters ) && is_string( $parameters['last_timestamp'] ) ){
                $last_timestamp = trim( $parameters['last_timestamp'] );
                $fetch_fwd = "false";
                if( array_key_exists( 'fetch_fwd', $parameters ) && is_string( $parameters['fetch_fwd'] ) ){
                    $fetch_fwd = trim( $parameters['fetch_fwd'] );
                }
                if( $last_timestamp == "" || $last_timestamp == "0" ){
                    $last_timestamp = time();
                }
                
                if( $last_timestamp == "-1" ){
                    $last_timestamp ="0";
                }
                
                $user_id = trim( $user_details['user_id'] );
                $user_type = trim( $user_details['user_type'] );
                if( $user_type != _USER_TYPE_SCHOOL && $user_type != _USER_TYPE_TEACHER ){
                    $this->restutilities->sendResponse( 200,    
                        '{"success": "false" }' );
                    return;
                }
                
                $this->load->model('schoolmodel');
                /* $forum_feed = $this->schoolmodel->getSchoolFeed( $school_id, $username, _FEED_FETCH_BY_USER_NAME, $user_type, $last_timestamp, 
                                                            _FORUM_PAGE_FEED_SIZE, _FORUM_DEFAULT_COMMENT_SIZE, _FEED_SHORT_PARAMS, $fetch_fwd ); */
                
                $forum_feed = $this->schoolmodel->getSchoolFeed( $school_id, $user_id, _FEED_FETCH_BY_USER_ID, $user_type, $last_timestamp, 
                                                            _FORUM_PAGE_FEED_SIZE, _FORUM_DEFAULT_COMMENT_SIZE, _FEED_SHORT_PARAMS, $fetch_fwd );
                
                if( count($forum_feed) == 0 ){
                    $forum_feed = '{ "fi" : [], "l" : "' . $last_timestamp . '", "f" : "' . $last_timestamp . '" }';
                } else {
                    $forum_feed = json_encode( $forum_feed );
                }
                //echo json_encode( $forum_feed );
                error_log( "forum_feed : " . $forum_feed );
            }
            
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $success . '", "school_feed": ' . $forum_feed . ' }' );
            return;
            
        }
    }
    
    public function deleteSchoolPostREST(){
        
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim( $user_details['user_id'] );
        $parameters = $requestParams['data'];
        if( array_key_exists( 'item_id', $parameters) && is_string( $parameters['item_id'] ) ){
            $item_id = trim( $parameters['item_id'] );
            error_log( "item_id : " . $parameters['item_id'] );
            $this->load->model('schoolmodel');
            $deleted = $this->schoolmodel->deleteSchoolPost( $school_id, $user_id, $item_id );
            if( $deleted ){
                $deleted = "true";
            } else {
                $deleted = "false";
            }
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $deleted . '", "item_id": "' . $item_id . '" }' );
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function deleteSFCommentREST(){        
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim( $user_details['user_id'] );
        $parameters = $requestParams['data'];
        if( array_key_exists( 'comment_id', $parameters) && is_string( $parameters['comment_id'] ) && 
                array_key_exists( 'item_id', $parameters) && is_string( $parameters['item_id'] ) ){
            $comment_id = trim( $parameters['comment_id'] );
            $item_id = trim( $parameters['item_id'] );
            error_log( "comment_id : " . $parameters['comment_id'] . " :: item_id : " . $parameters['item_id'] );
            $this->load->model('schoolmodel');
            $deleted = $this->schoolmodel->deleteSchoolComment( $school_id, $user_id, $item_id, $comment_id );
            if( $deleted ){
                $deleted = "true";
            } else {
                $deleted = "false";
            }
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $deleted . '", "comment_id": "' . $comment_id . '" }' );
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function getUserDetailsFromSessionID($session_id){
        $school_id = '0';
        if( _MEMCACHE_ENABLED ){
            $user_id_key = _SESSION_KEY_PREFIX . $session_id . "_" . _MEMCACHE_SESSIONS_USER_ID;
            $session_expiry_key = _SESSION_KEY_PREFIX . $session_id . "_" . _MEMCACHE_SESSIONS_SESSION_EXPIRY;
            
            $memcache = new MemcacheLibrary();
            $user_id = $memcache->getKey($user_id_key);
            $session_expiry = $memcache->getKey($session_expiry_key);
            $user_type = "";
            if( $user_id != null && $user_id != FALSE && 
                    $session_expiry != null && $session_expiry != FALSE ){
                $current_timestamp = time();
                if( $session_expiry > $current_timestamp ){
                    //+ (_USER_SESSION_EXPIRY_PERIOD * _ONE_DAY_SECONDS)
                    $user_type_key = _USERS_KEY_PREFIX . $school_id . "_" . $user_id . "_" . _MEMCACHE_USERS_USER_TYPE;
                    $user_type = $memcache->getKey($user_type_key);
                    if( $user_type != FALSE ){
                        $user_details = array("user_id" => $user_id, 
                                            "user_type" => $user_type,
                                            "error" => "" );
                        
                        return $user_details;
                    }
                }
            }
        }
        
        $this->load->model('schoolmodel');
        $user_details = $this->schoolmodel->getUserDetailsBySessionID($school_id, $session_id);
        return $user_details;
    }
    
    public function getUserDetailsFromSessionID_bkp( $session_id ){
        $username_enc_map = array( "1" => "5", "2" => "2", "3" => "8", "4" => "3", "5" => "9", 
                                    "6" => "1", "7" => "4", "8" => "0", "9" => "7", "0" => "6" ); 
        
        $username_enc_verify_map = array( "1" => "2", "2" => "7", "3" => "1", "4" => "8", "5" => "9", 
                                    "6" => "0", "7" => "5", "8" => "6", "9" => "3", "0" => "4" ); 
        
        $num_map = array( "1" => "t", "2" => "g", "3" => "u", "4" => "j", "5" => "b", 
                          "6" => "y", "7" => "d", "8" => "q", "9" => "s", "0" => "l" ); 
        
        /*$username_enc_map        = array_flip( $username_enc_map );
        $username_enc_verify_map = array_flip( $username_enc_verify_map );*/
        $num_map                 = array_flip( $num_map );
        
        $session_id_cnt = strlen( $session_id );
        $session_id_decoded = "";
        for( $i = 0; $i < $session_id_cnt; $i++ ){
            $hex_num = $session_id[$i] . $session_id[$i+1];
            $decoded_char = chr( hexdec( $hex_num ) - $username_enc_map[ ( ($i/2)%10 ) ] );
            $session_id_decoded .= $decoded_char;
            $i++;
        }
        
        $session_id_valid = true;
        $session_id_decoded = base64_decode( $session_id_decoded );
        $session_id_len = strlen( $session_id_decoded );
        $user_type = "";
        $timestamp_str = "";
        $username_len = "";
        $userid_len = "";
        $timestamp_len = 0;
        
        if( isset( $num_map[ $session_id_decoded[0] ] ) ){
            $timestamp_str = $num_map[ $session_id_decoded[0] ];
            $timestamp_len++;
        } else {
            $session_id_valid = false;
        }
        
        if( isset( $num_map[ $session_id_decoded[1] ] ) ){
            $username_len = $num_map[ $session_id_decoded[1] ];
        } else {
            $session_id_valid = false;
        }
        
        $tmp_start = 6;
        if( $session_id_decoded[2] == "!" ){
            $tmp_start = 8;
            if( isset( $num_map[ $session_id_decoded[3] ] ) ){
                $username_len = intval($username_len . $num_map[ $session_id_decoded[3] ]);
            } else {
                $session_id_valid = false;
            }
            
            if( isset( $num_map[ $session_id_decoded[4] ] ) ){
                $timestamp_str .= $num_map[ $session_id_decoded[4] ];
                $timestamp_len++;
            } else {
                $session_id_valid = false;
            }
            
            if( isset( $num_map[ $session_id_decoded[5] ] ) ){
                $userid_len = $num_map[ $session_id_decoded[5] ];
            } else {
                $session_id_valid = false;
            }
            
            if( isset( $num_map[ $session_id_decoded[6] ] ) ){
                $timestamp_str .= $num_map[ $session_id_decoded[6] ];
                $timestamp_len++;
            } else {
                $session_id_valid = false;
            }
            
            if( isset( $num_map[ $session_id_decoded[7] ] ) ){
                $user_type = $num_map[ $session_id_decoded[7] ];
            } else {
                $session_id_valid = false;
            }
        } else {
            if( isset( $num_map[ $session_id_decoded[2] ] ) ){
                $timestamp_str .= $num_map[ $session_id_decoded[2] ];
                $timestamp_len++;
            } else {
                $session_id_valid = false;
            }
            
            if( isset( $num_map[ $session_id_decoded[3] ] ) ){
                $userid_len = $num_map[ $session_id_decoded[3] ];
            } else {
                $session_id_valid = false;
            }
            
            if( isset( $num_map[ $session_id_decoded[4] ] ) ){
                $timestamp_str .= $num_map[ $session_id_decoded[4] ];
                $timestamp_len++;
            } else {
                $session_id_valid = false;
            }
            
            if( isset( $num_map[ $session_id_decoded[5] ] ) ){
                $user_type = $num_map[ $session_id_decoded[5] ];
            } else {
                $session_id_valid = false;
            }
        }
        
        if( !$session_id_valid ){
            return false;
        }
        
        $formed_uname_len = 0;
        $formed_uid_len = 0;
        $enc_uname_len = 0;
        $username = "";
        $user_id = "";
        $username_enc = "";
        $hex_char = "";
        for( $i = $tmp_start; $i < $session_id_len; $i++ ){
            if( ($i - $tmp_start) %3 == 0 && $timestamp_len < _TIMESTAMP_LENGTH ){
                $hex_char = "";
                if( isset( $num_map[ $session_id_decoded[$i] ] ) ){
                    $timestamp_str .= $num_map[ $session_id_decoded[$i] ];
                    $timestamp_len++;
                    continue;
                } else {
                    $session_id_valid = false;
                    break;
                }
            }
            
            if( ($i - $tmp_start)%3 != 0 && $timestamp_len < _TIMESTAMP_LENGTH && $formed_uid_len < $userid_len ){
                if( ($i - $tmp_start)%3 == 1 ){
                    $hex_char = $session_id_decoded[$i];
                } else {
                    $hex_char .= $session_id_decoded[$i];
                    $decoded_char = chr( hexdec( $hex_char ) - $username_enc_map[ $formed_uid_len%10 ] );
                    //$decoded_char = chr( ord( $session_id_decoded[$i] ) - $username_enc_map[ $i%10 ] );
                    $user_id .= $decoded_char;
                    $formed_uid_len++;
                }
                continue;
            }
            
            if( $timestamp_len >= _TIMESTAMP_LENGTH && $formed_uid_len < $userid_len ){
                if( $hex_char == "" ){
                    $hex_char = $session_id_decoded[$i];
                } else {
                    $hex_char .= $session_id_decoded[$i];
                    $decoded_char = chr( hexdec( $hex_char ) - $username_enc_map[ $formed_uname_len%10 ] );
                    $user_id .= $decoded_char;
                    $hex_char = "";
                    $formed_uname_len++;
                }
                continue;
            }
            
            if( ($i - $tmp_start)%3 != 0 && $timestamp_len < _TIMESTAMP_LENGTH && $formed_uname_len < $username_len ){
                if( ($i - $tmp_start)%3 == 1 ){
                    $hex_char = $session_id_decoded[$i];
                } else {
                    $hex_char .= $session_id_decoded[$i];
                    $decoded_char = chr( hexdec( $hex_char ) - $username_enc_map[ $formed_uname_len%10 ] );
                    //$decoded_char = chr( ord( $session_id_decoded[$i] ) - $username_enc_map[ $i%10 ] );
                    $username .= $decoded_char;
                    $formed_uname_len++;
                }
                continue;
            }
            
            if( $timestamp_len >= _TIMESTAMP_LENGTH && $formed_uname_len < $username_len ){
                if( $hex_char == "" ){
                    $hex_char = $session_id_decoded[$i];
                } else {
                    $hex_char .= $session_id_decoded[$i];
                    $decoded_char = chr( hexdec( $hex_char ) - $username_enc_map[ $formed_uname_len%10 ] );
                    $username .= $decoded_char;
                    $hex_char = "";
                    $formed_uname_len++;
                }
                continue;
            }
            
            if( $timestamp_len >= _TIMESTAMP_LENGTH && $formed_uname_len >= $username_len ){
                if( $hex_char == "" ){
                    $hex_char = $session_id_decoded[$i];
                } else {
                    $hex_char .= $session_id_decoded[$i];
                    $decoded_char = chr( hexdec( $hex_char ) - $username_enc_verify_map[ $enc_uname_len%10 ] );
                    $username_enc .= $decoded_char;
                    $hex_char = "";
                    $enc_uname_len++;
                }
                continue;
            }
        }
        
        $user_type_end = $num_map[$hex_char];
        if( $user_type != $user_type_end ){
            $session_id_valid = false;
        }
        
        error_log( "username : " . $username );
        error_log( "username_enc : " . $username_enc );
        error_log( "user_id : " . $user_id );
        if( $session_id_valid ){
            $timestamp = strrev( $timestamp_str );
            error_log( "timestamp : " . $timestamp );
            $current_time_stamp = time();
            if( $current_time_stamp - $timestamp > _USER_SESSION_EXPIRY_PERIOD * _ONE_DAY_SECONDS ){
                $session_id_valid = false;
            }
            if( $username != $username_enc ){
                $session_id_valid = false;
            }
            
            if( $user_type != _USER_TYPE_SCHOOL && $user_type != _USER_TYPE_TEACHER && 
                    $user_type != _USER_TYPE_STUDENT && $user_type != _USER_TYPE_PARENT ){
                $session_id_valid = false;
            }
        }
        
        if( !$session_id_valid ){
            return false;
        }
        
        $this->load->model('schoolmodel');
        $school_id = '0';
        $valid = $this->schoolmodel->validateUser( $school_id, $username, $user_id );
        if( !$valid ){
            return false;
        }
        
        $return_array = array( "username" => $username, "user_id" => $user_id, "user_type" => $user_type );
        return $return_array;
    }
    
    
    
    public function updateInboxCountMemcache( $school_id, $user_id ){
        if( _MEMCACHE_ENABLED ){
            $memcache = new MemcacheLibrary(); //$this->getMemcache(); 
            //error_log( "mem avail : " . $memcache->isMemcacheAvailable() );
            $inbox_cnt_key = _INBOX_COUNT . "_" . $school_id . "_" . $user_id;
            $memcache->deleteKey($inbox_cnt_key);
            $this->load->model('schoolmodel');
            $inbox_count = $this->schoolmodel->getInboxCount( $user_id, $school_id );
            if( $inbox_count != "" ){
                $memcache->setKey( $inbox_cnt_key, $inbox_count );
            }
            
            /*$important_cnt_key = _INBOX_IMPORTANT_COUNT . "_" . $school_id . "_" . $user_id;
            $inbox_important_count = $memcache->getKey($important_cnt_key);
            if( $inbox_important_count != FALSE ){
                $inbox_important_count = $this->schoolmodel->getInboxImportantCount( $user_id, $school_id );
                if( $inbox_important_count != "" ){
                    $memcache->setKey( $inbox_cnt_key, $inbox_important_count );
                }
            } */
        }
    }
    
    public function addTextPostSchoolREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            if( array_key_exists( 'posted_text', $parameters) && is_string( $parameters['posted_text'] ) ){
                $posted_text = trim( $parameters['posted_text'] );
                error_log( "posted_text : " . $parameters['posted_text'] );
            }

            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];
            //$text  = ( isset($_POST["text"] ) ? html_entity_decode(trim($_POST["text"])) : "" );
            $post_type = _FORUM_ITEM_TYPE_TEXT;
            error_log( "posted_text : " . $posted_text . " ::: user_id, user_type : " . $user_id . ", " . $user_type );
            $item_id = $this->schoolmodel->addSchoolForumPost( $school_id, $posted_text, $post_type, $user_id, $user_type );
            error_log( "item_id : " . $item_id );
            $success = "true";
            if( $item_id === FALSE ){
                $success = "false";
            } 
            
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $success . '" }' );
            return;
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
    }
    
    public function uploadSFPicREST(){
        error_log( "in uploadSFpic. file : " . print_r( $_FILES, true ) );
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getMultipartPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            error_log( "req_params : " . print_r( $parameters, true ) );
            $posted_text = "";
            if( array_key_exists( 'description', $parameters) && is_string( $parameters['description'] ) ){
                $posted_text = trim( $parameters['description'] );
                error_log( "posted_text : " . $parameters['description'] );
            }

            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];    
            
            $isValid['success'] = false;
            if( isset( $_FILES["picture"] ) && isset($_FILES["picture"]["error"])
                    && $_FILES["picture"]["error"] == 0 ){
                error_log( "in err if : " );
                $is_rest_upload = true;
                $isValid = $this->validateImage( "picture", _FORUM_IMAGE_MAX_SIZE, $is_rest_upload );
                /*if( !( exif_imagetype($_FILES["picture"]['tmp_name'] ) > 0 )
                    || $_FILES["picture"]["type"] != "image/jpeg" ){
                    error_log( "in not jpeg : " );
                    $isValid['success'] = false;
                }*/
            }
            $success = false;
            if( $isValid['success'] ){
                $timestamp = time();
                $filename = $timestamp . '_' . $user_id . ".jpg";
                $file = _FORUM_IMAGE_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME . '/' . $filename;
                $file_s3 = _FORUM_IMAGE_S3_FOLDER . '/' . _SCHOOL_POST_PIC_UPLOAD_DIR_NAME . '/' . $filename;
                $success = $this->saveFile($_FILES['picture']['tmp_name'], $file, $file_s3);
                        
                /*$try_count = 3;
                while( $try_count > 0 ){
                    error_log("mv_up_f ");
                    move_uploaded_file($_FILES['picture']['tmp_name'], $file);
                    $this->move_to_s3($_FILES['picture']['tmp_name'], $file_s3);
                    //$this->compress($_FILES['picture']['tmp_name'], $file, $compression_quality);
                    if( file_exists($file) ){
                        $success = true;
                        break;
                    }
                    $try_count--;
                }*/
            } 
            
            if( $success ){
                $post_type = _FORUM_ITEM_TYPE_PICTURE;
                $pic_url = _SCHOOL_POST_PIC_UPLOAD_DIR_NAME . "/" . $filename;
                $result = $this->schoolmodel->insertSchoolPicturePost( $school_id, $user_id, $user_type, $post_type, $pic_url, $posted_text );
                if( $result == false ){
                    $success = false;
                }
            }
            
            if( $success ){
                $this->restutilities->sendResponse( 200,    
                    '{"success": "true" }' );
                return;
            } else {
                $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
                return;
            }
        }
    }
    
    public function fetchSchoolNotifsREST(){
        $this->load->library('RestUtilities');
        //$requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER ) ){
            $this->load->library('Logging');
            $this->load->model('schoolmodel');
            $school_id = '0';
            $schoolNotifications = $this->schoolmodel->getSchoolNotifications( $school_id );
            $success = "false";
            if( is_array($schoolNotifications) ){
                $success = "true";
            }
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $success . '", "notifications": ' . json_encode($schoolNotifications) . ' }' );
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
    }
    
    public function fetchSchoolCommentsREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER ) ){
            $this->load->library('Logging');
            $this->load->model('schoolmodel');
            $parameters = $requestParams['data'];
            $school_id = '0';
            $item_id = "";
            $comment_id = "";
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];  
            
            if( array_key_exists( 'item_id', $parameters) && is_string( $parameters['item_id'] ) ){
                $item_id = trim( $parameters['item_id'] );
                error_log( "item_id : " . $parameters['item_id'] );
            }
            
            if( array_key_exists( 'comment_id', $parameters) && is_string( $parameters['comment_id'] ) ){
                $comment_id = trim( $parameters['comment_id'] );
                error_log( "comment_id : " . $parameters['comment_id'] );
            }
            
            if( $item_id == "" || $comment_id == "" ){
                $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
                return;
            }
            
            $feedComments = $this->schoolmodel->getSchoolFeedComments( $school_id, $user_id, $item_id, 
                                                    $comment_id, _FORUM_DEFAULT_COMMENT_DETAIL_SIZE, _FEED_SHORT_PARAMS );
            $this->restutilities->sendResponse( 200,    
                    '{"success": "true", "comments" : ' . json_encode( $feedComments ) . ' }' );//get short form feed names and send
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
    }
    
    public function postSchoolCommentREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER ) ){
            $this->load->library('Logging');
            $this->load->model('schoolmodel');
            $parameters = $requestParams['data'];
            $school_id = '0';
            $item_id = "";
            $comment = "";
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];
            
            if( array_key_exists( 'item_id', $parameters) && is_string( $parameters['item_id'] ) ){
                $item_id = trim( $parameters['item_id'] );
                error_log( "item_id : " . $parameters['item_id'] );
            }
            
            if( array_key_exists( 'comment', $parameters) && is_string( $parameters['comment'] ) ){
                $comment = trim( $parameters['comment'] );
                error_log( "comment : " . $parameters['comment'] );
            }
            
            if( $item_id == "" || $comment == "" ){
                $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
                return;
            }
            
            $added = $this->schoolmodel->addSchoolComment( $school_id, $user_id, $user_type, $item_id, $comment );
            if(is_array($added)){
                $comment = RestUtilities::escapeParamQuotes( $comment );
                $this->restutilities->sendResponse( 200,    
                    '{"success": "true", "comment_id" : "' . $added[0] . '", "username" : "' . $added[1] . 
                            '", "display_date" : "' . $added[2] . '", "comment" : "' . $comment . '" }' );
            } else {
                $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
                return;
            }
            
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
    }
    
    public function getInboxContentREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER
                        || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $this->load->model('schoolmodel');
            
            $parameters = $requestParams['data'];
            $school_id = '0';
            $search_user_id = "";
            $search_text = "";
            $pg_num = "1";
            $from_timestamp = "";
            $to_timestamp = "";
            
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];
            
            if( $user_type != _USER_TYPE_SCHOOL && $user_type != _USER_TYPE_TEACHER
                    && $user_type != _USER_TYPE_PARENT ){
                $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
                return;
            }
            
            if( array_key_exists( 'search_user_id', $parameters) && is_string( $parameters['search_user_id'] ) ){
                $search_user_id = trim( $parameters['search_user_id'] );
                error_log( "search_user_id : " . $parameters['search_user_id'] );
            }
            
            if( array_key_exists( 'search_text', $parameters) && is_string( $parameters['search_text'] ) ){
                $search_text = trim( $parameters['search_text'] );
                error_log( "search_text : " . $parameters['search_text'] );
            }
            
            if( array_key_exists( 'option', $parameters) && is_string( $parameters['option'] ) ){
                $option = trim( $parameters['option'] );
                error_log( "option : " . $parameters['option'] );
            }
            
            if( array_key_exists( 'pg_num', $parameters) && is_string( $parameters['pg_num'] ) ){
                $pg_num = trim( $parameters['pg_num'] );
                error_log( "pg_num : " . $parameters['pg_num'] );
            }
            
            if( array_key_exists( 'from_timestamp', $parameters) && is_string( $parameters['from_timestamp'] ) ){
                $from_timestamp = trim( $parameters['from_timestamp'] );
                error_log( "from_timestamp : " . $parameters['from_timestamp'] );
            }
            
            if( array_key_exists( 'to_timestamp', $parameters) && is_string( $parameters['to_timestamp'] ) ){
                $to_timestamp = trim( $parameters['to_timestamp'] );
                error_log( "to_timestamp : " . $parameters['to_timestamp'] );
            }
            
            $pg_size = _INBOX_PAGE_SIZE;
            $inbox_content = $this->schoolmodel->getInboxContentByTime($school_id, $user_type, $user_id, $search_user_id, $search_text,
                                            $option, $from_timestamp, $to_timestamp, $pg_size, _INBOX_SHORT_PARAMS );
            
            error_log( "to_timestamp : " . $to_timestamp );
            if( $to_timestamp != "" ){
                $inbox_content_tmp = array();
                $unix_timestamp_param = "u";
                $remove_from_idx = "";
                /*for( $i = count($inbox_content) - 1; $i >= 0; $i-- ){
                    $to_timestamp_content = trim( $inbox_content[$i][$unix_timestamp_param] );
                    error_log( "to_timestamp_content : " . $to_timestamp_content );
                    if( $to_timestamp_content >= $to_timestamp ){
                        $remove_from_idx = $i;
                    }
                }*/
                
                for( $i = 0; $i < count($inbox_content); $i++ ){
                    $to_timestamp_content = trim( $inbox_content[$i][$unix_timestamp_param] );
                    error_log( "to_timestamp_content : " . $to_timestamp_content );
                    if( $to_timestamp_content < $to_timestamp ){
                        $inbox_content_tmp[] = $inbox_content[$i];
                    }
                }
                
                
                    
                /*error_log( "remove_from_idx : " . $remove_from_idx );
                if( $remove_from_idx !== "" ){
                    $inbox_content = array_slice( $inbox_content, 0, $remove_from_idx );//$inbox_content = 
                }*/
                $inbox_content = $inbox_content_tmp;
                
            } else if( $from_timestamp != "" ){
                $inbox_content_tmp = array();
                $unix_timestamp_param = "u";
                for( $i = 0; $i < count($inbox_content); $i++ ){
                    $from_timestamp_content = trim( $inbox_content[$i][$unix_timestamp_param] );
                    error_log( "from_timestamp_content : " . $from_timestamp_content );
                    if( $from_timestamp_content >  $from_timestamp ){
                        $inbox_content_tmp[] = $inbox_content[$i];
                    }
                }
                $inbox_content = $inbox_content_tmp;
            }
            /*$inbox_content = $this->schoolmodel->getInboxContent( $school_id, $user_type, $user_id, 
                                                    $search_user_id, $search_text, $option, $pg_num, $pg_size, _INBOX_SHORT_PARAMS );*/
            
            $inbox_content_json = json_encode( $inbox_content );
            error_log( "inbox_content_json : " . $inbox_content_json );
            //$inbox_content_json = RestUtilities::escapeParamQuotes( $inbox_content_json );
            $this->restutilities->sendResponse( 200,    
                    '{"success": "true", "inbox_type" : "' . $option . '", "inbox_content" : ' . $inbox_content_json . ' }' );
            return;
        }
    }
    
    public function markMessageREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{ "success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER
                        || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $this->load->model('schoolmodel');
            
            $parameters = $requestParams['data'];
            $school_id = '0';
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];
            
            if( array_key_exists( 'parent_msg_id', $parameters) && is_string( $parameters['parent_msg_id'] ) ){
                $parent_msg_id = trim( $parameters['parent_msg_id'] );
                error_log( "parent_msg_id : " . $parameters['parent_msg_id'] );
            }
            
            if( array_key_exists( 'mark_as', $parameters) && is_string( $parameters['mark_as'] ) ){
                $markAs = trim( $parameters['mark_as'] );
                error_log( "markAs : " . $parameters['mark_as'] );
            }
            
            if( $parent_msg_id == "" || $markAs == "" ){
                $marked = "false";
            } else {
                $marked = $this->schoolmodel->markMessage( $school_id, $user_id, $parent_msg_id, $markAs );
            }
            
            if( $marked == "true" ){
                $this->updateInboxCountMemcache( $school_id, $user_id );
            }
            //$marked = "true";
            error_log( "resp : " . '{"success": "' . $marked . '", "parent_msg_id" : "' . $parent_msg_id . '", "mark_as" : "' . $markAs . '" }' );
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $marked . '", "parent_msg_id" : "' . $parent_msg_id . '", "mark_as" : "' . $markAs . '" }' );
            return;
        }
    }
    
    public function getMailDetailsREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{ "success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER
                        || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $this->load->model('schoolmodel');
            
            $parameters = $requestParams['data'];
            $school_id = '0';
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];
            
            if( array_key_exists( 'parent_msg_id', $parameters) && is_string( $parameters['parent_msg_id'] ) ){
                $parent_msg_id = trim( $parameters['parent_msg_id'] );
                error_log( "parent_msg_id : " . $parameters['parent_msg_id'] );
            }
            
            $success = "false";
            $messageDetails = $this->schoolmodel->getMessageDetails( $school_id, $user_type, $user_id, $parent_msg_id, _GENERIC_SHORT_PARAMS );
            error_log( "messageDetails : " . print_r($messageDetails, true));
            if( count( $messageDetails ) > 0 ){
                $success = "true";
                //$marked = $this->schoolmodel->markMessage( $school_id, $user_id, $parent_msg_id, "read" );
            }
            
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $success . '", "mailDetails" : ' . json_encode( $messageDetails ) . ' }' );
            return;
        }
    }
    
    public function sendMailREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{ "success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER
                        || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $this->load->model('schoolmodel');
            
            $parameters = $requestParams['data'];
            $school_id = '0';
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];
            
            $parent_msg_id = "-1";
            $is_reply_msg = "0";
            $to_user_id = "";
            $subject = "";
            $message = "";
            
            if( array_key_exists( 'parent_msg_id', $parameters) && is_string( $parameters['parent_msg_id'] ) ){
                $parent_msg_id = trim( $parameters['parent_msg_id'] );
                error_log( "parent_msg_id : " . $parameters['parent_msg_id'] );
            }
            
            if( array_key_exists( 'is_reply_msg', $parameters) && is_string( $parameters['is_reply_msg'] ) ){
                $is_reply_msg = trim( $parameters['is_reply_msg'] );
                error_log( "is_reply_msg : " . $parameters['is_reply_msg'] );
            }
            
            if( array_key_exists( 'to_user_id', $parameters) && is_string( $parameters['to_user_id'] ) ){
                $to_user_id = trim( $parameters['to_user_id'] );
                error_log( "to_user_id : " . $parameters['to_user_id'] );
            }
            
            if( array_key_exists( 'subject', $parameters) && is_string( $parameters['subject'] ) ){
                $subject = trim( $parameters['subject'] );
                error_log( "subject : " . $parameters['subject'] );
            }
            
            if( array_key_exists( 'message', $parameters) && is_string( $parameters['message'] ) ){
                $message = trim( $parameters['message'] );
                error_log( "message : " . $parameters['message'] );
            }
            
            $success = "true";
            if( $is_reply_msg == "1" && $parent_msg_id == "-1" ){
                $success = "false";
            }
            
            if( $is_reply_msg == "0" && $to_user_id == "" ){
                $success = "false";
            }
            
            if( $is_reply_msg == "0" && $parent_msg_id != "-1" && $parent_msg_id != "" ){
                $success = "false";
            }
            
            if( $subject == "" || $message == "" ){
                $success = "false";
            }
            
            if( $success == "true" ){
                $inserted = $this->schoolmodel->insertInboxMessage( $school_id, $user_id, $to_user_id, $parent_msg_id, $subject, $message );
                if( $inserted ){
                    $this->sendMessageNotification($school_id, $to_user_id);
                    $success = "true";
                } else {
                    $success = "false";
                }
            }
            
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $success . '" }' );
            return;
        }
    }
    
    public function getParentsREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{ "success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER
                        || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $this->load->model('schoolmodel');
            
            $parameters = $requestParams['data'];
            $school_id = '0';
            $lastUpdatedTimestamp = '0';
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];
            
            if( array_key_exists( 'lastUpdatedTimestamp', $parameters) && is_string( $parameters['lastUpdatedTimestamp'] ) ){
                $lastUpdatedTimestamp = trim( $parameters['lastUpdatedTimestamp'] );
                error_log( "lastUpdatedTimestamp : " . $parameters['lastUpdatedTimestamp'] );
            }
            
            $parents = $this->schoolmodel->getParents( $school_id, $lastUpdatedTimestamp, _GENERIC_SHORT_PARAMS );
            $updated_timestamp = $this->schoolmodel->getUpdatedTimestamp( $school_id, _PARENT_TABLE_ID );
            $updated_timestamp = $updated_timestamp[0]['update_timestamp'];
            $this->restutilities->sendResponse( 200,    
                    '{"success": "true", "updated_timestamp" : "'. $updated_timestamp . '", "parents" : ' . json_encode( $parents ) . ' }' );
            return;
        }
    }
    
    public function getStudentsREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{ "success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER
                        || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $this->load->model('schoolmodel');
            
            $parameters = $requestParams['data'];
            $school_id = '0';
            $lastUpdatedTimestamp = '0';
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];
            
            if( array_key_exists( 'lastUpdatedTimestamp', $parameters) && is_string( $parameters['lastUpdatedTimestamp'] ) ){
                $lastUpdatedTimestamp = trim( $parameters['lastUpdatedTimestamp'] );
                error_log( "lastUpdatedTimestamp : " . $parameters['lastUpdatedTimestamp'] );
            }
            
            $students = $this->schoolmodel->getStudents( $school_id, $lastUpdatedTimestamp, _GENERIC_SHORT_PARAMS );
            $updated_timestamp = $this->schoolmodel->getUpdatedTimestamp( $school_id, _STUDENT_TABLE_ID );
            $updated_timestamp = $updated_timestamp[0]['update_timestamp'];
            $this->restutilities->sendResponse( 200,    
                    '{"success": "true", "updated_timestamp" : "'. $updated_timestamp . '", "students" : ' . json_encode( $students ) . ' }' );
            return;
        }
    }
    
    public function getParentsIncREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{ "success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER
                        || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $this->load->model('schoolmodel');
            
            $parameters = $requestParams['data'];
            $school_id = '0';
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];
            
            if( array_key_exists( 'latestParentId', $parameters) && is_string( $parameters['latestParentId'] ) ){
                $latestParentId = trim( $parameters['latestParentId'] );
                error_log( "latestParentId : " . $parameters['latestParentId'] );
            }
            
            $parents = $this->schoolmodel->getParentsInc( $school_id, $latestParentId, $user_type, $user_id, _GENERIC_SHORT_PARAMS );
            error_log( "parents : " . json_encode($parents) );
            $this->restutilities->sendResponse( 200,    
                    '{"success": "true", "parents" : ' . json_encode( $parents ) . ' }' );
            return;
        }
    }
    
    public function getStudentsIncREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{ "success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER
                        || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $this->load->model('schoolmodel');
            
            $parameters = $requestParams['data'];
            $school_id = '0';
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];
            
            if( array_key_exists( 'latestStudentId', $parameters) && is_string( $parameters['latestStudentId'] ) ){
                $latestStudentId = trim( $parameters['latestStudentId'] );
                error_log( "latestStudentId : " . $parameters['latestStudentId'] );
            }
            
            $students = $this->schoolmodel->getStudentsInc( $school_id, $latestStudentId,  $user_type, $user_id, _GENERIC_SHORT_PARAMS );
            error_log( "students : " . json_encode($students) );
            $this->restutilities->sendResponse( 200,    
                    '{"success": "true", "students" : ' . json_encode( $students ) . ' }' );
            return;
        }
    }
    
    public function fetchStudentDetailsREST(){
        error_log("in validateLoginREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        error_log( "fetchStudentDetailsREST req headers : " . print_r( $request_headers, true ) . "\n" );
        error_log( "fetchStudentDetailsREST req params : " . print_r( $requestParams, true ) . "\n" );        
        if( $requestParams ){
            $school_id = '0';
            $parameters = $requestParams['data'];
            $success = "false";
            $studentProfileDetails = array();
            //$teacherTimeTable = array();
            if( array_key_exists( 'student_user_id', $parameters) && is_string( $parameters['student_user_id'] ) ){
                $student_user_id = trim( $parameters['student_user_id'] );
                $this->load->model('schoolmodel');
                
                /*$studentAndParentDetails = $this->schoolmodel->getStudentAndParentDetails( $school_id, $student_id );
                $studentSCDetails = array();
                if(  $sessionUserData['user_type'] !=  _USER_TYPE_PARENT ){
                    $studentSCDetails = $this->schoolmodel->getStudentTestDetails( $school_id, $student_id );
                }*/
            
                $studentProfileDetails = $this->schoolmodel->getStudentDetailsApp( $school_id, $student_user_id, _GENERIC_SHORT_PARAMS );
                //$teacherProfileDetails = $this->schoolmodel->getTeacherProfileDetailsByTid( $school_id, $teacher_id );
                error_log( "studentProfileDetails : " . print_r($studentProfileDetails, true));
                //$teacherTimeTable = $this->schoolmodel->getTeacherTimeTable( $school_id, $teacher_id );
                $success = "true";
            }
            
            $this->restutilities->sendResponse( 200, 
                    '{"success": "' . $success . '", "studentProfileDetails": ' . json_encode($studentProfileDetails) . ' }' );
            return;
            
        }
    }
    
    public function fetchParentDetailsREST(){
        error_log("in validateLoginREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        error_log( "fetchParentDetailsREST req headers : " . print_r( $request_headers, true ) . "\n" );
        error_log( "fetchParentDetailsREST req params : " . print_r( $requestParams, true ) . "\n" );        
        if( $requestParams ){
            $school_id = '0';
            $parameters = $requestParams['data'];
            $success = "false";
            $parentProfileDetails = array();
            if( array_key_exists( 'parent_user_id', $parameters) && is_string( $parameters['parent_user_id'] ) ){
                $parent_user_id = trim( $parameters['parent_user_id'] );
                $this->load->model('schoolmodel');
                $parentProfileDetails = $this->schoolmodel->getParentDetailsApp( $school_id, $parent_user_id, _GENERIC_SHORT_PARAMS );
                error_log( "parentProfileDetails : " . print_r($parentProfileDetails, true));
                $success = "true";
            }
            
            $this->restutilities->sendResponse( 200, 
                    '{"success": "' . $success . '", "parentProfileDetails": ' . json_encode($parentProfileDetails) . ' }' );
            return;
        }
    }
    
    public function fetchStudentScoresREST(){
        error_log("in fetchStudentScoresREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        ///user_type, $user_details['user_type']
        error_log( "fetchStudentScoresREST req headers : " . print_r( $request_headers, true ) . "\n" );
        error_log( "fetchStudentScoresREST req params : " . print_r( $requestParams, true ) . "\n" );        
        if( $requestParams ){
            $school_id = '0';
            $parameters = $requestParams['data'];
            $success = "false";
            $studentSCDetails = array();
            if( array_key_exists( 'student_id', $parameters) && is_string( $parameters['student_id'] ) ){
                $student_id = trim( $parameters['student_id'] );
                $this->load->model('schoolmodel');
                $is_valid = true;
                if( trim($user_details['user_type']) == _USER_TYPE_PARENT ){
                    $is_valid = $this->schoolmodel->isValidParentStudent($school_id, $student_id, trim($user_details['user_id']) );
                }
                
                if( $is_valid ){
                    $studentSCDetails = $this->schoolmodel->getStudentTestDetailsForApp( $school_id, $student_id, _GENERIC_SHORT_PARAMS );
                    $this->restutilities->sendResponse( 200, 
                    '{"success": "true", "studentSCDetails": ' . json_encode($studentSCDetails['studentSCDetails']) . 
                        ', "tests" : ' . json_encode($studentSCDetails['tests']) . ', "subjects" : ' . json_encode($studentSCDetails['subjects']) . ' }' );
                } else {
                    $this->restutilities->sendResponse( 200, 
                    '{"success": "false"}' );
                }
            }
            
            return;
        }
    }
    
    public function fetchSchoolLoginProfileREST(){
        error_log("in fetchSchoolLoginProfileREST" );
	$this->load->library('RestUtilities');
        //$requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        $this->load->model('schoolmodel');
        $profileDetails = $this->schoolmodel->getSchoolLoginProfileDetails( $school_id, $user_id );
        if( count($profileDetails) > 0 ){
            $this->restutilities->sendResponse( 200, 
                    '{"success": "true", "profileDetails": ' . json_encode($profileDetails) . ' }' );
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function saveProfileFieldREST(){
        error_log("in saveProfileFieldREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        ///user_type, $user_details['user_type']
        error_log( "saveProfileFieldREST req headers : " . print_r( $request_headers, true ) . "\n" );
        error_log( "saveProfileFieldREST req params : " . print_r( $requestParams, true ) . "\n" );        
        if( $requestParams ){
            $school_id = '0';
            $user_id = trim($user_details['user_id']);
            $parameters = $requestParams['data'];
            $updated = "false";
            $fieldName = "";
            $fieldValue = "";
            $profileType = "";
            $displayValue = "";
            $viewId = "";
            if( array_key_exists( 'fieldName', $parameters) && is_string( $parameters['fieldName'] ) ){
                $fieldName = trim( $parameters['fieldName'] );
            }
            
            if( array_key_exists( 'fieldValue', $parameters) && is_string( $parameters['fieldValue'] ) ){
                $fieldValue = trim( $parameters['fieldValue'] );
            }
            
            if( array_key_exists( 'profileType', $parameters) && is_string( $parameters['profileType'] ) ){
                $profileType = trim( $parameters['profileType'] );
            }
            
            if( array_key_exists( 'displayValue', $parameters) && is_string( $parameters['displayValue'] ) ){
                $displayValue = trim( $parameters['displayValue'] );
            }
            
            if( array_key_exists( 'viewId', $parameters) && is_string( $parameters['viewId'] ) ){
                $viewId = trim( $parameters['viewId'] );
            }
            
            if( trim($fieldName) == "" || trim($fieldValue) == "" || trim($profileType) == "" ){
                $this->restutilities->sendResponse( 200, 
                    '{"success": "' . $updated . '" }' );
                return;
            }
            
            $this->load->model('schoolmodel');
            if( $profileType == _PROFILE_TYPE_SCHOOL ){
                error_log("profile type : school");
                error_log("user_id : $user_id, fieldName : $fieldName, fieldValue : $fieldValue");
                $updated = $this->schoolmodel->updateSchoolProfileField( $school_id, $user_id, $fieldName, $fieldValue );
            }
            
            if( $profileType == _PROFILE_TYPE_TEACHER ){
                $updated = $this->schoolmodel->updateTeacherProfileField( $school_id, $user_id, $fieldName, $fieldValue );
            }
            
            if( $profileType == _PROFILE_TYPE_PARENT ){
                error_log("profile type : parent");
                error_log("user_id : $user_id, fieldName : $fieldName, fieldValue : $fieldValue");
                $updated = $this->schoolmodel->updateParentProfileField( $school_id, $user_id, $fieldName, $fieldValue );
            }
            
            if( $profileType == _PROFILE_TYPE_STUDENT ){
                $updated = $this->schoolmodel->updateStudentProfileField( $school_id, $user_id, $fieldName, $fieldValue );
            }
            
            $this->restutilities->sendResponse( 200, 
                    '{"success": "' . $updated . '", "displayValue" : "' . $displayValue . '", "viewId" : "' . $viewId . '" }' );
            return;
        }
    }
    
    public function changePasswordREST(){
        error_log("in changePasswordREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        ///user_type, $user_details['user_type']
        error_log( "changePasswordREST req headers : " . print_r( $request_headers, true ) . "\n" );
        error_log( "changePasswordREST req params : " . print_r( $requestParams, true ) . "\n" );        
        if( $requestParams ){
            $school_id = '0';
            $user_id = trim($user_details['user_id']);
            $parameters = $requestParams['data'];
            if( array_key_exists( 'oldPassword', $parameters) && is_string( $parameters['oldPassword'] ) ){
                $oldPassword = trim( $parameters['oldPassword'] );
            }
            
            if( array_key_exists( 'newPassword', $parameters) && is_string( $parameters['newPassword'] ) ){
                $newPassword = trim( $parameters['newPassword'] );
            }
            
            if( $oldPassword == "" || $newPassword == "" ){
                $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            }
            
            $this->load->model("schoolmodel");
            $changed = $this->schoolmodel->changePassword( $school_id, $user_id, $oldPassword, $newPassword, true );
            $changed_arr = explode("~~", $changed);
            $success = trim($changed_arr[0]);
            $reason = "";
            if( count($changed_arr) > 1 ){
                $reason = trim($changed_arr[1]);
            }
            
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $success . '", "reason" : "' . $reason . '" }' );
        }
        
    }
    
    public function uploadProfilePicREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getMultipartPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && ( $user_details['user_type'] == _USER_TYPE_PARENT ||
                $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            error_log( "req_params : " . print_r( $parameters, true ) );
            $upload_user_type = "";
            if( array_key_exists( 'description', $parameters) && is_string( $parameters['description'] ) ){
                $upload_user_type = trim( $parameters['description'] );
                error_log( "upload_user_type : " . $parameters['description'] );
            }

            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];    
            $updated = false;
            
            $isValid['success'] = false;
            if( isset( $_FILES["picture"] ) && isset($_FILES["picture"]["error"])
                    && $_FILES["picture"]["error"] == 0 ){
                $is_rest_upload = true;
                $isValid = $this->validateImage( "picture", _PROFILE_PIC_MAX_SIZE, $is_rest_upload );
            }
            $success = false;
            if( $isValid['success'] ){
                $timestamp = time();
                $filename = $timestamp . '_' . $user_id . ".jpg";
                $file = _PROFILE_PICTURE_FOLDER . '/' . $filename;
                $file_s3 = _PROFILE_PICTURE_S3_FOLDER . '/' . $filename;
                $success = $this->saveFile($_FILES['picture']['tmp_name'], $file, $file_s3);
                /*
                $try_count = 3;
                while( $try_count > 0 ){
                    error_log("mv_up_f ");
                    //move_uploaded_file($_FILES['picture']['tmp_name'], $file);
                    $moved = $this->move_to_s3($_FILES['picture']['tmp_name'], $file_s3);
                    if( /*file_exists($file)* $moved ){
                        $success = true;
                        break;
                    }
                    $try_count--;
                } */
            } 
            
            if( $success ){
                $pic_url = $filename;
                if( $upload_user_type == 'school' ){
                    $fieldName = 'pic_url';
                    $fieldValue = $pic_url;
                    $updated = $this->schoolmodel->updateSchoolProfileField( $school_id, $user_id, $fieldName, $fieldValue );
                }
                if( $upload_user_type == 'teacher' ){
                    $fieldName = 'pic_url';
                    $fieldValue = $pic_url;
                    $updated = $this->schoolmodel->updateTeacherProfileField( $school_id, $user_id, $fieldName, $fieldValue );
                }

                if( $upload_user_type == 'parent' ){
                    $fieldName = 'pic_url';
                    $fieldValue = $pic_url;
                    $updated = $this->schoolmodel->updateParentProfileField( $school_id, $user_id, $fieldName, $fieldValue );
                }

                if( $upload_user_type == 'student' ){
                    $fieldName = 'pic_url';
                    $fieldValue = $pic_url;
                    $updated = $this->schoolmodel->updateStudentProfileField( $school_id, $user_id, $fieldName, $fieldValue );
                }
            }
            
            if( $success && $updated ){
                $this->restutilities->sendResponse( 200,    
                    '{"success": "true" }' );
                return;
            } else {
                $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
                return;
            }
        }
    }
    
    public function fetchClassFeedREST(){
        error_log("in fetchClassFeedREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( $requestParams ){
            $school_id = '0';
            $parameters = $requestParams['data'];
            error_log("in fetchClassFeedREST, parameters : " . print_r($parameters, true) );
            $success = "false";
            $forum_feed = '{ "fi" : [], "l" : "0", "f" : "0" }';
            /*if( array_key_exists( 'username', $parameters) && array_key_exists( 'last_timestamp', $parameters ) 
                    && is_string( $parameters['username'] ) && is_string( $parameters['last_timestamp'] ) ){*/
            if( array_key_exists( 'last_timestamp', $parameters ) && is_string( $parameters['last_timestamp'] ) &&
                    array_key_exists( 'class_id', $parameters ) && is_string( $parameters['class_id'] ) && 
                    array_key_exists( 'fetch_fwd', $parameters ) && is_string( $parameters['fetch_fwd'] )){
                $last_timestamp = trim( $parameters['last_timestamp'] );
                $fetch_fwd = "false";
                $class_id = "";
                if( array_key_exists( 'class_id', $parameters ) && is_string( $parameters['class_id'] ) ){
                    $class_id = trim( $parameters['class_id'] );
                }
                if( array_key_exists( 'fetch_fwd', $parameters ) && is_string( $parameters['fetch_fwd'] ) ){
                    $fetch_fwd = trim( $parameters['fetch_fwd'] );
                }
                if( $last_timestamp == "" || $last_timestamp == "0" ){
                    $last_timestamp = time();
                }
                
                if( $last_timestamp == "-1" ){
                    $last_timestamp ="0";
                }
                
                $this->load->model('parentmodel');
                $user_id = trim( $user_details['user_id'] );
                $user_type = trim( $user_details['user_type'] );
                $is_valid_request = false;
                if( $user_type == _USER_TYPE_SCHOOL ){
                    $is_valid_request = true;
                } else {
                    $is_valid_request = $this->parentmodel->validateClassFeedReq($school_id, $user_id, $class_id, $user_type);
                }
                
                if( !$is_valid_request ){
                    $this->restutilities->sendResponse( 200,    
                        '{"success": "false" }' );
                    return;
                }
                
                
                $forum_feed = $this->parentmodel->getClassFeed( $school_id, $class_id, $user_id, $user_type, $last_timestamp, 
                                    _FORUM_PAGE_FEED_SIZE, _FORUM_DEFAULT_COMMENT_SIZE, _FEED_SHORT_PARAMS, $fetch_fwd );
                
                /*$forum_feed = $this->schoolmodel->getSchoolFeed( $school_id, $user_id, _FEED_FETCH_BY_USER_ID, $user_type, $last_timestamp, 
                                                            _FORUM_PAGE_FEED_SIZE, _FORUM_DEFAULT_COMMENT_SIZE, _FEED_SHORT_PARAMS, $fetch_fwd );*/
                
                if( count($forum_feed) == 0 ){
                    $forum_feed = '{ "fi" : [], "l" : "' . $last_timestamp . '", "f" : "' . $last_timestamp . '" }';
                } else {
                    $forum_feed = json_encode( $forum_feed );
                }
                
                $success = "true";
                //echo json_encode( $forum_feed );
                error_log( "forum_feed : " . $forum_feed );
            }
            
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $success . '", "class_feed": ' . $forum_feed . ', "classId" : "' . $class_id . '" }' );
            return;
            
        }
    }
    
    public function fetchClassCommentsREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER 
                    || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $this->load->model('parentmodel');
            $parameters = $requestParams['data'];
            $school_id = '0';
            $item_id = "";
            $comment_id = "";
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];  
            
            if( array_key_exists( 'item_id', $parameters) && is_string( $parameters['item_id'] ) ){
                $item_id = trim( $parameters['item_id'] );
                error_log( "item_id : " . $parameters['item_id'] );
            }
            
            if( array_key_exists( 'comment_id', $parameters) && is_string( $parameters['comment_id'] ) ){
                $comment_id = trim( $parameters['comment_id'] );
                error_log( "comment_id : " . $parameters['comment_id'] );
            }
            
            if( $item_id == "" || $comment_id == "" ){
                $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
                return;
            }
            
            /*$feedComments = $this->schoolmodel->getSchoolFeedComments( $school_id, $user_id, $item_id, 
                                                    $comment_id, _FORUM_DEFAULT_COMMENT_DETAIL_SIZE, _FEED_SHORT_PARAMS ); */
            
            $feedComments = $this->parentmodel->getFeedComments( $school_id, $user_id, $item_id, $comment_id, 
                                                    _FORUM_DEFAULT_COMMENT_DETAIL_SIZE, _FEED_SHORT_PARAMS );
            $this->restutilities->sendResponse( 200,    
                    '{"success": "true", "comments" : ' . json_encode( $feedComments ) . ' }' );//get short form feed names and send
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
    }
    
    public function postClassCommentREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER
                        || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            $school_id = '0';
            $item_id = "";
            $comment = "";
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];
            
            if( array_key_exists( 'item_id', $parameters) && is_string( $parameters['item_id'] ) ){
                $item_id = trim( $parameters['item_id'] );
                error_log( "item_id : " . $parameters['item_id'] );
            }
            
            if( array_key_exists( 'comment', $parameters) && is_string( $parameters['comment'] ) ){
                $comment = trim( $parameters['comment'] );
                error_log( "comment : " . $parameters['comment'] );
            }
            
            if( $item_id == "" || $comment == "" ){
                $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
                return;
            }
            
            error_log("params : user_id : $user_id, user_type : $user_type, item_id : $item_id, comment : $comment ");
            
            if( trim($user_type) == _USER_TYPE_PARENT ){
                $this->load->model('parentmodel');
                $added = $this->parentmodel->addComment( $school_id, $user_id, $user_type, $item_id, $comment );
            } else {
                $this->load->model('teachermodel');
                $added = $this->teachermodel->addClassComment( $school_id, $user_id, $user_type, $item_id, $comment );
            }
            
            //$added = $this->parentmodel->addComment( $school_id, $user_id, $user_type, $item_id, $comment );
            //$added = $this->schoolmodel->addSchoolComment( $school_id, $user_id, $user_type, $item_id, $comment );
            if(is_array($added)){
                $comment = RestUtilities::escapeParamQuotes( $comment );
                $this->restutilities->sendResponse( 200,    
                    '{"success": "true", "comment_id" : "' . $added[0] . '", "username" : "' . $added[1] . 
                            '", "display_date" : "' . $added[2] . '", "comment" : "' . $comment . '" }' );
            } else {
                $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
                return;
            }
            
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
    }
    
    public function uploadCFPicREST(){
        error_log( "in uploadCFpic. file : " . print_r( $_FILES, true ) );
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getMultipartPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER 
                    || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            error_log( "req_params : " . print_r( $parameters, true ) );
            $description = "";
            $posted_text = "";
            $class_id = "";
            if( array_key_exists( 'description', $parameters) && is_string( $parameters['description'] ) ){
                $description = trim( $parameters['description'] );
                $description_arr = explode(_CLASSFEED_UPLOAD_IMAGE_SEPARATOR, $description);
                $class_id = trim($description_arr[0]);
                if( count($description_arr) > 1 ){
                    $posted_text = trim($description_arr[1]);
                }
                error_log( "posted_text : " . $parameters['description'] );
            }

            if( $class_id == "" ){
                $this->restutilities->sendResponse( 200,    
                        '{"success": "false" }' );
                return;
            }
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            $class_meta_id = $this->schoolmodel->getClassMetaID( $school_id, $class_id );
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];    
            
            $isValid['success'] = false;
            if( isset( $_FILES["picture"] ) && isset($_FILES["picture"]["error"])
                    && $_FILES["picture"]["error"] == 0 ){
                error_log( "in err if : " );
                $is_rest_upload = true;
                $isValid = $this->validateImage( "picture", _FORUM_IMAGE_MAX_SIZE, $is_rest_upload );
                /*if( !( exif_imagetype($_FILES["picture"]['tmp_name'] ) > 0 )
                    || $_FILES["picture"]["type"] != "image/jpeg" ){
                    error_log( "in not jpeg : " );
                    $isValid['success'] = false;
                }*/
            }
            $success = false;
            if( $isValid['success'] ){
                $timestamp = time();
                $filename = $timestamp . '_' . $user_id . ".jpg";
                $file = _FORUM_IMAGE_FOLDER . '/' . $class_meta_id . '/' . $filename;
                $file_s3 = _FORUM_IMAGE_S3_FOLDER . '/' . $class_meta_id . '/' . $filename;
                error_log("file : " . $file);
                
                $success = $this->saveFile($_FILES['picture']['tmp_name'], $file, $file_s3);
                /*$try_count = 3;
                while( $try_count > 0 ){
                    error_log("mv_up_f ");
                    //move_uploaded_file($_FILES['picture']['tmp_name'], $file);
                    $moved = $this->move_to_s3($_FILES['picture']['tmp_name'], $file_s3);
                    //$this->compress($_FILES['picture']['tmp_name'], $file, $compression_quality);
                    if( /*file_exists($file)* $moved ){
                        $success = true;
                        break;
                    }
                    $try_count--;
                } */
            } 
            
            if( $success ){
                $post_type = _FORUM_ITEM_TYPE_PICTURE;
                $pic_url = $class_meta_id . "/" . $filename;
                $this->load->model('parentmodel');
                $result = $this->parentmodel->insertPicturePost( $school_id, $user_id, $user_type, 
                                                        $post_type, $pic_url, $posted_text, $class_id );
                //$result = $this->schoolmodel->insertSchoolPicturePost( $school_id, $user_id, $user_type, $post_type, $pic_url, $posted_text );
                if( $result == false ){
                    $success = false;
                }
            }
            
            if( $success ){
                $this->restutilities->sendResponse( 200,    
                    '{"success": "true" }' );
                return;
            } else {
                $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
                return;
            }
        }
    }
    
    public function deleteClassPostREST(){        
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim( $user_details['user_id'] );
        $parameters = $requestParams['data'];
        if( array_key_exists( 'item_id', $parameters) && is_string( $parameters['item_id'] ) ){
            $item_id = trim( $parameters['item_id'] );
            error_log( "item_id : " . $parameters['item_id'] );
            $this->load->model('parentmodel');
            $deleted = $this->parentmodel->deletePost( $school_id, $user_id, $item_id );
            if( $deleted ){
                $deleted = "true";
            } else {
                $deleted = "false";
            }
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $deleted . '", "item_id": "' . $item_id . '" }' );
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function deleteCFCommentREST(){        
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim( $user_details['user_id'] );
        $parameters = $requestParams['data'];
        if( array_key_exists( 'comment_id', $parameters) && is_string( $parameters['comment_id'] ) && 
                array_key_exists( 'item_id', $parameters) && is_string( $parameters['item_id'] ) ){
            $comment_id = trim( $parameters['comment_id'] );
            $item_id = trim( $parameters['item_id'] );
            error_log( "comment_id : " . $parameters['comment_id'] . " :: item_id : " . $parameters['item_id'] );
            $this->load->model('parentmodel');
            $deleted = $this->parentmodel->deleteComment( $school_id, $user_id, $item_id, $comment_id );
            if( $deleted ){
                $deleted = "true";
            } else {
                $deleted = "false";
            }
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $deleted . '", "comment_id": "' . $comment_id . '" }' );
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function addTextPostClassREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER
                        || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            if( array_key_exists( 'posted_text', $parameters) && is_string( $parameters['posted_text'] ) ){
                $posted_text = trim( $parameters['posted_text'] );
                error_log( "posted_text : " . $parameters['posted_text'] );
            }

            if( array_key_exists( 'classId', $parameters) && is_string( $parameters['classId'] ) ){
                $classId = trim( $parameters['classId'] );
                error_log( "classId : " . $parameters['classId'] );
            }
            
            
            $school_id = '0';
            $user_id = $user_details['user_id'];
            $user_type = $user_details['user_type'];
            //$text  = ( isset($_POST["text"] ) ? html_entity_decode(trim($_POST["text"])) : "" );
            $post_type = _FORUM_ITEM_TYPE_TEXT;
            error_log( "posted_text : " . $posted_text . " ::: user_id, user_type : " . $user_id . ", " . $user_type );
            //$school_id, $text, $post_type, $user_id, $user_type
            
            if( trim($user_details['user_type']) == _USER_TYPE_PARENT ){
                $this->load->model('parentmodel');
                $item_id = $this->parentmodel->addClassForumPost( $school_id, $posted_text, $post_type, $user_id, $user_type );
            } else {
                $this->load->model('teachermodel');
                $item_id = $this->teachermodel->addClassForumPost( $school_id, $classId, $posted_text, $post_type, 
                        $user_id, $user_type );
                error_log( "item_id : " . $item_id );
            }
            
            $success = "true";
            if( $item_id === FALSE ){
                $success = "false";
            } 
            
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $success . '" }' );
            return;
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
    }
    
    public function fetchClassNotifsREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_SCHOOL || $user_details['user_type'] == _USER_TYPE_TEACHER
                        || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            if( array_key_exists( 'classId', $parameters) && is_string( $parameters['classId'] ) ){
                $classId = trim( $parameters['classId'] );
                error_log( "classId : " . $parameters['classId'] );
            }
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            $classNotifications = $this->schoolmodel->getClassNotifications( $school_id, $classId );
            error_log( "classId : " . $classId );
            $success = "true";
            /*if( count($classNotifications) == 0 ){
                $success = "false";
            } */
            
            error_log( "notifications : " . json_encode($classNotifications) );
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $success . '", "classId" : "' . $classId . '", "notifications" : ' 
                            . json_encode($classNotifications) . ' }' );
            return;
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
    }
    
    public function fetchTeacherProfileREST(){
        error_log("in fetchTeacherProfileREST" );
	$this->load->library('RestUtilities');
        //$requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        $this->load->model('schoolmodel');
        $profileDetails = $this->schoolmodel->getTeacherProfileDetails( $school_id, $user_id );
        if( count($profileDetails) > 0 ){
            $this->restutilities->sendResponse( 200, 
                    '{"success": "true", "profileDetails": ' . json_encode($profileDetails) . ' }' );
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function getCurrentTimestamp(){
        error_log("in fetchTeacherProfileREST" );
	$this->load->library('RestUtilities');
        //$requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $cur_timestamp = time();
        $this->restutilities->sendResponse( 200,    
                    '{"success": "true", "current_timestamp" : "' . $cur_timestamp . '" }' );
            return;
    }
    
    public function fetchHomeWorkByClassREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( $user_details['user_type'] == _USER_TYPE_TEACHER || $user_details['user_type'] == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            $classId = "";
            $hwDate = "";
            $fetchBy = "";
            $fetchedIds = "";
            if( array_key_exists('classId', $parameters) && is_string( $parameters['classId'] )){
                $classId = trim( $parameters['classId'] );
                error_log( "classId : " . $parameters['classId'] );
            }
            
            if( array_key_exists('hwDate', $parameters) && is_string( $parameters['hwDate'] )){
                $hwDate = trim( $parameters['hwDate'] );
                error_log( "hwDate : " . $parameters['hwDate'] );
            }
            
            if( array_key_exists('fetchBy', $parameters) && is_string( $parameters['fetchBy'] )){
                $fetchBy = trim( $parameters['fetchBy'] );
                error_log( "fetchBy : " . $parameters['fetchBy'] );
            }
            
            if( array_key_exists('fetchedIds', $parameters) && is_string( $parameters['fetchedIds'] )){
                $fetchedIds = trim( $parameters['fetchedIds'] );
                error_log( "fetchedIds : " . $parameters['fetchedIds'] );
            }
            ///fetchedIds
            $school_id = '0';
            $homeworkList = array();
            if( $classId != "" && $hwDate != "" && $fetchBy != "" ){
                $this->load->model('teachermodel');
                $homeworkList = $this->teachermodel->getHomeWorkByClass($school_id, $classId, trim($user_details['user_id']), 
                        trim($user_details['user_type']), $hwDate, $fetchBy, $fetchedIds, _GENERIC_SHORT_PARAMS);
            }
            $success = "true";
            
            error_log( "homeworkList : " . json_encode($homeworkList) );
            $enc_homeworkList = json_encode($homeworkList);
            $enc_homeworkList = preg_replace('/\n/', '\\n', $enc_homeworkList);
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $success . '", "classId" : "' . $classId . '", "hwDate" : "' . $hwDate . '", ' .
                    '"fetchBy" : "' . $fetchBy . '", "homeworkList" : ' . $enc_homeworkList . ' }' );
            return;
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
        
    }
    
    public function fetchHomeWorkByTimeREST(){
        error_log("in fetchHomeWorkByTimeREST");
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( trim($user_details['user_type']) == _USER_TYPE_TEACHER || 
                    trim($user_details['user_type']) == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            $classId = "";
            $subjectId = "";
            $lastHwId = "";
            $fetchFwd = "";
            if( array_key_exists( 'classId', $parameters) && is_string( $parameters['classId'] )){
                $classId = trim( $parameters['classId'] );
                error_log( "classId : " . $parameters['classId'] );
            }
            
            if( array_key_exists( 'subjectId', $parameters) && is_string( $parameters['subjectId'] )){
                $subjectId = trim( $parameters['subjectId'] );
                error_log( "subjectId : " . $parameters['subjectId'] );
            }
            
            if( array_key_exists( 'lastHwId', $parameters) && is_string( $parameters['lastHwId'] )){
                $lastHwId = trim( $parameters['lastHwId'] );
                error_log( "lastHwId : " . $parameters['lastHwId'] );
            }
            
            if( array_key_exists( 'fetchFwd', $parameters) && is_string( $parameters['fetchFwd'] )){
                $fetchFwd = trim( $parameters['fetchFwd'] );
                error_log( "fetchFwd : " . $parameters['fetchFwd'] );
            }
            
            $school_id = '0';
            $last_hw_id_fetched = "";
            $first_hw_id_fetched = "";
            $teacher_user_id = trim($user_details['user_id']);
            $homeworkList = array();
            if( $classId != "" && $subjectId != "" ){
                $this->load->model('teachermodel');
                $homeworkList = $this->teachermodel->fetchHWHistory( $school_id, trim($user_details['user_type']), 
                        $teacher_user_id, $classId, $subjectId, $lastHwId, $fetchFwd, _GENERIC_SHORT_PARAMS);
                if( count($homeworkList) > 0 ){
                    $last_hw_id_fetched = trim($homeworkList[count($homeworkList)-1]['i']);
                    $first_hw_id_fetched = trim($homeworkList[0]['i']);
                }
            }
            $success = "true";
            /*if( count($classNotifications) == 0 ){
                $success = "false";
            } */
            
            error_log( "homeworkList : " . json_encode($homeworkList) );
            $enc_homeworkList = json_encode($homeworkList);
            $enc_homeworkList = preg_replace('/\n/', '\\n', $enc_homeworkList);
            $this->restutilities->sendResponse( 200,    
                    '{"success": "' . $success . '", "classId" : "' . $classId . '", "subjectId" : "' . $subjectId . '", "homeworkList" : ' 
            . $enc_homeworkList . ', "lastHwIdFetched" : "' . $last_hw_id_fetched . '", "firstHwIdFetched" : "' . $first_hw_id_fetched . '" }' );
            return;
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
        
    }
    
    public function addHomeWorkREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                $user_details['user_type'] == _USER_TYPE_TEACHER ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            
            $school_id = '0';
            $user_id = trim($user_details['user_id']);
            $classId = "";
            $subjectId = "";
            if( array_key_exists( 'classId', $parameters) && is_string( $parameters['classId'] )){
                $classId = trim( $parameters['classId'] );
                error_log( "classId : " . $parameters['classId'] );
            }
            
            if( array_key_exists( 'subjectId', $parameters) && is_string( $parameters['subjectId'] )){
                $subjectId = trim( $parameters['subjectId'] );
                error_log( "subjectId : " . $parameters['subjectId'] );
            }
            
            if( array_key_exists( 'homeWorkText', $parameters) && is_string( $parameters['homeWorkText'] )){
                $homeWorkText = trim( $parameters['homeWorkText'] );
                error_log( "homeWorkText : " . $parameters['homeWorkText'] );
            }
            
            if( array_key_exists( 'submitBy', $parameters) && is_string( $parameters['submitBy'] )){
                $submitBy = trim( $parameters['submitBy'] );
                error_log( "submitBy : " . $parameters['submitBy'] );
            }
            
            $added_hw_id = "";
            $this->load->model('teachermodel');
            $added = $this->teachermodel->addHomeWork( $school_id, $user_id, $classId, $subjectId, $homeWorkText, $submitBy, $added_hw_id );
            
            $homeWorkText = preg_replace('/\n/', '\\n', $homeWorkText);
            $this->restutilities->sendResponse( 200,    
                    '{ "success": "' . $added . '", "homeworkId" : "' . $added_hw_id . 
                        '", "homeWorkText" : "' . $homeWorkText . '", "submitBy" : "' . $submitBy . 
                        '", "classId" : "' . $classId . '", "subjectId" : "' . $subjectId . '" }' );
        }
    }
    
    public function editHomeWorkREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                $user_details['user_type'] == _USER_TYPE_TEACHER ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            
            $school_id = '0';
            $user_id = trim($user_details['user_id']);
            $homeworkId = "";
            $homeWorkText = "";
            $submitBy = "";
            $submitByTS = "";
            if( array_key_exists( 'homeworkId', $parameters) && is_string( $parameters['homeworkId'] )){
                $homeworkId = trim( $parameters['homeworkId'] );
                error_log( "homeworkId : " . $parameters['homeworkId'] );
            }
            
            if( array_key_exists( 'homeWorkText', $parameters) && is_string( $parameters['homeWorkText'] )){
                $homeWorkText = trim( $parameters['homeWorkText'] );
                error_log( "homeWorkText : " . $parameters['homeWorkText'] );
            }
            
            if( array_key_exists( 'submitBy', $parameters) && is_string( $parameters['submitBy'] )){
                $submitBy = trim( $parameters['submitBy'] );
                error_log( "submitBy : " . $parameters['submitBy'] );
            }
            
            if( array_key_exists( 'submitByTS', $parameters) && is_string( $parameters['submitByTS'] )){
                $submitByTS = trim( $parameters['submitByTS'] );
                error_log( "submitByTS : " . $parameters['submitByTS'] );
            }
            
            $this->load->model('teachermodel');
            $edited = $this->teachermodel->editHomeWork( $school_id, $user_id, $homeworkId, $homeWorkText, 
                                                    $submitBy, $class_id, $subject_id );
            
            $homeWorkText = preg_replace('/\n/', '\\n', $homeWorkText);
            $this->restutilities->sendResponse( 200,    
                    '{ "success": "' . $edited . '", "homeworkId" : "' . $homeworkId . '", "homeWorkText" : "' . $homeWorkText . 
                        '", "submitBy" : "' . $submitBy . '", "submitByTS" : "' . $submitByTS .
                        '", "classId" : "' . $class_id . '", "subjectId" : "' . $subject_id . '" }' );
        }
    }
    
    public function deleteHomeWorkREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                $user_details['user_type'] == _USER_TYPE_TEACHER ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            
            $school_id = '0';
            $user_id = trim($user_details['user_id']);
            $homeworkId = "";
            if( array_key_exists( 'homeworkId', $parameters) && is_string( $parameters['homeworkId'] )){
                $homeworkId = trim( $parameters['homeworkId'] );
                error_log( "homeworkId : " . $parameters['homeworkId'] );
            }
            
            $this->load->model('teachermodel');
            $deleted = $this->teachermodel->deleteHomeWork( $school_id, $user_id, $homeworkId );
            $this->restutilities->sendResponse( 200,    
                    '{ "success": "' . $deleted . '", "homeworkId" : "' . $homeworkId . '" }' );
        }
    }
    
    public function fetchTeacherTTSelfREST(){
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                $user_details['user_type'] == _USER_TYPE_TEACHER ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            
            $school_id = '0';
            $user_id = trim($user_details['user_id']);
            if( array_key_exists( 'timestamp', $parameters) && is_string( $parameters['timestamp'] )){
                $timestamp = trim( $parameters['timestamp'] );
                error_log( "timestamp : " . $parameters['timestamp'] );
            }
            
            $teacherTimeTable = array();
            $this->load->model('schoolmodel');
            $hasTeacherTTChanged = $this->schoolmodel->hasTeacherTimeTableChanged( $school_id, $user_id, $timestamp );
            $hasChangedStr = "false";
            if( $hasTeacherTTChanged ){
                $teacherTimeTable = $this->schoolmodel->getTeacherTimeTableShort( $school_id, $user_id, true );
                $hasChangedStr = "true";
            }
            
            $this->restutilities->sendResponse( 200,    
                '{"success": "true", "hasChanged" : "' . $hasChangedStr 
                        . '", "teacherTimeTable": ' . json_encode($teacherTimeTable) . ' }' );
        }
    }
    
    public function fetchClassTTREST(){
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' )   ;
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && (trim($user_details['user_type']) == _USER_TYPE_TEACHER 
                || trim($user_details['user_type']) == _USER_TYPE_PARENT )){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            
            $school_id = '0';
            $user_id = trim($user_details['user_id']);
            if( array_key_exists( 'classId', $parameters) && is_string( $parameters['classId'] )){
                $classId = trim( $parameters['classId'] );
                error_log( "classId : " . $parameters['classId'] );
            }
            
            if( array_key_exists( 'timestamp', $parameters) && is_string( $parameters['timestamp'] )){
                $timestamp = trim( $parameters['timestamp'] );
                error_log( "timestamp : " . $parameters['timestamp'] );
            }
            
            $classTimeTable = array();
            $this->load->model('schoolmodel');//hasClassTimetableChanged( $school_id, $class_id, $timestamp )
            $hasTeacherTTChanged = $this->schoolmodel->hasClassTimetableChanged( $school_id, $classId, $timestamp );
            $hasChangedStr = "false";
            if( $hasTeacherTTChanged ){
                $classTimeTable = $this->schoolmodel->getTimetableShort( $school_id, $classId );
                $hasChangedStr = "true";
            }
            
            $this->restutilities->sendResponse( 200,    
                '{"success": "true", "hasChanged" : "' . $hasChangedStr . '", "classId" : "' . $classId
                        . '", "classTimeTable": ' . json_encode($classTimeTable) . ' }' );
        }
    }
    
    public function fetchClassTestsREST(){
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' )   ;
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( trim($user_details['user_type']) == _USER_TYPE_TEACHER || 
                        trim($user_details['user_type']) == _USER_TYPE_SCHOOL ||
                         trim($user_details['user_type']) == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            
            $school_id = '0';
            $user_id = trim($user_details['user_id']);
            if( array_key_exists( 'classId', $parameters) && is_string( $parameters['classId'] )){
                $classId = trim( $parameters['classId'] );
                error_log( "classId : " . $parameters['classId'] );
            }
            
            $classTests = array();
            $this->load->model('teachermodel');
            $classTests = $this->teachermodel->getClassTestDetailsShort( $school_id, 
                                    $user_id, $classId, trim($user_details['user_type']) );
            $this->restutilities->sendResponse( 200,    
                '{"success": "true", "classId" : "' . $classId 
                        . '", "classTests": ' . json_encode($classTests) . ' }' );
        }
    }
    
    public function fetchTestScheduleREST(){
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' )   ;
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( trim($user_details['user_type']) == _USER_TYPE_TEACHER ||
                    trim($user_details['user_type']) == _USER_TYPE_SCHOOL ||
                    trim($user_details['user_type']) == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            
            $school_id = '0';
            $user_id = trim($user_details['user_id']);
            if( array_key_exists( 'testId', $parameters) && is_string( $parameters['testId'] )){
                $testId = trim( $parameters['testId'] );
                error_log( "testId : " . $parameters['testId'] );
            }
            
            $classTestSchedule = array();
            $this->load->model('schoolmodel');
            $classTestSchedule = $this->schoolmodel->getTestDetailsShort( $school_id, $testId );
            $this->restutilities->sendResponse( 200,    
                '{"success": "true", "testId" : "' . $testId 
                        . '", "testSchedule": ' . json_encode($classTestSchedule) . ' }' );
        }
    }
    
    public function fetchTestSubjectsREST(){
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' )   ;
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( trim($user_details['user_type']) == _USER_TYPE_TEACHER ||
                    trim($user_details['user_type']) == _USER_TYPE_SCHOOL || 
                    trim($user_details['user_type']) == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            
            $school_id = '0';
            $user_id = trim($user_details['user_id']);
            if( array_key_exists( 'testId', $parameters) && is_string( $parameters['testId'] )){
                $testId = trim( $parameters['testId'] );
                error_log( "testId : " . $parameters['testId'] );
            }
            
            $testSubjects = array();
            $this->load->model('schoolmodel');
            $testSubjects = $this->schoolmodel->getTestSubjectsShort( $school_id, $testId );
            $this->restutilities->sendResponse( 200,    
                '{"success": "true", "testId" : "' . $testId 
                        . '", "testSubjects": ' . json_encode($testSubjects) . ' }' );
        }
    }
    
    public function fetchTestScoresREST(){
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' )   ;
            return;
        }
        
        if( array_key_exists('user_type', $user_details) && 
                ( trim($user_details['user_type']) == _USER_TYPE_TEACHER ||
                    trim($user_details['user_type']) == _USER_TYPE_SCHOOL ||
                    trim($user_details['user_type']) == _USER_TYPE_PARENT ) ){
            $this->load->library('Logging');
            $parameters = $requestParams['data'];
            
            $school_id = '0';
            $user_id = trim($user_details['user_id']);
            if( array_key_exists( 'testId', $parameters) && is_string( $parameters['testId'] )){
                $testId = trim( $parameters['testId'] );
                error_log( "testId : " . $parameters['testId'] );
            }
            
            if( array_key_exists( 'subjectId', $parameters) && is_string( $parameters['subjectId'] )){
                $subjectId = trim( $parameters['subjectId'] );
                error_log( "subjectId : " . $parameters['subjectId'] );
            }
            
            $testScores = array();
            $this->load->model('teachermodel');
            $testScores = $this->teachermodel->getClassTestScores( $school_id, $user_id, 
                                                $testId, $subjectId, _GENERIC_SHORT_PARAMS );
            
            $this->restutilities->sendResponse( 200,    
                '{"success": "true", "testId" : "' . $testId . '", "subjectId" : "' . $subjectId
                        . '", "testScores": ' . json_encode($testScores) . ' }' );
            
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' )   ;
        }
    }
    
    public function schoolLoginsREST(){
        error_log("in schoolLoginsREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();

	error_log( "req params : " . print_r( $requestParams, true ) . "\n" );        
        if( $requestParams ){
            $school_id = '0';
            $lastUpdatedTimestamp = "";
            
            $parameters = $requestParams['data'];
            if( array_key_exists( 'lastUpdatedTimestamp', $parameters) && is_string( $parameters['lastUpdatedTimestamp'] ) ){
                $lastUpdatedTimestamp = trim( $parameters['lastUpdatedTimestamp'] );
            }
            
            $this->load->model( 'schoolmodel' );
            $schoolLogins = $this->schoolmodel->getSchoolLoginList( $school_id, $lastUpdatedTimestamp );
            $schoolLoginJson = json_encode($schoolLogins);
            
            $updated_timestamp = $this->schoolmodel->getUpdatedTimestamp( $school_id, _SCHOOL_LOGINS_TABLE_ID );
            $updated_timestamp = $updated_timestamp[0]['update_timestamp'];
            $this->restutilities->sendResponse( 200, 
                    '{"success": "true", "updated_timestamp": "' . $updated_timestamp . 
                            '", "schoolLogins" : ' . $schoolLoginJson .' }' );
            return;
        }
    }
    
    public function fetchParentProfileREST(){
        error_log("in fetchParentProfileREST" );
	$this->load->library('RestUtilities');
        //$requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( trim($user_details['user_type']) != _USER_TYPE_PARENT ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        $this->load->model('schoolmodel');
        $parentProfileDetails = $this->schoolmodel->getParentProfileDetails( $school_id, $user_id );
        $studentProfileDetails = $this->schoolmodel->getStudentProfileDetails( $school_id, $user_id );
        
        if( count($parentProfileDetails) > 0 && count($studentProfileDetails) > 0 ){
            $this->restutilities->sendResponse( 200, 
                    '{"success": "true", "parentProfileDetails": ' . json_encode($parentProfileDetails) . 
                        ', "studentProfileDetails": ' . json_encode($studentProfileDetails) . ' }' );
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function saveMemoriesREST(){
        error_log("in saveMemoriesREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        if( $requestParams ){
            $school_id = '0';
            $imageUrl = "";
            
            $parameters = $requestParams['data'];
            if( array_key_exists( 'imageUrl', $parameters) && is_string( $parameters['imageUrl'] ) ){
                $imageUrl = trim( $parameters['imageUrl'] );
            }
            
            $this->load->model( 'schoolmodel' );
            $memory_id = $this->schoolmodel->saveMemory( $school_id, $user_id, $imageUrl );
            if( $memory_id > 0 ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "memoryId" : "' . $memory_id . '", "imageUrl": "' . $imageUrl . '" }' );
            } else {
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false"}' );
            }
            
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function savePushTokenREST(){
        error_log("in savePushTokenREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        if( $requestParams ){
            $school_id = '0';
            $pushToken = "";
            
            $parameters = $requestParams['data'];
            if( array_key_exists( 'pushToken', $parameters) && is_string( $parameters['pushToken'] ) ){
                $pushToken = trim( $parameters['pushToken'] );
            }
            
            $this->load->model( 'schoolmodel' );
            $saved = $this->schoolmodel->savePushToken( $school_id, $user_id, $pushToken );
            if( $saved ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "true"}' );
            } else {
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false"}' );
            }
            
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function sendMessageNotification($school_id, $recipient_user_id){
        $this->load->model('schoolmodel');
        $this->load->library('Logging');
        $inbox_count = FALSE;
        $endPointArn = FALSE;
        if( _MEMCACHE_ENABLED ){
            $memcache = new MemcacheLibrary();
            $inbox_cnt_key = _INBOX_COUNT . "_" . $school_id . "_" . $recipient_user_id;
            $endPointArnKey = _USERS_KEY_PREFIX . $school_id . "_" . $recipient_user_id . "_" . _MEMCACHE_USERS_APP_ENDPOINT;
            $inbox_count = $memcache->getKey($inbox_cnt_key);
            $endPointArn = $memcache->getKey($endPointArnKey);
        }
        
        if( $inbox_count == FALSE ){
            $inbox_count = $this->schoolmodel->getInboxCount( $recipient_user_id, $school_id );
        } 
        
        if( $inbox_count == FALSE || $inbox_count == "" ){
            $inbox_count = "1";
        }
        
        if( $endPointArn == FALSE ){
            $endPointArn = $this->schoolmodel->getEndpointArn($school_id, $recipient_user_id);
        }
        
        $timestamp = time();
        $message_json = '{ "notif_type" : "' . _INBOX_NOTIF_DESC . '", "data" : { "timestamp" : "' . $timestamp . 
                                '", "unreadMsgs" : "' . $inbox_count . '" } }';
        
        try{
            $snsClient = new AwsSNS();
            $subject = "New Inbox Message";
            if( $endPointArn != FALSE && $endPointArn != "" ){
                $messageId = $snsClient->publish("", $endPointArn, $message_json, $subject );
            }
            
        } catch( Exception $e ){
            $this->logging->logError( "Exception in sending inbox notif. recipient_user_id : " . $recipient_user_id,
                                __FILE__, __FUNCTION__, __LINE__, "" );
        }
    }
    
    public function sendStarNotification($school_id, $student_id, $teacher_user_id, $star_desc){
        $this->load->model('schoolmodel');
        $this->load->library('Logging');
        $teacher_id = FALSE;
        $parent_1_user_id = FALSE;
        $parent_2_user_id = FALSE;
        $endPointArn1 = FALSE;
        $endPointArn2 = FALSE;
        if( _MEMCACHE_ENABLED ){
            $memcache = new MemcacheLibrary();
            
            $parentId_1_Key = _STUDENTS_KEY_PREFIX . $school_id . "_" . $student_id . "_" . _MEMCACHE_STUDENTS_PARENT_1_ID;
            $parentId_2_Key = _STUDENTS_KEY_PREFIX . $school_id . "_" . $student_id . "_" . _MEMCACHE_STUDENTS_PARENT_2_ID;
            $parent_1_id = $memcache->getKey($parentId_1_Key);
            $parent_2_id = $memcache->getKey($parentId_2_Key);
            
            if( $parent_1_id != FALSE ){
                $parent_1_user_id_key = _PARENTS_KEY_PREFIX . $school_id . "_" . $parent_1_id . "_" . _MEMCACHE_PARENTS_USER_ID;
                $parent_1_user_id = $memcache->getKey($parent_1_user_id_key); 
            }
            
            if( $parent_2_id != FALSE ){
                $parent_2_user_id_key = _PARENTS_KEY_PREFIX . $school_id . "_" . $parent_2_id . "_" . _MEMCACHE_PARENTS_USER_ID;
                $parent_2_user_id = $memcache->getKey($parent_2_user_id_key); 
            }
            
            if( $parent_1_user_id != FALSE ){
                $endPointArnKey1 = _USERS_KEY_PREFIX . $school_id . "_" . $parent_1_user_id . "_" . _MEMCACHE_USERS_APP_ENDPOINT;
                $endPointArn1 = $memcache->getKey($endPointArnKey1);
            }
            
            if( $parent_2_user_id != FALSE ){
                $endPointArnKey2 = _USERS_KEY_PREFIX . $school_id . "_" . $parent_2_user_id . "_" . _MEMCACHE_USERS_APP_ENDPOINT;
                $endPointArn2 = $memcache->getKey($endPointArnKey2);
            }
            
            $teacher_id_key = _USERS_KEY_PREFIX . $school_id . "_" . $teacher_user_id . "_" . _MEMCACHE_USERS_ID;
            $teacher_id = $memcache->getKey($teacher_id_key);
        }
        
        if( $parent_1_user_id == FALSE || $parent_2_user_id == FALSE ){
            $parent_user_ids = $this->schoolmodel->getParentUserIDs($school_id, $student_id);
            if( is_array($parent_user_ids) && count($parent_user_ids) > 1 ){
                $parent_1_user_id = $parent_user_ids[0];
                $parent_2_user_id = $parent_user_ids[1];
            }
            
        }
        
        if( $parent_1_user_id == FALSE && $parent_2_user_id == FALSE ){
            return;
        }
        
        if( $endPointArn1 == FALSE ){
            $endPointArn1 = $this->schoolmodel->getEndpointArn($school_id, $parent_1_user_id);
        }
        
        if( $endPointArn2 == FALSE ){
            $endPointArn2 = $this->schoolmodel->getEndpointArn($school_id, $parent_2_user_id);
        }
        
        if( $teacher_id == FALSE ){
            $teacher_id = $this->schoolmodel->getTeacherIDFromUserID($school_id, $teacher_user_id);
        }
        
        $message_json = '{ "notif_type" : "' . _STAR_NOTIF_DESC . '", "data" : { "teacher_id" : "' . $teacher_id . 
                                '", "star_desc" : "' . $star_desc . '" } }';
        
        try{
            $snsClient = new AwsSNS();
            $subject = "Star Awarded!";
            if( $endPointArn1 != FALSE && $endPointArn1 != "" ){
                $messageId1 = $snsClient->publish("", $endPointArn1, $message_json, $subject );
            }
            
            if( $endPointArn2 != FALSE && $endPointArn2 != "" ){
                $messageId2 = $snsClient->publish("", $endPointArn2, $message_json, $subject );
            }
            
        } catch( Exception $e ){
            $this->logging->logError( "Exception in sending star notif. student_id : " . $student_id,
                                __FILE__, __FUNCTION__, __LINE__, "" );
        }
    }
    
    public function saveStarREST(){
        error_log("in saveStarREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( trim($user_details['user_type']) != _USER_TYPE_TEACHER ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        if( $requestParams ){
            $school_id = '0';
            $student_id = "";
            $star_desc = "";
            
            $parameters = $requestParams['data'];
            if( array_key_exists( 'student_id', $parameters) && is_string( $parameters['student_id'] ) ){
                $student_id = trim( $parameters['student_id'] );
            }
            
            if( array_key_exists( 'star_desc', $parameters) && is_string( $parameters['star_desc'] ) ){
                $star_desc = trim( $parameters['star_desc'] );
            }
            
            $this->load->model( 'schoolmodel' );
            $saved = $this->schoolmodel->saveStars( $school_id, $user_id, $student_id, $star_desc );
            $this->sendStarNotification($school_id, $student_id, $user_id, $star_desc);
            if( $saved ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "true"}' );
            } else {
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false"}' );
            }
            
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function fetchStarsREST(){
        error_log("in fetchStarsREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( trim($user_details['user_type']) != _USER_TYPE_PARENT ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        if( $requestParams ){
            $parameters = $requestParams['data'];
            $last_star_id = "";
            $fetch_fwd = "false";
            
            if( array_key_exists( 'last_star_id', $parameters) && is_string( $parameters['last_star_id'] ) ){
                $last_star_id = trim( $parameters['last_star_id'] );
            }
            
            if( array_key_exists( 'fetch_fwd', $parameters) && is_string( $parameters['fetch_fwd'] ) ){
                $fetch_fwd = trim( $parameters['fetch_fwd'] );
            }
            
            $this->load->model( 'schoolmodel' );
            $star_records = $this->schoolmodel->fetchStars( $school_id, $user_id, $last_star_id, $fetch_fwd );
            $last_star_id_res = $last_star_id;
            if( count($star_records) > 0 ){
                $last_star_id_res = trim($star_records[count($star_records) - 1]['i']);
            }
            
            $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "starRecords" : ' . json_encode($star_records) . 
                                ', "last_star_id" : "' . $last_star_id_res . '" }' );
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function saveToDoItemREST(){
        error_log("in saveToDoItemREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        if( $requestParams ){
            error_log("req params : " . print_r($requestParams, true));
            $school_id = '0';
            $description = "";
            $doneFlag = "0";
            $remindIn = "-1";
            $toDoIdClient = "";
            
            //( $school_id, $user_id, $description, $doneFlag, $remindIn )
            $parameters = $requestParams['data'];
            if( array_key_exists( 'desc', $parameters) && is_string( $parameters['desc'] ) ){
                $description = trim($parameters['desc']);
            }
            
            if( array_key_exists( 'doneFlag', $parameters) && is_string( $parameters['doneFlag'] ) ){
                $doneFlag = trim($parameters['doneFlag']);
            }
            
            if( array_key_exists( 'remindIn', $parameters) && is_string( $parameters['remindIn'] ) ){
                $remindIn = trim($parameters['remindIn']);
            }
            
            if( array_key_exists( 'toDoIdClient', $parameters) && is_string( $parameters['toDoIdClient'] ) ){
                $toDoIdClient = trim($parameters['toDoIdClient']);
            }
            
            error_log("description : $description, doneFlag : $doneFlag, remindIn : $remindIn " );
            if( $description == "" ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false"}' );
            }

            
            $this->load->model( 'schoolmodel' );
            $toDoIdServer = $this->schoolmodel->saveToDoItem( $school_id, $user_id, $description, $doneFlag, $remindIn );
            if( $toDoIdServer != false ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "toDoIdServer" : "' . $toDoIdServer . '", "toDoIdClient" : "' . $toDoIdClient . '" }' );
            } else {
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false"}' );
            }
            
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function updateToDoItemREST(){
        error_log("in updateToDoItemREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        if( $requestParams ){
            error_log("req params : " . print_r($requestParams, true));
            $school_id = '0';
            $description = "";
            $doneFlag = "0";
            $remindIn = "";
            $toDoServerId = "";
            $toDoIdClient = "";
            
            $parameters = $requestParams['data'];
            if( array_key_exists( 'toDoIdClient', $parameters) && is_string( $parameters['toDoIdClient'] ) ){
                $toDoIdClient = trim($parameters['toDoIdClient']);
            }
            
            if( array_key_exists( 'toDoServerId', $parameters) && is_string( $parameters['toDoServerId'] ) ){
                $toDoServerId = trim($parameters['toDoServerId']);
            }
            
            if( array_key_exists( 'desc', $parameters) && is_string( $parameters['desc'] ) ){
                $description = trim($parameters['desc']);
            }
            
            if( array_key_exists( 'doneFlag', $parameters) && is_string( $parameters['doneFlag'] ) ){
                $doneFlag = trim($parameters['doneFlag']);
            }
            
            if( array_key_exists( 'remindIn', $parameters) && is_string( $parameters['remindIn'] ) ){
                $remindIn = trim($parameters['remindIn']);
            }
            
            if( $description == "" || $toDoServerId == "" ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false"}' );
            }

            error_log("description : $description, doneFlag : $doneFlag, remindIn : $remindIn, toDoServerId : $toDoServerId " );
            $this->load->model( 'schoolmodel' );
            $updated = $this->schoolmodel->updateToDoItem( $school_id, $user_id, 
                                        $toDoServerId, $description, $doneFlag, $remindIn );
            
            if( $updated ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "toDoIdClient" : "' . $toDoIdClient . '"}' );
            } else {
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false"}' );
            }
            
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function saveToDoItemsREST(){
        error_log("in saveToDoItemsREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        if( $requestParams ){
            error_log("req params : " . print_r($requestParams, true));
            $school_id = '0';
            $todoItems = "";
            $parameters = $requestParams['data'];
            if( array_key_exists( 'todoItems', $parameters) && is_array( $parameters['todoItems'] ) ){
                $todoItems = $parameters['todoItems'];
            }
            
            if( $todoItems == "" || count($todoItems) == 0 ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false"}' );
            }
            
            //$toDoList = json_decode($todoItems);
            error_log("todoItems obj : " . print_r($todoItems, true));
            $this->load->model( 'schoolmodel' );
            $savedItems = $this->schoolmodel->saveToDoItems( $school_id, $user_id, $todoItems );
            if( count($savedItems) > 0 ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "toDoMapObjs" : ' . json_encode($savedItems) . '}' );
            } else {
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false"}' );
            }
            
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function updateToDoItemsREST(){
        error_log("in updateToDoItemsREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        if( $requestParams ){
            $school_id = '0';
            $todoItems = "";
            $parameters = $requestParams['data'];
            if( array_key_exists( 'todoItems', $parameters) && is_array( $parameters['todoItems'] ) ){
                $todoItems = $parameters['todoItems'];
            }
            
            if( $todoItems == "" || count($todoItems) == 0 ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false"}' );
            }
            
            $this->load->model( 'schoolmodel' );
            $updatedItems = $this->schoolmodel->updateToDoItems( $school_id, $user_id, $todoItems );
            if( count($updatedItems) > 0 ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "toDoMapObjs" : ' . json_encode($updatedItems) . '}' );
            } else {
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false"}' );
            }
            
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function fetchToDoItemsREST(){
        error_log("in fetchToDoItemsREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        if( $requestParams ){
            $parameters = $requestParams['data'];
            $last_todo_id = "";
            $last_updated_ts = "";
            $fetch_fwd = "false";
            
            if( array_key_exists( 'last_todo_id', $parameters) && is_string( $parameters['last_todo_id'] ) ){
                $last_todo_id = trim( $parameters['last_todo_id'] );
            }
            
            if( array_key_exists( 'last_updated_ts', $parameters) && is_string( $parameters['last_updated_ts'] ) ){
                $last_updated_ts = trim( $parameters['last_updated_ts'] );
            }
            
            if( array_key_exists( 'fetch_fwd', $parameters) && is_string( $parameters['fetch_fwd'] ) ){
                $fetch_fwd = trim( $parameters['fetch_fwd'] );
            }
            
            $this->load->model( 'schoolmodel' );
            $todo_records = $this->schoolmodel->fetchToDoList( $school_id, $user_id, $last_todo_id, 
                                                                        $last_updated_ts, $fetch_fwd );
            
            $last_todo_id_db = "";
            if( count($todo_records) > 0 ){
                $last_todo_id_db = trim( $todo_records[ count($todo_records) - 1 ]['i'] );
            }
            
            $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "last_todo_id_resp" : "' . $last_todo_id_db . 
                                    '" , "toDoRecords" : ' . json_encode($todo_records) . '}' );
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function fetchSchoolLoginDashboardREST(){
        error_log("in fetchSchoolLoginDashboardREST" );
	$this->load->library('RestUtilities');
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( trim($user_details['user_type']) != _USER_TYPE_SCHOOL ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        $this->load->model('schoolmodel');
        
        $inboxCount = $this->getInboxUnreadCount($school_id, $user_id);
        $schoolFeedCnt = $this->schoolmodel->getSchoolFeedCount($school_id);
        $this->restutilities->sendResponse( 200, 
                    '{ "success" : "true", "inboxCnt" : "' . $inboxCount . '", "feedCnt" : "' . $schoolFeedCnt . '" }' );
        
    }
    
    public function fetchTeacherDashboardREST(){
        error_log("in fetchTeacherDashboardREST" );
	$this->load->library('RestUtilities');
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( trim($user_details['user_type']) != _USER_TYPE_TEACHER ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        $user_type = trim($user_details['user_type']);
        $this->load->model('schoolmodel');
        
        $completionDate =  date( "Y-m-d", time() );
        $postedDate = "";
        
        $inboxCount = $this->getInboxUnreadCount($school_id, $user_id);
        $hwCount = $this->schoolmodel->fetchHWCountByTime( $school_id, $user_id, 
                                            $user_type, $postedDate, $completionDate );
        $schoolFeedCnt = $this->schoolmodel->getSchoolFeedCount($school_id);
        $this->restutilities->sendResponse( 200, 
                    '{ "success" : "true", "inboxCnt" : "' . $inboxCount . '", "hwCnt" : "' 
                        . $hwCount . '", "feedCnt" : "' . $schoolFeedCnt . '" }' );
        
    }
    
    public function fetchParentDashboardREST(){
        error_log("in fetchParentDashboardREST" );
	$this->load->library('RestUtilities');
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        if( trim($user_details['user_type']) != _USER_TYPE_PARENT ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);
        $user_type = trim($user_details['user_type']);
        $this->load->model('schoolmodel');
        
        $completionDate =  "";
        $postedDate = date( "Y-m-d", time() );
        
        $inboxCount = $this->getInboxUnreadCount($school_id, $user_id);
        $hwCount = $this->schoolmodel->fetchHWCountByTime( $school_id, $user_id, 
                                            $user_type, $postedDate, $completionDate );
        $classFeedCnt = $this->schoolmodel->getClassFeedCount( $school_id, $user_id );
        $scoreCardCnt = $this->schoolmodel->getUploadedScoreCnt( $school_id, $user_id );
        
        $this->restutilities->sendResponse( 200, 
                    '{ "success" : "true", "inboxCnt" : "' . $inboxCount . '", "hwCnt" : "' 
                        . $hwCount . '", "feedCnt" : "' . $classFeedCnt . '", "scoreCardCnt" : "' . $scoreCardCnt['scoreCnt'] 
                        . '", "testId" : "' . $scoreCardCnt['test_id'] . '" }' );
        
    }
    
    public function getInboxUnreadCount($school_id, $user_id){
        $inbox_count = 0;
        if( _MEMCACHE_ENABLED ){
            $memcache = new MemcacheLibrary();
            $inbox_cnt_key = _INBOX_COUNT . "_" . $school_id . "_" . $user_id;
            $inbox_count = $memcache->getKey($inbox_cnt_key);
        }
        
        if( $inbox_count == FALSE ){
            $this->load->model('schoolmodel');
            $inbox_count = $this->schoolmodel->getInboxCount( $user_id, $school_id );
        } 
        
        if( $inbox_count == "" ){
            $inbox_count = "0";
        }
        
        return $inbox_count;
    }
    
    public function fetchUpdatedStudentsREST(){
        error_log("in fetchUpdatedStudentsREST" );
	$this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] )
                || !isset( $user_details['user_type'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);        
        $user_type = trim($user_details['user_type']);

        if( $requestParams ){
            $parameters = $requestParams['data'];
            $lastUpdatedTS = "";
            $lastStudentId = "";
            
            if( array_key_exists( 'lastUpdatedTS', $parameters) && is_string( $parameters['lastUpdatedTS'] ) ){
                $lastUpdatedTS = trim( $parameters['lastUpdatedTS'] );
            }
            
            if( array_key_exists( 'lastStudentId', $parameters) && is_string( $parameters['lastStudentId'] ) ){
                $lastStudentId = trim( $parameters['lastStudentId'] );
            }
            
            $this->load->model( 'schoolmodel' );
            $students = $this->schoolmodel->getStudentsUpdated( $school_id, $lastUpdatedTS, $lastStudentId, 
                                                                    $user_type, $user_id, _GENERIC_SHORT_PARAMS );
            
            $lastStudentIdDB = "";
            if( count($students) > 0 ){
                $lastStudentIdDB = trim( $students[ count($students) - 1 ]['i'] );
            }
            
            $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "lastStudentIdResp" : "' . $lastStudentIdDB . 
                                    '" , "students" : ' . json_encode($students) . '}' );
        } else {
            $this->restutilities->sendResponse( 200,    
                    '{"success": "false" }' );
        }
    }
    
    public function fetchUpdatedParentsREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        $request_headers = getallheaders();
        $session_id = "";
        $user_details = false;
        if( array_key_exists("SessionID", $request_headers) ){
            $session_id = urldecode( trim($request_headers['SessionID']) );
            $user_details = $this->getUserDetailsFromSessionID( $session_id );
            error_log("userdetails : " . print_r( $user_details, true ));
        }
        
        if( !is_array( $user_details ) || !isset( $user_details['user_id'] ) ){
            $this->restutilities->sendResponse( 200,    
                    '{ "success": "false", "error" : "' . trim($user_details['error']) . '" }' );
            return;
        }
        
        $school_id = '0';
        $user_id = trim($user_details['user_id']);        
        $user_type = trim($user_details['user_type']);

        if( $requestParams ){
            $parameters = $requestParams['data'];
            $lastUpdatedTS = "";
            $lastParentId = "";
            
            if( array_key_exists( 'lastUpdatedTS', $parameters) && is_string( $parameters['lastUpdatedTS'] ) ){
                $lastUpdatedTS = trim( $parameters['lastUpdatedTS'] );
            }
            
            if( array_key_exists( 'lastParentId', $parameters) && is_string( $parameters['lastParentId'] ) ){
                $lastParentId = trim( $parameters['lastParentId'] );
            }
            
            $this->load->model( 'schoolmodel' );
            $parents = $this->schoolmodel->getParentsUpdated( $school_id, $lastUpdatedTS, $lastParentId, 
                                                                    $user_type, $user_id, _GENERIC_SHORT_PARAMS );
            
            $lastParentIdDB = "";
            if( count($parents) > 0 ){
                $lastParentIdDB = trim( $parents[ count($parents) - 1 ]['i'] );
            }
            
            $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "lastParentIdResp" : "' . $lastParentIdDB . 
                                    '" , "parents" : ' . json_encode($parents) . '}' );
            return;
        }
    }
}

?>
