<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once( $DOC_ROOT . '/application/libraries/MemcacheLibrary.php' );

date_default_timezone_set("Asia/Kolkata");

class basic extends CI_Controller {

    public function index(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        $headerData = array();
        $displayData = array();
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            if( array_key_exists('user_type', $sessionUserData) ){
                $headerData['logged_in'] = $sessionUserData['logged_in'];
                $headerData['username'] = $sessionUserData['username'];
                $headerData['user_type'] = $sessionUserData['user_type'];
                $headerData['user_id'] = $sessionUserData['user_id'];
                
                $displayData['headerData'] = $headerData;
                $displayData['user_type'] = $sessionUserData['user_type'];
                $displayData['user_id']  = $sessionUserData['user_id'];
                $home_page = 'home';
                switch( $sessionUserData['user_type'] ){
                    case _USER_TYPE_ADMIN : 
                        $homeData = $this->getAdminHomeData();
                        break;
                    case _USER_TYPE_SCHOOL : 
                        $homeData = $this->getSchoolHomeData();
                        $home_page = 'school_home';
                        break;
                    case _USER_TYPE_TEACHER : 
                        $homeData = $this->getTeacherHomeData();
                        $home_page = 'school_home';
                        break;
                    case _USER_TYPE_STUDENT : 
                        $homeData = $this->getStudentHomeData();
                        break;
                    case _USER_TYPE_PARENT : 
                        $homeData = $this->getParentHomeData();
                        $home_page = 'parent_home';
                        break;                    
                    default : 
                        $homeData = $this->getStudentHomeData();
                        break;
                }
                $displayData['homeData'] = $homeData;
                $this->load->view($home_page, $displayData);
                return;
                
            } else {
                $headerData['logged_in'] = false;
                $displayData['headerData'] = $headerData;
                $homeData = $this->getGeneralHomeData();
                $displayData['homeData'] = $homeData;
                $this->load->view('home', $displayData);
                return;
            }
        }
        $headerData['logged_in'] = false;
        $displayData['headerData'] = $headerData;
        $homeData = $this->getGeneralHomeData();
        $displayData['homeData'] = $homeData;
        $this->load->view('home', $displayData);
    }
    
    public function login(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        //$this->session->unset_userdata($sessionUserData);
        //$this->session->set_userdata($newdata);
        $headerData = array();
        $displayData = array();
        error_log( "session data : " . print_r( $sessionUserData, true ) );
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            if( array_key_exists('user_type', $sessionUserData) ){
                $headerData['logged_in'] = $sessionUserData['logged_in'];
                $headerData['username'] = $sessionUserData['username'];
                $headerData['user_type'] = $sessionUserData['user_type'];
                $headerData['user_id'] = $sessionUserData['user_id'];
                
                $displayData['headerData'] = $headerData;
                $displayData['user_type'] = $sessionUserData['user_type'];
                $displayData['user_id']  = $sessionUserData['user_id'];
                $home_page = 'home';
                switch( $sessionUserData['user_type'] ){
                    case _USER_TYPE_ADMIN : 
                        $homeData = $this->getAdminHomeData();
                        break;
                    case _USER_TYPE_SCHOOL : 
                        $homeData = $this->getSchoolHomeData();
                        $home_page = 'school_home';
                        break;
                    case _USER_TYPE_TEACHER : 
                        $homeData = $this->getTeacherHomeData();
                        $home_page = 'school_home';
                        break;
                    case _USER_TYPE_STUDENT : 
                        $homeData = $this->getStudentHomeData();
                        break;
                    case _USER_TYPE_PARENT : 
                        $homeData = $this->getParentHomeData();
                        $home_page = 'parent_home';
                        break;                    
                    default : 
                        $homeData = $this->getStudentHomeData();
                        break;                   
                }
                
                $displayData['homeData'] = $homeData;
                $this->load->view($home_page, $displayData);
                return;
                
            } else {
                $headerData['logged_in'] = false;
                $displayData['headerData'] = $headerData;
                $homeData = $this->getGeneralHomeData();
                $displayData['homeData'] = $homeData;
                $this->load->view('home', $displayData);
            }
        } else {
            if( !array_key_exists('username', $_POST) && !array_key_exists('password', $_POST) ){
                error_log("redirect to login ");
                $headerData['logged_in'] = false;
                //$this->load->view('login'); 
                $displayData['headerData'] = $headerData;
                $homeData = $this->getGeneralHomeData();
                $displayData['homeData'] = $homeData;
                $this->load->view('home', $displayData);
                return;
            } 
            
            $username = "";
            $password = "";
            $authentic = 0;
            if(array_key_exists('username', $_POST) ){
                $username = trim( $_POST['username'] );
            }
            
            if(array_key_exists('password', $_POST)){
                $password = trim( $_POST['password'] );
            }
            
            $user_details = array();
            if( $username != "" && $password != "" ){
                $this->load->model('basicmodel');                
                $authentic = $this->basicmodel->authenticate( $username, $password, $user_details );
            } 
            
            if( $authentic == 0 || $authentic == 2 ){
                $headerData = array();
                $headerData['invalid_username']  = true;
                $headerData['username']      = $username;
                //$this->load->view('login');
                $headerData['logged_in'] = false;
                $displayData['headerData'] = $headerData;
                $homeData = $this->getGeneralHomeData();
                $displayData['homeData'] = $homeData;
                $this->load->view('home', $displayData);
                return;
            }
            
            if( $authentic == 3 ){
                $headerData = array();
                $headerData['incorrect_password']  = true;
                $headerData['username']      = $username;
                //$this->load->view('login');
                $headerData['logged_in'] = false;
                $displayData['headerData'] = $headerData;
                $homeData = $this->getGeneralHomeData();
                $displayData['homeData'] = $homeData;
                $this->load->view('home', $displayData);
                return;
            }
            
            if( $authentic == 1 ){
                $sessionUserData['user_id'] = $user_details['user_id'];
                $sessionUserData['username'] = $user_details['username'];               
                $sessionUserData['user_type'] = $user_details['user_type'];              
                $sessionUserData['last_login'] = $user_details['last_login'];             
                $sessionUserData['last_login_ip'] = $user_details['last_login_ip'];          
                $sessionUserData['init_password_changed'] = $user_details['init_password_changed']; 
                $sessionUserData['logged_in'] = true;
                
                error_log("authentic. user data : " . print_r( $sessionUserData, true ));
                $this->session->unset_userdata($sessionUserData);
                $this->session->set_userdata($sessionUserData);
                
                $sessionUserData1 = $this->session->all_userdata();
                $headerData['logged_in'] = $sessionUserData['logged_in'];
                $headerData['username'] = $sessionUserData['username'];
                $headerData['user_type'] = $sessionUserData['user_type'];
                $headerData['user_id'] = $sessionUserData['user_id'];
                
                $displayData['headerData'] = $headerData;
                $displayData['user_type'] = $sessionUserData['user_type'];
                $displayData['user_id']  = $sessionUserData['user_id'];
                $home_page = 'home';
                switch( $sessionUserData['user_type'] ){
                    case _USER_TYPE_ADMIN : 
                        $homeData = $this->getAdminHomeData();
                        break;
                    case _USER_TYPE_SCHOOL : 
                        $homeData = $this->getSchoolHomeData();
                        $home_page = 'school_home';
                        break;
                    case _USER_TYPE_TEACHER : 
                        $homeData = $this->getTeacherHomeData();
                        $home_page = 'school_home';
                        break;
                    case _USER_TYPE_STUDENT : 
                        $homeData = $this->getStudentHomeData();
                        break;
                    case _USER_TYPE_PARENT : 
                        $homeData = $this->getParentHomeData();
                        $home_page = 'parent_home';
                        break;                    
                    default : 
                        $homeData = $this->getStudentHomeData();
                        break;                    
                }
                $this->populateCounters();
                $displayData['homeData'] = $homeData;
                $this->load->view($home_page, $displayData);
                return;
            }
        }   
    }
     
    public function logout(){
	$this->load->library('session');
	$sessionUserData = $this->session->all_userdata();
	$this->session->unset_userdata($sessionUserData);
        $headerData = array();
        $headerData['logged_in'] = false;
	$displayData['header_message']="You have been logged out successfully !";        
        $displayData['headerData'] = $headerData;
        $homeData = $this->getGeneralHomeData();
        $displayData['homeData'] = $homeData;
	$this->load->view('home', $displayData);
    }
    
    public function getAdminHomeData(){
        return "";
    }
    
    public function getSchoolHomeData(){
        //$this->populateCounters();
        return "";
    }
    
    public function getTeacherHomeData(){
        return "";
    }
    
    public function getStudentHomeData(){
        return "";
    }
    
    public function getParentHomeData(){
        return "";
    }
    
    public function getGeneralHomeData(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('basicmodel');
        $notifications = $this->basicmodel->getGeneralNotifications( $school_id );
        $homePageData = "";
        
        $returnData = array();
        $returnData['notifications'] = $notifications;
        $returnData['homePageData']  = $homePageData;
        
        return $returnData;
        
    }
    
    public function getGeneralHomeDataREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        if( $requestParams ){
            $school_id = "0";
            $parameters = $requestParams['data'];
            
            if( array_key_exists( 'school_id', $parameters) && is_string( $parameters['school_id'] ) ){
                $school_id = trim($parameters['school_id']);
            }
            
            $this->load->model('basicmodel');
            $notifications = $this->basicmodel->getGeneralNotifications( $school_id );
            $notificationsJson = json_encode( $notifications );
            $this->restutilities->sendResponse( 200, 
                            '{"success": "true", "notifications" : ' . $notificationsJson . ' }' );
        }
    }
    
    public function mailUsername(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $school_id = '0';
        $this->load->model('basicmodel');
        $emailID = isset( $_POST['emailID']);
        $user_details = $this->basicmodel->getUserDetails( $school_id, $emailID );
        
        if( $user_details ){
            //Send mail
            echo json_encode("true");
            return;
        } else {
            //log
            $this->load->library('Logging');
            $this->logging->logError( "Error getting user details from email id ", __FILE__, __FUNCTION__, __LINE__, $emailID );
            echo json_encode("false");
            return;
        }
        
    }
    
    public function populateCounters(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( ( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ) &&
                array_key_exists('user_id', $sessionUserData) ){
            $this->load->model('schoolmodel');
            $school_id = '0';
            $user_id = trim($sessionUserData['user_id']);
            $inbox_count = $this->schoolmodel->getInboxCount( $user_id, $school_id );
            if( $inbox_count != "" && _MEMCACHE_ENABLED ){
                $memcache = new MemcacheLibrary();
                $inbox_cnt_key = _INBOX_COUNT . "_" . $school_id . "_" . $user_id;
                $memcache->setKey( $inbox_cnt_key, $inbox_count );
            }
            $complain_count = $this->schoolmodel->getComplainCount( trim($sessionUserData['user_id']));
            if( $complain_count != "" && _MEMCACHE_ENABLED ){
                $memcache = new MemcacheLibrary();
                $memcache->setKey(_COMPLAIN_COUNT . "_" . $school_id . "_" . $user_id , $complain_count );
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
}

