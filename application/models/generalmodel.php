<?php

/**
 * Description of generalmodel
 *
 * @author vinayakahegde
 */

$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once( $DOC_ROOT . '/application/libraries/DatabaseWrapper.php' );

class generalmodel extends DatabaseWrapper {
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
        
        $errMsg = "";
        $this->db_connections[_DB_GENERAL_GROUP] = $this->connectToDB($errMsg, _DB_GENERAL_GROUP);
        if( $this->db_connections[_DB_GENERAL_GROUP] == null ){
            $this->db_connection_errors[_DB_GENERAL_GROUP] = $errMsg;
        }
        
        date_default_timezone_set('Asia/Calcutta');
    }
    
    public function getGeneralNotifications( $school_id ){
        $dbConn = $this->db_connections[_DB_GENERAL_GROUP];
        
        $query = "select notification_heading from " . _DB_GENERAL_SCHEMA . ".general_notifications "
                . " where school_id = $school_id and "
                . " status = '" . _GENERAL_NOTIFICATION_STATUS_ACTIVE . "'"
                . " order by notification_type, priority desc "
                . " limit 50 ";
        
        $result = $this->selectData($query, $dbConn, $errMsg);
        return $result;
    }
    
    public function getGeneralInformation( $school_id ){
        $dbConn = $this->db_connections[_DB_GENERAL_GROUP];
        
        $query = "select notification_id, notification_heading, notification_text, notification_image_name "
                . " from " . _DB_GENERAL_SCHEMA . ".general_notifications "
                . " where school_id = '$school_id' and "
                . " status = '" . _GENERAL_NOTIFICATION_STATUS_ACTIVE . "'"
                . " and notification_type != '" . _GENERAL_NOTIFICATION_EVENT . "'"
                . " and remove_by > now() ";
        
        $result = $this->selectData( $query, $dbConn, $errMsg );
        return $result;
                
    }
    
    public function getEventInformation( $school_id ){
        $dbConn = $this->db_connections[_DB_GENERAL_GROUP];
        
        $query = "select notification_id, notification_heading, notification_text, notification_image_name"
                . " from " . _DB_GENERAL_SCHEMA . ".general_notifications "
                . " where school_id = '$school_id' and "
                . " status = '" . _GENERAL_NOTIFICATION_STATUS_ACTIVE . "'"
                . " and notification_type = '" . _GENERAL_NOTIFICATION_EVENT . "'"
                . " and remove_by > now() ";
        
        $result = $this->selectData( $query, $dbConn, $errMsg );
        return $result;
                
    }
    
    public function getBoardInformation( $school_id ){
        $dbConn = $this->db_connections[_DB_GENERAL_GROUP];
        
        $query = "select member_id, name, short_description, description, phone, "
                . " email_id, website, blog, twitter_handle, image_url, phone_show, "
                . " email_show, website_show, blog_show, twitter_show "
                . " from " . _DB_GENERAL_SCHEMA . ".school_board "
                . " where school_id = '$school_id' and "
                . " deleted_flag = '" . _BOARD_MEMBER_ACTIVE . "'";
        
        $result = $this->selectData( $query, $dbConn, $errMsg );
        return $result;
    }
    
    public function getFacultyInformation( $school_id ){
        $dbConn = $this->db_connections[_DB_GENERAL_GROUP];
        
        $query = "select teacher_id, concat(first_name, ' ', last_name ) as name, short_desc, description, phone, "
                . " email_id, website, blog, twitter_handle, image_url, phone_show, experience, qualification, subjects, "
                . " email_show, website_show, blog_show, twitter_show, qual_show, exp_show, sub_show "
                . " from " . _DB_GENERAL_SCHEMA . ".faculty_general "
                . " where school_id = '$school_id' and "
                . " deleted_flag = '" . _FACULTY_GENERAL_ACTIVE . "'";
        
        $result = $this->selectData( $query, $dbConn, $errMsg );
        return $result;
    }
       
    public function getSchoolCalendar( $school_id ){
        $dbConn = $this->db_connections[_DB_GENERAL_GROUP];
        $this->load->library('Logging');
        $queryFrom = "select calendar_date from " . _DB_GENERAL_SCHEMA . ".school_calendar_term "
                . " where id = " . _SCHOOL_CALENDAR_START_DATE_NUM . " and school_id = $school_id "
                . " limit 1 ";
        
        $queryTo   = "select calendar_date from " . _DB_GENERAL_SCHEMA . ".school_calendar_term "
                . " where id = " . _SCHOOL_CALENDAR_END_DATE_NUM . " and school_id = $school_id "
                . " limit 1 ";
        
        $cal_date_from = "";
        $cal_date_to = "";
        
        $errMsg = "";
        $result = $this->selectData( $queryFrom, $dbConn, $errMsg );
        if( count( $result ) > 0 ){
            $cal_date_from = trim( $result[0]['calendar_date'] );
        } else {
            $this->logging->logError( "Error getting from calendar date : $errMsg", __FILE__, __FUNCTION__, __LINE__, "0" );
        }
        
        $errMsg = "";
        $result = $this->selectData( $queryTo, $dbConn, $errMsg );
        if( count( $result ) > 0 ){
            $cal_date_to = trim( $result[0]['calendar_date'] );
        } else {
            $this->logging->logError( "Error getting to calendar date : $errMsg", __FILE__, __FUNCTION__, __LINE__, "0" );
        }
        
        if( $cal_date_from != "" && $cal_date_to != "" ){
            $query = "select short_desc, description, date_format( calendar_date_from, '%d-%M-%Y' ) as from_date, "
                    . " date_format( calendar_date_to, '%d-%M-%Y' ) as to_date, item_type,"
                    . " date_format( calendar_date_from, '%d-%m-%Y' ) as from_day, date_format( calendar_date_to, '%d-%m-%Y' ) as to_day "
                    . " from " . _DB_GENERAL_SCHEMA . ".school_calendar "
                    . " where school_id = '$school_id' and "
                    . " deleted_flag = '" . _SCHOOL_CALENDAR_EVENT_ACTIVE . "' and "
                    . " calendar_date_from > '$cal_date_from' and "
                    . " calendar_date_from < '$cal_date_to' ";

            $errMsg="";
            $result = $this->selectData( $query, $dbConn, $errMsg );
            if( count( $result ) == 0 ){
                $this->logging->logError( "Error getting calendar events : $errMsg", __FILE__, __FUNCTION__, __LINE__, "0" );
            }
            $returnArray = array('cal_date_from' => $cal_date_from,
                                 'cal_date_to' => $cal_date_to,
                                 'events' => $result ); 
            return $returnArray;
        } else {
            $returnArray = array('cal_date_from' => now(),
                                 'cal_date_to' => now(),
                                 'events' => array());
        }
    }
}

?>