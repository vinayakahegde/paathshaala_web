<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/
            <?php echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="parentHomeOnLoad();" >
        <div id="wrap"><input type="hidden" id="base_url" value="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>">
            <div id="main" class="container" style="padding-bottom:0px !important;"> <!--  -->
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
                    
                    $this->load->view('common/menu', $displayData);

                    if( !isset($user_type) ){
                        $displayData['homeData'] = $homeData; 
                        $displayData['header_message'] = ( isset($header_message)? $header_message : "" );
                        $this->load->view('body_general', $displayData);
                    }  
                    
                ?>
                <div class="container-fluid" style="margin:0px;">
                    <div class="panel panel-default" style="width:100%;height:100%;margin-top:15px;">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="row" id="postBoxDiv"> <!--  style="position:fixed;width:100%;" -->
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="postingTextArea" rows="2" 
                                                      value="" placeholder="Enter your post here..."></textarea>
                                        </div>
                                        <div class="col-sm-3" style="margin-top:3px;">
                                            <input type="button" id="postUpdateBtn" class="btn btn-primary"
                                                   value="POST" onclick="postInForum();">
                                            <button id="postUpdatePic" class="btn btn-default" data-toggle="modal" 
                                                    data-target="#uploadPicModal" data-backdrop="static" data-keyboard="true">
                                                <span class="glyphicon glyphicon-camera"></span>
                                            </button>
                                            <input type="hidden" id="last_feed_fetched_time" value="">
                                        </div>
                                    </div>
                                    <div id="homeContentDiv" style="height:400px;margin-top:20px;overflow-y:scroll;">
                                    </div>
                                </div>
                                <div class="col-sm-3" style="height:500px;overflow-y:scroll;">
                                    <table class="table table-bordered table-responsive light_background" id="classNotifTable"
                                           style="text-align: center;">
                                        <tr>
                                            <td style="text-align:center;">
                                                <p style="margin:0px;"><strong>Notifications</strong></p>
                                            </td>
                                        </tr>
                                    </table>
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
                                        <input type="submit" id="submitFeedImageUpload" class="btn btn-primary" value="POST">
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
        <script type="text/javascript" src="/public/js/parent.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>