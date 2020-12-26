<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME']); ?>/images/<?php 
        echo _IMAGE_SCHOOL_FAVICON_URL_NUM . "/" . _IMAGE_SCHOOL_FAVICON_FILE_NAME; ?>">
        <link rel="stylesheet" type="text/css" href="/public/css/basic.css">
        <link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css">
    </head>
    <body>
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
            <div class="container-fluid" style="margin:0px;"> <!--  padding:15px; -->
                <?php if( $header_message != "" ){ ?>
                    <div class="row">
                        <div id="alert" class="col-sm-6 col-sm-offset-3 alert-div" align="center;"> <!--margin-left:25%;margin-right:25%;-->
                            <p class="alert-text-ps"><?php echo $header_message; ?></p>
                        </div>
                    </div>
                <?php } ?>
                <div class="panel panel-default" style="width:100%;height:100%;margin-top:15px;">
                    <div class="panel-body" style="width:100%;">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form id="notificationSearchForm" name="notificationSearchForm" method="post" action="/notifications/1/<?php echo $pageSize; ?>">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="notificationPeriod">Notification Date</label>
                                                <select class="light_background form-control" id="notificationPeriod" name="notificationPeriod">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _TIME_PERIOD_ONE_WEEK ?>" 
                                                        <?php if(isset($notificationPeriod) && $notificationPeriod == _TIME_PERIOD_ONE_WEEK) echo "selected"; ?>>Since One Week</option>
                                                    <option value="<?php echo _TIME_PERIOD_TWO_WEEKS ?>" 
                                                        <?php if(isset($notificationPeriod) && $notificationPeriod == _TIME_PERIOD_TWO_WEEKS) echo "selected"; ?>>Since Two Weeks</option>
                                                    <option value="<?php echo _TIME_PERIOD_ONE_MONTH ?>" 
                                                        <?php if(isset($notificationPeriod) && $notificationPeriod == _TIME_PERIOD_ONE_MONTH) echo "selected"; ?>>Since One Month</option>
                                                    <option value="<?php echo _TIME_PERIOD_TWO_MONTHS ?>" 
                                                        <?php if(isset($notificationPeriod) && $notificationPeriod == _TIME_PERIOD_TWO_MONTHS) echo "selected"; ?>>Since Two Months</option>
                                                    <option value="<?php echo _TIME_PERIOD_THREE_MONTHS ?>" 
                                                        <?php if(isset($notificationPeriod) && $notificationPeriod == _TIME_PERIOD_THREE_MONTHS) echo "selected"; ?>>Since Three Months</option>
                                                    <option value="<?php echo _TIME_PERIOD_SIX_MONTHS ?>" 
                                                        <?php if(isset($notificationPeriod) && $notificationPeriod == _TIME_PERIOD_SIX_MONTHS) echo "selected"; ?>>Since Six Months</option>
                                                    <option value="<?php echo _TIME_PERIOD_NINE_MONTHS ?>" 
                                                        <?php if(isset($notificationPeriod) && $notificationPeriod == _TIME_PERIOD_NINE_MONTHS) echo "selected"; ?>>Since Nine Months</option>
                                                    <option value="<?php echo _TIME_PERIOD_ONE_YEAR ?>" 
                                                        <?php if(isset($notificationPeriod) && $notificationPeriod == _TIME_PERIOD_ONE_YEAR) echo "selected"; ?>>Since This Year</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="notificationStatus">Notification Status</label>
                                                <select class="light_background form-control" id="notificationStatus" name="notificationStatus">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_STATUS_ACTIVE ?>" 
                                                        <?php if(isset($notificationStatus) && $notificationStatus == _GENERAL_NOTIFICATION_STATUS_ACTIVE ) echo "selected"; ?>>Active</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_STATUS_DELETED ?>" 
                                                        <?php if(isset($notificationStatus) && $notificationStatus == _GENERAL_NOTIFICATION_STATUS_DELETED) echo "selected"; ?>>Deleted</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="notificationPriority">Notification Priority</label>
                                                <select class="light_background form-control" id="notificationPriority" name="notificationPriority">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_PRIORITY_0 ?>" 
                                                        <?php if(isset($notificationPriority) && $notificationPriority == _GENERAL_NOTIFICATION_PRIORITY_0) echo "selected"; ?>>Priority 0</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_PRIORITY_1 ?>" 
                                                        <?php if(isset($notificationPriority) && $notificationPriority == _GENERAL_NOTIFICATION_PRIORITY_1) echo "selected"; ?>>Priority 1</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_PRIORITY_2 ?>" 
                                                        <?php if(isset($notificationPriority) && $notificationPriority == _GENERAL_NOTIFICATION_PRIORITY_2) echo "selected"; ?>>Priority 2</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_PRIORITY_3 ?>" 
                                                        <?php if(isset($notificationPriority) && $notificationPriority == _GENERAL_NOTIFICATION_PRIORITY_3) echo "selected"; ?>>Priority 3</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_PRIORITY_4 ?>" 
                                                        <?php if(isset($notificationPriority) && $notificationPriority == _GENERAL_NOTIFICATION_PRIORITY_4) echo "selected"; ?>>Priority 4</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="notificationRemoveBy">Notification To Be Removed By</label>
                                                <select class="light_background form-control" id="notificationRemoveBy" name="notificationRemoveBy">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _TIME_PERIOD_ONE_WEEK ?>" 
                                                        <?php if(isset($notificationRemoveBy) && $notificationRemoveBy == _TIME_PERIOD_ONE_WEEK) echo "selected"; ?>>One Week</option>
                                                    <option value="<?php echo _TIME_PERIOD_TWO_WEEKS ?>" 
                                                        <?php if(isset($notificationRemoveBy) && $notificationRemoveBy == _TIME_PERIOD_TWO_WEEKS) echo "selected"; ?>>Two Weeks</option>
                                                    <option value="<?php echo _TIME_PERIOD_ONE_MONTH ?>" 
                                                        <?php if(isset($notificationRemoveBy) && $notificationRemoveBy == _TIME_PERIOD_ONE_MONTH) echo "selected"; ?>>One Month</option>
                                                    <option value="<?php echo _TIME_PERIOD_TWO_MONTHS ?>" 
                                                        <?php if(isset($notificationRemoveBy) && $notificationRemoveBy == _TIME_PERIOD_TWO_MONTHS) echo "selected"; ?>>Two Months</option>
                                                    <option value="<?php echo _TIME_PERIOD_THREE_MONTHS ?>" 
                                                        <?php if(isset($notificationRemoveBy) && $notificationRemoveBy == _TIME_PERIOD_THREE_MONTHS) echo "selected"; ?>>Three Months</option>
                                                    <option value="<?php echo _TIME_PERIOD_SIX_MONTHS ?>" 
                                                        <?php if(isset($notificationRemoveBy) && $notificationRemoveBy == _TIME_PERIOD_SIX_MONTHS) echo "selected"; ?>>Six Months</option>
                                                    <option value="<?php echo _TIME_PERIOD_NINE_MONTHS ?>" 
                                                        <?php if(isset($notificationRemoveBy) && $notificationRemoveBy == _TIME_PERIOD_NINE_MONTHS) echo "selected"; ?>>Nine Months</option>
                                                    <option value="<?php echo _TIME_PERIOD_ONE_YEAR ?>" 
                                                        <?php if(isset($notificationRemoveBy) && $notificationRemoveBy == _TIME_PERIOD_ONE_YEAR) echo "selected"; ?>>This Year</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="notificationType">Notification Type</label>
                                                <select class="light_background form-control" id="notificationType" name="notificationType">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_GENERAL ?>" 
                                                        <?php if(isset($notificationType) && $notificationType == _GENERAL_NOTIFICATION_GENERAL) echo "selected"; ?>>General</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_EVENT ?>" 
                                                        <?php if(isset($notificationType) && $notificationType == _GENERAL_NOTIFICATION_EVENT) echo "selected"; ?>>Event</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_ADMISSION ?>" 
                                                        <?php if(isset($notificationType) && $notificationType == _GENERAL_NOTIFICATION_ADMISSION) echo "selected"; ?>>Admission</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_STUDENT ?>" 
                                                        <?php if(isset($notificationType) && $notificationType == _GENERAL_NOTIFICATION_STUDENT) echo "selected"; ?>>Student</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_OTHER ?>" 
                                                        <?php if(isset($notificationType) && $notificationType == _GENERAL_NOTIFICATION_OTHER) echo "selected"; ?>>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="notificationDisplayOnHome">Display Notification On Home</label>
                                                <select class="light_background form-control" id="notificationDisplayOnHome" name="notificationDisplayOnHome">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_DISPLAY_ON_HOME_YES ?>" 
                                                        <?php if(isset($notificationDisplayOnHome) && $notificationDisplayOnHome == _GENERAL_NOTIFICATION_DISPLAY_ON_HOME_YES) echo "selected"; ?>>Yes</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_DISPLAY_ON_HOME_NO ?>" 
                                                        <?php if(isset($notificationDisplayOnHome) && $notificationDisplayOnHome == _GENERAL_NOTIFICATION_DISPLAY_ON_HOME_NO) echo "selected"; ?>>No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <br>
                                            <button type="button" class="btn btn-default" style="width:100%;" 
                                                    id="btnAddNotif" name="btnAddNotif" data-toggle="modal" data-target="#notificationModalEdit" >
                                                <span class="glyphicon glyphicon-plus"></span> <strong>&nbsp;&nbsp;&nbsp;Add Notification</strong>
                                            </button>
                                            <!-- <input type="button" id="btnAddNotif" name="btnAddNotif" value="Add Notification" 
                                                   class="btn btn-default" style="width:100%;font-weight:bold;" onclick="showGeneralNotificationPopup();"> -->
                                            
                                        </div>
                                        <div class="col-sm-4">
                                        </div>
                                        <div class="col-sm-4">
                                            <br>
                                            <input type="submit" id="btnSearch" name="btnSearch" value="Search" 
                                                   class="btn btn-primary" style="width:100%;font-weight:bold;">
                                            <!-- <input type="submit" id="btnSearch" name="btnSearch" value="Search" 
                                                   class="btn btn-primary" style="width:100%;font-weight:bold;"> -->
                                        </div>
                                    </div>               
                                </form>
                            </div>
                        </div>
                        <?php 
                            $limitStart = ( ($pageNo-1) * $pageSize ) + 1;
                            $limitEnd   = ( $notificationCount > ($pageNo * $pageSize) ) ? $pageNo * $pageSize : $notificationCount; 
                            $statusLabel = "notifications";                
                        ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <p style="text-align:center;color:#337ab7;"><?php echo "Showing ".$limitStart."-".$limitEnd." of ".$notificationCount." ".$statusLabel; ?></p>
                            </div> 
                            <div class="col-sm-4" style="text-align:center;">
                                <a href="#" title="First Page" onclick="goToFirstPage('notifications','notificationSearchForm', 
                                            <?php echo $pageSize; ?>);" style="font-size:16px;">&lt;&lt;</a>&nbsp;&nbsp;&nbsp;
                                <a href="#" title="Previous Page" onclick="goToPrevPage('notifications','notificationSearchForm',
                                            <?php echo $pageNo; ?>, <?php echo $pageSize; ?> );" style="font-size:16px;">&lt;</a>
                                &nbsp;&nbsp;&nbsp;<strong>Page No :</strong>&nbsp;
                                <input type="text" id="pageNo" name="pageNo" value="<?php echo $pageNo; ?>" 
                                       style="width:25px;border-radius:3px;" onkeyup="handlePageNoKeyPress(event,'notificationSearchForm', 'notifications',
                                                            '<?php echo $pageSize;?>', '<?php echo $notificationCount;?>');">&nbsp;&nbsp;&nbsp;
                                <a href="#" title="Next Page" onclick="goToNextPage('notifications','notificationSearchForm',
                                            <?php echo $pageNo; ?>, <?php echo $pageSize; ?>, <?php echo $notificationCount; ?>);" style="font-size:16px;">&gt;</a>&nbsp;&nbsp;&nbsp;
                                <a href="#" title="Last Page" onclick="goToLastPage('notifications','notificationSearchForm',
                                            <?php echo $pageSize; ?>, <?php echo $notificationCount; ?>);" style="font-size:16px;">&gt;&gt;</a>
                            </div> 
                            <div class="col-sm-4" style="text-align:center;padding-bottom:10px;">
                                <!-- <button type="button" class="btn btn-default btn-sm" name="exportReport" id="exportReport"
                                        onclick="exportReportsData(1, <?= $notificationCount?>);" style="width:100px;">
                                    <span class="glyphicon glyphicon-download-alt"></span> <strong>Export</strong>
                                </button> -->
                            </div>
                        </div>
                      <div class="panel panel-default">
                          <div class="panel-body">
                              <div class="table-responsive">
                                    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered table-striped" >
                                      <colgroup>                
                                        <col style="width:2%;">
                                        <col style="width:5%;">
                                        <col style="width:10%;">
                                        <col style="width:40%;">
                                        <col style="width:5%;">
                                        <col style="width:3%;">
                                        <col style="width:10%;">
                                        <col style="width:10%;">
                                        <col style="width:5%;">
                                        <col style="width:10%;">
                                    </colgroup>
                                    <tr style="background:#337ab7;">
                                        <th style="padding-left:3px;border-bottom:1px solid #CCCBCA;text-align:center;"></th>
                                        <th style="padding-left:3px;border-bottom:1px solid #CCCBCA;text-align:center;">ID</th>
                                        <th style="padding-left:3px;border-bottom:1px solid #CCCBCA;text-align:center;">Type</th>
                                        <th style="border-bottom:1px solid #CCCBCA;text-align:center;">Notification</th>
                                        <th style="border-bottom:1px solid #CCCBCA;text-align:center;">On Home</th>
                                        <th style="border-bottom:1px solid #CCCBCA;text-align:center;">Notification Priority</th>
                                        <th style="border-bottom:1px solid #CCCBCA;text-align:center;">Created On</th>
                                        <th style="border-bottom:1px solid #CCCBCA;text-align:center;">Remove By</th>
                                        <th style="border-bottom:1px solid #CCCBCA;text-align:center;">Status</th>
                                        <th style="border-bottom:1px solid #CCCBCA;text-align:center;">Action</th>
                                    </tr>
                                      <?php 
                                        for( $i = 0; $i < count($notificationDetails); $i++ ){
                                    ?>
                                    <tr>
                                        <td style="text-align: center;"><input type="checkbox" name="notification_<?php echo $notificationDetails[$i]['notification_id']; ?>" 
                                                   id="notification_<?php echo $notificationDetails[$i]['notification_id']; ?>" 
                                                   value="<?php echo $notificationDetails[$i]['notification_id']; ?>"
                                                   onchange="updateNotificationSelectedCount();" ></td>
                                        <td style="text-align: center;">
                                            <?php echo $notificationDetails[$i]['notification_id']; ?>
                                            <input type="hidden" id="notification_text_<?php echo $notificationDetails[$i]['notification_id']; ?>"
                                                   value="<?php echo escapeString($notificationDetails[$i]['notification_text']); ?>">
                                            <input type="hidden" id="notification_heading_<?php echo $notificationDetails[$i]['notification_id']; ?>"
                                                   value="<?php echo escapeString($notificationDetails[$i]['notification_heading']); ?>">
                                            <input type="hidden" id="notification_remove_by_<?php echo $notificationDetails[$i]['notification_id']; ?>"
                                                   value="<?php echo escapeString($notificationDetails[$i]['remove_by']); ?>">
                                            <input type="hidden" id="notification_type_<?php echo $notificationDetails[$i]['notification_id']; ?>"
                                                   value="<?php echo escapeString($notificationDetails[$i]['notification_type']); ?>">
                                            <input type="hidden" id="notification_priority_<?php echo $notificationDetails[$i]['notification_id']; ?>"
                                                   value="<?php echo escapeString($notificationDetails[$i]['priority']); ?>">
                                            <input type="hidden" id="notification_on_home_<?php echo $notificationDetails[$i]['notification_id']; ?>"
                                                   value="<?php echo escapeString($notificationDetails[$i]['on_home_id']); ?>">
                                            <input type="hidden" id="img_url_<?php echo trim($notificationDetails[$i]['notification_id']);?>"
                                                   value="<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . trim($_SERVER['SERVER_NAME']) : "http://" . trim($_SERVER['SERVER_NAME'])) . _IMAGE_URL . "/" . _IMAGE_SCHOOL_NOTIFICATION_NUM 
                                                           . "/" . trim($notificationDetails[$i]['notification_image_name']); ?>" >
                                        </td>
                                        <td style="text-align: center;"><?php echo $notificationDetails[$i]['type']; ?></td>
                                        <td style="text-align: center;"><?php echo $notificationDetails[$i]['notification_heading']; ?></td>
                                        <td style="text-align: center;"><?php echo $notificationDetails[$i]['on_home']; ?></td>
                                        <td style="text-align: center;"><?php echo $notificationDetails[$i]['priority_text']; ?></td>
                                        <td style="text-align: center;"><?php echo $notificationDetails[$i]['created_at']; ?></td>
                                        <td style="text-align: center;"><?php echo $notificationDetails[$i]['remove_by_text']; ?></td>
                                        <td style="text-align: center;"><?php echo $notificationDetails[$i]['status_text']; ?></td>
                                        <td style="text-align: center;">
                                            <?php if( $notificationDetails[$i]['status'] == _GENERAL_NOTIFICATION_STATUS_ACTIVE ){ ?>
                                                <input type='button' value='Edit' data-toggle="modal" data-target="#notificationModalEdit" 
                                                       id="notification_mod_<?php echo $notificationDetails[$i]['notification_id']; ?>" 
                                                       class="btn btn-default" style="color: darkgreen;" >
                                                <input type='button' value='Delete' class="btn btn-default" style="margin-top:5px; color: darkred;"
                                                       onclick='deleteGeneralNotification(<?php echo $notificationDetails[$i]['notification_id']; ?> );' >
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>  
                                </table>
                              </div>
                              <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <p id="selectedNotifications"></p><br>
                                            <input id="notificationActionSubmit" name="notificationActionSubmit" class="btn btn-primary"
                                                   type="button" value="Delete Notifications" onclick="deleteGeneralNotificationBulk();">
                                        </div>
                                    </div>
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
            <div id="notificationModalEdit" class="modal fade" role="dialog" style="height:100%;">
               <div class="modal-dialog modal-lg">
                   <div class="modal-content">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                           <h4 class="modal-title" id="notificationTitle"></h4> <!-- <strong></strong> -->
                       </div>
                       <div class="modal-body" id="notificationModalContent">
                           <div class="panel panel-default">
                            <div class="panel-body">
                                <form id="notificationForm" name="notificationForm" action="/addOrUpdateNotification" enctype="multipart/form-data"
                                      method="post" onsubmit="return validateAndSubmitNotif();" >
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="editNotificationHeading">Notification Heading</label>
                                                <textarea class="form-control" id="editNotificationHeading" name="editNotificationHeading" value="" rows="2" cols="30">
                                                </textarea>
                                                <p id="editNotificationHeading_error" style="color:red;"></p>
                                                <input type="hidden" id="notificationID" name="notificationID" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="editNotificationText">Notification Text</label>
                                                <textarea class="form-control" id="editNotificationText" name="editNotificationText" value="" rows="4" cols="80">
                                                </textarea>
                                                <p id="editNotificationText_error" style="color:red;"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="editNotificationType">Notification Type</label>
                                                <select class="light_background form-control" id="editNotificationType" name="editNotificationType">
                                                        <option value="">Select</option>
                                                        <option value="<?php echo _GENERAL_NOTIFICATION_GENERAL; ?>">General</option>
                                                        <option value="<?php echo _GENERAL_NOTIFICATION_EVENT; ?>">Event</option>
                                                        <option value="<?php echo _GENERAL_NOTIFICATION_ADMISSION; ?>">Admission</option>
                                                        <option value="<?php echo _GENERAL_NOTIFICATION_STUDENT; ?>">Student</option>
                                                        <option value="<?php echo _GENERAL_NOTIFICATION_OTHER; ?>">Other</option>
                                                </select> 
                                                <p id="editNotificationType_error" style="color:red;"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="editNotificationPriority">Notification Priority</label>
                                                <select class="light_background form-control" id="editNotificationPriority" name="editNotificationPriority">
                                                    <option value="">Select</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_PRIORITY_0 ?>">Priority 0</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_PRIORITY_1 ?>">Priority 1</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_PRIORITY_2 ?>">Priority 2</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_PRIORITY_3 ?>">Priority 3</option>
                                                    <option value="<?php echo _GENERAL_NOTIFICATION_PRIORITY_4 ?>">Priority 4</option>
                                                </select>
                                                <p id="editNotificationPriority_error" style="color:red;"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="editRemoveNotif">Notification Remove By</label>
                                                <!-- style="width:100px;" -->
                                                    <span>
                                                        <input class="form-control" type="text" name="editRemoveNotif" id="editRemoveNotif" value="" 
                                                                  onclick="javascript:NewCssCal('editRemoveNotif','yyyyMMdd','arrow',false,'12',false,'');">
                                                    </span>
                                                    <p id="editRemoveNotif_error" style="color:red;"></p>
                                                
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="editDisplayOnHome">Display Notification On Home</label>
                                                <span>
                                                    <select class="light_background form-control" id="editDisplayOnHome" name="editDisplayOnHome">
                                                        <option value="">Select</option>
                                                        <option value="<?php echo _GENERAL_NOTIFICATION_DISPLAY_ON_HOME_YES ?>">Yes</option>
                                                        <option value="<?php echo _GENERAL_NOTIFICATION_DISPLAY_ON_HOME_NO ?>">No</option>
                                                    </select>
                                                </span>
                                                <p id="editDisplayOnHome_error" style="color:red;"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="editNotificationImage">Notification Image</label><br>
                                            <img id="editNotificationImage" class="img-rounded img-responsive"
                                                 style="padding-bottom:20px;margin:0 auto;" alt="NO IMAGE">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="editNotificationImageUpload">Change Notification Image</label><br>
                                            <input type="file" name="editNotificationImageUpload" id="editNotificationImageUpload">
                                            <!--<span class="btn btn-default btn-file">
                                                <span class="glyphicon glyphicon-upload"></span>&nbsp;&nbsp;&nbsp;Upload Image 
                                                <input type="file" name="editNotificationImageUpload" id="editNotificationImageUpload">
                                            </span>
                                            <!-- <input type="file" name="editNotificationImageUpload" id="editNotificationImageUpload">
                                            <p id="editRemoveNotif_error" style="color:red;"></p> -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                        </div>
                                        <div class="col-sm-6">
                                            <br>
                                            <input type="submit" id="editNotificationSubmit" name="editNotificationSubmit" 
                                                   class="btn btn-primary" value="Submit" style="width:100%;">
                                        </div>
                                        <div class="col-sm-3">
                                        </div>
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
        <script type="text/javascript" src="/public/js/school.js"></script>
        <script type="text/javascript" src="/public/js/datetimepicker_css.js"></script>
        <script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
    </body>
</html>