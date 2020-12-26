<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set("Asia/Kolkata");
$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
//require_once $DOC_ROOT . "/vendor/autoload.php";
require_once $DOC_ROOT . "/application/libraries/getallheaders.php";

class adminController extends CI_Controller {
    public function addClasses(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        $displayData = array();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_ADMIN ) ){
            $headerData = array();
            $school_id = '0';
            $postArray = $_POST;
            $classArray = array();
            foreach( $postArray as $key => $value ){
                if( preg_match( "/class_id_/", $key ) ){
                    if( !array_key_exists($key, $classArray) ){
                        $classArray[ $key ] = array();
                        $classArray[ $key ][ 'class_id' ] = $value;
                    } 
                }
                if( preg_match( "/class_[\d+]/", $key ) ){
                    $key_arr = explode("_", $key);
                    $class_str = "class_id_" . $key_arr[1];
                    if( array_key_exists( $class_str, $postArray ) ){
                        if( !array_key_exists($class_str, $classArray) ){
                            $classArray[ $class_str ] = array();
                            $classArray[ 'class_id' ] = $postArray[ $class_str ];
                        }
                        array_push( $classArray[ $class_str ], $value );
                    }
                }
            }
            
            if( count( $classArray ) > 0 ){
                $this->load->model('adminmodel');
                $inserted = $this->adminmodel->insertClasses( $school_id, $classArray );
            }
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $this->load->view('addClasses', $displayData);
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
    
    public function addStudents(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        $displayData = array();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_ADMIN ) ){
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $this->load->view('addStudents', $displayData);
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function uploadStudents(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_ADMIN ) ){
            $school_id = '0';
            $timestamp = time();
            $file=_STUDENT_UPLOAD_FILE_FOLDER . 'studentFile_' . 
                                $timestamp . '_' . $_FILES["addStudentsFile"]["name"];
		
		$try_count = 3;
		$res = false;
		while( !$res && $try_count > 0 ){
			$res = move_uploaded_file($_FILES['addStudentsFile']['tmp_name'], $file) ;
                        if( !$res )
                            sleep(2);
                	$try_count-- ;
		}
		
		if( $res ){
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $file_mime_type = $finfo->file($file);
                    $supported_types = array(
                                                    'csv'  => 'text/csv',
                                                    'csv1' => 'text/plain',
                                                    /*'excel_from_others' => 'application/octet-stream',
                                                    'xls'  => 'application/vnd.ms-excel',
                                                    'xls1' => 'application/vnd.ms-office',
                                                    'xl_other' => 'application/xml',
                                                    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                                    'xlsx1' => 'application/zip'*/
                                                );
                    $format = array_search( $file_mime_type, $supported_types, true);
                    if( $format ){
                        $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
                        include "$DOC_ROOT/application/third_party/PHPExcel/IOFactory.php";

                        try {
                            $inputFileType = PHPExcel_IOFactory::identify($file);
                            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                            $objPHPExcel = $objReader->load($file);
                        } catch (Exception $e) {
                            $this->logging->logError( "Error importing students : " . $e->getMessage(), __FILE__, __FUNCTION__, __LINE__, "0" );                                                      
                        }

                        $sheet = $objPHPExcel->getSheet(0);
                        $headerRowNum = 1 ;
                        $highestRow = $sheet->getHighestRow();
                        $highestColumn = $sheet->getHighestColumn();
                        $rowData = $sheet->rangeToArray('A' . $headerRowNum . ':' . $highestColumn . $highestRow, NULL, TRUE, FALSE);
                        
                        $expected_headers = array( "class", "section", "student_roll_no", "exam_register_no", 
                                                    "firstname", "middlename", "lastname", "email",
                                                    "father_firstname", "father_middlename", "father_lastname", "father_phone", "father_email",
                                                    "mother_firstname", "mother_middlename", "mother_lastname", "mother_phone", "mother_email");
                        
                        $num_attrs = count( $expected_headers );
                        $headers_match = true;
                        if( count( $rowData[0] ) != $num_attrs ){
                            $this->logging->logError( "Error importing students : Header count does not match. ", __FILE__, __FUNCTION__, __LINE__, "0" ); 
                        }
                        for( $count = 0; $count < $num_attrs; $count++ ){
                            if( trim(strtolower($rowData[0][$count])) != $expected_headers[$count] ){
                                $headers_match = false;
                                break;
                            }
                        }
                        if( !$headers_match ){
                            $this->logging->logError( "Error importing students : Headers do not match. ", __FILE__, __FUNCTION__, __LINE__, "0" ); 
                            return;
                        }
                        $this->load->model('adminmodel');
                        $inserted = $this->adminmodel->validateAndInsertStudents( $school_id, $rowData, $num_attrs );
                        if( $inserted ){
                            $displayData['header_message']="Students uploaded successfully!"; 
                        } else {
                            $displayData['header_message']="Student upload failed. Check logs !";
                        }
                        $headerData['logged_in'] = $sessionUserData['logged_in'];
                        $headerData['username'] = $sessionUserData['username'];
                        $headerData['user_type'] = $sessionUserData['user_type'];
                        $headerData['user_id'] = $sessionUserData['user_id'];
                        $displayData['headerData'] = $headerData;
                        $displayData['user_type']  = $sessionUserData['user_type'];
                        $displayData['user_id']  = $sessionUserData['user_id'];
                        $this->load->view('addStudents', $displayData);
                    }
                }          
        } else {
            $this->session->unset_userdata($sessionUserData);
            echo json_encode("false");
        }
    }
    
    public function addTests(){
        $this->load->library('session');
        $this->load->library('Logging');
        $sessionUserData = $this->session->all_userdata();
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_ADMIN ) ){
            //addTests
            $headerData = array();
            $displayData = array();
            
            $school_id = '0';
            $postArray = $_POST;
            $classes = "";
            
            error_log( "post arr : " . print_r( $postArray, true ) );
            $classArray = array();
            foreach( $postArray as $key => $value ){
                if( preg_match( "/class_id_/", $key ) ){
                    $classes .= trim($value) . ", ";
                    $classArray[] = trim($value);
                }
            }
            
            $classes = substr( $classes, 0, strlen($classes) - 2 );
            $addedTestsJson = ( isset($_POST["addedTestsJson"]) ? trim($_POST["addedTestsJson"]) : "" );
            $gradingType = ( isset($_POST["gradingType"]) ? trim($_POST["gradingType"]) : "" );
            
            
            error_log( "addedTestsJson : " . $addedTestsJson );
            
            $addedTests = json_decode($addedTestsJson);
            error_log( "added tests : " . print_r( $addedTests, true ) );
            
            $this->load->model('adminmodel');
            $inserted = "false";
            if( $addedTestsJson != "" ){
                $inserted = $this->adminmodel->insertTests( $school_id, $addedTests, $classes, $classArray );
            }
            
            /*
            if( count( $classArray ) > 0 ){
                $this->load->model('adminmodel');
                $inserted = $this->adminmodel->insertClasses( $school_id, $classArray );
            }
            */
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['testsAdded'] = $inserted;
            $this->load->view('addTests', $displayData);
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

