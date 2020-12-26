<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="teacherTestOnLoad();">
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
                    <div class="panel panel-default" style="height:100%; margin-top: 15px;">
                        <div class="panel-body" style="padding-top:0px;">
                            <div class="row">
                                <div class="col-sm-2 light_background" style="margin-top: 0;padding-top: 50px;min-height: 500px;">
                                    <div class="form-group">
                                        <p style="text-align:center;"><strong>SELECT CLASS</strong></p>
                                        <select id="selectTestClass" class="form-control" onchange="populateClassTests();">
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
                                    </div>
                                    <p style="text-align:center;"><strong>TESTS</strong></p> 
                                    <div id="showTests">
                                        <p style="text-align:center;">Please select a class!</p>
                                    </div>
                                </div>
                                <div class="col-sm-10" style="min-height:500px;padding-left:20px;">
                                    <div style="padding-bottom:10px;border-bottom:1px solid #eaeaea;">
                                        <h4 style="text-align: center;"><strong id="teacherClassTestTitle"></strong></h4>
                                        <h5 style="text-align: center;margin-bottom:2px;"><strong id="teacherTestTitle"></strong></h5>
                                        <input type="hidden" id="teacherTestContentJson" value="">
                                        <input type="hidden" id="gradingType" value="">
                                        <input type="hidden" id="testId" value="">
                                    </div>
                                    <div id="teacherTestContent" style="display:none;">
                                        <div id="teacherTestContentSubjects">
                                            <ul class="nav nav-tabs nav-justified">
                                              <li role="presentation" class="active custom-active">
                                                  <a href="#" class="custom-link-active">Sanskrit</a>
                                              </li>
                                              <li role="presentation"><a href="#">Mathematics</a></li>
                                              <li role="presentation"><a href="#">English Prose</a></li>
                                              <li role="presentation"><a href="#">Kannada Prose</a></li>
                                            </ul>
                                        </div>
                                        <div id="classSubjectScoresDiv" style="height:400px; overflow-y:scroll;">
                                            <table id="classSubjectScoresMeta" class="table table-bordered table-responsive"
                                                   style="margin:0px;">
                                                <tr>
                                                    <td colspan="2" style="text-align:center;font-weight:bold;width:30%;">Test Date </td>
                                                    <td colspan="3"><p  style="margin:0px;" id="details_testDate"> 24 June 2016 </p></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align:center;font-weight:bold;width:30%;">Grading Type </td>
                                                    <td colspan="3"><p  style="margin:0px;" id="details_gradingType">A to D </p></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align:center;font-weight:bold;width:30%;">Class Average </td>
                                                    <td colspan="3" id="classAvgTd">
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" style="text-align:center;font-weight:bold;">
                                                        <button type="button" id="editAllBtnTop" class="btn btn-primary"
                                                                onclick="enableEditAll();">
                                                            <span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;EDIT ALL
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table id="classSubjectScores" class="table table-bordered table-responsive">
                                                <tr style="background:#eaeaea;">
                                                    <th class="student_roll">Roll No.</th>
                                                    <th class="student_name">Student Name</th>
                                                    <th class="student_grade">Grade</th>
                                                    <th class="student_remark">Remarks</th>
                                                    <th class="student_action">Action</th>
                                                </tr>
                                            </table>
                                            <div style="text-align: center;">
                                                <button type="button" id="editAllBtnBottom" class="btn btn-primary"
                                                        onclick="enableEditAll();" >
                                                    <span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;EDIT ALL
                                                </button>
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
        <script type="text/javascript" src="/public/js/teacher.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>