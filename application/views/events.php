<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/
            <?php echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="eventOnLoad();">
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
                    
                    $this->load->view('common/menu', $displayData); ?>
                 
                 <div class="container-fluid" style="margin:0px;">
                    <div class="row">
                        <div class="col-sm-9" style="padding:10px;padding-right:0px;">
                            <div class="panel panel-default" style="min-height:100%;width:100%;float:right;">
                                <div id="eventContainer" class="panel-body" style="width:100%;">
                                    <?php 
                                        $cnt = 0;
                                        $event_count = count( $event_information );
                                        while( $cnt < $event_count ){ ?>
                                            <div class="row">
                                                <div class="col-sm-6" id="event_elem_<?php echo trim($event_information[$cnt]['notification_id']);?>">
                                                    <div class="panel panel-default panel-custom"
                                                         id="event_<?php echo trim($event_information[$cnt]['notification_id']);?>" 
                                                        onmouseover="addPanelHighLight('event_' + '<?php echo trim($event_information[$cnt]['notification_id']);?>');" 
                                                        onmouseout="removePanelHighlight('event_' + '<?php echo trim($event_information[$cnt]['notification_id']);?>');"
                                                        data-toggle="modal" data-target="#eventModal">
                                                        <div class="panel-heading info-head">
                                                            <p><?php echo trim($event_information[$cnt]['notification_heading']); ?></p>
                                                            <input type="hidden" 
                                                                   id="notif_head_<?php echo trim($event_information[$cnt]['notification_id']);?>"
                                                                   value="<?php echo trim($event_information[$cnt]['notification_heading']); ?>" >
                                                        </div>
                                                        <div class="panel-body">
                                                            <p><?php echo substr( trim($event_information[$cnt]['notification_text']), 0, 150 ) . " ... "; ?></p>
                                                            <input type="hidden" id="notif_text_<?php echo trim($event_information[$cnt]['notification_id']);?>"
                                                                           value="<?php echo trim($event_information[$cnt]['notification_text']); ?>" >
                                                            <input type="hidden" id="img_url_<?php echo trim($event_information[$cnt]['notification_id']);?>"
                                                                           value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_NOTIFICATION_NUM 
                                                                                   . "/" .trim($event_information[$cnt]['notification_image_name']); ?>" >
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php $cnt++;
                                                if( $cnt < $event_count ){ ?>
                                                <div class="col-sm-6" id="event_elem_<?php echo trim($event_information[$cnt]['notification_id']);?>">
                                                    <div class="panel panel-default panel-custom" 
                                                         id="event_<?php echo trim($event_information[$cnt]['notification_id']);?>"  
                                                        onmouseover="addPanelHighLight('event_' + '<?php echo trim($event_information[$cnt]['notification_id']);?>');" 
                                                        onmouseout="removePanelHighlight('event_' + '<?php echo trim($event_information[$cnt]['notification_id']);?>');"
                                                        data-toggle="modal" data-target="#eventModal">
                                                        <div class="panel-heading info-head">
                                                            <p><?php echo trim($event_information[$cnt]['notification_heading']); ?></p>
                                                            <input type="hidden" 
                                                                   id="notif_head_<?php echo trim($event_information[$cnt]['notification_id']);?>"
                                                                   value="<?php echo trim($event_information[$cnt]['notification_heading']); ?>" >
                                                        </div>
                                                        <div class="panel-body">
                                                            <p><?php echo substr( trim($event_information[$cnt]['notification_text']), 0, 150 ) . " ... "; ?></p>
                                                            <input type="hidden" id="notif_text_<?php echo trim($event_information[$cnt]['notification_id']);?>"
                                                                           value="<?php echo trim($event_information[$cnt]['notification_text']); ?>" >
                                                            <input type="hidden" id="img_url_<?php echo trim($event_information[$cnt]['notification_id']);?>"
                                                                           value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_NOTIFICATION_NUM
                                                                                   . "/" . trim($event_information[$cnt]['notification_image_name']); ?>" >
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php $cnt++; 
                                                } ?>
                                            </div>
                                        <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3" style="padding:10px;">
                            <div class="panel panel-default" style="min-height:100%;width:100%;float:right;">
                              <div class="panel-heading" style="text-align: center;"><strong>Notifications</strong></div>
                              <div id="notificationContainer" class="panel-body" style="width:100%;height:500px;overflow:hidden;"
                                   onmouseover="disableScroll();" onmouseout="enableScroll();">
                                <div id="notifications" style="height:500px;">
                                    <table id="notificationTable" class="table table-striped table-hover borderless" style="margin-bottom:0px;">
                                    <?php
                                        for( $i=0; $i < count( $notifications ); $i++ ){ ?>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <a data-toggle="modal" data-target="#notificationModal" class="cursor-point"
                                                           id="notif_<?php echo trim($notifications[$i]['notification_id'])?>_1">
                                                        <?php if(array_key_exists('notification_heading', $notifications[$i]))
                                                                    echo trim($notifications[$i]['notification_heading']); ?>
                                                        </a>
                                                        <input type="hidden" id="home_notif_text_<?php echo trim($notifications[$i]['notification_id']); ?>"
                                                               value="<?php echo trim($notifications[$i]['notification_text']); ?>">
                                                        <input type="hidden" id="home_notif_image_<?php echo trim($notifications[$i]['notification_id']); ?>"
                                                               value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_NOTIFICATION_NUM 
                                                                       . "/" . trim($notifications[$i]['notification_image_name']); ?>">
                                                    </td>
                                                </tr>

                                        <?php  }
                                            for( $i=0; $i < count( $notifications ); $i++ ){ ?>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <a data-toggle="modal" data-target="#notificationModal" class="cursor-point"
                                                           id="notif_<?php echo trim($notifications[$i]['notification_id'])?>_2">
                                                        <?php if(array_key_exists('notification_heading', $notifications[$i]))
                                                                    echo trim($notifications[$i]['notification_heading']); ?>
                                                        </a>    
                                                    </td>
                                                </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 
                 <div id="eventModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="eventTitle"><strong></strong></h4>
                            </div>
                            <div class="modal-body" id="eventContent">
                                <!--<p>Hello there, &nbsp;&nbsp;&nbsp;   asdf<br> How are you doing? <br> This is a wonderful day!</p>-->
                                <img id="eventContentImage" class="img-rounded img-responsive" style="padding-bottom:20px;" alt="">
                                <p id="eventContentText" style="width:100%;word-wrap:break-word;"></p>
                            </div>
                        </div>
                    </div>
                 </div>
                 
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