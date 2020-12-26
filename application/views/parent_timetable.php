<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="parentTTOnLoad();">
        <div id="wrap"><input type="hidden" id="base_url" value="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>">
        <div id="main" class="container" style="padding-bottom:0px;">
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

                    $input_str = str_replace("'", '&#39;', $input_str);
                    $input_str = str_replace("'", '&quot;', $input_str);
                    return $input_str;        
                }
                
                $dayArray = array("MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN");
                $periodArray = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII" );
                
                $num_periods = _MAX_NUM_OF_PERIODS;
                $num_days = _MAX_NUM_DAYS;
                if( isset( $parentTimeTable ) ){
                    $num_periods = $parentTimeTable['num_periods'];
                    $num_days = $parentTimeTable['num_days'];
                    $parentTT = $parentTimeTable['timetable'];
                    $teachers = $parentTimeTable['teachers'];
                }
            ?>
            <div class="container-fluid" style="margin:0px;">
                <div class="panel panel-default" style="width:100%;height:100%;margin-top:15px;">
                    <div class="panel-body" style="padding-top:0px;">
                        <div class="row">
                            <div class="col-sm-3 light_background" style="padding:20px;">
                                <table class="table table-bordered table-responsive">
                                    <?php for( $i = 0; $i < count( $teachers ); $i++ ){ ?>
                                    <tr style="background:burlywood;text-align: center;">
                                        <td> 
                                            <strong><?php echo trim($teachers[$i]['subject_name']) . " [ " . 
                                                    trim($teachers[$i]['subject_short']) . " ] ";?></strong>
                                        </td>
                                    </tr>
                                    <tr style="background:#ffffff;text-align: center;cursor:pointer;">
                                        <td id="teacher_id_<?php echo trim($teachers[$i]['teacher_id']); ?>" 
                                            data-toggle="modal" data-target="#teacherModal" data-backdrop="static" data-keyboard="true"> 
                                            <?php echo trim($teachers[$i]['teacher_name']);?>
                                            <input type="hidden" id="teacher_pic_url_<?php echo trim($teachers[$i]['teacher_id']); ?>"
                                                   value="<?php if( trim($teachers[$i]['pic_url']) != "" ){
                                                                echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                '/' . trim($teachers[$i]['pic_url']); 

                                                           } else { 
                                                                echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                           }
                                                   ?>">
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <div class="col-sm-9">
                                <div id="timeTableContent">
                                    <div class="row" style="margin:0; margin-top:15px;">
                                        <div class="col-sm-1" style="margin:0;padding:2px;"></div>
                                        <div class="col-sm-1" style="margin:0;padding:2px;"></div>
                                    <?php for( $k=0; $k < $num_periods; $k++ ){ ?>
                                        <div class="col-sm-1" style="margin:0;padding:2px;">
                                            <div class="panel panel-default panel-date panel-period" id="st_tt_period_<?php echo $k; ?>_panel" style="margin:0px;">
                                                <div class="panel-body">
                                                    <p style="margin:0;text-align:center;" id="st_tt_period_<?php echo $k; ?>"><strong><?php echo $periodArray[$k]; ?></strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    </div>
                                    <?php for( $j=0; $j < $num_days; $j++ ){ ?>
                                    <div class="row" style="margin:0;">
                                        <div class="col-sm-1" style="margin:0;padding:2px;"></div>
                                        <div class="col-sm-1" style="margin:0;padding:2px;">
                                            <div class="panel panel-default panel-date panel-day" id="st_tt_day_<?php echo $j; ?>_panel">
                                                <div class="panel-body">
                                                    <p style="margin:0;text-align:center;" id="st_tt_day_<?php echo $j; ?>"><strong><?php echo $dayArray[$j]; ?></strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php for( $i=0; $i < $num_periods; $i++ ){ ?>
                                            <div class="col-sm-1" style="margin:0;padding:2px;">
                                                <div class="panel panel-default panel-date" id="st_tt_<?php echo $j; ?>_<?php echo $i; ?>_panel" 
                                                     data-toggle="modal" data-target="#showTTDetailsModal">
                                                    <div class="panel-body">
                                                        <p style="margin:0;text-align:center;" id="st_tt_<?php echo $j; ?>_<?php echo $i; ?>">
                                                            <?php if( trim($parentTT[$j][$i]['subject_desc']) != "" ){ 
                                                                        echo trim($parentTT[$j][$i]['subject_desc']); 
                                                                     } else {
                                                                        echo "&nbsp;";
                                                                    } ?>
                                                        </p>
                                                        <input type="hidden" id="st_tt_<?php echo $j; ?>_<?php echo $i; ?>_subject_id" 
                                                               value="<?php if( trim($parentTT[$j][$i]['subject_id']) != "" ) 
                                                                                echo trim($parentTT[$j][$i]['subject_id']); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="teacherModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg"> <!--  modal-lg -->
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:none;">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="addTeacherTitle" style="text-align:center;"><strong>Shruti Hassan</strong></h4>
                                <input type="hidden" id="selectedTeacherId" value="">
                            </div>
                            <div class="modal-body">
                                <div id="TeacherMenu">
                                    <ul class="nav nav-tabs nav-justified">
                                      <li role="presentation" class="active custom-active">
                                          <a href="#" class="custom-link-active" id="teacherDetails" onclick="activateTeacherDetails();">DETAILS</a>
                                      </li>
                                      <li role="presentation">
                                          <a href="#" id="teacherTimeTable" onclick="activateTeacherTimeTables();">TIMETABLE</a>
                                      </li>
                                    </ul>
                                </div>
                                <div id="teacherTimeTableContent" style="display:none;">
                                    <div class="row" style="margin:0; margin-top:15px;">
                                        <div class="col-sm-1" style="margin:0;padding:2px;"></div>
                                        <div class="col-sm-1" style="margin:0;padding:2px;"></div>
                                    <?php for( $k=0; $k < _MAX_NUM_OF_PERIODS; $k++ ){ ?>
                                        <div class="col-sm-1" style="margin:0;padding:2px;">
                                            <div class="panel panel-default panel-date panel-period" id="tt_period_<?php echo $k; ?>_panel" style="margin:0px;">
                                                <div class="panel-body">
                                                    <p style="margin:0;text-align:center;" id="tt_period_<?php echo $k; ?>"><strong><?php echo $periodArray[$k]; ?></strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    </div>
                                    <?php for( $j=0; $j < _MAX_NUM_DAYS; $j++ ){ ?>
                                    <div class="row" style="margin:0;">
                                        <div class="col-sm-1" style="margin:0;padding:2px;"></div>
                                        <div class="col-sm-1" style="margin:0;padding:2px;">
                                            <div class="panel panel-default panel-date panel-day" id="tt_day_<?php echo $j; ?>_panel">
                                                <div class="panel-body">
                                                    <p style="margin:0;text-align:center;" id="tt_day_<?php echo $j; ?>"><strong><?php echo $dayArray[$j]; ?></strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php for( $i=0; $i < _MAX_NUM_OF_PERIODS; $i++ ){ ?>
                                            <div class="col-sm-1" style="margin:0;padding:2px;">
                                                <div class="panel panel-default panel-date" id="tt_<?php echo $j; ?>_<?php echo $i; ?>_panel" 
                                                     data-toggle="modal" data-target="#showTTDetailsModal">
                                                    <div class="panel-body">
                                                        <p style="margin:0;text-align:center;" id="tt_<?php echo $j; ?>_<?php echo $i; ?>">
                                                            &nbsp;
                                                        </p>
                                                        <input type="hidden" id="tt_<?php echo $j; ?>_<?php echo $i; ?>_subject_id" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div id="teacherDetailContent" style="display:block;">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <img id="teacherDetailImg" alt="IMG" class="img-responsive img-rounded" src="" style="margin-top:10px;">
                                        </div>
                                        <div class="col-sm-8">
                                            <h4 style="text-align:center;text-decoration: underline;">Basic Details</h4>
                                            <table id="teacherBasicDetailTable" class="table table-bordered table-responsive">
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">First Name</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_firstname"></p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Last Name</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_lastname"></p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Birthday</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_birthday"></p></td>
                                                </tr>
                                            </table>
                                            <h4 style="text-align:center;text-decoration: underline;">Professional Details</h4>
                                            <table id="teacherProfDetailTable" class="table table-bordered table-responsive">
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Qualification</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_qualification"></p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Experience</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_experience"></p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Date Of Joining</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_doj"></p></td>
                                                </tr>
                                            </table>
                                            <h4 style="text-align:center;text-decoration: underline;">Contact Details</h4>
                                            <table id="teacherContactDetailTable" class="table table-bordered table-responsive">
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Address</p></td>
                                                    <td class="profile_detail">
                                                        <p class="custom-p" id="teacher_address">
                                                            
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Phone</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_phone"></p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Email</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_email"></p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Twitter</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_twitter"></p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Blog</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_blog"></p></td>
                                                </tr>
                                            </table>
                                            <div id="otherDetails">
                                                <h4 style="text-align:center;text-decoration: underline;">Other Details</h4>
                                                <table id="teacherOtherDetailTable" class="table table-bordered table-responsive">
                                                    <tr>
                                                        <th style="text-align: center;background:#eeeeee;width:50%;">Hobbies</th>
                                                        <th style="text-align: center;background:#eeeeee;width:50%;">Achievements</th>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;"><p class="custom-p" id="hobby_1"></p></td>
                                                        <td style="text-align: center;"><p class="custom-p" id="achievement_1"></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;"><p class="custom-p" id="hobby_2"></p></td>
                                                        <td style="text-align: center;"><p class="custom-p" id="achievement_2"></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;"><p class="custom-p" id="hobby_3"></p></td>
                                                        <td style="text-align: center;"><p class="custom-p" id="achievement_3"></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;"><p class="custom-p" id="hobby_4"></p></td>
                                                        <td style="text-align: center;"><p class="custom-p" id="achievement_4"></p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;"><p class="custom-p" id="hobby_5"></p></td>
                                                        <td style="text-align: center;"><p class="custom-p" id="achievement_5"></p></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        <!-- Load JS -->
        <script type="text/javascript" src="/public/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/public/js/parent.js"></script>
        <script type="text/javascript" src="/public/js/user_details.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>    
</html>