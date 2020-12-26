var _PAATHSHAALA_CUSTOM_DELIMITER = '$&&$';
var base_url = $('#base_url').val();
var _TEACHER_PIC_BASE_URL = base_url + '/images/6/';
var _DUMMY_TEACHER_ID = 11;
var _DUMMY_SUBJECT_ID = -1;
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

$('#applicationModal').on('show.bs.modal', function(e) { 
    var invoker_id = $(e.relatedTarget).attr("id");
    var application_id = invoker_id.split("_");
    application_id = application_id[1].trim();
    
    $('#applicationID').html( application_id );
    $('#studentName').html( $('#student_name_' + application_id).val() );
    $('#forClass').html( $('#class_desc_' + application_id).val() );
    $('#fatherName').html( $('#father_name_' + application_id).val() );
    $('#fatherQualification').html( $('#father_qual_' + application_id).val() );
    $('#motherName').html( $('#mother_name_' + application_id).val() );
    $('#motherQualification').html( $('#mother_qual_' + application_id).val() );
    $('#incomeLevel').html( $('#income_desc_' + application_id).val() );
    $('#motherTongue').html( $('#language_' + application_id).val() );
    $('#phoneNum').html( $('#phone_' + application_id).val() );
    $('#emailID').html( $('#email_id_' + application_id).val() );
    $('#appliedOn').html( $('#applied_at_' + application_id).val() );
    $('#applicationStatusPopup').html( $('#status_' + application_id).val() );
                                                             
    $('#applicationTitle').html( '<strong>' + $('#student_name_' + application_id).val() + '</strong>' );
});

$('#applicationModal').on('hidden.bs.modal', function() {
    $('#applicationID').html("");
    $('#studentName').html("");
    $('#forClass').html("");
    $('#fatherName').html("");
    $('#fatherQualification').html("");
    $('#motherName').html("");
    $('#motherQualification').html("");
    $('#incomeLevel').html("");
    $('#motherTongue').html("");
    $('#phoneNum').html("");
    $('#emailID').html("");
    $('#appliedOn').html("");
    $('#applicationStatusPopup').html("");
                                                             
    $('#applicationTitle').html("");
});

$('#notificationModalEdit').on('show.bs.modal', function(e) { 
    var invoker_id = $(e.relatedTarget).attr("id");
    var notification_id = invoker_id.split("_");
    if( notification_id.length > 1 ){
        notification_id = notification_id[2].trim();

        $('#editNotificationHeading').html( $('#notification_heading_' + notification_id).val() );
        $('#editNotificationText').html( $('#notification_text_' + notification_id).val() );
        $('#editNotificationType').val( $('#notification_type_' + notification_id).val() );
        $('#editNotificationPriority').val( $('#notification_priority_' + notification_id).val() );
        $('#editRemoveNotif').val( $('#notification_remove_by_' + notification_id).val() );
        $('#editDisplayOnHome').val( $('#notification_on_home_' + notification_id).val() );
        $('#notificationID').val( notification_id );
        var url = $('#img_url_' + notification_id ).val();
        var elementId = "editNotificationImage";
        if( url.trim() != "" ){
            loadImage( elementId, url );
        }

        $('#notificationTitle').html( '<strong>Notification ID : ' + notification_id + '</strong>' );
    } else {
        $('#editNotificationHeading').html('');
        $('#editNotificationText').html('');
        $('#editNotificationType').val('');
        $('#editNotificationPriority').val('');
        $('#editRemoveNotif').val('');
        $('#editDisplayOnHome').val('');
        $('#notificationTitle').html( '<strong>New Notification</strong>' );
        
        $('#editNotificationText_error').html('');
        $('#editNotificationType_error').html('');
        $('#editNotificationPriority_error').html('');
        $('#editNotificationHeading_error').html('');
        $('#editDisplayOnHome_error').html('');
    }
});

$('#notificationModalEdit').on('hidden.bs.modal', function() {
    $('#editNotificationHeading').html();
    $('#editNotificationText').html();
    $('#editNotificationType').val("");
    $('#editNotificationPriority').val("");
    $('#editRemoveNotif').val("");
    $('#editDisplayOnHome').val("");
    $('#notificationTitle').html("");
    closewin("editRemoveNotif"); 
    stopSpin();
});

$('#schoolCalendarModal').on('show.bs.modal', function(e) {
    var invoker_id = $(e.relatedTarget).attr("id");//calEventID_
    var calEventID = invoker_id.split("_");
    calEventID = calEventID[1];
    
    $('#fromCalendarEventPeriodEdit').val( $('#calEventFromDate_' + calEventID).val() );
    $('#toCalendarEventPeriodEdit').val( $('#calEventToDate_' + calEventID).val() );
    $('#calendarEventTypeEdit').val( $('#calEventType_' + calEventID).val() );
    $('#calendarEventNameEdit').val( $('#calEventShortDesc_' + calEventID).val() );
    $('#calendarEventDescriptionEdit').val( $('#calEventDesc_' + calEventID).val() );
    $('#calendarEventID').val( calEventID );
    
    $('#fromCalendarEventPeriodEditDiv').removeClass("has-error has-feedback");
    $('#fromCalendarEventPeriodEditMsg').css("display","none");
    $('#fromCalendarEventPeriodEditMsg').html("");
    $('#toCalendarEventPeriodEditDiv').removeClass("has-error has-feedback");
    $('#toCalendarEventPeriodEditMsg').css("display","none");
    $('#toCalendarEventPeriodEditMsg').html("");
    $('#calendarEventTypeEditDiv').removeClass("has-error has-feedback");
    $('#calendarEventTypeEditMsg').css("display","none");
    $('#calendarEventTypeEditMsg').html("");
    $('#calendarEventNameEditDiv').removeClass("has-error has-feedback");
    $('#calendarEventNameEditMsg').css("display","none");
    $('#calendarEventNameEditMsg').html("");
});

$('#schoolCalendarModal').on('hidden.bs.modal', function() {
    $('#fromCalendarEventPeriodEdit').val('');
    $('#toCalendarEventPeriodEdit').val('');
    $('#calendarEventTypeEdit').val('');
    $('#calendarEventNameEdit').val('');
    $('#calendarEventDescriptionEdit').val('');
    //$('#myModal').modal('hide');
});

/*$('#accordionAction').on('click', function ( action ) {
    $('#accordion .panel-collapse').collapse( action );
});*/

$('#addTeacherModal').on('show.bs.modal', function(e) { 
    $('#addedSubjects').val('');
    $('#addedSubjectsDiv').html('');
    $('#addTeacherFirstName').val('');
    $('#addTeacherMiddleName').val('');
    $('#addTeacherLastName').val('');
    $('#addTeacherAddress').val('');
    $('#addTeacherPincode').val('');
    $('#addTeacherPhone').val('');
    $('#addTeacherEmail').val('');
    $('#addTeacherTwitter').val('');
    $('#addTeacherBlog').val('');
    $('#addTeacherDateOfBirth').val('');
    $('#addTeacherDateOfJoining').val('');
    $('#addTeacherExperience').val('');
    $('#addTeacherQualification').val('');
    $('#addTeacherSubject').val('');
    
    $( "p[id$='Msg']" ).each(function( index ){
        $( this ).css("display","none");
        $( this ).html("");
    });    
    $( "div[id$='Div'][id^=addTeacher]" ).each(function( index ){
        $( this ).removeClass("has-error has-feedback");
    });
});

$('#addTeacherModal').on('hidden.bs.modal', function() {
    $('#addedSubjects').val('');
    $('#addedSubjectsDiv').html('');
    $('#addTeacherFirstName').val('');
    $('#addTeacherMiddleName').val('');
    $('#addTeacherLastName').val('');
    $('#addTeacherAddress').val('');
    $('#addTeacherPincode').val('');
    $('#addTeacherPhone').val('');
    $('#addTeacherEmail').val('');
    $('#addTeacherTwitter').val('');
    $('#addTeacherBlog').val('');
    $('#addTeacherDateOfBirth').val('');
    $('#addTeacherDateOfJoining').val('');
    $('#addTeacherExperience').val('');
    $('#addTeacherQualification').val('');
    $('#addTeacherSubject').val('');
    
    $( "p[id$='Msg']" ).each(function( index ){
        $( this ).css("display","none");
        $( this ).html("");
    });    
    $( "div[id$='Div'][id^=addTeacher]" ).each(function( index ){
        $( this ).removeClass("has-error has-feedback");
    });
});

function expandOrCollapse(){
    var tooltip_title = $('#expandOrCollapse').attr("title").trim();
    if( tooltip_title == "Expand All" ){// || tooltip_title == ""
        $('#expandOrCollapse').attr("title", "Collapse All");
        $('#expandOrCollapse').attr("data-original-title", "Collapse All");
        $('#expOrColGlyph').removeClass( "glyphicon-plus" );
        $('#expOrColGlyph').addClass( "glyphicon-minus" );
        $('#accordion .panel-collapse').collapse( 'show' );
    } else {
        $('#expandOrCollapse').attr("title", "Expand All");
        $('#expandOrCollapse').attr("data-original-title", "Expand All");
        $('#expOrColGlyph').removeClass( "glyphicon-minus" );
        $('#expOrColGlyph').addClass( "glyphicon-plus" );
        $('#accordion .panel-collapse').collapse( 'hide' );
    }
}

function loadImage( elementId, url ){
    var image = document.getElementById( elementId );
    var downloadingImage = new Image();
    downloadingImage.onload = function(){
        image.src = this.src;
    };
    downloadingImage.src = url;
}

function showGeneralNotificationPopup(){
    $('#notificationDetailsPopup').css("visibility", "visible");
    $('#editNotificationText').val('');
    $('#editNotificationType').val('');
    $('#editNotificationPriority').val('');
    $('#editRemoveNotif').val('');
    $('#editNotificationHeading').val('');
    $('#editDisplayOnHome').val('');
}

function editGeneralNotification( notification_id, priority_id, type_id, on_home_id ){
    $('#notificationDetailsPopup').css("visibility", "visible");
    $('#notificationID').val( notification_id );
    $('#editNotificationText').val( $('#notification_text_' + notification_id).val() );
    $('#editNotificationType').val(type_id);
    $('#editNotificationPriority').val(priority_id);
    $('#editRemoveNotif').val($('#notification_remove_by_' + notification_id).val());
    $('#editNotificationHeading').val($('#notification_heading_' + notification_id).val());
    $('#editDisplayOnHome').val(on_home_id);
}

function closeGeneralNotificationDetailsPopup(){
    $('#notificationDetailsPopup').css("visibility", "hidden");
    $('#editNotificationText').val('');
    $('#editNotificationType').val('');
    $('#editNotificationPriority').val('');
    $('#editRemoveNotif').val('');
    $('#editNotificationHeading').val('');
    $('#editDisplayOnHome').val('');
}

function validateAndSubmitNotif(){
    var notification_text = $('#editNotificationText').val().trim();
    var notification_type = $('#editNotificationType').val().trim();
    var notification_priority = $('#editNotificationPriority').val().trim();
    var notif_remove_by = $('#editRemoveNotif').val().trim();
    var notification_heading = $('#editNotificationHeading').val().trim();
    var notification_disp_home = $('#editDisplayOnHome').val().trim();
    
    $('#editNotificationText_error').html('');
    $('#editNotificationType_error').html('');
    $('#editNotificationPriority_error').html('');
    $('#editNotificationHeading_error').html('');
    $('#editDisplayOnHome_error').html('');
    
    var validNotification = true;
    
    if( notification_text == "" ){
        $('#editNotificationText_error').html('* Please enter a valid notification text');
        validNotification = false;
    }
    
    if( notification_type == "" ){
        $('#editNotificationType_error').html('* Please select a valid notification type');
        validNotification = false;
    }
    
    if( notification_priority == "" ){
        $('#editNotificationPriority_error').html('* Please select a valid notification priority');
        validNotification = false;
    }
    
    if( notif_remove_by == "" ){
        $('#editRemoveNotif_error').html('* Please select a remove by date for notification');
        validNotification = false;
    }
    
    if( notification_heading == "" ){
        $('#editNotificationHeading_error').html('* Please enter the notification heading');
        validNotification = false;
    }
    
    if( notification_disp_home == "" ){
        $('#editDisplayOnHome_error').html('* Please select if the notification needs to be on the home page');
        validNotification = false;
    }
    
    if( !validNotification ){
        alert( "Notification could not be added. ");
        return false;
    }
    
    //addOrUpdateNotification();
    return true;
}

function addOrUpdateNotification(){
    var notification_id = $('#notificationID').val().trim();
    var notification_text = $('#editNotificationText').val().trim();
    var notification_type = $('#editNotificationType').val().trim();
    var notification_priority = $('#editNotificationPriority').val().trim();
    var remove_notification_on = $('#editRemoveNotif').val().trim();
    var notification_heading = $('#editNotificationHeading').val().trim();
    var notification_disp_home = $('#editDisplayOnHome').val().trim();
    
    var url = '/addOrUpdateNotification';
    var datastring = 'notification_id='+notification_id + '&notification_text='+notification_text
                     + '&notification_type='+notification_type + '&notification_priority='+notification_priority
                     + '&remove_notification_on='+remove_notification_on + '&notification_heading='+notification_heading
                     + '&notification_disp_home=' + notification_disp_home;
             
    var notifUpdated = false;
    
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( responseText.indexOf("false") < 0 ){
                notifUpdated = true;
            }
        }
    });
    
    if( notifUpdated ){
        closeGeneralNotificationDetailsPopup();
        if( notification_id == "" )
            alert("Notification successfully added!");
        else
            alert("Notification successfully updated!");
        
        window.location.reload();
    } else {
        
    }
}

function deleteGeneralNotification( notification_id ){
    if( confirm("Delete the notification?") ){
        var url = '/deleteNotifications';
        var datastring = 'notification_ids='+notification_id;

        var notifDeleted = false;

        $.ajax({
            type : "POST",
            url : url,
            data : datastring,
            async : false,
            dataType: "json",
            success : function(responseText) {
                if( responseText.indexOf("false") < 0 ){
                    notifDeleted = true;
                }
            }
        });
        
        if( notifDeleted ){
            alert("Notification successfully deleted.");
            window.location.reload();
        } else {
            alert("Unable to delete notification");
        }
    }
}

function deleteGeneralNotificationBulk(){
    if( confirm("Delete the notifications?") ){
        var notificationIDs = "";
        $( "input[id^='notification_']" ).each(function( index ){
            if( $( this ).is(':checked') ){
                var notificationID = $( this ).val();
                notificationIDs = notificationIDs + ", " + notificationID.trim();
            }
        });

        notificationIDs = notificationIDs.substring(2, notificationIDs.length );
        
        var url = '/deleteNotifications';
        var datastring = 'notification_ids='+notificationIDs;

        var notifDeleted = false;

        $.ajax({
            type : "POST",
            url : url,
            data : datastring,
            async : false,
            dataType: "json",
            success : function(responseText) {
                if( responseText.indexOf("false") < 0 ){
                    notifDeleted = true;
                }
            }
        });
        
        if( notifDeleted ){
            alert("Notifications successfully deleted.");
            window.location.reload();
        } else {
            alert("Unable to delete notifications");
        }
    }
}

function updateNotificationSelectedCount(){
    var count = 0;
    var id = -1;
    $( "input[id^='notification_']" ).each(function( index ){
        if( $( this ).is(':checked') ){
            count++;
        }
    });
   
   $('#selectedNotifications').html( "You have selected " + count + " item/s." );
}

function updateApplicationSelectedCount(){
    var count = 0;
    var id = -1;
    $( "input[id^='application_']" ).each(function( index ){
        if( $( this ).is(':checked') ){
            count++;
        }
    });
   
   $('#selectedApplications').html( "You have selected " + count + " item/s." );
}

function goToFirstPage(url, formId, pageSize){
    var formElem     = document.getElementById(formId);
    formElem.action = "/"+url+"/1/"+pageSize;
    formElem.submit();
    return;
}

function goToPrevPage(url, formId, pageNo, pageSize ){
    var formElem     = document.getElementById(formId);
    var prevPageNo;

    if( pageNo <= 1 ) {
        prevPageNo = 1;
    }
    else {
        prevPageNo = pageNo - 1;
    }

    formElem.action = "/"+url+"/"+prevPageNo+"/"+pageSize;
    formElem.submit();

    return;
}

function goToNextPage( url, formId, pageNo, pageSize, recordCount ){
    var formElem     = document.getElementById(formId);
    var totalPages   = Math.ceil( recordCount/pageSize );

    var nextPageNo;

    if( pageNo === totalPages ) {
        nextPageNo = totalPages;
    }
    else {
        nextPageNo = pageNo + 1;
    }

    formElem.action = "/"+url+"/"+nextPageNo+"/"+pageSize;
    formElem.submit();

    return;
}

function goToLastPage(url, formId, pageSize, recordCount){
    var formElem     = document.getElementById(formId);
    var totalPages   = Math.ceil( recordCount/pageSize );

    formElem.action = "/"+url+"/"+totalPages+"/"+pageSize;
    formElem.submit();

    return;
}

function handlePageNoKeyPress(e, form_id, url, pageSize, recordCount){
    var pageNo = document.getElementById("pageNo").value;
    var totalPages = Math.ceil(recordCount/pageSize);
    e = e || window.event;
    if (e.keyCode == 13) {
        changePageNo( pageNo, form_id, url, totalPages, pageSize );
    }
}

function changePageNo( pageNo, form_id, url, totalPages, pageSize ){
    if( isNaN(pageNo) || pageNo < 1 ) {
            alert("Please enter a valid Page Number!");
            return;
    }
    if( parseInt(pageNo) > parseInt(totalPages) ) {
            alert("Page number is greater than the total number of pages!");
            return;
    }
    $("#" + form_id ).attr("action", "/" + url + "/" + pageNo + "/" + pageSize );
    $("#" + form_id ).submit();
    //window.location = "/"+url+"/"+pageNo+"/"+pageSize;
    return;
}

function changeCalendarPeriod(){
    var from_cal_period = $('#fromCalendarPeriod').val();
    var to_cal_period = $('#toCalendarPeriod').val();
    var validEvent = true;
    
    $('#fromCalendarPeriodDiv').removeClass("has-error has-feedback");
    $('#fromCalendarPeriodMsg').css("display","none");
    $('#fromCalendarPeriodMsg').html("");
    $('#toCalendarPeriodDiv').removeClass("has-error has-feedback");
    $('#toCalendarPeriodMsg').css("display","none");
    $('#toCalendarPeriodMsg').html("");
        
    if( from_cal_period == "" || !validateDate( from_cal_period, true ) ){
        $('#fromCalendarPeriodDiv').addClass("has-error has-feedback");
        $('#fromCalendarPeriodMsg').css("display","block");
        $('#fromCalendarPeriodMsg').html("    * Please enter a valid date( YYYY-MM-DD format )");
        validEvent = false;
    }
    if( to_cal_period == "" || !validateDate( to_cal_period, true ) ){
        $('#toCalendarPeriodDiv').addClass("has-error has-feedback");
        $('#toCalendarPeriodMsg').css("display","block");
        $('#toCalendarPeriodMsg').html("    * Please enter a valid date( YYYY-MM-DD format )");
        validEvent = false;
    }
    
    var fromEventDateObj = new Date( from_cal_period );
    var toEventDateObj   = new Date( to_cal_period );
    if( validEvent && toEventDateObj < fromEventDateObj ){
        $('#toCalendarPeriodDiv').addClass("has-error has-feedback");
        $('#toCalendarPeriodMsg').css("display","block");
        $('#toCalendarPeriodMsg').html("    * To date has to be greater than from date");
        validEvent = false;
    }
    
    if( !validEvent ){
        alert("Could not change calendar period");
        return;
    }
    var url = '/changeCalendarPeriod';
    var datastring = 'from_period=' + from_cal_period + "&to_period=" + to_cal_period;
    var success = false;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( responseText.indexOf("false") < 0 ){
                success = true;
                alert("Calendar period successfully changed!");
            } else {
                responseText = responseText.split("~~");
                responseText = responseText[1];
                alert("Could not change calendar period! \nError : " + responseText );
            }
        }
    });
    
    if( success ){
        var monthArr = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var from_cal_period_arr = from_cal_period.split("-");
        var to_cal_period_arr = to_cal_period.split("-");

        from_cal_period = from_cal_period_arr[2].trim() + " " + monthArr[ parseInt(from_cal_period_arr[1].trim()) - 1 ] + ", " + from_cal_period_arr[0].trim();
        to_cal_period = to_cal_period_arr[2].trim() + " " + monthArr[ parseInt(to_cal_period_arr[1].trim()) - 1 ] + ", " + to_cal_period_arr[0].trim();
        $('#calendarPeriodText').html( "From " + from_cal_period + " To " + to_cal_period );
        $('#calendarPeriodBody').collapse( 'hide' );
        window.location.reload();
    }    
}

function editCalEvent(){
    var from_event_date = $('#fromCalendarEventPeriodEdit').val().trim();//toCalendarEventPeriod
    var to_event_date = $('#toCalendarEventPeriodEdit').val().trim();
    var event_name = $('#calendarEventNameEdit').val().trim();
    var event_description = $('#calendarEventDescriptionEdit').val().trim();
    var event_type = $('#calendarEventTypeEdit').val().trim();
    var event_id = $('#calendarEventID').val().trim();
    var validEvent = true;
    
    $('#fromCalendarEventPeriodEditDiv').removeClass("has-error has-feedback");
    $('#fromCalendarEventPeriodEditMsg').css("display","none");
    $('#fromCalendarEventPeriodEditMsg').html("");
    $('#toCalendarEventPeriodEditDiv').removeClass("has-error has-feedback");
    $('#toCalendarEventPeriodEditMsg').css("display","none");
    $('#toCalendarEventPeriodEditMsg').html("");
    $('#calendarEventTypeEditDiv').removeClass("has-error has-feedback");
    $('#calendarEventTypeEditMsg').css("display","none");
    $('#calendarEventTypeEditMsg').html("");
    $('#calendarEventNameEditDiv').removeClass("has-error has-feedback");
    $('#calendarEventNameEditMsg').css("display","none");
    $('#calendarEventNameEditMsg').html("");
            
    if( from_event_date == "" || !validateDate( from_event_date, true ) ){
        $('#fromCalendarEventPeriodEditDiv').addClass("has-error has-feedback");
        $('#fromCalendarEventPeriodEditMsg').css("display","block");
        $('#fromCalendarEventPeriodEditMsg').html("    * Please enter a valid date( YYYY-MM-DD format )");
        validEvent = false;
    }
    if( to_event_date == "" || !validateDate( to_event_date, true ) ){
        $('#toCalendarEventPeriodEditDiv').addClass("has-error has-feedback");
        $('#toCalendarEventPeriodEditMsg').css("display","block");
        $('#toCalendarEventPeriodEditMsg').html("    * Please enter a valid date( YYYY-MM-DD format )");
        validEvent = false;
    }
    
    var fromEventDateObj = new Date( from_event_date );
    var toEventDateObj   = new Date( to_event_date );
    if( validEvent && toEventDateObj < fromEventDateObj ){
        $('#toCalendarEventPeriodEditDiv').addClass("has-error has-feedback");
        $('#toCalendarEventPeriodEditMsg').css("display","block");
        $('#toCalendarEventPeriodEditMsg').html("    * To date has to be greater than from date");
        validEvent = false;
    }
    
    if( event_type == "" ){
        $('#calendarEventTypeEditDiv').addClass("has-error has-feedback");
        $('#calendarEventTypeEditMsg').css("display","block");
        $('#calendarEventTypeEditMsg').html("    * Please selct a valid to event type");
        validEvent = false;
    }
    if( event_name == "" ){
        $('#calendarEventNameEditDiv').addClass("has-error has-feedback");
        $('#calendarEventNameEditMsg').css("display","block");
        $('#calendarEventNameEditMsg').html("    * Please enter a valid event name");
        validEvent = false;
    }
    
    if( validEvent ){
        var success = addOrEditCalEvent( from_event_date, to_event_date, event_name, event_description, event_type, event_id );
        if( success ){
            $('#fromCalendarEventPeriod').val('');
            $('#toCalendarEventPeriod').val('');
            $('#calendarEventType').val('');
            $('#calendarEventName').val('');
            $('#calendarEventDescription').val('');
            
            $('#fromCalendarEventPeriodEditDiv').removeClass("has-error has-feedback");
            $('#fromCalendarEventPeriodEditMsg').css("display","none");
            $('#fromCalendarEventPeriodEditMsg').html("");
            $('#toCalendarEventPeriodEditDiv').removeClass("has-error has-feedback");
            $('#toCalendarEventPeriodEditMsg').css("display","none");
            $('#toCalendarEventPeriodEditMsg').html("");
            $('#calendarEventTypeEditDiv').removeClass("has-error has-feedback");
            $('#calendarEventTypeEditMsg').css("display","none");
            $('#calendarEventTypeEditMsg').html("");
            $('#calendarEventNameEditDiv').removeClass("has-error has-feedback");
            $('#calendarEventNameEditMsg').css("display","none");
            $('#calendarEventNameEditMsg').html("");
            $('#schoolCalendarModal').modal('hide');
            window.location.reload();
        }
    } else {
        alert( "Could not add the event" );
    }
}

function addCalEvent(){
    var from_event_date = $('#fromCalendarEventPeriod').val().trim();
    var to_event_date = $('#toCalendarEventPeriod').val().trim();
    var event_name = $('#calendarEventName').val().trim();
    var event_description = $('#calendarEventDescription').val().trim();
    var event_type = $('#calendarEventType').val().trim();
    var event_id = -1;
    var validEvent = true;
    
    $('#fromCalendarEventPeriodDiv').removeClass("has-error has-feedback");
    $('#fromCalendarEventPeriodMsg').css("display","none");
    $('#fromCalendarEventPeriodMsg').html("");
    $('#toCalendarEventPeriodDiv').removeClass("has-error has-feedback");
    $('#toCalendarEventPeriodMsg').css("display","none");
    $('#toCalendarEventPeriodMsg').html("");
    $('#calendarEventNameDiv').removeClass("has-error has-feedback");
    $('#calendarEventNameMsg').css("display","none");
    $('#calendarEventNameMsg').html("");
    $('#calendarEventTypeDiv').removeClass("has-error has-feedback");
    $('#calendarEventTypeMsg').css("display","none");
    $('#calendarEventTypeMsg').html("");
            
    if( from_event_date == "" || !validateDate( from_event_date, true ) ){
        $('#fromCalendarEventPeriodDiv').addClass("has-error has-feedback");
        $('#fromCalendarEventPeriodMsg').css("display","block");
        $('#fromCalendarEventPeriodMsg').html("    * Please enter a valid date( YYYY-MM-DD format )");
        validEvent = false;
    }
    if( to_event_date == "" || !validateDate( to_event_date, true ) ){
        $('#toCalendarEventPeriodDiv').addClass("has-error has-feedback");
        $('#toCalendarEventPeriodMsg').css("display","block");
        $('#toCalendarEventPeriodMsg').html("    * Please enter a valid date( YYYY-MM-DD format )");
        validEvent = false;
    }
    
    var fromEventDateObj = new Date( from_event_date );
    var toEventDateObj   = new Date( to_event_date );
    if( validEvent && toEventDateObj < fromEventDateObj ){
        $('#toCalendarEventPeriodDiv').addClass("has-error has-feedback");
        $('#toCalendarEventPeriodMsg').css("display","block");
        $('#toCalendarEventPeriodMsg').html("    * To date has to be greater than from date");
        validEvent = false;
    }
    
    if( event_type == "" ){
        $('#calendarEventTypeDiv').addClass("has-error has-feedback");
        $('#calendarEventTypeMsg').css("display","block");
        $('#calendarEventTypeMsg').html("    * Please selct a valid to event type");
        validEvent = false;
    }
    if( event_name == "" ){
        $('#calendarEventNameDiv').addClass("has-error has-feedback");
        $('#calendarEventNameMsg').css("display","block");
        $('#calendarEventNameMsg').html("    * Please enter a valid event name");
        validEvent = false;
    }
    
    if( validEvent ){
        var success = addOrEditCalEvent( from_event_date, to_event_date, event_name, event_description, event_type, event_id );
        if( success ){
            $('#fromCalendarEventPeriod').val('');
            $('#toCalendarEventPeriod').val('');
            $('#calendarEventName').val('');
            $('#calendarEventDescription').val('');
            $('#calendarEventType').val('');
            
            $('#fromCalendarEventPeriodDiv').removeClass("has-error has-feedback");
            $('#fromCalendarEventPeriodMsg').css("display","none");
            $('#fromCalendarEventPeriodMsg').html("");
            $('#toCalendarEventPeriodDiv').removeClass("has-error has-feedback");
            $('#toCalendarEventPeriodMsg').css("display","none");
            $('#toCalendarEventPeriodMsg').html("");
            $('#calendarEventNameDiv').removeClass("has-error has-feedback");
            $('#calendarEventNameMsg').css("display","none");
            $('#calendarEventNameMsg').html("");
            $('#calendarEventTypeDiv').removeClass("has-error has-feedback");
            $('#calendarEventTypeMsg').css("display","none");
            $('#calendarEventTypeMsg').html("");
            window.location.reload();
        }
    } else {
        alert( "Could not add the event" );
    }
    
}
  
function validateEventName(){
    var event_name = $('#calendarEventName').val().trim();
    if( event_name == "" ){
        $('#calendarEventNameDiv').addClass("has-error has-feedback");
        $('#calendarEventNameMsg').css("display","block");
        $('#calendarEventNameMsg').html("    * Please enter event name");
    } else {
        $('#calendarEventNameDiv').removeClass("has-error has-feedback");
        $('#calendarEventNameMsg').css("display","none");
        $('#calendarEventNameMsg').html(""); 
    }
}

function validateDate( date, currentFlag ){
    var dateArr = date.split("-");
    if( dateArr.length != 3 ){
        return false;
    }
    
    var date_year = dateArr[0];
    var date_month = dateArr[1];
    var date_day = dateArr[2];
    
    if( isNaN( parseInt( date_year )) || isNaN( parseInt( date_month )) || isNaN( parseInt( date_day )) ){
        return false;
    }
    
    if( !currentFlag ){
        return true;
    }
    
    if( ( parseInt( date_year ) < 2015 ) || ( parseInt(date_month) > 12 ) || ( parseInt(date_month) < 0 )
            || ( parseInt( date_day ) > 31 ) || ( parseInt( date_day ) < 0 ) ){
        return false;
    }
    return true;
}

function addOrEditCalEvent( from_event_date, to_event_date, event_name, event_description, event_type, event_id ){                                          
    var success = false;    
    var url = '/addOrEditCalEvent';
    var datastring = 'from_event_date=' + from_event_date + '&to_event_date=' + to_event_date 
                    + '&event_name=' + event_name + '&event_description=' + event_description
                    + '&event_type=' + event_type + '&event_id=' + event_id;
    
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( responseText.indexOf("false") < 0 ){
                success = true;
                if( event_id == -1 ){
                    alert("Calendar event added successfully!");
                } else {
                    alert("Calendar event edited successfully!");
                }  
            } else {
                responseText = responseText.split("~~");
                responseText = responseText[1];
                if( event_id == -1 ){
                    alert("Could not add calendar event! \nError : " + responseText );
                } else {
                    alert("Could not edit calendar event! \nError : " + responseText );
                }
            }
        },
        error: function( exception ){
            //alert("exception : " + exception);
            console.log( exception );
        }
    });  
    
    return success;
}

function popupateFromVal(){
    $('#toCalendarEventPeriod').val( $('#fromCalendarEventPeriod').val().trim() );
}

function addSubject(){
    var addSubjectElem = document.getElementById("addTeacherSubject");
    var addedSubjectId = addSubjectElem.options[addSubjectElem.selectedIndex].value.trim();
    var addedSubjectText = addSubjectElem.options[addSubjectElem.selectedIndex].text.trim();
    
    var addedSubjects = $('#addedSubjects').val();
    addedSubjects = addedSubjects.split(',');
    for( var i=0; i < addedSubjects.length; i++ ){
        var subject_id = addedSubjects[i].trim();
        if( subject_id == addedSubjectId ){
            return;
        }
    }
    $('#addedSubjectsDiv').html( $('#addedSubjectsDiv').html() + 
                                        '<button class="btn btn-sm chosen_btn" id="subject_' + addedSubjectId + '"\n\
                                            onclick="removeSubject(\'' + addedSubjectId + '\')">' +
                                            '<span class="glyphicon glyphicon-remove"></span>' + 
                                            '<strong>&nbsp;' + addedSubjectText + '</strong>' +
                                        '</button>&nbsp;');
    
    if( $('#addedSubjects').val() == '' ){
        $('#addedSubjects').val( addedSubjectId );
    } else {
        $('#addedSubjects').val( $('#addedSubjects').val() + ', ' + addedSubjectId );
    }
    $('#addTeacherSubject').val('');
    //$('#addTeacherSubject').
}

function removeSubject( subject_id ){
    var addedSubjects = $('#addedSubjects').val();
    addedSubjects = addedSubjects.split(',');
    var modifiedAddedSubjects = '';
    for( var i=0; i < addedSubjects.length; i++ ){
        var subject_id_loop = addedSubjects[i].trim();
        if( subject_id_loop != subject_id ){
            if( modifiedAddedSubjects == '' ){
                modifiedAddedSubjects = subject_id_loop;
            } else {
                modifiedAddedSubjects = modifiedAddedSubjects + ", " + subject_id_loop;
            }
        }        
    }
    $('#addedSubjects').val( modifiedAddedSubjects );
    $( '#subject_' + subject_id ).remove();
}

function validateAddTeacherForm(){
    $( "p[id$='Msg']" ).each(function( index ){
        $( this ).css("display","none");
        $( this ).html("");
    });    
    $( "div[id$='Div'][id^=addTeacher]" ).each(function( index ){
        $( this ).removeClass("has-error has-feedback");
    });
    
    var firstName = $('#addTeacherFirstName').val().trim();
    var middleName = $('#addTeacherMiddleName').val().trim();
    var lastName = $('#addTeacherLastName').val().trim();
    var address = $('#addTeacherAddress').val().trim();
    var pincode = $('#addTeacherPincode').val().trim();
    var phone = $('#addTeacherPhone').val().trim();
    var email = $('#addTeacherEmail').val().trim();
    var twitter = $('#addTeacherTwitter').val().trim();
    var blog = $('#addTeacherBlog').val().trim();
    var date_of_birth = $('#addTeacherDateOfBirth').val().trim();
    var date_of_joining = $('#addTeacherDateOfJoining').val().trim();
    var experience = $('#addTeacherExperience').val().trim();
    var qualification = $('#addTeacherQualification').val().trim();
    var isValid = true;
    
    if( firstName == "" ){
        isValid = false;
        $('#addTeacherFirstNameDiv').addClass("has-error has-feedback");
        $('#addTeacherFirstNameMsg').css("display","inline");
        $('#addTeacherFirstNameMsg').html("* Please enter first name");
    }
    
    if( lastName == "" ){
        isValid = false;
        $('#addTeacherLastNameDiv').addClass("has-error has-feedback");
        $('#addTeacherLastNameMsg').css("display","inline");
        $('#addTeacherLastNameMsg').html("* Please enter last name");
    }
    
    if( address != "" && address.length < 10 ){
        isValid = false;
        $('#addTeacherAddressDiv').addClass("has-error has-feedback");
        $('#addTeacherAddressMsg').css("display","inline");
        $('#addTeacherAddressMsg').html("* Please enter a valid address");    
    }
    
    if( pincode != "" && ( pincode.length != 6 || !$.isNumeric(pincode) ) ){
        isValid = false;
        $('#addTeacherPincodeDiv').addClass("has-error has-feedback");
        $('#addTeacherPincodeMsg').css("display","inline");
        $('#addTeacherPincodeMsg').html("* Please enter a valid pincode");
    }
    
    if( phone == "" || ( phone.length < 10 || phone.length > 12 || !$.isNumeric( phone ) ) ){
        isValid = false;
        $('#addTeacherPhoneDiv').addClass("has-error has-feedback");
        $('#addTeacherPhoneMsg').css("display","inline");
        $('#addTeacherPhoneMsg').html("* Please enter a valid phone number");
    }
    
    if( date_of_birth != "" && !validateDate( date_of_birth, false ) ){
        isValid = false;
        $('#addTeacherDateOfBirthDiv').addClass("has-error has-feedback");
        $('#addTeacherDateOfBirthMsg').css("display","inline");
        $('#addTeacherDateOfBirthMsg').html("* Please enter a valid D.O.B");
    }
    
    if( date_of_joining == "" || !validateDate( date_of_joining, false ) ){
        isValid = false;
        $('#addTeacherDateOfJoiningDiv').addClass("has-error has-feedback");
        $('#addTeacherDateOfJoiningMsg').css("display","inline");
        $('#addTeacherDateOfJoiningMsg').html("* Please enter a valid joining date");
    }
    
    if( experience == "" ){
        isValid = false;
        $('#addTeacherExperienceDiv').addClass("has-error has-feedback");
        $('#addTeacherExperienceMsg').css("display","inline");
        $('#addTeacherExperienceMsg').html("* Please enter the experience");
    }
    
    if( qualification == "" ){
        isValid = false;
        $('#addTeacherQualificationDiv').addClass("has-error has-feedback");
        $('#addTeacherQualificationMsg').css("display","inline");
        $('#addTeacherQualificationMsg').html("* Please enter the qualification");
    }
    
    return isValid;    
}

function addPanelHighLight( panel_id ){
    $( '#' + panel_id ).addClass('panel-highlight');
}

function removePanelHighlight( panel_id ){
    $( '#' + panel_id ).removeClass('panel-highlight');
}

function teacherOnLoad(){
    $( "input[id^='teacher_pic_url_']" ).each(function( index ){
        var imageUrlId = $( this ).attr("id");
        var url = $( this ).val();
        var teacher_id = imageUrlId.split("_");
        teacher_id = teacher_id[3];
        
        loadImage( 'teacherImage_' + teacher_id, url );        
    });
    populateSections();
    $('#teacherSectionSearch').val( $('#selectedSection').val() );
}

function classesOnLoad(){
    $('#accordion .panel-collapse').collapse( 'hide' );
    $('#accordionDetail .panel-collapse').collapse( 'hide' );
    testCaching();
}

function populateSections(){
    var classConst = $('#teacherClassSearch' ).find(":selected").val();
    classConst = parseInt( classConst );
    var classArray = $('#classArray').val();
    classArray = jQuery.parseJSON(classArray);
    var sectionArray = classArray[classConst];
    console.log(sectionArray);
    var html = '<option value="">Select</option>';
    for( var i=0; i < sectionArray.length; i++ ){
        html += '<option value="' + sectionArray[i]['section'] + '" >' + sectionArray[i]['section'] + '</option>';
    }
    $('#teacherSectionSearch').html( html );
}

function populateClassDetails( class_id ){
    $('#classHeading').html( '<strong>' + $('#className_' + class_id ).val() + '</strong>' );
    var subjectTable = document.getElementById('subjectTable');
    while( subjectTable.rows.length > 1 ){
        subjectTable.deleteRow( -1 );
    }
    var teachingProgressTable = document.getElementById('teachingProgressTable');
    while( teachingProgressTable.rows.length > 1 ){
        teachingProgressTable.deleteRow( -1 );
    }
    var prevClassId = $('#editSubjectsClassId').val();
    $('#menuClassId_'+prevClassId).css("background", "white");
    var maxPeriods = parseInt($('#maxPeriods_' + class_id).val());
    var maxDays = parseInt($('#maxDays_' + class_id).val());
    createBlankTimeTable( maxPeriods, maxDays );
    var timetable;
    var classSubjects;
    var classSyllabus;
    var classesToSelectFrom;
    var url = '/classDetails';
    var datastring = 'class_id=' + class_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( typeof responseText == "string" && responseText.trim() == "false" ){
                return;
            }
            timetable = responseText.timetable;
            classSubjects = responseText.classSubjects;
            classSyllabus = responseText.classSyllabus;
            classesToSelectFrom = responseText.classesToSelectFrom;
            $('#classSyllabus').val( JSON.stringify(classSyllabus) );
            var optionsHtml = '<option value="">Select</option>';
            for( var i=0; i<classSubjects.length; i++ ){
                optionsHtml += '<option value="' + classSubjects[i][0] + '_' + classSubjects[i][2] + '">' 
                                    + classSubjects[i][1] + ' [' + classSubjects[i][2] + '] ' + '</option>';
            }
            $('#editTTSubjectSelect').html(optionsHtml);
            for( var i=0; i<timetable.length; i++ ){
                $('#tt_' + timetable[i]['day_id'] + '_' + timetable[i]['period_id'] ).html( timetable[i]['subject_short'] );
            }
        },
        error : function( exception ){
            console.log(exception);
        }
    });
    var subjects = $('#subjects_'+class_id).val();
    var subject_ids = $('#subject_ids_'+class_id).val();
    var teachers = $('#teachers_'+class_id).val();
    var subjects_short = $('#subjects_short_'+class_id).val();
    var teacherImages = $('#teacher_img_'+class_id).val();
    var teacherIds = $('#teacher_ids_'+class_id).val();
    var percent_complete = $('#percent_complete_'+class_id).val();
    subjects = subjects.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    subject_ids = subject_ids.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    teachers = teachers.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    subjects_short = subjects_short.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    teacherImages = teacherImages.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    teacherIds = teacherIds.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    percent_complete = percent_complete.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    var subjectHtml = '';
    for( var i=0; subjects != '' && i < subjects.length; i++ ){
        subjectHtml += '<tr><td class="subject_col">' + subjects[i] + ' [' + subjects_short[i] + '] ' +
                        '</td><td class="teacher_col">' + teachers[i] + 
                        '</td><td class="teacher_img_col"><input type="image" src="' + _TEACHER_PIC_BASE_URL + teacherImages[i] + '" alt="Image" ' +
                        'class="img-rounded img-responsive" height="50" width="50" onclick=getTeacherDetails(' + teacherIds[i] + ');></td></tr>';
    }
    var syllabusSubHtml = '';
    for( var i=0; subjects != '' && i < subjects.length; i++ ){
        syllabusSubHtml += '<tr><td class="subject_col">' + subjects[i] + '&nbsp; [' + subjects_short[i] + '] ' +
                        '</td><td class="progress_col">'+
                                '<div class="progress">'+
                                    '<div class="progress-bar" role="progressbar" aria-valuenow="' + percent_complete[i] + '"'+
                                        'aria-valuemin="0" aria-valuemax="100" style="width:' + percent_complete[i] + '%">' 
                                            + percent_complete[i] + '%</div>'+
                                    '</div></td>'+
                        '<td class="progress_action_col">'+
                                    '<input type="button" id="editSyllabusBtn_' + class_id + '_' + subject_ids[i] + 
                                           '" name="editSyllabusBtn_'+ class_id + '_' + subject_ids[i] + '" ' +
                                           'value="EDIT SYLLABUS" class="btn btn-warning" '+
                                           'data-toggle="modal" data-target="#editSyllabusModal">&nbsp;</td><td class="progress_import_col">';
                                   
                                   if( subject_ids[i] in classesToSelectFrom ){
                                       syllabusSubHtml += '<span title="Import from other sections" data-toggle="tooltip" data-placement="top">' +
                                            '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#syllabusImportModal" ' + 
                                                    ' id="importSyllabusBtn_'+ class_id + '_' + subject_ids[i] + '">'+
                                                    '<span class="glyphicon glyphicon-download-alt"></span>' + 
                                                   // '<strong>&nbsp;IMPORT&nbsp;&nbsp;</strong>' +
                                            '</button></span>'+
                                            '<input type="hidden" id="classesToSelFrom_'+ class_id + '_' + subject_ids[i] + '"'+
                                                    ' value=\'' + JSON.stringify( classesToSelectFrom[subject_ids[i]]) + '\'>';
                                   }
                                   
                        syllabusSubHtml += '</td></tr>';
    }
    $('#subjectTable tr:last').after(subjectHtml);
    $('#teachingProgressTable tr:last').after(syllabusSubHtml);
    $('#editSubjectsClassId').val(class_id);
    $('#menuClassId_'+class_id).css("background", "burlywood");
    if( $('#collapse_Students').hasClass("in") || $('#collapse_Students').hasClass("collapsing") ){
        populateStudentList();
    } else {
        clearStudentList();
    }
    /* if( $('#collapse_ClassForum').hasClass('in') ){
        populateSchoolClassFeed();
    } */
}

function createBlankTimeTable( maxPeriods, maxDays ){ 
var dayArray = ["MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN"];
var periodArray = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII" ];
var timetableHtml = '<div class="row" style="margin:20px;">'+
    '<div class="col-sm-offset-10">'+
        '<input type="button" id="editTimeTableBtn" name="editTimeTableBtn" ' +
               'class="btn btn-warning" value="EDIT TIMETABLE" onclick="toggleEditTimeTable( '+ maxPeriods + ', ' + maxDays + ');">' +
        '<br>' +
    '</div>' +
'</div>' +
'<div class="row" style="margin:0;">' +
    '<div class="col-sm-1" style="margin:0;padding:2px;"></div>' +
    '<div class="col-sm-1" style="margin:0;padding:2px;"></div>';
    
   for( var k=0; k < maxPeriods; k++ ){ 
    timetableHtml += '<div class="col-sm-1" style="margin:0;padding:2px;">' +
        '<div class="panel panel-default panel-date panel-period" id="tt_period_' + k + '_panel">' +
            '<div class="panel-body">' +
                '<p style="margin:0;text-align:center;" id="tt_period_' + k + '"><strong>' + periodArray[k] + '</strong></p>' +
            '</div>' +
        '</div>' +
    '</div>';
    }
    
timetableHtml += '</div>';

for( var j=0; j < maxDays; j++ ){
    timetableHtml += 
        '<div class="row" style="margin:0;">' +
            '<div class="col-sm-1" style="margin:0;padding:2px;"></div>' +
            '<div class="col-sm-1" style="margin:0;padding:2px;">' +
                '<div class="panel panel-default panel-date panel-day" id="tt_day_' + j + '_panel">' +
                    '<div class="panel-body">' +
                        '<p style="margin:0;text-align:center;" id="tt_day_' + j + '"><strong>' + dayArray[j] + '</strong></p>' +
                    '</div>' +
                '</div>' +
            '</div>';
            for( var i=0; i < maxPeriods; i++ ){
             timetableHtml += 
                '<div class="col-sm-1" style="margin:0;padding:2px;">' +
                    '<div class="panel panel-default panel-date" id="tt_' + j + '_' + i + '_panel" >' + 
                        '<div class="panel-body">' +
                            '<p style="margin:0;text-align:center;" id="tt_' + j + '_' + i + '">&nbsp;</p>' +
                            '<input type="hidden" id="tt_' + j + '_' + i + '_subject_id" value="">' +
                            '<input type="hidden" id="tt_' + j + '_' + i + '_teacher_id" value="">' +
                        '</div>' +
                    '</div>' +
                '</div>';
            }
timetableHtml += '</div>';
    }
    $('#timetable_body').html(timetableHtml);
}
$('#editSubjectsModal').on('show.bs.modal', function(e) { 
    var subjectEditTable = document.getElementById('subjectEditTable');
    while( subjectEditTable.rows.length > 1 ){
        subjectEditTable.deleteRow( -1 );
    }
    var class_id = $('#editSubjectsClassId').val();
    var subjects = $('#subjects_'+class_id).val();
    var subjects_short = $('#subjects_short_'+class_id).val();
    var teachers = $('#teachers_'+class_id).val();
    var subject_ids = $('#subject_ids_'+class_id).val();
    var teacher_ids = $('#teacher_ids_'+class_id).val();
    subjects = subjects.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    teachers = teachers.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    subject_ids = subject_ids.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    teacher_ids = teacher_ids.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    subjects_short = subjects_short.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    var subjectHtml = '';
    for( var i=0; subjects != '' && i < subjects.length; i++ ){
        subjectHtml += '<tr id="subRow_' + subject_ids[i] + '_' + class_id + '"><td class="subject_col">' + subjects[i] + 
                        ' [' + subjects_short[i] + '] ' +
                        '</td><td class="teacher_col" id="teacher_sub_' + subject_ids[i] + '_' + class_id + '"  >' + teachers[i] + 
                        '</td><td class="teacher_img_col"><input type="button" class="btn btn-sm btn-warning" value="Delete" onclick="deleteClassSubject(' + 
                                        subject_ids[i] + ', ' + class_id + ');">' + 
                        '<input type="button" class="btn btn-sm btn-info" value="Change Teacher" onclick="displayTeacherList(' +
                                        subject_ids[i] + ', ' + class_id + ');"></td></tr>';
    }
    $('#subjectEditTable tr:last').after(subjectHtml);    
});

function deleteClassSubject( subject_id, class_id  ){
    var url = '/deleteClassSubject';
    var datastring = 'class_id='+class_id+'&subject_id='+subject_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( responseText == 'true' ){
                $('#subRow_'+subject_id+'_'+class_id).remove();
            }
        }
    });
}

function displayTeacherList( subject_id, class_id ){
    var subject_id = parseInt(subject_id);
    var teacherListJson = $('#teacherList').val();
    var teacherList = JSON.parse( teacherListJson );
    var teacherSelectHtml = '<select class="form-control" id="subTeacherChg"><option value="">Select</option>';
    var teachersWithSameSub = [];
    var teachersWithDiffSub = [];
    var sameSubCnt = 0;
    var diffSubCnt = 0;
    for( var i=0; i < teacherList.length; i++ ){
        for( var j=1; j <= 20; j++ ){
            if( parseInt(teacherList[i]['s'+j]) == subject_id ){
                teachersWithSameSub[sameSubCnt] = [teacherList[i]['i'], teacherList[i]['f'], teacherList[i]['l']];
                sameSubCnt++;
                break;
            }
            if( j == 20){
                teachersWithDiffSub[diffSubCnt] = [teacherList[i]['i'], teacherList[i]['f'], teacherList[i]['l']]; 
                diffSubCnt++;
            }
        }
    }
    
    for( i=0; i < teachersWithSameSub.length; i++ ){
        teacherSelectHtml += '<option value="' + teachersWithSameSub[i][0] + '">' + 
                                    teachersWithSameSub[i][1] + ' ' + teachersWithSameSub[i][2] + 
                             '</option>';
    }
    for( i=0; i < teachersWithDiffSub.length; i++ ){
        teacherSelectHtml += '<option value="' + teachersWithDiffSub[i][0] + '">' + 
                                    teachersWithDiffSub[i][1] + ' ' + teachersWithDiffSub[i][2] + 
                             '</option>';
    }
    teacherSelectHtml += '</select><input type="button" class="btn btn-sm btn-info" value="Done" '+
                        'onclick="changeSubTeacher(' + subject_id + ', ' + class_id + ');">' +
                        '<input type="button" class="btn btn-sm btn-warning" value="Cancel" '+
                        'onclick="cancelChangeSubTeacher(' + subject_id + ', ' + class_id + ',\'' +
                        $('#teacher_sub_' + subject_id + '_' + class_id ).html() + '\');">';
    //'</select><input type="button" class="btn btn-sm btn-success" value="Done">';
    $('#teacher_sub_' + subject_id + '_' + class_id ).html(teacherSelectHtml);    
}

function changeSubTeacher( subject_id, class_id ){
    var teacher_id = $('#subTeacherChg').find(':selected').val();
    if( teacher_id == ''){
        alert("Please select a teacher!");
        return;
    }
    var url = '/changeSubTeacher';
    var datastring = 'class_id='+class_id+'&subject_id='+subject_id+'&teacher_id='+teacher_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( responseText == 'true' ){
                $('#teacher_sub_' + subject_id + '_' + class_id).html($('#subTeacherChg').find(':selected').html());
            }
        }
    });    
}

function cancelChangeSubTeacher( subject_id, class_id, teacher_name ){
    $('#teacher_sub_' + subject_id + '_' + class_id).html(teacher_name);
}

function addClassSubjectRow(){
    var class_id = $('#editSubjectsClassId').val();
    if( document.getElementById('addSubjectNewRow_' + class_id ) ){
        return;
    }
    var subjectList = JSON.parse($('#subjectList').val());
    console.log(subjectList);
    var subjectSelectHtml = '<select class="form-control" id="addSubject_' + class_id + '" onchange="populateTeacherList(' + class_id + ');"><option value="">Select</option>';
    for( var i=0; i < subjectList.length; i++ ){
        subjectSelectHtml += '<option value="' + subjectList[i]['subject_id'] + '">' + subjectList[i]['subject_name'] + '</option>';
    }
    subjectSelectHtml += '</select>';
    var teacherSelectHtml = '<select class="form-control" id="addSubTeacher_' + class_id + '"><option value="">Select</option>';
    
    var subjectHtml = '<tr id="addSubjectNewRow_' + class_id + '"><td class="subject_col">' + subjectSelectHtml + 
                        '</td><td class="teacher_col" id="addSubjectTeacher_' + class_id + '" >' + teacherSelectHtml + 
                        '</td><td class="teacher_img_col"><input type="button" class="btn btn-sm btn-success" value="Add Subject" onclick="addClassSubject(' + class_id + ');">' + 
                        '</td></tr>';
    $('#subjectEditTable tr:last').after(subjectHtml); 
}

function populateTeacherList( class_id ){
    var addedSubject = $( '#addSubject_' + class_id ).val();
    var teacherList = JSON.parse( $('#teacherList').val() );
    var teacherSelectHtml = '<select class="form-control" id="addSubTeacher_' + class_id + '"><option value="">Select</option>';
    var teachersWithSameSub = [];
    var teachersWithDiffSub = [];
    var sameSubCnt = 0;
    var diffSubCnt = 0;
    for( var i=0; i < teacherList.length; i++ ){
        for( var j=1; j <= 20; j++ ){
            if( parseInt(teacherList[i]['s'+j]) == addedSubject ){
                teachersWithSameSub[sameSubCnt] = [teacherList[i]['i'], teacherList[i]['f'], teacherList[i]['l']];
                sameSubCnt++;
                break;
            }
            if( j == 20){
                teachersWithDiffSub[diffSubCnt] = [teacherList[i]['i'], teacherList[i]['f'], teacherList[i]['l']]; 
                diffSubCnt++;
            }
        }
    }
    
    for( i=0; i < teachersWithSameSub.length; i++ ){
        teacherSelectHtml += '<option value="' + teachersWithSameSub[i][0] + '">' + 
                                    teachersWithSameSub[i][1] + ' ' + teachersWithSameSub[i][2] + 
                             '</option>';
    }
    for( i=0; i < teachersWithDiffSub.length; i++ ){
        teacherSelectHtml += '<option value="' + teachersWithDiffSub[i][0] + '">' + 
                                    teachersWithDiffSub[i][1] + ' ' + teachersWithDiffSub[i][2] + 
                             '</option>';
    }
    teacherSelectHtml += '</select>';
    $('#addSubjectTeacher_' + class_id).html( teacherSelectHtml );
}

function addClassSubject( class_id ){
    var subject_id = $('#addSubject_' + class_id).val();
    var subject_name = $('#addSubject_' + class_id).find(':selected').text();
    var teacher_id = $('#addSubTeacher_' + class_id).val();
    var teacher_name = $('#addSubTeacher_' + class_id).find(':selected').text();
    if( subject_id == '' || teacher_id == '' ){
        alert("Please choose the subject and the teacher!");
        return;
    }
    var addedRow = '<td class="subject_col">' + subject_name + 
                        '</td><td class="teacher_col" id="teacher_sub_' + subject_id + '_' + class_id + '"  >' + teacher_name + 
                        '</td><td class="teacher_img_col"><input type="button" class="btn btn-sm btn-warning" value="Delete" onclick="deleteClassSubject(' + 
                                        subject_id + ', ' + class_id + ');">' + 
                        '<input type="button" class="btn btn-sm btn-info" value="Change Teacher" onclick="displayTeacherList(' +
                                        subject_id + ', ' + class_id + ');"></td>';
                
    var url='/addClassSubject';
    var datastring = 'class_id='+class_id+'&teacher_id='+teacher_id+'&subject_id='+subject_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( responseText == 'true' ){
                $('#addSubjectNewRow_'+class_id).prop("id", "subRow_" + subject_id + '_' + class_id );
                $('#subRow_' + subject_id + '_' + class_id).html( addedRow );
            }
        }
    });
}

function showMatchingNames(){
    var names = document.getElementById('teacherCompleteList').value;
    if( names == ''){
        return;
    }
    names = JSON.parse( names );
    console.log(names);
        
    var searchedName = document.getElementById('teacherNameSearch').value;
    if( searchedName != '' ){
        for( var i=1; i<= 4; i++ ){
            document.getElementById('dropdown_opt' + i).innerHTML = '';
            document.getElementById('teacher_dropdown_' + i).value = '';
        }
        var firstChar = searchedName.toLowerCase().charAt(0);
        if( names[firstChar].length > 0 ){
            var name_idx = 1;
            for( var i=0; i< names[firstChar].length; i++ ){
                if( searchedName.toLowerCase() == names[firstChar][i]['searched_name'].substr(0, searchedName.length).toLowerCase() ){
                    document.getElementById('dropdown_opt' + name_idx).innerHTML = names[firstChar][i]['name'];
                    document.getElementById('teacher_dropdown_' + name_idx).value = names[firstChar][i]['teacher_id'];
                    name_idx++;
                } 
            }
            if( name_idx > 1 ){
                document.getElementById('dropDownTeacherList').style.display = "block";
            } else {
                document.getElementById('dropDownTeacherList').style.display = "none";
            }
        }
    }
}

function hideDropDownTeacherList(){
    document.getElementById('dropDownTeacherList').style.display = "none";
}
function displayDropDownTeacherList(){
    var searchedName = document.getElementById('teacherNameSearch').value;
    if( searchedName != '' ){
        document.getElementById('dropDownTeacherList').style.display = "block";
    }
}

function populateSearchName( opt_id ){
    document.getElementById('teacherNameSearch').value = document.getElementById('dropdown_opt'+opt_id).innerHTML;
    document.getElementById('dropDownTeacherList').style.display = "none";
}

function getTeacherDetails( teacher_id ){
    
}

function showTTSubjectChg( day_id, period_id ){
    
}

function toggleEditTimeTable( maxPeriods, maxDays ){
    if( $('#editTimeTableBtn').val().trim() == 'EDIT TIMETABLE' ){
        for( var i=0; i<maxDays; i++ ){
            for( var j=0; j<maxPeriods; j++ ){
                $('#tt_' + i + '_' + j + '_panel').bind("click", editSubjectsTT);
                $('#tt_' + i + '_' + j + '_panel').css("cursor", "pointer");
            }
        }
        $('#editTimeTableBtn').val('DONE');
    } else {
        for( var i=0; i<maxDays; i++ ){
            for( var j=0; j<maxPeriods; j++ ){
                $('#tt_' + i + '_' + j + '_panel').unbind("click");
                $('#tt_' + i + '_' + j + '_panel').css("cursor", "default");
            }
        }
        $('#editTimeTableBtn').val('EDIT TIMETABLE');
    }
}

var editSubjectsTT = function editSubjectsTT(){
    $('#editSubjectsTTModal').modal('show');
    var id = $(this).prop('id');
    id = id.split('_');
    $('#day_id_selected').val(id[1]);
    $('#period_id_selected').val(id[2]);
    $(this).css("background", "lightpink");
}

function submitEditSubjectTT(){
    var selectedSubId = $('#editTTSubjectSelect').find(':selected').val();
    var class_id = $('#editSubjectsClassId').val();
    if( selectedSubId == '' ){
        alert("Please select a subject!");
        return false;
    }
    selectedSubId = selectedSubId.split('_');
    var day_id = $('#day_id_selected').val();
    var period_id = $('#period_id_selected').val();
    $('#tt_' + day_id + '_' + period_id ).html( selectedSubId[1] );
    $('#tt_' + day_id + '_' + period_id + '_panel').css("background", "white");
    var url = '/changeTTSubject';
    var datastring = 'day_id='+day_id+'&period_id='+period_id+'&subject_id='+selectedSubId[0]+'&class_id='+class_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            console.log( responseText );
            if( responseText.indexOf("false") >= 0 ){
                responseText = responseText.split("~~");
                var failReason = responseText[1].trim();
                alert( failReason );
            } else {
                alert("Successfully changed the subject in the time table!!!");
            }
        }
    });
    $('#editSubjectsTTModal').modal('hide');
}

$('#editSubjectsTTModal').on('hidden.bs.modal', function (e) {
    var day_id = $('#day_id_selected').val();
    var period_id = $('#period_id_selected').val();
    $('#tt_' + day_id + '_' + period_id + '_panel').css("background", "white");
});

$('#editSyllabusModal').on('show.bs.modal', function(e) { 
    var invoker_id = $(e.relatedTarget).attr("id");
    var subject_id = invoker_id.split("_");
    subject_id = parseInt(subject_id[2].trim());
    $('#editSyllabusSubjectId').val(subject_id);
    var syllabusTable = document.getElementById('syllabusEditTable');
    while( syllabusTable.rows.length > 1 ){
        syllabusTable.deleteRow( -1 );
    }
    var class_id = $('#editSubjectsClassId').val();
    var classSyllabus = JSON.parse($('#classSyllabus').val());
    var subject_ids = $('#subject_ids_'+class_id).val();
    subject_ids = subject_ids.split(_PAATHSHAALA_CUSTOM_DELIMITER);
    
    var syllabusHtml = '';
    if( subject_id in classSyllabus ){
        var syllabus_elems = classSyllabus[subject_id];
        for( var i=0; syllabus_elems != '' && i < syllabus_elems.length; i++ ){
            var syllabus_id = syllabus_elems[i][0];
            var elem_id = class_id + '_' + subject_id + '_' + syllabus_id;
            var status_html = '';
            if( syllabus_elems[i][3] == '1' ){
                status_html = '<span class="glyphicon glyphicon-ok" style="color:green;"></span>';
            } else {
                status_html = '<span class="glyphicon glyphicon-remove" style="color:red;"></span>';
            }  
            /*var weight_html = '<input type="hidden" id="weight_' + elem_id + '" value="' + syllabus_elems[i][2] + '" >' +
                              '<span class="glyphicon glyphicon-chevron-down" type="button" onclick="testClick(\'down\');"></span>&nbsp;&nbsp;'
                                + syllabus_elems[i][2] + '% ' +
                              '&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-up" type="button" onclick="testClick(\'up\');"></span>'  ;*/
            var weight_html = '<input type="hidden" id="weight_' + elem_id + '" value="' + syllabus_elems[i][2] + '" >' + syllabus_elems[i][2] + '&nbsp;%';
                      
            syllabusHtml += '<tr id="sylRow_' + elem_id + '"><td class="syllabus_col" id="syl_input_' + elem_id + '">' +  
                        syllabus_elems[i][1] +
                        '</td><td class="syllabus_other_col" id="syl_status_' + elem_id + '"  >' + status_html +
                        '</td><td class="syllabus_other_col" id="syl_weight_' + elem_id + '"  >' + weight_html +
                        '</td><td class="syllabus_action_col" id="syl_action_' + elem_id + '" ><input type="button" class="btn btn-sm btn-info" value="Edit" onclick="editSyllabusItem(' + 
                                        syllabus_id + ', ' + subject_id + ', ' + class_id + ', true );">&nbsp;' + 
                        '<input type="button" class="btn btn-sm btn-warning" value="Delete" onclick="deleteSyllabusItem(' +
                                        syllabus_id + ', ' + subject_id + ', ' + class_id + ', true );"></td></tr>';
        }
        $('#syllabusEditTable tr:last').after(syllabusHtml); 
    } 
});

function addSyllabusContentRow(){
    var class_id = $('#editSubjectsClassId').val();
    var subject_id = $('#editSyllabusSubjectId').val();
    var elem_id = class_id + '_' + subject_id;
    if( document.getElementById('addSyllabusNewRow_' + elem_id ) ){
        return;
    }
    var num_rows = $('#syllabusEditTable tr').length;
    var eq_wt = 100/( num_rows );
    eq_wt = eq_wt.toFixed(2);
    $( "input[id^=weight_" + class_id + "_" + subject_id + "]" ).each(function( index ){
        var id = $(this).prop("id");
        var wt = parseFloat($(this).val());
        var new_wt = (( eq_wt * (num_rows-1) ) * wt )/100;
        new_wt = new_wt.toFixed(2);
        var wt_html = '<input type="hidden" id="' + id + '" value="' + new_wt + '" >' + new_wt + '&nbsp;%';
        $(this).parent().html( wt_html );
                /*'<span class="glyphicon glyphicon-chevron-down" type="button" onclick="testClick(\'down\');"></span>&nbsp;&nbsp;'
                       + new_wt + '&nbsp;% ' +
                      '&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-up" type="button" onclick="testClick(\'up\');"></span>';*/
        //$('#syl_' + id ).html(wt_html);
    });
    $( "input[id^=addSyllabusWeightage_n_]" ).each(function( index ){
        var id = $(this).prop("id");
        var wt = parseFloat($(this).val());
        var new_wt = (( eq_wt * (num_rows-1) ) * wt )/100;
        new_wt = new_wt.toFixed(2);
        var wt_html = '<input type="hidden" id="' + id + '" value="' + new_wt + '" >' + new_wt + '&nbsp;%';
        $(this).parent().html( wt_html );
    });
    
    var syllabusInputHtml = '<input type="text" id="addedSyllabusItem_' + elem_id + '" name="addedSyllabusItem_' + elem_id + 
                            '" class="form-control" value="" >';
    var syllabusWeightHtml = '<input type="hidden" id="addedWeightText_' + elem_id + '" value="' + eq_wt + '" >' +
                             '<span class="glyphicon glyphicon-chevron-down" type="button" onclick="changeWeight(\'addedWeightText_' + elem_id + 
                                '\', ' + eq_wt + ', false);"></span>&nbsp;&nbsp;'
                                + eq_wt + '&nbsp;% ' +
                              '&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-up" type="button" onclick="changeWeight(\'addedWeightText_' + elem_id + 
                                '\', ' + eq_wt + ', true);"></span>';
                      //eq_wt + '%';
    var syllabusCompleteHtml = '<select class="form-control" id="addedSyllabusItemStatus_' + elem_id + '">'+
                                    '<option value="incomplete">Yet to complete</span></option>'+
                                    '<option value="complete">Completed</span></option></select>';
                        //'<span class="glyphicon glyphicon-remove" style="color:red;"></span>';
    var syllabusHtml = '<tr id="addSyllabusNewRow_' + elem_id + '"><td class="syllabus_col" id="addedSyllabusItemTd_' + elem_id + '">' + 
                                syllabusInputHtml + 
                        '</td><td class="syllabus_other_col" id="addSyllabusCompleteTd_' + elem_id + '" >' + syllabusCompleteHtml + 
                        '</td><td class="syllabus_other_col" id="addSyllabusWeightageTd_' + elem_id + '" >' + syllabusWeightHtml + 
                        '</td><td class="syllabus_action_col" id="addSyllabusActionTd_' + elem_id + 
                            '" ><input type="button" class="btn btn-sm btn-success" value="Add" onclick="addSyllabusItem(' + class_id + ', ' + subject_id + ');">' + 
                        '</td></tr>';
    $('#syllabusEditTable tr:last').after(syllabusHtml);
}

function addSyllabusItem( class_id, subject_id ){
    var num_rows = $('#syllabusEditTable tr').length;
    var elem_id = class_id + '_' + subject_id;
    var syllabus_content = $('#addedSyllabusItem_' + elem_id ).val().trim();
    if( syllabus_content == '' ){
        alert("Please enter the content of the syllabus item!");
        return;
    }
    
    var status_html = '';
    if( $('#addedSyllabusItemStatus_' + elem_id ).val().trim() == 'complete' ){
        status_html = '<span class="glyphicon glyphicon-ok" style="color:green;"></span>';
    } else {
        status_html = '<span class="glyphicon glyphicon-remove" style="color:red;"></span>';
    }
    var weight_html = '<input type="hidden" id="addSyllabusWeightage_n_' + num_rows + '" value="' + $('#addedWeightText_' + elem_id).val() + '">' 
                            + $('#addedWeightText_' + elem_id).val() + '&nbsp;%';   
    var action_html = '<input type="button" class="btn btn-sm btn-info" value="Edit" onclick="editSyllabusItem(' + 
                                        num_rows + ', ' + subject_id + ', ' + class_id + ', false );">&nbsp;' + 
                        '<input type="button" class="btn btn-sm btn-warning" value="Delete" onclick="deleteSyllabusItem(' +
                                        num_rows + ', ' + subject_id + ', ' + class_id + ', false );">';
    $('#addedSyllabusItemTd_' + elem_id ).html( syllabus_content );
    $('#addSyllabusCompleteTd_' + elem_id ).html( status_html );
    $('#addSyllabusWeightageTd_' + elem_id ).html( weight_html );                  
    $('#addSyllabusActionTd_' + elem_id ).html( action_html );    
        
    $('#addSyllabusNewRow_'+elem_id).prop("id", "addSyllabusRow_n_" + num_rows );
    $('#addedSyllabusItemTd_'+elem_id).prop("id", "addedSyllabusItemTd_n_" + num_rows );
    $('#addSyllabusCompleteTd_'+elem_id).prop("id", "addSyllabusCompleteTd_n_" + num_rows );
    $('#addSyllabusWeightageTd_'+elem_id).prop("id", "addSyllabusWeightageTd_n_" + num_rows );
    $('#addSyllabusActionTd_'+elem_id).prop("id", "addSyllabusActionTd_n_" + num_rows );
    $('#addedWeightText_' + elem_id).prop("id", "addSyllabusWeightage_n_" + num_rows );
    $('#addedSyllabusItem_' + elem_id).prop("id", "addedSyllabusItem_n_" + num_rows );//
    $('#addedSyllabusItemStatus_' + elem_id).prop("id", "addedSyllabusItemStatus_n_" + num_rows );
}

function changeWeight( wt_elem_id, wt, increaseFlag ){
    //5% increase/decrease on each action
    var init_rem_val = 100 - wt;
    if( increaseFlag ){
        wt = wt * 1.05;
    } else {
        wt = wt * 0.95;
    }
    var final_rem_val = 100 - wt;
    var class_id = $('#editSubjectsClassId').val();
    var subject_id = $('#editSyllabusSubjectId').val();
    //var elem_id = class_id + '_' + subject_id;
    wt = wt.toFixed(2);
    var wt_elem_parent_id = $('#' + wt_elem_id).parent().prop("id");
    var syllabusWeightHtml = '<input type="hidden" id="' + wt_elem_id + '" value="' + wt + '" >' +
                             '<span class="glyphicon glyphicon-chevron-down" type="button" onclick="changeWeight(\'' + wt_elem_id + 
                                '\', ' + wt + ', false);"></span>&nbsp;&nbsp;'
                                + wt + '&nbsp;% ' +
                              '&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-up" type="button" onclick="changeWeight(\'' + wt_elem_id + 
                                '\', ' + wt + ', true);"></span>';
                        
    $('#' + wt_elem_parent_id ).html( syllabusWeightHtml );
    $( "input[id^=weight_" + class_id + "_" + subject_id + "]" ).each(function( index ){
        var id = $(this).prop("id");
        if( id != wt_elem_id ){
            var wt = parseFloat($(this).val());
            var new_wt = ( wt * final_rem_val )/init_rem_val;
            new_wt = new_wt.toFixed(2);
            var wt_html = '<input type="hidden" id="' + id + '" value="' + new_wt + '" >' + new_wt + '&nbsp;%';
            $(this).parent().html( wt_html );
        }
    });
    $( "input[id^=addSyllabusWeightage_n_]" ).each(function( index ){
        var id = $(this).prop("id");
        if( id != wt_elem_id ){
            var wt = parseFloat($(this).val());
            var new_wt = ( wt * final_rem_val )/init_rem_val;
            new_wt = new_wt.toFixed(2);
            var wt_html = '<input type="hidden" id="' + id + '" value="' + new_wt + '" >' + new_wt + '&nbsp;%';
            $(this).parent().html( wt_html );
        }
    });
}

function editSyllabusItem( syllabus_id, subject_id, class_id, existingFlag ){
    if( existingFlag ){
        var elem_id = class_id + '_' + subject_id + '_' + syllabus_id;
        var syllabusInputHtml = '<input type="text" id="syllabusInput_' + elem_id + '" name="syllabusInput_' + elem_id + 
                                '" class="form-control" value="' + $('#syl_input_' + elem_id).html() + '" >';
                      
        var isComplete = $('#syl_status_' + elem_id ).find('span').hasClass("glyphicon-ok");
        var statusHtml = '<select class="form-control" id="statusSelect_' + elem_id + '">';
        if( isComplete ){
            statusHtml += '<option value="incomplete">Yet to complete</span></option>'+
            '<option value="complete" selected>Completed</span></option></select>';
        } else {
            statusHtml += '<option value="incomplete" selected>Yet to complete</span></option>'+
            '<option value="complete">Completed</span></option></select>';
        }                
                  
//                  /'<input type="hidden" id="weight_' + elem_id + '" value="' + syllabus_elems[i][2] + '" >' + syllabus_elems[i][2] + '&nbsp;%';
        var wt = $('#weight_' + elem_id ).val().trim();
        var syllabusWeightHtml = '<input type="hidden" id="weight_' + elem_id + '" value="' + wt + '" >' +
                             '<span class="glyphicon glyphicon-chevron-down" type="button" onclick="changeWeight(\'weight_' + elem_id + 
                                '\', ' + wt + ', false);"></span>&nbsp;&nbsp;'
                                + wt + '&nbsp;% ' +
                              '&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-up" type="button" onclick="changeWeight(\'weight_' + elem_id + 
                                '\', ' + wt + ', true);"></span>';
         
        var syllabusActionHtml = '<input type="button" class="btn btn-sm btn-success" value="Done" onclick="completeEditSylRow(' +
                                        syllabus_id + ', ' + subject_id + ', ' + class_id + ', true );">';
        $('#syl_input_' + elem_id).html(syllabusInputHtml);
        $("#syl_status_" + elem_id).html(statusHtml);
        $('#syl_weight_' + elem_id).html(syllabusWeightHtml);
        $('#syl_action_' + elem_id).html(syllabusActionHtml);
    } else {
        var syllabusInputHtml = '<input type="text" id="addedSyllabusItem_n_' + syllabus_id + '" class="form-control" ' + 
                                'value="' + $('#addedSyllabusItemTd_n_' + syllabus_id).html() + '" >';
              
        var isComplete = $('#addSyllabusCompleteTd_n_' + syllabus_id ).find('span').hasClass("glyphicon-ok");
        var statusHtml = '<select class="form-control" id="addedSyllabusItemStatus_n_' + syllabus_id + '">';
        if( isComplete ){
            statusHtml += '<option value="incomplete">Yet to complete</span></option>'+
            '<option value="complete" selected>Completed</span></option></select>';
        } else {
            statusHtml += '<option value="incomplete" selected>Yet to complete</span></option>'+
            '<option value="complete">Completed</span></option></select>';
        }
        
        /*var statusHtml = '<select class="form-control" id="addedSyllabusItemStatus_n_' + syllabus_id + '">'+
                          '<option value="incomplete">Yet to complete</span></option>'+
                          '<option value="complete">Completed</span></option></select>';*/
                  
//                  /'<input type="hidden" id="weight_' + elem_id + '" value="' + syllabus_elems[i][2] + '" >' + syllabus_elems[i][2] + '&nbsp;%';
        //addSyllabusWeightage_n_5
        var wt = $('#addSyllabusWeightage_n_' + syllabus_id ).val().trim();
        var syllabusWeightHtml = '<input type="hidden" id="addSyllabusWeightage_n_' + syllabus_id + '" value="' + wt + '" >' +
                             '<span class="glyphicon glyphicon-chevron-down" type="button" onclick="changeWeight(\'addSyllabusWeightage_n_' + syllabus_id + 
                                '\', ' + wt + ', false);"></span>&nbsp;&nbsp;'
                                + wt + '&nbsp;% ' +
                              '&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-up" type="button" onclick="changeWeight(\'addSyllabusWeightage_n_' + syllabus_id + 
                                '\', ' + wt + ', true);"></span>';
         
        var syllabusActionHtml = '<input type="button" class="btn btn-sm btn-success" value="Done" onclick="completeEditSylRow(' +
                                        syllabus_id + ', ' + subject_id + ', ' + class_id + ', false );">';
        $('#addedSyllabusItemTd_n_' + syllabus_id).html(syllabusInputHtml);
        $("#addSyllabusCompleteTd_n_" + syllabus_id).html(statusHtml);
        $('#addSyllabusWeightageTd_n_' + syllabus_id).html(syllabusWeightHtml);
        $('#addSyllabusActionTd_n_' + syllabus_id).html(syllabusActionHtml);
    }
}

function deleteSyllabusItem( syllabus_id, subject_id, class_id, existingFlag ){
    if( existingFlag ){
        var elem_id = class_id + '_' + subject_id + '_' + syllabus_id;
        var init_rem_val = 100 - parseFloat($('#weight_' + elem_id ).val());
        var final_rem_val = 100;
        final_rem_val = final_rem_val.toFixed(2);
        $('#weight_' + elem_id ).val( '0.00' );
        $('#sylRow_' + elem_id).css("display", "none");
    } else {
        var init_rem_val = 100 - parseFloat($('#addSyllabusWeightage_n_' + syllabus_id ).val());
        var final_rem_val = 100;
        $('#addSyllabusWeightage_n_' + syllabus_id ).val('0.00');
        $('#addSyllabusRow_n_' + syllabus_id).css("display", "none");
    }
    
    $( "input[id^=weight_" + class_id + "_" + subject_id + "]" ).each(function( index ){
        var id = $(this).prop("id");
        if( id != 'weight_' + elem_id ){
            var wt = parseFloat($(this).val());
            var new_wt = ( wt * final_rem_val )/init_rem_val;
            new_wt = new_wt.toFixed(2);
            var wt_html = '<input type="hidden" id="' + id + '" value="' + new_wt + '" >' + new_wt + '&nbsp;%';
            $(this).parent().html( wt_html );
        }
    });
    $( "input[id^=addSyllabusWeightage_n_]" ).each(function( index ){
        var id = $(this).prop("id");
        if( id != 'addSyllabusWeightage_n_' + syllabus_id ){
            var wt = parseFloat($(this).val());
            var new_wt = ( wt * final_rem_val )/init_rem_val;
            new_wt = new_wt.toFixed(2);
            var wt_html = '<input type="hidden" id="' + id + '" value="' + new_wt + '" >' + new_wt + '&nbsp;%';
            $(this).parent().html( wt_html );
        }
    });
}

function completeEditSylRow( syllabus_id, subject_id, class_id, existingFlag ){
    if( existingFlag ){
        var elem_id = class_id + '_' + subject_id + '_' + syllabus_id;
        var syllabusInputHtml = $('#syllabusInput_' + elem_id).val().trim();
        if( syllabusInputHtml == '' ){
            alert("Please enter the content of the syllabus item!");
            return;
        }
                        
        var statusHtml = '';
        if( $('#statusSelect_' + elem_id ).val().trim() == 'complete' ){
           statusHtml = '<span class="glyphicon glyphicon-ok" style="color:green;"></span>';
        } else {
           statusHtml = '<span class="glyphicon glyphicon-remove" style="color:red;"></span>';
        }
        
        var wt = $('#weight_' + elem_id ).val().trim();
        var syllabusWeightHtml = '<input type="hidden" id="weight_' + elem_id + '" value="' + wt + '" >' + wt + '&nbsp;% ';
         
        var syllabusActionHtml = '<input type="button" class="btn btn-sm btn-info" value="Edit" onclick="editSyllabusItem(' + 
                                        syllabus_id + ', ' + subject_id + ', ' + class_id + ', true );">&nbsp;' + 
                                 '<input type="button" class="btn btn-sm btn-warning" value="Delete" onclick="deleteSyllabusItem(' +
                                        syllabus_id + ', ' + subject_id + ', ' + class_id + ', true );">';
                                
        $('#syl_input_' + elem_id).html(syllabusInputHtml);
        $('#syl_status_' + elem_id).html(statusHtml);
        $('#syl_weight_' + elem_id).html(syllabusWeightHtml);
        $('#syl_action_' + elem_id).html(syllabusActionHtml);
    } else {
        var syllabusInputHtml = $('#addedSyllabusItem_n_' + syllabus_id).val().trim();
        if( syllabusInputHtml == '' ){
            alert("Please enter the content of the syllabus item!");
            return;
        }
          
        var statusHtml = '';
        if( $('#addedSyllabusItemStatus_n_' + syllabus_id ).val().trim() == 'complete' ){
            statusHtml = '<span class="glyphicon glyphicon-ok" style="color:green;"></span>';
        } else {
            statusHtml = '<span class="glyphicon glyphicon-remove" style="color:red;"></span>';
        }
        
        var wt = $('#addSyllabusWeightage_n_' + syllabus_id ).val().trim();
        var syllabusWeightHtml = '<input type="hidden" id="addSyllabusWeightage_n_' + elem_id + '" value="' + wt + '" >' + wt + '&nbsp;% ';
         
        var syllabusActionHtml = '<input type="button" class="btn btn-sm btn-info" value="Edit" onclick="editSyllabusItem(' + 
                                        syllabus_id + ', ' + subject_id + ', ' + class_id + ', false );">&nbsp;' + 
                                 '<input type="button" class="btn btn-sm btn-warning" value="Delete" onclick="deleteSyllabusItem(' +
                                        syllabus_id + ', ' + subject_id + ', ' + class_id + ', false );">';
        $('#addedSyllabusItemTd_n_' + syllabus_id).html(syllabusInputHtml);
        $("#addSyllabusCompleteTd_n_" + syllabus_id).html(statusHtml);
        $('#addSyllabusWeightageTd_n_' + syllabus_id).html(syllabusWeightHtml);
        $('#addSyllabusActionTd_n_' + syllabus_id).html(syllabusActionHtml);
    }
}

function saveSyllabusEdit(){
    var class_id = $('#editSubjectsClassId').val();
    var subject_id = $('#editSyllabusSubjectId').val();
    var content = '';
    var isComplete = '';
    var weights = '';
    var syllabus_ids = '';
    var contentNew = '';
    var isCompleteNew = '';
    var weightsNew = '';
    var syllabusIdsDeleted = '';
    var formIncomplete = false;
    $('tr[id^=sylRow_' + class_id + '_' + subject_id + ']').each( function( index ){
        var id = $(this).prop("id");
        id = id.split('_');
        var elem_id = id[1] + '_' + id[2] + '_' + id[3];
        var disp = $(this).css("display");
        if( disp && disp.trim() != '' && disp.trim() == "none" ){
            if( syllabusIdsDeleted == '' ){
                syllabusIdsDeleted = id[3];
            } else {
                syllabusIdsDeleted += _PAATHSHAALA_CUSTOM_DELIMITER + id[3];
            }
        }
        if( $('#syl_action_' + elem_id ).find("input:first").val().trim() == 'Done' ){
            formIncomplete = true;
        }
        if( syllabus_ids == '' ){
            syllabus_ids = id[3];
        } else {
            syllabus_ids += _PAATHSHAALA_CUSTOM_DELIMITER + id[3];
        }
        
        if( content == '' ){
            content = $('#syl_input_' + elem_id ).html();
        } else {
            content += _PAATHSHAALA_CUSTOM_DELIMITER + $('#syl_input_' + elem_id ).html();
        }
        
        var comp = '0';
        if($('#syl_status_' + elem_id ).find('span').hasClass("glyphicon-ok")){
            comp = '1';
        } 
        if( isComplete == '' ){
            isComplete = comp;
        } else {
            isComplete += _PAATHSHAALA_CUSTOM_DELIMITER + comp;
        }
        
        if( weights == '' ){
            weights = $('#weight_'+elem_id).val();
        } else {
            weights += _PAATHSHAALA_CUSTOM_DELIMITER + $('#weight_'+elem_id).val();
        }
    });
    
    $('tr[id^=addSyllabusRow_n_]').each( function( index ){
        var id = $(this).prop("id");
        id = id.split('_');
        var elem_id = id[2];
        if( $('#addSyllabusActionTd_n_' + elem_id ).find("input:first").val().trim() == 'Done' ){
            formIncomplete = true;
        }
        if( contentNew == '' ){
            contentNew = $('#addedSyllabusItemTd_n_' + elem_id ).html();
        } else {
            contentNew += _PAATHSHAALA_CUSTOM_DELIMITER + $('#addedSyllabusItemTd_n_' + elem_id ).html();
        }
        
        var comp = '0';
        if($('#addSyllabusCompleteTd_n_' + elem_id ).find('span').hasClass("glyphicon-ok")){
            comp = '1';
        } 
        if( isCompleteNew == '' ){
            isCompleteNew = comp;
        } else {
            isCompleteNew += _PAATHSHAALA_CUSTOM_DELIMITER + comp;
        }
        
        if( weightsNew == '' ){
            weightsNew = $('#addSyllabusWeightage_n_'+elem_id).val();
        } else {
            weightsNew += _PAATHSHAALA_CUSTOM_DELIMITER + $('#addSyllabusWeightage_n_'+elem_id).val();
        }
    });
    if( formIncomplete ){
        alert( "Please finish all editing before submit!");
        return;
    }
    
    var url = '/saveSyllabusEdit';
    var datastring = 'class_id='+class_id+'&subject_id='+subject_id+'&content='+encodeURIComponent(content)+
                     '&isComplete='+encodeURIComponent(isComplete)+'&weights='+encodeURIComponent(weights)+
                     '&syllabus_ids='+encodeURIComponent(syllabus_ids)+'&contentNew='+encodeURIComponent(contentNew)+
                     '&isCompleteNew='+encodeURIComponent(isCompleteNew)+'&weightsNew='+encodeURIComponent(weightsNew)+
                     '&syllabusIdsDeleted='+syllabusIdsDeleted;
             
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            alert("Successfully edited the syllabus!!!");
            populateClassDetails( class_id );
            $('#editSyllabusModal').modal('hide');
        }
    });
}

$('#syllabusImportModal').on('show.bs.modal', function(e) { 
    var invoker_id = $(e.relatedTarget).attr("id");
    var id_arr = invoker_id.split("_");
    var class_id = id_arr[1];
    var subject_id = id_arr[2];
    $('#importSyllabusSubjectId').val(subject_id);
    var classesSelect = JSON.parse($('#classesToSelFrom_'+ class_id + '_' + subject_id).val());
    var selectHtml = '<option value="">Select</option>';
    for( var i=0; i < classesSelect.length; i++ ){
        selectHtml += '<option value="' + classesSelect[i][0] + '">Section ' + classesSelect[i][1] + '</option>';
    }
    $('#importSyllabusSelect').html(selectHtml);
});

function importSyllabus(){
    var class_id = $('#editSubjectsClassId').val();
    var subject_id = $('#importSyllabusSubjectId').val();
    var importFromCls = $('#importSyllabusSelect').val().trim();
    if( importFromCls == '' ){
        alert("Please select the class to import from!");
        return;
    }
    var url = '/importSyllabus';
    var datastring = 'class_id=' + class_id + '&subject_id=' + subject_id + '&importFromCls=' + importFromCls;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            alert("Successfully imported the syllabus!!!");
            populateClassDetails( class_id );
            $('#syllabusImportModal').modal('hide');
        }
    });
}

function testClick( text ){
    alert("text :  " + text );
}

function testCaching(){
    if (typeof(Storage) !== "undefined") {
        
    } else {
        alert("Sorry, your browser does not support Web Storage...");
    }
}

function studentOnLoad(){
    //clearLocalStorage();
    if (typeof(Storage) !== "undefined") {
        if( !localStorage.getItem("students") || localStorage.getItem("students") == "false" ){
            var students = fetchStudents();
            //localStorage.setItem( "students", students );
        }
        if( !localStorage.getItem("parents") || localStorage.getItem("parents") == "false" ){
            var parents = fetchParents();
            //localStorage.setItem( "parents", parents );
        }
    }
    populateStudentSections();
     $('#studentSectionSearch').val( $('#selectedSection').val() );
}

function clearLocalStorage(){
    localStorage.removeItem("students");
    localStorage.removeItem("parents");
}

function fetchStudents(){
    var url = '/fetchAllStudents';
    $.ajax({
        type : "GET",
        url : url,
        async : false,
        dataType: "text",
        success : function(responseText) {
            if( typeof responseText == 'string' && responseText == "false" ){
                return;
            }
            localStorage.setItem("students", responseText);
        }
    });
}

function fetchParents(){
    var url = '/fetchAllParents';
    $.ajax({
        type : "GET",
        url : url,
        async : false,
        dataType: "text",
        success : function(responseText) {
            if( typeof responseText == 'string' && responseText == "false" ){
                return;
            }
            localStorage.setItem("parents", responseText);
        }
    });
}

function showMatchingStudentNames(){
    var searchedStudentName = document.getElementById('studentNameSearch').value;
    if( searchedStudentName != '' && searchedStudentName.length >= 3){
        var students = localStorage.getItem("students"); 
        students = JSON.parse(students);
        console.log(students);
        for( var i=1; i<= 4; i++ ){
            document.getElementById('dropdown_opt' + i).innerHTML = '';
            document.getElementById('student_dropdown_' + i).value = '';
        }
        var firstChar = searchedStudentName.toLowerCase().charAt(0);
        var secondChar = searchedStudentName.toLowerCase().charAt(1);
        var thirdChar = searchedStudentName.toLowerCase().charAt(2);
        var matchingNames = students[firstChar][secondChar][thirdChar];
        if( matchingNames.length > 0 ){
            var name_idx = 1;
            for( var i=0; i< matchingNames.length; i++ ){
                var name_arr = matchingNames[i].split(" ");
                var firstname = name_arr[0].toLowerCase();
                var lastname = name_arr[1].toLowerCase();
                if( searchedStudentName.toLowerCase() == firstname.substr(0, searchedStudentName.length) ){
                    document.getElementById('dropdown_opt' + name_idx).innerHTML = matchingNames[i];
                    document.getElementById('student_dropdown_' + name_idx).value = matchingNames[i];
                    name_idx++;
                } else if( searchedStudentName.toLowerCase() == lastname.substr(0, searchedStudentName.length) ){
                    document.getElementById('dropdown_opt' + name_idx).innerHTML = matchingNames[i];
                    document.getElementById('student_dropdown_' + name_idx).value = matchingNames[i];
                    name_idx++;
                }
            }
            if( name_idx > 1 ){
                document.getElementById('dropDownStudentList').style.display = "block";
            } else {
                document.getElementById('dropDownStudentList').style.display = "none";
            }
        }
    }
}

function showMatchingParentNames(){
    var studentParentNameSearch = document.getElementById('studentParentNameSearch').value;
    if( studentParentNameSearch != '' && studentParentNameSearch.length >= 3){
        var parents = localStorage.getItem("parents"); 
        parents = JSON.parse(parents);
        console.log(parents);
        for( var i=1; i<= 4; i++ ){
            document.getElementById('dropdown_p_opt' + i).innerHTML = '';
            document.getElementById('student_parent_dropdown_' + i).value = '';
        }
        var firstChar = studentParentNameSearch.toLowerCase().charAt(0);
        var secondChar = studentParentNameSearch.toLowerCase().charAt(1);
        var thirdChar = studentParentNameSearch.toLowerCase().charAt(2);
        var matchingNames = parents[firstChar][secondChar][thirdChar];
        if( matchingNames.length > 0 ){
            var name_idx = 1;
            for( var i=0; i< matchingNames.length; i++ ){
                var name_arr = matchingNames[i].split(" ");
                var firstname = name_arr[0].toLowerCase();
                var lastname = name_arr[1].toLowerCase();
                if( studentParentNameSearch.toLowerCase() == firstname.substr(0, studentParentNameSearch.length) ){
                    document.getElementById('dropdown_p_opt' + name_idx).innerHTML = matchingNames[i];
                    document.getElementById('student_parent_dropdown_' + name_idx).value = matchingNames[i];
                    name_idx++;
                } else if( studentParentNameSearch.toLowerCase() == lastname.substr(0, studentParentNameSearch.length) ){
                    document.getElementById('dropdown_p_opt' + name_idx).innerHTML = matchingNames[i];
                    document.getElementById('student_parent_dropdown_' + name_idx).value = matchingNames[i];
                    name_idx++;
                }
            }
            if( name_idx > 1 ){
                document.getElementById('dropDownStudentParentList').style.display = "block";
            } else {
                document.getElementById('dropDownStudentParentList').style.display = "none";
            }
        }
    }
}

function displayDropDownStudentList(){
    var searchedName = document.getElementById('studentNameSearch').value;
    if( searchedName != '' ){
        document.getElementById('dropDownStudentList').style.display = "block";
    }
}

function hideDropDownStudentList(){
    document.getElementById('dropDownStudentList').style.display = "none";
}

function displayDropDownParentList(){
    var searchedName = document.getElementById('studentParentNameSearch').value;
    if( searchedName != '' ){
        document.getElementById('dropDownStudentParentList').style.display = "block";
    }
}

function hideDropDownParentList(){
    document.getElementById('dropDownStudentParentList').style.display = "none";
}

function populateStudentSearchName( opt_id ){
    document.getElementById('studentNameSearch').value = document.getElementById('dropdown_opt'+opt_id).innerHTML;
    document.getElementById('dropDownStudentList').style.display = "none";
}

function populateParentSearchName( opt_id ){
    document.getElementById('studentParentNameSearch').value = document.getElementById('dropdown_p_opt'+opt_id).innerHTML;
    document.getElementById('dropDownStudentParentList').style.display = "none";
}

function populateStudentSections(){
    var classConst = $('#studentClassSearch' ).find(":selected").val();
    classConst = parseInt( classConst );
    var classArray = $('#classArray').val();
    classArray = jQuery.parseJSON(classArray);
    var sectionArray = classArray[classConst];
    console.log(sectionArray);
    var html = '<option value="">Select</option>';
    for( var i=0; i < sectionArray.length; i++ ){
        html += '<option value="' + sectionArray[i]['section'] + '" >' + sectionArray[i]['section'] + '</option>';
    }
    $('#studentSectionSearch').html( html );
}

function populateAddStudentSections(){
    var classConst = $('#addStudentClass' ).find(":selected").val();
    classConst = parseInt( classConst );
    var classArray = $('#classArray').val();
    classArray = jQuery.parseJSON(classArray);
    var sectionArray = classArray[classConst];
    console.log(sectionArray);
    var html = '<option value="">Select</option>';
    for( var i=0; i < sectionArray.length; i++ ){
        html += '<option value="' + sectionArray[i]['section'] + '" >' + sectionArray[i]['section'] + '</option>';
    }
    $('#addStudentSection').html( html );
}

function validateAddStudentForm(){
    $( "p[id$='Msg']" ).each(function( index ){
        $( this ).css("display","none");
        $( this ).html("");
    });    
    $( "div[id$='Div'][id^=addStudent]" ).each(function( index ){
        $( this ).removeClass("has-error has-feedback");
    });
    
    var firstName = $('#addStudentFirstName').val().trim();
    var middleName = $('#addStudentMiddleName').val().trim();
    var lastName = $('#addStudentLastName').val().trim();
    var fatherFirstName = $('#addFatherFirstName').val().trim();
    var fatherMiddleName = $('#addFatherMiddleName').val().trim();
    var fatherLastName = $('#addFatherLastName').val().trim();
    var motherFirstName = $('#addMotherFirstName').val().trim();
    var motherMiddleName = $('#addMotherMiddleName').val().trim();
    var motherLastName = $('#addMotherLastName').val().trim();
    
    var email = $('#addStudentEmail').val().trim();
    var fatherEmail = $('#addFatherEmail').val().trim();
    var motherEmail = $('#addMotherEmail').val().trim();
    
    var studentRoll = $('#addStudentRoll').val().trim();
    var examRoll = $('#addExamRollNum').val().trim();
    
    var studentClass = $('#addStudentClass').val().trim();
    var section = $('#addStudentSection').val().trim();
    
    var fatherPhone = $('#addStudentFatherPhone').val().trim();
    var motherPhone = $('#addStudentMotherPhone').val().trim();
    
    var isValid = true;
    
    if( firstName == "" ){
        isValid = false;
        $('#addStudentFirstNameDiv').addClass("has-error has-feedback");
        $('#addStudentFirstNameMsg').css("display","inline");
        $('#addStudentFirstNameMsg').html("* Please enter first name");
    }
    
    if( lastName == "" ){
        isValid = false;
        $('#addStudentLastNameDiv').addClass("has-error has-feedback");
        $('#addStudentLastNameMsg').css("display","inline");
        $('#addStudentLastNameMsg').html("* Please enter last name");
    }
    
    if( fatherFirstName == "" ){
        isValid = false;
        $('#addStudentFatherFirstNameDiv').addClass("has-error has-feedback");
        $('#addStudentFatherFirstNameMsg').css("display","inline");
        $('#addStudentFatherFirstNameMsg').html("* Please enter first name");
    }
    
    if( fatherLastName == "" ){
        isValid = false;
        $('#addStudentFatherLastNameDiv').addClass("has-error has-feedback");
        $('#addStudentFatherLastNameMsg').css("display","inline");
        $('#addStudentFatherLastNameMsg').html("* Please enter last name");
    }
    
    if( motherFirstName == "" ){
        isValid = false;
        $('#addStudentMotherFirstNameDiv').addClass("has-error has-feedback");
        $('#addStudentMotherFirstNameMsg').css("display","inline");
        $('#addStudentMotherFirstNameMsg').html("* Please enter first name");
    }
    
    if( motherLastName == "" ){
        isValid = false;
        $('#addStudentMotherLastNameDiv').addClass("has-error has-feedback");
        $('#addStudentMotherLastNameMsg').css("display","inline");
        $('#addStudentMotherLastNameMsg').html("* Please enter last name");
    }
    
    if( studentClass == "" ){
        isValid = false;
        $('#addStudentClassDiv').addClass("has-error has-feedback");
        $('#addStudentClassMsg').css("display","inline");
        $('#addStudentClassMsg').html("* Please select a class");
    }
    
    if( section == "" ){
        isValid = false;
        $('#addStudentSectionDiv').addClass("has-error has-feedback");
        $('#addStudentSectionMsg').css("display","inline");
        $('#addStudentSectionMsg').html("* Please select a section");
    }
    
    if( email == "" ){
        isValid = false;
        $('#addStudentEmailDiv').addClass("has-error has-feedback");
        $('#addStudentEmailMsg').css("display","inline");
        $('#addStudentEmailMsg').html("* Please enter valid email");
    }
    
    if( fatherEmail == "" ){
        isValid = false;
        $('#addStudentFatherEmailDiv').addClass("has-error has-feedback");
        $('#addStudentFatherEmailMsg').css("display","inline");
        $('#addStudentFatherEmailMsg').html("* Please enter valid email");
    }
    
    if( motherEmail == "" ){
        isValid = false;
        $('#addStudentMotherEmailDiv').addClass("has-error has-feedback");
        $('#addStudentMotherEmailMsg').css("display","inline");
        $('#addStudentMotherEmailMsg').html("* Please enter valid email");
    }
    
    if( studentRoll == "" ){
        isValid = false;
        $('#addStudentRollDiv').addClass("has-error has-feedback");
        $('#addStudentRollMsg').css("display","inline");
        $('#addStudentRollMsg').html("* Please enter student roll number");
    }
    
    if( fatherPhone.length != 0 && ( fatherPhone.length != 10 || !( /^\d+$/.test(fatherPhone) ) ) ){
        isValid = false;
        $('#addStudentFatherPhoneDiv').addClass("has-error has-feedback");
        $('#addStudentFatherPhoneMsg').css("display","inline");
        $('#addStudentFatherPhoneMsg').html("* Please enter a valid phone number");
    }
    
    if( motherPhone.length != 0 && ( motherPhone.length != 10 || !( /^\d+$/.test(motherPhone) ) ) ){
        isValid = false;
        $('#addStudentMotherPhoneDiv').addClass("has-error has-feedback");
        $('#addStudentMotherPhoneMsg').css("display","inline");
        $('#addStudentMotherPhoneMsg').html("* Please enter a valid phone number");
    }
    return isValid;    
}

function addMessageRecipient(){
    alert("addMessageRecipient");
    return;
}

/*
$('#studentDetailModal').on('shown.bs.modal', function(e){
    var invoker_id = $(e.relatedTarget).attr("id");
    var student_id = invoker_id.split('_');
    student_id = student_id[2].trim();
    $('#accordion .panel-collapse').collapse( 'hide' );
    $('#studentModalClass').html( $('#student_class_' + student_id).val().trim());
    $('#studentModalFather').html( $('#student_fn_' + student_id).val().trim());
    $('#studentModalMother').html( $('#student_mn_' + student_id).val().trim());
    $('#studentModalDOB').html( $('#student_dob_' + student_id).val().trim());
    $('#studentModalDOJ').html( $('#student_doj_' + student_id).val().trim());
    $('#studentDetailTitle').html( '<strong>' + $('#student_name_' + student_id).val().trim() + '</strong>' );
    
    var studentTestDetailsTbl = document.getElementById('studentTestDetailsTbl');
    while( studentTestDetailsTbl.rows.length > 1 ){
        studentTestDetailsTbl.deleteRow( -1 );
    }
    
    var url='/getScoreCardDetails';
    var datastring = 'student_id=' + student_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : true,
        dataType: "json",
        success : function(responseText) {
            console.log(responseText);
            $('#scoreCardDetailsJson').val( JSON.stringify(responseText) );
            var cnt=0;
            var menuHtml = '<ul class="nav nav-tabs nav-justified">';
            var scoreCardHtml = '';
            for (var test_id in responseText ) {
                if( responseText.hasOwnProperty(test_id) && 'test_name' in responseText[test_id] ){
                    if( cnt == 0 ){
                        /*$('#details_testDate').html( test_details[subject_id]['test_date'] );
                        $('#details_gradingType').html( test_details[subject_id]['grading_type_desc'] );
                        $('#gradingType').val( test_details[subject_id]['grading_type'] );*
                        menuHtml += '<li role="presentation" class="active custom-active">' +
                                        '<a href="#" class="custom-link-active" onclick="activateTestMenu(' + test_id 
                                            + ');" id="menu_test_' + test_id + '">' 
                                            + responseText[test_id]['test_name'] + 
                                        '</a>' +
                                    '</li>';
                        
                        if( 'details' in responseText[test_id] ){
                            var details = responseText[test_id]['details'];
                            for( var i=0; i < details.length; i++ ){
                                var student_grade = details[i]['st_grade_value'].trim() == ''? -1 : parseInt(details[i]['st_grade_value']);
                                var student_percent = (100 * student_grade)/(parseInt(details[i]['max_grade_value']) - parseInt(details[i]['min_grade_value']));
                                student_percent = student_percent.toFixed(2);
                                var class_avg = parseInt(details[i]['class_average']);
                                var min_grade = details[i]['min_grade'];
                                var max_grade = details[i]['max_grade'];
                                var remark = details[i]['remark'];
                                var student_grade_disp = details[i]['st_grade'];
                                var student_pro_bar_html = 'Not Yet Marked';
                                if( student_grade >= 0 ){
                                    student_pro_bar_html = '<div class="progress" style="margin-bottom:0px;">' +
                                                    '<div class="progress-bar" role="progressbar" aria-valuenow="' + student_percent + '" ' +
                                                         'aria-valuemin="0" aria-valuemax="100" style="width:' + student_percent + '%;">' +
                                                        student_grade_disp +
                                                    '</div>' +
                                                '</div>' +
                                                '<div>' +
                                                    '<span style="float:left;">' + min_grade + '</span>' +
                                                    '<span style="float:right;">' + max_grade + '</span>' +
                                                '</div>';
                                }
                                scoreCardHtml += '<tr>' +
                                            '<td class="sc_subject">' + details[i]['subject_name'] + '</td>' +
                                            '<td class="sc_score">' + 
                                                student_pro_bar_html +
                                            '</td>' +
                                            '<td class="sc_average" >' + 
                                                '<div class="progress" style="margin-bottom:0px;">' +
                                                    '<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="' + class_avg + '" ' + 
                                                         'aria-valuemin="0" aria-valuemax="100" style="width:' + class_avg + '%;">' + 
                                                        class_avg + '%' + 
                                                    '</div>' + 
                                                '</div>' + 
                                                '<div>' + 
                                                    '<span style="float:left;">' + min_grade + '</span>' + 
                                                    '<span style="float:right;">' + max_grade + '</span>' + 
                                                '</div>' + 
                                            '</td>' +
                                            '<td class="sc_remarks" >' + 
                                                remark +
                                            '</td>' +
                                        '</tr>';
                            }
                        }
                    } else {
                        menuHtml += '<li role="presentation">' +
                                        '<a href="#" onclick="activateTestMenu(' + test_id 
                                            + ');" id="menu_test_' + test_id + '">' 
                                            + responseText[test_id]['test_name'] + 
                                        '</a>' +
                                    '</li>';
                    }
                }
                cnt++;
            }
            $('#studentTestDetailsMenu').html( menuHtml );
            $('#studentTestDetailsTbl tr:last').after( scoreCardHtml );
        }
    });
});
*/

function activateTestMenu( test_id ){
    $('#studentTestDetailsMenu li').each( function(e){
       $(this).removeClass("active custom-active"); 
       $(this).children().removeClass("custom-link-active");
    });
    
    var studentTestDetailsTbl = document.getElementById('studentTestDetailsTbl');
    while( studentTestDetailsTbl.rows.length > 1 ){
        studentTestDetailsTbl.deleteRow( -1 );
    }
    
    $('#menu_test_' + test_id ).addClass("custom-link-active");
    $('#menu_test_' + test_id ).parent().addClass("active custom-active");
    var scoreCardDetailsJson = JSON.parse($('#scoreCardDetailsJson').val());
    var cnt=0;
    var menuHtml = '<ul class="nav nav-tabs nav-justified">';
    var scoreCardHtml = '';
    if( scoreCardDetailsJson.hasOwnProperty(test_id) && 'test_name' in scoreCardDetailsJson[test_id] ){
        /*$('#details_testDate').html( test_details[subject_id]['test_date'] );
        $('#details_gradingType').html( test_details[subject_id]['grading_type_desc'] );
        $('#gradingType').val( test_details[subject_id]['grading_type'] );*/
        menuHtml += '<li role="presentation" class="active custom-active">' +
                        '<a href="#" class="custom-link-active" onclick="activateTestMenu(' + test_id 
                            + ');" id="menu_test_' + test_id + '">' 
                            + scoreCardDetailsJson[test_id]['test_name'] + 
                        '</a>' +
                    '</li>';
        
        if( 'details' in scoreCardDetailsJson[test_id] ){
            var details = scoreCardDetailsJson[test_id]['details'];
            for( var i=0; i < details.length; i++ ){
                var student_grade = details[i]['st_grade_value'].trim() == ''? -1 : parseInt(details[i]['st_grade_value']);
                var student_percent = (100 * student_grade)/(parseInt(details[i]['max_grade_value']) - parseInt(details[i]['min_grade_value']));
                student_percent = student_percent.toFixed(2);
                var class_avg = parseInt(details[i]['class_average']);
                var min_grade = details[i]['min_grade'];
                var max_grade = details[i]['max_grade'];
                var student_grade_disp = details[i]['st_grade'];
                var remark = details[i]['remark'];
                var student_pro_bar_html = 'Not Yet Marked';
                if( student_grade >= 0 ){
                    student_pro_bar_html = '<div class="progress" style="margin-bottom:0px;">' +
                                    '<div class="progress-bar" role="progressbar" aria-valuenow="' + student_percent + '" ' +
                                         'aria-valuemin="0" aria-valuemax="100" style="width:' + student_percent + '%;">' +
                                        student_grade_disp +
                                    '</div>' +
                                '</div>' +
                                '<div>' +
                                    '<span style="float:left;">' + min_grade + '</span>' +
                                    '<span style="float:right;">' + max_grade + '</span>' +
                                '</div>';
                }
                scoreCardHtml += '<tr>' +
                            '<td class="sc_subject">' + details[i]['subject_name'] + '</td>' +
                            '<td class="sc_score">' + 
                                student_pro_bar_html +
                            '</td>' +
                            '<td class="sc_average" >' + 
                                '<div class="progress" style="margin-bottom:0px;">' +
                                    '<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="' + class_avg + '" ' + 
                                         'aria-valuemin="0" aria-valuemax="100" style="width:' + class_avg + '%;">' + 
                                        class_avg + '%' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div>' + 
                                    '<span style="float:left;">' + min_grade + '</span>' + 
                                    '<span style="float:right;">' + max_grade + '</span>' + 
                                '</div>' + 
                            '</td>' +
                            '<td class="sc_remarks" >' + 
                                remark +
                            '</td>' +
                        '</tr>';
            }
        }
    }
    $('#studentTestDetailsTbl tr:last').after( scoreCardHtml );
}

function editSchoolTestOnLoad(){
    $('#accordion .panel-collapse').collapse( 'hide' );
}

function showTestDetails( class_id ){
    var classArr = ['Pre KG', 'LKG', 'UKG', 'Class I', 'Class II', 'Class III', 'Class IV', 'Class V',
                    'Class VI', 'Class VII', 'Class VIII', 'Class IX', 'Class X', 'Class XI', 'Class XII', 'Play Home'];
    var prevClassId = $('#chosen_class_id').val().trim();
    var testDetailsTbl = document.getElementById('testDetailsTbl');
    while( testDetailsTbl.rows.length > 1 ){
        testDetailsTbl.deleteRow( -1 );
    }
    
    if( prevClassId != '' ){
        $('#class_' + prevClassId ).parent().css("background", "white");
    }
    $('#class_' + class_id ).parent().css("background", "burlywood");
    $('#chosen_class_id').val(class_id);
    var testDetails = JSON.parse( $('#testJson').val().trim() );
    var className = '';
    if( testDetails[class_id].length > 0  ){
        className = classArr[testDetails[class_id][0]['class']] + ' Section ' + testDetails[class_id][0]['section'];
    }
    
    $('#testDetailTitle').html( className + " - Test Details");
    $('#testDetailsTbl').css("display", "block");
    
    var testDetailHtml = '';
    for( var i=0; i < testDetails[class_id].length; i++ ){
        testDetailHtml += '<tr><td class="test_name" id="test_name_' + testDetails[class_id][i]['test_id'] + '" >' + testDetails[class_id][i]['test_name'] + '</td>' +
                              '<td class="test_status" id="test_status_' + testDetails[class_id][i]['test_id'] + '" >' + testDetails[class_id][i]['status'] + '</td>' +
                              '<td class="test_fd" id="from_time_' + testDetails[class_id][i]['test_id'] + '" >' + testDetails[class_id][i]['from_time'] + '</td>' +
                              '<td class="test_td" id="to_time_' + testDetails[class_id][i]['test_id'] + '" >' + testDetails[class_id][i]['to_time'] + '</td>' +
                              '<td class="test_action">' + 
                                '<input type="hidden" id="from_time_date_' + testDetails[class_id][i]['test_id'] + 
                                        '" value="' + testDetails[class_id][i]['from_time_date'] + '" >' +
                                '<input type="hidden" id="to_time_date_' + testDetails[class_id][i]['test_id'] + 
                                        '" value="' + testDetails[class_id][i]['to_time_date'] + '" >' +
                                '<input type="hidden" id="grading_type_' + testDetails[class_id][i]['test_id'] + 
                                        '" value="' + testDetails[class_id][i]['grading_type'] + '" >' +
                                '<button id="testDetails_' + testDetails[class_id][i]['test_id'] + '" class="btn btn-sm btn-default" ' +
                                    ' style="margin-right:5px;color: darkgreen;" ' +
                                    ' data-toggle="modal" data-target="#testDetailModal" data-backdrop="static" data-keyboard="true" >' + 
                                    ' <strong>&nbsp;&nbsp;DETAILS&nbsp;</strong>' +
                                '</button>' +
                                '<button id="editTest_' + testDetails[class_id][i]['test_id'] + '" class="btn btn-sm btn-default" ' +
                                    ' style="margin-right:5px;color: darkorange;" ' +
                                    ' data-toggle="modal" data-target="#editTestModal" data-backdrop="static" data-keyboard="true" >' + 
                                    ' <span class="glyphicon glyphicon-pencil"></span> <strong>&nbsp;&nbsp;&nbsp;EDIT</strong>' +
                                '</button>' +
                              '</td>' +
                          '</tr>';
                  
                  //'<td class="grade_pattern">' + testDetails[class_id][i]['grading_type'] + '</td>' +
    }
    
    $('#testDetailsTbl tr:last').after( testDetailHtml );
    
}

function validateDateDiff( date1, date2, duration ){
    var date1_unix = date1.getTime();
    var date2_unix = date2.getTime();
    var one_day_unix = 1000*24*60*60;
    
    var date_diff_days = (date2_unix - date1_unix)/one_day_unix;
    if( date_diff_days > duration ){
        return false;
    }
    return true;
}

function validateAddTestForm(){
    $( "p[id$='Msg']" ).each(function( index ){
        $( this ).css("display","none");
        $( this ).html("");
    });    
    $( "div[id$='Div'][id^=addTest]" ).each(function( index ){
        $( this ).removeClass("has-error has-feedback");
    });
    
    var testName = $('#addTestName').val().trim();
    var gradeType = $('#addTestGradeType').val().trim();
    var fromDate = $('#addTestFromDate').val().trim();
    var toDate = $('#addTestToDate').val().trim();
    var isValid = true;
    
    if( testName == "" ){
        isValid = false;
        $('#addTestNameDiv').addClass("has-error has-feedback");
        $('#addTestNameMsg').css("display","inline");
        $('#addTestNameMsg').html("* Please enter test name");
    }
    
    if( gradeType == "" ){
        isValid = false;
        $('#addTestGradeTypeDiv').addClass("has-error has-feedback");
        $('#addTestGradeTypeMsg').css("display","inline");
        $('#addTestGradeTypeMsg').html("* Please enter grade type");
    }
    
    if( fromDate == "" || !validateDate( fromDate, true ) ){
        isValid = false;
        $('#addTestFromDateDiv').addClass("has-error has-feedback");
        $('#addTestFromDateMsg').css("display","inline");
        $('#addTestFromDateMsg').html("* Please enter valid from date");
    }
    
    if( toDate == "" || !validateDate( toDate, true ) ){
        isValid = false;
        $('#addTestToDateDiv').addClass("has-error has-feedback");
        $('#addTestToDateMsg').css("display","inline");
        $('#addTestToDateMsg').html("* Please enter valid to date");
    }
    
    if( $('#addedClassTests').val().trim() == '' ){
        isValid = false;
        $('#addTestClassesDiv').addClass("has-error has-feedback");
        $('#addTestClassesMsg').css("display","inline");
        $('#addTestClassesMsg').html("* Please choose atlease one class to add");
    }
    
    if(!isValid){
        return isValid;
    }
    
    var fromDateObj = new Date( fromDate );
    var toDateObj = new Date( toDate );
    if( fromDateObj > toDateObj ){
        isValid = false;
        $('#addTestToDateDiv').addClass("has-error has-feedback");
        $('#addTestToDateMsg').css("display","inline");
        $('#addTestToDateMsg').html("* To date should be later than from date");
    }
    
    if( !validateDateDiff( fromDateObj, toDateObj, 30 ) ){
        isValid = false;
        $('#addTestToDateDiv').addClass("has-error has-feedback");
        $('#addTestToDateMsg').css("display","inline");
        $('#addTestToDateMsg').html("* The test duration should be less than 1 month!");
    }
    return isValid;
}

function addTestClass(){
    var classId = $('#addTestClasses').val().trim();
    var addedTestClassElem = document.getElementById('addTestClasses');
    var classDesc = addedTestClassElem.options[addedTestClassElem.selectedIndex].text.trim();
    $('#addedTestClassesDiv').html( $('#addedTestClassesDiv').html() + 
                                        '<button class="btn btn-sm chosen_btn" id="testClass_' + classId + 
                                            '" onclick="removeTestClass(\'' + classId + '\')">' +
                                            '<span class="glyphicon glyphicon-remove"></span>' + 
                                            '<strong>&nbsp;' + classDesc + '</strong>' +
                                        '</button>&nbsp;');
                              
    if( $('#addedClassTests').val() == '' ){
        $('#addedClassTests').val( classId );
    } else {
        $('#addedClassTests').val( $('#addedClassTests').val() + ', ' + classId );
    }
}

function removeTestClass( classId ){
    var addedClassTests = $('#addedClassTests').val();
    addedClassTests = addedClassTests.split(',');
    var modifiedAddedClassTests = '';
    for( var i=0; i < addedClassTests.length; i++ ){
        var class_id_loop = addedClassTests[i].trim();
        if( class_id_loop != classId ){
            if( modifiedAddedClassTests == '' ){
                modifiedAddedClassTests = class_id_loop;
            } else {
                modifiedAddedClassTests = modifiedAddedClassTests + ", " + class_id_loop;
            }
        }        
    }
    $('#addedClassTests').val( modifiedAddedClassTests );
    $( '#testClass_' + classId ).remove();
}

$('#addTestModal').on('shown.bs.modal', function(e){
    $('#addedTestClassesDiv').html('');  
    $('#addedClassTests').val('');
        
    $('#addTestName').val('');
    $('#addTestGradeType').val('');
    $('#addTestFromDate').val('');
    $('#addTestToDate').val('');
    
    $( "p[id$='Msg']" ).each(function( index ){
        $( this ).css("display","none");
        $( this ).html("");
    });    
    $( "div[id$='Div'][id^=addTest]" ).each(function( index ){
        $( this ).removeClass("has-error has-feedback");
    });
});

$('#addTestModal').on('hidden.bs.modal', function(e){
    $('#addedTestClassesDiv').html('');
    $('#addedClassTests').val('');
});

$('#editTestModal').on('shown.bs.modal', function(e){
    var invoker_id = $(e.relatedTarget).attr("id");
    var test_id = invoker_id.split("_");
    test_id = test_id[1].trim();
    
    $( "p[id$='Msg']" ).each(function( index ){
        $( this ).css("display","none");
        $( this ).html("");
    });    
    $( "div[id$='Div'][id^=editTest]" ).each(function( index ){
        $( this ).removeClass("has-error has-feedback");
    });
    
    //$('#test_status_' + test_id ).html().trim();
    $('#editTestGradeType').val($('#grading_type_' + test_id ).val().trim());
    $('#editTestFromDate').val($('#from_time_date_' + test_id ).val().trim());
    $('#editTestToDate').val($('#to_time_date_' + test_id ).val().trim());
    $('#editTestName').val( $('#test_name_' + test_id ).html().trim() );
    $('#editTestId').val( test_id );
});

function validateEditTestForm(){
    $( "p[id$='Msg']" ).each(function( index ){
        $( this ).css("display","none");
        $( this ).html("");
    });    
    $( "div[id$='Div'][id^=editTest]" ).each(function( index ){
        $( this ).removeClass("has-error has-feedback");
    });
    
    var testName = $('#editTestName').val().trim();
    var gradeType = $('#editTestGradeType').val().trim();
    var fromDate = $('#editTestFromDate').val().trim();
    var toDate = $('#editTestToDate').val().trim();
    var isValid = true;
    
    if( testName == "" ){
        isValid = false;
        $('#editTestNameDiv').addClass("has-error has-feedback");
        $('#editTestNameMsg').css("display","inline");
        $('#editTestNameMsg').html("* Please enter test name");
    }
    
    if( gradeType == "" ){
        isValid = false;
        $('#editTestGradeTypeDiv').addClass("has-error has-feedback");
        $('#editTestGradeTypeMsg').css("display","inline");
        $('#editTestGradeTypeMsg').html("* Please enter grade type");
    }
    
    if( fromDate == "" || !validateDate( fromDate, true ) ){
        isValid = false;
        $('#editTestFromDateDiv').addClass("has-error has-feedback");
        $('#editTestFromDateMsg').css("display","inline");
        $('#editTestFromDateMsg').html("* Please enter valid from date");
    }
    
    if( toDate == "" || !validateDate( toDate, true ) ){
        isValid = false;
        $('#editTestToDateDiv').addClass("has-error has-feedback");
        $('#editTestToDateMsg').css("display","inline");
        $('#editTestToDateMsg').html("* Please enter valid to date");
    }
    
    if(!isValid){
        return isValid;
    }
    
    var fromDateObj = new Date( fromDate );
    var toDateObj = new Date( toDate );
    if( fromDateObj > toDateObj ){
        isValid = false;
        $('#editTestToDateDiv').addClass("has-error has-feedback");
        $('#editTestToDateMsg').css("display","inline");
        $('#editTestToDateMsg').html("* To date should be later than from date");
    }
    
    if( !validateDateDiff( fromDateObj, toDateObj, 30 ) ){
        isValid = false;
        $('#editTestToDateDiv').addClass("has-error has-feedback");
        $('#editTestToDateMsg').css("display","inline");
        $('#editTestToDateMsg').html("* The test duration should be less than 1 month!");
    }
    return isValid;
}

$('#testDetailModal').on('shown.bs.modal', function(e){
    var invoker_id = $(e.relatedTarget).attr("id");
    var test_id = invoker_id.split("_");
    test_id = test_id[1].trim();
    
    populateTestDetails( test_id );
});

function populateTestDetails( test_id ){
    var testDetailHtml = '';
    var testSubjectsTbl = document.getElementById('testSubjectDetailsTbl');
    while( testSubjectsTbl.rows.length > 1 ){
        testSubjectsTbl.deleteRow( -1 );
    }
    
    var testDuration = '(&nbsp;' + $('#from_time_' + test_id).html().trim() + ' TO ' + $('#to_time_' + test_id).html().trim() + '&nbsp;)';
    $('#individualTestTiming').html(testDuration);
    $('#individualTestDetailTitle').html('<strong>' + $('#test_name_' + test_id ).html().trim() + ' - Details </strong>'); 
    var url = '/getTestDetails';
    var datastring = 'test_id=' + test_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            console.log(responseText);
            for( var i=0; i < responseText.length; i++ ){
                testDetailHtml += '<tr>' +
                                    '<td style="text-align:center;" id="subname_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + '" >' 
                                        + responseText[i]['subject_name'] + 
                                    '</td>' +
                                    '<td style="text-align:center;" id="gt_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + '">' 
                                            + responseText[i]['type'] + 
                                    '</td>' +
                                    '<td style="text-align:center;" id="test_date_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + '">' 
                                            + responseText[i]['test_date'] + 
                                    '</td>' +
                                    '<td style="text-align:center;" id="test_time_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + '">' 
                                            + responseText[i]['test_time'] + 
                                    '</td>' +
                                    '<td style="text-align:center;">' +
                                        '<input type="hidden" id="gr_type_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + 
                                                    '" value="' + responseText[i]['grading_type'] + '" >' +
                                        '<input type="hidden" id="sub_date_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + 
                                                    '" value="' + responseText[i]['test_date'] + '" >' +
                                        '<input type="hidden" id="st_time_hour_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + 
                                                    '" value="' + responseText[i]['sub_st_hour'] + '" >' +
                                        '<input type="hidden" id="st_time_ampm_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + 
                                                    '" value="' + responseText[i]['sub_st_ampm'] + '" >' +
                                        '<input type="hidden" id="st_time_min_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + 
                                                    '" value="' + responseText[i]['sub_st_min'] + '" >' +
                                        '<input type="hidden" id="end_time_hour_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + 
                                                    '" value="' + responseText[i]['sub_end_hour'] + '" >' +
                                        '<input type="hidden" id="end_time_min_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + 
                                                    '" value="' + responseText[i]['sub_end_min'] + '" >' +
                                        '<input type="hidden" id="end_time_ampm_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + 
                                                    '" value="' + responseText[i]['sub_end_ampm'] + '" >' +
                                        '<input type="button" id="editTestDetails_' + responseText[i]['test_id'] + '_' + responseText[i]['subject_id'] + 
                                            '" data-toggle="modal" data-target="#editTestDetailModal" ' + 
                                            ' class="btn btn-sm btn-default" style="color: #20b2aa;font-weight:bold;" value="MODIFY" >' +
                                    '</td>' +
                                  '</tr>';
            }
            
            /*if( responseText.indexOf("false") < 0 ){
                //testDetailHtml += 
            }*/
        }
    });
    
    $('#testSubjectDetailsTbl tr:last').after(testDetailHtml); 
}

String.prototype.capitalizeFirstLetter = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

$('#editTestDetailModal').on('shown.bs.modal', function(e){
    $('#editSubTestGradeType').val( '' );
    $('#editSubTestFromHour').val( '12' );
    $('#editSubTestFromMinute').val( '00' );
    $('#editSubTestFromAMPM').val( 'AM' );
    $('#editSubTestToHour').val( '12' );
    $('#editSubTestToMinute').val( '00' );
    $('#editSubTestToAMPM').val( 'AM' );
    
    var invoker_id = $(e.relatedTarget).attr("id");
    var test_id = invoker_id.split("_");
    var subject_id = test_id[2].trim();
    test_id = test_id[1].trim();
    var subject_name = $('#subname_' + test_id + '_' + subject_id ).html().trim();
    var test_name = $('#test_name_' + test_id ).html().trim()
    $('#testSubEditTitle').html('<strong>' + test_name + ' - ' + subject_name + ' </strong>');
    $('#selectedTestId').val(test_id);
    $('#selectedSubjectId').val(subject_id);
    
    var monthMap = {};
    monthMap['jan'] = 31;
    monthMap['feb'] = 29;
    monthMap['mar'] = 31;
    monthMap['apr'] = 30;
    monthMap['may'] = 31;
    monthMap['jun'] = 30;
    monthMap['jul'] = 31;
    monthMap['aug'] = 31;
    monthMap['sep'] = 30;
    monthMap['oct'] = 31;
    monthMap['nov'] = 30;
    monthMap['dec'] = 31;
    
    var test_from_date = $('#from_time_' + test_id).html().trim();
    test_from_date = test_from_date.split(' ');
    var test_from_day = parseInt(test_from_date[0].trim());
    var test_from_month = test_from_date[1].trim().toLowerCase();
    var test_from_year = '';
    var from_time_date = $('#from_time_date_' + test_id).val();
    from_time_date = from_time_date.split('-');
    
    if( from_time_date.length > 2 ){
        test_from_year = parseInt(from_time_date[0].trim());
    }
    
    var test_to_date = $('#to_time_' + test_id).html().trim();
    test_to_date = test_to_date.split(' ');
    var test_to_day = parseInt(test_to_date[0].trim());
    var test_to_month = test_to_date[1].trim().toLowerCase();
    var test_to_year = '';
    var to_time_date = $('#to_time_date_' + test_id).val();
    to_time_date = to_time_date.split('-');
    
    if( to_time_date.length > 2 ){
        test_to_year = parseInt(to_time_date[0].trim());
    }
    
    var optionsHtml = '<option value="">Select</option>';
    if( test_from_month == test_to_month ){
        for( var i=test_from_day; i <= test_to_day; i++ ){
            optionsHtml += '<option value="' + i + ' ' + test_to_month.capitalizeFirstLetter() + ' ' + test_from_year + '">' 
                                + i + ' ' + test_to_month.capitalizeFirstLetter() + '</option>';
        }
    } else {
        for( var i=test_from_day; i <= monthMap[test_from_month]; i++ ){
            optionsHtml += '<option value="' + i + ' ' + test_from_month.capitalizeFirstLetter() + ' ' + test_from_year + '">' 
                        + i + ' ' + test_from_month.capitalizeFirstLetter() + '</option>';
        }
        for( var i=1; i <= test_to_day; i++ ){
            optionsHtml += '<option value="' + i + ' ' + test_to_month.capitalizeFirstLetter() + ' ' + test_to_year +  '">' 
                        + i + ' ' + test_to_month.capitalizeFirstLetter() + '</option>';
        }
    }
    $('#editSubTestDate').html( optionsHtml );
    
    var test_date = $('#sub_date_' + test_id + '_' + subject_id).val().trim();
    var test_date = test_date.split(' ');
    var test_day = '';
    var test_month = '';
    var test_year = '';
    if( Array.isArray(test_date) && test_date.length > 2 ){
        test_day = parseInt(test_date[0].trim());
        test_month = test_date[1].trim().toLowerCase();
        test_month = test_month.substring(0, test_month.length - 1);
        test_year = parseInt( test_date[2].trim() );
        $('#editSubTestDate').val( test_day + ' ' + test_month.capitalizeFirstLetter() + ' ' + test_year );
    }
    
    $('#editSubTestGradeType').val( $('#gr_type_' + test_id + '_' + subject_id).val().trim() );
    $('#editSubTestFromHour').val( $('#st_time_hour_' + test_id + '_' + subject_id ).val().trim() );
    $('#editSubTestFromMinute').val( $('#st_time_min_' + test_id + '_' + subject_id ).val().trim() );
    $('#editSubTestFromAMPM').val( $('#st_time_ampm_' + test_id + '_' + subject_id ).val().trim() );
    $('#editSubTestToHour').val( $('#end_time_hour_' + test_id + '_' + subject_id ).val().trim() );
    $('#editSubTestToMinute').val( $('#end_time_min_' + test_id + '_' + subject_id ).val().trim() );
    $('#editSubTestToAMPM').val( $('#end_time_ampm_' + test_id + '_' + subject_id ).val().trim() );
});

function validateAndSubmitTestDetails(){
    $( "p[id$='Msg']" ).each(function( index ){
        $( this ).css("display","none");
        $( this ).html("");
    });    
    $( "div[id$='Div'][id^=editSubTest]" ).each(function( index ){
        $( this ).removeClass("has-error has-feedback");
    });
    
    var isValid = true;
    var gradingType = $('#editSubTestGradeType').val().trim();
    var testSubjectDate = $('#editSubTestDate').val().trim();
    var editSubTestFromHour = $('#editSubTestFromHour').val().trim();
    var editSubTestFromMinute = $('#editSubTestFromMinute').val().trim();
    var editSubTestToHour = $('#editSubTestToHour').val().trim();
    var editSubTestToMinute = $('#editSubTestToMinute').val().trim();
    
    if( gradingType == "" ){
        isValid = false;
        $('#editSubTestGradeTypeDiv').addClass("has-error has-feedback");
        $('#editSubTestGradeTypeMsg').css("display","inline");
        $('#editSubTestGradeTypeMsg').html("* Please select a grade type");
    }
    
    if( testSubjectDate == "" ){
        isValid = false;
        $('#editSubTestDateDiv').addClass("has-error has-feedback");
        $('#editSubTestDateMsg').css("display","inline");
        $('#editSubTestDateMsg').html("* Please select a valid test date");
    }
    
    if( editSubTestFromHour == "" || editSubTestFromMinute == ""
            || editSubTestToHour == "" || editSubTestToMinute == "" ){
        isValid = false;
        $('#editSubTestTimingDiv').addClass("has-error has-feedback");
        $('#editSubTestTimingMsg').css("display","inline");
        $('#editSubTestTimingMsg').html("* Please enter a valid test time");
    }
    
    var test_id = $('#selectedTestId').val();
    if( isValid ){
        var url = '/editSchoolTestDetail';
        var datastring = 'editSubTestGradeType=' + $('#editSubTestGradeType').val().trim() +
                         '&editSubTestDate=' + $('#editSubTestDate').val() +
                         '&editSubTestFromHour=' + $('#editSubTestFromHour').val() +
                         '&editSubTestFromMinute=' + $('#editSubTestFromMinute').val() +
                         '&editSubTestFromAMPM=' + $('#editSubTestFromAMPM').val() +
                         '&editSubTestToHour=' + $('#editSubTestToHour').val() +
                         '&editSubTestToMinute=' + $('#editSubTestToMinute').val() +
                         '&editSubTestToAMPM=' + $('#editSubTestToAMPM').val() +
                         '&selectedTestId=' + $('#selectedTestId').val() +
                         '&selectedSubjectId=' + $('#selectedSubjectId').val();
                 
        $.ajax({
            type : "POST",
            url : url,
            data : datastring,
            async : false,
            dataType: "json",
            success : function(responseText) {
                if( responseText.trim() == "true" ){
                    alert("Successfully saved the details!");
                    $('#editTestDetailModal').modal('hide');
                    populateTestDetails( test_id );
                    //closeModal('editTestDetailModal');
                    //closeModal('testDetailModal');
                    //$('#testDetails_' + test_id).trigger("click");
                } else {
                    alert("Could not save the test details");
                }
            }
        });
    } else {
        return isValid;
    }
}

function closeModal( modal_id ){
    $('#' + modal_id ).modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}

/*$("#collapse_ClassForum").on('shown.bs.collapse', function(){
    if( $('#forumSelectClass').length ){
        $('#forumSelectClass').remove();
    }
    if( $('#classForumDiv').html().trim() == '' ){
        populateSchoolClassFeed();
    }
});

$("#collapse_ClassForum").on('hidden.bs.collapse', function(){
    $('#forumSelectClass').remove();
});*/

function populateSchoolClassFeed( class_id ){
    if( class_id == '' ){
        $('#classForumDiv').html('<h3 style="text-align:center;" id="forumSelectClass">Please select a class!</h3>');
        return;
    }
    var class_desc = $('#className_' + class_id).val() + ' - Section ' + $('#classSection_' + class_id ).val();
    
    var classFeedHtml = '<div class="row" id="postBoxDiv">' +
                            '<div class="col-sm-9">' +
                                '<textarea class="form-control" id="postingTextArea" rows="2" ' +
                                         ' value="" placeholder="[' + class_desc + 
                                                                    '] Enter your post here... "></textarea>' +
                            '</div>' +
                            '<div class="col-sm-3" style="margin-top:3px;">' +
                                '<input type="button" id="postUpdateBtn" class="btn btn-primary" style="margin-right:5px;" ' +
                                      ' value="POST" onclick="schoolPostInForum(' + class_id + ');">' +
                                '<button id="postUpdatePic_' + class_id + '" class="btn btn-default" data-toggle="modal" ' +
                                      ' data-target="#uploadPicModal" data-backdrop="static" data-keyboard="true">' +
                                    '<span class="glyphicon glyphicon-camera"></span>' +
                                '</button>' +
                                '<input type="hidden" id="last_feed_fetched_time" value="">' +
                            '</div>' +
                        '</div>' +
                        '<div id="homeContentDiv" style="height:1400px;margin-top:20px;overflow-y:scroll;">' +
                        '</div>';
                
    $('#classForumDiv').html( classFeedHtml );
    fetchSchoolClassForumItems( class_id );
    $( "p[id^=class_]" ).each(function( index ){
        $(this).parent().css("background", "white");
    });
    $("#class_" + class_id ).parent().css("background", "burlywood");
}

function fetchSchoolClassForumItems( class_id ){
    var url = '/fetchClassForumItems';
    var datastring = 'to_time=' + $('#last_feed_fetched_time').val() + '&class_id=' + class_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            console.log(responseText);
            var isInit = true;
            var feedHtml = getSchoolClassFeedHtml( responseText, isInit, class_id );
            //populateForumItems( responseText );
            
            var moreFeedHtml = getMoreSchoolClassFeedHtml( class_id );
            feedHtml += moreFeedHtml;
            $('#homeContentDiv').html(feedHtml);
        }
    });
}

function schoolPostInForum( class_id ){
    var postedText = $('#postingTextArea').val().trim();
    if( typeof postedText != 'undefined' && postedText.trim() == '' ){
        alert( "Please enter a post!" );
        return;
    }
    var url = '/addClassTextPost';
    var datastring = 'text=' + encodeURIComponent(postedText) + '&class_id=' + class_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            console.log(responseText);
            var isInit = true;
            var feedHtml = getSchoolClassFeedHtml( responseText, isInit, class_id );
            //populateForumItems( responseText );
            
            var moreFeedHtml = getMoreSchoolClassFeedHtml( class_id );
            feedHtml += moreFeedHtml;
            $('#homeContentDiv').html(feedHtml);
            $('#postingTextArea').val('');
            //alert(responseText);
        }
    });
}

function getSchoolClassFeedHtml( dataObject, isInit, class_id ){
    if( 'last_post_time' in dataObject ){
        $('#last_feed_fetched_time').val( dataObject['last_post_time'] );
    }
    
    var feed_html = '';
    if( 'feed_items' in dataObject ){
        var feed_items = dataObject['feed_items'];
        var cnt = 0;
        for (var idx in feed_items ) {
            if( feed_items.hasOwnProperty(idx) ){
                if( 'item_text' in feed_items[idx] && 'posted_at' in feed_items[idx]
                        && 'user_name' in feed_items[idx] && 'user_id' in feed_items[idx] ){
                    var user_name = feed_items[idx]['user_name'];
                    var posted_at = feed_items[idx]['posted_at'];
                    var item_text = feed_items[idx]['item_text'];
                    var user_id = feed_items[idx]['user_id']; 
                    var item_id = feed_items[idx]['item_id']; 
                    var editable = feed_items[idx]['editable'];
                    var item_type = feed_items[idx]['item_type'];
                    var pic_url = feed_items[idx]['pic_url'];
                    var show_details = feed_items[idx]['show_details'];
                    
                    var style_margin = ' style="margin-top:40px;" ';
                    if( cnt === 0 && isInit ){
                        style_margin = '';
                    }
                    
                    var cancelPostStyle = ' display:none; ';
                    if( editable ){
                        cancelPostStyle = ' display:block; ';
                    }
                    
                    var cancelPostHtml = '<div class="col-sm-1" style="padding-left:0px;padding-right:0px;' + cancelPostStyle + '">' +
                                             '<span class="delete_post" style="cursor:pointer;" onclick="deleteSchoolClassPost(' + item_id + ', ' + class_id + ');">&times;</span>' +
                                         '</div>';
                                 
                    feed_html += '<div class="row" '+ style_margin + '>' +
                                '<div class="col-sm-8 col-sm-offset-1">' +
                                    '<div class="row">' +
                                        '<div class="col-sm-4">' +
                                            '<p style="width:100%;"><strong id="feed_item_name_' + item_id + '">' + 
                                                user_name + '</strong></p>' +
                                        '</div>' +
                                        '<div class="col-sm-3 col-sm-offset-4 feed_time_div">' +
                                            '<p style="width:100%;">' + 
                                                '<span class="delete_post" style="cursor:pointer;float:right;' + cancelPostStyle + 
                                                    '" onclick="deleteSchoolClassPost(' + item_id + ', ' +  class_id + ');">&nbsp;&nbsp;&times;</span>' + 
                                                '<small id="feed_item_time_' + item_id + '" style="float:right;padding-top:4px;">' + 
                                                    posted_at + '</small>' +
                                            '</p>' +
                                        '</div>' +
                                        //cancelPostHtml +
                                    '</div>' +
                                    '<p style="width:100%;" id="feed_item_text_' + item_id + '">' +
                                        getLinkText(item_text) + '</p>';
                    if( item_type == '2' && pic_url != '' ){
                        feed_html += '<button type="button" class="btn viewImage" onclick="showSchoolFeedImage(' + item_id + ');" id="showFeedImageBtn_' + item_id + '">' +
                                                '<span class="glyphicon glyphicon-eye-open">&nbsp;</span>' +
                                                ' VIEW IMAGE&nbsp;&nbsp;' +
                                            '</button>' +
                                            '<input type="hidden" id="pic_url_' + item_id + '" value="' + pic_url + '" >' +
                                            '<div id="feedImageDiv_' + item_id + '">' +
                                            '</div>';
                    }
                    
                    var commentHtml = '';
                    if( 'comments' in feed_items[idx] && feed_items[idx]['comments'].length > 0 ){
                        var comments = feed_items[idx]['comments'];
                        commentHtml += '<div id="commentsForPost_' + item_id + '" class="row">' +
                                            '<div class="col-sm-10" style="padding-right:0px;">' +
                                                '<table class="table table-bordered table-responsive" id="commentTable_' + item_id + '" ' +
                                                      ' style="background:#efecec; margin:0px;">';
                                        
                        for( var j=0; j < comments.length; j++ ){
                            var comment_id = comments[j]['comment_id'];
                            var comment_text = comments[j]['comment_text'];
                            var user_id = comments[j]['user_id'];
                            var user_name = comments[j]['user_name'];
                            var posted_at = comments[j]['posted_at'];
                            var editable_comment = comments[j]['editable'];
                            
                            var cancelCommentStyle = ' display:none; ';
                            if( editable_comment ){
                                cancelCommentStyle = ' display:block; ';
                            }
                            
                            commentHtml += '<tr>' +
                                               '<td style="padding-top:0px; padding-bottom:0px;padding-right:1px;">' +
                                                    '<div class="row" style="margin-right:0px;">' +
                                                        '<div class="col-sm-6">' +
                                                            '<p style="width:100%;"><strong id="comment_username_' + item_id + '_' + comment_id + '">'+ 
                                                                user_name + '</strong></p>' +
                                                        '</div>' +
                                                        '<div class="col-sm-3 col-sm-offset-3 feed_time_comment_div">' +
                                                            '<p style="width:100%;">' + 
                                                                '<span class="delete_post" onclick="deleteSchoolClassComment(' + item_id + ', ' + 
                                                                                comment_id + ');" style="float:right;' + cancelCommentStyle + '">&nbsp;&nbsp;&times;</span>' +
                                                                '<small id="comment_time_' + item_id + '_' + comment_id + '" style="float:right;padding-top:4px;">'+ 
                                                                    posted_at + '</small>' + 
                                                            '</p>' +
                                                        '</div>' +
                                                        /*'<div class="col-sm-1" ' + cancelCommentStyle + '>' +
                                                            '<span class="delete_post" onclick="deleteComment(' + item_id + ', ' + comment_id + ');" >&times;</span>' +
                                                        '</div>' +*/
                                                    '</div>' +
                                                    '<p id="comment_' + item_id + '_' + comment_id + '">' + 
                                                        getLinkText(comment_text) + '</p>' +
                                               '</td>' +
                                           '</tr>';
                        }
                        
                        if( show_details ){
                            commentHtml += '<tr id="showMoreCommentsTr_' + item_id + '"><td style="padding-top:0px; padding-bottom:0px;padding-right:1px;text-align: center;">' +
                                                '<a href="#" data-toggle="modal" data-target="#feedDetailModal" ' +
                                                   'data-backdrop="static" data-keyboard="true" id="showFeedDetail_' + item_id + '" >' +
                                                    'Show More Comments ' +
                                                '</a>' +
                                            '</td></tr>';
                        }
                        
                        commentHtml +=          '</table>' +
                                            '</div>' +
                                        '</div>';
                    }
                    
                    feed_html = feed_html + commentHtml;
                    feed_html += '<div class="row">' +
                                        '<div class="col-sm-10" style="padding-right:1px;">' +
                                            '<textarea class="form-control" id="comment_box_' + item_id + '" ' +
                                                ' rows="1" value="" style="border-radius:0px;"></textarea>' +
                                        '</div>' +
                                        '<div class="col-sm-2">' +
                                            '<input type="button" id="commentSubmitBtn' + item_id + '" ' +
                                                ' class="btn btn-sm btn-primary" style="height:34px;" value="COMMENT" ' + 
                                                ' onclick="postSchoolClassComment(' + item_id + ', \'comment_box_' + item_id + '\' );" >' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-sm-2">' +
                                '</div>' +
                            '</div>';
                }
            }
            cnt++;
        }
    }
    return feed_html;
}

function getLinkText( text ){
    var pattern = /(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/;
    if( pattern.test( text ) ){
        var res = text.replace(pattern, function replaceFunc(x){return '<a href="' + x + '" target="_blank" >' + x + '</a>' });
        return res;
    } else {
        return text;
    }
}

function getMoreSchoolClassFeedHtml( class_id ){
    return '<div class="row" id="showMoreFeedDiv">' +
               '<div class="col-sm-8 col-sm-offset-1" style="text-align:center;margin-top:5px;">' +
                   '<div class="col-sm-10">' +
                       '<button type="button" class="btn btn-primary" onclick="showMoreSchoolClassFeed(' + class_id + ');" >' +
                           '&nbsp;' +
                           '<span class="glyphicon glyphicon glyphicon-menu-down"></span>' +
                           '&nbsp;' +
                           'SHOW MORE' +
                           '&nbsp;' +
                           '<span class="glyphicon glyphicon-menu-down"></span>' +
                           '&nbsp;' +
                       '</button>' +
                   '</div>' +
               '</div>' +
           '</div>';
}

function postSchoolClassComment( item_id, comment_box_id ){
    var comment = $('#' + comment_box_id ).val();
    if( typeof comment != 'undefined' && comment.trim() == '' ){
        alert( "Please enter a comment!" );
        return;
    }
    var url = '/postClassComment';
    var datastring = 'item_id=' + item_id + '&comment=' + encodeURIComponent( comment );
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( typeof responseText != "string" ){
                var comment_id = responseText[0];
                var username = responseText[1].trim();
                var comment_time = responseText[2].trim();
                
                var username_id = 'comment_username_' + item_id + '_' + comment_id;
                var comment_time_id = 'comment_time_' + item_id + '_' + comment_id;
                var comment_box_upd_id = 'comment_box_' + item_id;
                var comment_p_id = 'comment_' + item_id + '_' + comment_id;
                var showMoreCommentsTr_id = 'showMoreCommentsTr_' + item_id;
                var commentTableId = 'commentTable_' + item_id;
                var commentDivId = 'commentsForPost_' + item_id;

                if( comment_box_id.trim() == 'commentDetailText_' + item_id ){
                    username_id = 'commentDetail_username_' + item_id + '_' + comment_id;
                    comment_time_id = 'commentDetail_time_' + item_id + '_' + comment_id;
                    comment_box_upd_id = 'commentDetailText_' + item_id;
                    comment_p_id = 'commentDetail_' + item_id + '_' + comment_id;
                    showMoreCommentsTr_id = 'showMoreCommentsTr';
                    commentTableId = 'feedDetailCommentTable';
                    commentDivId =  'feedDetailComments';
                }
    
    
                var commentHtml = '<tr>' +
                                      '<td style="padding-top:0px; padding-bottom:0px;padding-right:1px;">' +
                                           '<div class="row" style="margin-right:0px;">' +
                                               '<div class="col-sm-6">' +
                                                   '<p style="width:100%;"><strong id="' + username_id + '">'+ 
                                                       username + '</strong></p>' +
                                               '</div>' +
                                               '<div class="col-sm-3 col-sm-offset-3 feed_time_comment_div">' +
                                                   '<p style="width:100%;">' + 
                                                       '<span class="delete_post" onclick="deleteComment(' + item_id + ', ' + 
                                                                       comment_id + ');" style="float:right;">&nbsp;&nbsp;&times;</span>' +
                                                       '<small id="' + comment_time_id + '" style="float:right;padding-top:4px;">'+ 
                                                           comment_time + '</small>' + 
                                                   '</p>' +
                                               '</div>' +
                                           '</div>' +
                                           '<p id="' + comment_p_id + '">' + 
                                               getLinkText(comment) + '</p>' +
                                      '</td>' +
                                  '</tr>';
                       
                if( $('#' + showMoreCommentsTr_id).length ){
                    $('#' + showMoreCommentsTr_id).remove();   
                    if( comment_box_id.trim() == 'commentDetailText_' + item_id ){
                        commentHtml +='<tr id="showMoreCommentsTr"><td style="padding-top:0px; padding-bottom:0px;padding-right:1px;text-align: center;">' +
                                            '<a href="#" id="showMoreFeedDetail_' + item_id + '" onclick="fetchSchoolClassCommentDetails(' + item_id + ', ' + comment_id + ');" >' +
                                                'Show More Comments ' +
                                            '</a>' +
                                        '</td></tr>';
                    } else {
                        commentHtml += '<tr id="' + showMoreCommentsTr_id + '"><td style="padding-top:0px; padding-bottom:0px;padding-right:1px;text-align: center;">' +
                                            '<a href="#" data-toggle="modal" data-target="#feedDetailModal" ' +
                                               'data-backdrop="static" data-keyboard="true" id="showFeedDetail_' + item_id + '" >' +
                                                'Show More Comments ' +
                                            '</a>' +
                                        '</td></tr>';
                    }
                    $('#' + commentTableId + ' tr:last').after(commentHtml);
                } else {
                    if( $('#' + commentTableId + ' tr:last').length ){
                        $('#' + commentTableId + ' tr:last').after(commentHtml);
                    } else {
                        var commentSection = '<div id="' + commentDivId + '" class="row feed_detail_div" >' +
                                                '<div class="col-sm-10" style="padding-right:0px;">' +
                                                    '<table class="table table-bordered table-responsive" id="' + commentTableId + '" ' +
                                                          ' style="background:#efecec;margin:0px;">';
                        
                        commentSection += commentHtml;
                        commentSection +=        '</table>' +
                                             '</div>' +
                                         '</div>';
                        
                        if( comment_box_id.trim() != 'commentDetailText_' + item_id ){
                            if( $('#feedImageDiv_' + item_id).length ){
                                $(commentSection).insertAfter( '#feedImageDiv_' + item_id );
                            } else {
                                $(commentSection).insertAfter( '#feed_item_text_' + item_id );
                            }
                        }
                        
                    }
                    
                }
                $('#' + comment_box_upd_id ).val('');
                
            }
            /* if( typeof responseText != "string" ){
                var comment_id = responseText[0];
                var username = responseText[1].trim();
                var comment_time = responseText[2].trim();
                var commentHtml = '<tr>' +
                                      '<td style="padding-top:0px; padding-bottom:0px;padding-right:1px;">' +
                                           '<div class="row" style="margin-right:0px;">' +
                                               '<div class="col-sm-6">' +
                                                   '<p style="width:100%;"><strong id="comment_username_' + item_id + '_' + comment_id + '">'+ 
                                                       username + '</strong></p>' +
                                               '</div>' +
                                               '<div class="col-sm-3 col-sm-offset-3 feed_time_comment_div">' +
                                                   '<p style="width:100%;">' + 
                                                       '<span class="delete_post" onclick="deleteSchoolClassComment(' + item_id + ', ' + 
                                                                       comment_id + ');" style="float:right;">&nbsp;&nbsp;&times;</span>' +
                                                       '<small id="comment_time_' + item_id + '_' + comment_id + '" style="float:right;padding-top:4px;">'+ 
                                                           comment_time + '</small>' + 
                                                   '</p>' +
                                               '</div>' +
                                           '</div>' +
                                           '<p id="comment_' + item_id + '_' + comment_id + '">' + 
                                               comment + '</p>' +
                                      '</td>' +
                                  '</tr>';
                       
                if( $('#showMoreCommentsTr_' + item_id).length ){
                    $('#showMoreCommentsTr_' + item_id).remove();
                    commentHtml += '<tr id="showMoreCommentsTr_' + item_id + '"><td style="padding-top:0px; padding-bottom:0px;padding-right:1px;text-align: center;">' +
                                       '<a href="#" data-toggle="modal" data-target="#feedDetailModal" ' +
                                          'data-backdrop="static" data-keyboard="true" id="showFeedDetail_' + item_id + '" >' +
                                           'Show More Comments ' +
                                       '</a>' +
                                   '</td></tr>';
                    $('#commentTable_' + item_id + ' tr:last').after(commentHtml);
                } else {
                    if( $('#commentTable_' + item_id + ' tr:last').length ){
                        $('#commentTable_' + item_id + ' tr:last').after(commentHtml);
                    } else {
                        var commentSection = '<div id="commentsForPost_' + item_id + '" class="row feed_detail_div" >' +
                                                '<div class="col-sm-10" style="padding-right:0px;">' +
                                                    '<table class="table table-bordered table-responsive" id="commentTable_' + item_id + '" ' +
                                                          ' style="background:#efecec;margin:0px;">';
                        
                        commentSection += commentHtml;
                        commentSection +=        '</table>' +
                                             '</div>' +
                                         '</div>';
                        
                        if( $('#feedImageDiv_' + item_id).length ){
                            $(commentSection).insertAfter( '#feedImageDiv_' + item_id );
                        } else {
                            $(commentSection).insertAfter( '#feed_item_text_' + item_id );
                        }
                        
                    }
                    
                }
                $('#comment_box_' + item_id ).val('');
            } */
        }
    });    
}

function deleteSchoolClassPost( item_id, class_id ){
    var url = '/deleteClassPost';
    var datastring = 'item_id=' + item_id + '&class_id=' + class_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            var isInit = true;
            var feedHtml = getSchoolClassFeedHtml( responseText, isInit, class_id );
            var moreFeedHtml = getMoreSchoolClassFeedHtml( class_id );
            feedHtml += moreFeedHtml;
            $('#homeContentDiv').html(feedHtml);
        }
    });
}

function deleteSchoolClassComment( item_id, comment_id ){
    var url = '/deleteComment';
    var datastring = 'item_id=' + item_id + '&comment_id=' + comment_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( $('#feedDetailModal').hasClass('in') ){
                $('#commentDetail_username_' + item_id + '_' + comment_id ).closest('tr').remove();
            }
            $('#comment_' + item_id + '_' + comment_id).closest('tr').remove();
        }
    });
}

function showMoreSchoolClassFeed( class_id ){
    var url = '/fetchClassForumItems';
    var datastring = 'to_time=' + $('#last_feed_fetched_time').val() + '&class_id=' + class_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            console.log(responseText);
            $('#showMoreFeedDiv').remove();
            var existingFeedHtml = $('#homeContentDiv').html();
            var isInit = false;
            var feedHtml = getSchoolClassFeedHtml( responseText, isInit, class_id );
            var moreFeedHtml = getMoreSchoolClassFeedHtml( class_id );
            $('#homeContentDiv').html( existingFeedHtml + feedHtml + moreFeedHtml );
            $('#homeContentDiv').prop("scrollTop", $('#homeContentDiv').prop("scrollTop") + 150 );
            //$('#homeContentDiv')[0].scrollBy(0, 50);
        }
    });
}

$('#feedDetailModal').on('shown.bs.modal', function(e){
    var invoker_id = $(e.relatedTarget).attr("id");
    var item_id = invoker_id.split("_");
    item_id = item_id[1].trim();
    
    var url = '/getFeedDetails';
    var datastring = 'item_id=' + item_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            var feedDetailHtml = getSchoolClassFeedDetailHtml( responseText );
            $('#feedDetailModalContent').html( feedDetailHtml );
        }
    });    
});

$('#feedDetailModal').on('hidden.bs.modal', function(e){
    $('#feedDetailModalContent').html( '' );
});

function getSchoolClassFeedDetailHtml( dataJson ){
    feedDetailHtml = '';
    if( 'commentArray' in dataJson && 'item_id' in dataJson && 'item_text' in dataJson && 'item_type' in dataJson
            && 'pic_url' in dataJson && 'posted_at' in dataJson && 'user_id' in dataJson && 'user_name' in dataJson ){
        
        var commentArray = dataJson['commentArray'];
        var item_id = dataJson['item_id'];
        var item_text = dataJson['item_text'];
        var item_type = dataJson['item_type'];
        var pic_url = dataJson['pic_url'];
        var posted_at = dataJson['posted_at'];
        var user_id = dataJson['user_id'];
        var user_name = dataJson['user_name'];
        var pictureHtml = '';
        
        if( item_type == '2' && pic_url != '' ){
            pictureHtml = '<br><img id="feedDetailImage" class="img-rounded img-responsive" style="padding-bottom:20px;" ' +
                                ' src="' + base_url + '/images/8/'+ pic_url.trim() +'"  alt="Picture">';
        }
        var feedDetailHtml = '<div class="row">' +
                              '<div class="col-sm-10 col-sm-offset-1">' +
                                  '<div class="row">' +
                                      '<div class="col-sm-4">' +
                                          '<p style="width:100%;"><strong id="feedDetailName">' + user_name + '</strong></p>' +
                                      '</div>' +
                                      '<div class="col-sm-2 col-sm-offset-4 feed_time_div">' +
                                          '<p style="width:100%;"><small id="feedDetailTime">' + posted_at + '</small></p>' +
                                      '</div>' +
                                  '</div>' +
                                  '<p style="width:100%;" id="feedDetailText">' + item_text + '</p>' +
                                   pictureHtml +
                                  '<div id="feedDetailComments" class="row feed_detail_div" >' +
                                      '<div class="col-sm-10" style="padding-right:0px;">' +
                                          '<table class="table table-bordered table-responsive" id="feedDetailCommentTable" ' +
                                                ' style="background:#efecec;margin:0px;">';
                                        
                                        
        if( 'comments' in commentArray && 'more_comments' in commentArray ){
            var comments = commentArray['comments'];
            var more_comments = commentArray['more_comments'];
            var comment_id;
            for( var i=0; i < comments.length; i++ ){
                comment_id = comments[i]['comment_id'];
                var comment_text = comments[i]['comment_text'];
                var editable = comments[i]['editable'];
                var posted_at = comments[i]['posted_at'];
                var user_id = comments[i]['user_id'];
                var user_name = comments[i]['user_name'];
                var editable_comment = comments[i]['editable'];
                
                var cancelCommentStyle = ' style="display:none;" ';
                if( editable_comment ){
                    cancelCommentStyle = ' style="display:block;" ';
                }
                            
                feedDetailHtml += '<tr>' +
                                      '<td style="padding-top:0px; padding-bottom:0px;padding-right:1px;">' +
                                           '<div class="row">' +
                                               '<div class="col-sm-6">' +
                                                   '<p style="width:100%;"><strong id="commentDetail_username_' + item_id + '_' + comment_id + '">'+ 
                                                       user_name + '</strong></p>' +
                                               '</div>' +
                                               '<div class="col-sm-2 col-sm-offset-3 feed_time_comment_div">' +
                                                   '<p style="width:100%;"><small id="commentDetail_time_' + item_id + '_' + comment_id + '">'+ 
                                                           posted_at + '</small></p>' +
                                               '</div>' +
                                               '<div class="col-sm-1" ' + cancelCommentStyle + '>' +
                                                   '<span class="delete_post" onclick="deleteSchoolClassComment(' + item_id + ', ' + comment_id + ');" >&times;</span>' +
                                               '</div>' +
                                           '</div>' +
                                           '<p id="comment_' + item_id + '_' + comment_id + '">' + 
                                               getLinkText(comment_text) + '</p>' +
                                      '</td>' +
                                  '</tr>';
            }
        }
        
        if( more_comments ){
            feedDetailHtml += '<tr id="showMoreCommentsTr"><td style="padding-top:0px; padding-bottom:0px;padding-right:1px;text-align: center;">' +
                                '<a href="#" id="showMoreFeedDetail_' + item_id + '" onclick="fetchSchoolClassCommentDetails(' + item_id + ', ' + comment_id + ');" >' +
                                    'Show More Comments ' +
                                '</a>' +
                            '</td></tr>';
        }
                        
        feedDetailHtml +=                 '</table>' +
                                      '</div>' +
                                  '</div>' +
                                  '<div class="row">' +
                                      '<div class="col-sm-10" style="padding-right:0px;">' +
                                          '<textarea class="form-control" id="commentDetailText_' + item_id + '" rows="1" ' +
                                                   ' value="" style="border-radius:0px;"></textarea>' +
                                      '</div>' +
                                      '<div class="col-sm-2">' +
                                          '<input type="button" id="commentDetailSubmitBtn_' + item_id + '" class="btn btn-sm btn-primary" ' + 
                                                ' style="height:34px;" value="COMMENT" ' + 
                                                ' onclick="postSchoolClassComment(' + item_id + ', \'commentDetailText_' + item_id + '\' );">' +
                                      '</div>' +
                                  '</div>' +
                              '</div>' +
                              '<div class="col-sm-2">' +
                              '</div>' +
                          '</div>';
        
    }
    
    return feedDetailHtml;
}

function fetchSchoolClassCommentDetails( item_id, comment_id ){
    var url = '/fetchComments';
    var datastring = 'item_id=' + item_id + '&comment_id=' + comment_id;    
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            console.log(responseText);
            var existingComments = '';
            if( 'comments' in responseText && 'more_comments' in responseText ){
                $('#showMoreCommentsTr').remove();
                existingComments = $('#feedDetailCommentTable').html();
                var comments = responseText['comments'];
                var more_comments = responseText['more_comments'];
                var comment_id;
                var feedDetailCommentsHtml = '';
                for( var i=0; i < comments.length; i++ ){
                    comment_id = comments[i]['comment_id'];
                    var comment_text = comments[i]['comment_text'];
                    var editable = comments[i]['editable'];
                    var posted_at = comments[i]['posted_at'];
                    var user_id = comments[i]['user_id'];
                    var user_name = comments[i]['user_name'];
                    var editable_comment = comments[i]['editable'];

                    var cancelCommentStyle = ' display:none; ';
                    if( editable_comment ){
                        cancelCommentStyle = ' display:block; ';
                    }

                    feedDetailCommentsHtml += '<tr>' +
                                      '<td style="padding-top:0px; padding-bottom:0px;padding-right:1px;">' +
                                           '<div class="row" style="margin-right:0px;">' +
                                               '<div class="col-sm-6">' +
                                                   '<p style="width:100%;"><strong id="commentDetail_username_' + item_id + '_' + comment_id + '">'+ 
                                                       user_name + '</strong></p>' +
                                               '</div>' +
                                               '<div class="col-sm-3 col-sm-offset-3 feed_time_comment_div">' +
                                                   '<p style="width:100%;">' + 
                                                       '<span class="delete_post" onclick="deleteSchoolClassComment(' + item_id + ', ' + 
                                                                       comment_id + ');" style="float:right;' + cancelCommentStyle + '">&nbsp;&nbsp;&times;</span>' +
                                                       '<small id="commentDetail_time_' + item_id + '_' + comment_id + '" style="float:right;padding-top:4px;">'+ 
                                                           posted_at + '</small>' + 
                                                   '</p>' +
                                               '</div>' +
                                           '</div>' +
                                           '<p id="commentDetail_' + item_id + '_' + comment_id + '">' + 
                                               comment_text + '</p>' +
                                      '</td>' +
                                  '</tr>';
                }
            }

            if( more_comments ){
                feedDetailCommentsHtml += '<tr id="showMoreCommentsTr"><td style="padding-top:0px; padding-bottom:0px;padding-right:1px;text-align: center;">' +
                                    '<a href="#" id="showMoreFeedDetail_' + item_id + '" onclick="fetchSchoolClassCommentDetails(' + item_id + ', ' + comment_id + ');" >' +
                                        'Show More Comments ' +
                                    '</a>' +
                                '</td></tr>';
            }
            
            $('#feedDetailCommentTable').html( existingComments + feedDetailCommentsHtml );
        }
    });
}

function showSchoolUploadedFileName( elem, filename_id ){
    var filename = $(elem).val();
    $('#' + filename_id ).html("Added file : " + filename );
}

function showSchoolFeedImage( item_id ){
    var pic_url = $('#pic_url_' + item_id ).val().trim();
    var imageHtml = '<img id="feedImage_' + item_id + '" class="img-rounded img-responsive" style="padding-bottom:20px;" ' +
                          ' src="' + base_url + '/images/8/'+ pic_url +'"  alt="Picture">';
    
    $('#feedImageDiv_' + item_id ).html(imageHtml);
    var showImageBtnHtml = '<span class="glyphicon glyphicon-eye-close">&nbsp;</span>HIDE IMAGE&nbsp;&nbsp;';
    
    $('#showFeedImageBtn_' + item_id).html( showImageBtnHtml );
    $('#showFeedImageBtn_' + item_id).removeClass('viewImage');
    $('#showFeedImageBtn_' + item_id).addClass('hideImage');
    $('#showFeedImageBtn_' + item_id).attr("onclick", "hideSchoolFeedImage(" + item_id + ");");
}

function hideSchoolFeedImage( item_id ){
    $('#feedImageDiv_' + item_id).html('');
    var showImageBtnHtml = '<span class="glyphicon glyphicon-eye-open">&nbsp;</span>VIEW IMAGE&nbsp;&nbsp;';
    
    $('#showFeedImageBtn_' + item_id).html( showImageBtnHtml );
    $('#showFeedImageBtn_' + item_id).removeClass('hideImage');
    $('#showFeedImageBtn_' + item_id).addClass('viewImage');
    $('#showFeedImageBtn_' + item_id).attr("onclick", "showSchoolFeedImage(" + item_id + ");");
}

$('#uploadPicModal').on('shown.bs.modal', function(e){
    var invoker_id = $(e.relatedTarget).attr("id");
    var class_id = invoker_id.split("_");
    class_id = class_id[1].trim();
    $('#pic_class_id').val( class_id );
});

function schoolClassForumOnload(){
    $('#accordion .panel-collapse').collapse( 'hide' );
    var selectedClass = $('#selectedClass').val().trim();
    if( selectedClass != '' ){
        var selectedClassId = $('#selectedClassId').val().trim();
        populateSchoolClassFeed( selectedClassId );
        $( '#collapse_' + selectedClass ).collapse('show');
    }
}

function toggleSelectAllClasses(){
    if( $('#addForumPostSelectAll').is(":checked") ){
        $('#addForumPostClass_error').css("display", "none");
        $('#addForumPostSection_error').css("display", "none");
        $('#addForumPostClass').val("");
        $('#addForumPostSection').val("");
        $('#addForumPostClass').prop("disabled", true);
        $('#addForumPostSection').prop("disabled", true);
        var allClassHtml = '<button class="btn btn-sm chosen_btn" id="postClassAll" '+
                               'onclick="removePostClass( this )">'+
                               '<span class="glyphicon glyphicon-remove"></span>'+
                               '<input type="hidden" value="-1">' +
                               '<strong>All Classes</strong>'+
                           '</button>';
                   
        $('#chosen_classes').html( allClassHtml );
        $('#addForumPostClassBtn').prop("disabled", true);
        //$('#addedClasses').val('');
    } else {
        $('#addForumPostClass').val("");
        $('#addForumPostSection').val("");
        $('#addForumPostClass').prop("disabled", false);
        $('#addForumPostSection').prop("disabled", false);
        $('#chosen_classes').html( '(None)' );
        $('#addForumPostClassBtn').prop("disabled", false);
    }
}

function populateForumClassSections(){
    var classJson = $('#classJson').val();
    var classes = JSON.parse(classJson);
    var class_val = $('#addForumPostClass :selected').val();
    var class_details = classes[class_val];
        
    var sectionHtml = ''; //'<option value="">Select Section</option>';
    var allSectionsClasses = '';
    for( var i=0; i < class_details.length; i++ ){
        allSectionsClasses += class_details[i]['class_id'] + ', ';
        sectionHtml += '<option value="' + class_details[i]['class_id'] + '">Section ' + class_details[i]['section'] + '</option>';
    }
    allSectionsClasses = allSectionsClasses.substr(0, allSectionsClasses.length - 2 );
    sectionHtml = '<option value="">Select</option><option value="' + allSectionsClasses + '">All Sections</option>' + sectionHtml;
    $('#addForumPostSection').html( sectionHtml );
}

function removePostClass( elem ){
    $( elem ).remove();
}

function addForumClass(){
    $('#addForumPostClass_error').css("display", "none");
    $('#addForumPostSection_error').css("display", "none");
    var selectedClass = $('#addForumPostClass').val().trim();
    var selectedSection = $('#addForumPostSection').val().trim();
    if( selectedClass == '' ){
        $('#addForumPostClass_error').css("display", "block");
    }
    if( selectedSection == '' ){
        $('#addForumPostSection_error').css("display", "block");
    } else {
        var selectedClassName = $('#addForumPostClass :selected').html() + ' - ' + $('#addForumPostSection :selected').html();
        var selectedClassBtnHtml = '<button class="btn btn-sm chosen_btn" ' +
                                       'onclick="removePostClass(this)">' +
                                       '<span class="glyphicon glyphicon-remove"></span>' + 
                                       '<input type="hidden" value="' + selectedSection + '">' +
                                       '<strong>&nbsp;' + selectedClassName + '</strong>' +
                                   '</button>&nbsp;';
        
        var optionAlreadySelected = false;
        $('#chosen_classes').find('button').each(function(e){
            if($(this).html().indexOf( selectedClassName ) >= 0 ){
                optionAlreadySelected = true;
            }
        });
        
        if( optionAlreadySelected ){
            return;
        }
        
        if( $('#chosen_classes').html().trim() == '(None)' ){
            $('#chosen_classes').html( selectedClassBtnHtml );
            //$('#addedClasses').val( selectedSection );
        } else {
            $('#chosen_classes').html( $('#chosen_classes').html() + selectedClassBtnHtml ); 
            // $('#addedClasses').val( $('#addedClasses').val() + ', ' + selectedSection );
        }
    }
    
}

function validateAddForumPost(){
    if( $('#chosen_classes').html().trim() == '(None)' ){
        alert("Please select the class/es!!");
        return false;
    }
    var selectedClasses = '';
    $('#chosen_classes').find('input').each(function(e){
        selectedClasses += $(this).val() + ', ';
    });
    
    selectedClasses = selectedClasses.trim()
    if( selectedClasses.length >= 2 ){
        selectedClasses = selectedClasses.substr( 0, selectedClasses.length - 1 );
    }
    var add_pic_filename = $('#add-pic-file-info').html().trim();
    var entered_text = $('#addForumPostText').val().trim();
    if( add_pic_filename == '' && entered_text == '' ){
        alert("Please enter a message OR include a picture!");
        return false;
    }
    $('#addedClasses').val( selectedClasses );
    return true;
}

//studentCollapseDiv
$('#collapse_Students').on('shown.bs.collapse', function(e){
    var leftTable = document.getElementById('studentLeftTable');
    if( leftTable.rows.length > 1 ){
        return;
    }
    populateStudentList();    
});

function clearStudentList(){
    var leftTable = document.getElementById('studentLeftTable');
    var rightTable = document.getElementById('studentRightTable');
    
    while( leftTable.rows.length > 1 ){
        leftTable.deleteRow( -1 );
    }
    
    while( rightTable.rows.length > 1 ){
        rightTable.deleteRow( -1 );
    }
}
function populateStudentList(){
    var class_id = $('#editSubjectsClassId').val();
    clearStudentList();
    
    var url = '/getClassStudents';
    var datastring = 'class_id=' + class_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( Array.isArray(responseText) && responseText.length > 0 ){
                var num_students = responseText.length;
                var num_left_col = Math.ceil(num_students/2);
                
                var leftTableHtml = '';
                var rightTableHtml = '';
                var profilePicBaseUrl = $('#profilePicBaseUrl').val().trim();
                var defaultProfilePic = $('#profilePicDefault').val().trim();
                
                console.log(responseText);
                for( var i=0; i < num_left_col; i++ ){
                    var student_pic_url = profilePicBaseUrl + '/' + 
                                            (responseText[i]['pic_url'].trim() == '' ? defaultProfilePic : responseText[i]['pic_url'].trim());
                    var father_pic_url = profilePicBaseUrl + '/' + 
                                            (responseText[i]['father_pic_url'].trim() == '' ? defaultProfilePic : responseText[i]['father_pic_url'].trim());
                    var mother_pic_url = profilePicBaseUrl + '/' + 
                                            (responseText[i]['mother_pic_url'].trim() == '' ? defaultProfilePic : responseText[i]['mother_pic_url'].trim());
                    
                    leftTableHtml += '<tr>' +
                                        '<td style="text-align: center;">' + responseText[i]['student_roll_no'].trim() + '</td>' +
                                        '<td class="class_student" data-toggle="modal" data-target="#studentDetailModal" ' + 
                                            ' data-backdrop="static" id="student_id_' + responseText[i]['student_id'].trim() + '">' + 
                                            '<p id="student_name_' + responseText[i]['student_id'].trim() + '" >' + 
                                                responseText[i]['student_name'].trim() + 
                                            '</p>' + 
                                            '<input type="hidden" id="student_pic_url_' + responseText[i]['student_id'].trim() + 
                                                    '" value="' + student_pic_url + '" >' +
                                            '<input type="hidden" id="student_father_pic_url_' + responseText[i]['student_id'].trim() + 
                                                    '" value="' + father_pic_url + '" >' +
                                            '<input type="hidden" id="student_mother_pic_url_' + responseText[i]['student_id'].trim() + 
                                                    '" value="' + mother_pic_url + '" >' +
                                        '</td>' +
                                    '</tr>';
                }
                for( ; i < num_students; i++ ){
                    var student_pic_url = profilePicBaseUrl + '/' + 
                                            (responseText[i]['pic_url'].trim() == '' ? defaultProfilePic : responseText[i]['pic_url'].trim());
                    var father_pic_url = profilePicBaseUrl + '/' + 
                                            (responseText[i]['father_pic_url'].trim() == '' ? defaultProfilePic : responseText[i]['father_pic_url'].trim());
                    var mother_pic_url = profilePicBaseUrl + '/' + 
                                            (responseText[i]['mother_pic_url'].trim() == '' ? defaultProfilePic : responseText[i]['mother_pic_url'].trim());
                                    
                    rightTableHtml += '<tr>' +
                                        '<td style="text-align: center;">' + responseText[i]['student_roll_no'].trim() + '</td>' +
                                        '<td class="class_student" data-toggle="modal" data-target="#studentDetailModal" ' + 
                                            ' data-backdrop="static" id="student_id_' + responseText[i]['student_id'].trim() + '">' + 
                                            '<p id="student_name_' + responseText[i]['student_id'].trim() + '" >' + 
                                                responseText[i]['student_name'].trim() + 
                                            '</p>' + 
                                            '<input type="hidden" id="student_pic_url_' + responseText[i]['student_id'].trim() + 
                                                    '" value="' + student_pic_url + '" >' +
                                            '<input type="hidden" id="student_father_pic_url_' + responseText[i]['student_id'].trim() + 
                                                    '" value="' + father_pic_url + '" >' +
                                            '<input type="hidden" id="student_mother_pic_url_' + responseText[i]['student_id'].trim() + 
                                                    '" value="' + mother_pic_url + '" >' +
                                        '</td>' +
                                    '</tr>';
                }
                
                $('#studentLeftTable tr:last').after(leftTableHtml);
                $('#studentRightTable tr:last').after(rightTableHtml);
            }
        },
        error : function( exception ){
            
        }
    });
}

