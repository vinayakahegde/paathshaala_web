<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="teacherOnLoad();">
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
                //$periodArray = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII" );
                $periodArray = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12" );
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
                            <div class="col-sm-4" > <!-- padding-right:10%; style=" border-right: 1px solid #333;" -->
                                <div class="panel">
                                    <div class="panel-body" style="padding-top:0;">
                                        <div class="teacherLeftContent" >
                                            <div id="teacherSearchDiv">
                                                <!-- <div class="row">
                                                    <div class="col-sm-6">
                                                        <p style="text-align : left;">
                                                            <span class="glyphicon glyphicon-search"></span>&nbsp;
                                                            <strong>SEARCH TEACHER</strong>
                                                        </p><br>
                                                    </div>
                                                    <div class="col-sm-6" style="text-align:right;">
                                                        <!-- <span class="glyphicon glyphicon-plus"></span> 
                                                        <strong>&nbsp;<a href="#" data-toggle="modal" data-target="#addTeacherModal">ADD TEACHER</a></strong> --
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-default" style="width:100%;padding:10px;" 
                                                                    id="btnAddTeacher" name="btnAddTeacher" data-toggle="modal" data-target="#addTeacherModal" >
                                                                <span class="glyphicon glyphicon-plus"></span> <strong>&nbsp;&nbsp;&nbsp;ADD TEACHER</strong>
                                                            </button>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <?php if( $user_type == _USER_TYPE_SCHOOL ){ ?>
                                                <div class="row" style="margin-bottom:10px;">
                                                    <button type="button" class="btn btn-default" style="width:100%;padding:10px;" 
                                                            id="btnAddTeacher" name="btnAddTeacher" data-toggle="modal" data-target="#addTeacherModal" >
                                                        <span class="glyphicon glyphicon-plus"></span> <strong>&nbsp;&nbsp;&nbsp;ADD TEACHER</strong>
                                                    </button>
                                                </div>
                                                <?php } ?>
                                                <div class="row">
                                                <div class="panel panel-default" id="teacherNameSearchDiv" style="margin:0;border-radius:0 !important;">
                                                    <div class="panel panel-heading light_background" style="margin:0;border-radius:0 !important;">
                                                        <p style="text-align:center;margin:0;"><strong>NAME SEARCH</strong></p>
                                                    </div>
                                                    <div class="panel-body">
                                                    <form id="teacherNameSearchForm" name="teacherNameSearchForm" action="/teachers" method="post">
                                                    <div class="form-group">
                                                        <input type="hidden" id="teacherCompleteList" name="teacherCompleteList" value='<?php echo $teachersComplete; ?>'>
                                                        <!-- <label for="teacherNameSearch">Name</label> -->
                                                            <span style="color:lightcoral;">&nbsp;&nbsp;( * Enter part or whole name )</span>
                                                            <div class="dropdown">
                                                                <input type="text" id="teacherNameSearch" class="form-control" autocomplete="off"
                                                                       name="teacherNameSearch" onkeyup="showMatchingNames();"
                                                                       value="<?php if(isset($teacherNameEntered)) echo $teacherNameEntered; ?>">
                                                                <input type="hidden" id="teacher_dropdown_1" value="">
                                                                <input type="hidden" id="teacher_dropdown_2" value="">
                                                                <input type="hidden" id="teacher_dropdown_3" value="">
                                                                <input type="hidden" id="teacher_dropdown_4" value="">
                                                                <ul class="dropdown-menu" id="dropDownTeacherList" onmouseover="displayDropDownTeacherList();"
                                                                    style="width:100%;display:none;" onmouseout="hideDropDownTeacherList();"><!-- aria-labelledby="dropdownMenu1" -->
                                                                  <li><a href="#" id="dropdown_opt1" onclick="populateSearchName(1);">Action</a></li>
                                                                  <li><a href="#" id="dropdown_opt2" onclick="populateSearchName(2);">Another action</a></li>
                                                                  <li><a href="#" id="dropdown_opt3" onclick="populateSearchName(3);">Something else here</a></li>
                                                                  <li><a href="#" id="dropdown_opt4" onclick="populateSearchName(4);">Something else here</a></li>
                                                                </ul>
                                                            </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <br>
                                                        <input type="submit" id="teacherNameSearchSubmit" class="form-control btn btn-primary" 
                                                               name="teacherNameSearchSubmit" value="SEARCH">
                                                    </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="panel panel-default" id="teacherDetailSearchDiv" style="margin:0;border-radius:0 !important">
                                                    <div class="panel panel-heading light_background" style="margin:0;border-radius:0 !important;">
                                                        <p style="text-align:center;margin:0;"><strong>DETAIL SEARCH</strong></p>
                                                    </div>
                                                    <div class="panel-body">
                                                        <form id="teacherSearchForm" name="teacherSearchForm" action="/teachers" method="post">
                                                            <div class="form-group">
                                                                <label for="teacherClassSearch">Class</label>
                                                                <select class="form-control" id="teacherClassSearch" 
                                                                        name="teacherClassSearch" onchange="populateSections();"> <!--   -->
                                                                        <option value="">Select</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_PLAY_HOME ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_PLAY_HOME) echo "selected"; ?>>Play Home</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_PRE_KG ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_PRE_KG) echo "selected"; ?>>Pre-KG</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_LKG ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_LKG) echo "selected"; ?>>LKG</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_UKG ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_UKG) echo "selected"; ?>>UKG</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_1 ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_CLASS_1) echo "selected"; ?>>Class I</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_2 ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_CLASS_2) echo "selected"; ?>>Class II</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_3 ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_CLASS_3) echo "selected"; ?>>Class III</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_4 ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_CLASS_4) echo "selected"; ?>>Class IV</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_5 ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_CLASS_5) echo "selected"; ?>>Class V</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_6 ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_CLASS_6) echo "selected"; ?>>Class VI</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_7 ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_CLASS_7) echo "selected"; ?>>Class VII</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_8 ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_CLASS_8) echo "selected"; ?>>Class VIII</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_9 ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_CLASS_9) echo "selected"; ?>>Class IX</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_10 ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_CLASS_10) echo "selected"; ?>>Class X</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_11 ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_CLASS_11) echo "selected"; ?>>Class XI</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_12 ?>" 
                                                                            <?php if(isset($teacherSearchByClass) && $teacherSearchByClass == _ADMISSION_APPLY_CLASS_12) echo "selected"; ?>>Class XII</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" id="classArray" name="classArray"
                                                                       value='<?php if( isset($classes) ) echo $classes; ?>'>
                                                                <input type="hidden" id="selectedSection" name="selectedSection" 
                                                                       value="<?php if(isset($selectedSection) ) echo $selectedSection; ?>">
                                                                <label for="teacherSectionSearch">Section</label>
                                                                <select class="form-control" id="teacherSectionSearch" name="teacherSectionSearch">
                                                                    <option value="">Select</option>
                                                                    <?php for( $i=0; isset($sectionArray) && $i < count($sectionArray); $i++ ){ ?>
                                                                        <option value="<?php echo $sectionArray[$i]; ?>" 
                                                                                <?php if( $sectionArray[$i] == $selectedSection ) echo "selected"; ?>>
                                                                                    <?php echo $sectionArray[$i]; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="teacherSubjectSearch">Subject</label>
                                                                <select class="form-control" id="teacherSubjectSearch" name="teacherSubjectSearch">
                                                                    <option value="">Select</option>
                                                                    <?php foreach( $subjectList as $subject_id => $subject) { //$i=0; $i < count( $subjectList ); $i++ ?>
                                                                        <option value="<?php echo $subject_id; ?>" 
                                                                            <?php if( isset($selectedSubject) && $selectedSubject != "" && $selectedSubject == $subject_id ) echo "selected"; ?> >
                                                                            <?php echo $subject; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <input type="submit" id="teacherSearch" class="form-control btn btn-primary" 
                                                                       name="teacherSearch" value="SEARCH">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-sm-8">
                                <!--<div class="row" id="teacherAddDiv">
                                    <div class="col-sm-offset-9">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-default" style="width:100%;padding:10px;" 
                                                    id="btnAddTeacher" name="btnAddTeacher" data-toggle="modal" data-target="#addTeacherModal" >
                                                <span class="glyphicon glyphicon-plus"></span> <strong>&nbsp;&nbsp;&nbsp;ADD TEACHER</strong>
                                            </button>
                                            <br>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="teacherResultDiv">
                                    <h4 id="teacherSearchCriteria" style="text-align: center;">
                                        <strong><i>Search Criteria:&nbsp;</i></strong> &nbsp;
                                            <?php if( isset($searchCriteria) ){ echo $searchCriteria; } else { echo "None"; } ?>
                                        
                                    </h4>
                                    <?php $teacher_count = count($teachers);
                                        for( $i=0; $i < $teacher_count; $i++ ){ ?>
                                    <div class="row">
                                        <div class="col-sm-6"><!--style="padding-left:10px;padding-right:0px;" style="padding:25px;" -->
                                            <div class="panel panel-default panel-custom" style="height:100%;width:100%;"
                                                 id="teacher_id_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>" 
                                                 onmouseover="addPanelHighLight('teacher_id_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>');" 
                                                 onmouseout="removePanelHighlight('teacher_id_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>');"
                                                 data-toggle="modal" data-target="#teacherModal" data-backdrop="static"> <!-- min-height:100%; -->
                                                <div class="panel-heading info-head">
                                                    <p style="text-align:center;"><strong>
                                                        <?php echo trim( $teachers[$i]['firstname'] ) . " " . trim( $teachers[$i]['lastname'] ); ?>
                                                        </strong></p>
                                                </div>
                                                <div id="teacherContainer_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>" 
                                                     class="panel-body" style="width:100%;">
                                                    <div class="facultyGeneralImageDiv" style="width:100%;">
                                                        <img id="teacherImage_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>" 
                                                                 class="img-rounded img-responsive" 
                                                                 style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                                    </div>
                                                    <div>
                                                        <table class="table table-responsive borderless" 
                                                                   id="teacherDetailsTbl_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>">
                                                                <colgroup>
                                                                    <col style="width:100px;">
                                                                    <col>
                                                                </colgroup>
                                                                <tr>
                                                                    <td><p><strong>Experience</strong></p></td>
                                                                    <td><p><?php echo trim( $teachers[$i]['experience'] ); ?></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p><strong>Qualification</strong></p></td>
                                                                    <td>
                                                                        <p><?php echo trim( $teachers[$i]['qualification'] ); ?></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p><strong>Subjects</strong></p></td>
                                                                    <td>
                                                                        <p>
                                                                            <?php $subjects = "";
                                                                            for( $k=1; $k <= 5 && $k < trim( $teachers[$i]['num_of_subjects'] ); $k++ ){
                                                                                        $subjects .= $subjectList[ trim( $teachers[$i]["subject_id_$k"] ) ] . ", ";
                                                                            }
                                                                            $subjects = substr( $subjects, 0, strlen($subjects) - 2 );
                                                                            echo $subjects;
                                                                            ?>
                                                                        </p>
                                                                        <input type="hidden" id="teacher_firstname_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['firstname'] ); ?>">
                                                                        <input type="hidden" id="teacher_middlename_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['middlename'] ); ?>">
                                                                        <input type="hidden" id="teacher_lastname_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['lastname'] ); ?>">
                                                                        <input type="hidden" id="teacher_address_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['address'] ); ?>">
                                                                        <input type="hidden" id="teacher_pincode_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['pincode'] ); ?>">
                                                                        <input type="hidden" id="teacher_phone_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['phone'] ); ?>">
                                                                        <input type="hidden" id="teacher_twitter_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['twitter'] ); ?>">
                                                                        <input type="hidden" id="teacher_blog_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['blog'] ); ?>">
                                                                        <input type="hidden" id="teacher_email_id_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['email_id'] ); ?>">
                                                                        <input type="hidden" id="teacher_date_of_birth_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['date_of_birth'] ); ?>">
                                                                        <input type="hidden" id="teacher_qualification_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['qualification'] ); ?>">
                                                                        <input type="hidden" id="teacher_experience_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['experience'] ); ?>">
                                                                        <input type="hidden" id="teacher_subjects_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $subjects ); ?>">
                                                                        <!-- <input type="hidden" id="teacher_pic_url_<?php echo trim($teachers[$i]['teacher_id']); ?>"
                                                                                value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_FACULTY_GENERAL_NUM 
                                                                                        . "/" . trim($teachers[$i]['pic_url']); ?>"> -->
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
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $i++;
                                            if( $i < $teacher_count ){ ?>
                                        <div class="col-sm-6"><!--style="padding-left:10px;padding-right:0px;" style="padding:25px;" -->
                                            <div class="panel panel-default panel-custom" style="height:100%;width:100%;"
                                                 id="teacher_id_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>" 
                                                 onmouseover="addPanelHighLight('teacher_id_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>');" 
                                                 onmouseout="removePanelHighlight('teacher_id_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>');"
                                                 data-toggle="modal" data-target="#teacherModal"> <!-- min-height:100%; -->
                                                <div class="panel-heading info-head">
                                                    <p style="text-align:center;"><strong>
                                                        <?php echo trim( $teachers[$i]['firstname'] ) . " " . trim( $teachers[$i]['lastname'] ); ?>
                                                        </strong></p>
                                                </div>
                                                <div id="teacherContainer_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>" 
                                                     class="panel-body" style="width:100%;">
                                                    <div class="facultyGeneralImageDiv" style="width:100%;">
                                                        <img id="teacherImage_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>" 
                                                                 class="img-rounded img-responsive" 
                                                                 style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                                    </div>
                                                    <div>
                                                        <table class="table table-responsive borderless" 
                                                                   id="teacherDetailsTbl_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>">
                                                                <colgroup>
                                                                    <col style="width:100px;">
                                                                    <col>
                                                                </colgroup>
                                                                <tr>
                                                                    <td><p><strong>Experience</strong></p></td>
                                                                    <td><p><?php echo trim( $teachers[$i]['experience'] ); ?></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p><strong>Qualification</strong></p></td>
                                                                    <td>
                                                                        <p><?php echo trim( $teachers[$i]['qualification'] ); ?></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p><strong>Subjects</strong></p></td>
                                                                    <td>
                                                                        <p>
                                                                            <?php $subjects = "";
                                                                            for( $k=1; $k <= 5 && $k < trim( $teachers[$i]['num_of_subjects'] ); $k++ ){
                                                                                        $subjects .= $subjectList[ trim( $teachers[$i]["subject_id_$k"] ) ] . ", ";
                                                                            }
                                                                            $subjects = substr( $subjects, 0, strlen($subjects) - 2 );
                                                                            echo $subjects;
                                                                            ?>
                                                                        </p>
                                                                        <input type="hidden" id="teacher_firstname_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['firstname'] ); ?>">
                                                                        <input type="hidden" id="teacher_middlename_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['middlename'] ); ?>">
                                                                        <input type="hidden" id="teacher_lastname_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['lastname'] ); ?>">
                                                                        <input type="hidden" id="teacher_address_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['address'] ); ?>">
                                                                        <input type="hidden" id="teacher_pincode_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['pincode'] ); ?>">
                                                                        <input type="hidden" id="teacher_phone_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['phone'] ); ?>">
                                                                        <input type="hidden" id="teacher_twitter_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['twitter'] ); ?>">
                                                                        <input type="hidden" id="teacher_blog_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['blog'] ); ?>">
                                                                        <input type="hidden" id="teacher_email_id_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['email_id'] ); ?>">
                                                                        <input type="hidden" id="teacher_date_of_birth_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['date_of_birth'] ); ?>">
                                                                        <input type="hidden" id="teacher_qualification_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['qualification'] ); ?>">
                                                                        <input type="hidden" id="teacher_experience_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $teachers[$i]['experience'] ); ?>">
                                                                        <input type="hidden" id="teacher_subjects_<?php echo trim( $teachers[$i]['teacher_id'] ); ?>"
                                                                               value="<?php echo trim( $subjects ); ?>">
                                                                        <!-- <input type="hidden" id="teacher_pic_url_<?php echo trim($teachers[$i]['teacher_id']); ?>"
                                                                                value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_FACULTY_GENERAL_NUM 
                                                                                        . "/" . trim($teachers[$i]['pic_url']); ?>"> -->
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
                </div>
            </div>
            <div id="addTeacherModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog"> <!--  modal-lg -->
                        <div class="modal-content">
                            <div class="modal-header light_background">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="addTeacherTitle" style="text-align:center;"><strong>ADD TEACHER</strong></h4>
                            </div>
                            <div class="modal-body" id="addTeacherContent">
                                <form id="addTeacherForm" name="addTeacherForm" onsubmit="return validateAddTeacherForm();"
                                      action="/addTeacher" method="post">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addTeacherFirstNameDiv">
                                                <label for="addTeacherFirstName">First Name<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addTeacherFirstName" class="form-control" 
                                                       name="addTeacherFirstName" value="">
                                                <p id="addTeacherFirstNameMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addTeacherMiddleNameDiv">
                                                <label for="addTeacherMiddleName">Middle Name</label>
                                                <input type="text" id="addTeacherMiddleName" class="form-control" 
                                                       name="addTeacherMiddleName" value="">
                                                <p id="addTeacherMiddleNameMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addTeacherLastNameDiv">
                                                <label for="addTeacherLastName">Last Name<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addTeacherLastName" class="form-control" 
                                                       name="addTeacherLastName" value="">
                                                <p id="addTeacherLastNameMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addTeacherAddressDiv">
                                                <label for="addTeacherAddress">Address</label>
                                                <textarea id="addTeacherAddress" class="form-control" 
                                                          name="addTeacherAddress" value=""></textarea>
                                                <p id="addTeacherAddressMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addTeacherPincodeDiv">
                                                <label for="addTeacherPincode">PIN code</label>
                                                <input type="text" id="addTeacherPincode" class="form-control" 
                                                       name="addTeacherPincode" value="">
                                                <p id="addTeacherPincodeMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addTeacherPhoneDiv">
                                                <label for="addTeacherPhone">Phone<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addTeacherPhone" class="form-control" 
                                                       name="addTeacherPhone" value="">
                                                <p id="addTeacherPhoneMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addTeacherEmailDiv">
                                                <label for="addTeacherEmail">Email</label>
                                                <input type="text" id="addTeacherEmail" class="form-control" 
                                                       name="addTeacherEmail" value="">
                                                <p id="addTeacherEmailMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addTeacherTwitterDiv">
                                                <label for="addTeacherTwitter">Twitter</label>
                                                <input type="text" id="addTeacherTwitter" class="form-control" 
                                                       name="addTeacherTwitter" value="">
                                                <p id="addTeacherTwitterMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addTeacherBlogDiv">
                                                <label for="addTeacherBlog">Blog</label>
                                                <input type="text" id="addTeacherBlog" class="form-control" 
                                                       name="addTeacherBlog" value="">
                                                <p id="addTeacherBlogMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addTeacherDateOfBirthDiv">
                                                <label for="addTeacherDateOfBirth">Date Of Birth</label>
                                                <input class="form-control" type="text" name="addTeacherDateOfBirth" id="addTeacherDateOfBirth" value="" 
                                                       onclick="javascript:NewCssCal('addTeacherDateOfBirth','yyyyMMdd','arrow',false,'12',false,'');">
                                                <p id="addTeacherDateOfBirthMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addTeacherDateOfJoiningDiv">
                                                <label for="addTeacherDateOfJoining">Date Of Joining<span style="color:red;">&nbsp;*</span></label>
                                                <input class="form-control" type="text" name="addTeacherDateOfJoining" id="addTeacherDateOfJoining" value="" 
                                                       onclick="javascript:NewCssCal('addTeacherDateOfJoining','yyyyMMdd','arrow',false,'12',false,'');">
                                                <p id="addTeacherDateOfJoiningMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addTeacherExperienceDiv">
                                                <label for="addTeacherExperience">Experience<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addTeacherExperience" class="form-control" 
                                                       name="addTeacherExperience" value="">
                                                <p id="addTeacherExperienceMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addTeacherQualificationDiv">
                                                <label for="addTeacherQualification">Qualification<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addTeacherQualification" class="form-control" 
                                                       name="addTeacherQualification" value="">
                                                <p id="addTeacherQualificationMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addTeacherSubjectDiv">
                                                <label for="addTeacherSubject">Subject</label>
                                                <select id="addTeacherSubject" name="addTeacherSubject" class="form-control" >
                                                    <option value="">Select</option>
                                                    <?php 
                                                    if( count( $subjectList ) > 0 ){
                                                        foreach( $subjectList as $subjectIdx => $subject ){ ?>
                                                            <option value="<?php echo $subjectIdx; ?>">
                                                                <?php echo $subject; ?>
                                                            </option>
                                                        <?php }
                                                    } ?>
                                                </select>
                                                <p id="addTeacherSubjectMsg" class="inputAlert"></p>
                                                <!-- <input type="text" id="addTeacherSubject" class="form-control" 
                                                       name="addTeacherSubject" value=""> -->
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <br>
                                                <button type="button" class="btn btn-default" onclick="addSubject();">
                                                    <span class="glyphicon glyphicon-plus"></span> 
                                                    <strong>&nbsp;ADD</strong>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input type="hidden" id="addedSubjects" name="addedSubjects" value="">
                                        <div class="col-sm-12" id="addedSubjectsDiv">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-offset-3 col-sm-6">
                                            <br>
                                            <input type="submit" id="addTeacherSubmit" name="addTeacherSubmit" 
                                                   class="btn btn-primary" style="width:100%;" value="SUBMIT">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                 </div>
                 <div id="teacherModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg"> <!--  modal-lg -->
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:none;">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" style="text-align:center;"><strong id="teacherNameHeading">Shruti Hassan</strong></h4>
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
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_firstname">Shruti</p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Last Name</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_lastname">Hassan</p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Birthday</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_birthday">21-June-1966</p></td>
                                                </tr>
                                            </table>
                                            <h4 style="text-align:center;text-decoration: underline;">Professional Details</h4>
                                            <table id="teacherProfDetailTable" class="table table-bordered table-responsive">
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Qualification</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_qualification">B.Sc</p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Experience</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_experience">7 years</p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Date Of Joining</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_doj">21-June-2009</p></td>
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
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_phone">9873488348</p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Email</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_email">shr@gmail.com</p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Twitter</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_twitter">@shruti</p></td>
                                                </tr>
                                                <tr>
                                                    <td class="profile_desc"><p class="custom-p">Blog</p></td>
                                                    <td class="profile_detail"><p class="custom-p" id="teacher_blog">shr.wordpress.com</p></td>
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
                                                        <td style="text-align: center;"><p class="custom-p" id="hobby_1">Phone</p></td>
                                                        <td style="text-align: center;"><p class="custom-p" id="achievement_1">Phone</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;"><p class="custom-p" id="hobby_2">Phone</p></td>
                                                        <td style="text-align: center;"><p class="custom-p" id="achievement_2">Phone</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;"><p class="custom-p" id="hobby_3">Phone</p></td>
                                                        <td style="text-align: center;"><p class="custom-p" id="achievement_3">Phone</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;"><p class="custom-p" id="hobby_4">Phone</p></td>
                                                        <td style="text-align: center;"><p class="custom-p" id="achievement_4">Phone</p></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;"><p class="custom-p" id="hobby_5">Phone</p></td>
                                                        <td style="text-align: center;"><p class="custom-p" id="achievement_5">Phone</p></td>
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
        <script type="text/javascript" src="/public/js/school.js"></script>
        <script type="text/javascript" src="/public/js/user_details.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>