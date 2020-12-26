<?php

$DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
require_once( $DOC_ROOT . '/application/libraries/DatabaseWrapper.php' );

class basicmodel extends DatabaseWrapper {    
    public function __construct() {
	parent::__construct();
        $this->db_connections = array();
        $this->db_connection_errors = array();
        date_default_timezone_set('Asia/Calcutta');
    }
    
    public function getTestData(){
        $errMsg = "";
        $this->load->library('Logging');
        if( !array_key_exists( _DB_DEFAULT_GROUP, $this->db_connections ) ){
            $this->db_connections[_DB_DEFAULT_GROUP] = $this->connectToDB($errMsg, _DB_DEFAULT_GROUP);
            if( $this->db_connections[_DB_DEFAULT_GROUP] == null ){
                $this->db_connection_errors[_DB_DEFAULT_GROUP] = $errMsg;
            }
        }
        
        $query = "select * from " . _DB_TEST_SCHEMA . ".testing "; 
        $dbConn = $this->db_connections[_DB_DEFAULT_GROUP];
        $errMsg = "";
        $result = $this->selectData( $query, $dbConn, $errMsg );
        return $result;
    }
    
    /*   Authenticate the user
     *   Input : 
     *   Username - string
     *   Password - string
     *   
     *   Output : 
     *   1 - authentic
     *   2 - invalid username
     *   3 - valid username, incorrect password
     */
    
    public function authenticate( $username, $password, &$user_details ){
        $errMsg = "";
        $this->load->library('Logging');
        if( !array_key_exists( _DB_CORE_GROUP, $this->db_connections ) ){
            $this->db_connections[_DB_CORE_GROUP] = $this->connectToDB($errMsg, _DB_CORE_GROUP);
            if( $this->db_connections[_DB_CORE_GROUP] == null ){
                $this->db_connection_errors[_DB_CORE_GROUP] = $errMsg;
                $this->logging->logError( "Error getting database connection : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "" );
            }
        }
        
        $dbConn = $this->db_connections[_DB_CORE_GROUP];
        $username = $this->realEscapeString($dbConn, $username);
        $password = hash( "sha512", $this->realEscapeString($dbConn, $password) . _PAATHSHAALA_SALT );
        
        $query_username = "select count(1) as cnt "
                . " from " . _DB_CORE_SCHEMA . ".users "
                . " where username = '" . $username . "' ";
        
        $query_authenticate = "select user_id, username, user_type, last_login, last_login_ip, init_password_changed "
                . " from " . _DB_CORE_SCHEMA . ".users "
                . " where username = '" . $username . "' "
                . " and password = '" . $password . "' limit 1 ";
         
        $errMsg = "";
        $result = $this->selectData($query_username, $dbConn, $errMsg);
        if( $errMsg != "" ){
            $this->logging->logError( "Error authenticating : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "$username" );
        }
        
        if( count( $result ) == 0 || $result[0]['cnt'] == '0' ){
            return 2;
        }
        
        $errMsg = "";
        $result = $this->selectData($query_authenticate, $dbConn, $errMsg);
        if( $errMsg != "" ){
            $this->logging->logError( "Error authenticating : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "$username" );
        }
        
        if( count( $result ) == 0 ){
            return 3;
        }
        
        $user_details['user_id']                = trim( $result[0]['user_id'] );
        $user_details['username']               = trim( $result[0]['username'] );
        $user_details['user_type']              = trim( $result[0]['user_type'] );
        $user_details['last_login']             = trim( $result[0]['last_login'] );
        $user_details['last_login_ip']          = trim( $result[0]['last_login_ip'] );
        $user_details['init_password_changed']  = trim( $result[0]['init_password_changed'] );
        
        return 1;
    }
    
    public function authenticateREST( $username, $password, &$user_details ){
        $errMsg = "";
        $this->load->library('Logging');
        if( !array_key_exists( _DB_CORE_GROUP, $this->db_connections ) ){
            $this->db_connections[_DB_CORE_GROUP] = $this->connectToDB($errMsg, _DB_CORE_GROUP);
            if( $this->db_connections[_DB_CORE_GROUP] == null ){
                $this->db_connection_errors[_DB_CORE_GROUP] = $errMsg;
                $this->logging->logError( "Error getting database connection : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "" );
            }
        }
        
        $dbConn = $this->db_connections[_DB_CORE_GROUP];
        $username = $this->realEscapeString($dbConn, $username);
        $password = $this->realEscapeString($dbConn, $password);
        
        $query_username = "select count(1) as cnt "
                . " from " . _DB_CORE_SCHEMA . ".users "
                . " where username = '" . $username . "' ";
        
        $query_authenticate = "select u.user_id, u.username, u.user_type, u.last_login, "
                . " u.last_login_ip, u.init_password_changed, coalesce( t.token, '' ) as token, "
                . " coalesce(session_id, '') as session_id, "
                . " case when session_expiry = '0000-00-00 00:00:00' "
                . " then 0 "
                . " else unix_timestamp( session_expiry ) "
                . " end as session_expiry "
                . " from " . _DB_CORE_SCHEMA . ".users u "
                . " left join test_1.pushTokens t on u.school_id = t.school_id and u.user_id = t.user_id "
                . " where u.username = '" . $username . "' "
                . " and u.password = '" . $password . "' limit 1 ";
         
        $errMsg = "";
        $result = $this->selectData($query_username, $dbConn, $errMsg);
        if( $errMsg != "" ){
            $this->logging->logError( "Error authenticating : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "$username" );
        }
        
        if( count( $result ) == 0 || $result[0]['cnt'] == '0' ){
            return 2;
        }
        
        $errMsg = "";
        $result = $this->selectData($query_authenticate, $dbConn, $errMsg);
        if( $errMsg != "" ){
            $this->logging->logError( "Error authenticating : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "$username" );
        }
        
        if( count( $result ) == 0 ){
            return 3;
        }
        
        $user_details['user_id']                = trim( $result[0]['user_id'] );
        $user_details['username']               = trim( $result[0]['username'] );
        $user_details['user_type']              = trim( $result[0]['user_type'] );
        $user_details['last_login']             = trim( $result[0]['last_login'] );
        $user_details['last_login_ip']          = trim( $result[0]['last_login_ip'] );
        $user_details['init_password_changed']  = trim( $result[0]['init_password_changed'] );
        $user_details['session_id']             = trim( $result[0]['session_id'] );
        $user_details['session_expiry']         = trim( $result[0]['session_expiry'] );
        $user_details['token']                  = trim( $result[0]['token'] );
        
        return 1;
    }
    
    public function generateAndInsertSessionID( $school_id, $username, $timestamp ){
        $errMsg = "";
        $this->load->library('Logging');
        if( !array_key_exists( _DB_CORE_GROUP, $this->db_connections ) ){
            $this->db_connections[_DB_CORE_GROUP] = $this->connectToDB($errMsg, _DB_CORE_GROUP);
            if( $this->db_connections[_DB_CORE_GROUP] == null ){
                $this->db_connection_errors[_DB_CORE_GROUP] = $errMsg;
                $this->logging->logError( "Error getting database connection : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "" );
            }
        }
        
        $dbConn = $this->db_connections[_DB_CORE_GROUP];
        $school_id = $this->realEscapeString($dbConn, $school_id);
	$username = $this->realEscapeString($dbConn, $username);
        
        $session_id = $this->generateRandomPassword(15) . uniqid();//test - chg minute to day
        $insert_query = "update " . _DB_CORE_SCHEMA . ".users
                            set session_id = '$session_id',
                                session_expiry = date_add( from_unixtime($timestamp), interval " . _USER_SESSION_EXPIRY_PERIOD . " day )
                            where username = '$username'
                            and school_id = '$school_id' ";
        
        $inserted = $this->executeInsert( $insert_query, $dbConn, $errMsg );
        if( $inserted ){
            return $session_id;
        }
        return "";
    }
    
    public function getGeneralNotifications( $school_id ){
        $errMsg = "";
        $this->load->library('Logging');
        if( !array_key_exists( _DB_GENERAL_GROUP, $this->db_connections ) ){
            $this->db_connections[_DB_GENERAL_GROUP] = $this->connectToDB($errMsg, _DB_GENERAL_GROUP);
            if( $this->db_connections[_DB_GENERAL_GROUP] == null ){
                $this->db_connection_errors[_DB_GENERAL_GROUP] = $errMsg;
                $this->logging->logError( "Error connecting to database : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "schoolid : $school_id" );
            } 
        }
        
        $dbConn = $this->db_connections[_DB_GENERAL_GROUP];
        $school_id = $this->realEscapeString($dbConn, $school_id);
        
        $query = "select notification_id, notification_heading, notification_text, notification_image_name "
                . " from " . _DB_GENERAL_SCHEMA . ".general_notifications "
                . " where school_id = $school_id and "
                . " status = '" . _GENERAL_NOTIFICATION_STATUS_ACTIVE . "' and "
                . " on_home_page = '" . _GENERAL_NOTIFICATION_DISPLAY_ON_HOME_YES . "' "
                . " and remove_by > now() "
                . " order by notification_type, priority desc "
                . " limit 50 ";
         
        $errMsg = "";
        $result = $this->selectData($query, $dbConn, $errMsg);
        if( $errMsg != "" ){
            $this->logging->logError( "Error getting general notifs : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "schoolid : $school_id" );
        }
        return $result;
    }
    
    public function getUserDetails( $school_id, $emailID ){
        $errMsg = "";
        $this->load->library('Logging');
        if( !array_key_exists( _DB_CORE_GROUP, $this->db_connections ) ){
            $this->db_connections[_DB_CORE_GROUP] = $this->connectToDB($errMsg, _DB_CORE_GROUP);
            if( $this->db_connections[_DB_CORE_GROUP] == null ){
                $this->db_connection_errors[_DB_CORE_GROUP] = $errMsg;
                $this->logging->logError( "Error connecting to database : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "schoolid : $school_id" );
            } 
        }
        
        $dbConn = $this->db_connections[_DB_CORE_GROUP];
        $school_id = $this->realEscapeString($dbConn, $school_id);
	$emailID = $this->realEscapeString($dbConn, $emailID);
        
        $query = "select username from " . _DB_CORE_SCHEMA . ".users "
                . " where school_id = '$school_id' and email_id = '$emailID' limit 1";
        
        $errMsg = "";
        $result = $this->selectData($query, $dbConn, $errMsg);
        if( count( $result ) == 0 ){
            $this->logging->logError( "Error getting username : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "emailID : $emailID" );
            return false;
        }
        return trim($result[0]['username']);
    }
    
    public function getValidUsername( $first_name, $last_name, $email = "" ){
        $errMsg = "";
        $this->load->library('Logging');
        if( !array_key_exists( _DB_CORE_GROUP, $this->db_connections ) ){
            $this->db_connections[_DB_CORE_GROUP] = $this->connectToDB($errMsg, _DB_CORE_GROUP);
            if( $this->db_connections[_DB_CORE_GROUP] == null ){
                $this->db_connection_errors[_DB_CORE_GROUP] = $errMsg;
                $this->logging->logError( "Error connecting to database : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "schoolid : $school_id" );
            } 
        }
        
        $dbConn = $this->db_connections[_DB_CORE_GROUP];
        
        $first_name = $this->realEscapeString($dbConn, strtolower( $first_name ) );
        $last_name = $this->realEscapeString($dbConn, strtolower( $last_name ) );
        $email = $this->realEscapeString($dbConn, $email );
        $randomStr1 = $this->generateRandomPassword(15);
        $randomStr2 = $this->generateRandomPassword(15);
        $randomStr3 = $this->generateRandomPassword(15);
        $randomStr4 = $this->generateRandomPassword(15);
        $randomStr5 = $this->generateRandomPassword(15);
        
        $user_names = array();
        if( $email != "" ){
            $user_names[ $email ] = true;
        }
        $user_names[ $first_name ] = true;
        $user_names[ $first_name . "_" . $last_name ] = true;
        $user_names[ $last_name . "_" . $first_name ] = true;
        $user_names[ $first_name . "_" . $last_name . "1" ] = true;
        $user_names[ $first_name . "_" . $last_name . "2" ] = true;
        $user_names[ $first_name . "_" . $last_name . "3" ] = true;
        $user_names[ $randomStr1 ] = true;
        $user_names[ $randomStr2 ] = true;
        $user_names[ $randomStr3 ] = true;
        $user_names[ $randomStr4 ] = true;
        $user_names[ $randomStr5 ] = true;
        
        $query = "select username	
                    from " . _DB_CORE_SCHEMA . ".users
                    where username in ( '$email', '$first_name', '$first_name" . "_" . "$last_name', '$last_name" . "_" . "$first_name', "
                . "'$first_name" . "_" . "$last_name" . "1', " .  "'$first_name" . "_" . "$last_name" . "2', "
                . "'$first_name" . "_" . "$last_name" . "3', '$randomStr1', '$randomStr2', '$randomStr3', '$randomStr4', '$randomStr5' ) ";
        
        $errMsg = "";
        $result = $this->selectData($query, $dbConn, $errMsg);
        if( $errMsg != "" ){
            $this->logging->logError( "Error in getUsernamesForValidation : $errMsg ", __FILE__, __FUNCTION__, __LINE__,
                                "first_name : $first_name ::: last_name : $last_name " );
            return "";
        }
        for( $i=0; $i < count( $result ); $i++ ){
            $user_names[ trim($result[$i]['username']) ] = false;
        }
        
        if( $email != "" && $user_names[ $email ] ){
            return $email;
        } else if( $user_names[ $first_name ] ){
            return $first_name;
        } else if( $user_names[ $first_name . "_" . $last_name ] ){
            return $first_name . "_" . $last_name;
        } else if( $user_names[ $last_name . "_" . $first_name ] ){
            return $last_name . "_" . $first_name;
        } else if( $user_names[ $first_name . "_" . $last_name . "1" ] ){
            return $first_name . "_" . $last_name . "1";
        } else if( $user_names[ $first_name . "_" . $last_name . "2" ] ){
            return $first_name . "_" . $last_name . "2";
        } else if( $user_names[ $first_name . "_" . $last_name . "3" ] ){
            return $first_name . "_" . $last_name . "3";
        } else if( $user_names[ $randomStr1 ] ) {
            return $randomStr1;
        } else if( $user_names[ $randomStr2 ] ) {
            return $randomStr2;
        } else if( $user_names[ $randomStr3 ] ) {
            return $randomStr3;
        } else if( $user_names[ $randomStr4 ] ) {
            return $randomStr4;
        } else if( $user_names[ $randomStr5 ] ) {
            return $randomStr5;
        }
    }
    
    public function generateRandomPassword( $length = 10 ){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen( $characters );
        $generated_password = "";
        for( $i=0; $i < $length; $i++ ){
            $generated_password = $generated_password . $characters[ rand(0, $charLength-1) ];
        }
        return $generated_password; 
    }
    
    public function addUser( $school_id, $username, $password, $email_id, $phone, $user_type ){
        $errMsg = "";
        $this->load->library('Logging');
        if( !array_key_exists( _DB_CORE_GROUP, $this->db_connections ) ){
            $this->db_connections[_DB_CORE_GROUP] = $this->connectToDB($errMsg, _DB_CORE_GROUP);
            if( $this->db_connections[_DB_CORE_GROUP] == null ){
                $this->db_connection_errors[_DB_CORE_GROUP] = $errMsg;
                $this->logging->logError( "Error connecting to database : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "schoolid : $school_id" );
            } 
        }
        
        $dbConn = $this->db_connections[_DB_CORE_GROUP];
        $school_id       = $this->realEscapeString($dbConn, $school_id);
        $username       = $this->realEscapeString($dbConn, $username);
        $password      = $this->realEscapeString($dbConn, $password);
        $email_id        = $this->realEscapeString($dbConn, $email_id);
        $phone          = $this->realEscapeString($dbConn, $phone);
        $user_type       = $this->realEscapeString($dbConn, $user_type);
        $hashed_password = hash( "sha512", $password . _PAATHSHAALA_SALT );
        
        $query = "insert into " . _DB_CORE_SCHEMA . ".users
                    ( school_id, username, password, generated_password, email_id, phone, user_type )
                    values
                    ( $school_id, '$username', '$hashed_password', '$password', '$email_id', '$phone', $user_type ) ";
        
        $errMsg = "";
        $inserted = $this->executeInsert($query, $dbConn, $errMsg);
        $user_id = $this->getLastInsertID( $dbConn );
        if( !$inserted )
            $this->logging->logError( "Error inserting user : $errMsg ", __FILE__, __FUNCTION__, __LINE__, "0" );
        
        return $user_id;
    }
}
