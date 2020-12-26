<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="addClassesOnLoad();">
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
                                        <form id="addClassesForm" name="addClassesForm"
                                              action="/addClasses" method="post">
                                                <div class="form-group">
                                                    <label for="numClasses">Sections</label><br>
                                                    <input type="text" class="input-sm" value="" id="numSections">
                                                    <input type="button" class="btn btn-primary btn-sm" id="submitNumSections" 
                                                           value="UPDATE" onclick="updateSections();">
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
                                                <input type="submit" class="btn btn-warning" id="submitAddClasses" 
                                                       name="submitAddClasses" value="SUBMIT" >
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
            <div id="addClassModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog"> <!--  modal-lg -->
                        <div class="modal-content">
                            <div class="modal-header light_background">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="addClassTitle" style="text-align:center;"><strong>ADD CLASS</strong></h4>
                            </div>
                            <div class="modal-body" id="addClassContent">
                                <form id="addClassesForm" name="addClassesForm" onsubmit="return validateAddClassesForm();"
                                      role="form" action="/addClasses" method="post">
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