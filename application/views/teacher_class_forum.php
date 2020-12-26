<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="teacherClassForumOnLoad();">
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
                <?php if( isset($header_message) && $header_message != "" ){ ?>
                    <div class="row">
                        <div id="alert" class="col-sm-6 col-sm-offset-3 alert-div" align="center;"> <!--margin-left:25%;margin-right:25%;-->
                            <p class="alert-text-ps"><?php echo $header_message; ?></p>
                        </div>
                    </div>
                <?php } ?>
                    <div class="panel panel-default" style="height:100%; margin-top: 15px;">
                        <div class="panel-body" style="padding-top:0px;">
                            <div class="row">
                                <div class="col-sm-3 light_background" style="margin-top: 0;padding-top: 50px;min-height: 500px;">
                                    <div class="form-group">
                                        <p style="text-align:center;"><strong>SELECT CLASS</strong></p>
                                        <select id="selectFeedClass" class="form-control" onchange="populateClassFeed();">
                                            <option value="">Select</option>
                                            <?php if( isset($classList) ) { 
                                                for( $i=0; $i < count($classList); $i++ ){ ?>
                                            <option value="<?php echo trim($classList[$i]['class_id']); ?>"
                                                <?php if( isset($selectedClassId) && trim($selectedClassId) == trim($classList[$i]['class_id']) ) 
                                                                echo "selected" ?> >
                                                <?php echo $classMap[trim($classList[$i]['class'])] . " - Section " . trim($classList[$i]['section']); ?>
                                            </option>
                                            <?php } 
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <p style="text-align:center;"><strong>NOTIFICATIONS</strong></p> 
                                    <div id="showNotifications" style="height:400px;overflow-y:scroll;">
                                        <p style="text-align:center;" id="selectClassTxt">Please select a class!</p>
                                        <table class="table table-bordered table-responsive" id="classNotifTable" 
                                               style="display:none;background:#ffffff;text-align: center;">
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-9" style="min-height:500px;padding-left:20px;padding-top:20px;" id="classForumDiv">
                                    
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
                                <!-- <div class="row">
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <p style="width:100%;"><strong>Vinayaka Hegde</strong></p>
                                            </div>
                                            <div class="col-sm-2 col-sm-offset-4 feed_time_div">
                                                <p style="width:100%;"><small>28 June</small></p>
                                            </div>
                                        </div>
                                        <p style="width:100%;">Sample update1... this is a lengthy update!!! really relally lenghty</p>
                                        <div id="commentsForPost" class="row" style="max-height: 300px;overflow-y:scroll;">
                                            <div class="col-sm-10" style="padding-right:0px;">
                                                <table class="table table-bordered table-responsive" id="commentTable" 
                                                       style="background:#efecec;margin:0px;">
                                                    <tr>
                                                        <td style="padding-top:0px; padding-bottom:0px;padding-right:1px;">
                                                            <strong>One Plus</strong><br>
                                                            <p>This is a sample comment</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top:0px; padding-bottom:0px;padding-right:1px;">
                                                            <strong>One Plus</strong><br>
                                                            <p>This is a sample comment 2</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-top:0px; padding-bottom:0px;padding-right:1px;">
                                                            <strong>One Plus</strong><br>
                                                            <p>This is a sample comment 2</p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-10" style="padding-right:0px;">
                                                <textarea class="form-control" id="comment1" rows="1" 
                                                          value="" style="border-radius:0px;"></textarea>
                                            </div>
                                            <div class="col-sm-2"> <!-- style="padding-left:0px;" -->
                                                <input type="button" id="commentSubmitBtn1" class="btn btn-sm btn-primary" 
                                                       style="height:34px;" value="COMMENT">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                    </div>
                                </div> -->
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
                                        <input type="hidden" id="pic_class_id" name="pic_class_id" value="">
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
        <!-- Load JS -->
        <script type="text/javascript" src="/public/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/public/js/teacher.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>