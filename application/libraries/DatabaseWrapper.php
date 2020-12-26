<?php

/**
 * Description of DatabaseWrapper
 *
 * @author vinayakahegde
 */

define('_DB_CONNECT_TRY_COUNT',		3);
define('_DB_QUERY_RUN_MAXTIME',		10);

define('_DB_RETURN_ARRAY_BOTH',  1);
define('_DB_RETURN_ARRAY_NUM',   2);
define('_DB_RETURN_ARRAY_ASSOC', 3);

class DatabaseWrapper extends CI_Model {
    protected $db_connections = null;
    protected $db_connection_errors = null;

    protected function connectToDB( &$errorMsg, $active_grp="default" )
    {
        $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
        include( $DOC_ROOT . '/application/config/database.php' );

        $host = $db[$active_grp]["hostname"];
        $user = $db[$active_grp]["username"];
        $pass = $db[$active_grp]["password"];
        $database = $db[$active_grp]["database"];

        $try_count = 0;
        $link = null;
        while( $link == null && $try_count < _DB_CONNECT_TRY_COUNT){
            $link = mysqli_connect($host,$user,$pass,$database);
            $try_count++;
            //sleep(_ID_CONNECT_RETRY_INTERVAL);
        }

        if( $link == null ){
            $errorMsg = mysqli_connect_error();
        } else {
            $errorMsg = "";
        }

        return $link;
    }
    
    protected function isValidDbConn( $conn ) {
        if(is_object($conn)  && get_class($conn)=='mysqli') 
            return true;

        return false;
    }
    
    protected function executeQuery($query, $conn, &$errMsg = "", &$numRows = 0 ){
        $time_limit_sec = _DB_QUERY_RUN_MAXTIME;
        $back_trace     = debug_backtrace ();
        
        if (!$this->isValidDbConn( $conn )) {
            $errMsg = "DB Connection is invalid";
            return false;
        }
        
        //query start time
        $time_start  = time();
        
        if ( mysqli_multi_query( $conn, $query) === FALSE ) {
            $errMsg = mysqli_error( $conn );
            $err_no = mysqli_errno( $conn );
            $errMsg = $err_no . " : " . $errMsg;
            return false;
        }

        //query execution end time
        $time_end  = time();

        $numRows = mysqli_affected_rows( $conn );
        $rs = mysqli_store_result( $conn );
        if( $rs !== false && is_object($rs) ){
            return $rs;
        } else {
            return false;
        }
    } 
    
    protected function executeInsert( $query, $conn, &$errMsg = ""  ){
        $time_limit_sec = _DB_QUERY_RUN_MAXTIME;
        $back_trace     = debug_backtrace ();
        
        if (!$this->isValidDbConn( $conn )) {
            $errMsg = "DB Connection is invalid";
            return false;
        }
        
        //query start time
        $time_start  = time();
        
        if ( mysqli_multi_query( $conn, $query) === FALSE ) {
            $errMsg = mysqli_error( $conn );
            $err_no = mysqli_errno( $conn );
            $errMsg = $err_no . " : " . $errMsg;
            return false;
        }

        //query execution end time
        $time_end  = time();
        return true;
    }
    
    protected function executeUpdate( $query, $conn, &$errMsg = "", &$affectedRows = 0 ){
        $time_limit_sec = _DB_QUERY_RUN_MAXTIME;
        $back_trace     = debug_backtrace ();
        
        if (!$this->isValidDbConn( $conn )) {
            $errMsg = "DB Connection is invalid";
            return false;
        }
        
        //query start time
        $time_start  = time();
        
        if ( mysqli_multi_query( $conn, $query) === FALSE ) {
            $errMsg = mysqli_error( $conn );
            $err_no = mysqli_errno( $conn );
            $errMsg = $err_no . " : " . $errMsg;
            return false;
        }

        $affectedRows = mysqli_affected_rows( $conn );
        //query execution end time
        $time_end  = time();
        return true;
    }
    
    protected function executeDelete( $query, $conn, &$errMsg = "", &$affectedRows = 0 ){
        $time_limit_sec = _DB_QUERY_RUN_MAXTIME;
        $back_trace     = debug_backtrace ();
        
        if (!$this->isValidDbConn( $conn )) {
            $errMsg = "DB Connection is invalid";
            return false;
        }
        
        //query start time
        $time_start  = time();
        
        if ( mysqli_multi_query( $conn, $query) === FALSE ) {
            $errMsg = mysqli_error( $conn );
            $err_no = mysqli_errno( $conn );
            $errMsg = $err_no . " : " . $errMsg;
            return false;
        }

        $affectedRows = mysqli_affected_rows( $conn );
        //query execution end time
        $time_end  = time();
        return true;
    }
    
    protected function fetchRow( $result_set, $type = MYSQLI_BOTH, &$errMsg = "" ) {
        if ( $result_set && is_object($result_set) ) {
            switch($type){
                case _DB_RETURN_ARRAY_BOTH   : return mysqli_fetch_array($result_set,MYSQLI_BOTH);
                case _DB_RETURN_ARRAY_NUM    : return mysqli_fetch_array($result_set,MYSQLI_NUM);
                case _DB_RETURN_ARRAY_ASSOC  : return mysqli_fetch_array($result_set,MYSQLI_ASSOC);
            }
        }
            //return mysqli_fetch_row($result_set);
        
        $errMsg = 'Not a valid mysqli row set object';
        return false;
    }
    
    protected function realEscapeString($conn, $string, &$errMsg = "" ){
        if( !is_string($string) ){
            return $string;
        }
        
        if ( $conn && is_object($conn) ) {
            return mysqli_real_escape_string($conn, $string);
        }
        
        $errMsg = 'Not a valid mysqli row set object';
        return false;
    }
    
    protected function getLastInsertID($conn, &$errMsg = "" ) {
        if ($this->isValidDbConn( $conn )) {
            return mysqli_insert_id($conn);
        }
        
        $errMsg = 'Not a valid mysqli connection';
        return false;
    }
    
    protected function freeResult( $result_set, &$errMsg = "" ) {
        if ( $result_set && is_object($result_set) ){
            mysqli_free_result($result_set);
            return true;
        }
        
        $errMsg = 'Not a valid mysqli row set';
        return false;
    }
    
    protected function selectData( $query, $conn, &$errMsg ) {
        $errMsg = "";
        $numRows = 0;
        $result_set = $this->executeQuery( $query, $conn, $errMsg, $numRows );
        $result = array();
        $cnt = 0;
        
        while( $row = $this->fetchRow( $result_set ) ){
            $result[$cnt++] = $row;
        }
        
        $this->freeResult($result_set);
        
        return $result;
    }
    
    protected function prepareStatement( $query, $param_string, $num_params, &$param_array, $conn, &$errMsg ){
        for( $i=0; $i < $num_params; $i++ ){
            $param_array[] = '';
        }
        $stmt = $conn->prepare( $query );
        $bind_stmt = '$stmt->bind_param($param_string, ';
        for( $i=0; $i < $num_params; $i++ ){
            $bind_stmt .= '$param_array[' . $i . '], ';
        }
        $bind_stmt = substr( $bind_stmt, 0, strlen( $bind_stmt ) - 2 );
        $bind_stmt .= ' );';
        eval( $bind_stmt );
        
        return $stmt;
    }
    
    protected function selectDataPrepared( $stmt, &$param_array, $num_return_params, $conn, &$errMsg ) {
        $stmt->execute();  
        $metaResults = $stmt->result_metadata();
        $fields = $metaResults->fetch_fields();
        $column=array();
        $statementParams='';
         //build the bind_results statement dynamically so I can get the results in an array
        foreach($fields as $field){
             if(empty($statementParams)){
                 $statementParams.="\$column['".$field->name."']";
             }else{
                 $statementParams.=", \$column['".$field->name."']";
             }
        }
        $statment="\$stmt->bind_result($statementParams);";
        eval($statment);
             
        $result = array();
        while ($stmt->fetch()) {
            $result[] = $column;
        }
        
        return $result;
    }
    
    protected function beginTransaction( $conn ){
        mysqli_query($conn, "START TRANSACTION");
        //mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);
    }
    
    protected function commitTransaction( $conn ){
        mysqli_query($conn, "COMMIT");
        //mysqli_commit($conn);
    }
    
    protected function rollBackTransaction( $conn ){
        mysqli_query($conn, "ROLLBACK");
        //mysqli_rollback($conn);
    }
    
}
