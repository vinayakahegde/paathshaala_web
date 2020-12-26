<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="teacherTTOnLoad();">
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

                $classMap = array();

                $classMap[_ADMISSION_APPLY_PRE_KG] = array( "Pre-KG", "PreKG");
                $classMap[_ADMISSION_APPLY_LKG] = array( "LKG", "LKG" );
                $classMap[_ADMISSION_APPLY_UKG] = array( "UKG", "UKG" );
                $classMap[_ADMISSION_APPLY_CLASS_1] = array( "Class I", "I" );
                $classMap[_ADMISSION_APPLY_CLASS_2] = array( "Class II", "II" );
                $classMap[_ADMISSION_APPLY_CLASS_3] = array( "Class III", "III" );
                $classMap[_ADMISSION_APPLY_CLASS_4] = array( "Class IV", "IV" );
                $classMap[_ADMISSION_APPLY_CLASS_5] = array( "Class V", "V" );
                $classMap[_ADMISSION_APPLY_CLASS_6] = array( "Class VI", "VI" );
                $classMap[_ADMISSION_APPLY_CLASS_7] = array( "Class VII", "VII" );
                $classMap[_ADMISSION_APPLY_CLASS_8] = array( "Class VIII", "VIII" );
                $classMap[_ADMISSION_APPLY_CLASS_9] = array( "Class IX", "IX" );
                $classMap[_ADMISSION_APPLY_CLASS_10] = array( "Class X", "X" );
                $classMap[_ADMISSION_APPLY_CLASS_11] = array( "Class XI", "XI" );
                $classMap[_ADMISSION_APPLY_CLASS_12] = array( "Class XII", "XII" );
                $classMap[_ADMISSION_APPLY_PLAY_HOME] = array( "Play Home", "PH" );
                
                function escapeString( $input_str ){

                    $input_str = str_replace("'", '&#39;', $input_str);
                    $input_str = str_replace("'", '&quot;', $input_str);
                    return $input_str;        
                }
                
                $dayArray = array("MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN");
                //$periodArray = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII" );
                $periodArray = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12" );
            ?>
            <div class="container-fluid" style="margin:0px;">
                <div class="panel panel-default" style="width:100%;height:100%;margin-top:15px;">
                    <div class="panel-body"> 
                        <input type="hidden" id="classTTJson" value="">
                        <input type="hidden" id="teacherTTJson" value='<?php if(isset($teacherTTJson)) echo $teacherTTJson; ?>'>
                        <div id="TimeTableMenu">
                            <ul class="nav nav-tabs nav-justified">
                              <li role="presentation" class="active custom-active">
                                  <a href="#" class="custom-link-active" id="myTimetable" onclick="activateMyTimeTable();">MY TIMETABLE</a>
                              </li>
                              <li role="presentation">
                                  <a href="#" id="classTimeTables" onclick="activateClassTimeTables();">CLASS TIMETABLES</a>
                              </li>
                            </ul>
                        </div>
                        <div id="timeTableContent">
                            <div class="row" style="margin:0; margin-top:15px;">
                                <div class="col-sm-1" style="margin:0;padding:2px;"></div>
                                <div class="col-sm-1" style="margin:0;padding:2px;"></div>
                            <?php for( $k=0; $k < _MAX_NUM_OF_PERIODS; $k++ ){ ?>
                                <div class="col-sm-1" style="margin:0;padding:2px;">
                                    <div class="panel panel-default panel-tt-detail panel-period" id="tt_period_<?php echo $k; ?>_panel" style="margin:0px;">
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
                                    <div class="panel panel-default panel-tt-detail panel-day" id="tt_day_<?php echo $j; ?>_panel">
                                        <div class="panel-body">
                                            <p style="margin:0;text-align:center;" id="tt_day_<?php echo $j; ?>"><strong><?php echo $dayArray[$j]; ?></strong></p>
                                        </div>
                                    </div>
                                </div>
                                <?php for( $i=0; $i < _MAX_NUM_OF_PERIODS; $i++ ){ ?>
                                    <div class="col-sm-1" style="margin:0;padding:2px;">
                                        <div class="panel panel-default panel-tt-detail" id="tt_<?php echo $j; ?>_<?php echo $i; ?>_panel" 
                                             data-toggle="modal" data-target="#showTTDetailsModal">
                                            <div class="panel-body">
                                                <p style="margin:0;text-align:center;" id="tt_<?php echo $j; ?>_<?php echo $i; ?>">
                                                    <?php if( trim($teacherTimeTable[$j][$i]['class']) != "" ){ 
                                                                echo $classMap[trim($teacherTimeTable[$j][$i]['class'])][1] . 
                                                                    "&nbsp;-&nbsp;" . trim($teacherTimeTable[$j][$i]['section']); ?>
                                                    <br>
                                                    <?php echo "[" . trim($teacherTimeTable[$j][$i]['subject_short']) . "]"; } else {
                                                        echo "&nbsp;";
                                                        } ?>
                                                </p>
                                                <input type="hidden" id="tt_<?php echo $j; ?>_<?php echo $i; ?>_subject_id" value="">
                                                <input type="hidden" id="tt_<?php echo $j; ?>_<?php echo $i; ?>_teacher_id" value="">
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
        <?php 
            $displayData = array();
            $this->load->view('common/footer', $displayData);
        ?>
        <!-- Load JS -->
        <script type="text/javascript" src="/public/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/public/js/teacher.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>    
</html>