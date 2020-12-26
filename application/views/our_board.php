<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/
            <?php echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="ourBoardOnLoad();">
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
                            $board_count = count( $board_information );
                            while( $i < $board_count ){ ?>
                            <div class="row">
                                <div class="col-sm-6"><!-- style="padding-left:10px;padding-right:0px;" style="padding:25px;height:400px;" -->
                                    <div class="panel panel-default panel-custom" style="height:100%;width:100%;"
                                         id="board_mem_id_<?php echo trim($board_information[$i]['member_id']);?>" 
                                         onmouseover="addPanelHighLight('board_mem_id_' + '<?php echo trim($board_information[$i]['member_id']);?>');" 
                                         onmouseout="removePanelHighlight('board_mem_id_' + '<?php echo trim($board_information[$i]['member_id']);?>');"
                                         data-toggle="modal" data-target="#boardMemberModal"> <!-- min-height:100%; -->
                                        <div class="panel-heading info-head">
                                            <p style="text-align:center;"><strong><?php echo trim($board_information[$i]['name']); ?></strong></p>
                                        </div>
                                        <div id="boardContainer_<?php echo trim($board_information[$i]['member_id'])?>" 
                                             class="panel-body" style="width:100%;">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <img id="boardMemberImage_<?php echo trim($board_information[$i]['member_id'])?>" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="hidden" id="mem_img_url_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                    value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_BOARD_MEMBER_NUM 
                                                                            . "/" . trim($board_information[$i]['image_url']); ?>">
                                                    <table class="table table-responsive borderless" 
                                                           id="boardMemContactsTbl_<?php echo trim($board_information[$i]['member_id']); ?>">
                                                        <colgroup>
                                                            <col style="width:75px;">
                                                            <col>
                                                        </colgroup>
                                                        <?php if( trim($board_information[$i]['phone_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($board_information[$i]['phone']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Phone</strong></p></td>
                                                            <td><p><?php echo trim($board_information[$i]['phone']); ?></p>
                                                                <input type="hidden" id="mem_phone_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                       value="<?php echo trim($board_information[$i]['phone']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($board_information[$i]['email_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($board_information[$i]['email_id']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Email ID</strong></p></td>
                                                            <td>
                                                                <p><?php echo trim($board_information[$i]['email_id']); ?></p>
                                                                <input type="hidden" id="mem_email_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                   value="<?php echo trim($board_information[$i]['email_id']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($board_information[$i]['website_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($board_information[$i]['website']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Website</strong></p></td>
                                                            <td><input type="hidden" id="mem_website_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                   value="<?php echo trim($board_information[$i]['website']); ?>">
                                                                <p><?php echo trim($board_information[$i]['website']); ?></p>
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($board_information[$i]['blog_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($board_information[$i]['blog']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Blog</strong></p></td>
                                                            <td><input type="hidden" id="mem_blog_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                   value="<?php echo trim($board_information[$i]['blog']); ?>">
                                                                <p><?php echo trim($board_information[$i]['blog']); ?></p>
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($board_information[$i]['twitter_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($board_information[$i]['twitter_handle']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Twitter</strong></p></td>
                                                            <td><input type="hidden" id="mem_twitter_handle_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                   value="<?php echo trim($board_information[$i]['twitter_handle']); ?>">
                                                                <p><?php echo trim($board_information[$i]['twitter_handle']); ?></p>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </table>
                                                </div>
                                            </div>
                                            <div id="boardMemShortDesc_<?php echo trim($board_information[$i]['member_id']); ?>">
                                                <p id="mem_short_desc_<?php echo trim($board_information[$i]['member_id'])?>">
                                                    <?php echo trim($board_information[$i]['short_description'])?>
                                                </p>
                                                <input type="hidden" id="mem_name_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                       value="<?php echo trim($board_information[$i]['name']); ?>">
                                                <input type="hidden" id="mem_desc_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                       value="<?php echo trim($board_information[$i]['description']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $i++; 
                            if( $i < $board_count ){ ?>
                                <div class="col-sm-6">  <!--  style="padding:25px;padding-left:0px;height:400px;" -->
                                    <div class="panel panel-default panel-custom" style="height:100%;width:100%;"
                                         id="board_mem_id_<?php echo trim($board_information[$i]['member_id']);?>" 
                                         onmouseover="addPanelHighLight('board_mem_id_' + '<?php echo trim($board_information[$i]['member_id']);?>');" 
                                         onmouseout="removePanelHighlight('board_mem_id_' + '<?php echo trim($board_information[$i]['member_id']);?>');"
                                         data-toggle="modal" data-target="#boardMemberModal">
                                        <div class="panel-heading info-head">
                                            <p style="text-align:center;"><strong><?php echo trim($board_information[$i]['name']); ?></strong></p>
                                        </div>
                                        <div id="boardContainer_<?php echo trim($board_information[$i]['member_id'])?>" 
                                             class="panel-body" style="width:100%;">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <img id="boardMemberImage_<?php echo trim($board_information[$i]['member_id'])?>" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="hidden" id="mem_img_url_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                    value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_BOARD_MEMBER_NUM 
                                                                            . "/" . trim($board_information[$i]['image_url']); ?>">
                                                    <table class="table table-responsive borderless" 
                                                           id="boardMemContactsTbl_<?php echo trim($board_information[$i]['member_id']); ?>">
                                                        <colgroup>
                                                            <col style="width:75px;">
                                                            <col>
                                                        </colgroup>
                                                        <?php if( trim($board_information[$i]['phone_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($board_information[$i]['phone']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Phone</strong></p></td>
                                                            <td><p><?php echo trim($board_information[$i]['phone']); ?></p>
                                                                <input type="hidden" id="mem_phone_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                       value="<?php echo trim($board_information[$i]['phone']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($board_information[$i]['email_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($board_information[$i]['email_id']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Email ID</strong></p></td>
                                                            <td>
                                                                <p><?php echo trim($board_information[$i]['email_id']); ?></p>
                                                                <input type="hidden" id="mem_email_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                   value="<?php echo trim($board_information[$i]['email_id']); ?>">
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($board_information[$i]['website_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($board_information[$i]['website']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Website</strong></p></td>
                                                            <td><input type="hidden" id="mem_website_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                   value="<?php echo trim($board_information[$i]['website']); ?>">
                                                                <p><?php echo trim($board_information[$i]['website']); ?></p>
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($board_information[$i]['blog_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($board_information[$i]['blog']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Blog</strong></p></td>
                                                            <td><input type="hidden" id="mem_blog_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                   value="<?php echo trim($board_information[$i]['blog']); ?>">
                                                                <p><?php echo trim($board_information[$i]['blog']); ?></p>
                                                            </td>
                                                        </tr>
                                                        <?php } if( trim($board_information[$i]['twitter_show']) == _GENERAL_DISPLAY_CONTENT &&
                                                                    trim($board_information[$i]['twitter_handle']) != "" ){ ?>
                                                        <tr>
                                                            <td><p><strong>Twitter</strong></p></td>
                                                            <td><input type="hidden" id="mem_twitter_handle_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                                   value="<?php echo trim($board_information[$i]['twitter_handle']); ?>">
                                                                <p><?php echo trim($board_information[$i]['twitter_handle']); ?></p>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </table>
                                                </div>
                                            </div>
                                            <div id="boardMemShortDesc_<?php echo trim($board_information[$i]['member_id']); ?>">
                                                <p id="mem_short_desc_<?php echo trim($board_information[$i]['member_id'])?>">
                                                    <?php echo trim($board_information[$i]['short_description'])?>
                                                </p>
                                                <input type="hidden" id="mem_name_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                       value="<?php echo trim($board_information[$i]['name']); ?>">
                                                <input type="hidden" id="mem_desc_<?php echo trim($board_information[$i]['member_id']); ?>"
                                                       value="<?php echo trim($board_information[$i]['description']); ?>">
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