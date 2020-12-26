<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="parentStudentOnLoad();">
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
                        <div class="teacherResultDiv">
                            <h4 id="teacherSearchCriteria" style="text-align: center;">
                                <strong><i>Class:&nbsp;</i></strong> &nbsp;
                                    <?php if( isset($class_desc) ){ echo $class_desc; } ?>
                                
                            </h4>
                            <?php $student_count = count($students);
                                for( $i=0; $i < $student_count; $i++ ){ ?>
                            <div class="row">
                                <div class="col-sm-4"><!--style="padding-left:10px;padding-right:0px;" style="padding:25px;" -->
                                    <div class="panel panel-default panel-custom" style="height:100%;width:100%;"
                                         id="teacher_id_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                         onmouseover="addPanelHighLight('student_id_<?php echo trim( $students[$i]['student_id'] ); ?>');" 
                                         onmouseout="removePanelHighlight('student_id_<?php echo trim( $students[$i]['student_id'] ); ?>');"
                                         data-toggle="modal" data-target="#studentDetailModal" data-backdrop="static"> <!-- min-height:100%; -->
                                        <div class="panel-heading info-head">
                                            <p style="text-align:center;"><strong id="student_name_<?php echo trim( $students[$i]['student_id'] ); ?>">
                                                <?php echo trim( $students[$i]['student_name'] ); ?>
                                                </strong></p>
                                        </div>
                                        <div id="studentContainer_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                             class="panel-body" style="width:100%;">
                                            <div class="studentImageDiv" style="width:100%;">
                                                <img id="studentImage_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                            </div>
                                            <div>
                                                <table class="table table-responsive borderless" 
                                                           id="studentDetailsTbl_<?php echo trim( $students[$i]['student_id'] ); ?>">
                                                        <colgroup>
                                                            <col style="width:100px;">
                                                            <col>
                                                        </colgroup>
                                                        <tr>
                                                            <td><p><strong>Roll No.</strong></p></td>
                                                            <td><p><?php echo trim( $students[$i]['student_roll_no'] ); ?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><p><strong>Father</strong></p></td>
                                                            <td>
                                                                <p><?php echo trim( $students[$i]['father_name'] ); ?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><p><strong>Mother</strong></p></td>
                                                            <td>
                                                                <p><?php echo trim( $students[$i]['mother_name'] ); ?></p>
                                                                <input type="hidden" id="student_pic_url_<?php echo trim($students[$i]['student_id']); ?>"
                                                                        value="<?php if( trim($students[$i]['pic_url']) != "" ){
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . trim($students[$i]['pic_url']); 

                                                                                       } else { 
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                                       }
                                                                               ?>">
                                                                <input type="hidden" id="student_father_pic_url_<?php echo trim($students[$i]['student_id']); ?>"
                                                                        value="<?php if( trim($students[$i]['father_pic_url']) != "" ){
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . trim($students[$i]['father_pic_url']); 

                                                                                       } else { 
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                                       }
                                                                               ?>">
                                                                <input type="hidden" id="student_mother_pic_url_<?php echo trim($students[$i]['student_id']); ?>"
                                                                        value="<?php if( trim($students[$i]['mother_pic_url']) != "" ){
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . trim($students[$i]['mother_pic_url']); 

                                                                                       } else { 
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                                       }
                                                                               ?>">
                                                                
                                                            </td>
                                                        </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++;
                                    if( $i < $student_count ){ ?>
                                <div class="col-sm-4"><!--style="padding-left:10px;padding-right:0px;" style="padding:25px;" -->
                                    <div class="panel panel-default panel-custom" style="height:100%;width:100%;"
                                         id="teacher_id_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                         onmouseover="addPanelHighLight('student_id_<?php echo trim( $students[$i]['student_id'] ); ?>');" 
                                         onmouseout="removePanelHighlight('student_id_<?php echo trim( $students[$i]['student_id'] ); ?>');"
                                         data-toggle="modal" data-target="#studentDetailModal" data-backdrop="static"> <!-- min-height:100%; -->
                                        <div class="panel-heading info-head">
                                            <p style="text-align:center;"><strong id="student_name_<?php echo trim( $students[$i]['student_id'] ); ?>">
                                                <?php echo trim( $students[$i]['student_name'] ); ?>
                                                </strong></p>
                                        </div>
                                        <div id="studentContainer_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                             class="panel-body" style="width:100%;">
                                            <div class="studentImageDiv" style="width:100%;">
                                                <img id="studentImage_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                            </div>
                                            <div>
                                                <table class="table table-responsive borderless" 
                                                           id="studentDetailsTbl_<?php echo trim( $students[$i]['student_id'] ); ?>">
                                                        <colgroup>
                                                            <col style="width:100px;">
                                                            <col>
                                                        </colgroup>
                                                        <tr>
                                                            <td><p><strong>Roll No.</strong></p></td>
                                                            <td><p><?php echo trim( $students[$i]['student_roll_no'] ); ?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><p><strong>Father</strong></p></td>
                                                            <td>
                                                                <p><?php echo trim( $students[$i]['father_name'] ); ?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><p><strong>Mother</strong></p></td>
                                                            <td>
                                                                <p><?php echo trim( $students[$i]['mother_name'] ); ?></p>
                                                                <input type="hidden" id="student_pic_url_<?php echo trim($students[$i]['student_id']); ?>"
                                                                        value="<?php if( trim($students[$i]['pic_url']) != "" ){
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . trim($students[$i]['pic_url']); 

                                                                                       } else { 
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                                       }
                                                                               ?>">
                                                                <input type="hidden" id="student_father_pic_url_<?php echo trim($students[$i]['student_id']); ?>"
                                                                        value="<?php if( trim($students[$i]['father_pic_url']) != "" ){
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . trim($students[$i]['father_pic_url']); 

                                                                                       } else { 
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                                       }
                                                                               ?>">
                                                                <input type="hidden" id="student_mother_pic_url_<?php echo trim($students[$i]['student_id']); ?>"
                                                                        value="<?php if( trim($students[$i]['mother_pic_url']) != "" ){
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . trim($students[$i]['mother_pic_url']); 

                                                                                       } else { 
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                                       }
                                                                               ?>">
                                                            </td>
                                                        </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php }
                                    $i++;
                                    if( $i < $student_count ){ ?>
                                <div class="col-sm-4"><!--style="padding-left:10px;padding-right:0px;" style="padding:25px;" -->
                                    <div class="panel panel-default panel-custom" style="height:100%;width:100%;"
                                         id="teacher_id_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                         onmouseover="addPanelHighLight('student_id_<?php echo trim( $students[$i]['student_id'] ); ?>');" 
                                         onmouseout="removePanelHighlight('student_id_<?php echo trim( $students[$i]['student_id'] ); ?>');"
                                         data-toggle="modal" data-target="#studentDetailModal" data-backdrop="static"> <!-- min-height:100%; -->
                                        <div class="panel-heading info-head">
                                            <p style="text-align:center;"><strong id="student_name_<?php echo trim( $students[$i]['student_id'] ); ?>">
                                                <?php echo trim( $students[$i]['student_name'] ); ?>
                                                </strong></p>
                                        </div>
                                        <div id="studentContainer_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                             class="panel-body" style="width:100%;">
                                            <div class="studentImageDiv" style="width:100%;">
                                                <img id="studentImage_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                            </div>
                                            <div>
                                                <table class="table table-responsive borderless" 
                                                           id="studentDetailsTbl_<?php echo trim( $students[$i]['student_id'] ); ?>">
                                                        <colgroup>
                                                            <col style="width:100px;">
                                                            <col>
                                                        </colgroup>
                                                        <tr>
                                                            <td><p><strong>Roll No.</strong></p></td>
                                                            <td><p><?php echo trim( $students[$i]['student_roll_no'] ); ?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><p><strong>Father</strong></p></td>
                                                            <td>
                                                                <p><?php echo trim( $students[$i]['father_name'] ); ?></p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><p><strong>Mother</strong></p></td>
                                                            <td>
                                                                <p><?php echo trim( $students[$i]['mother_name'] ); ?></p>
                                                                <input type="hidden" id="student_pic_url_<?php echo trim($students[$i]['student_id']); ?>"
                                                                        value="<?php if( trim($students[$i]['pic_url']) != "" ){
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . trim($students[$i]['pic_url']); 

                                                                                       } else { 
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                                       }
                                                                               ?>">
                                                                <input type="hidden" id="student_father_pic_url_<?php echo trim($students[$i]['student_id']); ?>"
                                                                        value="<?php if( trim($students[$i]['pic_url']) != "" ){
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . trim($students[$i]['father_pic_url']); 

                                                                                       } else { 
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                                       }
                                                                               ?>">
                                                                <input type="hidden" id="student_mother_pic_url_<?php echo trim($students[$i]['student_id']); ?>"
                                                                        value="<?php if( trim($students[$i]['pic_url']) != "" ){
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . trim($students[$i]['mother_pic_url']); 

                                                                                       } else { 
                                                                                            echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                                            '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                                       }
                                                                               ?>">
                                                            </td>
                                                        </tr>
                                                </table>
                                            </div>
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
            <div id="studentDetailModal" class="modal fade" role="dialog" style="height:100%;">
                <div class="modal-dialog modal-lg lg-modal-custom"> 
                   <div class="modal-content">
                       <div class="modal-header light_background">
                           <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                           <h4 class="modal-title" style="text-align:center;"><strong id="studentDetailTitle"></strong></h4>
                           <input type="hidden" id="studentAndParentDetails" value="">
                           <input type="hidden" id="selectedStudentId" value="">
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
        <script type="text/javascript" src="/public/js/user_details.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>