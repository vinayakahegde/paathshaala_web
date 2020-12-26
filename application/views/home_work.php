<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="teacherHomeWorkOnload();">
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
                $classMap[ _ADMISSION_APPLY_PLAY_HOME ] = "Play Home";
                $classMap[ _ADMISSION_APPLY_PRE_KG ] = "Pre KG";
                $classMap[ _ADMISSION_APPLY_LKG ] = "LKG";
                $classMap[ _ADMISSION_APPLY_UKG ] = "UKG";
                $classMap[ _ADMISSION_APPLY_CLASS_1 ] = "Class I";
                $classMap[ _ADMISSION_APPLY_CLASS_2 ] = "Class II";
                $classMap[ _ADMISSION_APPLY_CLASS_3 ] = "Class III";
                $classMap[ _ADMISSION_APPLY_CLASS_4 ] = "Class IV";
                $classMap[ _ADMISSION_APPLY_CLASS_5 ] = "Class V";
                $classMap[ _ADMISSION_APPLY_CLASS_6 ] = "Class VI";
                $classMap[ _ADMISSION_APPLY_CLASS_7 ] = "Class VII";
                $classMap[ _ADMISSION_APPLY_CLASS_8 ] = "Class VIII";
                $classMap[ _ADMISSION_APPLY_CLASS_9 ] = "Class IX";
                $classMap[ _ADMISSION_APPLY_CLASS_10 ] = "Class X";
                $classMap[ _ADMISSION_APPLY_CLASS_11 ] = "Class XI";
                $classMap[ _ADMISSION_APPLY_CLASS_12 ] = "Class XII";
                
                function escapeString( $input_str ){
                    $input_str = str_replace("'", '&#39;', $input_str);
                    $input_str = str_replace("'", '&quot;', $input_str);
                    return $input_str;        
                }
            ?>
            <div class="container-fluid" style="margin:0px;"> <!--  padding:15px; -->
                <?php if( isset($header_message) && $header_message != "" ){ ?>
                    <div class="row">
                        <div id="alert" class="col-sm-6 col-sm-offset-3 alert-div" align="center;"> <!--margin-left:25%;margin-right:25%;-->
                            <p class="alert-text-ps"><?php echo $header_message; ?></p>
                        </div>
                    </div>
                <?php } ?>
                    <div class="panel panel-default" style="height:100%; margin-top: 15px;">
                        <div class="panel-body" style="padding-top:0px;">
                            <div class="row">
                                <div class="col-sm-3 light_background" style="margin-top: 0;padding-top: 15px;min-height: 500px;">
                                    <div class="form-group">
                                        <h4 style="text-align:center;"><strong>CLASSWISE SEARCH</strong></h4>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" id="classSubjectList" value='<?php echo $classSubjectList; ?>'>
                                        <label for="selectHWClass">Select Class</label>
                                        <select id="selectHWClass" class="form-control" onchange="populateClassSubjects();">
                                            <option value="">Select</option>
                                            <?php if( isset($classList) ) { 
                                                for( $i=0; $i < count($classList); $i++ ){ ?>
                                            <option value="<?php echo trim($classList[$i]['class_id']); ?>">
                                                <?php echo $classMap[trim($classList[$i]['class'])] . " - Section " . trim($classList[$i]['section']); ?>
                                            </option>
                                            <?php } 
                                                }
                                            ?>
                                        </select>
                                        <p id="selectHWClassMsg" class="inputAlert">* Please select a class</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="selectHWSubject">Select Subject</label>
                                        <select id="selectHWSubject" class="form-control">
                                            <option value="">Select</option>
                                        </select>
                                        <p id="selectHWSubjectMsg" class="inputAlert">* Please select a subject</p>
                                    </div>
                                    <div class="form-group">
                                        <button id="searchHWBtn" class="btn btn-primary form-control"
                                                onclick="populateHomeWork();">
                                            <span class="glyphicon glyphicon-search"></span>&nbsp;SEARCH
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <br>
                                        <h4 style="text-align: center;"><strong>TIMEWISE SEARCH</strong></h4>
                                        <button id="selectTimeCollapsible" class="btn form-control light_background"
                                                data-toggle="collapse" data-target="#timeSelectionDiv" > <!-- onclick="showHWTimeOptions();" -->
                                            <strong>-------------&nbsp;&nbsp;Select Time&nbsp;&nbsp;--------------</strong>
                                        </button>
                                    </div>
                                    <div id="timeSelectionDiv" class="collapse">
                                        <div class="form-group">
                                            <label for="selectPostedTime">Posted Date</label>
                                            <select id="selectPostedTime"  class="form-control">
                                                <option value="">Select</option>
                                                <?php if( isset( $postedDateArray ) ){
                                                    foreach( $postedDateArray as $date_key => $date_details ){ ?>
                                                        <option value="<?php echo $date_key; ?>"><?php echo $date_details['date_desc']; ?></option>
                                                <?php }
                                                    } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="selectCompleteByTime">Completion Date</label>
                                            <select id="selectCompleteByTime" class="form-control">
                                                <option value="">Select</option>
                                                <?php if( isset( $completionDateArray ) ){
                                                    foreach( $completionDateArray as $date_key => $date_details ){ ?>
                                                        <option value="<?php echo $date_key; ?>"><?php echo $date_details['date_desc']; ?></option>
                                                <?php }
                                                    } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button id="searchTimeHWBtn" class="btn btn-primary form-control"
                                                    onclick="populateTimeWiseHW();">
                                                <span class="glyphicon glyphicon-search"></span>&nbsp;SEARCH
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9" id="homeWorkContentDiv" style="margin-top:10px;">
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
        <script type="text/javascript" src="/public/js/teacher.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>