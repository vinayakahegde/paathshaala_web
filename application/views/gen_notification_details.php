<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
</head>
<body>
<?php
    $displayData = array();
    if( isset($headerData) )
        $displayData['headerData'] = $headerData;
    
    $this->load->view('common/header',$displayData); 
    
    $displayData = array();
    if( isset($user_type) )
        $displayData['user_type'] = $user_type;
    if( isset($user_id) )
        $displayData['user_id'] = $user_id;
    
    $this->load->view('common/menu', $displayData);
    
    function escapeString( $input_str ){
        return str_replace( '"', '&quot;', $input_str );
    }
?>

<div id="notificationDetailsDiv" name="notificationDetailsDiv" >
    <h2><?php 
        error_log( "notif details : " . print_r( $notificationDetails, true ) ) ;
        if(array_key_exists('notification_heading', $notificationDetails))
            echo trim($notificationDetails['notification_heading']); ?>
    </h2>
    <br>
    <br>
    <div id="notificationDetailsText" name="notificationDetailsText" >
        <p><?php 
            if( array_key_exists( 'notification_text', $notificationDetails))
                echo trim($notificationDetails['notification_text']); ?>
        </p>
    </div>
</div> 

<!-- Load JS files -->
<script type="text/javascript" src="/public/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/public/js/school.js"></script>
<script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
    
</body>    