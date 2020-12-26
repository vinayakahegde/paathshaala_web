$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

var _INBOX_SELECT_MAIL_TO = 1;
var _INBOX_SELECT_SEARCH_FROM = 2;
function inboxOnLoad(){
    var type = getParameterByName('type');
    var pg_num = getParameterByName('pg_num');
    if( type ){
        if( pg_num ){
            getInboxContent(type, pg_num, '', '');
        } else {
            getInboxContent(type, '1', '', '');
        }        
    } else {
        getInboxContent('inbox', '1', '', '');
    }
    
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
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getInboxContent( type, pg_num, search_user_id, search_text ){
    $('#current_page_num').val(pg_num);
    $('#current_inbox_type').val(type);
    $('#search_user_id').val(search_user_id);
    $('#search_text').val(search_text);
                       
    $('#page_num').html(pg_num);
    if( search_user_id == '' && search_text == '' ){
        $('#searchCriteria').css("display", "none");
        removeInboxSearchFrom();
    }
    
    if( type == 'sent' ){
        $('#searchFrom').html("Select Receiver");
        $('#search_uname_desc').html("To&nbsp;");
    } else {
        $('#searchFrom').html("Select Sender");
        $('#search_uname_desc').html("From&nbsp;");
    }
    
    clearInboxSelection();
    var inboxHtml = '';
    var numCols = 0;
    if( type == 'sent' ){
        inboxHtml =  '<tr style="background:lightgrey">' + 
                         '<th class="inbox_from">To</th>' + 
                         '<th class="inbox_subject">Subject</th>' + 
                         '<th class="inbox_time">Time</th>' + 
                     '</tr>';
        numCols = 3;
    } else {
        inboxHtml =  '<tr style="background:lightgrey">' + 
                         '<th class="inbox_chkbox"></th>' + 
                         '<th class="inbox_imp"></th>' + 
                         '<th class="inbox_from">From</th>' + 
                         '<th class="inbox_subject">Subject</th>' + 
                         '<th class="inbox_time">Time</th>' + 
                         '<th class="inbox_action">Action</th>' + 
                     '</tr>';
        numCols = 6;     
    }
             
    var url = '/getInboxContent';
    var datastring = 'option=' + type + '&pg_num=' + pg_num + '&search_user_id=' + search_user_id 
                        + '&search_text=' + encodeURIComponent( search_text );
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( 'string' == typeof responseText ){
                alert("Could not fetch messages. Please try later!");
                return;
            }
            console.log(responseText);
            $('#' + type + '_btn').css("background", "lightgray");
            $('#' + type + '_span').css("font-weight", "bold");
            
            if( responseText.length == 0 ){
                inboxHtml += '<tr><td colspan="' + numCols + '" style="text-align:center;">No Messages Here!!!</td></tr>';
            }
            
            $('#current_page_size').val( responseText.length );
            for( var i=0; i < responseText.length; i++ ){ 
                if( type != 'sent' ){
                    if( responseText[i]['read_flag'].trim() == '1' ){
                        inboxHtml += '<tr class="read" >';
                    } else {
                        inboxHtml += '<tr class="unread" >';
                    }

                    var impGlyp = '';
                    var impOpt = '';
                    if( responseText[i]['important_flag'].trim() == '1' ){
                        impGlyp = 'glyphicon-star';
                        impOpt = 'unimportant';
                    } else {
                        impGlyp = 'glyphicon-star-empty';
                        impOpt = 'important';
                    }
                    inboxHtml += '<td class="inbox_chkbox">' + 
                                    '<input type="checkbox" id="msg_' + responseText[i]['msg_id'] + '" name="msg_' + responseText[i]['msg_id']
                                        + '" value="' + responseText[i]['msg_id'] + '">' + 
                                '</td>' + 
                                '<td class="inbox_imp">' +
                                    '<a onclick="markMessage( ' + responseText[i]['parent_msg_id'] + ', \'' + impOpt + '\' );">'+
                                        '<span class="glyphicon ' + impGlyp + '" id="msg_imp_' + responseText[i]['parent_msg_id'] + '"></span></a>' +
                                '</td>';
                }
                
                inboxHtml += '<td class="inbox_from">' + responseText[i]['name'] + '</td>' + 
                             '<td class="inbox_subject"><a href="#" data-toggle="modal" data-target="#showMessageModal" '+
                                    ' data-backdrop="static" data-keyboard="true" ' + 
                                    ' id="msg_sub_' + responseText[i]['parent_msg_id'] + '" '+
                                    ' >' + responseText[i]['subject'] + '</a><input type="hidden" id="msg_type_' 
                                        + responseText[i]['parent_msg_id'] + '" value="' + type + '" >' + 
                                    '<input type="hidden" id="msg_pg_num_' + responseText[i]['parent_msg_id'] + '" ' + 
                                            'value="' + pg_num + '" ></td>' + 
                             '<td class="inbox_time">' + responseText[i]['msg_time_stamp'] + '</td>';
                     
                if( type != 'sent' ){
                    
                    inboxHtml += '<td class="inbox_action">' + 
                                    '<button type="button" id="deleteMsg_' + responseText[i]['parent_msg_id'] + 
                                        '" onclick="markMessage(' + responseText[i]['parent_msg_id'] + ', \'deleted\')" ' +
                                        '" class="btn btn-sm btn-default">' +
                                        '<span class="glyphicon glyphicon-remove-sign" style="color:lightcoral;font-weight:bold;"></span>&nbsp;' + 
                                            '<span style="color:lightcoral;font-weight:bold;">Delete</span>' +
                                    '</button>' +
                                 '</td>';
                }  
                inboxHtml += '</tr>';
            }
            
        },
        error: function(exception) {
            console.log(exception);
        }
    });
    $('#inboxContentTable').html(inboxHtml); 
}

function clearInboxSelection(){
    var inbox_opts = [ 'inbox', 'unread', 'read', 'important', 'sent' ];
    for( var i=0; i < inbox_opts.length; i++ ){
        $('#' + inbox_opts[i] + '_btn').css("background", "white");
        $('#' + inbox_opts[i] + '_span').css("font-weight", "normal");
    }
}

function showMatchingStudentNames(){
    var searchedStudentName = document.getElementById('studentNameSearch').value;
    if( searchedStudentName != '' && searchedStudentName.length >= 3){
        var students = localStorage.getItem("students"); 
        students = JSON.parse(students);
        //console.log(students);
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

$('#selectPersonModal').on('shown.bs.modal', function(e){
    var invoker_id = $(e.relatedTarget).attr("id");
    if( invoker_id == 'select_to_btn' ){
        $('#selection_type_id').val( _INBOX_SELECT_MAIL_TO );
    } else {
        $('#selection_type_id').val( _INBOX_SELECT_SEARCH_FROM );
    }
});

$('#selectPersonModal').on('hidden.bs.modal', function(e){
    $('#searchContentDiv').html('');
});

function searchByName(){
    var studentNameSearch = $('#studentNameSearch').val().trim();
    var studentParentNameSearch = $('#studentParentNameSearch').val().trim();
    var selection_type_id = $('#selection_type_id').val();
    
    var url = '/inbox_search';
    var datastring = 'studentNameSearch=' + encodeURIComponent(studentNameSearch) +
                        '&studentParentNameSearch=' + encodeURIComponent( studentParentNameSearch );
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            console.log( responseText );
            if( "string" == typeof responseText ){
                alert("Please try after some time!");
                return;
            }
            var studentSearchByClass = responseText.studentSearchByClass.trim();
            var selectedSection = responseText.selectedSection;
            var studentNameEntered = responseText.studentNameEntered;
            var studentParentNameEntered = responseText.studentParentNameEntered;
            var studentRollNoEntered = responseText.studentRollNoEntered;
            
            $('#studentNameSearch').val( studentNameEntered );
            $('#studentParentNameSearch').val( studentParentNameEntered );
            $('#studentClassSearch').val( studentSearchByClass );
            
            var classArray = $('#classArray').val();
            classArray = jQuery.parseJSON(classArray);
            var sectionArray = classArray[studentSearchByClass];
            var html = '<option value="">Select</option>';
            for( var i=0; sectionArray && i < sectionArray.length; i++ ){
                html += '<option value="' + sectionArray[i]['section'] + '" >' + sectionArray[i]['section'] + '</option>';
            }
            $('#studentSectionSearch').html( html );
    
            $('#studentSectionSearch').val( selectedSection );
            $('#studentRollNoEntered').val( studentRollNoEntered );
            
            var students = responseText.students;
            var searchContentDivHtml = '';
                        
            var classArr = [ "Pre-KG", "LKG", "UKG", "Class I", "Class II", "Class III", "Class IV", "Class V", "Class VI",
                                "Class VII", "Class VIII", "Class IX", "Class X", "Class XI", "Class XII", "Play Home" ];
                            
            if( students instanceof Array ){
                for( var i=0; i < students.length; i++ ){
                    var headingStr = students[i]['firstname'].trim() + ' ' + students[i]['lastname'].trim() + ' [' 
                                        + classArr[students[i]['class'].trim()] + ', Section ' + students[i]['section'].trim() + ' ]';
                    var fatherName = students[i]['father_firstname'].trim() + ' ' + students[i]['father_lastname'].trim(); 
                    var motherName = students[i]['mother_firstname'].trim() + ' ' + students[i]['mother_lastname'].trim();
                    var fatherUserId = students[i]['father_user_id'].trim();
                    var motherUserId = students[i]['mother_user_id'].trim();
                    
                    searchContentDivHtml += 
                                    '<div class="panel panel-default" style="padding:0;">' +
                                        '<div class="panel-heading">' +
                                            '<h4 style="margin:0;text-align: center;">' + headingStr + '</h4>' +
                                        '</div>' +
                                        '<div class="panel-body" style="margin:0;padding:0;">' +
                                            '<table id="studentDetail_1" class="table table-responsive table-bordered" ' +
                                                   'style="text-align: center; margin:0;padding:0;">' +
                                                '<tr>' +
                                                    '<td class="parent_name_col"><strong>Father</strong></td>' +
                                                    '<td class="parent_mail_col">' +
                                                        '<button type="button" class="btn btn-sm btn-default" style="width:100%;padding:10px;" ' +
                                                                'id="messageFatherName" name="messageFatherName" ' +
                                                                'onclick="performUserSelection( \''+ fatherName + '\', ' + fatherUserId + ', ' + selection_type_id + ' );">' +
                                                            '<span class="glyphicon glyphicon-envelope"></span> <strong>&nbsp;&nbsp;&nbsp;' + fatherName + '</strong>' +
                                                        '</button>' + 
                                                    '</td>' +
                                                '</tr>' +
                                                '<tr>' +
                                                    '<td class="parent_name_col"><strong>Mother</strong></td>' +
                                                    '<td class="parent_mail_col">' +
                                                        '<button type="button" class="btn btn-sm btn-default" style="width:100%;padding:10px;" ' +
                                                                'id="messageMotherName" name="messageMotherName" ' +
                                                                'onclick="performUserSelection( \''+ motherName + '\', ' + motherUserId + ', ' + selection_type_id + ' );">' +
                                                            '<span class="glyphicon glyphicon-envelope"></span> <strong>&nbsp;&nbsp;&nbsp;' + motherName + '</strong>' +
                                                        '</button>' +
                                                    '</td>' +
                                                '</tr>' +
                                            '</table>' +
                                        '</div>' +
                                    '</div>';
                            
                }
                $('#searchContentDiv').html(searchContentDivHtml);
            }
            
        }
    });
}

function searchByDetails(){
    var studentClassSearch = $('#studentClassSearch').val().trim();
    var studentSectionSearch = $('#studentSectionSearch').val().trim();
    var studentRollNoEntered = $('#studentRollNoEntered').val().trim();
    
    var selection_type_id = $('#selection_type_id').val();
    var url = '/inbox_search';
    var datastring = 'studentClassSearch=' + encodeURIComponent( studentClassSearch ) + '&studentSectionSearch=' 
                        + encodeURIComponent( studentSectionSearch ) + '&studentRollNoEntered=' + encodeURIComponent( studentRollNoEntered );
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            console.log( responseText );
            if( "string" == typeof responseText ){
                alert("Please try after some time!");
                return;
            }
            var studentSearchByClass = responseText.studentSearchByClass.trim();
            var selectedSection = responseText.selectedSection;
            var studentNameEntered = responseText.studentNameEntered;
            var studentParentNameEntered = responseText.studentParentNameEntered;
            var studentRollNoEntered = responseText.studentRollNoEntered;
            
            $('#studentNameSearch').val( studentNameEntered );
            $('#studentParentNameSearch').val( studentParentNameEntered );
            $('#studentClassSearch').val( studentSearchByClass );
            
            var classArray = $('#classArray').val();
            classArray = jQuery.parseJSON(classArray);
            var sectionArray = classArray[studentSearchByClass];
            var html = '<option value="">Select</option>';
            for( var i=0; sectionArray && i < sectionArray.length; i++ ){
                html += '<option value="' + sectionArray[i]['section'] + '" >' + sectionArray[i]['section'] + '</option>';
            }
            $('#studentSectionSearch').html( html );
    
            $('#studentSectionSearch').val( selectedSection );
            $('#studentRollNoEntered').val( studentRollNoEntered );
            
            var students = responseText.students;
            var searchContentDivHtml = '';
                        
            var classArr = [ "Pre-KG", "LKG", "UKG", "Class I", "Class II", "Class III", "Class IV", "Class V", "Class VI",
                                "Class VII", "Class VIII", "Class IX", "Class X", "Class XI", "Class XII", "Play Home" ];
                            
            if( students instanceof Array ){
                for( var i=0; i < students.length; i++ ){
                    var headingStr = students[i]['firstname'].trim() + ' ' + students[i]['lastname'].trim() + ' [' 
                                        + classArr[students[i]['class'].trim()] + ', Section ' + students[i]['section'].trim() + ' ]';
                    var fatherName = students[i]['father_firstname'].trim() + ' ' + students[i]['father_lastname'].trim(); 
                    var motherName = students[i]['mother_firstname'].trim() + ' ' + students[i]['mother_lastname'].trim();
                    var fatherUserId = students[i]['father_user_id'].trim();
                    var motherUserId = students[i]['mother_user_id'].trim();
                    
                    searchContentDivHtml += 
                                    '<div class="panel panel-default" style="padding:0;">' +
                                        '<div class="panel-heading">' +
                                            '<h4 style="margin:0;text-align: center;">' + headingStr + '</h4>' +
                                        '</div>' +
                                        '<div class="panel-body" style="margin:0;padding:0;">' +
                                            '<table id="studentDetail_1" class="table table-responsive table-bordered" ' +
                                                   'style="text-align: center; margin:0;padding:0;">' +
                                                '<tr>' +
                                                    '<td class="parent_name_col"><strong>Father</strong></td>' +
                                                    '<td class="parent_mail_col">' +
                                                        '<button type="button" class="btn btn-sm btn-default" style="width:100%;padding:10px;" ' +
                                                                'id="messageFatherName" name="messageFatherName" ' +
                                                                'onclick="performUserSelection( \''+ fatherName + '\', ' + fatherUserId + ', ' + selection_type_id + ' );">' +
                                                            '<span class="glyphicon glyphicon-envelope"></span> <strong>&nbsp;&nbsp;&nbsp;' + fatherName + '</strong>' +
                                                        '</button>' + 
                                                    '</td>' +
                                                '</tr>' +
                                                '<tr>' +
                                                    '<td class="parent_name_col"><strong>Mother</strong></td>' +
                                                    '<td class="parent_mail_col">' +
                                                        '<button type="button" class="btn btn-sm btn-default" style="width:100%;padding:10px;" ' +
                                                                'id="messageMotherName" name="messageMotherName" ' +
                                                                'onclick="performUserSelection( \''+ motherName + '\', ' + motherUserId + ', ' + selection_type_id + ' );">' +
                                                            '<span class="glyphicon glyphicon-envelope"></span> <strong>&nbsp;&nbsp;&nbsp;' + motherName + '</strong>' +
                                                        '</button>' +
                                                    '</td>' +
                                                '</tr>' +
                                            '</table>' +
                                        '</div>' +
                                    '</div>';
                            
                }
                $('#searchContentDiv').html(searchContentDivHtml);
            }
        }
    });
}

function addMessageRecipient( name, parent_id ){
    $('#selectPersonModal').modal('hide');
    var msg_to_div_html = '<label for="message_to">TO</label>&nbsp;&nbsp;' +
                    '<input type="hidden" id="to_message_id" name="to_message_id" value="' + parent_id + '" >' +
                    '<button class="btn btn-sm chosen_btn" id="message_recipient" onclick="removeMessageRecipient()">' +
                    '<strong>' + name + '&nbsp;&nbsp;</strong><span class="glyphicon glyphicon-remove"></span></button>';
    
    $('#message_to_div').html( msg_to_div_html );
}

function removeMessageRecipient(){
    var msg_to_div_html = '<label for="message_to">TO</label>' +
                                '<input type="button" id="select_to_btn" name="select_to_btn" ' +
                                       'class="btn btn-warning" style="margin-left:10px;" value="SELECT PERSON" ' +
                                       'data-toggle="modal" data-target="#selectPersonModal" ' +
                                       'data-backdrop="static" data-keyboard="true">';
                               
    $('#message_to_div').html( msg_to_div_html );
}

function performUserSelection( name, parent_id, selection_id ){
    if( selection_id == _INBOX_SELECT_MAIL_TO ){
        addMessageRecipient( name, parent_id );
    } else {
        selectSearchUser( name, parent_id );
    }
}

function selectSearchUser( name, parent_id ){
    $('#search_user_id').val( parent_id );
    $('#selected_search_uname').html( name );
    $('#searchedUnameDiv').css("display", "block");
    $('#searchMailTxtDiv').css("display", "none");
    $('#searchFromDiv').css("display", "none");
    $('#selectPersonModal').modal('hide');
}

function removeInboxSearchFrom(){
    $('#search_user_id').val('');
    $('#selected_search_uname').html('');
    $('#searchTextDisp').val('');
    $('#searchedUnameDiv').css("display", "none");
    $('#searchMailTxtDiv').css("display", "block");
    $('#searchFromDiv').css("display", "block");
}

function sendMessage(){
    var maxMsgLength = 3000;
    var maxSubLength = 250;
    var recipient_id = '';
    
    if( $('#principal_name_fld').length == 0 || $('#principal_name_fld').css("display") == "block" ){
        recipient_id = $('#to_message_id').val().trim();
    } else {
        recipient_id = $('#select_teacher').val();
    }
    
    if( recipient_id == '' ){
        alert( "Please select a recipient to send the message to!");
        return;
    }
    var message = $('#message_content').val().trim();
    if( message.length == 0 ){
        alert("Please enter a valid message!");
        return;
    }
    if( message.length > maxMsgLength ){
        alert( "Message length exceeded the maximum permissible limit of " + maxMsgLength + " characters! ");
        return;
    }
    
    var subject = $('#message_subject').val().trim();
    if( subject.length == 0 ){
        alert("Please enter a valid subject!");
        return;
    }
    if( subject.length > maxSubLength ){
        alert( "Subject length exceeded the maximum permissible limit of " + maxSubLength + " characters! ");
        return;
    }
    
    var url = '/sendInboxMessage';
    var datastring = 'recipient_id=' + recipient_id + '&message=' + encodeURIComponent( message )
                        + '&subject=' + encodeURIComponent( subject );
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( responseText.trim() == "true" ){
                $('#newMessageModal').modal('hide');
                alert("Message successfully sent!");
                window.location.reload();
            } else {
                alert("Message delivery failed. Please try again!");
                return;
            }
        },
        error: function( exception ){
            alert("Message delivery failed. Please try again!");
            return;
        }
    });
}

function markMessage( parent_msg_id, markAs ){
    var url = '/markMessage';
    var datastring = 'parent_msg_id=' + parent_msg_id + '&markAs=' + markAs;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( responseText.trim() == "true" ){
                if( markAs == 'important' ){
                    $('#msg_imp_' + parent_msg_id ).removeClass( "glyphicon-star-empty" );
                    $('#msg_imp_' + parent_msg_id ).addClass( "glyphicon-star" );
                } else if( markAs == 'unimportant' ){
                    $('#msg_imp_' + parent_msg_id ).removeClass( "glyphicon-star" );
                    $('#msg_imp_' + parent_msg_id ).addClass( "glyphicon-star-empty" );
                } else {
                    window.location.reload();
                }
            } else {
                alert("Unable to mark important. Please try again!");
                return;
            }
        },
        error: function( exception ){
            alert("Unable to mark important. Please try again!");
            return;
        }
    });
}

$('#newMessageModal').on('shown.bs.modal', function(e){
    var invoker_id = $(e.relatedTarget).attr("id");
    if( invoker_id == 'newMsg' ) {
        $('#principal_name_fld').css("display", "none");
        return;
    }
    if( invoker_id == 'askPrincipal' ){
        $('#principal_name_fld').css("display", "block");
        $('#select_teacher').css("display", "none");
    }
    if( invoker_id == 'askTeacher' ){
        $('#principal_name_fld').css("display", "none");
        $('#select_teacher').css("display", "block");
    }
});

$('#showMessageModal').on('shown.bs.modal', function(e){
   var invoker_id = $(e.relatedTarget).attr("id");
   var subject = $(e.relatedTarget).html().trim();
   var msg_ids = invoker_id.split("_");
   var parent_msg_id = msg_ids[2].trim();
   var msg_type = $('#msg_type_' + parent_msg_id ).val();
   var msg_pg_num = $('#msg_pg_num_' + parent_msg_id ).val();
   
   $('#showMessageTitle').html( subject );
   $('#selected_parent_msg_id').val(parent_msg_id);
   $('#messageType').val(msg_type);
   $('#messagePageNum').val(msg_pg_num);
   //$('#selected_msg_id').val(parent_msg_id);
   cancelReply();
   
   var url = '/getMessageDetails';
   var datastring = 'parent_msg_id=' + parent_msg_id;
   $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            console.log(responseText);
            var messageHtml = '';
            var reply_to = '';
            if( !("string" == typeof responseText) ){
                for( var i=0; i < responseText.length; i++ ){
                    if( responseText[i]['from_name'].trim() != 'me' && reply_to == '' ){
                        reply_to = responseText[i]['from_name'].trim();
                        $('#reply_to_user_id').val( responseText[i]['from_user_id'].trim() );
                        $('#messageReplyTo').html( reply_to );
                    }
                    if( responseText[i]['to_name'].trim() != 'me' && reply_to == '' ){
                        reply_to = responseText[i]['to_name'].trim();
                        $('#reply_to_user_id').val( responseText[i]['to_user_id'].trim() );
                        $('#messageReplyTo').html( reply_to );
                    }
                    messageHtml += '<tr>' +
                                    '<td>' +
                                        '<div>' +
                                            '<span style="float:left;"><strong>' + responseText[i]['from_name'] + '</strong></span>' +
                                            '<span style="float:right;">' + responseText[i]['msg_time_stamp'] + '</span>' +
                                        '</div>' +
                                        '<div>' +
                                            '<br>' +
                                            '<p>To : ' + responseText[i]['to_name'] + '</p>' +
                                            '<br>' +
                                            '<p>' + formatMessageHtml( responseText[i]['message'] ) +
                                            '</p>' +
                                        '</div>' +
                                    '</td>' +
                                '</tr>';
                }
            }
            $('#messageTable').html(messageHtml);
            //alert(responseText);            
        },
        error: function( exception ){
            alert("Unable fetch messages. Please try again!");
            return;
        }
    });
});

/*$('#showMessageModal').on( 'hidden.bs.modal', function(e){
    window.location.reload();
});*/

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

function showReplyBox(){
    $('#replyMessageDiv').css("display", "block");
    document.getElementById('messageContainer').scrollTop = 0;
    $('#replyMessage').val('');
    var modBtnHtml = '<input type="button" class="btn btn-danger" value="CANCEL" onclick="cancelReply();">&nbsp;' +
                     '<input type="button" class="btn btn-success" value="SEND" onclick="sendReply();" >';
    $('#actionDiv').html( modBtnHtml );
}

function sendReply(){
    var replyMsg = $('#replyMessage').val().trim();
    var parentMsgId = $('#selected_parent_msg_id').val().trim();
    var reply_to_user_id = $('#reply_to_user_id').val().trim();
    var showMessageTitle = $('#showMessageTitle').html().trim();
    
    var url = '/sendInboxReply';
    var datastring = 'replyMsg='+encodeURIComponent(replyMsg) + '&parentMsgId=' + parentMsgId + 
                        '&reply_to_user_id=' + reply_to_user_id + '&subject='+encodeURIComponent( showMessageTitle );
                               
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            if( responseText == "true" ){
                alert("Message sent successfully!");
                var paramIdx = window.location.href.indexOf('?');
                var href_val = window.location.href;
                if( paramIdx > 0 ){
                    href_val = href_val.substr( 0, paramIdx );
                } 
                window.location.href = href_val + '?type=' + $('#messageType').val() + '&pg_num=' + $('#messagePageNum').val();
            }
        },
        error : function(exception){
            console.log( exception );
        }
    });
}

function cancelReply(){
    $('#replyMessageDiv').css("display", "none");
    var modBtnHtml = '<input type="button" class="btn btn-warning" value="REPLY" onclick="showReplyBox();" >';
    $('#actionDiv').html( modBtnHtml );
}

function formatMessageHtml( msg ){
    //msg = msg.replace( "\n", "<br>" );
    return msg;
}

function getPreviousInboxPage(){
    var current_page_num = $('#current_page_num').val();
    if( current_page_num <= 1 ){
        return;
    }
    var search_user_id = $('#search_user_id').val();
    var search_text = $('#search_text').val();
    var type = $('#current_inbox_type').val();
    getInboxContent( type, parseInt(current_page_num) - 1, search_user_id, search_text );
}

function getNextInboxPage(){
    var current_page_num = $('#current_page_num').val();
    var current_page_size = $('#current_page_size').val();
    var inbox_page_default_size = $('#inbox_default_page_size').val();
    
    if( current_page_size < inbox_page_default_size ){
        return;
    }
    var search_user_id = $('#search_user_id').val();
    var search_text = $('#search_text').val();
    var type = $('#current_inbox_type').val();
    getInboxContent( type, parseInt(current_page_num) + 1, search_user_id, search_text );
}

function doInboxSearch(){
    var search_user_id = $('#search_user_id').val();
    var search_text = $('#searchTextDisp').val();
    var type = $('#current_inbox_type').val();
    
    var searchedUsername = $('#selected_search_uname').html();
    if( searchedUsername ){
        searchedUsername = searchedUsername.trim();
    }
    
    if( search_text ){
        search_text = search_text.trim();
        var search_text_max_len = $('#search_text_max_len').val();
        if( search_text.length > search_text_max_len ){
            alert( "Please enter search text less than " + search_text_max_len + " characters!" );
            return;
        }
    }
    
    var fromto_text = 'Sent By :';
    if( type == 'sent' ){
        fromto_text = 'Sent To :';
    }
    $('#search_text').val( search_text );
    var searchCriteriaHtml = '<span style="background: #eeeeee;"><strong>&nbsp;&nbsp;SEARCH CRITERIA&nbsp;&nbsp;</strong></span> ';
    if( search_user_id != '' && search_text != '' ){
        searchCriteriaHtml += fromto_text + ' <strong>' + searchedUsername + '</strong>, Mail contains : <strong>"' 
                                    + search_text + '"</strong>';
    } else if( search_user_id != '' ){
        searchCriteriaHtml += fromto_text + ' <strong>' + searchedUsername + '</strong>';
    } else if( search_text != '' ){
        searchCriteriaHtml += 'Mail contains : <strong>"' + search_text + '"</strong>';
    }
                                                                    
    $('#searchCriteriaTxt').html( searchCriteriaHtml );
    $('#searchCriteria').css("display", "block");
    
    getInboxContent( type, 1, search_user_id, search_text );
}