<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="addTestsOnLoad();">
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
            ?>
            <div class="container-fluid" style="margin:0px;">
                <div class="panel panel-default" style="width:100%;height:100%;margin-top:15px;">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <input type="hidden" id="testsAdded" name="testsAdded" 
                                               value="<?php if( isset( $testsAdded ) ) echo $testsAdded; else echo "false"; ?>">
                                        <form id="addTestsForm" name="addTestsForm"
                                              role="form" action="/addTests" method="post" onsubmit="return populateAddTests();">
                                                <div class="form-group">
                                                    <label for="testName">Test Name</label><br>
                                                    <input type="text" class="form-control" id="test_name" name="test_name" value="" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="fromTestPeriod">From Date</label><br>
                                                    <input class="form-control" type="text" name="fromTestPeriod" id="fromTestPeriod" value="" 
                                                           onclick="javascript:NewCssCal('fromTestPeriod','yyyyMMdd','arrow',false,'12',false,'');">
                                                </div>
                                                <div class="form-group">
                                                    <label for="toTestPeriod">To Date</label><br>
                                                    <input class="form-control" type="text" name="toTestPeriod" id="toTestPeriod" value="" 
                                                           onclick="javascript:NewCssCal('toTestPeriod','yyyyMMdd','arrow',false,'12',false,'');">
                                                </div>
                                                <div class="form-group">
                                                    <label for="gradingType">Grading Type</label><br>
                                                    <select id="gradingType" name="gradingType" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="<?PHP echo _GRADING_TYPE_A_TO_D; ?>">A to D</option>
                                                        <option value="<?PHP echo _GRADING_TYPE_A_TO_F; ?>">A to F</option>
                                                        <option value="<?PHP echo _GRADING_TYPE_0_TO_10; ?>">0 to 10</option>
                                                        <option value="<?PHP echo _GRADING_TYPE_0_TO_100; ?>">0 to 100</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="button" class="btn btn-primary" id="submitTest" name="submitTest" 
                                                           value="ADD" onclick="addTest();">
                                                </div>
                                                <div class="form-group">
                                                    <label for="addedSubjects">Added Subjects</label><br>
                                                    <input type="hidden" id="addedTestsJson" name="addedTestsJson" value="">
                                                    <div id="addedTests">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                      <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_PLAY_HOME ?>"
                                                                    id="class_id_1" name="class_id_1" onclick="toggleSectionTab(this,'1');">Play Home</label>
                                                        <div id="sections_1" style="display:none;">
                                                            <!-- <input type="text" class="input-sm" value="A">
                                                            <input type="text" class="input-sm" value="B">
                                                            <input type="text" class="input-sm" value="C">
                                                            <input type="text" class="input-sm" value="D">
                                                            <input type="button" class="btn btn-primary btn-sm" value="UPDATE"> -->
                                                        </div>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_PRE_KG ?>"
                                                                    id="class_id_2" name="class_id_2" onclick="toggleSectionTab(this,'2');">Pre KG</label>  
                                                        <div id="sections_2" style="display:none;">
                                                        </div>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_LKG ?>"
                                                                    id="class_id_3" name="class_id_3" onclick="toggleSectionTab(this,'3');">LKG</label> 
                                                        <div id="sections_3" style="display:none;">
                                                        </div>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_UKG ?>"
                                                                    id="class_id_4" name="class_id_4" onclick="toggleSectionTab(this,'4');">UKG</label>  
                                                        <div id="sections_4" style="display:none;">
                                                        </div>            
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_CLASS_1 ?>"
                                                                    id="class_id_5" name="class_id_5" onclick="toggleSectionTab(this,'5');">Class I</label>  
                                                        <div id="sections_5" style="display:none;">
                                                        </div>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_CLASS_2 ?>"
                                                                    id="class_id_6" name="class_id_6" onclick="toggleSectionTab(this,'6');">Class II</label>  
                                                        <div id="sections_6" style="display:none;">
                                                        </div>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_CLASS_3 ?>"
                                                                    id="class_id_7" name="class_id_7" onclick="toggleSectionTab(this,'7');">Class III</label>  
                                                        <div id="sections_7" style="display:none;">
                                                        </div>            
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_CLASS_4 ?>"
                                                                    id="class_id_8" name="class_id_8" onclick="toggleSectionTab(this,'8');">Class IV</label>
                                                        <div id="sections_8" style="display:none;">
                                                        </div>            
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_CLASS_5 ?>"
                                                                    id="class_id_9" name="class_id_9" onclick="toggleSectionTab(this,'9');">Class V</label> 
                                                        <div id="sections_9" style="display:none;">
                                                        </div>            
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_CLASS_6 ?>"
                                                                    id="class_id_10" name="class_id_10" onclick="toggleSectionTab(this,'10');">Class VI</label> 
                                                        <div id="sections_10" style="display:none;">
                                                        </div>            
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_CLASS_7 ?>"
                                                                    id="class_id_11" name="class_id_11" onclick="toggleSectionTab(this,'11');">Class VII</label>  
                                                        <div id="sections_11" style="display:none;">
                                                        </div>            
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_CLASS_8 ?>"
                                                                    id="class_id_12" name="class_id_12" onclick="toggleSectionTab(this,'12');">Class VIII</label>  
                                                        <div id="sections_12" style="display:none;">
                                                        </div>             
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_CLASS_9 ?>"
                                                                    id="class_id_13" name="class_id_13" onclick="toggleSectionTab(this,'13');">Class IX</label>  
                                                        <div id="sections_13" style="display:none;">
                                                        </div>            
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_CLASS_10 ?>"
                                                                    id="class_id_14" name="class_id_14" onclick="toggleSectionTab(this,'14');">Class X</label>  
                                                        <div id="sections_14" style="display:none;">
                                                        </div>            
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_CLASS_11 ?>"
                                                                    id="class_id_15" name="class_id_15" onclick="toggleSectionTab(this,'15');">Class XI</label>  
                                                        <div id="sections_15" style="display:none;">
                                                        </div>            
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="<?php echo _ADMISSION_APPLY_CLASS_12 ?>"
                                                                    id="class_id_16" name="class_id_16" onclick="toggleSectionTab(this,'16');">Class XII</label>  
                                                        <div id="sections_16" style="display:none;">
                                                        </div>            
                                                    </div>
                                                </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-warning" id="submitAddTests" 
                                                       name="submitAddTests" value="SUBMIT" >
                                            </div>
                                        </form>
                                        <!-- <button type="button" class="btn btn-default" style="width:100%;" 
                                                id="btnAddClass" name="btnAddClass" data-toggle="modal" data-target="#addClassModal" >
                                            <span class="glyphicon glyphicon-plus"></span> <strong>&nbsp;&nbsp;&nbsp;ADD CLASS</strong>
                                        </button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <p><strong>Added Classes</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <!-- Choose class - prekg to XII 
                 section,
                 Choose class teacher'
                 add subjects 
                 assign teachers to subjects
            
            configure num classes and section in admin panel
            -->
            
            </div>
        </div>
        <?php 
            $displayData = array();
            $this->load->view('common/footer', $displayData);
        ?>
        <!-- Load JS -->
        <script type="text/javascript" src="/public/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/public/js/admin.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>    
</html>