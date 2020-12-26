<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/
            <?php echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="codeOfConductLoad();">
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
                                <div class="panel-heading" style="text-align: center;"><strong>Code Of Conduct</strong></div>
                                <div class="panel-body">
                                    <p>As in any family or community, a school must have rules.</p><br>

                                    <p>These rules set the standard by which individuals within the school measure their relationships with others. They are based on experience and common sense as well as the traditions and changing needs of the school. Some do not need to be written down as they are part of the everyday life of the school, administered as a matter of course by the staff and the Headmaster.</p>

                                    <p>The school rules are intended as guidelines for pupils in their conduct and for the Headmaster and staff in the exercise of their authority.</p>

                                    <p>It is recognised that the viewpoint of pupils and those in authority do not always coincide. There are mechanisms for dealing with these concerns, the intention being to reconcile significant differences and respect individuals, both pupils and staff.</p>
                                    <br><br>
                                    <p><strong>Important Rules and Conditions</strong></p>
                                    <p>•	Pupils must conduct themselves with common sense at all times.</p>
                                    <p>•	The school is often judged by the appearance of its pupils so all pupils are expected to be familiar with and adhere to the dress code.</p>
                                    <p>•	Pupils must treat each other, and visitors, with courtesy and consideration.</p>
                                    <p>•	Pupils must respect the authority of staff and of senior pupils entrusted by staff with particular responsibilities.</p>
                                    <p>•	Pupils must respect the amenities and property of the school and the local community.</p>
                                    <p>•	Times, commitments and restricted areas are clearly stated; pupils should abide by these and always check details on notice boards.</p>
                                    <p>•	Parental and house permission is essential for ‘leave’ and for permission to travel in any car. Term dates are always published well in advance; parents and pupils are given a termly calendar with details of meetings, fixtures and school events.</p> 
                                    <p>•	The drinking of alcohol, bullying, smoking, sexual impropriety, stealing and vandalism are not tolerated. Sanctions for major offences vary but in the last resort the Headmaster reserves the right to expel a pupil, particularly those who have disregard for the law of the land.</p>
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