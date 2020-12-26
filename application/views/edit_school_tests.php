<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="editSchoolTestOnLoad();">
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
                <?php if( $header_message != "" ){ ?>
                    <div class="row">
                        <div id="alert" class="col-sm-6 col-sm-offset-3 alert-div" align="center;"> <!--margin-left:25%;margin-right:25%;-->
                            <p class="alert-text-ps"><?php echo $header_message; ?></p>
                        </div>
                    </div>
                <?php } ?>
                <div class="panel panel-default" style="width:100%;height:100%;margin-top:15px;">
                    <div class="panel-body" style="width:100%;">
                        <div class="row">
                            <div class="col-sm-3" style="text-align: center;">
                                <div class="panel-group" id="accordion" style="margin-bottom:0;">
                                    <button type="button" class="btn btn-default" style="width:100%;padding:10px; margin-bottom:5px;" 
                                            id="btnAddTest" name="btnAddTest" data-toggle="modal" data-target="#addTestModal" 
                                            data-backdrop="static" data-keyboard="true">
                                        <span class="glyphicon glyphicon-plus"></span> <strong>&nbsp;&nbsp;&nbsp;ADD TEST</strong>
                                    </button>
                                    <?php $i = 0;
                                    foreach( $classList as $class => $details ){ ?>
                                    <div class="panel panel-default" style="border-radius:0px;margin-top:0;"><!-- #F99999; -->
                                        <div class="panel-heading cursor-point light_background" data-toggle="collapse"
                                              data-parent="#accordion" data-target="#collapse<?php echo $i; ?>">
                                          <h5 class="small_title">
                                             <strong><?php echo $classMap[$class]; ?></strong>
                                          </h5>
                                            
                                        </div>
                                        <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse in">
                                            <div class="panel-body" style="background: white;padding:0;text-align:center;">
                                                <table class="table table-bordered" style="margin:0px;">
                                                <?php for( $j=0; $j < count($details); $j++ ){ ?>
                                                    <tr>
                                                        <td onclick="showTestDetails(<?php echo trim($details[$j]['class_id']); ?>);"
                                                            style="cursor:pointer;">
                                                            <p id="class_<?php echo trim($details[$j]['class_id']); ?>" style="margin:0px;">
                                                                <?php echo "Section " . trim($details[$j]['section']); ?>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; } ?>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div id="test_detail_div" style="text-align: center;">
                                    <h4><strong><span id="testDetailTitle">Test Details</span></strong></h4>
                                    <input type="hidden" id="chosen_class_id" name="chosen_class_id" value="">
                                    <input type="hidden" id="testJson" name="testJson" 
                                           value='<?php if( isset( $testDetails ) ) echo $testDetails; ?>'>
                                </div>
                                <table class="table table-bordered" id="testDetailsTbl" style="display:none;">
                                    <tr style="background:#eaeaea;">
                                        <th class="test_name">Test Name</th>
                                        <!-- <th class="grade_pattern">Grading Pattern</th> -->
                                        <th class="test_status">Status</th>
                                        <th class="test_fd">From Date</th>
                                        <th class="test_td">To Date</th>
                                        <th class="test_action">Action</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="addTestModal" class="modal fade" role="dialog" style="height:100%;">
                <div class="modal-dialog"> <!--  modal-lg -->
                    <div class="modal-content">
                        <div class="modal-header light_background">
                            <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                            <h4 class="modal-title" id="addTestTitle" style="text-align:center;"><strong>ADD TEST</strong></h4>
                        </div>
                        <div class="modal-body" id="addTestContent">
                            <form id="addTestForm" name="addTestForm" onsubmit="return validateAddTestForm();"
                                      action="/addSchoolTest" method="post">
                                <div class="form-group" id="addTestNameDiv">
                                    <label for="addTestName">Test Name<span style="color:red;">&nbsp;*</span></label>
                                    <input type="text" id="addTestName" class="form-control" 
                                           name="addTestName" value="">
                                    <p id="addTestNameMsg" class="inputAlert"></p>
                                </div>
                                <div class="form-group" id="addTestGradeTypeDiv">
                                    <label for="addTestGradeType">Grading Type<span style="color:red;">&nbsp;*</span>
                                        &nbsp;<em style="color:gray;">[NOTE : You will be able to change grading type for individual subjects once the test is added]</em>
                                    </label>
                                    <select id="addTestGradeType" name="addTestGradeType" class="form-control">
                                        <option value="">Select</option>
                                        <option value="<?php echo _GRADING_TYPE_A_TO_D; ?>">A to D</option>
                                        <option value="<?php echo _GRADING_TYPE_A_TO_F; ?>">A to F</option>
                                        <option value="<?php echo _GRADING_TYPE_0_TO_10; ?>">0 to 10</option>
                                        <option value="<?php echo _GRADING_TYPE_0_TO_100; ?>">0 to 100</option>
                                    </select>
                                    <p id="addTestGradeTypeMsg" class="inputAlert"></p>
                                </div>
                                <div class="form-group" id="addTestClassesDiv">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <label for="addTestClasses">Classes<span style="color:red;">&nbsp;*</span></label>
                                            <select id="addTestClasses" name="addTestClasses" class="form-control">
                                                <option value="">Select</option>
                                                <option value="<?php echo _ADMISSION_APPLY_PLAY_HOME; ?>">Play Home</option>
                                                <option value="<?php echo _ADMISSION_APPLY_PRE_KG; ?>">Pre KG</option>
                                                <option value="<?php echo _ADMISSION_APPLY_LKG; ?>">LKG</option>
                                                <option value="<?php echo _ADMISSION_APPLY_UKG; ?>">UKG</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_1; ?>">Class I</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_2; ?>">Class II</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_3; ?>">Class III</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_4; ?>">Class IV</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_5; ?>">Class V</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_6; ?>">Class VI</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_7; ?>">Class VII</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_8; ?>">Class VIII</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_9; ?>">Class IX</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_10; ?>">Class X</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_11; ?>">Class XI</option>
                                                <option value="<?php echo _ADMISSION_APPLY_CLASS_12; ?>">Class XII</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4" style="vertical-align: bottom;">
                                            <label for="addTestBtn"></label>
                                            <button type="button" class="btn btn-default form-control" onclick="addTestClass();"
                                                            id="addTestBtn" name="addTestBtn" style="margin-top:4px;">
                                                <span class="glyphicon glyphicon-plus"></span> 
                                                <strong>&nbsp;ADD CLASS</strong>
                                            </button>
                                            <input type="hidden" id="addedClassTests" name="addedClassTests" value="">
                                        </div>
                                    </div>
                                    <p id="addTestClassesMsg" class="inputAlert"></p>
                                </div>
                                <div class="form-group" id="addedTestClassesDiv">
                                    
                                </div>
                                <div class="form-group" id="addTestFromDateDiv">
                                    <label for="addTestFromDate">From Date<span style="color:red;">&nbsp;*</span></label>
                                    <input class="form-control" type="text" name="addTestFromDate" id="addTestFromDate" value="" 
                                           onclick="javascript:NewCssCal('addTestFromDate','yyyyMMdd','arrow',false,'12',false,'');">
                                    <p id="addTestFromDateMsg" class="inputAlert"></p>
                                </div>
                                <div class="form-group" id="addTestToDateDiv">
                                    <label for="addTestToDate">To Date<span style="color:red;">&nbsp;*</span></label>
                                    <input class="form-control" type="text" name="addTestToDate" id="addTestToDate" value="" 
                                           onclick="javascript:NewCssCal('addTestToDate','yyyyMMdd','arrow',false,'12',false,'');">
                                    <p id="addTestToDateMsg" class="inputAlert"></p>
                                </div>
                                <div class="form-group" id="addTestSubmitDiv" style="text-align: center;">
                                    <br>
                                    <input type="submit" id="addTestSubmit" name="addTestSubmit" 
                                           class="btn btn-primary" value="SUBMIT">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="editTestModal" class="modal fade" role="dialog" style="height:100%;">
                <div class="modal-dialog"> <!--  modal-lg -->
                    <div class="modal-content">
                        <div class="modal-header light_background">
                            <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                            <h4 class="modal-title" id="editTestTitle" style="text-align:center;"><strong>EDIT TEST</strong></h4>
                        </div>
                        <div class="modal-body" id="editTestContent">
                            <form id="editTestForm" name="editTestForm" onsubmit="return validateEditTestForm();"
                                      action="/editSchoolTest" method="post">
                                <div class="form-group" id="editTestNameDiv">
                                    <label for="editTestName">Test Name<span style="color:red;">&nbsp;*</span></label>
                                    <input type="text" id="editTestName" class="form-control" 
                                           name="editTestName" value="">
                                    <input type="hidden" id="editTestId" name="editTestId" value="">
                                    <p id="editTestNameMsg" class="inputAlert"></p>
                                </div>
                                <div class="form-group" id="editTestGradeTypeDiv">
                                    <label for="editTestGradeType">Grading Type<span style="color:red;">&nbsp;*</span>
                                        &nbsp;
                                    </label>
                                    <select id="editTestGradeType" name="editTestGradeType" class="form-control">
                                        <option value="">Select</option>
                                        <option value="<?php echo _GRADING_TYPE_A_TO_D; ?>">A to D</option>
                                        <option value="<?php echo _GRADING_TYPE_A_TO_F; ?>">A to F</option>
                                        <option value="<?php echo _GRADING_TYPE_0_TO_10; ?>">0 to 10</option>
                                        <option value="<?php echo _GRADING_TYPE_0_TO_100; ?>">0 to 100</option>
                                    </select>
                                    <p id="editTestGradeTypeMsg" class="inputAlert"></p>
                                </div>
                                <div class="form-group" id="editTestFromDateDiv">
                                    <label for="editTestFromDate">From Date<span style="color:red;">&nbsp;*</span></label>
                                    <input class="form-control" type="text" name="editTestFromDate" id="editTestFromDate" value="" 
                                           onclick="javascript:NewCssCal('editTestFromDate','yyyyMMdd','arrow',false,'12',false,'');">
                                    <p id="editTestFromDateMsg" class="inputAlert"></p>
                                </div>
                                <div class="form-group" id="editTestToDateDiv">
                                    <label for="editTestToDate">To Date<span style="color:red;">&nbsp;*</span></label>
                                    <input class="form-control" type="text" name="editTestToDate" id="editTestToDate" value="" 
                                           onclick="javascript:NewCssCal('editTestToDate','yyyyMMdd','arrow',false,'12',false,'');">
                                    <p id="editTestToDateMsg" class="inputAlert"></p>
                                </div>
                                <div class="form-group" id="editTestSubmitDiv" style="text-align: center;">
                                    <br>
                                    <input type="submit" id="editTestSubmit" name="editTestSubmit" 
                                           class="btn btn-primary" value="SAVE">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="testDetailModal" class="modal fade" role="dialog" style="height:100%;">
                <div class="modal-dialog modal-lg"> <!--  modal-lg -->
                    <div class="modal-content">
                        <div class="modal-header light_background">
                            <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                            <h4 class="modal-title" id="individualTestDetailTitle" style="text-align:center;"><strong>TEST DETAILS</strong></h4>
                            <h5 class="modal-title" style="text-align:center;">
                                <strong style="padding-right:68px;" id="individualTestTiming">(&nbsp;26 June TO 1 July&nbsp;)</strong>
                            </h5>
                        </div>
                        <div class="modal-body" id="editTestContent">
                            <!-- <div class="row">
                                <div class="col-sm-4  col-sm-offset-2">
                                    <p><strong>From</strong>&nbsp;<span id="fromTestTime">26th June</span></p>
                                </div>
                                <div class="col-sm-4">
                                    <p><strong>To</strong>&nbsp;<span id="toTestTime">1st July</span></p>
                                </div>
                            </div> -->  
                            <div id="testSubjectDetailsDiv">
                                <table id="testSubjectDetailsTbl" class="table table-bordered table-responsive">
                                    <tr style="background:#eaeaea;">
                                        <th style="text-align:center;">Subject</th>
                                        <th style="text-align:center;">Grading Type</th>
                                        <th style="text-align:center;">Date Of Test</th>
                                        <th style="text-align:center;">Test Timing</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="editTestDetailModal" class="modal fade" role="dialog" style="height:100%;">
                <div class="modal-dialog"> <!--  modal-lg -->
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom:0px;">
                            <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                            <h4 class="modal-title" id="testSubEditTitle" style="text-align:center;"><strong>TEST DETAILS</strong></h4>
                        </div>
                        <div class="modal-body" id="editTestContent">
                            <form id="editTestForm" name="editTestDetailForm" onsubmit="return validateEditTestDetailForm();"
                                      action="/editSchoolTestDetail" method="post">
                                <div class="form-group" id="editSubTestGradeTypeDiv">
                                    <label for="editTestGradeType">Grading Type<span style="color:red;">&nbsp;*</span>
                                        &nbsp;
                                    </label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <select id="editSubTestGradeType" name="editSubTestGradeType" class="form-control">
                                                <option value="">Select</option>
                                                <option value="<?php echo _GRADING_TYPE_A_TO_D; ?>">A to D</option>
                                                <option value="<?php echo _GRADING_TYPE_A_TO_F; ?>">A to F</option>
                                                <option value="<?php echo _GRADING_TYPE_0_TO_10; ?>">0 to 10</option>
                                                <option value="<?php echo _GRADING_TYPE_0_TO_100; ?>">0 to 100</option>
                                            </select>
                                        </div>
                                    </div>
                                    <p id="editSubTestGradeTypeMsg" class="inputAlert"></p>
                                </div>
                                <div class="form-group" id="editSubTestDateDiv">
                                    <label for="editSubTestDate">Date<span style="color:red;">&nbsp;*</span></label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <select id="editSubTestDate" name="editSubTestDate" class="form-control">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <p id="editSubTestDateMsg" class="inputAlert"></p>
                                </div>
                                <div class="form-group" id="editSubTestTimingDiv">
                                    <!--<label for="editSubTestTiming">Test Timing<span style="color:red;">&nbsp;*</span></label>-->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="editSubTestFrom">Test Start Time<span style="color:red;">&nbsp;*</span></label>
                                                <div class="row">
                                                    <div class="col-sm-3" style="padding-right:0px;">
                                                        <select id="editSubTestFromHour" name="editSubTestFromHour" class="form-control">
                                                            <option value="">--</option>
                                                            <?php for( $i = 1; $i <= 12; $i++ ){ ?>
                                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <p style="font-weight: bold;">:</p>
                                                    </div>
                                                    <div class="col-sm-3" style="padding:0px;">
                                                        <select id="editSubTestFromMinute" name="editSubTestFromMinute" class="form-control">
                                                            <option value="">--</option>
                                                            <?php for( $i = 0; $i <= 59; $i++ ){ ?>
                                                                <option value="<?php if( $i < 10 ) echo "0" . $i; else echo $i; ?>">
                                                                    <?php if( $i < 10 ) echo "0" . $i; else echo $i; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3" style="padding-right:0px;">
                                                        <select id="editSubTestFromAMPM" name="editSubTestFromAMPM" class="form-control">
                                                            <option value="AM">AM</option>
                                                            <option value="PM">PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="editSubTestTo">Test End Time<span style="color:red;">&nbsp;*</span></label>
                                                <div class="row">
                                                    <div class="col-sm-3" style="padding-right:0px;">
                                                        <select id="editSubTestToHour" name="editSubTestToHour" class="form-control">
                                                            <option value="">--</option>
                                                            <?php for( $i = 1; $i <= 12; $i++ ){ ?>
                                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <p style="font-weight: bold;">:</p>
                                                    </div>
                                                    <div class="col-sm-3" style="padding:0px;">
                                                        <select id="editSubTestToMinute" name="editSubTestToMinute" class="form-control">
                                                            <option value="">--</option>
                                                            <?php for( $i = 0; $i <= 59; $i++ ){ ?>
                                                                <option value="<?php if( $i < 10 ) echo "0" . $i; else echo $i; ?>">
                                                                    <?php if( $i < 10 ) echo "0" . $i; else echo $i; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3" style="padding-right:0px;">
                                                        <select id="editSubTestToAMPM" name="editSubTestToAMPM" class="form-control">
                                                            <option value="AM">AM</option>
                                                            <option value="PM">PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p id="editSubTestTimingMsg" class="inputAlert"></p>
                                </div>
                                <div class="form-group" id="editSubTestSubmitDiv" style="text-align: center;">
                                    <br>
                                    <input type="hidden" id="selectedTestId" name="selectedTestId" value="">
                                    <input type="hidden" id="selectedSubjectId" name="selectedSubjectId" value="">  
                                    <input type="button" id="editSubTestSubmit" name="editSubTestSubmit" 
                                           class="btn btn-primary" value="SAVE" onclick="validateAndSubmitTestDetails();">
                                </div>
                            </form>
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
        <script type="text/javascript" src="/public/js/school.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>