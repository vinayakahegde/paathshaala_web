<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body onload="inboxOnLoad();">
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
            ?>
            <div class="container-fluid" style="margin:0px;"> <!--  padding:15px; -->
                <?php if( isset($header_message) && $header_message != "" ){ ?>
                    <div class="row">
                        <div id="alert" class="col-sm-6 col-sm-offset-3 alert-div" align="center;"> <!--margin-left:25%;margin-right:25%;-->
                            <p class="alert-text-ps"><?php echo $header_message; ?></p>
                        </div>
                    </div>
                <?php } ?>
                <div class="panel panel-default" style="width:100%;height:100%;margin-top:15px;">
                    <div class="panel-body" style="width:100%;">
                        <div class="row">
                            <div class="col-sm-2" style="text-align: left;">
                                <!--<div class="panel panel-default">
                                    <div class="panel-body" style="text-align: center;">-->
                                <br><br>
                                <?php if( $user_type == _USER_TYPE_SCHOOL || $user_type == _USER_TYPE_TEACHER ){ ?>
                                <button type="button" class="btn btn-sm btn-primary" style="width:100%;padding:10px;" 
                                        id="newMsg" name="newMsg" data-toggle="modal" data-target="#newMessageModal" 
                                        data-backdrop="static" data-keyboard="true">
                                    <span class="glyphicon glyphicon-pencil"></span> <strong>&nbsp;&nbsp;&nbsp;NEW MESSAGE</strong>
                                </button>
                                <?php } else { ?>
                                <button type="button" class="btn btn-sm btn-info" style="width:100%;padding:10px;" 
                                        id="askPrincipal" name="askPrincipal" data-toggle="modal" data-target="#newMessageModal" 
                                        data-backdrop="static" data-keyboard="true">
                                    <span class="glyphicon glyphicon-pencil"></span> <strong>&nbsp;&nbsp;&nbsp;ASK PRINCIPAL</strong>
                                </button>
                                <br><br>
                                <button type="button" class="btn btn-sm btn-warning" style="width:100%;padding:10px;" 
                                        id="askTeacher" name="askTeacher" data-toggle="modal" data-target="#newMessageModal" 
                                        data-backdrop="static" data-keyboard="true">
                                    <span class="glyphicon glyphicon-pencil"></span> <strong>&nbsp;&nbsp;&nbsp;ASK TEACHER</strong>
                                </button>
                                <?php } ?>
                                <!-- <input type="button" id="newMsg" name="newMsg" value="New Message" class="btn btn-danger"> -->
                                <br><br>
                                        <table class="table-bordered table-responsive" style="width:100%;">
                                            <tr>
                                                <td>
                                                    <button class="btn btn-default" type="button" id="inbox_btn"
                                                            style="width:100%;border-radius:0;text-align: left;"
                                                            onclick="getInboxContent( 'inbox', '1', '', '' );" >
                                                        <span id="inbox_span">Inbox</span> 
                                                        <span class="badge" id="inbox_num" 
                                                            <?php if( $inbox_count == "" ){
                                                                echo ' style="display:none;" ';
                                                            }
                                                            ?>>
                                                            <?php 
                                                                if( isset($inbox_count) && $inbox_count != "" ){
                                                                    echo $inbox_count;
                                                                }
                                                            ?>
                                                        </span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <button class="btn btn-default" type="button" id="unread_btn"
                                                            style="width:100%;border-radius:0;text-align: left;"
                                                            onclick="getInboxContent( 'unread', '1', '', '' );">
                                                        <span id="unread_span">Unread</span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <button class="btn btn-default" type="button" id="read_btn"
                                                            style="width:100%;border-radius:0;text-align: left;"
                                                            onclick="getInboxContent( 'read', '1', '', '' );" >
                                                        <span id="read_span">Read</span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <button class="btn btn-default" type="button" id="important_btn"
                                                            style="width:100%;border-radius:0;text-align: left;"
                                                            onclick="getInboxContent( 'important', '1', '', '' );" >
                                                        <span id="important_span">Important</span> 
                                                        <span class="badge" id="important_num"
                                                            <?php if( $inbox_important_count == "" ){
                                                                echo ' style="display:none;" ';
                                                            }
                                                            ?>>
                                                            <?php 
                                                                if( isset($inbox_important_count) && $inbox_important_count != "" ){
                                                                    echo $inbox_important_count;
                                                                }
                                                            ?>
                                                        </span>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <button class="btn btn-default" type="button" id="sent_btn"
                                                            style="width:100%;border-radius:0;text-align: left;"
                                                            onclick="getInboxContent( 'sent', '1', '', '' );">
                                                        <span id="sent_span">Sent</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                <!--    </div>
                                </div> -->
                            </div>
                            <div class="col-sm-10">
                                <!-- <div class="panel panel-default" style="min-height:400px;"> -->
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="row inbox_search">
                                            <div class="col-sm-2" style="padding-right:0px;display:block;" id="searchMailTxtDiv">
                                                <p style="margin:0px; padding-top:7px;"><strong>SEARCH MAIL</strong></p>
                                            </div>
                                            <?php if( $user_type != _USER_TYPE_PARENT ){ ?>
                                            <div class="col-sm-3" id="searchFromDiv" style="display:block;">
                                                <div>
                                                    <button id="searchFrom" class="btn btn-default" data-toggle="modal" 
                                                            data-target="#selectPersonModal" data-backdrop="static" data-keyboard="true">
                                                        Select Sender
                                                    </button>
                                                </div>
                                            </div>
                                            <?php } else { ?>
                                            <div class="col-sm-3" id="searchFromDiv" style="visibility:hidden;">
                                                <div>
                                                    <button id="searchFrom" class="btn btn-default" data-toggle="modal" 
                                                            data-target="#selectPersonModal" data-backdrop="static" data-keyboard="true">
                                                        Select Sender
                                                    </button>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            
                                            <div class="col-sm-5" id="searchedUnameDiv" style="display:none;">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><strong id="search_uname_desc">From&nbsp;</strong></span>
                                                    <p class="form-control" id="selected_search_uname">Venkataramana...</p>
                                                    <!-- <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)"> -->
                                                    <span class="input-group-addon" onclick="removeInboxSearchFrom();" style="cursor:pointer;">
                                                        <span class="glyphicon glyphicon-remove"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div>
                                                    <input type="text" id="searchTextDisp" class="form-control" value="" 
                                                           placeholder="Contains Text....">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button id="doSearch" class="btn btn-primary" onclick="doInboxSearch();">
                                                    <span class="glyphicon glyphicon-search"></span>&nbsp;SEARCH
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="row" style="margin-top:6px;">
                                            <div class="col-sm-5" style="text-align: center;">
                                                <button id="prevPage" class="btn btn-default" style="width:100%;" onclick="getPreviousInboxPage();">
                                                    <strong><span class="glyphicon glyphicon-menu-left"></span>&nbsp;PREV</strong>
                                                </button>
                                            </div>
                                            <div class="col-sm-2" style="text-align: center;margin-top:7px;font-weight: bold;" id="page_num">
                                                
                                            </div>
                                            <div class="col-sm-5" style="text-align: center;">
                                                <button id="nextPage" class="btn btn-default" style="width:100%;" onclick="getNextInboxPage();">
                                                    <strong>NEXT&nbsp;<span class="glyphicon glyphicon-menu-right"></span></strong>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="searchCriteria" style="display:none;">
                                    <p id="searchCriteriaTxt" style="background: #ffffe0;text-align: center;">
                                        <span style="background: #eeeeee;"><strong>&nbsp;&nbsp;SEARCH CRITERIA&nbsp;&nbsp;</strong></span>
                                        Sent by : <strong>Venkataramana Hegde</strong>, Mail contains : <strong>"hello"</strong>
                                    </p>
                                </div>
                                <div class="table-responsive" style="min-height:400px;">
                                    <input type="hidden" id="current_inbox_type" value="">
                                    <input type="hidden" id="current_page_num" value="">
                                    <input type="hidden" id="current_page_size" value="">
                                    <input type="hidden" id="search_user_id" value="">
                                    <input type="hidden" id="search_text" value="">
                                    <input type="hidden" id="search_text_max_len" value="<?php echo _INBOX_SEARCH_TEXT_MAX_LENGTH; ?>">
                                    <input type="hidden" id="inbox_default_page_size" value="<?php echo _INBOX_PAGE_SIZE; ?>">
                                    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered" 
                                           id="inboxContentTable" name="inboxContentTable" >
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="newMessageModal" class="modal fade" role="dialog" style="height:100%;">
                <div class="modal-dialog modal-lg"> <!--  modal-lg -->
                    <div class="modal-content">
                        <div class="modal-header light_background" style="border-bottom:0;">
                            <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                            <h4 class="modal-title" id="newMessageTitle" style="text-align:center;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;COMPOSE NEW MESSAGE</strong></h4>
                        </div>
                        <div class="modal-body" id="newMessageContent">
                            <div class="form-group" id="message_to_div">
                                <span><label for="message_to">TO</label>
                                <!-- <input type="text" id="message_to" name="message_to" class="form-control" value=""> -->
                                <?php if( $user_type == _USER_TYPE_SCHOOL || $user_type == _USER_TYPE_TEACHER ){ ?>
                                <input type="button" id="select_to_btn" name="select_to_btn" 
                                       class="btn btn-warning" style="margin-left:10px;" value="SELECT PERSON"
                                       data-toggle="modal" data-target="#selectPersonModal"
                                       data-backdrop="static" data-keyboard="true">
                                <?php } else { ?>
                                <input type="hidden" id="to_message_id" name="to_message_id" value="<?php echo _SCHOOL_USER_ID; ?>">
                                <input type="hidden" id="to_teacher_id" name="to_teacher_id" value="">
                                <select id="select_teacher" name="select_teacher" class="form-control" style="display:none;">
                                    <option value="">Select</option>
                                    <?php for( $i=0; $i < count($teacherList); $i++ ){ ?>
                                        <option value="<?php echo $teacherList[$i]['user_id']?>">
                                            <?php echo $teacherList[$i]['teacher_name'] . " [ " . 
                                                        $teacherList[$i]['subject_name'] . " ]"; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <p id="principal_name_fld" name="principal_name_fld" style="display:none;">Principal</p>
                                <?php } ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="message_subject">SUBJECT</label>
                                <input type="text" id="message_subject" name="message_subject" 
                                       class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="message_to">MESSAGE</label>
                                <textarea id="message_content" name="message_content" 
                                    class="form-control" value="" rows="8"></textarea>
                            </div>
                            <div class="form-group" style="text-align: center;">
                                <input type="button" id="send_message" name="send_message" value="SEND" 
                                       class="btn btn-primary" onclick="sendMessage();">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="selectPersonModal" class="modal fade" role="dialog" style="height:100%;"><!-- z-index:1400; -->
                <div class="modal-dialog modal-lg"> <!--  modal-lg -->
                    <div class="modal-content">
                        <!-- <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                        </div> -->
                        <div class="modal-body">
                            <input type="hidden" id="selection_type_id" value="">
                            <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="panel panel-default">
                                    <div class="panel-body">
                                    <!-- <form id="studentNameSearchForm" name="studentNameSearchForm" action="/inbox_search" method="post"> -->
                                        <div class="form-group">
                                                <label for="studentNameSearch">Student Name</label>
                                                <span style="color:lightcoral;">&nbsp;&nbsp;( * Enter part or whole name )</span>
                                                <div class="dropdown">
                                                    <input type="text" id="studentNameSearch" class="form-control" autocomplete="off"
                                                           name="studentNameSearch" onkeyup="showMatchingStudentNames();"
                                                           value="">
                                                    <input type="hidden" id="student_dropdown_1" value="">
                                                    <input type="hidden" id="student_dropdown_2" value="">
                                                    <input type="hidden" id="student_dropdown_3" value="">
                                                    <input type="hidden" id="student_dropdown_4" value="">
                                                    <ul class="dropdown-menu" id="dropDownStudentList" onmouseover="displayDropDownStudentList();"
                                                        style="width:100%;display:none;" onmouseout="hideDropDownStudentList();"><!-- aria-labelledby="dropdownMenu1" -->
                                                      <li><a href="#" id="dropdown_opt1" onclick="populateStudentSearchName(1);">Action</a></li>
                                                      <li><a href="#" id="dropdown_opt2" onclick="populateStudentSearchName(2);">Another action</a></li>
                                                      <li><a href="#" id="dropdown_opt3" onclick="populateStudentSearchName(3);">Something else here</a></li>
                                                      <li><a href="#" id="dropdown_opt4" onclick="populateStudentSearchName(4);">Something else here</a></li>
                                                    </ul>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label for="studentParentNameSearch">Parent Name</label>
                                                <span style="color:lightcoral;">&nbsp;&nbsp;( * Enter part or whole name )</span>
                                                <div class="dropdown">
                                                    <input type="text" id="studentParentNameSearch" class="form-control" autocomplete="off"
                                                           name="studentParentNameSearch" onkeyup="showMatchingParentNames();"
                                                           value="">
                                                    <input type="hidden" id="student_parent_dropdown_1" value="">
                                                    <input type="hidden" id="student_parent_dropdown_2" value="">
                                                    <input type="hidden" id="student_parent_dropdown_3" value="">
                                                    <input type="hidden" id="student_parent_dropdown_4" value="">
                                                    <ul class="dropdown-menu" id="dropDownStudentParentList" onmouseover="displayDropDownParentList();"
                                                        style="width:100%;display:none;" onmouseout="hideDropDownParentList();"><!-- aria-labelledby="dropdownMenu1" -->
                                                      <li><a href="#" id="dropdown_p_opt1" onclick="populateParentSearchName(1);">Action</a></li>
                                                      <li><a href="#" id="dropdown_p_opt2" onclick="populateParentSearchName(2);">Another action</a></li>
                                                      <li><a href="#" id="dropdown_p_opt3" onclick="populateParentSearchName(3);">Something else here</a></li>
                                                      <li><a href="#" id="dropdown_p_opt4" onclick="populateParentSearchName(4);">Something else here</a></li>
                                                    </ul>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                            <br>
                                            <input type="button" id="studentNameSearchSubmit" class="form-control btn btn-primary" 
                                                   name="studentNameSearchSubmit" value="SEARCH" onclick="searchByName();">
                                        </div>
                                    <!-- </form> -->
                                    <div class="row">
                                        <div class="panel panel-default" id="studentDetailSearchDiv" style="margin:0;border-radius:0 !important">
                                            <div class="panel panel-heading light_background" style="margin:0;border-radius:0 !important;">
                                                <p style="text-align:center;margin:0;"><strong>DETAIL SEARCH</strong></p>
                                            </div>
                                            <div class="panel-body">
                                                <!-- <form id="studentSearchForm" name="studentSearchForm" action="/inbox_search" method="post"> -->
                                                <div class="form-group">
                                                    <label for="studentClassSearch">Class</label>
                                                    <select class="form-control" id="studentClassSearch" 
                                                            name="studentClassSearch" onchange="populateStudentSections();"> <!--   -->
                                                            <option value="">Select</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_PLAY_HOME ?>" >Play Home</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_PRE_KG ?>" >Pre-KG</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_LKG ?>" >LKG</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_UKG ?>" >UKG</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_CLASS_1 ?>" >Class I</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_CLASS_2 ?>" >Class II</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_CLASS_3 ?>" >Class III</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_CLASS_4 ?>" >Class IV</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_CLASS_5 ?>" >Class V</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_CLASS_6 ?>" >Class VI</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_CLASS_7 ?>" >Class VII</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_CLASS_8 ?>" >Class VIII</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_CLASS_9 ?>" >Class IX</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_CLASS_10 ?>" >Class X</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_CLASS_11 ?>" >Class XI</option>
                                                            <option value="<?php echo _ADMISSION_APPLY_CLASS_12 ?>" >Class XII</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" id="classArray" name="classArray"
                                                           value='<?php if( isset($classes) ) echo $classes; ?>'>
                                                    <label for="studentSectionSearch">Section</label>
                                                    <select class="form-control" id="studentSectionSearch" name="studentSectionSearch">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="studentRollNoEntered">Roll Number</label>
                                                    <input type="text" id="studentRollNoEntered" name="studentRollNoEntered" class="form-control" 
                                                           value="">
                                                </div>
                                                <div class="form-group">
                                                    <br>
                                                    <input type="button" id="studentSearch" class="form-control btn btn-primary" 
                                                           name="studentSearch" value="SEARCH" onclick="searchByDetails();">
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                    </div>
                                    </div>
                                </div>
                                <div class="col-sm-7" style="height:500px; overflow-y: scroll;" id="searchContentDiv">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div id="showMessageModal" class="modal fade" role="dialog" style="height:100%;">
                <div class="modal-dialog modal-lg"> <!--  modal-lg -->
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom:0;"> <!-- style="background:lightblue;" -->
                            <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                            <h4 class="modal-title" id="showMessageTitle" style="text-align:center;">Sample Subject</h4>
                        </div>
                        <div class="modal-body" id="showMessageContent">
                            <div id="messageContainer" style="height:400px;overflow-y:scroll;">
                                <input type="hidden" id="reply_to_user_id" value="">
                                <input type="hidden" id="selected_msg_id" value="">
                                <input type="hidden" id="selected_parent_msg_id" value="">
                                <input type="hidden" id="messageType" value="">
                                <input type="hidden" id="messagePageNum" value="">
                            <div id="replyMessageDiv" style="display:none;">
                                <strong>TO : </strong><p id="messageReplyTo"></p>
                                <textarea id="replyMessage" class="form-control" value="" rows="6"></textarea>
                            </div>
                            <table id="messageTable" class="table table-responsive" >
                            </table>
                            </div>
                            <div id="actionDiv" style="text-align: center;border-top:1px;">
                                <input type="button" class="btn btn-warning" value="REPLY"
                                       id="replyBtn" onclick="showReplyBox();">
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
        <script type="text/javascript" src="/public/js/messages.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>