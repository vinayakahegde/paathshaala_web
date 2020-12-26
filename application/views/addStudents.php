<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="addStudentsOnLoad();">
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
                <?php if( isset( $header_message ) && $header_message != "" ){ ?>
                    <div class="row">
                        <div id="alert" class="col-sm-6 col-sm-offset-3 alert-div" align="center;"> <!--margin-left:25%;margin-right:25%;-->
                            <p class="alert-text-ps"><?php echo $header_message; ?></p>
                        </div>
                    </div>
                <?php } ?>
                <div class="panel panel-default" style="width:100%;height:100%;margin-top:15px;">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <p><strong>Added Students</strong></p>
                                        <form id="addStudentsForm" name="addStudentsForm" method="post"
                                              enctype="multipart/form-data" action="/uploadStudents">
                                            <div class="form-group">
                                                <label for="addStudentsFile" class="form-control">
                                                <input type="file" id="addStudentsFile" name="addStudentsFile">
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" id="studentUploadBtn" name="studentUploadBtn" 
                                                       class="btn btn-primary" value="Upload">
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

