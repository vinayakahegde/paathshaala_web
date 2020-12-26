<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/
            <?php echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="aboutUsOnLoad();">
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
                 
                 <div class="container-fluid" style="margin:0px;">
                    <div class="row">
                        <div class="col-sm-8" style="padding:10px;padding-right:0px;">
                            <div class="panel panel-default" style="min-height:100%;width:100%;">
                                <div class="panel-heading" style="text-align: center;"><strong>About Us</strong></div>
                                <div id="aboutUsContainer" class="panel-body" style="width:100%;">
                                    <p>
                                        <strong>Our Motto</strong><br>
                                        Sa Vidya Ya Vimuktaye<br>
                                        Education alone liberates the soul.<br>
                                    </p>
                                    <p>
                                        <strong>Our Vision</strong><br>
                                        To provide world class education to all the students<br>
                                    </p>
                                    
                                    <p>
                                        <strong>Our Mission</strong><br>
                                        To provide quality education to all the students and make them first class citizens<br><br>
                                    </p>
                                    
                                    <p>
                                        VidyaVardhaka Sangha High School was started in the year 1970 under the able leadership of Mr. Dwarakanath<br>
                                        It has grown since then to become one of the most reputed schools in Bangalore.<br>
                                        Our alumni have achieved great things in many fields.<br></br>
                                    </p>
                                    <p>
                                        The school currently has six sections for each class<br>
                                        
                                        The school has state of the art facilities in all areas<br>
                                        It has its own ground and we conduct many events from time to time<br>
                                        Our students have shown excellent caliber and the board exam results speak for themselves<br>
                                        
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4" style="padding:10px;">
                            <div class="panel panel-default" style="min-height:100%;width:100%;float:right;">
                                <div class="panel-heading" style="text-align: center;"><strong>School Board</strong></div>
                                <div id="boardContainer" class="panel-body" style="width:100%;height:500px;overflow:hidden;"
                                    onmouseover="disableScroll();" onmouseout="enableScroll();">
                                    <div id="boardMembers" style="height:500px;">
                                    <table id="boardMembersTable" class="table table-hover borderless" style="margin-bottom:0px;">
                                    <?php  //member_id, name, short_description, description, phone, 
                                            //email_id, website, blog, twitter_handle, image_url
                                        for( $i=0; $i < count( $board_information ); $i++ ){ ?>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <div class="panel panel-default cursor-point" data-toggle="modal" data-target="#boardMemberModal"
                                                         id="mem_id_1_<?php echo trim( $board_information[$i]['member_id'] ); ?>">
                                                        <div class="panel-body" style="width:100%;">
                                                            <img alt="img" id="mem_img_1_<?php echo trim($board_information[$i]['member_id'])?>"
                                                                 class="img-rounded img-responsive" 
                                                                 style="padding-bottom:10px;margin:0 auto;clear:both;">
                                                            <p id="mem_name_1_<?php echo trim($board_information[$i]['member_id'])?>">
                                                                <strong><?php echo trim($board_information[$i]['name'])?></strong>
                                                            </p>
                                                            <p id="mem_short_desc_1_<?php echo trim($board_information[$i]['member_id'])?>">
                                                                <?php echo trim($board_information[$i]['short_description'])?>
                                                            </p>
                                                            <input type="hidden" id="mem_name_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                    value="<?php echo trim($board_information[$i]['name']); ?>">
                                                             <input type="hidden" id="mem_desc_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                    value="<?php echo trim($board_information[$i]['description']); ?>">
                                                             <?php if( trim($board_information[$i]['phone_show']) == _GENERAL_DISPLAY_CONTENT ) { ?>
                                                                <input type="hidden" id="mem_phone_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                    value="<?php echo trim($board_information[$i]['phone']); ?>"> 
                                                             <?php } 
                                                                if( trim($board_information[$i]['email_show']) == _GENERAL_DISPLAY_CONTENT ){ ?>
                                                                <input type="hidden" id="mem_email_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                    value="<?php echo trim($board_information[$i]['email_id']); ?>">
                                                             <?php } 
                                                                if( trim($board_information[$i]['website_show']) == _GENERAL_DISPLAY_CONTENT ){ ?>
                                                                <input type="hidden" id="mem_website_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                    value="<?php echo trim($board_information[$i]['website']); ?>">
                                                             <?php } 
                                                                if( trim($board_information[$i]['blog_show']) == _GENERAL_DISPLAY_CONTENT ){ ?>
                                                                <input type="hidden" id="mem_blog_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                    value="<?php echo trim($board_information[$i]['blog']); ?>">
                                                             <?php } 
                                                                if( trim($board_information[$i]['twitter_show']) == _GENERAL_DISPLAY_CONTENT ){ ?>
                                                                <input type="hidden" id="mem_twitter_handle_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                    value="<?php echo trim($board_information[$i]['twitter_handle']); ?>">
                                                             <?php } ?>
                                                             <input type="hidden" id="mem_img_url_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                    value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_BOARD_MEMBER_NUM 
                                                                            . "/" . trim($board_information[$i]['image_url']); ?>">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                      <?php  }
                                        for( $i=0; $i < count( $board_information ); $i++ ){ ?>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <div class="panel panel-default cursor-point" data-toggle="modal" data-target="#boardMemberModal"
                                                         id="mem_id_2_<?php echo trim( $board_information[$i]['member_id'] ); ?>">
                                                        <div class="panel-body" style="width:100%;">
                                                            <img src="" alt="img" id="mem_img_2_<?php echo trim($board_information[$i]['member_id'])?>"
                                                                 class="img-rounded img-responsive" 
                                                                 style="padding-bottom:10px;margin:0 auto;clear:both;">
                                                            <p id="mem_name_2_<?php echo trim($board_information[$i]['member_id'])?>">
                                                                <strong><?php echo trim($board_information[$i]['name'])?></strong>
                                                            </p>
                                                            <p id="mem_short_desc_2_<?php echo trim($board_information[$i]['member_id'])?>">
                                                                <?php echo trim($board_information[$i]['short_description'])?>
                                                            </p>
                                                        </div>
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
                 
                 <div id="boardMemberModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="boardMemberTitle" style="text-align:center;"><strong></strong></h4>
                            </div>
                            <div class="modal-body" id="boardMemberContent">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <img id="boardMemberContentImage" class="img-rounded img-responsive" 
                                             style="padding-bottom:20px;margin:0 auto;" alt="">
                                    </div>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-5">
                                        <table class="table table-responsive borderless" id="boardMemContactsTbl">
                                        </table>
                                    </div>
                                </div>
                                <p id="boardMemberContentText" style="width:100%;word-wrap:break-word;text-align: center;"></p>
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