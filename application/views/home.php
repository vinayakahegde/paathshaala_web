<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/
            <?php echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body <?php if( !isset($user_type) ){ ?> onload="homeOnLoad();" <?php } ?> >
        <div id="wrap"><input type="hidden" id="base_url" value="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>">
            <div id="main" class="container" style="padding-bottom:0px;"> <!--  -->
                 <!-- -->
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

                    if( !isset($user_type) ){
                        $displayData['homeData'] = $homeData; 
                        $displayData['header_message'] = ( isset($header_message)? $header_message : "" );
                        $this->load->view('body_general', $displayData);
                    }  
                    
                ?>
                 <div id="notificationModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="notificationTitle"><strong></strong></h4>
                            </div>
                            <div class="modal-body" id="notificationModalContent">
                                <!--<p>Hello there, &nbsp;&nbsp;&nbsp;   asdf<br> How are you doing? <br> This is a wonderful day!</p>-->
                                <img id="notificationContentImage" class="img-rounded img-responsive" style="padding-bottom:20px;" alt="">
                                <p id="notificationContentText" style="width:100%;word-wrap:break-word;"></p>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
        <?php 
            $displayData = array();
            $this->load->view('common/footer', $displayData);
        ?>
        
        <!-- Forgot Username Div -->
        <div id="forgotUsernameDiv" class="ForgotCredentials">
            <div id="close">
                <img src="/public/images/close.png" onclick="closeForgotUsername();"
                                            title="Close Popup" style="float: right; cursor: pointer;">
            </div>
            <div id="forgotUsernameDetails">
                <span style="text-align: center;"><p>Please Enter Your Email ID : </p></span>
                <span style="text-align: center;"><input type="text" id="forgotUsernameEmailID" name="forgotUsernameEmailID" value="" ></span>
                <span style="text-align: center;">
                    <input type="button" id="forgotUsernameSubmitBtn" name="forgotUsernameSubmitBtn" value="Submit" onclick="mailUsername();" >
                </span>
            </div>
        </div>

        <!--Forgot Password Div -->
        <div id="forgotPasswordDiv" class="ForgotCredentials">
        </div>
    <!-- Load JS -->
        <script type="text/javascript" src="/public/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/public/js/basic.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>