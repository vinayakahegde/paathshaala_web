<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once( $DOC_ROOT . '/application/libraries/MemcacheLibrary.php' );
require_once $DOC_ROOT . "/system/libraries/AwsSNS.php";

date_default_timezone_set("Asia/Kolkata");

class messageController extends CI_Controller {
    
    public function inbox(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) ){
            
            $displayData = array();
            $headerData = array();
            $this->load->model('schoolmodel');
            $school_id = '0';
            $classes = $this->schoolmodel->getClasses( $school_id );
            $classes = json_encode($classes);
            $user_id = trim($sessionUserData['user_id']);
            if( _MEMCACHE_ENABLED ){
                $memcache = new MemcacheLibrary(); //$this->getMemcache(); 
                //error_log( "mem avail : " . $memcache->isMemcacheAvailable() );
                $inbox_cnt_key = _INBOX_COUNT . "_" . $school_id . "_" . $user_id;
                $inbox_count = $memcache->getKey($inbox_cnt_key);
                if( $inbox_count != FALSE ){
                    $inbox_count = $this->schoolmodel->getInboxCount( $user_id, $school_id );
                    if( $inbox_count != "" ){
                        $memcache->setKey( $inbox_cnt_key, $inbox_count );
                    }
                } 
                
                $important_cnt_key = _INBOX_IMPORTANT_COUNT . "_" . $school_id . "_" . $user_id;
                $inbox_important_count = $memcache->getKey($important_cnt_key);
                if( $inbox_important_count != FALSE ){
                    $inbox_important_count = $this->schoolmodel->getInboxImportantCount( $user_id, $school_id );
                    if( $inbox_important_count != "" ){
                        $memcache->setKey( $inbox_cnt_key, $inbox_important_count );
                    }
                }
            }
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $user_id;
            $displayData['headerData'] = $headerData;
            $displayData['classes'] = $classes;
            $displayData['inbox_count'] = $inbox_count;
            $displayData['inbox_important_count'] = $inbox_important_count;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            if( $sessionUserData['user_type'] == _USER_TYPE_PARENT ){
                $teacherList = $this->schoolmodel->getTeacherListByParentUserID($school_id, trim($sessionUserData['user_id']));
                $displayData['teacherList'] = $teacherList;
            } else {
                $displayData['teacherList'] = array();
            }
            $this->load->view('inbox', $displayData);
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function getMemcache(){
        $server = _MEMCACHE_SERVER_IP;
        $port   = _MEMCACHE_SERVER_PORT;
        $memcache = new Memcache();
        $memcache->connect($server, $port);

        return $memcache;
    }
    
    public function inbox_search(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            $studentNameSearch = ( isset($_POST["studentNameSearch"]) ? html_entity_decode(trim($_POST["studentNameSearch"])) : "" );
            $studentParentNameSearch = ( isset($_POST["studentParentNameSearch"]) ? html_entity_decode(trim($_POST["studentParentNameSearch"])) : "" );
            $studentClassSearch = ( isset($_POST["studentClassSearch"]) ? html_entity_decode(trim($_POST["studentClassSearch"])) : "" );
            $studentSectionSearch = ( isset($_POST["studentSectionSearch"]) ? html_entity_decode(trim($_POST["studentSectionSearch"])) : "" );
            $studentRollNoEntered = ( isset($_POST["studentRollNoEntered"]) ? html_entity_decode(trim($_POST["studentRollNoEntered"])) : "" );
            
            $class_ids = "";
            if( $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
                $teacher_user_id = trim( $sessionUserData['user_id'] );
                $teacher_class_ids = $this->schoolmodel->getTeacherClasses( $school_id, $teacher_user_id );
                $class_ids = "";
                for( $i=0; $i < count($teacher_class_ids); $i++ ){
                    $class_ids .= trim($teacher_class_ids[$i]['class_id']) . ", ";
                }
                $class_ids = substr( $class_ids, 0, strlen($class_ids) - 2 );
            }
            $students = $this->schoolmodel->getStudentList( $school_id, $studentParentNameSearch, $studentNameSearch, 
                                                            $studentClassSearch, $studentSectionSearch, $studentRollNoEntered, 
                                                            $class_ids );
                        
            $response = array();
            $response['students'] = $students;
            $response['studentSearchByClass'] = $studentClassSearch;
            $response['selectedSection'] = $studentSectionSearch;
            $response['studentNameEntered'] = $studentNameSearch;
            $response['studentParentNameEntered'] = $studentParentNameSearch;
            $response['studentRollNoEntered'] = $studentRollNoEntered;
            
            echo str_replace("'", "", json_encode( $response ));
            return;   
        } else {
            echo json_encode( "false" );
            return;
        }
    }
    
    public function sendInboxMessage(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] != _USER_TYPE_STUDENT ){
            
            $this->load->model('schoolmodel');
            $school_id = '0';
            $recipientId = ( isset($_POST["recipient_id"]) ? trim($_POST["recipient_id"]) : "" );
            $message = ( isset($_POST["message"]) ? html_entity_decode(trim($_POST["message"])) : "" );
            $subject = ( isset($_POST["subject"]) ? html_entity_decode(trim($_POST["subject"])) : "" );
            
            $fromId = trim($sessionUserData['user_id']);
            $parentMsgId = -1;
            $inserted = $this->schoolmodel->insertInboxMessage( $school_id, $fromId, $recipientId, $parentMsgId, $subject, $message );
            
            if( $inserted ){
                $this->sendMessageNotification($school_id, $recipientId);
                echo json_encode("true");
            } else {
                echo json_encode("false");
            }
            return;
        } else {
            echo json_encode( "false" );
            return;
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
        $message_json = '{ "notif_type" : "inbox", "data" : { "timestamp" : "' . $timestamp . 
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
    
    public function getInboxContent(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) ){
            
            $user_type = trim($sessionUserData['user_type']);
            if( !($user_type == _USER_TYPE_SCHOOL || $user_type == _USER_TYPE_TEACHER || $user_type == _USER_TYPE_PARENT) ){
                echo "false";
                return;
            }
            $this->load->model('schoolmodel');
            $school_id = '0';
            $option = ( isset($_POST["option"]) ? trim($_POST["option"]) : "" );
            $pg_num = ( isset($_POST["pg_num"]) ? trim($_POST["pg_num"]) : "" );
            $search_user_id = ( isset($_POST["search_user_id"]) ? trim($_POST["search_user_id"]) : "" );
            $search_text = ( isset($_POST["search_text"]) ? trim( html_entity_decode($_POST["search_text"]) ) : "" );
            $pg_size = _INBOX_PAGE_SIZE;
            $user_id = trim( $sessionUserData['user_id'] );
            $inbox_content = $this->schoolmodel->getInboxContent( $school_id, $user_type, $user_id, 
                                                    $search_user_id, $search_text, $option, $pg_num, $pg_size, _INBOX_LONG_PARAMS );
            //error_log( "inbox content : " . print_r($inbox_content, true) );
            ob_clean();
            echo json_encode($inbox_content);
            return;
        } else {
            echo json_encode( "false" );
            return;
        }
        
    }
    
    public function markMessage(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) ){
            
            $user_type = trim($sessionUserData['user_type']);
            if( !($user_type == _USER_TYPE_SCHOOL || $user_type == _USER_TYPE_TEACHER || $user_type == _USER_TYPE_PARENT) ){
                echo "false";
                return;
            }
            $this->load->model('schoolmodel');
            $school_id = '0';
            $parent_msg_id = ( isset($_POST["parent_msg_id"]) ? trim($_POST["parent_msg_id"]) : "" );
            $markAs = ( isset($_POST["markAs"]) ? trim($_POST["markAs"]) : "" );
            $user_id = trim( $sessionUserData['user_id'] );
            $marked = $this->schoolmodel->markMessage( $school_id, $user_id, $parent_msg_id, $markAs );
            if( $marked == "true" ){
                $this->updateInboxCountMemcache( $school_id, $user_id );
            }
            echo json_encode($marked);
            return;
        } else {
            echo json_encode( "false" );
            return;
        }
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
    
    public function getMessageDetails(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) ){
            
            $user_type = trim($sessionUserData['user_type']);
            if( !($user_type == _USER_TYPE_SCHOOL || $user_type == _USER_TYPE_TEACHER || $user_type == _USER_TYPE_PARENT) ){
                echo "false";
                return;
            }
            $this->load->model('schoolmodel');
            $school_id = '0';
            //$msg_id = ( isset($_POST["msg_id"]) ? trim($_POST["msg_id"]) : "" );
            $parent_msg_id = ( isset($_POST["parent_msg_id"]) ? trim($_POST["parent_msg_id"]) : "" );
            $user_id = trim( $sessionUserData['user_id'] );
            $messageDetails = $this->schoolmodel->getMessageDetails( $school_id, $user_type, $user_id, $parent_msg_id, _GENERIC_LONG_PARAMS );
            if( count( $messageDetails ) > 0 ){
                $marked = $this->schoolmodel->markMessage( $school_id, $user_id, $parent_msg_id, "read" );
            }
            error_log("msg details : " . print_r( $messageDetails, true ));
            echo json_encode($messageDetails);
            return;
        } else {
            echo json_encode( "false" );
            return;
        }
    }
    
    public function sendInboxReply(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) ){
            
            $user_type = trim($sessionUserData['user_type']);
            if( !($user_type == _USER_TYPE_SCHOOL || $user_type == _USER_TYPE_TEACHER || $user_type == _USER_TYPE_PARENT) ){
                echo json_encode("false");
                return;
            }
            $this->load->model('schoolmodel');
            $school_id = '0';
            $replyMsg = ( isset($_POST["replyMsg"]) ? trim(html_entity_decode($_POST["replyMsg"])) : "" );
            $parent_msg_id = ( isset($_POST["parentMsgId"]) ? trim($_POST["parentMsgId"]) : "-1" );
            $reply_to_user_id = ( isset($_POST["reply_to_user_id"]) ? trim($_POST["reply_to_user_id"]) : "" );
            $subject = ( isset($_POST["subject"]) ? trim(html_entity_decode($_POST["subject"])) : "" );
            
            $user_id = trim( $sessionUserData['user_id'] );
            $inserted = $this->schoolmodel->insertInboxMessage( $school_id, $user_id, $reply_to_user_id, $parent_msg_id, $subject, $replyMsg );
            if( $inserted ){
                $this->sendMessageNotification($school_id, $reply_to_user_id);
                echo json_encode( "true" );
            } else {
                echo json_encode( "false" );
            }
            return;
        } else {
            echo json_encode( "false" );
            return;
        }
    }
}