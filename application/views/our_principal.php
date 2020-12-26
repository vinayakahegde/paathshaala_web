<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/
            <?php echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="ourPrincipalOnLoad();">
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
                        <div class="col-sm-7" style="padding:10px;padding-right:0px;">
                            <div class="panel panel-default" style="min-height:100%;width:100%;">
                                <div class="panel-heading" style="text-align: center;"><strong>Principal's Message</strong></div>
                                <div id="ourPrincipalContainer" class="panel-body" style="width:100%;">
                                    <p>
                                        VidyaVardhaka Sangha High School was started in the year 1970 under the able leadership of Mr. Dwarakanath<br>
                                        It has grown since then to become one of the most reputed schools in Bangalore.<br>
                                        Our alumni have achieved great things in many fields.<br></br>
                                    </p>
                                    <p>
                                        As we look forward to the future, we envision VVSHS, Rajajinagar as a place where excellence in education means educating the whole child. 
                                        We aim to provide the knowledge, skills, abilities, attitudes and beliefs that are essential for a productive and successful life. 
                                        We recognize that these goals are best achieved when the school provides an environment in which educators, parents, staff and others develop and practice core values that benefit the academic, emotional and social needs of all children.
                                    </p>
                                    <p>
                                        Strong communication between home and school forms the basis for the caring, nurturing, family atmosphere that is essential to our School. 
                                        This atmosphere promotes an excellence in teaching that results in high academic achievement and enables children to realize personal excellence at all levels.
                                    </p>
                                    <p>
                                        We see education as forming a sound foundation for life-long learning. 
                                        All children can learn, and we can develop within each student the desire to know, the tools to seek and the ability to find, understand and use information as a means to becoming self-sufficient, responsible, and productive contributors to a complex, ever-changing, and diverse society. 
                                        We seek a challenging and supportive learning environment that capitalizes on the natural curiosity of children as they explore all parts of the curriculum.
                                    </p>
                                    <p>
                                        Join us in our mission for to make our School a place children love to attend, a place in which parents believe their children are receiving an education second to none, and a place in which teachers express their joy of working with pride.
                                    </p>
                                    <br>
                                    <p style="text-align:right;padding-right:50px;"><strong>Lakshminarayan</strong><br>
                                        Principal, VVSHS
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-sm-4" style="padding:10px;">
                            <div class="panel panel-default" style="min-height:100%;width:100%;float:right;">
                                <div class="panel-heading" style="text-align: center;">School Board</div>
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
                    </div> -->
                    <div class="col-sm-5" style="padding:10px;">
                        <div class="panel panel-default" style="min-height:100%;width:100%;">
                            <div class="panel-heading" style="text-align: center;"><strong>Principal's Bio</strong></div>
                            <div id="principalBioContainer" class="panel-body" style="width:100%;">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <img id="principalImage" class="img-rounded img-responsive" 
                                             style="padding-bottom:20px; " alt="PRINCIPAL"> <!-- margin:0 auto; -->
                                        <input type="hidden" id="principalImageURL" 
                                              value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . 
                                                      _IMAGE_SCHOOL_PRINCIPAL_NUM . "/" . _IMAGE_SCHOOL_PRINCIPAL_FILE_NAME; ?>">
                                    </div>
                                    <!--<div class="col-sm-2"></div>-->
                                    <div class="col-sm-8">
                                        <table class="table table-responsive borderless" id="principalContactsTbl"
                                               style="margin:auto;">
                                            <colgroup>
                                                <col style="width:50px;">
                                                <col>
                                            </colgroup>
                                            <tr>
                                                <td><strong>Phone</strong></td>
                                                <td>9876556789</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email</strong></td>
                                                <td>principal@vvshs.com</td>
                                            </tr>
                                            <!--<tr>
                                                <td><strong>Website</strong></td>
                                                <td>www.vvshs.com</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Blog</strong></td>
                                                <td>principal_vvshs.wordpress.com</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Twitter</strong></td>
                                                <td>@principal_vvshs</td>
                                            </tr>-->
                                        </table>
                                    </div>
                                </div>
                                <p><strong>Mr. Lakshminarayan</strong></p>
                                <br>
                                <p><strong>D.O.B : </strong>26-03-1956</p>
                                <br>
                                <p><strong>Academic Qualifications : </strong></p>
                                <p>M.Sc, Bangalore University, 1970</p>
                                <p>B.Sc, Bangalore University, 1968</p>
                                <br>
                                <p><strong>Professional Qualifications : </strong></p>
                                <p>Science and Math teacher, Vani High School, 1971 - 1985</p>
                                <p>Science and Math teacher, Vidyavardhaka Sangha High School, 1985 - 2005</p>
                                <p>Principal, Vidyavardhaka Sangha High School, 2005 - present </p>
                                <br>
                                <p><strong>Awards and Recognitions : </strong></p>
                                <p>National Teachers Award, 2008</p>
                                <p>Best teacher award in Bangalore, 1998</p>
                                <br>
                                <p><strong>Other Achievements and Responsibilities</strong></p>
                                <p>Head of NSS in VVSHS</p>
                                <br>
                                <p><strong>Interests</strong></p>
                                <p>Cultural programs</p>
                                <p>Literature</p>
                            </div>
                        </div>
                    </div>
                 </div>
                 
                 <div id="boardMemberModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="boardMemberTitle"><strong></strong></h4>
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