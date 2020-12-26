<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="schoolProfileOnLoad();">
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
                
                $profileDetailsSet = false;
                if( isset($profileDetails) && is_array($profileDetails) ){
                    $profileDetailsSet = true;
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
                        <div class="panel-body" style="padding-top:0px;padding-bottom:0px;">
                            <div class="row light_background">
                                <div class="col-sm-3" style="padding-top:15px;"><!-- teacher_id,  pic_url  -->
                                    <img id="schoolProfilePic" alt="Profile Picture"
                                         src="" class="img-rounded img-responsive" align="middle">
                                    <input type="hidden" id="schoolProPicUrl" 
                                           value="<?php if( $profileDetailsSet && array_key_exists( 'pic_url', $profileDetails)
                                                                && trim( $profileDetails['pic_url'] ) != '' ){
                                                echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                '/' . $profileDetails['pic_url']; 
                                                
                                           } else { 
                                               echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . '/' . _IMAGE_SCHOOL_PROFILE_PICTURE_NUM . 
                                                                                '/' . _DUMMY_PROFILE_PICTURE_FILENAME;
                                           }
                                            ?>">
                                    
                                    <button id="button" class="btn btn-primary" style="margin-top:10px;"
                                            data-toggle="modal" data-target="#changePictureModal">
                                        <span class="glyphicon glyphicon-picture"></span>&nbsp;&nbsp;CHANGE PICTURE
                                    </button>
                                    <button id="button" class="btn btn-default" style="margin-top:10px;"
                                            data-toggle="modal" data-target="#changePasswordModal"
                                            data-backdrop="static" data-keyboard="true">
                                        <span class="glyphicon glyphicon-lock"></span>&nbsp;&nbsp;<strong>CHANGE PASSWORD</strong>
                                    </button>
                                </div>
                                <div class="col-sm-9">
                                    <h4 id="basicDetailHeading" class="profile_sections">Basic Details</h4><br>
                                    <table id="basicDetailTable" class="table table-responsive table-bordered">
                                        <tr style="background:#cccccc;">
                                            <td class="profile_details_3" >
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-8">
                                                        <strong>First Name</strong>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span id="editFirstName" class="editProfileSpan" onclick="editProfileField('school', 'editFirstName', 'firstNameContent', 'firstname');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit First Name">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="profile_details_3" >
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-8">
                                                        <strong>Middle Name</strong>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span id="editMiddleName" class="editProfileSpan" onclick="editProfileField('school','editMiddleName', 'middleNameContent', 'middlename');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit Middle Name">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td  class="profile_details_3">
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-8"> <!--  style="padding-left:20%;" -->
                                                        <strong>Last Name</strong>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span id="editLastName" class="editProfileSpan" onclick="editProfileField('school', 'editLastName', 'lastNameContent', 'lastname');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit Last Name">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="background:#ffffff;">
                                            <td>
                                                <div id="firstNameContent" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'firstname', $profileDetails))
                                                                echo trim( $profileDetails['firstname'] ); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div id="middleNameContent" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'middlename', $profileDetails))
                                                                echo trim( $profileDetails['middlename'] ); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div id="lastNameContent" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'lastname', $profileDetails))
                                                                echo trim( $profileDetails['lastname'] ); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table id="datesTable" class="table table-bordered table-responsive">
                                        <tr style="background:#cccccc;">
                                            <td class="profile_details_3" >
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-6">
                                                        <strong>Date Of Birth</strong>
                                                    </div>
                                                    <div class="col-sm-4" style="text-align:right;">
                                                        <span id="editDOB" class="editProfileSpan" onclick="editProfileDateField('school', 2000, 'editDOB', 'DOBContent', 'date_of_birth', 'selectDOB');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit Date Of Birth">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="profile_details_3" >
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-6">
                                                        <strong>Marriage Date</strong>
                                                    </div>
                                                    <div class="col-sm-4" style="text-align:right;">
                                                        <span id="editDOA" class="editProfileSpan" onclick="editProfileDateField('school', 2016, 'editDOA', 'DOAContent', 'date_of_anniversary', 'selectDOA');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit Date Of Joining">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="profile_details_3" >
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-6">
                                                        <strong>Date Of Joining</strong>
                                                    </div>
                                                    <div class="col-sm-4" style="text-align:right;">
                                                        <span id="editDOJ" class="editProfileSpan" onclick="editProfileDateField('school', 2016, 'editDOJ', 'DOJContent', 'date_of_joining', 'selectDOJ');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit Date Of Joining">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="background:#ffffff;">
                                            <td>
                                                <div id="DOBContent" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'date_of_birth', $profileDetails))
                                                                echo trim( $profileDetails['date_of_birth'] ); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div id="DOAContent" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'date_of_anniversary', $profileDetails))
                                                                echo trim( $profileDetails['date_of_anniversary'] ); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div id="DOJContent" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'date_of_joining', $profileDetails))
                                                                echo trim( $profileDetails['date_of_joining'] ); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table id="basicAdditionalTable" class="table table-responsive table-bordered">
                                        <tr style="background:#cccccc;">
                                            <td class="profile_details_3" >
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-8">
                                                        <strong>School Teacher Number</strong>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span id="editTeacherRegNo" class="editProfileSpan" onclick="editProfileField('school', 'editTeacherRegNo', 'teacherRegNo', 'teacher_school_num');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit School Teacher Number">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="profile_details_3" >
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-8">
                                                        <strong>Qualification</strong>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span id="editQualification" class="editProfileSpan" onclick="editProfileField('school', 'editQualification', 'teacherQualification', 'qualification');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit Qualification">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td  class="profile_details_3">
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-8"> <!--  style="padding-left:20%;" -->
                                                        <strong>Experience</strong>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span id="editExperience" class="editProfileSpan" onclick="editProfileField('school', 'editExperience', 'teacherExperience', 'experience');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit Experience">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="background:#ffffff;">
                                            <td>
                                                <div id="teacherRegNo" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'teacher_school_num', $profileDetails))
                                                                echo trim( $profileDetails['teacher_school_num'] ); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div id="teacherQualification" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'qualification', $profileDetails))
                                                                echo trim( $profileDetails['qualification'] ); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div id="teacherExperience" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'experience', $profileDetails))
                                                                echo trim( $profileDetails['experience'] ); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <h4 id="basicDetailHeading" class="profile_sections">Contact Details</h4><br>
                                    <table id="contactDetailTable" class="table table-responsive table-bordered">
                                        <tr style="background:#cccccc;">
                                            <td style="text-align:center; width:75%;">
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-8">
                                                        <strong>Address</strong>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span id="editAddress" class="editProfileSpan" onclick="editAddressField('school', 'editAddress', 'teacherAddress', 'address');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit Address">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="text-align:center; width:25%;">
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-8">
                                                        <strong>PIN Code</strong>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span id="editPincode" class="editProfileSpan" onclick="editProfileField('school', 'editPincode', 'teacherPincode', 'pincode');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit PIN Code">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="background:#ffffff;">
                                            <td>
                                                <div id="teacherAddress" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'address', $profileDetails))
                                                                echo trim( $profileDetails['address'] ); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div id="teacherPincode" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'pincode', $profileDetails))
                                                                echo trim( $profileDetails['pincode'] ); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table id="contactDetails1Table" class="table table-bordered table-responsive">
                                        <tr style="background:#cccccc;">
                                            <td class="profile_details_2" >
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-8">
                                                        <strong>Phone Number</strong>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span id="editPhone" class="editProfileSpan" onclick="editProfileField('school', 'editPhone', 'teacherPhone', 'phone');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit Phone Number">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="profile_details_2" >
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-8">
                                                        <strong>Email</strong>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span id="editEmail" class="editProfileSpan" onclick="editProfileField('school', 'editEmail', 'teacherEmail', 'email_id');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit Email ID">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="background:#ffffff;">
                                            <td>
                                                <div id="teacherPhone" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'phone', $profileDetails))
                                                                echo trim( $profileDetails['phone'] ); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div id="teacherEmail" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'email_id', $profileDetails))
                                                                echo trim( $profileDetails['email_id'] ); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table id="contactDetails2Table" class="table table-bordered table-responsive">
                                        <tr style="background:#cccccc;">
                                            <td class="profile_details_2" >
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-8">
                                                        <strong>Twitter Handle</strong>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span id="editTwitter" class="editProfileSpan" onclick="editProfileField('school', 'editTwitter', 'teacherTwitter', 'twitter');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit Twitter Handle">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="profile_details_2" >
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-8">
                                                        <strong>Blog</strong>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <span id="editBlog" class="editProfileSpan" onclick="editProfileField('school', 'editBlog', 'teacherBlog', 'blog');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit Blog">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="background:#ffffff;">
                                            <td>
                                                <div id="teacherTwitter" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'twitter', $profileDetails))
                                                                echo trim( $profileDetails['twitter'] ); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div id="teacherBlog" style="margin:0px;text-align: center;">
                                                    <?php if( array_key_exists( 'blog', $profileDetails))
                                                                echo trim( $profileDetails['blog'] ); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <h4 id="basicDetailHeading" class="profile_sections">Other Details</h4><br>
                                    <table id="otherDetailTable" class="table table-responsive table-bordered">
                                        <tr style="background: #cccccc;">
                                            <td style="width:50%;text-align: center;" colspan="2">
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-6">
                                                        <strong>Hobbies</strong>
                                                    </div>
                                                    <div class="col-sm-4" style="text-align:right;">
                                                        <span id="editHobbies" class="editProfileSpan" onclick="editBulkField('school', 'editHobbies', 'hobby_', 'hobby_');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:50%;text-align: center;" colspan="2">
                                                <div class="row">
                                                    <div class="col-sm-offset-2 col-sm-6">
                                                        <strong>Achievements</strong>
                                                    </div>
                                                    <div class="col-sm-4" style="text-align:right;">
                                                        <span id="editAchievements" class="editProfileSpan" onclick="editBulkField('school', 'editAchievements', 'achievement_', 'achievement_');"
                                                              data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php for( $i = 1; $i <= 5; $i++ ){ ?>
                                        <tr style="background:#ffffff;">
                                            <td style="width:5%;text-align: center;">
                                                <?php echo $i; ?>
                                            </td>
                                            <td style="width:45%;text-align: center;">
                                                <div id="hobby_<?php echo $i; ?>">
                                                    <?php if( array_key_exists( 'hobby_' . $i, $profileDetails))
                                                                echo trim( $profileDetails['hobby_' . $i] ); ?>
                                                </div>
                                            </td>
                                            <td style="width:5%;text-align: center;">
                                                <?php echo $i; ?>
                                            </td>
                                            <td style="width:45%;text-align: center;">
                                                <div id="achievement_<?php echo $i; ?>">
                                                    <?php if( array_key_exists( 'achievement_' . $i, $profileDetails))
                                                                echo trim( $profileDetails['achievement_' . $i] ); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div id="changePictureModal" class="modal fade" role="dialog" style="height:100%;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header light_background">
                            <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                            <h4 class="modal-title" id="changePictureTitle" style="text-align:center;"><strong>CHANGE PROFILE PICTURE</strong></h4>
                        </div>
                        <div class="modal-body" id="changePictureContent">
                            <form id="uploadProPicForm" name="uploadProPicForm" method="post"
                                  action="/uploadProPic" enctype="multipart/form-data">
                                <![if !IE]>
                                    <label class="btn btn-warning btn-file" style="margin-bottom:16px;">
                                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Upload Picture 
                                        <input type="file" style="display: none;"  id="uploadProPic" name="uploadProPic"
                                               onchange="showUploadedFileName(this);">
                                    </label>
                                    <span class='label label-info' id="upload-file-info"></span>
                                <![endif]>
                                <!--[if lte IE 8]> 
                                    <input type="file" id="uploadProPic" name="uploadProPic"> 
                                <![endif]-->
                                
                                <div class="form-group" style="text-align:center;">
                                    <input type="hidden" id="upload_user_type" name="upload_user_type" value="school">
                                    <input type="submit" id="submitProPicUpload" class="btn btn-primary" value="UPLOAD">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="changePasswordModal" class="modal fade" role="dialog" style="height:100%;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header light_background">
                            <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                            <h4 class="modal-title" id="changePasswordTitle" style="text-align:center;"><strong>CHANGE PASSWORD</strong></h4>
                        </div>
                        <div class="modal-body" id="changePictureContent">
                            <div class="form-group">
                                <label for="oldPassword">Old Password</label>
                                <input type="password" id="oldPassword" value="" autocomplete="off" class="form-control">
                                <p class="inputAlert" id="oldPasswordErr">* Please enter the old password</p>
                            </div>
                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <input type="password" id="newPassword" value="" autocomplete="off" class="form-control">
                                <p class="inputAlert" id="newPasswordErr">* Please enter the new password</p>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm New Password</label>
                                <input type="password" id="confirmPassword" value="" autocomplete="off" class="form-control">
                                <p class="inputAlert" id="confirmPasswordErr">* Please enter the new password again</p>
                            </div>
                            <div class="form-group" style="text-align: center;">
                                <button type="button" id="saveChangePassword" class="btn btn-primary" onclick="changePassword();">
                                    <span class="glyphicon glyphicon-lock"></span>&nbsp;SAVE
                                </button>
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
        <script type="text/javascript" src="/public/js/profile.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>