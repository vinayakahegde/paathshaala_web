<?php

/**
 * Description of SMSUtilities
 *
 * @author vinayakahegde
 */

class SMSUtilities {
    /*
     * Input : 
     * Number - 10 digit India phone number
     * Text - SMS text to be sent
     * 
     * Output :
     * TRUE on success. FALSE on failure
     */
    
    public static function sendSMS( $number, $text ){
        $sms_sent = SMSUtilities::sendSMSGupShup($number, $text);
        return $sms_sent;
    }
    
    public static function sendSMSGupShup( $number, $text ){
        
        $headers = array(
            "$gupshup_key_name : $gupshup_key"
        );
        
        $number = "91" . trim($number);
        $text = urlencode( $text );        
        $url = $url . "?message=$text&phone=$number";   
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
                
        $result = json_decode( $server_output, true );
        if( array_key_exists('response', $result) && array_key_exists('status', $result['response']) 
                && trim($result['response']['status']) == "success" ){
            return true;
        } 
        return false;
        /*$res = json_decode($server_output);
        /*echo $res->success;
        echo "\n";
        $error = curl_error($ch);
        error_log( "error : " . $error . "\n");
        return true;*/
    }
}

?>

