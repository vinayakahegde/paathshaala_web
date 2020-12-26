<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once( $DOC_ROOT . '/application/libraries/MemcacheLibrary.php' );

date_default_timezone_set("Asia/Kolkata");

class teacherController extends CI_Controller {
    
    public function teacher_test(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $this->load->model('teachermodel');
            //$this->load->model('schoolmodel');
            $school_id = '0';
            $teacher_user_id = trim($sessionUserData['user_id']);
            $classList = $this->teachermodel->getTeacherClassList($school_id, $teacher_user_id);
            
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['classList'] = $classList;
            $this->load->view('teacher_test', $displayData);
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function getClassTestDetails(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $school_id = '0';
            $this->load->model('teachermodel');
            $teacher_user_id = trim( $sessionUserData['user_id'] );
            $class_id = ( isset( $_POST["class_id"] ) ? trim( $_POST["class_id"] ) : "" );
            $testDetails = $this->teachermodel->getClassTestDetails( $school_id, $teacher_user_id, $class_id );
            echo json_encode($testDetails);
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo "false";
            return;
        }
    }
    
    public function getClassTestSubjectDetails(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $school_id = '0';
            $this->load->model('teachermodel');
            $teacher_user_id = trim( $sessionUserData['user_id'] );
            $class_id = ( isset( $_POST["class_id"] ) ? trim( $_POST["class_id"] ) : "" );
            $test_id = ( isset( $_POST["test_id"] ) ? trim( $_POST["test_id"] ) : "" );
            $testDetails = $this->teachermodel->getClassTestSubjectDetails( $school_id, $teacher_user_id, $test_id, $class_id );
            $grading_types = array();
            $grading_type_str = "";
            
            foreach( $testDetails as $subject_id => $details ){
                $grading_type = trim($testDetails[$subject_id]["grading_type"]);
                if( !array_key_exists($grading_type, $grading_types) ){
                    $grading_types[$grading_type] = array();
                    $grading_type_str .= $grading_type . ", ";
                }
            }
            
            $grading_type_str = substr( $grading_type_str, 0, strlen($grading_type_str) - 2 );
            $this->teachermodel->getGrades( $grading_type_str, $grading_types );
            
            $returnArray = array();
            $returnArray['grading_types'] = $grading_types;
            $returnArray['test_details'] = $testDetails;
            echo json_encode($returnArray);
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo "false";
            return;
        }
    }
    
    public function saveScoreCard(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $school_id = '0';
            $this->load->model('teachermodel');
            $teacher_user_id = trim( $sessionUserData['user_id'] );
            
            $data = ( isset( $_POST["data"] ) ? html_entity_decode( trim( $_POST["data"] ) ) : "" );
            $details = json_decode($data, true);
            $saved = $this->teachermodel->saveScoreCard( $school_id, $details );
            echo json_encode($saved);
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function saveStudentScoreCard(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            $school_id = '0';
            $this->load->model('teachermodel');
            $teacher_user_id = trim( $sessionUserData['user_id'] );
            
            $test_id    = ( isset( $_POST["test_id"] ) ? trim( $_POST["test_id"] ) : "" );
            $subject_id = ( isset( $_POST["subject_id"] ) ? trim( $_POST["subject_id"] ) : "" );
            $student_id = ( isset( $_POST["student_id"] ) ? trim( $_POST["student_id"] ) : "" );
            $gradeVal   = ( isset( $_POST["gradeVal"] ) ? trim( $_POST["gradeVal"] ) : "" );
            $remark     = ( isset( $_POST["remark"] ) ? trim( $_POST["remark"] ) : "" );
            
            $saved = $this->teachermodel->saveStudentScoreCard( $school_id, $test_id, $subject_id, $student_id, 
                                                                    $gradeVal, $remark, $teacher_user_id );
            echo json_encode($saved);
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function class_forum(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $this->load->model('teachermodel');
            //$this->load->model('schoolmodel');
            $school_id = '0';
            $teacher_user_id = trim($sessionUserData['user_id']);
            $classList = $this->teachermodel->getTeacherClassList($school_id, $teacher_user_id);
            
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['classList'] = $classList;
            $this->load->view('teacher_class_forum', $displayData);
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function fetchClassForumItems(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        $this->load->library('Logging');
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_TEACHER || $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $this->load->model('parentmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = trim($sessionUserData['user_type']);
            $to_time  = ( isset($_POST["to_time"] ) ? trim($_POST["to_time"]) : "" );
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            if( $to_time == "" ){
                $to_time = time();
            }
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
    
    public function addClassTextPost(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $this->load->model('teachermodel');
            $this->load->model('parentmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            $text  = ( isset($_POST["text"] ) ? html_entity_decode(trim($_POST["text"])) : "" );
            $class_id = ( isset($_POST["class_id"] ) ? html_entity_decode(trim($_POST["class_id"])) : "" );
            $post_type = _FORUM_ITEM_TYPE_TEXT;
            $added_item_id = $this->teachermodel->addClassForumPost( $school_id, $class_id, $text, $post_type, $user_id, $user_type );
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
    
    public function deleteClassPost(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_PARENT
                  || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $item_id  = ( isset($_POST["item_id"] ) ? trim($_POST["item_id"]) : "" );
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $this->load->model('parentmodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            
            $deleted = $this->parentmodel->deletePost( $school_id, $user_id, $item_id );
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
    
    public function postClassComment(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();        
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && 
                ( $sessionUserData['user_type'] == _USER_TYPE_SCHOOL || $sessionUserData['user_type'] == _USER_TYPE_TEACHER ) ){
            
            $this->load->model('teachermodel');
            $school_id = '0';
            $user_id = $sessionUserData['user_id'];
            $user_type = $sessionUserData['user_type'];
            $comment  = ( isset($_POST["comment"] ) ? html_entity_decode(trim($_POST["comment"])) : "" );
            $item_id  = ( isset($_POST["item_id"] ) ? trim($_POST["item_id"]) : "" );
            
            $added = $this->teachermodel->addClassComment( $school_id, $user_id, $user_type, $item_id, $comment );
            echo json_encode( $added );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
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
            $date_str = $cur_date_obj->format( "j, M[ D ]" );
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
            $date_str = $cur_date_obj->format( "j, M[ D ]" );
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
        $completionDateArray['-1'] = array( "date_desc" => "Yesterday ( " . $cur_date_obj1->format( "j, M[ D ]" ) . " ) ", 
                                            "date" => $cur_date_obj1->format( 'Y-m-d' ) );
        
        $cur_date_obj1->sub( new DateInterval( "P1D" ) );
        $completionDateArray['-2'] = array( "date_desc" => $cur_date_obj1->format( "j, M[ D ]" ), 
                                            "date" => $cur_date_obj1->format( 'Y-m-d' ) );
        
        ksort($completionDateArray);
        return $completionDateArray;
    }
    
    public function home_work(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $displayData = array();
            $message = "";
            $headerData = array();
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $this->load->model('teachermodel');
            //$this->load->model('schoolmodel');
            $school_id = '0';
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $subject_id  = ( isset($_POST["subject_id"] ) ? trim($_POST["subject_id"]) : "" );
            $last_hw_id = ( isset($_POST["last_hw_id"] ) ? trim($_POST["last_hw_id"]) : -1 );
            $teacher_user_id = trim($sessionUserData['user_id']);
            
            $last_hw_id_fetched = -1;
            $classList = $this->teachermodel->getTeacherClassList($school_id, $teacher_user_id);
            $classSubjectList = $this->teachermodel->getTeacherClassSubjectList($school_id, $teacher_user_id);
            $homeworkList = array();
            if( $class_id != "" && $subject_id == "" ){
                $homeworkList = $this->teachermodel->getHomeWorkList( $school_id, $teacher_user_id, $class_id, 
                                    $subject_id, $last_hw_id, _HOME_WORK_FEED_SIZE, $last_hw_id_fetched, _GENERIC_LONG_PARAMS, "false" );
            }
            
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['classList'] = $classList;
            $displayData['classSubjectList'] = json_encode($classSubjectList);
            $displayData['postedDateArray'] = $this->getPostedDateArray();
            $displayData['completionDateArray'] = $this->getCompletionDateArray();
            $displayData['homeworkList'] = $homeworkList;
            $this->load->view('home_work', $displayData);
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function fetchHomeWorkDetails(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $this->load->model('teachermodel');
            $school_id  = '0';
            $teacher_user_id = $sessionUserData['user_id'];
            $user_type  = $sessionUserData['user_type'];
            $class_id   = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $subject_id = ( isset($_POST["subject_id"] ) ? trim($_POST["subject_id"]) : "" );
            $last_hw_id = ( isset($_POST["last_hw_id"] ) ? trim($_POST["last_hw_id"]) : -1 );
            
            $last_hw_id_fetched = -1;
            if( $class_id != '' && $subject_id != '' ){
                $homework_details = $this->teachermodel->getHomeWorkList( $school_id, $teacher_user_id, $class_id, 
                                        $subject_id, $last_hw_id, _HOME_WORK_FEED_SIZE, $last_hw_id_fetched, _GENERIC_LONG_PARAMS, "false" );
                
                $returnArray = array('hw_details' => $homework_details, 'last_hw_id_fetched' => $last_hw_id_fetched );
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
    
    public function postClassHomeWork(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $this->load->model('teachermodel');
            $school_id = '0';
            $teacher_user_id = $sessionUserData['user_id'];
            $class_id  = ( isset($_POST["class_id"] ) ? trim($_POST["class_id"]) : "" );
            $subject_id  = ( isset($_POST["subject_id"] ) ? trim($_POST["subject_id"]) : "" );
            $homeworkText = ( isset($_POST["homeworkText"] ) ? html_entity_decode( trim($_POST["homeworkText"]) ) : "" );
            $addHomeWorkSubmitBy  = ( isset($_POST["addHomeWorkSubmitBy"] ) ? html_entity_decode(trim($_POST["addHomeWorkSubmitBy"])) : "" );
            
            $added_hw_id = "";
            $added = $this->teachermodel->addHomeWork( $school_id, $teacher_user_id, $class_id, 
                            $subject_id, $homeworkText, $addHomeWorkSubmitBy, $added_hw_id );
            echo json_encode( $added );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function deleteHomeWork(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $this->load->model('teachermodel');
            $school_id = '0';
            $teacher_user_id = $sessionUserData['user_id'];
            $homework_id  = ( isset($_POST["homework_id"] ) ? trim($_POST["homework_id"]) : "" );
            $deleted = $this->teachermodel->deleteHomeWork( $school_id, $teacher_user_id, $homework_id );
            echo json_encode( $deleted );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function fetchHWByTime(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $this->load->model('teachermodel');
            $school_id = '0';
            $teacher_user_id = $sessionUserData['user_id'];
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
            $hwByTimeFeed = $this->teachermodel->fetchHWByTime( $school_id, $teacher_user_id, $actualPostedDate, $actualcompletionDate );
            echo json_encode( $hwByTimeFeed );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function teacher_timetable(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $displayData = array();
            $message = "";
            $headerData = array();
            $school_id = '0';
            $teacher_user_id = trim( $sessionUserData['user_id'] );
            
            $this->load->model('teachermodel');
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $teacherTimeTable = $this->teachermodel->getTeacherTimeTable( $school_id, $teacher_user_id, _GENERIC_LONG_PARAMS );
            $displayData['header_message'] = $message;
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['teacherTimeTable']  = $teacherTimeTable;
            $displayData['teacherTTJson'] = json_encode( $teacherTimeTable );
            $this->load->view( "teacher_timetable", $displayData );
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function getTeacherTimeTable(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $school_id = '0';
            $teacher_user_id = trim( $sessionUserData['user_id'] );
            $this->load->model('teachermodel');
            $teacherTimeTable = $this->teachermodel->getTeacherTimeTable( $school_id, $teacher_user_id, _GENERIC_LONG_PARAMS );
            echo json_encode( $teacherTimeTable );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
    
    public function getTeacherClassTT(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_TEACHER ){
            
            $school_id = '0';
            $teacher_user_id = trim( $sessionUserData['user_id'] );
            $this->load->model('teachermodel');
            $teacherTimeTable = $this->teachermodel->getTeacherClassTimeTable( $school_id, $teacher_user_id );
            echo json_encode( $teacherTimeTable );
            return;
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
            return;
        }
    }
        
}

?>