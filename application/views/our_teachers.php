<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/
            <?php echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="facultyOnLoad();">
        <div id="wrap"><input type="hidden" id="base_url" value="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>">
            <div id="main" class="container" style="padding-bottom:0px;"> <!--  -->
                 <!-- -->
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
                    
                    $this->load->view('common/menu', $displayData); ?>
                 
                 <div class="container-fluid" style="margin:0px;padding:15px;"> <!--  -->
                    <div class="panel panel-default" style="width:100%;height:100%;">
                        <div class="panel-body" style="width:100%;">
                        <?php 
                            $i = 0;
                            $faculty_count = count( $faculty_information );
                            while( $i < $faculty_count ){ ?>
                            <div class="row">
                                <div class="col-sm-4"><!--style="padding-left:10px;padding-right:0px;" style="padding:25px;" -->
                                    <div class="panel panel-default panel-custom" style="height:100%;width:100%;"
                                         id="faculty_gen_id_<?php echo trim($faculty_information[$i]['teacher_id']);?>" 
                                         onmouseover="addPanelHighLight('faculty_gen_id_' + '<?php echo trim($faculty_information[$i]['teacher_id']);?>');" 
                                         onmouseout="removePanelHighlight('faculty_gen_id_' + '<?php echo trim($faculty_information[$i]['teacher_id']);?>');"
                                         data-toggle="modal" data-target="#facultyGeneralModal"> <!-- min-height:100%; -->
                                        <div class="panel-heading info-head">
                                            <p style="text-align:center;"><strong><?php echo trim($faculty_information[$i]['name']); ?></strong></p>
                                        </div>
                                        <div id="facultyGeneralContainer_<?php echo trim($faculty_information[$i]['teacher_id'])?>" 
                                             class="panel-body" style="width:100%;">
                                            <div class="facultyGeneralImageDiv" style="width:100%;">
                                                <img id="facultyGeneralImage_<?php echo trim($faculty_information[$i]['teacher_id'])?>" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                            </div>
                                            <div>
                                                <table class="table table-responsive borderless" 
                                                           id="facultyGeneralDetailsTbl_<?php echo trim($faculty_information[$i]['teacher_id']); ?>">
                                                        <colgroup>
                                                            <col style="width:100px;">
                                                            <col>
                                                        </colgroup>
                                                        <?php if( trim($faculty_information[$i]['exp_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($faculty_information[$i]['experience']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Experience</strong></p></td>
                                                            <td><p><?php echo trim($faculty_information[$i]['experience']); ?></p>
                                                                <input type="hidden" id="fg_experience_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                       value="<?php echo trim($faculty_information[$i]['experience']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($faculty_information[$i]['qual_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($faculty_information[$i]['qualification']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Qualification</strong></p></td>
                                                            <td>
                                                                <p><?php echo trim($faculty_information[$i]['qualification']); ?></p>
                                                                <input type="hidden" id="fg_qual_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['qualification']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($faculty_information[$i]['sub_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($faculty_information[$i]['subjects']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Subjects</strong></p></td>
                                                            <td><input type="hidden" id="fg_subjects_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['subjects']); ?>">
                                                                <p><?php echo trim($faculty_information[$i]['subjects']); ?></p>
                                                                <input type="hidden" id="fg_phone_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                       value="<?php echo trim($faculty_information[$i]['phone']); ?>">
                                                                <input type="hidden" id="fg_email_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['email_id']); ?>">
                                                                <input type="hidden" id="fg_website_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['website']); ?>">
                                                                <input type="hidden" id="fg_blog_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['blog']); ?>">
                                                                <input type="hidden" id="fg_twitter_handle_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['twitter_handle']); ?>">
                                                                <input type="hidden" id="fg_name_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                       value="<?php echo trim($faculty_information[$i]['name']); ?>">
                                                                <input type="hidden" id="fg_desc_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                       value="<?php echo trim($faculty_information[$i]['description']); ?>">
                                                                <input type="hidden" id="fg_img_url_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                    value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_FACULTY_GENERAL_NUM 
                                                                            . "/" . trim($faculty_information[$i]['image_url']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $i++; 
                            if( $i < $faculty_count ){ ?>
                                <div class="col-sm-4" >  <!-- style="padding:25px;padding-left:0px;" -->
                                    <div class="panel panel-default panel-custom" style="height:100%;width:100%;"
                                         id="faculty_gen_id_<?php echo trim($faculty_information[$i]['teacher_id']);?>" 
                                         onmouseover="addPanelHighLight('faculty_gen_id_' + '<?php echo trim($faculty_information[$i]['teacher_id']);?>');" 
                                         onmouseout="removePanelHighlight('faculty_gen_id_' + '<?php echo trim($faculty_information[$i]['teacher_id']);?>');"
                                         data-toggle="modal" data-target="#facultyGeneralModal">
                                        <div class="panel-heading info-head">
                                            <p style="text-align:center;"><strong><?php echo trim($faculty_information[$i]['name']); ?></strong></p>
                                        </div>
                                        <div id="facultyGeneralContainer_<?php echo trim($faculty_information[$i]['teacher_id'])?>" 
                                             class="panel-body" style="width:100%;">
                                            <div class="facultyGeneralImageDiv" style="width:100%;">
                                                <img id="facultyGeneralImage_<?php echo trim($faculty_information[$i]['teacher_id'])?>" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                            </div>
                                            <div>
                                                <table class="table table-responsive borderless" 
                                                           id="facultyGeneralDetailsTbl_<?php echo trim($faculty_information[$i]['teacher_id']); ?>">
                                                        <colgroup>
                                                            <col style="width:100px;">
                                                            <col>
                                                        </colgroup>
                                                        <?php if( trim($faculty_information[$i]['exp_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($faculty_information[$i]['experience']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Experience</strong></p></td>
                                                            <td><p><?php echo trim($faculty_information[$i]['experience']); ?></p>
                                                                <input type="hidden" id="fg_experience_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                       value="<?php echo trim($faculty_information[$i]['experience']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($faculty_information[$i]['qual_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($faculty_information[$i]['qualification']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Qualification</strong></p></td>
                                                            <td>
                                                                <p><?php echo trim($faculty_information[$i]['qualification']); ?></p>
                                                                <input type="hidden" id="fg_qual_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['qualification']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($faculty_information[$i]['sub_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($faculty_information[$i]['subjects']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Subjects</strong></p></td>
                                                            <td><input type="hidden" id="fg_subjects_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['subjects']); ?>">
                                                                <p><?php echo trim($faculty_information[$i]['subjects']); ?></p>
                                                                <input type="hidden" id="fg_phone_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                       value="<?php echo trim($faculty_information[$i]['phone']); ?>">
                                                                <input type="hidden" id="fg_email_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['email_id']); ?>">
                                                                <input type="hidden" id="fg_website_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['website']); ?>">
                                                                <input type="hidden" id="fg_blog_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['blog']); ?>">
                                                                <input type="hidden" id="fg_twitter_handle_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['twitter_handle']); ?>">
                                                                <input type="hidden" id="fg_name_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                       value="<?php echo trim($faculty_information[$i]['name']); ?>">
                                                                <input type="hidden" id="fg_desc_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                       value="<?php echo trim($faculty_information[$i]['description']); ?>">
                                                                <input type="hidden" id="fg_img_url_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                    value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_FACULTY_GENERAL_NUM 
                                                                            . "/" . trim($faculty_information[$i]['image_url']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $i++; } if( $i < $faculty_count ){ ?>
                                <div class="col-sm-4" > <!-- style="padding:25px;padding-left:0px;" -->
                                    <div class="panel panel-default panel-custom" style="height:100%;width:100%;"
                                         id="faculty_gen_id_<?php echo trim($faculty_information[$i]['teacher_id']);?>" 
                                         onmouseover="addPanelHighLight('faculty_gen_id_' + '<?php echo trim($faculty_information[$i]['teacher_id']);?>');" 
                                         onmouseout="removePanelHighlight('faculty_gen_id_' + '<?php echo trim($faculty_information[$i]['teacher_id']);?>');"
                                         data-toggle="modal" data-target="#facultyGeneralModal">
                                        <div class="panel-heading info-head">
                                            <p style="text-align:center;"><strong><?php echo trim($faculty_information[$i]['name']); ?></strong></p>
                                        </div>
                                        <div id="facultyGeneralContainer_<?php echo trim($faculty_information[$i]['teacher_id'])?>" 
                                             class="panel-body" style="width:100%;">
                                            <div class="facultyGeneralImageDiv" style="width:100%;">
                                                <img id="facultyGeneralImage_<?php echo trim($faculty_information[$i]['teacher_id'])?>" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                            </div>
                                            <div>
                                                <table class="table table-responsive borderless" 
                                                           id="facultyGeneralDetailsTbl_<?php echo trim($faculty_information[$i]['teacher_id']); ?>">
                                                        <colgroup>
                                                            <col style="width:100px;">
                                                            <col>
                                                        </colgroup>
                                                        <?php if( trim($faculty_information[$i]['exp_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($faculty_information[$i]['experience']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Experience</strong></p></td>
                                                            <td><p><?php echo trim($faculty_information[$i]['experience']); ?></p>
                                                                <input type="hidden" id="fg_experience_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                       value="<?php echo trim($faculty_information[$i]['experience']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($faculty_information[$i]['qual_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($faculty_information[$i]['qualification']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Qualification</strong></p></td>
                                                            <td>
                                                                <p><?php echo trim($faculty_information[$i]['qualification']); ?></p>
                                                                <input type="hidden" id="fg_qual_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['qualification']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($faculty_information[$i]['sub_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($faculty_information[$i]['subjects']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Subjects</strong></p></td>
                                                            <td><input type="hidden" id="fg_subjects_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['subjects']); ?>">
                                                                <p><?php echo trim($faculty_information[$i]['subjects']); ?></p>
                                                                <input type="hidden" id="fg_phone_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                       value="<?php echo trim($faculty_information[$i]['phone']); ?>">
                                                                <input type="hidden" id="fg_email_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['email_id']); ?>">
                                                                <input type="hidden" id="fg_website_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['website']); ?>">
                                                                <input type="hidden" id="fg_blog_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['blog']); ?>">
                                                                <input type="hidden" id="fg_twitter_handle_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                   value="<?php echo trim($faculty_information[$i]['twitter_handle']); ?>">
                                                                <input type="hidden" id="fg_name_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                       value="<?php echo trim($faculty_information[$i]['name']); ?>">
                                                                <input type="hidden" id="fg_desc_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                       value="<?php echo trim($faculty_information[$i]['description']); ?>">
                                                                <input type="hidden" id="fg_img_url_<?php echo trim($faculty_information[$i]['teacher_id']); ?>"
                                                                    value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_FACULTY_GENERAL_NUM 
                                                                            . "/" . trim($faculty_information[$i]['image_url']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>      
                 </div>
                 
                 <div id="facultyGeneralModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="facultyGeneralTitle" style="text-align:center;"><strong></strong></h4>
                            </div>
                            <div class="modal-body" id="facultyGeneralContent">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <img id="facultyGeneralContentImage" class="img-rounded img-responsive" 
                                             style="padding-bottom:20px;margin:0 auto;" alt="">
                                    </div>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-5">
                                        <table class="table table-responsive borderless" id="facultyGeneralContactsTbl">
                                            
                                        </table>
                                    </div>
                                </div>
                                <p id="facultyGeneralContentText" style="width:100%;word-wrap:break-word;text-align: center;"></p>
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
        
        <!-- Forgot Username Div -->
        <div id="forgotUsernameDiv" class="ForgotCredentials">
            <div id="close">
                <img src="/public/images/close.png" onclick="closeForgotUsername();"
                                            title="Close Popup" style="float: right; cursor: pointer;">
            </div>
            <div id="forgotUsernameDetails">
                <span style="text-align: center;"><p>Please Enter Your Email ID : </p></span>
                <span style="text-align: center;"><input type="text" id="forgotUsernameEmailID" name="forgotUsernameEmailID" value="" ></span>
                <span style="text-align: center;">
                    <input type="button" id="forgotUsernameSubmitBtn" name="forgotUsernameSubmitBtn" value="Submit" onclick="mailUsername();" >
                </span>
            </div>
        </div>

        <!--Forgot Password Div -->
        <div id="forgotPasswordDiv" class="ForgotCredentials">
        </div>
    <!-- Load JS -->
        <script type="text/javascript" src="/public/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/public/js/basic.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>