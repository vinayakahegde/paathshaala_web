$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

$('#applicationStatusModal').on('hidden.bs.modal', function () {
  $('#applicationStatusDetailsDiv').css("display", "none");
  $('#applicationStatusPhoneDiv').css("display", "block");
  $("#applicationStatusBtnDiv").css("display", "block");
});

$('#informationModal').on('show.bs.modal', function(e) {
    var invoker_id = $(e.relatedTarget).attr("id");
    var notif_id = invoker_id.split("_");
    notif_id = notif_id[1];
    var notif_text = $('#notif_text_' + notif_id ).val();
    notif_text = notif_text.replace(/ /g, "&nbsp;");
    notif_text = notif_text.replace(/\n/g, "<br>");
    $('#informationContentText').html(notif_text);
    $('#informationTitle').html($('#notif_head_' + notif_id ).val());
    var url = $('#img_url_' + notif_id ).val();
    var elementId = "informationContentImage";
    if( url.trim() != "" ){
        loadImage( elementId, url );
    }
});

$('#informationModal').on('hidden.bs.modal', function() {
    $('#informationContentText').html('');
    $('#informationTitle').html('');
    $('#informationContentImage').attr("src", "");
});

$('#eventModal').on('show.bs.modal', function(e) {
    var invoker_id = $(e.relatedTarget).attr("id");
    var notif_id = invoker_id.split("_");
    notif_id = notif_id[1];
    var notif_text = $('#notif_text_' + notif_id ).val();
    notif_text = notif_text.replace(/ /g, "&nbsp;");
    notif_text = notif_text.replace(/\n/g, "<br>");
    $('#eventContentText').html(notif_text);
    $('#eventTitle').html($('#notif_head_' + notif_id ).val());
    var url = $('#img_url_' + notif_id ).val();
    var elementId = "eventContentImage";
    if( url.trim() != "" ){
        loadImage( elementId, url );
    }
});

$('#eventModal').on('hidden.bs.modal', function() {
    $('#eventContentText').html('');
    $('#eventTitle').html('');
    $('#eventContentImage').attr("src", "");
});

$('#notificationModal').on('show.bs.modal', function(e) {
    var invoker_id = $(e.relatedTarget).attr("id");
    var notif_id = invoker_id.split("_");
    notif_id = notif_id[1];
    var notif_text = $('#home_notif_text_' + notif_id ).val();
    notif_text = notif_text.replace(/ /g, "&nbsp;");
    notif_text = notif_text.replace(/\n/g, "<br>");
    $('#notificationContentText').html(notif_text);
    $('#notificationTitle').html($('#' + invoker_id ).html());
    var url = $('#home_notif_image_' + notif_id ).val();
    var elementId = "notificationContentImage";
    if( url.trim() != "" ){
        loadImage( elementId, url );
    }
});

$('#notificationModal').on('hidden.bs.modal', function() {
    $('#notificationContentText').html('');
    $('#notificationTitle').html('');
    $('#notificationContentImage').attr("src", "");
});

$('#boardMemberModal').on('show.bs.modal', function(e) {
    var invoker_id = $(e.relatedTarget).attr("id");
    var member_id = invoker_id.split("_");
    member_id = member_id[3];
    var member_description = $('#mem_desc_' + member_id ).val();
    member_description = member_description.replace(/ /g, "&nbsp;");
    member_description = member_description.replace(/\n/g, "<br>");
    $('#boardMemberContentText').html(member_description);
    $('#boardMemberTitle').html($('#mem_name_' + member_id ).val());
    var i = 0;
    var member_phone = $('#mem_phone_' + member_id ).val();
    var member_email = $('#mem_email_' + member_id ).val();
    var member_website = $('#mem_website_' + member_id ).val();
    var member_blog = $('#mem_blog_' + member_id ).val();
    var member_twitter_handle = $('#mem_twitter_handle_' + member_id ).val();
    var member_contact_details_tbl = document.getElementById("boardMemContactsTbl");
    while( member_contact_details_tbl.rows.length > 0 ){
        member_contact_details_tbl.deleteRow( -1 );
    }
    
    if( member_phone && member_phone != "" ){
        var row = member_contact_details_tbl.insertRow(i);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = "<strong>Phone</strong>";
        cell2.innerHTML = member_phone;
        i++;
    }
    if( member_email && member_email != "" ){
        var row = member_contact_details_tbl.insertRow(i);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = "<strong>Email</strong>";
        cell2.innerHTML = member_email;
        i++;
    }
    if( member_website && member_website != "" ){
        var row = member_contact_details_tbl.insertRow(i);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = "<strong>Website</strong>";
        cell2.innerHTML = member_website;
        i++;
    }
    if( member_blog && member_blog != "" ){
        var row = member_contact_details_tbl.insertRow(i);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = "<strong>Blog</strong>";
        cell2.innerHTML = member_blog;
        i++;
    }
    if( member_twitter_handle && member_twitter_handle != "" ){
        var row = member_contact_details_tbl.insertRow(i);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = "<strong>Twitter</strong>";
        cell2.innerHTML = member_twitter_handle;
        i++;
    }
    var url = $('#mem_img_url_' + member_id ).val();
    var elementId = "boardMemberContentImage";
    if( url.trim() != "" ){
        loadImage( elementId, url );
    }
});

$('#boardMemberModal').on('hidden.bs.modal', function() {
    var member_contact_details_tbl = document.getElementById("boardMemContactsTbl");
    while( member_contact_details_tbl.rows.length > 0 ){
        member_contact_details_tbl.deleteRow( -1 );
    }
    $('#boardMemberContentText').html('');
    $('#boardMemberTitle').html('');
    $('#boardMemberContentImage').attr("src", "");
});

$('#facultyGeneralModal').on('show.bs.modal', function(e) {
    var invoker_id = $(e.relatedTarget).attr("id");
    var faculty_id = invoker_id.split("_");
    faculty_id = faculty_id[3];
    var faculty_description = $('#fg_desc_' + faculty_id ).val();
    faculty_description = faculty_description.replace(/ /g, "&nbsp;");
    faculty_description = faculty_description.replace(/\n/g, "<br>");
    $('#facultyGeneralContentText').html(faculty_description);
    $('#facultyGeneralTitle').html($('#fg_name_' + faculty_id ).val());
    var i = 0;
    var faculty_phone = $('#fg_phone_' + faculty_id ).val();
    var faculty_email = $('#fg_email_' + faculty_id ).val();
    var faculty_website = $('#fg_website_' + faculty_id ).val();
    var faculty_blog = $('#fg_blog_' + faculty_id ).val();
    var faculty_twitter_handle = $('#fg_twitter_handle_' + faculty_id ).val();
    var faculty_contact_details_tbl = document.getElementById("facultyGeneralContactsTbl");
    while( faculty_contact_details_tbl.rows.length > 0 ){
        faculty_contact_details_tbl.deleteRow( -1 );
    }
    
    if( faculty_phone && faculty_phone != "" ){
        var row = faculty_contact_details_tbl.insertRow(i);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = "<strong>Phone</strong>";
        cell2.innerHTML = faculty_phone;
        i++;
    }
    if( faculty_email && faculty_email != "" ){
        var row = faculty_contact_details_tbl.insertRow(i);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = "<strong>Email</strong>";
        cell2.innerHTML = faculty_email;
        i++;
    }
    if( faculty_website && faculty_website != "" ){
        var row = faculty_contact_details_tbl.insertRow(i);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = "<strong>Website</strong>";
        cell2.innerHTML = faculty_website;
        i++;
    }
    if( faculty_blog && faculty_blog != "" ){
        var row = faculty_contact_details_tbl.insertRow(i);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = "<strong>Blog</strong>";
        cell2.innerHTML = faculty_blog;
        i++;
    }
    if( faculty_twitter_handle && faculty_twitter_handle != "" ){
        var row = faculty_contact_details_tbl.insertRow(i);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = "<strong>Twitter</strong>";
        cell2.innerHTML = faculty_twitter_handle;
        i++;
    }
    var url = $('#fg_img_url_' + faculty_id ).val();
    var elementId = "facultyGeneralContentImage";
    if( url.trim() != "" ){
        loadImage( elementId, url );
    }
});

$('#facultyGeneralModal').on('hidden.bs.modal', function() {
    var member_contact_details_tbl = document.getElementById("facultyGeneralContactsTbl");
    while( member_contact_details_tbl.rows.length > 0 ){
        member_contact_details_tbl.deleteRow( -1 );
    }
    $('#facultyGeneralContentText').html('');
    $('#facultyGeneralTitle').html('');
    $('#facultyGeneralContentImage').attr("src", "");
});

$('#calendarEventModal').on('show.bs.modal', function(e) {
    var day_panel_id = $(e.relatedTarget).attr("id");
    var day          = $(e.relatedTarget).find('p')[0].innerHTML;
    day_panel_id = day_panel_id.substring( 0, day_panel_id.length - 5);
    
    var cal_event_desc = $('#' + day_panel_id + 'desc' ).val(); // $('#' + day + '_desc').val();
    var cal_event_type = $('#' + day_panel_id + 'event_type' ).val(); //$('#' + day + '_event_type').val();
    cal_event_desc = cal_event_desc.replace(/ /g, "&nbsp;");
    cal_event_desc = cal_event_desc.replace(/\n/g, "<br>");
    $('#calendarEventContentText').html( cal_event_desc );
    
    if( cal_event_type == 2 ){
        $('#calendarEventModalHeader').removeClass("light_background");//calendar-event
        $('#calendarEventModalHeader').addClass("holiday");
    } else {
        $('#calendarEventModalHeader').removeClass("holiday");
        $('#calendarEventModalHeader').addClass("light_background");//calendar-event
    }
    /*var url = $('#img_url_' + notif_id ).val();
    var elementId = "calendarEventContentImage";
    if( url.trim() != "" ){
        loadImage( elementId, url );
    }*/
});

$('#calendarEventModal').on('hidden.bs.modal', function() {
    $('#informationContentText').html('');
    $('#informationTitle').html('');
    $('#informationContentImage').attr("src", "");
});

function doLogin(){
    alert("doing login");
}

function showAdmissionPopup(){
    document.getElementById('applicationDetails').style.visibility = 'visible';
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

function closeApplicationDetails(){
    document.getElementById('applicationDetails').style.visibility = 'hidden';
    
    $('#studentNameMessage').html("");
    $('#fatherNameMessage').html("");
    $('#motherNameMessage').html("");
    $('#addressMessage').html("");
    $('#pincodeMessage').html("");
    $('#phoneNumMessage').html("");
    $('#emailIDMessage').html("");
    $('#fatherQualificationMessage').html("");
    $('#motherQualificationMessage').html("");
    $('#motherTongueMessage').html("");
    $('#annualIncomeMessage').html("");
    $('#forClassMessage').html("");
    
    $('#studentNameMessage').css("display","none");
    $('#fatherNameMessage').css("display","none");
    $('#motherNameMessage').css("display","none");
    $('#addressMessage').css("display","none");
    $('#pincodeMessage').css("display","none");
    $('#phoneNumMessage').css("display","none");
    $('#emailIDMessage').css("display","none");
    $('#fatherQualificationMessage').css("display","none");
    $('#motherQualificationMessage').css("display","none");
    $('#motherTongueMessage').css("display","none");
    $('#annualIncomeMessage').css("display","none");
    $('#forClassMessage').css("display","none");
}

function validateApplication(){
    var validApplication = true;
    var studentName = $('#studentName').val().trim();
    var fatherName = $('#fatherName').val().trim();
    var motherName = $('#motherName').val().trim();
    var address = $('#address').val().trim();
    var pincode = $('#pincode').val().trim();
    var phoneNum = $('#phoneNum').val().trim();
    var emailID = $('#emailID').val().trim();
    
    var fatherQualElem = document.getElementById("fatherQualification");
    var fatherQual = fatherQualElem.options[fatherQualElem.selectedIndex].value.trim();
    
    var motherQualElem = document.getElementById("motherQualification");
    var motherQual = motherQualElem.options[motherQualElem.selectedIndex].value.trim();
    
    var motherTongueElem = document.getElementById("motherTongue");
    var motherTongue = motherTongueElem.options[motherTongueElem.selectedIndex].value.trim();
    
    var annualIncomeElem = document.getElementById("annualIncome");
    var annualIncome = annualIncomeElem.options[annualIncomeElem.selectedIndex].value.trim();
    
    var forClassElem = document.getElementById("forClass");
    var forClass = forClassElem.options[forClassElem.selectedIndex].value.trim();
    
    if( studentName == "" || studentName.length < 5 ){
        validApplication = false;
        $('#studentNameDiv').addClass("has-error has-feedback");
        $('#studentNameMessage').css("display","block");
        $('#studentNameMessage').html("    * Please enter the full name of the student");
    }
    
    if( fatherName == "" || fatherName.length < 5 ){
        validApplication = false;
        $('#fatherNameDiv').addClass("has-error has-feedback");
        $('#fatherNameMessage').css("display","block");
        $('#fatherNameMessage').html("    * Please enter the full name of the father");
    }
    
    if( motherName == "" || motherName.length < 5 ){
        validApplication = false;
        $('#motherNameDiv').addClass("has-error has-feedback");
        $('#motherNameMessage').css("display","block");
        $('#motherNameMessage').html("    * Please enter the full name of the mother");
    }
    
    if( address == "" || address.length < 10 ){
        validApplication = false;
        $('#homeAddressDiv').addClass("has-error has-feedback");
        $('#addressMessage').css("display","block");
        $('#addressMessage').html("    * Please enter the address");
    }

    if( pincode == "" || pincode.length != 6 ){
        validApplication = false;
        $('#pincodeDiv').addClass("has-error has-feedback");
        $('#pincodeMessage').css("display","block");
        $('#pincodeMessage').html("    * Please enter a valid PIN code");
    }
    
    if( phoneNum == "" ){
        validApplication = false;
        $('#contactNumberDiv').addClass("has-error has-feedback");
        $('#phoneNumMessage').css("display","block");
        $('#phoneNumMessage').html("    * Please enter the contact phone number");
    }
    
    if( emailID == "" ){
        validApplication = false;
        $('#contactEmailDiv').addClass("has-error has-feedback");
        $('#emailIDMessage').css("display","block");
        $('#emailIDMessage').html("    * Please enter the email id to contact. Enter \"None\" if you don't have an email id");
    }
    
    if( fatherQual == "" ){
        validApplication = false;
        $('#fatherQualDiv').addClass("has-error has-feedback");
        $('#fatherQualificationMessage').css("display","block");
        $('#fatherQualificationMessage').html("    * Please select the educational qualification of the father");
    }
    
    if( motherQual == "" ){
        validApplication = false;
        $('#motherQualDiv').addClass("has-error has-feedback");
        $('#motherQualificationMessage').css("display","block");
        $('#motherQualificationMessage').html("    * Please select the educational qualification of the mother");
    }
    
    if( motherTongue == "" ){
        validApplication = false;
        $('#motherTongueDiv').addClass("has-error has-feedback");
        $('#motherTongueMessage').css("display","block");
        $('#motherTongueMessage').html("    * Please select the mother tongue of the student");
    }
    
    if( annualIncome == "" ){
        validApplication = false;
        $('#annualIncomeDiv').addClass("has-error has-feedback");
        $('#annualIncomeMessage').css("display","block");
        $('#annualIncomeMessage').html("    * Please select the annual income of the household");
    }
    
    if( forClass == "" ){
        validApplication = false;
        $('#forClassDiv').addClass("has-error has-feedback");
        $('#forClassMessage').css("display","block");
        $('#forClassMessage').html("    * Please select the class for which you are applying");
    }
    
    var studentName = $('#studentName').val().trim();
    var fatherName = $('#fatherName').val().trim();
    var motherName = $('#motherName').val().trim();
    var address = $('#address').val().trim();
    var pincode = $('#pincode').val().trim();
    var phoneNum = $('#phoneNum').val().trim();
    var emailID = $('#emailID').val().trim();
    
    var url = "/validateApplication";
    var datastring = "studentName="+encodeURIComponent(studentName)+"&fatherName="+encodeURIComponent(fatherName)+"&motherName="
                     +encodeURIComponent(motherName)+"&address="+encodeURIComponent(address)
                     +"&pincode="+encodeURIComponent(pincode)+"&phoneNum="+encodeURIComponent(phoneNum)+"&emailID="+encodeURIComponent(emailID);
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            //var response = jQuery.parseJSON(responseText);
            var response = responseText;
            if( response.studentName.trim() != "" ){
                validApplication = false;
                $('#studentNameDiv').addClass("has-error has-feedback");
                $('#studentNameMessage').css("display","block");
                $('#studentNameMessage').html( response.studentName.trim() );
            }
            
            if( response.fatherName.trim() != "" ){
                validApplication = false;
                $('#fatherNameDiv').addClass("has-error has-feedback");
                $('#fatherNameMessage').css("display","block");
                $('#fatherNameMessage').html( response.fatherName.trim() );
            }
            
            if( response.motherName.trim() != "" ){
                validApplication = false;
                $('#motherNameDiv').addClass("has-error has-feedback");
                $('#motherNameMessage').css("display","block");
                $('#motherNameMessage').html( response.motherName.trim() );
            }
            
            if( response.address.trim() != "" ){
                validApplication = false;
                $('#homeAddressDiv').addClass("has-error has-feedback");
                $('#addressMessage').css("display","block");
                $('#addressMessage').html( response.address.trim() );
            }
            
            if( response.pincode.trim() != "" ){
                validApplication = false;
                $('#pincodeDiv').addClass("has-error has-feedback");
                $('#pincodeMessage').css("display","block");
                $('#pincodeMessage').html( response.pincode.trim() );
            }
            
            if( response.phoneNum.trim() != "" ){
                validApplication = false;
                $('#contactNumberDiv').addClass("has-error has-feedback");
                $('#phoneNumMessage').css("display","block");
                $('#phoneNumMessage').html( response.phoneNum.trim() );
            }
            
            if( response.emailID.trim() != "" ){
                validApplication = false;
                $('#contactEmailDiv').addClass("has-error has-feedback");
                $('#emailIDMessage').css("display","block");
                $('#emailIDMessage').html( response.emailID.trim() );
            }
        },
        error:function( exception ){
            console.log("Exception " + exception);
        }
    });
    
    if( !validApplication ){
        alert("Application could not be submitted successfully.");
    }
    return validApplication;
}

function checkStudentName(){
    var studentName = $('#studentName').val().trim();    
    if( studentName == "" || studentName.length < 5 ){
        $('#studentNameDiv').addClass("has-error has-feedback");
        $('#studentNameMessage').css("display","block");
        $('#studentNameMessage').html("    * Please enter the full name of the student");
    } else {
        $('#studentNameDiv').removeClass("has-error has-feedback");
        $('#studentNameMessage').css("display","none");
    }
}

function checkFatherName(){
    var fatherName = $('#fatherName').val().trim();    
    if( fatherName == "" || fatherName.length < 5 ){
        $('#fatherNameDiv').addClass("has-error has-feedback");
        $('#fatherNameMessage').css("display","block");
        $('#fatherNameMessage').html( "    * Please enter the full name of the father" );
    } else {
        $('#fatherNameDiv').removeClass("has-error has-feedback");
        $('#fatherNameMessage').css("display","none");
    }
}

function checkMotherName(){
    var motherName = $('#motherName').val().trim();    
    if( motherName == "" || motherName.length < 5 ){
        $('#motherNameDiv').addClass("has-error has-feedback");
        $('#motherNameMessage').css("display","block");
        $('#motherNameMessage').html( "    * Please enter the full name of the father" );
    } else {
        $('#motherNameDiv').removeClass("has-error has-feedback");
        $('#motherNameMessage').css("display","none");
    }
}

function checkAddress(){
    var address = $('#address').val().trim();    
    if( address == "" || address.length < 10 ){
        $('#homeAddressDiv').addClass("has-error has-feedback");
        $('#addressMessage').css("display","block");
        $('#addressMessage').html( "    * Please enter the full name of the father" );
    } else {
        $('#homeAddressDiv').removeClass("has-error has-feedback");
        $('#addressMessage').css("display","none");
    }    
}
    
function checkPhoneNum(){
    var phoneNum = $('#phoneNum').val().trim();    
    if( phoneNum == "" || phoneNum.length < 10 || phoneNum.length > 11 || !$.isNumeric(phoneNum) ){
        $('#contactNumberDiv').addClass("has-error has-feedback");
        $('#phoneNumMessage').css("display","block");
        $('#phoneNumMessage').html( "    * Please enter a valid phone number" );
    } else {
        $('#contactNumberDiv').removeClass("has-error has-feedback");
        $('#phoneNumMessage').css("display","none");
    }   
}

function checkContactEmail(){
    var emailID = $('#emailID').val().trim();    
    if( emailID == "" ){
        $('#contactEmailDiv').addClass("has-error has-feedback");
        $('#emailIDMessage').css("display","block");
        $('#emailIDMessage').html( "    * Please enter a email id" );
    } else {
        $('#contactEmailDiv').removeClass("has-error has-feedback");
        $('#emailIDMessage').css("display","none");
    }    
}

function checkPinCode(){
    var pincode = $('#pincode').val().trim();    
    if( pincode == "" || pincode.length != 6 || !$.isNumeric(pincode) ){
        $('#pincodeDiv').addClass("has-error has-feedback");
        $('#pincodeMessage').css("display","block");
        $('#pincodeMessage').html( "    * Please enter a valid pincode" );
    } else {
        $('#pincodeDiv').removeClass("has-error has-feedback");
        $('#pincodeMessage').css("display","none");
    }
}

function checkApplicationStatusPhone(){
    var phoneNum = $('#applicationStatusPhone').val().trim();    
    if( phoneNum == "" || phoneNum.length < 10 || phoneNum.length > 11 || !$.isNumeric(phoneNum) ){
        $('#applicationStatusPhoneDiv').addClass("has-error has-feedback");
        $('#applicationStatusPhoneMessage').css("display","block");
        $('#applicationStatusPhoneMessage').html( "    * Please enter a valid phone number" );
    } else {
        $('#applicationStatusPhoneDiv').removeClass("has-error has-feedback");
        $('#applicationStatusPhoneMessage').css("display","none");
    }
}

function showStatusPopup(){
    document.getElementById('applicationStatus').style.visibility = 'visible';
    $('#applicationStatusSearch').css("display", "block");
}

function closeApplicationStatus(){
    var applicationStatusTable = document.getElementById('applicationStatusTable');
    while( applicationStatusTable.rows.length > 0 ){
            applicationStatusTable.deleteRow( -1 );
    }
    $('#applicationStatusResult').css("display", "none");
    $('#applicationStatusPhone').val("");
    document.getElementById('applicationStatus').style.visibility = 'hidden';
}

function showApplicationStatus(){
    var applicationStatusTable = document.getElementById('applicationStatusTable');
    while( applicationStatusTable.rows.length > 0 ){
            applicationStatusTable.deleteRow( -1 );
    }
    
    var searchPhoneNum = $('#applicationStatusPhone').val().trim();
    if( searchPhoneNum == "" ){
        alert("Please enter the phone number");
        return;
    }
    
    var url = '/getApplicationStatus';
    var datastring = 'searchPhoneNum='+searchPhoneNum;
    
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( responseText.indexOf("false") < 0 ){
                $('#applicationStatusSearch').css("display", "none");
                $('#applicationStatusPhoneDiv').css("display", "none");
                $('#applicationStatusBtnDiv').css("display", "none");
                
                for( var i=0; i < responseText.length; i++ ){
                    var row = applicationStatusTable.insertRow(i);
                    var cell1 = row.insertCell(0);
                    $('#enteredPhoneNum').html( "You entered the phone number <strong>" + responseText[i].phone + "</strong>");
                    cell1.innerHTML = "<table id='application_" + i + "' class='table table-bordered'>" +
                                      "<colgroup>" +
                                        "<col style='width:40%;'>" +
                                        "<col style='width:60%;'>" +
                                      "</colgroup>" + 
                                        "<tr>" +
                                            "<td colspan='2'><p id='applicationStatusMsg_" + i + "'><strong>" + 
                                            responseText[i].message + "</strong></p></td>" +
                                        "</tr>" +
                                        "<tr>" +
                                            "<td><p><strong>Application ID </strong></p></td>" + 
                                                //"<p id='searchApplicationId_" + i + "'>" + responseText[i].application_id + "</p></td>" +
                                            "<td><p id='searchApplicationId_" + i + "'><strong>" + responseText[i].application_id + "</strong></p></td>" +
                                        "</tr>" +
                                        "<tr>" +
                                            "<td><p><strong>Student Name </strong></p></td>" + 
                                            //"<p id='searchStudentName_" + i + "'>" + responseText[i].student_name + "</p></td>" +
                                            "<td><p id='searchStudentName_" + i + "'>" + responseText[i].student_name + "</p></td>" +
                                        "</tr>" +
                                        "<tr>" +
                                            "<td><p><strong>Father's Name </strong></p></td>" +
                                            //"<p id='searchFatherName_" + i + "'>" + responseText[i].father_name + "</p></td>" +
                                            "<td><p id='searchFatherName_" + i + "'>" + responseText[i].father_name + "</p></td>" +
                                        "</tr>" +
                                        "<tr>" +
                                            "<td><p><strong>Applied for </strong></p></td>" +
                                            //"<p id='searchForClass_" + i + "'>" + responseText[i].class_desc + "</p></td>" +
                                            "<td><p id='searchForClass_" + i + "'>" + responseText[i].class_desc + "</p></td>" +
                                        "</tr>" +
                                        "<tr>" +
                                            "<td><p><strong>Your Application Status </strong></p></td>" +
                                            //"<p id='searchApplicationStatus_" + i + "'>" + responseText[i].status + "</p></td>" +
                                            "<td><p id='searchApplicationStatus_" + i + "'>" + responseText[i].status + "</p></td>" +
                                        "</tr>" +
                                       "</table>";
                }
                $('#applicationStatusDetailsDiv').css("display", "block");
            } else {
                responseText = responseText.split("~~");
                $('#applicationStatusPhoneMessage').css("display", "block");
                $('#applicationStatusPhoneMessage').html( " *    " + responseText[1]);
            }
        }
    });
    
}

function showSchoolApplicationDetails(application_id, student_name, father_name, father_qual, mother_name,
                                     mother_qual, income_desc, language, phone, email_id ){
                                         
      $('#applicationDetailsPopup').css("visibility", "visible");
      $('#applicationID').html( application_id );
      $('#studentName').html(student_name);
      $('#fatherName').html(father_name);
      $('#fatherQualification').html(father_qual);
      $('#motherName').html(mother_name);
      $('#motherQualification').html(mother_qual);
      $('#incomeLevel').html(income_desc);
      $('#motherTongue').html(language);
      $('#phoneNum').html(phone);
      $('#emailID').html(email_id);     
    
}

function closeSchoolApplicationDetails(){
      $('#applicationDetailsPopup').css("visibility", "hidden");
      $('#applicationID').html( "" );
      $('#studentName').html("");
      $('#fatherName').html("");
      $('#fatherQualification').html("");
      $('#motherName').html("");
      $('#motherQualification').html("");
      $('#incomeLevel').html("");
      $('#motherTongue').html("");
      $('#phoneNum').html("");
      $('#emailID').html(""); 
}

function changeApplicationStatus( applicationIDs, changedStatus, pageNo, pageSize ){
    var url = '/changeApplicationStatus';
    var datastring = 'applicationIDs='+applicationIDs + '&changedStatus='+changedStatus;
    var statusChanged = false;
    
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( responseText.indexOf("false") < 0 ){
                statusChanged = true;
            }
        }
    });
    
    if( statusChanged ){
        window.location.reload();
    }
}

function changeApplicationStatusBulk(){
    var applicationIDs = "";
    var count = 0;
    
    var changedStatus = $("#applicationAction option:selected").val();
    if( changedStatus.trim() == "" ){
        alert("Please select an option to change the applications");
        return;
    }
    
    $( "input[id^='application_']" ).each(function( index ){
        if( $( this ).is(':checked') ){
            var applicationID = $( this ).val();
            
            applicationIDs = applicationIDs + ", " + applicationID.trim();
            count++;
        }
    });
    
    applicationIDs = applicationIDs.substring(2, applicationIDs.length );
    var url = '/changeApplicationStatus';
    var datastring = 'applicationIDs='+applicationIDs + '&changedStatus='+changedStatus;
    var statusChanged = false;
    
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( responseText.indexOf("false") < 0 ){
                statusChanged = true;
            }
        }
    });
    
    if( statusChanged ){
        window.location.reload();
    }
    
}

function loadNotifications(){
    if( !document.getElementById( "notificationTable" ) ){
        return;
    }
    var tableHeight = $('#notificationTable').height();
    var containerHeight = $('#notificationContainer').height();
    var notificationContainer = 'notificationContainer';
    
    var notificationTable = document.getElementById('notificationTable');
    var tableRowHeight = 0;
    if( notificationTable.rows.length > 0 ){
        tableRowHeight = notificationTable.rows[0].offsetHeight;
    }
        
    if( tableHeight/2 > containerHeight ){
        setInterval("scrollNotifications( " + tableHeight + ", " + tableRowHeight + ", '" + notificationContainer + "')", 50);
    } else {
        var i = notificationTable.rows.length - 1;
        var notificationTableLength = notificationTable.rows.length;
        while( i >= notificationTableLength/2 ){
            notificationTable.deleteRow( -1 );
            i--;
        }
    }
}

function homeOnLoad(){
    loadNotifications();
    
    /*var base_url = $('#base_url').val();
    var url = base_url + "/images/1/vvs_banner_2.jpg";
    var elementId = "schoolImage";
    loadImage( elementId, url );*/
}

function infoOnLoad(){
    loadNotifications();
}

function eventOnLoad(){
    loadNotifications();
}

function loadBoardMembers(){
    var tableHeight = $('#boardMembersTable').height();
    var containerHeight = $('#boardContainer').height();
    var boardContainer = 'boardContainer';
    var boardMembersTable = document.getElementById('boardMembersTable');
    var tableRowHeight = boardMembersTable.rows[0].offsetHeight;
    if( tableHeight/2 > containerHeight ){
        setInterval("scrollNotifications( " + tableHeight + ", " + tableRowHeight + ", '" + boardContainer + "')", 20);
    } else {
        var i = boardMembersTable.rows.length - 1;
        var notificationTableLength = boardMembersTable.rows.length;
        while( i >= notificationTableLength/2 ){
            boardMembersTable.deleteRow( -1 );
            i--;
        }
    }
}

function aboutUsOnLoad(){
    $( "input[id^='mem_img_url_']" ).each(function( index ){
        var imageUrlId = $( this ).attr("id");
        var url = $( this ).val();
        var member_id = imageUrlId.split("_");
        member_id = member_id[3];
        
        loadImage( 'mem_img_1_' + member_id, url );
        if( document.getElementById( 'mem_img_2_' + member_id ))
            loadImage( 'mem_img_2_' + member_id, url );
        
    });
    setTimeout( loadBoardMembers, 4000 );
}

function ourPrincipalOnLoad(){
    var url = $('#principalImageURL').val();
    var elementId = "principalImage";
    loadImage( elementId, url );
    
    $( "input[id^='mem_img_url_']" ).each(function( index ){
        var imageUrlId = $( this ).attr("id");
        var url = $( this ).val();
        var member_id = imageUrlId.split("_");
        member_id = member_id[3];
        
        loadImage( 'mem_img_1_' + member_id, url );
        if( document.getElementById( 'mem_img_2_' + member_id ))
            loadImage( 'mem_img_2_' + member_id, url );
        
    });
    setTimeout( loadBoardMembers, 4000 );
}

function ourBoardOnLoad(){
    $( "input[id^='mem_img_url_']" ).each(function( index ){
        var imageUrlId = $( this ).attr("id");
        var url = $( this ).val();
        var member_id = imageUrlId.split("_");
        member_id = member_id[3];
        
        loadImage( 'boardMemberImage_' + member_id, url );        
    });
}

function facultyOnLoad(){
    $( "input[id^='fg_img_url_']" ).each(function( index ){
        var imageUrlId = $( this ).attr("id");
        var url = $( this ).val();
        var faculty_id = imageUrlId.split("_");
        faculty_id = faculty_id[3];
        
        loadImage( 'facultyGeneralImage_' + faculty_id, url );        
    });
}

function loadImage( elementId, url ){
    var image = document.getElementById( elementId );
    var downloadingImage = new Image();
    downloadingImage.onload = function(){
        image.src = this.src;
    };
    downloadingImage.src = url;
}

var speed = 0;
var scroll = true;
function scrollNotifications( tableHeight, tableRowHeight, container ){
    if( scroll ){
        var containerDiv = document.getElementById(container);
        
        if( speed > tableHeight/2 ){
            speed = 0;
        }

        containerDiv.scrollTop = speed;
        speed=speed+1;
    }
}

function disableScroll(){
    scroll = false;
}

function enableScroll(){
    scroll = true;
}

function addPanelHighLight( panel_id ){
    $( '#' + panel_id ).addClass('panel-highlight');
}

function removePanelHighlight( panel_id ){
    $( '#' + panel_id ).removeClass('panel-highlight');
}

function showInfoDetails(){
    $('#informationModal').show();
}

function showForgotUsername(){
    $('#forgotUsernameEmailID').val('');
    $('#forgotUsernameDiv').css('visibility', 'visible');
}

function closeForgotUsername(){
    $('#forgotUsernameEmailID').val('');
    $('#forgotUsernameDiv').css('visibility', 'hidden');
}

function mailUsername(){
    var email_id = $('#forgotUsernameEmailID').val().trim();
    if( email_id == "" ){
        alert("Please enter the email_id");
        return;
    }
    
    var url = '/mailUsername';
    var datastring = 'emailID=' + encodeURIComponent(email_id);
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( responseText.trim() == "true" ){
                alert("Your username has been mailed to you.");
            } else {
                alert("The email id that you have entered is invalid");
            }
        }
    });
}

function activateHome(){
    $('#menuHomeOption').addClass("active");
}

function showDates( date ){
    var month_arr = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    
    var date_arr = date.split(',');
    var month = parseInt(date_arr[0].trim());
    var year = parseInt(date_arr[1].trim());
    
    $('#selectedPeriod').html( month_arr[month-1] + ", " + year );
    
    var daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];
    if ( (!(year % 4) && year % 100) || !(year % 400)) {
      daysInMonth[1] = 29;
    }
    var date_first = new Date(year, month-1, 1);
    var prev_month = ( month === 1 )? 12 : month-1;
    var num_days_prev = daysInMonth[prev_month-1];
    
    var week_day_num = date_first.getDay();
    for( var j=1; j<=6; j++ ){
        for( var i=1; i<=7; i++ ){
            $('#day_' + j + '_' + i + '_panel' ).removeClass( "other-month" );
            $('#day_' + j + '_' + i + '_panel' ).removeClass( "holiday" );
            $('#day_' + j + '_' + i + '_panel' ).removeClass( "light_background" );//calendar-event
            $('#day_' + j + '_' + i + '_panel' ).removeClass( "cursor-point" );
            $('#day_' + j + '_' + i + '_panel' ).removeAttr("data-toggle");
            $('#day_' + j + '_' + i + '_panel' ).removeAttr("data-target");
            $('#day_' + j + '_' + i ).html( "&nbsp;" );
        }
    }
    for( var j=week_day_num+1; j>=1; j-- ){
        $('#day_1_' + j).html("&nbsp;");   
        $('#day_1_' + j + '_panel' ).removeClass( "holiday" );
        $('#day_1_' + j + '_panel' ).addClass( "other-month" );
        num_days_prev--;
    }
    //week_day_num++;
    var week_idx = 1;
    var day_idx = week_day_num + 1;
    for( var day = 0; day < daysInMonth[month-1]; day++ ){
        day_idx = ((week_day_num + day ) % 7)+1;
        week_idx = Math.floor((week_day_num + day )/7) +1;
        $('#day_' + week_idx + '_' + day_idx).html(day+1);
        $('#day_' + week_idx + '_' + day_idx + '_panel' ).removeClass( "other-month" );
        if( day_idx == 1 ){//other-month, holiday
            $('#day_' + week_idx + '_' + day_idx + '_panel' ).removeClass( "other-month" );
            $('#day_' + week_idx + '_' + day_idx + '_panel' ).addClass( "holiday" );
        }
    }
    var next_mnt_start_day = 1;
    for( var k=day_idx+1; k <= 7; k++ ){
        $('#day_' + week_idx + '_' + k).html("&nbsp;");
        $('#day_' + week_idx + '_' + k + '_panel' ).addClass( "other-month" );
        next_mnt_start_day++;
    }
    if( week_idx === 5 ){
        week_idx++;
        for( var k=1; k <= 7; k++ ){
            $('#day_' + week_idx + '_' + k).html("&nbsp;");
            $('#day_' + week_idx + '_' + k + '_panel' ).addClass( "other-month" );
            next_mnt_start_day++;
        } 
    }
    var cal_content = $('#calendar_events_content').val();
    var cal_content_array = JSON.parse( cal_content );
    var cal_events_table = document.getElementById("calendar_events");
    var rownum = 0;
    var eventMap = {};
    
    while( cal_events_table.rows.length > 0 ){
        cal_events_table.deleteRow( -1 );
    }
    for( var i=0; i< cal_content_array.length; i++ ){
        var from_day = cal_content_array[i]['from_day'];
        var to_day = cal_content_array[i]['to_day'];
        
        var from_day_arr = from_day.split("-");
        var from_day_day = parseInt(from_day_arr[0].trim());
        var from_day_month = parseInt(from_day_arr[1].trim());
        var from_day_year = parseInt(from_day_arr[2].trim());
        
        var to_day_arr = to_day.split("-");
        var to_day_day = parseInt(to_day_arr[0].trim());
        var to_day_month = parseInt(to_day_arr[1].trim());
        var to_day_year = parseInt(to_day_arr[2].trim());
        
        if( from_day_month == month ){
            var row = cal_events_table.insertRow( rownum );
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            if( from_day_day == to_day_day && from_day_month == to_day_month && from_day_year == to_day_year ){
                cell1.innerHTML = '<p style="text-align:center;margin:0;">' + cal_content_array[i]['from_date'] + '</p>';
                //cell1.style.background = "bisque";
                cell1.style.margin = 0;
                eventMap[from_day_day] = cal_content_array[i];
            } else {
                if( from_day_month != to_day_month || from_day_year != to_day_year ){
                    for( var j=from_day_day; j<=daysInMonth[from_day_month-1]; j++ ){
                        eventMap[j] = cal_content_array[i];
                    }
                } else {
                    for( var j=from_day_day; j<=to_day_day; j++ ){
                        eventMap[j] = cal_content_array[i];
                    }
                }
                cell1.innerHTML = '<p style="text-align:center;margin:0;">' + cal_content_array[i]['from_date'] + '</p>' +
                                "<p style='text-align:center;margin:0;'>TO</p><p style='text-align:center;margin:0;'>" + 
                                    cal_content_array[i]['to_date']  + '</p>';
                
                //cell1.style.background = "bisque";
                cell1.style.margin = 0;
                
            }
            if( cal_content_array[i]['item_type'] == 2){
                cell1.setAttribute("class", "holiday");
                cell2.setAttribute("class", "holiday-light");
            }
            if( cal_content_array[i]['item_type'] == 3){
                cell1.setAttribute("class", "light_background");//calendar-event
                cell2.setAttribute("class", "lighter_background");//calendar-event-light
            }
            cell2.innerHTML = '<p style="margin:0;text-align:center;font-weight:bold;">' + cal_content_array[i]['short_desc']  + '</p>';
            //cell2.style.background = "beige";
            cell2.valign = 'middle';
            cell2.style.verticalAlign = 'middle';
            cell1.style.verticalAlign = 'middle';
            eventMap[from_day_day] = cal_content_array[i];
            rownum++;
        }
    }
    for( var j=1; j<=6; j++ ){
        for( var i=1; i<=7; i++ ){
            var day = $('#day_' + j + '_' + i ).html();
            if( day in eventMap ){
                $('#day_' + j + '_' + i + '_panel' ).removeClass( "other-month" );
                $('#day_' + j + '_' + i + '_panel' ).removeClass( "holiday" );
                if( eventMap[day]['item_type'] == 2 ){//
                    $('#day_' + j + '_' + i + '_panel' ).addClass( "cursor-point" );
                    $('#day_' + j + '_' + i + '_panel' ).addClass( "holiday" );
                    $('#day_' + j + '_' + i + '_panel' ).attr({"data-toggle":"modal", "data-target":"#calendarEventModal"});
                }
                if( eventMap[day]['item_type'] == 3 ){
                    $('#day_' + j + '_' + i + '_panel' ).addClass( "cursor-point" );
                    $('#day_' + j + '_' + i + '_panel' ).addClass( "light_background" );//calendar-event
                    $('#day_' + j + '_' + i + '_panel' ).attr({"data-toggle":"modal", "data-target":"#calendarEventModal"});
                }
                $('#day_' + j + '_' + i + '_desc' ).val( eventMap[day]['description'] );
                $('#day_' + j + '_' + i + '_event_type' ).val( eventMap[day]['item_type'] );
            }
        }
    }
}

function schoolCalendarLoad(){
    loadNotifications();
    var date = new Date();
    var dateString = (date.getMonth() + 1 ) + ", " + (date.getFullYear());
    showDates( dateString );
}

function codeOfConductLoad(){
    loadNotifications();
}

function schoolTourOnLoad(){
    $( "input[id^='facilityImageUrl_']" ).each(function( index ){
        var url = $(this).val();
        var id = $(this).attr("id");
        var type = id.split("_");
        type = type[1];
        var imgElementId = "facilityImage_" + type;
        loadImage( imgElementId, url );
    });
}

function clubsOnLoad(){
    $( "input[id^='clubImageUrl_']" ).each(function( index ){
        var url = $(this).val();
        var id = $(this).attr("id");
        var type = id.split("_");
        type = type[1];
        var imgElementId = "clubImage_" + type;
        loadImage( imgElementId, url );
    });
}