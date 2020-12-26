<?php

/*
 *  Mail Utility using the Google SMTP
 *  @author vinayakahegde
 */

    
class MailUtilities {   
    public function sendMail($to_email_ids, $to_email_names, $from_email_id, $from_email_name, $subject, $mail_body, $attachment_file_name) {
        $DOC_ROOT = $_SERVER['DOCUMENT_ROOT'];
        require_once($DOC_ROOT . '/system/libraries/PHPMailer/class.phpmailer.php');
        var_dump(openssl_get_cert_locations());
        $mail = new PHPMailer();
        $mail->Host = _ID_PHP_MAILER_HOST;
        $mail->SMTPDebug = 2; //0
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = _ID_PHP_MAILER_PORT;
        $mail->Username = _ID_PHP_MAILER_USER;
        $mail->Password = _ID_PHP_MAILER_PWD;  //smtpConnect  SMTPOptions
        $mail->smtpConnect = array(  
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->IsSMTP();
        $mail->isHTML(true);
        $mail->SetFrom($from_email_id, $from_email_name);
        $mail->AddReplyTo($from_email_id, $from_email_name );
        $mail->Subject = $subject;
        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
        $mail->MsgHTML($mail_body);
        for( $i=0; $i<count( $to_email_ids ); $i++ ){
            $mail->AddAddress( $to_email_ids[$i], $to_email_names[$i] );
        }
        
        if( trim($attachment_file_name) != "")
            $mail->AddAttachment($attachment_file_name);

        if (!$mail->Send()) {
            $error = "Exception in fatalStatusMismatch: " . $mail->ErrorInfo;
            // print $error;
            $this->writeLog($mail_body, $error, __FUNCTION__, 'Mail Send Error', '', $scanIdentifier = "");
        } else
            $this->writeLog($mail_body, 'Mail sent successfully', __FUNCTION__, 'Mail Send Sucess', '', $scanIdentifier = "");

        return;
    }
}

?>
