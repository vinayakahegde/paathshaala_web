<?php

$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once( $DOC_ROOT . '/application/libraries/DatabaseWrapper.php' );

/**
 * Description of admissionsmodel
 *
 * @author vinayakahegde
 */
class admissionsmodel extends DatabaseWrapper {
    
    public function __construct() {
	parent::__construct();
        $this->db_connections = array();
        $this->db_connection_errors = array();
        
        /*$errMsg = "";
        $this->db_connections[_DB_DEFAULT_GROUP] = $this->connectToDB($errMsg, _DB_DEFAULT_GROUP);
        if( $this->db_connections[_DB_DEFAULT_GROUP] == null ){
            $this->db_connection_errors[_DB_DEFAULT_GROUP] = $errMsg;
        }
        
        $errMsg = "";
        $this->db_connections[_DB_CORE_GROUP] = $this->connectToDB($errMsg, _DB_CORE_GROUP);
        if( $this->db_connections[_DB_CORE_GROUP] == null ){
            $this->db_connection_errors[_DB_CORE_GROUP] = $errMsg;
        }*/
        
        $this->load->library('Logging');
        $errMsg = "";
        $this->db_connections[_DB_ADMISSIONS_GROUP] = $this->connectToDB($errMsg, _DB_ADMISSIONS_GROUP);
        if( $this->db_connections[_DB_ADMISSIONS_GROUP] == null ){
            $this->db_connection_errors[_DB_ADMISSIONS_GROUP] = $errMsg;
            $this->load->library('Logging');
            $this->logging->logError( "Error connecting to DB : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "0" );
        } 
        
        date_default_timezone_set('Asia/Calcutta');
    }
    
    public function getApplyCount( $phoneNum ){
        $this->load->library('Logging');
        $dbConn = $this->db_connections[_DB_ADMISSIONS_GROUP];
        $phoneNum    = $this->realEscapeString($dbConn, $phoneNum);
        
        $query = "select count(1) as cnt from " . _DB_ADMISSIONS_SCHEMA . ".applications "
                . " where phone = '$phoneNum' ";
        
        $errMsg = "";
        $result = $this->selectData($query, $dbConn, $errMsg);
        if( count( $result ) > 0 ){
            return trim($result[0]['cnt']);
        } else {
            $this->logging->logError( "Error getting application count : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "0" );
            return -1;
        }
        
    }
    
    public function insertApplicationInDB( $school_id, $studentName, $fatherName, $motherName, $address, $pincode, $phoneNum,
                                        $emailID, $fatherQualification, $motherQualification, $motherTongue, $annualIncome,
                                        $forClass, $lastScore, $previousSchool ){
        
        $dbConn = $this->db_connections[_DB_ADMISSIONS_GROUP];
        $this->load->library('Logging');
        
        $studentName    = $this->realEscapeString($dbConn, $studentName);
        $fatherName     = $this->realEscapeString($dbConn, $fatherName);
        $motherName     = $this->realEscapeString($dbConn, $motherName);
        $address        = $this->realEscapeString($dbConn, $address);
        $emailID        = $this->realEscapeString($dbConn, $emailID);
        $lastScore      = $this->realEscapeString($dbConn, $lastScore);
        $previousSchool = $this->realEscapeString($dbConn, $previousSchool);
        
        $insertQuery = "insert into " . _DB_ADMISSIONS_SCHEMA . ".applications "
                      . " ( school_id, student_name, father_name, mother_name, address, pincode, phone, email_id, father_qualification, "
                      . " mother_qualification, mother_tongue, annual_income, apply_class, prev_marks, prev_school_name ) "
                      . " values "
                      . " ( '$school_id', '$studentName', '$fatherName', '$motherName', '$address', '$pincode', '$phoneNum', "
                      . " '$emailID', $fatherQualification, $motherQualification, $motherTongue, $annualIncome, $forClass, "
                      . " '$lastScore', '$previousSchool' ) ";
        
        $errMsg = "";
        $inserted = $this->executeInsert($insertQuery, $dbConn, $errMsg);
        if( !$inserted )
            $this->logging->logError( "Error inserting application : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "0" );
        
        return $inserted;
                    
    }
    
    public function getApplicationDetails( $school_id, $searchPhoneNum ){
        $dbConn = $this->db_connections[_DB_ADMISSIONS_GROUP];
        $this->load->library('Logging');
        $school_id = $this->realEscapeString($dbConn, $school_id);
        $searchPhoneNum = $this->realEscapeString($dbConn, $searchPhoneNum);
        
        $query = "select ap.application_id, ap.student_name, ap.father_name, ap.apply_class, ap.phone, apc.class_desc, "
                . " apst.status as status, apst.message "
                . " from " . _DB_ADMISSIONS_SCHEMA . ".applications ap "
                . " join " . _DB_ADMISSIONS_SCHEMA . ".application_status apst on ap.status_id = apst.status_id "
                . " join " . _DB_ADMISSIONS_SCHEMA . ".application_class apc on ap.apply_class = apc.class_id "
                . " where ap.school_id = '" . $school_id . "' and ap.phone = '" . $searchPhoneNum . "' ";
        
        $errMsg = "";
        $result = $this->selectData($query, $dbConn, $errMsg);
        if( $errMsg != "" ){
            $this->logging->logError( "Error getting application details : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "0" );
        }
        return $result;
    }
    
    public function getApplicationDetailsForSchool( $school_id, $fromSearch, $toSearch, $applicationStatus,
                    $applicationMotherTongue, $applicationIncomeLevel, $applicationFatherQual, $applicationMotherQual, 
                    $applicationForClass, $pageNo, $pageSize, &$applicationCount ){
        
        $dbConn = $this->db_connections[_DB_ADMISSIONS_GROUP];
        $this->load->library('Logging');
        
        $school_id = $this->realEscapeString($dbConn, $school_id);
	$fromSearch = $this->realEscapeString($dbConn, $fromSearch);
	$toSearch = $this->realEscapeString($dbConn, $toSearch);
	$applicationStatus = $this->realEscapeString($dbConn, $applicationStatus);
	$applicationMotherTongue = $this->realEscapeString($dbConn, $applicationMotherTongue);
	$applicationIncomeLevel = $this->realEscapeString($dbConn, $applicationIncomeLevel);
	$applicationFatherQual = $this->realEscapeString($dbConn, $applicationFatherQual);
	$applicationMotherQual = $this->realEscapeString($dbConn, $applicationMotherQual);
	$applicationForClass = $this->realEscapeString($dbConn, $applicationForClass);
	$pageNo = $this->realEscapeString($dbConn, $pageNo);
	$pageSize = $this->realEscapeString($dbConn, $pageSize);
        
        $application_query = "select ap.application_id, ap.student_name, ap.father_name, ap.mother_name, apc.class_desc, apqf.qualification_desc as father_qual, "
                            . " apqm.qualification_desc as mother_qual, apl.language, apai.income_desc, ap.phone, ap.email_id, "
                            . " date_format( ap.applied_at, '%d-%M-%Y' ) as applied_at, apst.status, ap.status_id " 
                            . " from " . _DB_ADMISSIONS_SCHEMA . ".applications ap "
                            . " join " . _DB_ADMISSIONS_SCHEMA . ".application_status apst on ap.status_id = apst.status_id "
                            . " join " . _DB_ADMISSIONS_SCHEMA . ".application_class apc on ap.apply_class = apc.class_id "
                            . " join " . _DB_ADMISSIONS_SCHEMA . ".application_qualification apqf on ap.father_qualification = apqf.qualification_id "
                            . " join " . _DB_ADMISSIONS_SCHEMA . ".application_qualification apqm on ap.mother_qualification = apqm.qualification_id "
                            . " join " . _DB_ADMISSIONS_SCHEMA . ".application_language apl on ap.mother_tongue = apl.language_id "
                            . " join " . _DB_ADMISSIONS_SCHEMA . ".application_annual_income apai on ap.annual_income = apai.income_id "
                            . " where ap.school_id = '$school_id' ";
        
        $application_count_query = "select count(1) as cnt " 
                            . " from " . _DB_ADMISSIONS_SCHEMA . ".applications ap "
                            . " where ap.school_id = '$school_id' ";
        
        $limitStr = "";
        if($pageSize>0) {
            $offset   = ($pageNo-1) * $pageSize;
            $rowcnt   = $pageSize;
            $limitStr = ( empty( $rowcnt ) ? " " : " limit ".$offset.",".$rowcnt );
        }
        
        $orderByStr = " order by ap.applied_at desc ";
        
        $cond = " ";
        $cond .= ( strlen( $applicationStatus ) == 0 ? " " : " and ap.status_id = '$applicationStatus' " );
        $cond .= ( strlen( $applicationMotherTongue ) == 0 ? " " : " and ap.mother_tongue = '$applicationMotherTongue' " );
        $cond .= ( strlen( $applicationFatherQual ) == 0 ? " " : " and ap.father_qualification = '$applicationFatherQual' " );
        $cond .= ( strlen( $applicationMotherQual ) == 0 ? " " : " and ap.mother_qualification = '$applicationMotherQual' " );
        $cond .= ( strlen( $applicationIncomeLevel ) == 0 ? " " : " and ap.annual_income = '$applicationIncomeLevel' " );
        $cond .= ( strlen( $applicationForClass ) == 0 ? " " : " and ap.apply_class = '$applicationForClass' " );
        
        if( $fromSearch != "" && $toSearch != "" ){
            $cond .= " and ap.applied_at between '$fromSearch' and '$toSearch' ";
        } else if( $fromSearch != "" && $toSearch == "" ){
            $cond .= " and ap.applied_at > '$fromSearch' ";
        } else if( $fromSearch == "" && $toSearch != "" ){
            $cond .= " and ap.applied_at < '$toSearch' ";
        }
        
        $application_query = $application_query . $cond . $orderByStr . $limitStr;
        $application_count_query = $application_count_query . $cond;
        
        $errMsg = "";
        $result = $this->selectData($application_query, $dbConn, $errMsg);
        if( $errMsg != "" ){
            $this->logging->logError( "Error getting application details in applications page: $errMsg ", __FILE__, __FUNCTION__, __LINE__, "0" );
            $errMsg = "";
        }
        $application_count_result = $this->selectData($application_count_query, $dbConn, $errMsg);
        if( count($application_count_result) > 0 ){
            $applicationCount = intval(trim($application_count_result[0]['cnt']));
        } else {
            $this->logging->logError( "Error getting application count in applications page: $errMsg ", __FILE__, __FUNCTION__, __LINE__, "0" );
        }
        
        return $result;
        
    }
    
    public function changeApplicationStatus( $applicationIDs, $changedStatus, $school_id ){
        $dbConn = $this->db_connections[_DB_ADMISSIONS_GROUP];
        $this->load->library('Logging');
        
        $applicationIDs = $this->realEscapeString($dbConn, $applicationIDs);
	$changedStatus = $this->realEscapeString($dbConn, $changedStatus);
	$school_id = $this->realEscapeString($dbConn, $school_id);
        
        $query = "update " . _DB_ADMISSIONS_SCHEMA . ".applications "
                . " set status_id = $changedStatus "
                . " where application_id in ( $applicationIDs ) "
                . " and school_id = '$school_id' "
                . " and status_id not in (" . _ADMISSION_APPLICATION_STATUS_ACCEPTED . ", " . _ADMISSION_APPLICATION_STATUS_REJECTED . " ) ";
        
        $errMsg = "";
        $affectedRows = 0;
        $this->executeUpdate( $query, $dbConn, $errMsg, $affectedRows );
        if( $errMsg == "" ){            
            return true;
        } else {
            $this->logging->logError( "Error changing application status: $errMsg ", __FILE__, __FUNCTION__, __LINE__, "0" );
            return false;
        }
    }
}