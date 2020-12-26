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
                
                date_default_timezone_set("Asia/Calcutta");
                $calendar_start_obj = date_create($calendar_start);
                //$calendar_start_cal = date_format($calendar_start_obj,"Ymd");
                $calendar_start_text = date_format($calendar_start_obj,"d M, Y");
                
                $calendar_end_obj = date_create($calendar_end);
                //$calendar_end_cal = date_format($calendar_end_obj,"Ymd");
                $calendar_end_text = date_format($calendar_end_obj,"d M, Y");
            ?>
            <div class="container-fluid" style="margin:0px;"> <!--  padding:15px; -->
                <?php if( $header_message != "" ){ ?>
                    <div class="row">
                        <div id="alert" class="col-sm-6 col-sm-offset-3 alert-div" align="center;"> <!--margin-left:25%;margin-right:25%;-->
                            <p class="alert-text-ps"><?php echo $header_message; ?></p>
                        </div>
                    </div>
                <?php } ?>
                <div class="panel panel-default" style="width:100%;margin-top:15px;"> <!-- height:100%; -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div style="text-align:right;">
                                    <span class="btn btn-default btn-file" onclick="expandOrCollapse();" id="expandOrCollapse"
                                          data-toggle="tooltip" data-placement="left" title="Collapse All" >
                                        <span class="glyphicon glyphicon-minus" id="expOrColGlyph"></span>
                                        <!-- <input type="button" name="expandOrCollapse" id="expandOrCollapse" value="Expand All"> -->
                                    </span>
                                </div>
                                <div class="panel panel-default" style="border-radius:0px;">
                                    <div class="panel-group" id="accordion">
                                        <?php 
                                            $i=0;
                                            foreach( $month_wise_event_array as $month => $eventArray ){ ?>
                                                <div class="panel panel-default" style="border-radius:0px;"><!-- #F99999; -->
                                                    <div class="panel-heading cursor-point light_background" data-toggle="collapse"
                                                          data-parent="#accordion" data-target="#collapse<?php echo $i; ?>">
                                                      <h4 class="panel-title">
                                                         <strong><?php echo $month; ?></strong>
                                                      </h4>
                                                    </div>
                                                    <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse in">
                                                        <div class="panel-body" style="background: white;">
                                                            <table class="table table-hover table-responsive table-bordered"
                                                                   style="margin:0;">
                                                                <colgroup>
                                                                    <col style="width:35%;">
                                                                    <col style="width:65%;">
                                                                </colgroup>
                                                            <?php  foreach( $eventArray as $day => $details ){ ?>
                                                                <!-- '<p style="text-align:center;margin:0;">' + cal_content_array[i]['from_date'] + '</p>' +
                                "<p style='text-align:center;margin:0;'>TO</p><p style='text-align:center;margin:0;'>" + 
                                    cal_content_array[i]['to_date']  + '</p>'; -->
                                                                <tr>
                                                                    <td class="light_background" style="vertical-align:middle;">
                                                                        <strong>
                                                                            <?php 
                                                                                if( $details['from_date'] == $details['to_date'] ){
                                                                                    echo '<p style="text-align:center;margin:0;">' .
                                                                                        date_format( date_create( $details['from_date'] ),"d M, Y") .
                                                                                        '</p>';
                                                                                } else { 
                                                                                    echo '<p style="text-align:center;margin:0;">' . 
                                                                                            date_format( date_create( $details['from_date'] ),"d M, Y") . 
                                                                                          '</p>' .
                                                                                            "<p style='text-align:center;margin:0;'>TO</p>" . 
                                                                                            "<p style='text-align:center;margin:0;'>" .
                                                                                            date_format( date_create( $details['to_date'] ),"d M, Y") .
                                                                                            "</p>"; 
                                                                                }
                                                                            ?>
                                                                        </strong>
                                                                    </td>
                                                                    <td style="background: aliceblue; vertical-align:middle;"> <!-- beige -->
                                                                        <p style="margin:0;text-align:center;font-weight:bold;">
                                                                            <a href="#" data-toggle="modal" data-target="#schoolCalendarModal"
                                                                               id="calEventID_<?php echo $details['calendar_item_id'];?>">
                                                                               <?php echo $details['short_desc'];?>
                                                                            </a>
                                                                        </p>
                                                                        <input type="hidden" id="calEventShortDesc_<?php echo $details['calendar_item_id'];?>"
                                                                               value="<?php echo $details['short_desc'];?>" >
                                                                        <input type="hidden" id="calEventDesc_<?php echo $details['calendar_item_id'];?>"
                                                                               value="<?php echo $details['description'];?>" > 
                                                                        <input type="hidden" id="calEventFromDate_<?php echo $details['calendar_item_id'];?>"
                                                                               value="<?php echo $details['from_date'];?>" >
                                                                        <input type="hidden" id="calEventToDate_<?php echo $details['calendar_item_id'];?>"
                                                                               value="<?php echo $details['to_date'];?>" >
                                                                        <input type="hidden" id="calEventType_<?php echo $details['calendar_item_id'];?>"
                                                                               value="<?php echo $details['item_type'];?>" >
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                  </div>
                                        <?php 
                                            $i++;
                                            } ?>
                                      </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <span><strong>Calendar Period</strong><span><br>
                                                <input type="hidden" id="fromCalPeriod" value="<?php echo $calendar_start_text; ?>" >
                                                <input type="hidden" id="toCalPeriod" value="<?php echo $calendar_end_text; ?>" >
                                                <span style="color:#337ab7;font-size:small;" id="calendarPeriodText"><?php echo "From $calendar_start_text To $calendar_end_text" ?></span>
                                            </div>
                                            <div class="col-sm-6" style="text-align:right;">
                                                <span class="btn btn-default btn-file" data-toggle="collapse" data-target="#calendarPeriodBody">
                                                    <span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;&nbsp;Edit Period 
                                                    <!-- <input type="button" name="editCalendarPeriod" id="editCalendarPeriod"> -->
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body collapse" id="calendarPeriodBody">
                                        <form id="calendarPeriodForm" name="calendarPeriodForm">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group" id="fromCalendarPeriodDiv">
                                                        <label for="fromCalendarPeriod" class="control-label" >From</label>
                                                        <input class="form-control" type="text" name="fromCalendarPeriod" id="fromCalendarPeriod" 
                                                               value="<?php echo $calendar_start; ?>" 
                                                               onclick="javascript:NewCssCal('fromCalendarPeriod','yyyyMMdd','arrow',false,'12',false,'');">
                                                        <p id="fromCalendarPeriodMsg" class="inputAlert"></p>
                                                    </div>
                                                    <div class="form-group" id="toCalendarPeriodDiv">
                                                        <label for="toCalendarPeriod" class="control-label">To</label>
                                                        <input class="form-control" type="text" name="toCalendarPeriod" id="toCalendarPeriod" 
                                                               value="<?php echo $calendar_end; ?>" 
                                                               onclick="javascript:NewCssCal('toCalendarPeriod','yyyyMMdd','arrow',false,'12',false,'');">
                                                        <p id="toCalendarPeriodMsg" class="inputAlert"></p>
                                                    </div>
                                                    <div>
                                                        <input type="button" id="calendarPeriodSubmit" class="btn btn-primary"
                                                               value="SUBMIT" onclick="changeCalendarPeriod();">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" id="addOrEditCalEventHead">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <p style="margin:0; padding:0;" id="calEventTypeDesc"><strong>Add Calendar Event</strong></p> <!--  -->
                                            </div>
                                            <div class="col-sm-4" style="text-align:right;" id="calEventAddDiv">
                                                <!--<input type="button" id="addNewCalendarEvent" class="btn btn-default" 
                                                       value="Add New" onclick="calEventToggleToAdd();">-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="form-group" id="fromCalendarEventPeriodDiv">
                                                    <label for="fromCalendarEventPeriod" class="control-label">From</label>
                                                    <input class="form-control" type="text" name="fromCalendarEventPeriod" id="fromCalendarEventPeriod" value="" 
                                                           onclick="javascript:NewCssCal('fromCalendarEventPeriod','yyyyMMdd','arrow',false,'12',false,'');">
                                                    <!-- <br> -->
                                                    <p id="fromCalendarEventPeriodMsg" class="inputAlert">asd</p>
                                                </div>
                                                <div class="form-group" id="toCalendarEventPeriodDiv">
                                                    <label for="toCalendarEventPeriod" class="control-label">To</label>
                                                    <input class="form-control" type="text" name="toCalendarEventPeriod" id="toCalendarEventPeriod" value="" 
                                                           onclick="popupateFromVal();NewCssCal('toCalendarEventPeriod','yyyyMMdd','arrow',false,'12',false,'');">
                                                    <!-- <br> -->
                                                    <p id="toCalendarEventPeriodMsg" class="inputAlert">asdf</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="calendarEventTypeDiv">
                                            <lable for="calendarEventType" class="control-label"><strong>Event Type</strong></label>
                                            <select class="form-control" id="calendarEventType" name="calendarEventType">
                                                <option value="">Select</option>
                                                <option value="<?php echo _SCHOOL_CALENDAR_EVENT_TYPE_HOLIDAY ?>">Holiday</option>
                                                <option value="<?php echo _SCHOOL_CALENDAR_EVENT_TYPE_OTHER ?>">Event</option>
                                            </select>
                                            <!-- <br> -->
                                            <p id="calendarEventTypeMsg" class="inputAlert">asdf</p>
                                        </div>
                                        <div class="form-group" id="calendarEventNameDiv">
                                            <label for="calendarEventName" class="control-label">Event</label>
                                            <input class="form-control" type="text" name="calendarEventName" id="calendarEventName" 
                                                   value="" onblur="validateEventName();">
                                            <!-- <br> -->
                                            <p id="calendarEventNameMsg" class="inputAlert">asdf</p>
                                        </div>
                                        <div class="form-group" id="calendarEventDescriptionDiv">
                                            <label for="calendarEventDescription" class="control-label">Event Description</label>
                                            <textarea class="form-control" id="calendarEventDescription" name="calendarEventDescription" value="" rows="2" cols="30"></textarea>
                                            <!-- <br> -->
                                            <p id="calendarEventDescriptionMsg" class="inputAlert">asdf</p>
                                        </div>
                                        <div style="text-align:center;">
                                            <span class="btn btn-default btn-file" id="submitCalendarEvent" onclick="addCalEvent();">
                                                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;ADD&nbsp;&nbsp;
                                                <!-- <span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;EDIT&nbsp;&nbsp; -->
                                                <!-- <input type="button" name="editCalendarPeriod" id="editCalendarPeriod"> -->
                                            </span>
                                            <!-- <input type="button" id="submitCalendarEvent" class="btn btn-primary" value="ADD"> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="schoolCalendarModal" class="modal fade" role="dialog" style="height:100%;">
               <div class="modal-dialog modal-lg">
                   <div class="modal-content">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">&times;<small>CLOSE</small></button>
                           <h4 class="modal-title" id="schoolCalendarModalTitle">
                                <span class="glyphicon glyphicon-pencil"></span><strong>&nbsp;&nbsp;Edit Calendar Event</strong>
                                <input type="hidden" id="calendarEventID" value="">
                           </h4> <!-- <strong></strong> -->
                       </div>
                       <div class="modal-body" id="schoolCalendarModalContent">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group" id="fromCalendarEventPeriodEditDiv">
                                                <label for="fromCalendarEventPeriodEdit" class="control-label">From</label>
                                                <input class="form-control" type="text" name="fromCalendarEventPeriodEdit" id="fromCalendarEventPeriodEdit" value="" 
                                                       onclick="javascript:NewCssCal('fromCalendarEventPeriodEdit','yyyyMMdd','arrow',false,'12',false,'');">
                                                <p id="fromCalendarEventPeriodEditMsg" class="inputAlert">asdf</p>
                                            </div>
                                            <div class="form-group" id="toCalendarEventPeriodEditDiv">
                                                <label for="toCalendarEventPeriodEdit" class="control-label">To</label>
                                                <input class="form-control" type="text" name="toCalendarEventPeriodEdit" id="toCalendarEventPeriodEdit" value="" 
                                                       onclick="javascript:NewCssCal('toCalendarEventPeriodEdit','yyyyMMdd','arrow',false,'12',false,'');">
                                                <p id="toCalendarEventPeriodEditMsg" class="inputAlert">asdf</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="calendarEventTypeEditDiv">
                                        <lable for="calendarEventTypeEdit" class="control-label">Event Type</label>
                                        <select class="form-control" id="calendarEventTypeEdit" name="calendarEventTypeEdit">
                                            <option value="">Select</option>
                                            <option value="<?php echo _SCHOOL_CALENDAR_EVENT_TYPE_HOLIDAY ?>">Holiday</option>
                                            <option value="<?php echo _SCHOOL_CALENDAR_EVENT_TYPE_OTHER ?>">Event</option>
                                        </select>
                                        <p id="calendarEventTypeEditMsg" class="inputAlert">asdf</p>
                                    </div>
                                    <div class="form-group" id="calendarEventNameEditDiv">
                                        <label for="calendarEventNameEdit" class="control-label">Event</label>
                                        <input class="form-control" type="text" name="calendarEventNameEdit" id="calendarEventNameEdit" value="">
                                        <p id="calendarEventNameEditMsg" class="inputAlert">asdf</p>
                                    </div>
                                    <div class="form-group" id="calendarEventDescriptionEditDiv">
                                        <label for="calendarEventDescriptionEdit" class="control-label">Event Description</label>
                                        <textarea class="form-control" id="calendarEventDescriptionEdit" name="calendarEventDescriptionEdit" value="" rows="2" cols="30">
                                            </textarea>
                                    </div>
                                    <div style="text-align:center;">
                                        <span class="btn btn-primary btn-file" id="submitCalendarEvent" onclick="editCalEvent();">
                                            &nbsp;&nbsp;SUBMIT&nbsp;&nbsp;
                                        </span>
                                    </div>
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