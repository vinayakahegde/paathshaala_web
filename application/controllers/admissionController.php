<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set("Asia/Kolkata");

/**
 * Description of admissions
 *
 * @author vinayakahegde
 */
class admissionController extends CI_Controller {
    
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
        $displayData['header_message'] = "";
        $displayData['admissions_open'] = _SCHOOL_ADMISSION_OPEN;
        
        $this->load->view('admissions', $displayData);
    }
    
    public function validateApplication(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $studentName  = trim( html_entity_decode($_POST['studentName']) );
        $fatherName   = trim( html_entity_decode($_POST['fatherName']) );
        $motherName   = trim( html_entity_decode($_POST['motherName']) );
        $address      = trim( html_entity_decode($_POST['address']) );
        $pincode      = trim( html_entity_decode($_POST['pincode']) );
        $phoneNum     = trim( html_entity_decode($_POST['phoneNum']) );
        $emailID      = trim( html_entity_decode($_POST['emailID']) );
        
        $returnArray = $this->isValidApplication($studentName, $fatherName, $motherName, $address, $pincode, $phoneNum, $emailID );
        
        echo json_encode( $returnArray );
        
    }
    
    public function validateApplicationREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        if( $requestParams ){
            $studentName  = "";
            $fatherName   = "";
            $motherName   = "";
            $address      = "";
            $pincode      = "";
            $phoneNum     = "";
            $emailID      = "";
            
            $parameters = $requestParams['data'];
            if( array_key_exists( 'studentName', $parameters) && is_string( $parameters['studentName'] ) ){
                $studentName = trim( $parameters['studentName'] );
            }
            
            if( array_key_exists( 'fatherName', $parameters) && is_string( $parameters['fatherName'] ) ){
                $fatherName = trim($parameters['fatherName']);
            }
            
            if( array_key_exists( 'motherName', $parameters) && is_string( $parameters['motherName'] ) ){
                $motherName = trim($parameters['motherName']);
            }
            
            if( array_key_exists( 'address', $parameters) && is_string( $parameters['address'] ) ){
                $address = trim($parameters['address']);
            }
            
            if( array_key_exists( 'pincode', $parameters) && is_string( $parameters['pincode'] ) ){
                $pincode = trim($parameters['pincode']);
            }
            
            if( array_key_exists( 'phoneNum', $parameters) && is_string( $parameters['phoneNum'] ) ){
                $phoneNum = trim($parameters['phoneNum']);
            }
            
            if( array_key_exists( 'emailID', $parameters) && is_string( $parameters['emailID'] ) ){
                $emailID = trim($parameters['emailID']);
            }
                       
            $returnArray = $this->isValidApplication($studentName, $fatherName, $motherName, $address, $pincode, $phoneNum, $emailID );
            $returnArrayJson = json_encode($returnArray);
            
            $this->restutilities->sendResponse( 200, 
                    '{"success": "true", "error" : ' . $returnArrayJson .' }' );
            return;
                        
        }
        
    }
    
    private function isValidApplication($studentName, $fatherName, $motherName, $address, $pincode, $phoneNum, $emailID ){
        $returnArray = array();
        $returnArray['studentName'] = "";
        $returnArray['fatherName']  = "";
        $returnArray['motherName']  = "";
        $returnArray['address']     = "";
        $returnArray['pincode']     = "";
        $returnArray['phoneNum']    = "";
        $returnArray['emailID']     = "";
        
        if( !$this->isValidPhoneNum($phoneNum) ){
            $returnArray['phoneNum'] = "* Please enter a valid phone number";
        } else {
            $this->load->model('admissionsmodel');
            $applied_count = $this->admissionsmodel->getApplyCount( $phoneNum );
            if( $applied_count > 3 ){
                $returnArray['phoneNum'] = "* You have reached the maximum application limit. Please apply with a different mobile number.";
            }
        }
                
        if( strlen($studentName) < 5 ){
            $returnArray['studentName'] = "* Please enter the full name of the student";
        } else if( !$this->isValidName( $studentName ) ) {
            $returnArray['studentName'] = "* Please enter a valid name. Special characters are not allowed.";
        }
        
        if( strlen($fatherName) < 5 ){
            $returnArray['fatherName'] = "* Please enter the full name of the father";
        } else if( !$this->isValidName( $fatherName ) ) {
            $returnArray['fatherName'] = "* Please enter a valid name. Special characters are not allowed.";
        }
        
        if( strlen($motherName) < 5 ){
            $returnArray['motherName'] = "* Please enter the full name of the mother";
        } else if( !$this->isValidName( $motherName ) ) {
            $returnArray['motherName'] = "* Please enter a valid name. Special characters are not allowed.";
        }
        
        if( strlen($address) < 10 ){
            $returnArray['address'] = "* Please enter a valid address";
        } 
        
        if( !$this->isValidPincode($pincode) ){
            $returnArray['pincode'] = "* Please enter a valid pincode number";
        }
        
       /* if( !$this->isValidPhoneNum($phoneNum) ){
            $returnArray['phoneNum'] = "* Please enter a valid phone number";
        } */
        
        if( !$this->isValidEmail($emailID) ){
            $returnArray['emailID'] = "* Please enter a valid email id";
        }
        //Yet to validate last score and previous school
        return $returnArray;
    }
    
    private function isValidName( $name ){
        //allow only alphabets and . and ' and `
        return true;
    }
    
    private function isValidPincode( $pincode ){
        //Validate pincode length should be 6 and should contain only numbers
        return true;
    }
    
    private function isValidPhoneNum( $phoneNum ){
        //Validate phone num length should be 10 and should contain only numbers
        return true;
    }
    
    private function isValidEmail( $emailID ){
        //Validate email - should contain '@' and '.' 
        return true;
    }
    
    public function submitApplication(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $studentName          = ( array_key_exists( 'studentName', $_POST )? trim( $_POST['studentName']) : "" );
        $fatherName           = ( array_key_exists( 'fatherName', $_POST )? trim( $_POST['fatherName']) : "" );
        $motherName           = ( array_key_exists( 'motherName', $_POST )? trim( $_POST['motherName']) : "" );
        $address              = ( array_key_exists( 'address', $_POST )? trim( $_POST['address']) : "" );
        $pincode              = ( array_key_exists( 'pincode', $_POST )? trim( $_POST['pincode']) : "" ); 
        $phoneNum             = ( array_key_exists( 'phoneNum', $_POST )? trim( $_POST['phoneNum']) : "" );
        $emailID              = ( array_key_exists( 'emailID', $_POST )? trim( $_POST['emailID']) : "" );
        $fatherQualification  = ( array_key_exists( 'fatherQualification', $_POST )? trim( $_POST['fatherQualification']) : "" );
        $motherQualification  = ( array_key_exists( 'motherQualification', $_POST )? trim( $_POST['motherQualification']) : "" );
        $motherTongue         = ( array_key_exists( 'motherTongue', $_POST )? trim( $_POST['motherTongue']) : "" );
        $annualIncome         = ( array_key_exists( 'annualIncome', $_POST )? trim( $_POST['annualIncome']) : "" );
        $forClass             = ( array_key_exists( 'forClass', $_POST )? trim( $_POST['forClass']) : "" );
        $lastScore            = ( array_key_exists( 'lastScore', $_POST )? trim( $_POST['lastScore']) : "" );
        $previousSchool       = ( array_key_exists( 'previousSchool', $_POST )? trim( $_POST['previousSchool']) : "" );
        
        $displayData = array();
        $homeData = $this->getGeneralHomeData();
        $displayData['homeData'] = $homeData;
        $displayData['admissions_open'] = _SCHOOL_ADMISSION_OPEN;
        $displayData['header_message'] = "";
        
        if($studentName == "" || $fatherName == "" || $motherName == "" || $address == "" ||
            $pincode == "" || $phoneNum == "" || $emailID == "" || $fatherQualification == "" ||
            $motherQualification  == "" || $motherTongue == "" || $annualIncome == "" || $forClass == "" ){
            
            $this->load->view('home', $displayData);
            return;
        }
            
        $this->load->model('admissionsmodel');
        //think of a way to get school id
        $school_id = '0';
        $inserted = $this->admissionsmodel->insertApplicationInDB( $school_id, $studentName, $fatherName, $motherName, $address, $pincode, $phoneNum,
                                        $emailID, $fatherQualification, $motherQualification, $motherTongue, $annualIncome,
                                        $forClass, $lastScore, $previousSchool );
                
        if( $inserted ){
            $displayData['header_message'] = "Your application has been successfully submitted!";
            $this->load->view('admissions', $displayData);
        } else {
            $displayData['header_message'] = "Sorry, Could not submit the application. Please try again";
            $this->load->view('admissions', $displayData);
        }
        
    }
    
    public function submitApplicationREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        if( $requestParams ){
            $studentName          = "";
            $fatherName           = "";
            $motherName           = "";
            $address              = "";
            $pincode              = "";
            $phoneNum             = "";
            $emailID              = "";
            $fatherQualification  = "";
            $motherQualification  = "";
            $motherTongue         = "";
            $annualIncome         = "";
            $forClass             = "";
            $lastScore            = "";
            $previousSchool       = "";
            $school_id            = '0';
            
            $parameters = $requestParams['data'];
            if( array_key_exists( 'studentName', $parameters) && is_string( $parameters['studentName'] ) ){
                $studentName = trim( $parameters['studentName'] );
            }
            
            if( array_key_exists( 'fatherName', $parameters) && is_string( $parameters['fatherName'] ) ){
                $fatherName = trim($parameters['fatherName']);
            }
            
            if( array_key_exists( 'motherName', $parameters) && is_string( $parameters['motherName'] ) ){
                $motherName = trim($parameters['motherName']);
            }
            
            if( array_key_exists( 'address', $parameters) && is_string( $parameters['address'] ) ){
                $address = trim($parameters['address']);
            }
            
            if( array_key_exists( 'pincode', $parameters) && is_string( $parameters['pincode'] ) ){
                $pincode = trim($parameters['pincode']);
            }
            
            if( array_key_exists( 'phoneNum', $parameters) && is_string( $parameters['phoneNum'] ) ){
                $phoneNum = trim($parameters['phoneNum']);
            }
            
            if( array_key_exists( 'emailID', $parameters) && is_string( $parameters['emailID'] ) ){
                $emailID = trim($parameters['emailID']);
            }
                     
            if( array_key_exists( 'fatherQualification', $parameters) && is_string( $parameters['fatherQualification'] ) ){
                $fatherQualification = trim($parameters['fatherQualification']);
            }
            
            if( array_key_exists( 'motherQualification', $parameters) && is_string( $parameters['motherQualification'] ) ){
                $motherQualification = trim($parameters['motherQualification']);
            }
            
            if( array_key_exists( 'motherTongue', $parameters) && is_string( $parameters['motherTongue'] ) ){
                $motherTongue = trim($parameters['motherTongue']);
            }
            
            if( array_key_exists( 'annualIncome', $parameters) && is_string( $parameters['annualIncome'] ) ){
                $annualIncome = trim($parameters['annualIncome']);
            }
            
            if( array_key_exists( 'forClass', $parameters) && is_string( $parameters['forClass'] ) ){
                $forClass = trim($parameters['forClass']);
            }
            
            if( array_key_exists( 'lastScore', $parameters) && is_string( $parameters['lastScore'] ) ){
                $lastScore = trim($parameters['lastScore']);
            }
            
            if( array_key_exists( 'previousSchool', $parameters) && is_string( $parameters['previousSchool'] ) ){
                $previousSchool = trim($parameters['previousSchool']);
            }
            
            if( array_key_exists( 'school_id', $parameters) && is_string( $parameters['school_id'] ) ){
                $school_id = trim($parameters['school_id']);
            }
                       
            if($studentName == "" || $fatherName == "" || $motherName == "" || $address == "" ||
                $pincode == "" || $phoneNum == "" || $emailID == "" || $fatherQualification == "" ||
                $motherQualification  == "" || $motherTongue == "" || $annualIncome == "" || $forClass == "" ){
                
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false", "error" : "Invalid Input" }' );
                
                return;
                
            }
            
            $this->load->model('admissionsmodel');
            $inserted = $this->admissionsmodel->insertApplicationInDB( $school_id, $studentName, $fatherName, $motherName, $address, $pincode, $phoneNum,
                                        $emailID, $fatherQualification, $motherQualification, $motherTongue, $annualIncome,
                                        $forClass, $lastScore, $previousSchool );
            
            if( $inserted ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "error" : "" }' );
            } else {
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false", "error" : "Unable to submit application" }' );
            }
            
        }
    }
    
    public function getApplicationStatus(){       
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
    
        if( array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true ){
            $this->session->unset_userdata($sessionUserData);
        }
        
        $searchPhoneNum          = trim( $_POST['searchPhoneNum'] );
        if( $this->isValidPhoneNum($searchPhoneNum)){
            $this->load->model('admissionsmodel');
            //think of a way to get school id
            $school_id = '0';
            $application_details = $this->admissionsmodel->getApplicationDetails( $school_id, $searchPhoneNum );
            if( count($application_details) > 0 )
                echo json_encode( $application_details );
            else
                echo json_encode("false~~Sorry!! No records found");
        } else {
            echo json_encode( "false~~Please enter a valid phone number" );
        }
        
    }
    
    public function getApplicationStatusREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        if( $requestParams ){
            $searchPhoneNum = "";
            $school_id = '0';
            
            $parameters = $requestParams['data'];
            if( array_key_exists( 'searchPhoneNum', $parameters) && is_string( $parameters['searchPhoneNum'] ) ){
                $searchPhoneNum = trim($parameters['searchPhoneNum']);
            }
            
            if( array_key_exists( 'school_id', $parameters) && is_string( $parameters['school_id'] ) ){
                $school_id = trim($parameters['school_id']);
            }
            
            if( $searchPhoneNum == "" || !$this->isValidPhoneNum($searchPhoneNum)){
                $this->logging->logDebug( "Error invalid phone number ", __FILE__, __FUNCTION__, __LINE__, 
                        "searchPhoneNum : $searchPhoneNum" );
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false", "error" : "Please enter a valid phone number" }' );
                return;
            }
              
            $this->load->model('admissionsmodel');
            $application_details = $this->admissionsmodel->getApplicationDetails( $school_id, $searchPhoneNum );
            if( count($application_details) > 0 ){
                $application_details_json = json_encode( $application_details );
                $this->logging->logDebug( "Success - got application details ", __FILE__, __FUNCTION__, __LINE__, 
                        "details : $application_details_json" );
                $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "application_details" : ' . $application_details_json . ' }' );
            } else {
                $this->logging->logDebug( "Fail - no records found ", __FILE__, __FUNCTION__, __LINE__, "" );
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false", "error" : "No Records Found" }' );
            }
        }
               
    }
    
    public function applications( $pageNo, $pageSize ){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            /*$fromSearch              = ( isset($_POST["fromSearch"]) ? trim($_POST["fromSearch"]) : "" );
            $toSearch                = ( isset($_POST["toSearch"]) ? trim($_POST["toSearch"]) : "" );*/
            //testing
            /*$this->load->library('MailUtilities');
            $to_email_ids = array("vinayaka.87.hegde@gmail.com");
            $to_email_names = array("Vinayaka Hegde");
            $from_email_id = "contact.paathshaala@gmail.com";
            $from_email_name  = "Paathshaala";
            $subject = "Test Mail";
            $mail_body = "Test mail body";
            $attachment_file_name = "";
            
            $result = $this->mailutilities->sendMail($to_email_ids, $to_email_names, $from_email_id, $from_email_name, $subject, $mail_body, $attachment_file_name);
            */
            $applicationStatus       = ( isset($_POST["applicationStatus"]) ? trim($_POST["applicationStatus"]) : "" );
            $applicationMotherTongue = ( isset($_POST["applicationMotherTongue"]) ? trim($_POST["applicationMotherTongue"]) : "" );
            $applicationIncomeLevel  = ( isset($_POST["applicationIncomeLevel"]) ? trim($_POST["applicationIncomeLevel"]) : "" );
            $applicationFatherQual   = ( isset($_POST["applicationFatherQual"]) ? trim($_POST["applicationFatherQual"]) : "" );
            $applicationMotherQual   = ( isset($_POST["applicationMotherQual"]) ? trim($_POST["applicationMotherQual"]) : "" );
            $applicationForClass     = ( isset($_POST["applicationForClass"]) ? trim($_POST["applicationForClass"]) : "" );
            $applicationPeriod       = ( isset($_POST["applicationPeriod"]) ? trim($_POST["applicationPeriod"]) : "" );
            
            $school_id = '0';
            $fromSearch = '';
            $toSearch = '';
            
            $this->setDateRange( $applicationPeriod, $fromSearch, $toSearch );
            
            $this->load->model('admissionsmodel');
            $applicationCount = 0;
            $applicationDetails = $this->admissionsmodel->getApplicationDetailsForSchool( $school_id, $fromSearch, $toSearch, $applicationStatus,
                    $applicationMotherTongue, $applicationIncomeLevel, $applicationFatherQual, $applicationMotherQual, $applicationForClass,
                    $pageNo, $pageSize, $applicationCount );     
            
            $headerData['logged_in'] = $sessionUserData['logged_in'];
            $headerData['username'] = $sessionUserData['username'];
            $headerData['user_type'] = $sessionUserData['user_type'];
            $headerData['user_id'] = $sessionUserData['user_id'];
            
            $displayData['headerData'] = $headerData;
            $displayData['user_type']  = $sessionUserData['user_type'];
            $displayData['user_id']  = $sessionUserData['user_id'];
            $displayData['pageNo']     = $pageNo;
            $displayData['pageSize']   = $pageSize;
            $displayData['applicationDetails']   = $applicationDetails;
            $displayData['applicationCount']   = $applicationCount;
            
            if( $applicationPeriod !== "" ){
                $displayData['applicationPeriod']   = $applicationPeriod;
            }
            
            if( $applicationPeriod !== "" ){
                $displayData['applicationPeriod']   = $applicationPeriod;
            }
            
            if( $applicationStatus !== "" ){
                $displayData['applicationStatus']   = $applicationStatus;
            }
            
            if( $applicationMotherTongue !== "" ){
                $displayData['applicationMotherTongue']   = $applicationMotherTongue;
            }
            
            if( $applicationIncomeLevel !== "" ){
                $displayData['applicationIncomeLevel']   = $applicationIncomeLevel;
            }
            
            if( $applicationFatherQual !== "" ){
                $displayData['applicationFatherQual']   = $applicationFatherQual;
            }
            
            if( $applicationMotherQual !== "" ){
                $displayData['applicationMotherQual']   = $applicationMotherQual;
            }
            
            if( $applicationForClass !== "" ){
                $displayData['applicationForClass']   = $applicationForClass;
            }
            //echo print_r($applicationDetails, true);
            $this->load->view('applications', $displayData);
            
            
        } else {
            $this->session->unset_userdata($sessionUserData);
            $headerData['logged_in'] = false;
            $displayData['headerData'] = $headerData;
            $displayData['homeData'] = array();
            $this->load->view('home', $displayData);
            return;
        }
    }
    
    public function applicationsREST(){
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        if( $requestParams ){
            $applicationStatus       = '';
            $applicationMotherTongue = '';
            $applicationIncomeLevel  = '';
            $applicationFatherQual   = '';
            $applicationMotherQual   = '';
            $applicationForClass     = '';
            $applicationPeriod       = '';
            $pageNo                  = '';
            $pageSize                = '';
            
            $school_id = '0';
            $fromSearch = '';
            $toSearch = '';
            
            $parameters = $requestParams['data'];
            if( array_key_exists( 'applicationStatus', $parameters) && is_string( $parameters['applicationStatus'] ) ){
                $applicationStatus = trim($parameters['applicationStatus']);
            }
            
            if( array_key_exists( 'applicationMotherTongue', $parameters) && is_string( $parameters['applicationMotherTongue'] ) ){
                $applicationMotherTongue = trim($parameters['applicationMotherTongue']);
            }
            
            if( array_key_exists( 'applicationIncomeLevel', $parameters) && is_string( $parameters['applicationIncomeLevel'] ) ){
                $applicationIncomeLevel = trim($parameters['applicationIncomeLevel']);
            }
            
            if( array_key_exists( 'applicationFatherQual', $parameters) && is_string( $parameters['applicationFatherQual'] ) ){
                $applicationFatherQual = trim($parameters['applicationFatherQual']);
            }
            
            if( array_key_exists( 'applicationMotherQual', $parameters) && is_string( $parameters['applicationMotherQual'] ) ){
                $applicationMotherQual = trim($parameters['applicationMotherQual']);
            }
            
            if( array_key_exists( 'applicationForClass', $parameters) && is_string( $parameters['applicationForClass'] ) ){
                $applicationForClass = trim($parameters['applicationForClass']);
            }
            
            if( array_key_exists( 'applicationPeriod', $parameters) && is_string( $parameters['applicationPeriod'] ) ){
                $applicationPeriod = trim($parameters['applicationPeriod']);
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
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false", "error" : "Invalid Input" }' );
                return;
            }
            
            $this->load->library('DateUtilities');
            $this->dateutilities->setDateRange( $applicationPeriod, $fromSearch, $toSearch, false );
            
            if( $applicationPeriod == "" ){
                $fromSearch = _SCHOOL_DEFAULT_START_DATE . " 00:00:00";
            }
            $this->load->model('admissionsmodel');
            $applicationCount = 0;
            $applicationDetails = $this->admissionsmodel->getApplicationDetailsForSchool( $school_id, $fromSearch, $toSearch, $applicationStatus,
                    $applicationMotherTongue, $applicationIncomeLevel, $applicationFatherQual, $applicationMotherQual, $applicationForClass,
                    $pageNo, $pageSize, $applicationCount ); 
            
            $applicationDetailsJson = json_encode($applicationDetails);              
            $this->restutilities->sendResponse( 200, 
                        '{"success": "true", "application_details" : ' . $applicationDetailsJson . 
                                ', "application_count" : "' . $applicationCount . '" }' );
            
        }
    }
    
    private function setDateRange( $applicationPeriod, &$fromSearch, &$toSearch ){
        date_default_timezone_set("Asia/Kolkata");
        $cur_time = date("Y-m-d H:i:s");
        $toSearch = $cur_time;
        
        $cur_time_date = date_create($cur_time);
        switch( $applicationPeriod ){
            case _TIME_PERIOD_ONE_WEEK : 
                date_sub($cur_time_date, date_interval_create_from_date_string("1 week"));
                $fromSearch = date_format($cur_time_date, "Y-m-d H:i:s");
                break;
            
            case _TIME_PERIOD_TWO_WEEKS : 
                date_sub($cur_time_date, date_interval_create_from_date_string("2 weeks"));
                $fromSearch = date_format($cur_time_date, "Y-m-d H:i:s");
                break;
            
            case _TIME_PERIOD_ONE_MONTH : 
                date_sub($cur_time_date, date_interval_create_from_date_string("1 month"));
                $fromSearch = date_format($cur_time_date, "Y-m-d H:i:s");
                break;
            
            case _TIME_PERIOD_TWO_MONTHS : 
                date_sub($cur_time_date, date_interval_create_from_date_string("2 months"));
                $fromSearch = date_format($cur_time_date, "Y-m-d H:i:s");
                break;
            
            case _TIME_PERIOD_THREE_MONTHS : 
                date_sub($cur_time_date, date_interval_create_from_date_string("3 months"));
                $fromSearch = date_format($cur_time_date, "Y-m-d H:i:s");
                break;
            
            case _TIME_PERIOD_SIX_MONTHS : 
                date_sub($cur_time_date, date_interval_create_from_date_string("6 months"));
                $fromSearch = date_format($cur_time_date, "Y-m-d H:i:s");
                break;
            
            case _TIME_PERIOD_NINE_MONTHS : 
                date_sub($cur_time_date, date_interval_create_from_date_string("9 months"));
                $fromSearch = date_format($cur_time_date, "Y-m-d H:i:s");
                break;
            
            case _TIME_PERIOD_ONE_YEAR : 
                date_sub($cur_time_date, date_interval_create_from_date_string("1 year"));
                $fromSearch = date_format($cur_time_date, "Y-m-d H:i:s");
                break;
            
            default :
                //date_sub($cur_time_date, date_interval_create_from_date_string("1 year"));
                $fromSearch = _SCHOOL_DEFAULT_START_DATE . " 00:00:00";
                //date_format($cur_time_date, "Y-m-d H:i:s");
                break;
        }
    }
    
    public function changeApplicationStatus(){
        $this->load->library('session');
        $sessionUserData = $this->session->all_userdata();
        $this->load->library('Logging');
        
        if( (array_key_exists('logged_in', $sessionUserData) && $sessionUserData['logged_in'] == true)
                && ( array_key_exists('user_type', $sessionUserData) && $sessionUserData['user_type'] == _USER_TYPE_SCHOOL ) ){
            
            $school_id = '0';
            $applicationIDs = ( isset($_POST["applicationIDs"]) ? trim($_POST["applicationIDs"]) : "" );
            $changedStatus = ( isset($_POST["changedStatus"]) ? trim($_POST["changedStatus"]) : "" );
            
            if( $applicationIDs != "" && $changedStatus != "" ){
                $this->load->model('admissionsmodel');
                $updated = $this->admissionsmodel->changeApplicationStatus( $applicationIDs, $changedStatus, $school_id );
                
                if( $updated ){
                    echo json_encode("true");
                } else {
                    echo json_encode("false~~Unable to change the status");
                }
            } else {
                $this->logging->logError( "Error changing application status ", __FILE__, __FUNCTION__, __LINE__, 
                        "applicationIDs : $applicationIDs, changedStatus : $changedStatus" );
                echo json_encode("false~~Invalid Input");
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
    
    public function changeApplicationStatusREST(){
        /*$this->load->library('SMSUtilities');
        $sentSMS = $this->smsutilities->sendSMS( "9538099320", "hello there - from code testing1234");*/
        
        $this->load->library('RestUtilities');
        $requestParams = $this->restutilities->getPostParams();
        
        if( $requestParams ){
            $applicationIDs = "";
            $changedStatus = "";
            $school_id = '0';
            
            $parameters = $requestParams['data'];
            if( array_key_exists( 'applicationIDs', $parameters) && is_string( $parameters['applicationIDs'] ) ){
                $applicationIDs = trim( $parameters['applicationIDs'] );
            }
            
            if( array_key_exists( 'changedStatus', $parameters) && is_string( $parameters['changedStatus'] ) ){
                $changedStatus = trim($parameters['changedStatus']);
            }
            
            if( array_key_exists( 'school_id', $parameters) && is_string( $parameters['school_id'] ) ){
                $school_id = trim($parameters['school_id']);
            }
            
            if( $applicationIDs == "" || $changedStatus == "" ){
                $this->restutilities->sendResponse( 200, 
                        '{"success": "false", "error" : "Invalid Input" }' );
                return;
            }
            
            $this->load->model('admissionsmodel');
            $updated = $this->admissionsmodel->changeApplicationStatus( $applicationIDs, $changedStatus, $school_id );

            if( $updated ){
                $this->restutilities->sendResponse( 200, 
                            '{"success": "true", "error" : "" }' );
            } else {
                $this->logging->logError( "Error changing application status ", __FILE__, __FUNCTION__, __LINE__, 
                        "applicationIDs : $applicationIDs, changedStatus : $changedStatus" );
                $this->restutilities->sendResponse( 200, 
                            '{"success": "false", "error" : "Unable to change the status" }' );
            }
        }
        
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
        error_log("notifs : " . print_r( $notifications, true ) );
        $homePageData = "";
        
        $returnData = array();
        $returnData['notifications'] = $notifications;
        $returnData['homePageData']  = $homePageData;
        
        return $returnData;
        
    }
    
}