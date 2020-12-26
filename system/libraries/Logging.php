<?php

/**
 * Description of Logging
 *
 * @author vinayakahegde
 */


class Logging {
    public static function logError( $message, $file, $function, $line_num, $identifier ){
        $error_msg = "[Line : $line_num] Function : $function( $file ) :: $message. IDENTIFIER : $identifier ";
        log_message( 'error', $error_msg );
    }
    
    public static function logDebug( $message, $file, $function, $line_num, $identifier ){
        $error_msg = "[Line : $line_num] Function : $function( $file ) :: $message. IDENTIFIER : $identifier ";
        log_message( 'debug', $error_msg );
    }
    
    public static function logInfo( $message, $file, $function, $line_num, $identifier ){
        $error_msg = "[Line : $line_num] Function : $function( $file ) :: $message. IDENTIFIER : $identifier ";
        log_message( 'info', $error_msg );
    }
}