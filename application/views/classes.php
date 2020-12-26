<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="classesOnLoad();">
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

                $classMap[_ADMISSION_APPLY_PRE_KG] = "Pre-KG";
                $classMap[_ADMISSION_APPLY_LKG] = "LKG";
                $classMap[_ADMISSION_APPLY_UKG] = "UKG";
                $classMap[_ADMISSION_APPLY_CLASS_1] = "Class I";
                $classMap[_ADMISSION_APPLY_CLASS_2] = "Class II";
                $classMap[_ADMISSION_APPLY_CLASS_3] = "Class III";
                $classMap[_ADMISSION_APPLY_CLASS_4] = "Class IV";
                $classMap[_ADMISSION_APPLY_CLASS_5] = "Class V";
                $classMap[_ADMISSION_APPLY_CLASS_6] = "Class VI";
                $classMap[_ADMISSION_APPLY_CLASS_7] = "Class VII";
                $classMap[_ADMISSION_APPLY_CLASS_8] = "Class VIII";
                $classMap[_ADMISSION_APPLY_CLASS_9] = "Class IX";
                $classMap[_ADMISSION_APPLY_CLASS_10] = "Class X";
                $classMap[_ADMISSION_APPLY_CLASS_11] = "Class XI";
                $classMap[_ADMISSION_APPLY_CLASS_12] = "Class XII";
                $classMap[_ADMISSION_APPLY_PLAY_HOME] = "Play Home";
                
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
                                    <div class="panel-body" style="padding:0;">
                                        <input type="hidden" id="teacherList" name="teacherList" value='<?php echo $teacherList; ?>'>
                                        <input type="hidden" id="subjectList" name="subjectList" value='<?php echo $subjectList; ?>'>
                                        <div class="panel-group" id="accordion" style="margin-bottom:0;">
                                        <?php foreach( $classes as $class => $sections ){ 
                                                // $i=0; $i < count($classes); $i++ ) ?>
                                            <div class="panel panel-default" style="border-radius:0px;"><!-- #F99999; -->
                                                <div class="panel-heading cursor-point light_background" data-toggle="collapse"
                                                      data-parent="#accordion" data-target="#collapse<?php echo $class; ?>">
                                                  <h4 class="panel-title" style="text-align: center;">
                                                     <strong><?php echo $classMap[$class]; ?></strong>
                                                  </h4>
                                                </div>
                                                <div id="collapse<?php echo $class; ?>" class="panel-collapse collapse in">
                                                    <div class="panel-body" style="background: white;padding:0;">
                                                        <table class="table table-hover table-responsive table-bordered"
                                                               style="margin:0;">
                                                            <?php for( $i=0; $i < count($sections); $i++ ){ ?>  
                                                            <tr><td style="text-align: center;cursor:pointer;" id="menuClassId_<?php echo $sections[$i]['class_id']; ?>"
                                                                        onclick="populateClassDetails( '<?php echo $sections[$i]['class_id']; ?>');" >
                                                                    <input type="hidden" id="className_<?php echo $sections[$i]['class_id']; ?>" 
                                                                           value="<?php echo $classMap[$class] . '&nbsp;-&nbsp;&nbsp;Section ' . $sections[$i]['section']; ?>">
                                                                    <input type="hidden" id="maxPeriods_<?php echo $sections[$i]['class_id']; ?>" 
                                                                           value="<?php echo $sections[$i]['maxPeriods']; ?>">
                                                                    <input type="hidden" id="maxDays_<?php echo $sections[$i]['class_id']; ?>" 
                                                                           value="<?php echo $sections[$i]['maxDays']; ?>">
                                                                    <input type="hidden" id="teachers_<?php echo $sections[$i]['class_id']; ?>" 
                                                                           value="<?php echo $sections[$i]['teachers']; ?>">
                                                                    <input type="hidden" id="teacher_img_<?php echo $sections[$i]['class_id']; ?>" 
                                                                           value="<?php echo $sections[$i]['teacherImages']; ?>">
                                                                    <input type="hidden" id="subjects_<?php echo $sections[$i]['class_id']; ?>" 
                                                                           value="<?php echo $sections[$i]['subjects']; ?>">
                                                                    <input type="hidden" id="subjects_short_<?php echo $sections[$i]['class_id']; ?>" 
                                                                           value="<?php echo $sections[$i]['subjects_short']; ?>">
                                                                    <input type="hidden" id="subject_ids_<?php echo $sections[$i]['class_id']; ?>" 
                                                                           value="<?php echo $sections[$i]['subject_ids']; ?>">
                                                                    <input type="hidden" id="teacher_ids_<?php echo $sections[$i]['class_id']; ?>" 
                                                                           value="<?php echo $sections[$i]['teacher_ids']; ?>">
                                                                    <input type="hidden" id="percent_complete_<?php echo $sections[$i]['class_id']; ?>" 
                                                                           value="<?php echo $sections[$i]['percent_complete']; ?>">
                                                                    <strong><a href="#">
                                                                        <?php echo "Section " . $sections[$i]['section']; ?></a></strong>
                                                                </td></tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="panel-heading" style="padding-top:0px;">
                                    <h3 id="classHeading" style="text-align:center;margin-top:0px;"></h3>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body" style="padding:0;">
                                        <div class="panel panel-default" style="border-radius:0px;"><!-- #F99999; -->
                                            <div class="panel-group" id="accordionDetail" style="margin-bottom:0;">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading cursor-point light_background" data-toggle="collapse"
                                                          data-parent="#accordionDetail" data-target="#collapse_Teachers">
                                                      <h4 class="panel-title" style="text-align: center;">
                                                         <strong>TEACHERS</strong>
                                                      </h4>
                                                    </div>
                                                    <div id="collapse_Teachers" class="panel-collapse collapse in">
                                                        <div class="panel-body" id="subjects_body" style="background: white;padding:0;">
                                                            <div class="row">
                                                                <div class="col-sm-9">
                                                                    <table class="table table-responsive table-striped" id="subjectTable">
                                                                        <tr>
                                                                            <th style="text-align:center;">Subject</th>
                                                                            <th style="text-align:center;">Teacher</th>
                                                                            <th style="text-align:center;"></th>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-top:10px;">
                                                                    <input type="button" id="editSubjectsBtn" name="editSubjectsBtn" 
                                                                           class="btn btn-warning" value="EDIT SUBJECTS"
                                                                           data-toggle="modal" data-target="#editSubjectsModal">
                                                                    <input type="hidden" id="editSubjectsClassId" value="" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading cursor-point light_background" data-toggle="collapse"
                                                          data-parent="#accordionDetail" data-target="#collapse_TP">
                                                      <h4 class="panel-title" style="text-align: center;">
                                                         <strong>TEACHING PROGRESS</strong>
                                                      </h4>
                                                    </div>
                                                    <div id="collapse_TP" class="panel-collapse collapse in">
                                                        <div class="panel-body" id="Tteaching_progress_body" style="background: white;padding:0;">
                                                            <input type="hidden" id="classSyllabus" name="classSyllabus" value="" >
                                                            <table class="table table-responsive table-striped" id="teachingProgressTable">
                                                                <tr>
                                                                    <th style="text-align:center;">Subject</th>
                                                                    <th style="text-align:center;">Progress</th>
                                                                    <th style="text-align:center;"></th>
                                                                    <th style="text-align:center;"></th>
                                                                </tr>
                                                                <!--<tr>
                                                                    <td class="subject_col">English&nbsp;[ENG]</td>
                                                                    <td class="progress_col">
                                                                        <div class="progress">
                                                                            <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                                                aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                                                              70%
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="progress_action_col">
                                                                        <input type="button" id="editSyllabusBtn1" name="editSyllabusBtn1"
                                                                               value="EDIT SYLLABUS" class="btn btn-warning" 
                                                                               data-toggle="modal" data-target="#editSyllabusModal">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="subject_col">Kannada&nbsp;[KAN]</td>
                                                                    <td class="progress_col">
                                                                        <div class="progress">
                                                                            <div class="progress-bar" role="progressbar" aria-valuenow="75"
                                                                                aria-valuemin="0" aria-valuemax="100" style="width:75%">
                                                                              75%
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="progress_action_col">
                                                                        <input type="button" id="editSyllabusBtn2" name="editSyllabusBtn2"
                                                                               value="EDIT SYLLABUS" class="btn btn-warning" >
                                                                    </td>
                                                                </tr>-->
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading cursor-point light_background" data-toggle="collapse"
                                                          data-parent="#accordionDetail" data-target="#collapse_Students" id="studentCollapseDiv">
                                                      <h4 class="panel-title" style="text-align: center;">
                                                         <strong>STUDENTS</strong>
                                                      </h4>
                                                    </div>
                                                    <div id="collapse_Students" class="panel-collapse collapse in">
                                                        <div class="panel-body" id="student_body" style="background: white;padding:0;">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <table class="table table-bordered table-responsive" id="studentLeftTable">
                                                                        <tr style="background:#cccccc;">
                                                                            <th style="width:20%;text-align: center;">Roll No.</th>
                                                                            <th style="width:80%;text-align: center;">Student Name</th>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <table class="table table-bordered table-responsive" id="studentRightTable">
                                                                        <tr style="background:#cccccc;">
                                                                            <th style="width:20%;text-align: center;">Roll No.</th>
                                                                            <th style="width:80%;text-align: center;">Student Name</th>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--<div class="panel panel-default">
                                                    <div class="panel-heading cursor-point light_background" data-toggle="collapse"
                                                          data-parent="#accordionDetail" data-target="#collapse_SC">
                                                      <h4 class="panel-title" style="text-align: center;">
                                                         <strong>SCORE CARDS</strong>
                                                      </h4>
                                                    </div>
                                                    <div id="collapse_SC" class="panel-collapse collapse in">
                                                        <div class="panel-body" id="score_card_body" style="background: white;padding:0;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading cursor-point light_background" data-toggle="collapse"
                                                          data-parent="#accordionDetail" data-target="#collapse_Att">
                                                      <h4 class="panel-title" style="text-align: center;">
                                                         <strong>ATTENDANCE</strong>
                                                      </h4>
                                                    </div>
                                                    <div id="collapse_Att" class="panel-collapse collapse in">
                                                        <div class="panel-body" id="attendance_body" style="background: white;padding:0;">
                                                        </div>
                                                    </div>
                                                </div>-->
                                                <div class="panel panel-default">
                                                    <div class="panel-heading cursor-point light_background" data-toggle="collapse"
                                                          data-parent="#accordionDetail" data-target="#collapse_TT">
                                                      <h4 class="panel-title" style="text-align: center;">
                                                         <strong>TIME TABLE</strong>
                                                      </h4>
                                                    </div>
                                                    <div id="collapse_TT" class="panel-collapse collapse in">
                                                        <div class="panel-body" id="timetable_body" style="background: white;padding:0;">
                                                            <?php 
                                                                $displayData = array();
                                                                $this->load->view('timetable', $displayData); 
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="panel panel-default">
                                                    <div class="panel-heading cursor-point light_background" data-toggle="collapse"
                                                          data-parent="#accordionDetail" data-target="#collapse_ClassForum">
                                                      <h4 class="panel-title" style="text-align: center;">
                                                         <strong>CLASS FORUM</strong>
                                                      </h4>
                                                    </div>
                                                    <div id="collapse_ClassForum" class="panel-collapse collapse in">
                                                        <div class="panel-body" id="feedback_body" style="background: white;padding:0;">
                                                            <div class="row">
                                                                <div class="col-sm-12" style="min-height:500px;padding-left:20px;padding-top:20px;" id="classForumDiv">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
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
            <div id="editSubjectsModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header light_background">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="addTeacherTitle" style="text-align:center;"><strong>EDIT SUBJECTS</strong></h4>
                            </div>
                            <div class="modal-body" id="addTeacherContent">
                                <form id="editSubjectsForm" name="editSubjectsForm" action="/editSubjects" method="post">
                                    <table class="table table-responsive table-striped" id="subjectEditTable">
                                        <tr>
                                            <th style="text-align:center;">Subject</th>
                                            <th style="text-align:center;">Teacher</th>
                                            <th style="text-align:center;">Action</th>
                                        </tr>
                                    </table>
                                </form>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-default" onclick="addClassSubjectRow();">
                                            <span class="glyphicon glyphicon-plus"></span> 
                                            <strong>&nbsp;ADD SUBJECT</strong>
                                        </button>
                                    </div>
                                    <div class="col-sm-6" style="text-align:right;">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                                            <span class="glyphicon glyphicon-ok"></span> 
                                            <strong>&nbsp;DONE&nbsp;&nbsp;</strong>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="editSubjectsTTModal" class="modal fade" role="dialog" data-backdrop="static" style="height:100%;">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header light_background">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="editTTSubject" style="text-align:center;"><strong>EDIT</strong></h4>
                            </div>
                            <div class="modal-body" id="editTTSubjectContent">
                                <div class="form-group">
                                <input type="hidden" id="day_id_selected" name="day_id_selected" value="">
                                <input type="hidden" id="period_id_selected" name="period_id_selected" value="">
                                <select class="form-control" id="editTTSubjectSelect">
                                    <option value="">Select</option>
                                </select>
                                </div>
                                <div class="form-group" style="text-align:center !important;">
                                <input type="button" id="editTTSubjectBtn" name="editTTSubjectBtn" 
                                       class="btn btn-warning" value="DONE" onclick="submitEditSubjectTT();">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="editSyllabusModal" class="modal fade" role="dialog" data-backdrop="static" style="height:100%;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header light_background">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="editSyllabusHeading" style="text-align:center;"><strong>EDIT SYLLABUS</strong></h4>
                            </div>
                            <div class="modal-body" id="editSyllabusContent">
                                <input type="hidden" id="editSyllabusSubjectId" name="editSyllabusSubjectId" value="">
                                <table class="table table-responsive table-striped" id="syllabusEditTable">
                                    <tr>
                                        <th style="text-align:center;">Content</th>
                                        <th style="text-align:center;">Complete</th>
                                        <th style="text-align:center;">Weightage</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </table>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-default" onclick="addSyllabusContentRow();">
                                            <span class="glyphicon glyphicon-plus"></span> 
                                            <strong>&nbsp;ADD SYLLABUS CONTENT</strong>
                                        </button>
                                    </div>
                                    <div class="col-sm-6" style="text-align:right;">
                                        <button type="button" class="btn btn-primary" onclick="saveSyllabusEdit();">
                                            <span class="glyphicon glyphicon-ok"></span> 
                                            <strong>&nbsp;DONE&nbsp;&nbsp;</strong>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div id="syllabusImportModal" class="modal fade" role="dialog" data-backdrop="static" style="height:100%;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header light_background">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="importSyllabusHeading" style="text-align:center;"><strong>IMPORT SYLLABUS</strong></h4>
                        </div>
                        <div class="modal-body" id="importSyllabusContent">
                            <input type="hidden" id="importSyllabusSubjectId" name="importSyllabusSubjectId" value=""> 
                            <select id="importSyllabusSelect" class="form-control">
                                <option value="">Select</option>
                            </select><br>
                            <div style="text-align:center;">
                                <input type="button" id="importSyllabusBtn" name="importSyllabusBtn" class="btn btn-primary"
                                       value="IMPORT" onclick="importSyllabus();">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="feedDetailModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:0px;">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                            </div>
                            <div class="modal-body" id="feedDetailModalContent">
                                <!-- <div class="row">
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <p style="width:100%;"><strong>Vinayaka Hegde</strong></p>
                                            </div>
                                            <div class="col-sm-2 col-sm-offset-4 feed_time_div">
                                                <p style="width:100%;"><small>28 June</small></p>
                                            </div>
                                        </div>
                                        <p style="width:100%;">Sample update1... this is a lengthy update!!! really relally lenghty</p>
                                        <div id="commentsForPost" class="row" style="max-height: 300px;overflow-y:scroll;">
                                            <div class="col-sm-10" style="padding-right:0px;">
                                                <table class="table table-bordered table-responsive" id="commentTable" 
                                                       style="background:#efecec;margin:0px;">
                                                    <tr>
                                                        <td style="padding-top:0px; padding-bottom:0px;padding-right:1px;">
                                                            <strong>One Plus</strong><br>
                                                            <p>This is a sample comment</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top:0px; padding-bottom:0px;padding-right:1px;">
                                                            <strong>One Plus</strong><br>
                                                            <p>This is a sample comment 2</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top:0px; padding-bottom:0px;padding-right:1px;">
                                                            <strong>One Plus</strong><br>
                                                            <p>This is a sample comment 2</p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-10" style="padding-right:0px;">
                                                <textarea class="form-control" id="comment1" rows="1" 
                                                          value="" style="border-radius:0px;"></textarea>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="button" id="commentSubmitBtn1" class="btn btn-sm btn-primary" 
                                                       style="height:34px;" value="COMMENT">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div id="uploadPicModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:0px;">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                            </div>
                            <div class="modal-body" id="uploadPicModalContent">
                                <form id="uploadFeedImageForm" name="uploadFeedImageForm" method="post"
                                      action="/uploadFeedImage" enctype="multipart/form-data">
                                    <![if !IE]>
                                        <label class="btn btn-warning btn-file" style="margin-bottom:16px;">
                                            <span class="glyphicon glyphicon-plus"></span>&nbsp;Upload Picture 
                                            <input type="file" style="display: none;"  id="uploadFeedPic" name="uploadFeedPic"
                                                   onchange="showUploadedFileName(this);">
                                        </label>
                                        <span class='label label-info' id="upload-file-info"></span>
                                    <![endif]>
                                    <!--[if lte IE 8]> 
                                        <input type="file" id="uploadFeedPic" name="uploadFeedPic"> 
                                    <![endif]-->
                                    
                                    <div class="form-group">
                                        <label for="uploadPicText">Add Caption</label><br>
                                        <textarea id="uploadPicText" name="uploadPicText" rows="2" value="" class="form-control" ></textarea>
                                    </div>
                                    <div class="form-group" style="text-align:center;">
                                        <input type="hidden" id="pic_class_id" name="pic_class_id" value="">
                                        <input type="submit" id="submitFeedImageUpload" class="btn btn-primary" value="POST">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                 </div>
                 <div id="studentDetailModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg lg-modal-custom"> 
                       <div class="modal-content">
                           <div class="modal-header light_background">
                               <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                               <h4 class="modal-title" style="text-align:center;"><strong id="studentDetailTitle"></strong></h4>
                               <input type="hidden" id="scoreCardDetailsJson" value="">
                               <input type="hidden" id="studentAndParentDetails" value="">
                               <input type="hidden" id="selectedStudentId" value="">
                               <input type="hidden" id="profilePicBaseUrl" value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM; ?>">
                               <input type="hidden" id="profilePicDefault" value="<?php echo _DUMMY_PROFILE_PICTURE_FILENAME; ?>">
                           </div>
                           <div class="modal-body" id="studentDetailContent">
                               <div class="row">
                                   <div class="col-sm-3">
                                       <table id="studentDetailContentMenu" class="table table-bordered table-responsive">
                                           <tr>
                                               <td id="studentProfileOpt" class="student_pr_desc" onclick="showStudentProfile();">
                                                   Student Profile &nbsp;<span class="glyphicon glyphicon-chevron-right"></span>
                                               </td>
                                           </tr>
                                           <tr>
                                               <td id="fatherProfileOpt" class="student_pr_desc" onclick="showFatherProfile();">
                                                   Father Profile &nbsp;<span class="glyphicon glyphicon-chevron-right"></span>
                                               </td>
                                           </tr>
                                           <tr>
                                               <td id="motherProfileOpt" class="student_pr_desc" onclick="showMotherProfile();">
                                                   Mother Profile &nbsp;<span class="glyphicon glyphicon-chevron-right"></span>
                                               </td>
                                           </tr>
                                           <?php if( $user_type == _USER_TYPE_SCHOOL || $user_type == _USER_TYPE_TEACHER ){ ?>
                                            <tr>
                                                <td id="studentScoreCardOpt" class="student_pr_desc" onclick="showStudentScoreCards();">
                                                    Score Card &nbsp;<span class="glyphicon glyphicon-chevron-right"></span>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                       </table>
                                   </div>
                                   <div class="col-sm-9" style="height:400px;overflow-y:scroll;">
                                       <div id="studentOwnProfile" style="display:block;">
                                           <div class="row">
                                               <div class="col-sm-4">
                                                   <img id="studentProfileImg" alt="IMG" class="img-responsive img-rounded" src="" style="margin-top:10px;">
                                               </div>
                                               <div class="col-sm-8">
                                                   <h4 style="text-align:center;text-decoration: underline;">Basic Details</h4>
                                                   <table id="studentBasicDetailTable" class="table table-bordered table-responsive">
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">First Name</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="student_firstname"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Last Name</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="student_lastname"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Birthday</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="student_birthday"></p></td>
                                                       </tr>
                                                   </table>
                                                   <h4 style="text-align:center;text-decoration: underline;">Class Details</h4>
                                                   <table id="studentClassTable" class="table table-bordered table-responsive">
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Class</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="student_class"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Roll No.</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="student_roll"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Exam Registration No.</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="student_exam_regno"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Date Of Joining</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="student_doj"></p></td>
                                                       </tr>
                                                   </table>
                                                   <h4 style="text-align:center;text-decoration: underline;">Contact Details</h4>
                                                   <table id="studentContactDetailTable" class="table table-bordered table-responsive">
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Address</p></td>
                                                           <td class="profile_detail">
                                                               <p class="custom-p" id="student_address">

                                                               </p>
                                                           </td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Phone</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="student_phone"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Email</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="student_email"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Twitter</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="student_twitter"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Blog</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="student_blog"></p></td>
                                                       </tr>
                                                   </table>
                                                   <div id="otherDetails">
                                                       <h4 style="text-align:center;text-decoration: underline;">Other Details</h4>
                                                       <table id="studentOtherDetailTable" class="table table-bordered table-responsive">
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
                                       <div id="studentFatherProfile" style="display:none;">
                                           <div class="row">
                                               <div class="col-sm-4">
                                                   <img id="fatherProfileImg" alt="IMG" class="img-responsive img-rounded" src="" style="margin-top:10px;">
                                               </div>
                                               <div class="col-sm-8">
                                                   <h4 style="text-align:center;text-decoration: underline;">Basic Details</h4>
                                                   <table id="fatherBasicDetailTable" class="table table-bordered table-responsive">
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">First Name</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="father_firstname"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Last Name</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="father_lastname"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Birthday</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="father_birthday"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Marriage Anniversary</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="father_anniversary"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Qualification</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="father_qualification"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Place Of Work</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="father_pow"></p></td>
                                                       </tr>
                                                   </table>
                                                   <h4 style="text-align:center;text-decoration: underline;">Contact Details</h4>
                                                   <table id="fatherContactDetailTable" class="table table-bordered table-responsive">
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Address</p></td>
                                                           <td class="profile_detail">
                                                               <p class="custom-p" id="father_address">

                                                               </p>
                                                           </td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Phone</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="father_phone"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Email</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="father_email"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Twitter</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="father_twitter"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Blog</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="father_blog"></p></td>
                                                       </tr>
                                                   </table>
                                               </div>
                                           </div>
                                       </div>
                                       <div id="studentMotherProfile" style="display:none;">
                                           <div class="row">
                                               <div class="col-sm-4">
                                                   <img id="motherProfileImg" alt="IMG" class="img-responsive img-rounded" src="" style="margin-top:10px;">
                                               </div>
                                               <div class="col-sm-8">
                                                   <h4 style="text-align:center;text-decoration: underline;">Basic Details</h4>
                                                   <table id="motherBasicDetailTable" class="table table-bordered table-responsive">
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">First Name</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="mother_firstname"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Last Name</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="mother_lastname"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Birthday</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="mother_birthday"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Marriage Anniversary</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="mother_anniversary"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Qualification</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="mother_qualification"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Place Of Work</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="mother_pow"></p></td>
                                                       </tr>
                                                   </table>
                                                   <h4 style="text-align:center;text-decoration: underline;">Contact Details</h4>
                                                   <table id="motherContactDetailTable" class="table table-bordered table-responsive">
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Address</p></td>
                                                           <td class="profile_detail">
                                                               <p class="custom-p" id="mother_address">

                                                               </p>
                                                           </td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Phone</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="mother_phone"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Email</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="mother_email"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Twitter</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="mother_twitter"></p></td>
                                                       </tr>
                                                       <tr>
                                                           <td class="profile_desc"><p class="custom-p">Blog</p></td>
                                                           <td class="profile_detail"><p class="custom-p" id="mother_blog"></p></td>
                                                       </tr>
                                                   </table>
                                               </div>
                                           </div>
                                       </div>
                                       <div id="studentAttendance" style="display:none;">
                                        </div>
                                        <?php if( $user_type == _USER_TYPE_SCHOOL || $user_type == _USER_TYPE_TEACHER ){ ?>
                                        <div id="studentScoreCard" style="display:none;">
                                            <div id="studentTestDetailsMenu">
                                                <ul class="nav nav-tabs nav-justified">
                                                  <li role="presentation" class="active custom-active">
                                                      <a href="#" class="custom-link-active">Test 1</a>
                                                  </li>
                                                  <li role="presentation"><a href="#">Test 2</a></li>
                                                  <li role="presentation"><a href="#">Test 3</a></li>
                                                  <li role="presentation"><a href="#">Mid Term</a></li>
                                                  <li role="presentation"><a href="#">Test 4</a></li>
                                                  <li role="presentation"><a href="#">Test 5</a></li>
                                                  <li role="presentation"><a href="#">Test 6</a></li>
                                                  <li role="presentation"><a href="#">End Term</a></li>
                                                </ul>
                                            </div>
                                            <div id="studentTestDetailsTblDiv">
                                                <table id="studentTestDetailsTbl" class="table table-bordered table-responsive">
                                                    <tr style="background:#eaeaea;">
                                                        <th class="sc_subject">Subject</th>
                                                        <th class="sc_score">Score</th>
                                                        <th class="sc_average">Class Average</th>
                                                        <th class="sc_remarks">Teacher Remarks</th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <?php } ?>
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
        <script type="text/javascript" src="/public/js/school.js"></script>
        <script type="text/javascript" src="/public/js/user_details.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>    
</html>