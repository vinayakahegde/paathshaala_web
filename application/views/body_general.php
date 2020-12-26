<div class="container-fluid" style="margin:0px;">
    <?php if( $header_message != "" ){ ?>
        <div class="row">
            <div id="alert" class="col-sm-6 col-sm-offset-3 alert-div" align="center;"> <!--margin-left:25%;margin-right:25%;-->
                <p class="alert-text-ps"><?php echo $header_message; ?></p>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-sm-9" style="padding:10px;padding-right:0px;">
            <!--<div style="min-height:100%; width:75%;float:left;">--
                <h1>content</h1>
            <!--</div>-->
            <div class="panel panel-default" style="min-height:100%;width:100%;">
                <div id="homeContainer" class="panel-body" style="width:100%;overflow:scroll;">
                    <!--<img id="schoolImage" name="schoolImage" src="../../public/images/vvshs_image.jpg"
                         class="img-rounded img-responsive" style="padding-bottom:20px;">-->
                    <img id="schoolImage" class="img-rounded img-responsive" style="padding-bottom:20px;" 
                         src="public/images/vvs_banner_2.jpg" alt="VVSHS">
                    <p>
                        <!-- Vidya Vardhaka Sangha High School! -->
Welcome to Total Schooling.
                    </p>
                    <p>
Finance minister Arun Jaitley has said the Supreme Court judgment striking down the 
National Judicial Appointments Commission Act is based on "erroneous logic".
                    </p>
                    <p>
"The Indian democracy cannot be a tyranny of the unelected and if the elected are undermined, 
democracy itself would be in danger," Jaitley said on Sunday, expressing his "personal" views in a 
Facebook post titled 'The NJAC Judgment - An Alternative View.'
                    </p>
                    <p>
The judgment has upheld the primacy of one basic structure - independence of judiciary - but diminished 
five other basic structures of the Constitution, namely, parliamentary democracy, an elected government, 
the council of ministers, an elected Prime Minister and the elected leader of the opposition. 
This is the fundamental error on which the majority has fallen," Jaitley wrote.
                    </p>
                    <p>
"A constitutional court, while interpreting the Constitution, had to base the judgment on constitutional principles. 
There is no constitutional principle that democracy and its institutions has to be saved from elected representatives," he said.
                    </p>
                    <p>

RECOGNITION
Recognised but un-aided.(Vide G.O. No. ED 58/ PGC 83/ Bangalore dsted 6th July 1984). 
Affiliated to CBSE Board, New Delhi. Code No. 830 225.

                    </p>
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
                        if( array_key_exists( 'notifications', $homeData ) ){
                            $notifications = $homeData['notifications'];  
                            //count( $notifications )
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
                        }
                    ?>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>