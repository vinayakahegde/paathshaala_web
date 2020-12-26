<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/
            <?php echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="schoolTourOnLoad();">
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
                 
                 <div class="container-fluid" style="margin:0px;padding:15px;">  
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="panel panel-default" style="min-height:100%;width:100%;">
                                        <div class="panel-heading light_background" style="text-align: center;"><strong>Classrooms</strong></div>
                                        <div class="panel-body" style="background:#CBE7F1;">
                                            <div class="facilityImageDiv" style="width:100%;">
                                                <img id="facilityImage_Classroom" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                                <input type="hidden" id="facilityImageUrl_Classroom" 
                                                       value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_FACILITIES_NUM 
                                                              . "/" . _IMAGE_SCHOOL_CLASSROOM_FILE_NAME; ?>">
                                            </div>
                                            <div class="facilityDescDiv">
                                                <p>As in any family or community, a school must have rules.</p><br>

                                                <p>These rules set the standard by which individuals within the school measure their relationships with others. They are based on experience and common sense as well as the traditions and changing needs of the school. Some do not need to be written down as they are part of the everyday life of the school, administered as a matter of course by the staff and the Headmaster.</p>

                                                <p>The school rules are intended as guidelines for pupils in their conduct and for the Headmaster and staff in the exercise of their authority.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="panel panel-default" style="min-height:100%;width:100%;">
                                        <div class="panel-heading" style="text-align: center;background:lightcoral;"><strong>School Library</strong></div>
                                        <div class="panel-body" style="background:#F99999;">
                                            <div class="facilityImageDiv" style="width:100%;">
                                                <img id="facilityImage_Library" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                                <input type="hidden" id="facilityImageUrl_Library" 
                                                       value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_FACILITIES_NUM 
                                                              . "/" . _IMAGE_SCHOOL_LIBRARY_FILE_NAME; ?>">
                                            </div>
                                            <div class="facilityDescDiv">
                                                <p>As in any family or community, a school must have rules.</p><br>

                                                <p>These rules set the standard by which individuals within the school measure their relationships with others. They are based on experience and common sense as well as the traditions and changing needs of the school. Some do not need to be written down as they are part of the everyday life of the school, administered as a matter of course by the staff and the Headmaster.</p>

                                                <p>The school rules are intended as guidelines for pupils in their conduct and for the Headmaster and staff in the exercise of their authority.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="panel panel-default" style="min-height:100%;width:100%;">
                                        <div class="panel-heading" style="text-align: center;background:lightgreen;"><strong>Canteen</strong></div>
                                        <div class="panel-body" style="background:#B8FBB8;">
                                            <div class="facilityImageDiv" style="width:100%;">
                                                <img id="facilityImage_Canteen" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                                <input type="hidden" id="facilityImageUrl_Canteen" 
                                                       value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_FACILITIES_NUM 
                                                              . "/" . _IMAGE_SCHOOL_CANTEEN_FILE_NAME; ?>">
                                            </div>
                                            <div class="facilityDescDiv">
                                                <p>As in any family or community, a school must have rules.</p><br>

                                                <p>These rules set the standard by which individuals within the school measure their relationships with others. They are based on experience and common sense as well as the traditions and changing needs of the school. Some do not need to be written down as they are part of the everyday life of the school, administered as a matter of course by the staff and the Headmaster.</p>

                                                <p>The school rules are intended as guidelines for pupils in their conduct and for the Headmaster and staff in the exercise of their authority.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="panel panel-default" style="min-height:100%;width:100%;">
                                        <div class="panel-heading" style="text-align: center;background:yellow;"><strong>Auditorium</strong></div>
                                        <div class="panel-body" style="background:#FFFFA9;">
                                            <div class="facilityImageDiv" style="width:100%;">
                                                <img id="facilityImage_Auditorium" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                                <input type="hidden" id="facilityImageUrl_Auditorium" 
                                                       value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_FACILITIES_NUM 
                                                              . "/" . _IMAGE_SCHOOL_AUDITORIUM_FILE_NAME; ?>">
                                            </div>
                                            <div class="facilityDescDiv">
                                                <p>As in any family or community, a school must have rules.</p><br>

                                                <p>These rules set the standard by which individuals within the school measure their relationships with others. They are based on experience and common sense as well as the traditions and changing needs of the school. Some do not need to be written down as they are part of the everyday life of the school, administered as a matter of course by the staff and the Headmaster.</p>

                                                <p>The school rules are intended as guidelines for pupils in their conduct and for the Headmaster and staff in the exercise of their authority.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="panel panel-default" style="min-height:100%;width:100%;">
                                        <div class="panel-heading light_background" style="text-align: center;"><strong>Laboratory</strong></div>
                                        <div class="panel-body" style="background:#CBE7F1;">
                                            <div class="facilityImageDiv" style="width:100%;">
                                                <img id="facilityImage_Laboratory" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                                <input type="hidden" id="facilityImageUrl_Laboratory" 
                                                       value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_FACILITIES_NUM 
                                                              . "/" . _IMAGE_SCHOOL_LABORATORY_FILE_NAME; ?>">
                                            </div>
                                            <div class="facilityDescDiv">
                                                <p>As in any family or community, a school must have rules.</p><br>

                                                <p>These rules set the standard by which individuals within the school measure their relationships with others. They are based on experience and common sense as well as the traditions and changing needs of the school. Some do not need to be written down as they are part of the everyday life of the school, administered as a matter of course by the staff and the Headmaster.</p>

                                                <p>The school rules are intended as guidelines for pupils in their conduct and for the Headmaster and staff in the exercise of their authority.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="panel panel-default" style="min-height:100%;width:100%;">
                                        <div class="panel-heading" style="text-align: center;background:lightcoral;"><strong>Computer Lab</strong></div>
                                        <div class="panel-body" style="background:#F99999;">
                                            <div class="facilityImageDiv" style="width:100%;">
                                                <img id="facilityImage_CompLab" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                                <input type="hidden" id="facilityImageUrl_CompLab" 
                                                       value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_FACILITIES_NUM 
                                                              . "/" . _IMAGE_SCHOOL_COMP_LAB_FILE_NAME; ?>">
                                            </div>
                                            <div class="facilityDescDiv">
                                                <p>As in any family or community, a school must have rules.</p><br>

                                                <p>These rules set the standard by which individuals within the school measure their relationships with others. They are based on experience and common sense as well as the traditions and changing needs of the school. Some do not need to be written down as they are part of the everyday life of the school, administered as a matter of course by the staff and the Headmaster.</p>

                                                <p>The school rules are intended as guidelines for pupils in their conduct and for the Headmaster and staff in the exercise of their authority.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="panel panel-default" style="min-height:100%;width:100%;">
                                        <div class="panel-heading" style="text-align: center;background:lightgreen;"><strong>Playground</strong></div>
                                        <div class="panel-body" style="background:#B8FBB8;">
                                            <div class="facilityImageDiv" style="width:100%;">
                                                <img id="facilityImage_Ground" 
                                                         class="img-rounded img-responsive" 
                                                         style="padding-bottom:20px;margin:0 auto;" alt="IMG">
                                                <input type="hidden" id="facilityImageUrl_Ground" 
                                                       value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_FACILITIES_NUM 
                                                              . "/" . _IMAGE_SCHOOL_GROUND_FILE_NAME; ?>">
                                            </div>
                                            <div class="facilityDescDiv">
                                                <p>As in any family or community, a school must have rules.</p><br>

                                                <p>These rules set the standard by which individuals within the school measure their relationships with others. They are based on experience and common sense as well as the traditions and changing needs of the school. Some do not need to be written down as they are part of the everyday life of the school, administered as a matter of course by the staff and the Headmaster.</p>

                                                <p>The school rules are intended as guidelines for pupils in their conduct and for the Headmaster and staff in the exercise of their authority.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
                 <div id="notificationModal" class="modal fade" role="dialog" style="height:100%;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                                <h4 class="modal-title" id="notificationTitle"><strong></strong></h4>
                            </div>
                            <div class="modal-body" id="notificationModalContent">
                                <img id="notificationContentImage" class="img-rounded img-responsive" style="padding-bottom:20px;" alt="">
                                <p id="notificationContentText" style="width:100%;word-wrap:break-word;"></p>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
            <?php 
                $displayData = array();
                $this->load->view('common/footer', $displayData);
            ?>
        </div>
        <!-- Load JS -->
        <script type="text/javascript" src="/public/js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="/public/js/basic.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>