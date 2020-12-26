<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="studentOnLoad();">
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
                            <div class="col-sm-4" > <!-- padding-right:10%; style=" border-right: 1px solid #333;" -->
                                <div class="panel">
                                    <div class="panel-body" style="padding-top:0;">
                                        <div class="studentLeftContent" >
                                            <div id="studentSearchDiv">
                                                <?php if( $user_type == _USER_TYPE_SCHOOL ){ ?>
                                                <div class="row" style="margin-bottom:10px;">
                                                    <button type="button" class="btn btn-default" style="width:100%;padding:10px;" 
                                                            id="btnAddStudent" name="btnAddStudent" data-toggle="modal" data-target="#addStudentModal" 
                                                            data-backdrop="static" data-keyboard="true">
                                                        <span class="glyphicon glyphicon-plus"></span> <strong>&nbsp;&nbsp;&nbsp;ADD STUDENT</strong>
                                                    </button>
                                                </div>
                                                <?php } ?>
                                                <div class="row">
                                                <div class="panel panel-default" id="studentNameSearchDiv" style="margin:0;border-radius:0 !important;">
                                                    <div class="panel panel-heading light_background" style="margin:0;border-radius:0 !important;">
                                                        <p style="text-align:center;margin:0;"><strong>NAME SEARCH</strong></p>
                                                    </div>
                                                    <div class="panel-body">
                                                    <form id="studentNameSearchForm" name="studentNameSearchForm" action="/students" method="post">
                                                    <div class="form-group">
                                                            <label for="studentNameSearch">Name</label>
                                                            <span style="color:lightcoral;">&nbsp;&nbsp;( * Enter part or whole name )</span>
                                                            <div class="dropdown">
                                                                <input type="text" id="studentNameSearch" class="form-control" autocomplete="off"
                                                                       name="studentNameSearch" onkeyup="showMatchingStudentNames();"
                                                                       value="<?php if(isset($studentNameEntered)) echo $studentNameEntered; ?>">
                                                                <input type="hidden" id="student_dropdown_1" value="">
                                                                <input type="hidden" id="student_dropdown_2" value="">
                                                                <input type="hidden" id="student_dropdown_3" value="">
                                                                <input type="hidden" id="student_dropdown_4" value="">
                                                                <ul class="dropdown-menu" id="dropDownStudentList" onmouseover="displayDropDownStudentList();"
                                                                    style="width:100%;display:none;" onmouseout="hideDropDownStudentList();"><!-- aria-labelledby="dropdownMenu1" -->
                                                                  <li><a href="#" id="dropdown_opt1" onclick="populateStudentSearchName(1);">Action</a></li>
                                                                  <li><a href="#" id="dropdown_opt2" onclick="populateStudentSearchName(2);">Another action</a></li>
                                                                  <li><a href="#" id="dropdown_opt3" onclick="populateStudentSearchName(3);">Something else here</a></li>
                                                                  <li><a href="#" id="dropdown_opt4" onclick="populateStudentSearchName(4);">Something else here</a></li>
                                                                </ul>
                                                            </div>
                                                    </div>
                                                    <div class="form-group">
                                                            <label for="studentParentNameSearch">Parent Name</label>
                                                            <span style="color:lightcoral;">&nbsp;&nbsp;( * Enter part or whole name )</span>
                                                            <div class="dropdown">
                                                                <input type="text" id="studentParentNameSearch" class="form-control" autocomplete="off"
                                                                       name="studentParentNameSearch" onkeyup="showMatchingParentNames();"
                                                                       value="<?php if(isset($studentParentNameEntered)) echo $studentParentNameEntered; ?>">
                                                                <input type="hidden" id="student_parent_dropdown_1" value="">
                                                                <input type="hidden" id="student_parent_dropdown_2" value="">
                                                                <input type="hidden" id="student_parent_dropdown_3" value="">
                                                                <input type="hidden" id="student_parent_dropdown_4" value="">
                                                                <ul class="dropdown-menu" id="dropDownStudentParentList" onmouseover="displayDropDownParentList();"
                                                                    style="width:100%;display:none;" onmouseout="hideDropDownParentList();"><!-- aria-labelledby="dropdownMenu1" -->
                                                                  <li><a href="#" id="dropdown_p_opt1" onclick="populateParentSearchName(1);">Action</a></li>
                                                                  <li><a href="#" id="dropdown_p_opt2" onclick="populateParentSearchName(2);">Another action</a></li>
                                                                  <li><a href="#" id="dropdown_p_opt3" onclick="populateParentSearchName(3);">Something else here</a></li>
                                                                  <li><a href="#" id="dropdown_p_opt4" onclick="populateParentSearchName(4);">Something else here</a></li>
                                                                </ul>
                                                            </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <br>
                                                        <input type="submit" id="studentNameSearchSubmit" class="form-control btn btn-primary" 
                                                               name="studentNameSearchSubmit" value="SEARCH">
                                                    </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="panel panel-default" id="studentDetailSearchDiv" style="margin:0;border-radius:0 !important">
                                                    <div class="panel panel-heading light_background" style="margin:0;border-radius:0 !important;">
                                                        <p style="text-align:center;margin:0;"><strong>DETAIL SEARCH</strong></p>
                                                    </div>
                                                    <div class="panel-body">
                                                        <form id="studentSearchForm" name="studentSearchForm" action="/students" method="post">
                                                            <div class="form-group">
                                                                <label for="studentClassSearch">Class</label>
                                                                <select class="form-control" id="studentClassSearch" 
                                                                        name="studentClassSearch" onchange="populateStudentSections();"> <!--   -->
                                                                        <option value="">Select</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_PLAY_HOME ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_PLAY_HOME) echo "selected"; ?>>Play Home</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_PRE_KG ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_PRE_KG) echo "selected"; ?>>Pre-KG</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_LKG ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_LKG) echo "selected"; ?>>LKG</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_UKG ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_UKG) echo "selected"; ?>>UKG</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_1 ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_CLASS_1) echo "selected"; ?>>Class I</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_2 ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_CLASS_2) echo "selected"; ?>>Class II</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_3 ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_CLASS_3) echo "selected"; ?>>Class III</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_4 ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_CLASS_4) echo "selected"; ?>>Class IV</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_5 ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_CLASS_5) echo "selected"; ?>>Class V</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_6 ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_CLASS_6) echo "selected"; ?>>Class VI</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_7 ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_CLASS_7) echo "selected"; ?>>Class VII</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_8 ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_CLASS_8) echo "selected"; ?>>Class VIII</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_9 ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_CLASS_9) echo "selected"; ?>>Class IX</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_10 ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_CLASS_10) echo "selected"; ?>>Class X</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_11 ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_CLASS_11) echo "selected"; ?>>Class XI</option>
                                                                        <option value="<?php echo _ADMISSION_APPLY_CLASS_12 ?>" 
                                                                            <?php if(isset($studentSearchByClass) && $studentSearchByClass == _ADMISSION_APPLY_CLASS_12) echo "selected"; ?>>Class XII</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" id="classArray" name="classArray"
                                                                       value='<?php if( isset($classes) ) echo $classes; ?>'>
                                                                <input type="hidden" id="selectedSection" name="selectedSection" 
                                                                       value="<?php if(isset($selectedSection) ) echo $selectedSection; ?>">
                                                                <label for="studentSectionSearch">Section</label>
                                                                <select class="form-control" id="studentSectionSearch" name="studentSectionSearch">
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
                                                                <label for="studentRollNoEntered">Roll Number</label>
                                                                <input type="text" id="studentRollNoEntered" name="studentRollNoEntered" class="form-control" 
                                                                       value="<?php if(isset($studentRollNoEntered)) echo $studentRollNoEntered; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <input type="submit" id="studentSearch" class="form-control btn btn-primary" 
                                                                       name="studentSearch" value="SEARCH">
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
                                <div class="studentResultDiv">
                                    <h4 id="studentSearchCriteria" style="text-align: center;">
                                        <strong><i>Search Criteria:&nbsp;</i></strong> &nbsp;
                                            <?php if( isset($searchCriteria) ){ echo $searchCriteria; } else { echo "None"; } ?>
                                        
                                    </h4>
                                    <?php $student_count = count($students);
                                        for( $i=0; $i < $student_count; $i++ ){ ?>
                                    <div class="row">
                                        <div class="col-sm-6"><!--style="padding-left:10px;padding-right:0px;" style="padding:25px;" -->
                                            <div class="panel panel-default panel-custom" style="height:100%;width:100%;"
                                                 id="student_id_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                 onmouseover="addPanelHighLight('student_id_<?php echo trim( $students[$i]['student_id'] ); ?>');" 
                                                 onmouseout="removePanelHighlight('student_id_<?php echo trim( $students[$i]['student_id'] ); ?>');"
                                                 data-toggle="modal" data-target="#studentDetailModal"> <!-- min-height:100%; -->
                                                <div class="panel-heading info-head">
                                                    <p style="text-align:center;"><strong id="student_name_<?php echo trim( $students[$i]['student_id'] ); ?>">
                                                        <?php echo trim( $students[$i]['firstname'] ) . " " . trim( $students[$i]['lastname'] ); ?>
                                                        </strong></p>
                                                </div>
                                                <div id="studentContainer_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                     class="panel-body" style="width:100%;">
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
                                                                                                        '/' . trim($students[$i]['pic_url']); 

                                                                   } else { 
                                                                        echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                        '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                   }
                                                           ?>">
                                                    <input type="hidden" id="student_mother_pic_url_<?php echo trim($students[$i]['student_id']); ?>"
                                                           value="<?php if( trim($students[$i]['mother_pic_url']) != "" ){
                                                                        echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                        '/' . trim($students[$i]['pic_url']); 

                                                                   } else { 
                                                                        echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                        '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                   }
                                                           ?>">
                                                    <div>
                                                        <table class="table table-responsive table-bordered" 
                                                                   id="studentDetailsTbl_<?php echo trim( $students[$i]['student_id'] ); ?>">
                                                                <colgroup>
                                                                    <col style="width:100px;">
                                                                    <col>
                                                                </colgroup>
                                                                <tr>
                                                                    <td><p><strong>Class</strong></p></td>
                                                                    <td><p><?php echo $classMap[trim($students[$i]['class'])]; ?></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <p><strong>Section</strong></p>
                                                                    </td>
                                                                    <td>
                                                                        <p><?php echo trim( $students[$i]['section'] ); ?></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p><strong>Roll No.</strong></p></td>
                                                                    <td>
                                                                        <p><?php echo trim( $students[$i]['student_roll_no'] ); ?></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p><strong>Father</strong></p></td>
                                                                    <td>
                                                                        <?php if( $user_type == _USER_TYPE_SCHOOL ){ ?>
                                                                        <button type="button" class="btn btn-sm btn-default" style="width:100%;padding:10px;" 
                                                                                id="studentFatherName_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                                                name="studentFatherName_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                                                onclick="addMessageRecipient();">
                                                                            <span class="glyphicon glyphicon-envelope"></span> 
                                                                            <strong><?php echo trim( $students[$i]['father_firstname'] ) . " " . trim( $students[$i]['father_lastname'] ); ?></strong>
                                                                        </button>
                                                                        <?php } else { 
                                                                            echo trim( $students[$i]['father_firstname'] ) . " " . trim( $students[$i]['father_lastname'] );
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p><strong>Mother</strong></p></td>
                                                                    <td>
                                                                        <?php if( $user_type == _USER_TYPE_SCHOOL ){ ?>
                                                                        <button type="button" class="btn btn-sm btn-default" style="width:100%;padding:10px;" 
                                                                                id="studentMotherName_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                                                name="studentMotherName_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                                                onclick="addMessageRecipient();">
                                                                            <span class="glyphicon glyphicon-envelope"></span> 
                                                                            <strong><?php echo trim( $students[$i]['mother_firstname'] ) . " " . trim( $students[$i]['mother_lastname'] ); ?></strong>
                                                                        </button>
                                                                        <?php } else { 
                                                                            echo trim( $students[$i]['mother_firstname'] ) . " " . trim( $students[$i]['mother_lastname'] );
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $i++;
                                            if( $i < $student_count ){ ?>
                                        <div class="col-sm-6"><!--style="padding-left:10px;padding-right:0px;" style="padding:25px;" -->
                                            <div class="panel panel-default panel-custom" style="height:100%;width:100%;"
                                                 id="student_id_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                 onmouseover="addPanelHighLight('student_id_<?php echo trim( $students[$i]['student_id'] ); ?>');" 
                                                 onmouseout="removePanelHighlight('student_id_<?php echo trim( $students[$i]['student_id'] ); ?>');"
                                                 data-toggle="modal" data-target="#studentDetailModal"> <!-- min-height:100%; -->
                                                <div class="panel-heading info-head">
                                                    <p style="text-align:center;"><strong id="student_name_<?php echo trim( $students[$i]['student_id'] ); ?>">
                                                        <?php echo trim( $students[$i]['firstname'] ) . " " . trim( $students[$i]['lastname'] ); ?>
                                                        </strong></p>
                                                </div>
                                                <div id="studentContainer_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                     class="panel-body" style="width:100%;">
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
                                                                                                        '/' . trim($students[$i]['pic_url']); 

                                                                   } else { 
                                                                        echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                        '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                   }
                                                           ?>">
                                                    <input type="hidden" id="student_mother_pic_url_<?php echo trim($students[$i]['student_id']); ?>"
                                                           value="<?php if( trim($students[$i]['mother_pic_url']) != "" ){
                                                                        echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                        '/' . trim($students[$i]['pic_url']); 

                                                                   } else { 
                                                                        echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                                        '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                                                   }
                                                           ?>">
                                                    <div>
                                                        <table class="table table-responsive table-bordered" 
                                                                   id="studentDetailsTbl_<?php echo trim( $students[$i]['student_id'] ); ?>">
                                                                <colgroup>
                                                                    <col style="width:100px;">
                                                                    <col>
                                                                </colgroup>
                                                                <tr>
                                                                    <td><p><strong>Class</strong></p></td>
                                                                    <td><p><?php echo $classMap[trim($students[$i]['class'])]; ?></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p><strong>Section</strong></p></td>
                                                                    <td>
                                                                        <p><?php echo trim( $students[$i]['section'] ); ?></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p><strong>Roll No.</strong></p></td>
                                                                    <td>
                                                                        <p><?php echo trim( $students[$i]['student_roll_no'] ); ?></p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p><strong>Father</strong></p></td>
                                                                    <td>
                                                                        <?php if( $user_type == _USER_TYPE_SCHOOL ){ ?>
                                                                        <button type="button" class="btn btn-sm btn-default" style="width:100%;padding:10px;" 
                                                                                id="studentFatherName_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                                                name="studentFatherName_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                                                onclick="addMessageRecipient();">
                                                                            <span class="glyphicon glyphicon-envelope"></span> 
                                                                            <strong><?php echo trim( $students[$i]['father_firstname'] ) . " " . trim( $students[$i]['father_lastname'] ); ?></strong>
                                                                        </button>
                                                                        <?php } else { 
                                                                            echo trim( $students[$i]['father_firstname'] ) . " " . trim( $students[$i]['father_lastname'] );
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><p><strong>Mother</strong></p></td>
                                                                    <td>
                                                                        <?php if( $user_type == _USER_TYPE_SCHOOL ){ ?>
                                                                        <button type="button" class="btn btn-sm btn-default" style="width:100%;padding:10px;" 
                                                                                id="studentMotherName_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                                                name="studentMotherName_<?php echo trim( $students[$i]['student_id'] ); ?>" 
                                                                                onclick="addMessageRecipient();">
                                                                            <span class="glyphicon glyphicon-envelope"></span> 
                                                                            <strong><?php echo trim( $students[$i]['mother_firstname'] ) . " " . trim( $students[$i]['mother_lastname'] ); ?></strong>
                                                                        </button>
                                                                        <?php } else { 
                                                                            echo trim( $students[$i]['mother_firstname'] ) . " " . trim( $students[$i]['mother_lastname'] );
                                                                        } ?>
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
            <div id="addStudentModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog"> <!--  modal-lg -->
                        <div class="modal-content">
                            <div class="modal-header light_background">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="addStudentTitle" style="text-align:center;"><strong>ADD STUDENT</strong></h4>
                            </div>
                            <div class="modal-body" id="addStudentContent">
                                <form id="addStudentForm" name="addStudentForm" onsubmit="return validateAddStudentForm();"
                                      action="/addStudent" method="post">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addStudentFirstNameDiv">
                                                <label for="addStudentFirstName">First Name<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addStudentFirstName" class="form-control" 
                                                       name="addStudentFirstName" value="">
                                                <p id="addStudentFirstNameMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addStudentMiddleNameDiv">
                                                <label for="addStudentMiddleName">Middle Name</label>
                                                <input type="text" id="addStudentMiddleName" class="form-control" 
                                                       name="addStudentMiddleName" value="">
                                                <p id="addStudentMiddleNameMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addStudentLastNameDiv">
                                                <label for="addStudentLastName">Last Name<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addStudentLastName" class="form-control" 
                                                       name="addStudentLastName" value="">
                                                <p id="addStudentLastNameMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addStudentFatherFirstNameDiv">
                                                <label for="addFatherFirstName">Father First Name<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addFatherFirstName" class="form-control" 
                                                       name="addFatherFirstName" value="">
                                                <p id="addStudentFatherFirstNameMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addStudentFatherMiddleNameDiv">
                                                <label for="addFatherMiddleName">Father Middle Name</label>
                                                <input type="text" id="addFatherMiddleName" class="form-control" 
                                                       name="addFatherMiddleName" value="">
                                                <p id="addStudentFatherMiddleNameMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addStudentFatherLastNameDiv">
                                                <label for="addFatherLastName">Father Last Name<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addFatherLastName" class="form-control" 
                                                       name="addFatherLastName" value="">
                                                <p id="addStudentFatherLastNameMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addStudentMotherFirstNameDiv">
                                                <label for="addMotherFirstName">Mother First Name<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addMotherFirstName" class="form-control" 
                                                       name="addMotherFirstName" value="">
                                                <p id="addStudentMotherFirstNameMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addStudentMotherMiddleNameDiv">
                                                <label for="addMotherMiddleName">Mother Middle Name</label>
                                                <input type="text" id="addMotherMiddleName" class="form-control" 
                                                       name="addMotherMiddleName" value="">
                                                <p id="addStudentMotherMiddleNameMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addStudentMotherLastNameDiv">
                                                <label for="addMotherLastName">Mother Last Name<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addMotherLastName" class="form-control" 
                                                       name="addMotherLastName" value="">
                                                <p id="addStudentMotherLastNameMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addStudentClassDiv">
                                                <label for="addStudentClass">Class<span style="color:red;">&nbsp;*</span></label>
                                                <select id="addStudentClass" name="addStudentClass" class="form-control" 
                                                        onchange="populateAddStudentSections();" >
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_PLAY_HOME ?>" >Play Home</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_PRE_KG ?>" >Pre-KG</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_LKG ?>" >LKG</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_UKG ?>" >UKG</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_1 ?>" >Class I</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_2 ?>" >Class II</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_3 ?>" >Class III</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_4 ?>" >Class IV</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_5 ?>" >Class V</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_6 ?>" >Class VI</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_7 ?>" >Class VII</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_8 ?>" >Class VIII</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_9 ?>" >Class IX</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_10 ?>" >Class X</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_11 ?>" >Class XI</option>
                                                    <option value="<?php echo _ADMISSION_APPLY_CLASS_12 ?>" >Class XII</option>
                                                </select>
                                                <p id="addStudentClassMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addStudentSectionDiv">
                                                <label for="addStudentSection">Section<span style="color:red;">&nbsp;*</span></label>
                                                <select id="addStudentSection" name="addStudentSection" class="form-control" >
                                                    <option value="">Select</option>
                                                </select>
                                                <p id="addStudentSectionMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addStudentRollDiv">
                                                <label for="addStudentRoll">Student Roll Number<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addStudentRoll" class="form-control" 
                                                       name="addStudentRoll" value="">
                                                <p id="addStudentRollMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addStudentExamRollNumDiv">
                                                <label for="addExamRollNum">Exam Registration Number</label>
                                                <input type="text" id="addExamRollNum" class="form-control" 
                                                       name="addExamRollNum" value="">
                                                <p id="addStudentExamRollNumMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addStudentEmailDiv">
                                                <label for="addStudentEmail">Student Email<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addStudentEmail" class="form-control" 
                                                       name="addStudentEmail" value="">
                                                <p id="addStudentEmailMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addStudentFatherEmailDiv">
                                                <label for="addFatherEmail">Father Email<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addFatherEmail" class="form-control" 
                                                       name="addFatherEmail" value="">
                                                <p id="addStudentFatherEmailMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group" id="addStudentMotherEmailDiv">
                                                <label for="addMotherEmail">Mother Email<span style="color:red;">&nbsp;*</span></label>
                                                <input type="text" id="addMotherEmail" class="form-control" 
                                                       name="addMotherEmail" value="">
                                                <p id="addStudentMotherEmailMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addStudentFatherPhoneDiv">
                                                <label for="addStudentFatherPhone">Father Phone</label>
                                                <input type="text" id="addStudentFatherPhone" class="form-control" 
                                                       name="addStudentFatherPhone" value="">
                                                <p id="addStudentFatherPhoneMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group" id="addStudentMotherPhoneDiv">
                                                <label for="addStudentMotherPhone">Mother Phone</label>
                                                <input type="text" id="addStudentMotherPhone" class="form-control" 
                                                       name="addStudentMotherPhone" value="">
                                                <p id="addStudentMotherPhoneMsg" class="inputAlert"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-offset-3 col-sm-6">
                                            <br>
                                            <input type="submit" id="addStudentSubmit" name="addStudentSubmit" 
                                                   class="btn btn-primary" style="width:100%;" value="SUBMIT">
                                        </div>
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
                                <h4 class="modal-title" style="text-align:center;">
                                    <strong id="studentDetailTitle"></strong>
                                </h4>
                                <input type="hidden" id="scoreCardDetailsJson" value="">
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
                                            <!-- <tr>
                                                <td class="student_pr_desc">
                                                    Attendance &nbsp;<span class="glyphicon glyphicon-chevron-right"></span>
                                                </td>
                                            </tr> -->
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
                <!-- <div id="studentDetailModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg lg-modal-custom"> 
                        <div class="modal-content">
                            <div class="modal-header light_background">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="studentDetailTitle" style="text-align:center;"><strong>Vinayaka Hegde</strong></h4>
                                <input type="hidden" id="scoreCardDetailsJson" value="">
                            </div>
                            <div class="modal-body" id="studentDetailContent">
                                <div class="row">
                                    <div class="col-sm-2" id="studentPersonalDetailDiv">
                                        <img id="studentImage" class="img-rounded img-responsive" 
                                             style="padding-bottom:20px;margin:0 auto;" alt="IMG"
                                             src="http://paathshaala/images/5/board_3.jpeg">
                                        
                                        <div class="panel-group" id="accordion" style="margin-bottom:0;">
                                            <div class="panel panel-default" style="border-radius:0px;margin-top:0;">
                                                <div class="panel-heading cursor-point" data-toggle="collapse"
                                                      data-parent="#accordion" data-target="#collapse1">
                                                  <h5 class="small_title">
                                                     <strong>Class</strong>
                                                  </h5>
                                                    
                                                </div>
                                                <div id="collapse1" class="panel-collapse collapse in">
                                                    <div class="panel-body" style="background: white;padding:0;text-align:center;">
                                                        <p id="studentModalClass">VII 'A'</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default" style="border-radius:0px;margin-top:0;">
                                                <div class="panel-heading cursor-point" data-toggle="collapse"
                                                      data-parent="#accordion" data-target="#collapse2">
                                                  <h5 class="small_title">
                                                     <strong>Father</strong>
                                                  </h5>
                                                    
                                                </div>
                                                <div id="collapse2" class="panel-collapse collapse in">
                                                    <div class="panel-body" style="background: white;padding:0;text-align:center;">
                                                        <p id="studentModalFather">Venkataramana Nandi Hegde</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default" style="border-radius:0px;margin-top:0;">
                                                <div class="panel-heading cursor-point" data-toggle="collapse"
                                                      data-parent="#accordion" data-target="#collapse3">
                                                  <h5 class="small_title">
                                                     <strong>Mother</strong>
                                                  </h5>
                                                    
                                                </div>
                                                <div id="collapse3" class="panel-collapse collapse in">
                                                    <div class="panel-body" style="background: white;padding:0;text-align:center;">
                                                        <p id="studentModalMother">Dakshayani Hegde</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default" style="border-radius:0px;margin-top:0;">
                                                <div class="panel-heading cursor-point" data-toggle="collapse"
                                                      data-parent="#accordion" data-target="#collapse4">
                                                  <h5 class="small_title">
                                                     <strong>Date Of Birth</strong>
                                                  </h5>
                                                </div>
                                                <div id="collapse4" class="panel-collapse collapse in">
                                                    <div class="panel-body" style="background: white;padding:0;text-align:center;">
                                                        <p id="studentModalDOB">28 Feb, 1987</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default" style="border-radius:0px;margin-top:0;">
                                                <div class="panel-heading cursor-point" data-toggle="collapse"
                                                      data-parent="#accordion" data-target="#collapse5">
                                                  <h5 class="small_title">
                                                     <strong>Date Of Joining</strong>
                                                  </h5>
                                                </div>
                                                <div id="collapse5" class="panel-collapse collapse in">
                                                    <div class="panel-body" style="background: white;padding:0;text-align:center;">
                                                        <p id="studentModalDOJ">01 June, 1991</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-10" id="studentResultDiv">
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
                                                <tr>
                                                    <td class="sc_subject">English</td>
                                                    <td class="sc_score">
                                                        <div class="progress" style="margin-bottom:0px;">
                                                            <div class="progress-bar" role="progressbar" aria-valuenow="100"
                                                                 aria-valuemin="0" aria-valuemax="100" style="width:100%;">
                                                                100%
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span style="float:left;">D</span>
                                                            <span style="float:right;">A</span>
                                                        </div>
                                                    </td>
                                                    <td class="sc_average">
                                                        <div class="progress" style="margin-bottom:0px;">
                                                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="80"
                                                                 aria-valuemin="0" aria-valuemax="100" style="width:80%;">
                                                                80%
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span style="float:left;">D</span>
                                                            <span style="float:right;">A</span>
                                                        </div>
                                                    </td>
                                                    <td class="sc_remarks">Good! Keep it up</td>
                                                </tr>
                                                <tr>
                                                    <td class="sc_subject">Kannada</td>
                                                    <td class="sc_score">
                                                        <div class="progress" style="margin-bottom:0px;">
                                                            <div class="progress-bar" role="progressbar" aria-valuenow="90"
                                                                 aria-valuemin="0" aria-valuemax="100" style="width:90%;">
                                                                90%
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span style="float:left;">D</span>
                                                            <span style="float:right;">A</span>
                                                        </div>
                                                    </td>
                                                    <td class="sc_average">
                                                        <div class="progress" style="margin-bottom:0px;">
                                                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="80"
                                                                 aria-valuemin="0" aria-valuemax="100" style="width:80%;">
                                                                80%
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span style="float:left;">D</span>
                                                            <span style="float:right;">A</span>
                                                        </div>
                                                    </td>
                                                    <td class="sc_remarks">Good! Keep it up</td>
                                                </tr>
                                                <tr>
                                                    <td class="sc_subject">Social Science</td>
                                                    <td class="sc_score">
                                                        <div class="progress" style="margin-bottom:0px;">
                                                            <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                                 aria-valuemin="0" aria-valuemax="100" style="width:70%;">
                                                                70%
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span style="float:left;">D</span>
                                                            <span style="float:right;">A</span>
                                                        </div>
                                                    </td>
                                                    <td class="sc_average">
                                                        <div class="progress" style="margin-bottom:0px;">
                                                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="80"
                                                                 aria-valuemin="0" aria-valuemax="100" style="width:80%;">
                                                                80%
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <span style="float:left;">D</span>
                                                            <span style="float:right;">A</span>
                                                        </div>
                                                    </td>
                                                    <td class="sc_remarks">Can do better</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
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