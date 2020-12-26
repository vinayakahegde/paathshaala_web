<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/
            <?php echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="schoolCalendarLoad();">
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
                            <div class="panel panel-default" style="min-height:100%;width:100%;">
                                <div class="panel-heading" style="text-align: center;"><strong>School Calendar</strong></div>
                                <div class="panel-body">
                                    <?php 
                                        $displayData = array();
                                        $displayData['calendar_info']   = $calendar_info;
                                        $displayData['calendar_start']  = $calendar_start;
                                        $displayData['calendar_end']    = $calendar_end; 
                                        $this->load->view('calendar', $displayData); ?>
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
                                            <?php }
                                    ?>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
                 <div id="calendarEventModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog">
                        <div class="modal-content" style="border-radius:0 !important;">
                            <div class="modal-header" style="padding-bottom:25px;" id="calendarEventModalHeader">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <!-- <h4 class="modal-title" id="calendarEventTitle" style="text-align:center;"><strong></strong></h4> -->
                            </div>
                            <div class="modal-body" id="calendarEventContent">
                                <img id="calendarEventContentImage" class="img-rounded img-responsive" 
                                             style="padding-bottom:20px;margin:0 auto;" alt="">
                                <p id="calendarEventContentText" style="width:100%;word-wrap:break-word;text-align: center;"></p>
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
                                <img id="notificationContentImage" class="img-rounded img-responsive" style="padding-bottom:20px;" alt="">
                                <p id="notificationContentText" style="width:100%;word-wrap:break-word;"></p>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
            <?php 
                $displayData = array();
                $this->load->view('common/footer', $displayData);
            ?>
        </div>
        <!-- Load JS -->
        <script type="text/javascript" src="/public/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/public/js/basic.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>