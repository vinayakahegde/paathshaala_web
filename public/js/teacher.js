var DEFAULT_MAX_PERIODS = 8;
var DEFAULT_MAX_DAYS = 6;
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

function teacherTestOnLoad(){
    
}

function populateClassTests(){
    var class_id = $('#selectTestClass').val();
    if( class_id == '' ){
        $('#showTests').html('<p style="text-align:center;">Please select a class!</p>');
        return;
    }
    $('#teacherClassTestTitle').html( $('#selectTestClass :selected').text().toUpperCase() );
    $('#teacherTestContentSubjects').html('<p style="text-align:center;">Please select a test!</p>');
    $('#teacherTestContent').css("display", "block");
    $('#classSubjectScoresDiv').css("display", "none");
    var url = '/getClassTestDetails';
    var datastring = 'class_id=' + class_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            console.log(responseText);
            var showTestsHtml = '<table id="teacherTestsTbl" style="background:white;"' +
                                      ' class="table table-bordered table-responsive">';
            if( Array.isArray(responseText) && responseText.length > 0 ){
                for( var i=0; i < responseText.length; i++ ){
                    showTestsHtml += '<tr>'+
                                        '<input type="hidden" id="teacher_test_interval_' + responseText[i]['test_id'] + '" value="' 
                                                    + responseText[i]['test_interval'] + '">' + 
                                        '<td style="text-align: center;cursor:pointer;" id="teacher_test_' + responseText[i]['test_id'] + 
                                             '" onclick="populateTeacherTestDetails( ' + responseText[i]['test_id'] + ', '+ class_id + ' );" ><strong>' 
                                            + responseText[i]['test_name'] + 
                                        '</strong></td></tr>';
                }
                $('#showTests').html( showTestsHtml );
            } else {
                $('#showTests').html('<p style="text-align:center;">No Tests scheduled!</p>');
            }
        }
    });
}

function populateTeacherTestDetails( test_id, class_id ){
    $('#teacherTestTitle').html( $('#teacher_test_' + test_id).html() + '(&nbsp;' + $('#teacher_test_interval_' + test_id).val() + '&nbsp;)' );
    $('#testId').val( test_id );
    var classSubjectScoresTable = document.getElementById('classSubjectScores');
    while( classSubjectScoresTable.rows.length > 1 ){
        classSubjectScoresTable.deleteRow( -1 );
    }
    var classSubjectScoresTbl = document.getElementById('classSubjectScores');
    while( classSubjectScoresTbl.rows.length > 1 ){
        classSubjectScoresTbl.deleteRow( -1 );
    }
    
    $( "td[id^=teacher_test_]" ).each(function( index ){
        $(this).css("background", "white");
    });
    $("#teacher_test_" + test_id ).css("background", "burlywood");
    
    var url = '/getClassTestSubjectDetails';
    var datastring = 'class_id=' + class_id + '&test_id=' + test_id;
    
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : false,
        dataType: "json",
        success : function(responseText) {
            console.log(responseText);
            $('#teacherTestContentJson').val( JSON.stringify(responseText) );
            if( 'test_details' in responseText ){
                var test_details = responseText['test_details'];
                var menuHtml = '<ul class="nav nav-tabs nav-justified">';
                var studentHtml = '';
                var cnt=0;
                for (var subject_id in test_details ) {
                    if( test_details.hasOwnProperty(subject_id) && 'subject_name' in test_details[subject_id] ){
                        if( cnt == 0 ){
                            $('#details_testDate').html( test_details[subject_id]['test_date'] );
                            $('#details_gradingType').html( test_details[subject_id]['grading_type_desc'] );
                            $('#gradingType').val( test_details[subject_id]['grading_type'] );
                            menuHtml += '<li role="presentation" class="active custom-active">' +
                                            '<a href="#" class="custom-link-active" onclick="activateSubMenu(' + subject_id 
                                                + ');" id="menu_sub_' + subject_id + '">' 
                                                + test_details[subject_id]['subject_name'] + 
                                            '</a>' +
                                        '</li>';
                            
                            var class_avg = test_details[subject_id]['class_average'];
                            var class_avg_html = '<div class="progress" style="margin-bottom:0px;">' +
                                                     '<div class="progress-bar" role="progressbar" aria-valuenow="' + class_avg + '" ' +
                                                          'aria-valuemin="0" aria-valuemax="100" style="width:' + class_avg + '%;">' +
                                                         class_avg +
                                                     '</div>' +
                                                 '</div>';
                            $('#classAvgTd').html(class_avg_html);
                
                            if( 'student_list' in test_details[subject_id] ){
                                var student_list = test_details[subject_id]['student_list'];
                                for( var student_idx in student_list ){
                                    studentHtml += '<tr>' +
                                                '<td class="student_roll">' + student_list[student_idx]['student_roll_no'] + '</td>' +
                                                '<td class="student_name">' + 
                                                    student_list[student_idx]['firstname'] + ' ' + student_list[student_idx]['lastname'] +
                                                '</td>' +
                                                '<td class="student_grade" id="studentGrade_' + subject_id + '_' + student_list[student_idx]['student_id'] + '">' + 
                                                            student_list[student_idx]['grade'] + 
                                                '</td>' +
                                                '<td class="student_remark" id="studentRemark_' + subject_id + '_' + student_list[student_idx]['student_id'] + '">' + 
                                                           student_list[student_idx]['remarks'] +  
                                                '</td>' +
                                                '<td class="student_action">' +
                                                    '<button type="button" id="editStudentDetailsBtn_' + subject_id + '_' + 
                                                                student_list[student_idx]['student_id'] + '" class="btn btn-sm btn-warning" ' + 
                                                                ' onclick="editStudentScoreCard(' + subject_id + ', ' + student_list[student_idx]['student_id'] + ');" >' +
                                                        '<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;EDIT' +
                                                    '</button>' +
                                                '</td>' +
                                            '</tr>';
                                }
                            }
                        } else {
                            menuHtml += '<li role="presentation">' +
                                            '<a href="#"onclick="activateSubMenu(' + subject_id 
                                                + ');" id="menu_sub_' + subject_id + '">' 
                                                + test_details[subject_id]['subject_name'] + 
                                            '</a>' +
                                        '</li>';
                        }
                    }
                    cnt++;
                }
                menuHtml += '</ul>';
                $('#teacherTestContentSubjects').html( menuHtml );
                $('#classSubjectScores tr:last').after( studentHtml );
                $('#classSubjectScoresDiv').css("display", "block");
            }
            $('#teacherTestContent').css("display", "block");
        }
    });
}

function activateSubMenu( subject_id ){
    $('#teacherTestContentSubjects li').each( function(e){
       $(this).removeClass("active custom-active"); 
       $(this).children().removeClass("custom-link-active");
    });
    
    var classSubjectScoresTbl = document.getElementById('classSubjectScores');
    while( classSubjectScoresTbl.rows.length > 1 ){
        classSubjectScoresTbl.deleteRow( -1 );
    }
    
    $('#editAllBtnBottom').html("<span class='glyphicon glyphicon-pencil'></span>&nbsp;&nbsp;EDIT ALL");
    $('#editAllBtnTop').html("<span class='glyphicon glyphicon-pencil'></span>&nbsp;&nbsp;EDIT ALL");
    $('#editAllBtnBottom').attr("onclick", "enableEditAll();" );
    $('#editAllBtnTop').attr("onclick", "enableEditAll();" );
    $('#editAllBtnBottom').removeClass("btn-success");
    $('#editAllBtnTop').removeClass("btn-success");
    $('#editAllBtnBottom').addClass("btn-primary");
    $('#editAllBtnTop').addClass("btn-primary");
    
    $('#menu_sub_' + subject_id ).addClass("custom-link-active");
    $('#menu_sub_' + subject_id ).parent().addClass("active custom-active");
    var testContentJson = JSON.parse($('#teacherTestContentJson').val());
    if( 'test_details' in testContentJson ){
        var test_details = testContentJson['test_details'];
        $('#details_testDate').html( test_details[subject_id]['test_date'] );
        $('#details_gradingType').html( test_details[subject_id]['grading_type_desc'] );
        $('#gradingType').val( test_details[subject_id]['grading_type'] );
        var class_avg = test_details[subject_id]['class_average'];
        var class_avg_html = '<div class="progress" style="margin-bottom:0px;">' +
                                 '<div class="progress-bar" role="progressbar" aria-valuenow="' + class_avg + '" ' +
                                      'aria-valuemin="0" aria-valuemax="100" style="width:' + class_avg + '%;">' +
                                     class_avg +
                                 '</div>' +
                             '</div>';
        $('#classAvgTd').html(class_avg_html);
        
        var studentHtml = '';
        if( 'student_list' in test_details[subject_id] ){
            var student_list = test_details[subject_id]['student_list'];
            for( var student_idx in student_list ){
                studentHtml += '<tr>' +
                            '<td class="student_roll">' + student_list[student_idx]['student_roll_no'] + '</td>' +
                            '<td class="student_name">' + 
                                student_list[student_idx]['firstname'] + ' ' + student_list[student_idx]['lastname'] +
                            '</td>' +
                            '<td class="student_grade" id="studentGrade_' + subject_id + '_' + student_list[student_idx]['student_id'] + '">' + student_list[student_idx]['grade'] + '</td>' +
                            '<td class="student_remark" id="studentRemark_' + subject_id + '_' + student_list[student_idx]['student_id'] + '">' + 
                                    student_list[student_idx]['remarks'] +  
                            '</td>' +
                            '<td class="student_action">' +
                                '<button type="button" id="editStudentDetailsBtn_' + subject_id + '_' + 
                                            student_list[student_idx]['student_id'] + '" class="btn btn-sm btn-warning"' + 
                                            ' onclick="editStudentScoreCard(' + subject_id + ', ' + student_list[student_idx]['student_id'] + ');" >' +
                                    '<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;EDIT' +
                                '</button>' +
                            '</td>' +
                        '</tr>';
            }
        }
                    
        $('#classSubjectScores tr:last').after( studentHtml );
        $('#classSubjectScoresDiv').css("display", "block");
    }    
}

function enableEditAll(){
    $('#editAllBtnBottom').html("SAVE ALL");
    $('#editAllBtnTop').html("SAVE ALL");
    $('#editAllBtnBottom').attr("onclick", "saveScoreCard();" );
    $('#editAllBtnTop').attr("onclick", "saveScoreCard();" );
    $('#editAllBtnBottom').removeClass("btn-primary");
    $('#editAllBtnTop').removeClass("btn-primary");
    $('#editAllBtnBottom').addClass("btn-success");
    $('#editAllBtnTop').addClass("btn-success");    
    
    var testContentJson = JSON.parse($('#teacherTestContentJson').val());
    var gradingType = $('#gradingType').val().trim();
    $("td[id^=studentGrade_]").each( function(e){
        var id = $(this).attr("id");
        var substud = id.split('_');
        var subject_id = substud[1].trim();
        var student_id = substud[2].trim();
        var existingGrade = '';
        var existingRemarks = '';
        
        if( $('#grade_sel_' + subject_id + '_' + student_id ).length ){
            existingGrade = $('#grade_sel_' + subject_id + '_' + student_id ).val();
        } else {
            existingGrade = $('#studentGrade_' + subject_id + '_' + student_id ).html().trim();
        } 
        
        if( $('#remark_' + subject_id + '_' + student_id ).length ){
            existingRemarks = $('#remark_' + subject_id + '_' + student_id ).val()
        } else {
            existingRemarks = $('#studentRemark_' + subject_id + '_' + student_id ).html().trim();
        }  
        
        var remarksHtml = '<input type="text" id="remark_' + subject_id + '_' + student_id + 
                        '" class="form-control" value="' + existingRemarks + '" >';
        var gradeHtml = '<select id="grade_sel_' + subject_id + '_' + student_id + '" class="form-control" >' +
                            '<option value="">Select</option>';
        if( 'grading_types' in testContentJson &&  gradingType in testContentJson['grading_types'] ){
            var grade_arr = testContentJson['grading_types'][gradingType];
            var selected = '';
            for( var i=0; i < grade_arr.length; i++ ){
                if( existingGrade != '' && existingGrade == grade_arr[i]['grade'] ){
                    selected = ' selected ';
                } else {
                    selected = '';
                }
                gradeHtml += '<option value="' + grade_arr[i]['grade'] + '" ' + selected + '>' + grade_arr[i]['grade'] + '</option>';
            }
        }
        gradeHtml += '</select>';
        $('#studentGrade_' + subject_id + '_' + student_id ).html( gradeHtml );
        $('#studentRemark_' + subject_id + '_' + student_id ).html( remarksHtml );
        
        $('#editStudentDetailsBtn_' + subject_id + '_' + student_id ).html('SAVE');
        $('#editStudentDetailsBtn_' + subject_id + '_' + student_id).removeClass("btn-warning");
        $('#editStudentDetailsBtn_' + subject_id + '_' + student_id).addClass("btn-success");
        $('#editStudentDetailsBtn_' + subject_id + '_' + student_id).attr("onclick", "saveStudentScoreCard(" + subject_id + ", " + student_id + ");");
    });
}

function saveScoreCard(){
    var details = {};
    details['test_id'] = $('#testId').val();
    details['grading_type'] = $('#gradingType').val();
    details['student_details'] = {};
    var subject_id = '';
    $("td[id^=studentGrade_]").each( function(e){
        var id = $(this).attr("id");
        var substud = id.split('_');
        subject_id = substud[1].trim();
        var student_id = substud[2].trim();
        var gradeVal = $('#grade_sel_' + subject_id + '_' + student_id ).val();
        var remark = $('#remark_' + subject_id + '_' + student_id).val();
        details['student_details'][student_id] = {};
        details['student_details'][student_id]['grade'] = gradeVal;
        details['student_details'][student_id]['remark'] = remark;
    });
    
    details['subject_id'] = subject_id;
    
    var detailsJson = JSON.stringify(details);
    var url = '/saveScoreCard';
    var datastring = 'data=' + encodeURIComponent( detailsJson );
    
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : true,
        dataType: "json",
        success : function(responseText) {
            if( responseText.indexOf("true") >= 0 ){
                responseText = responseText.split("~~");
                var class_avg = responseText[1].trim();
                var class_avg_html = '<div class="progress" style="margin-bottom:0px;">' +
                                         '<div class="progress-bar" role="progressbar" aria-valuenow="' + class_avg + '" ' +
                                              'aria-valuemin="0" aria-valuemax="100" style="width:' + class_avg + '%;">' +
                                             class_avg +
                                         '</div>' +
                                     '</div>';
                $('#classAvgTd').html(class_avg_html);
                $("td[id^=studentGrade_]").each( function(e){
                    var id = $(this).attr("id");
                    var substud = id.split('_');
                    var subject_id = substud[1].trim();
                    var student_id = substud[2].trim();
                    var gradeVal = $('#grade_sel_' + subject_id + '_' + student_id ).val();
                    $('#studentGrade_' + subject_id + '_' + student_id ).html( gradeVal );
                    $('#studentRemark_' + subject_id + '_' + student_id ).html( $('#remark_' + subject_id + '_' + student_id).val() );

                    $('#editStudentDetailsBtn_' + subject_id + '_' + student_id ).html('<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;EDIT');
                    $('#editStudentDetailsBtn_' + subject_id + '_' + student_id).removeClass("btn-success");
                    $('#editStudentDetailsBtn_' + subject_id + '_' + student_id).addClass("btn-warning");
                    $('#editStudentDetailsBtn_' + subject_id + '_' + student_id).attr("onclick", "editStudentScoreCard(" + subject_id + ", " + student_id + ");");
                });
                $('#editAllBtnBottom').html("<span class='glyphicon glyphicon-pencil'></span>&nbsp;&nbsp;EDIT ALL");
                $('#editAllBtnTop').html("<span class='glyphicon glyphicon-pencil'></span>&nbsp;&nbsp;EDIT ALL");
                $('#editAllBtnBottom').attr("onclick", "enableEditAll();" );
                $('#editAllBtnTop').attr("onclick", "enableEditAll();" );
                $('#editAllBtnBottom').removeClass("btn-success");
                $('#editAllBtnTop').removeClass("btn-success");
                $('#editAllBtnBottom').addClass("btn-primary");
                $('#editAllBtnTop').addClass("btn-primary");
            } else {
                alert("Could not update the scorecard. Please try again!");
            }
        }
    });
}

function editStudentScoreCard( subject_id, student_id ){
    $('#editStudentDetailsBtn_' + subject_id + '_' + student_id ).html('SAVE');
    $('#editStudentDetailsBtn_' + subject_id + '_' + student_id).removeClass("btn-warning");
    $('#editStudentDetailsBtn_' + subject_id + '_' + student_id).addClass("btn-success");
    $('#editStudentDetailsBtn_' + subject_id + '_' + student_id).attr("onclick", "saveStudentScoreCard(" + subject_id + ", " + student_id + ");");
    
    var existingGrade = '';
    var existingRemarks = '';
    
    if( $('#grade_sel_' + subject_id + '_' + student_id ).length ){
        existingGrade = $('#grade_sel_' + subject_id + '_' + student_id ).val();
    } else {
        existingGrade = $('#studentGrade_' + subject_id + '_' + student_id ).html().trim();
    } 
    
    if( $('#remark_' + subject_id + '_' + student_id ).length ){
        existingRemarks = $('#remark_' + subject_id + '_' + student_id ).val()
    } else {
        existingRemarks = $('#studentRemark_' + subject_id + '_' + student_id ).html().trim();
    }
    
    var remarksHtml = '<input type="text" id="remark_' + subject_id + '_' + student_id + 
                        '" class="form-control" value="' + existingRemarks + '" >';
    var gradingType = $('#gradingType').val().trim();
    var testContentJson = JSON.parse($('#teacherTestContentJson').val());
    var gradeHtml = '<select id="grade_sel_' + subject_id + '_' + student_id + '" class="form-control" >' +
                        '<option value="">Select</option>';
    if( 'grading_types' in testContentJson &&  gradingType in testContentJson['grading_types'] ){
        var grade_arr = testContentJson['grading_types'][gradingType];
        var selected = '';
        for( var i=0; i < grade_arr.length; i++ ){
            if( existingGrade != '' && existingGrade == grade_arr[i]['grade'] ){
                selected = ' selected ';
            } else {
                selected = '';
            }
            gradeHtml += '<option value="' + grade_arr[i]['grade'] + '" ' + selected + '>' + grade_arr[i]['grade'] + '</option>';
        }
    }
    gradeHtml += '</select>';
    $('#studentGrade_' + subject_id + '_' + student_id ).html( gradeHtml );
    $('#studentRemark_' + subject_id + '_' + student_id ).html( remarksHtml );
}

function saveStudentScoreCard( subject_id, student_id ){
    var gradeVal = $('#grade_sel_' + subject_id + '_' + student_id ).val();
    var remark = $('#remark_' + subject_id + '_' + student_id ).val();
    var test_id = $('#testId').val();
    
    var url = '/saveStudentScoreCard';
    var datastring = 'test_id=' + test_id + '&subject_id=' + subject_id + '&student_id=' + student_id + 
                        '&gradeVal=' + gradeVal + '&remark=' + remark;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        async : true,
        dataType: "json",
        success : function(responseText) {
            if( responseText.indexOf("true") >= 0 ){
                responseText = responseText.split("~~");
                var class_avg = responseText[1].trim();
                var class_avg_html = '<div class="progress" style="margin-bottom:0px;">' +
                                         '<div class="progress-bar" role="progressbar" aria-valuenow="' + class_avg + '" ' +
                                              'aria-valuemin="0" aria-valuemax="100" style="width:' + class_avg + '%;">' +
                                             class_avg +
                                         '</div>' +
                                     '</div>';
                $('#classAvgTd').html(class_avg_html);
                $('#editStudentDetailsBtn_' + subject_id + '_' + student_id ).html('<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;EDIT');
                $('#editStudentDetailsBtn_' + subject_id + '_' + student_id).removeClass("btn-success");
                $('#editStudentDetailsBtn_' + subject_id + '_' + student_id).addClass("btn-warning");
                $('#editStudentDetailsBtn_' + subject_id + '_' + student_id).attr("onclick", "editStudentScoreCard(" + subject_id + ", " + student_id + ");");
                $('#studentGrade_' + subject_id + '_' + student_id ).html( gradeVal );
                $('#studentRemark_' + subject_id + '_' + student_id ).html( $('#remark_' + subject_id + '_' + student_id).val() );
                alert("Successfully updated the score!");
            } else {
                alert("Could not update the score!");
            }
        }
    });
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

function populateClassFeed(){
    var class_id = $('#selectFeedClass').val().trim();
    var class_desc = $('#selectFeedClass :selected').html().trim();
    if( class_id == '' ){
        $('#selectClassTxt').css("display", "block");
        $('#classNotifTable').css("display", "none");
        $('#classForumDiv').html('<h3 style="text-align:center;">Please select a class!</h3>');
        return;
    }
    
    var classFeedHtml = '<div class="row" id="postBoxDiv">' +
                            '<div class="col-sm-9">' +
                                '<textarea class="form-control" id="postingTextArea" rows="2" ' +
                                         ' value="" placeholder="[' + class_desc + 
                                                                    '] Enter your post here... "></textarea>' +
                            '</div>' +
                            '<div class="col-sm-3" style="margin-top:3px;">' +
                                '<input type="button" id="postUpdateBtn" class="btn btn-primary" style="margin-right:5px;" ' +
                                      ' value="POST" onclick="postInForum(' + class_id + ');">' +
                                '<button id="postUpdatePic_' + class_id + '" class="btn btn-default" data-toggle="modal" ' +
                                      ' data-target="#uploadPicModal" data-backdrop="static" data-keyboard="true">' +
                                    '<span class="glyphicon glyphicon-camera"></span>' +
                                '</button>' +
                                '<input type="hidden" id="last_feed_fetched_time" value="">' +
                            '</div>' +
                        '</div>' +
                        '<div id="homeContentDiv" style="height:400px;margin-top:20px;overflow-y:scroll;">' +
                        '</div>';
                
    $('#classForumDiv').html( classFeedHtml );
    fetchTeacherForumItems( class_id );
    fetchClassNotifications( class_id );
}

function fetchClassNotifications( class_id ){
    var classNotifTable = document.getElementById('classNotifTable');
    /*while( classNotifTable.rows.length > 0 ){
        classNotifTable.deleteRow(-1);
    }*/
    var url = '/fetchClassNotifications';
    var datastring = 'class_id=' + class_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function( responseText ) {
            var classNotifHtml = getClassNotificationHtml( responseText );
            $('#selectClassTxt').css("display", "none");
            $('#classNotifTable').css("display", "block");
            $('#classNotifTable').html( classNotifHtml );
            console.log(responseText);
        }
    });
}

function getClassNotificationHtml( notificationObj ){
    var classNotifHtml = '';
    if( Array.isArray(notificationObj) && notificationObj.length > 0 ){
        for( var i=0; i < notificationObj.length; i++ ){
            var name = notificationObj[i]['name'].trim();
            if( 'bwd_doa' in notificationObj[i] && notificationObj[i]['bwd_doa'].trim() != '' ){
                classNotifHtml += '<tr>' +
                                        '<td>' +
                                            '<p style="margin:0px;">It was <strong>' + name + '\'s</strong> marriage anniversary on <strong>' +  
                                                  notificationObj[i]['bwd_doa']  + '</strong>. Wish them now!</p>' +
                                        '</td>' +
                                    '</tr>';
            }
            if( 'bwd_dob' in notificationObj[i] && notificationObj[i]['bwd_dob'].trim() != '' ){
                classNotifHtml += '<tr>' +
                                        '<td>' +
                                            '<p style="margin:0px;">It was <strong>' + name + '\'s</strong> birthday on <strong>' +  
                                                  notificationObj[i]['bwd_dob']  + '</strong>. Wish them now!</p>' +
                                        '</td>' +
                                    '</tr>';
            }
            if( 'bwd_doj' in notificationObj[i] && notificationObj[i]['bwd_doj'].trim() != '' ){
                classNotifHtml += '<tr>' +
                                        '<td>' +
                                            '<p style="margin:0px;">It was <strong>' + name + '\'s</strong> work anniversary on <strong>' +  
                                                  notificationObj[i]['bwd_doj']  + '</strong>. Wish them now!</p>' +
                                        '</td>' +
                                    '</tr>';
            }
            if( 'fwd_doa' in notificationObj[i] && notificationObj[i]['fwd_doa'].trim() != '' ){
                classNotifHtml += '<tr>' +
                                        '<td>' +
                                            '<p style="margin:0px;">It is <strong>' + name + '\'s</strong> marriage anniversary today. Wish them now!</p>' +
                                        '</td>' +
                                    '</tr>';
            }
            if( 'fwd_dob' in notificationObj[i] && notificationObj[i]['fwd_dob'].trim() != '' ){
                classNotifHtml += '<tr>' +
                                        '<td>' +
                                            '<p style="margin:0px;">It is <strong>' + name + '\'s</strong> birthday today. Wish them now!</p>' +
                                        '</td>' +
                                    '</tr>';
            }
            if( 'fwd_doj' in notificationObj[i] && notificationObj[i]['fwd_doj'].trim() != '' ){
                classNotifHtml += '<tr>' +
                                        '<td>' +
                                            '<p style="margin:0px;">It is <strong>' + name + '\'s</strong> work anniversary today. Wish them now!</p>' +
                                        '</td>' +
                                    '</tr>';
            }
        }
    }
    
    return classNotifHtml;
}

function fetchTeacherForumItems( class_id ){
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
            var feedHtml = getClassFeedHtml( responseText, isInit, class_id );
            //populateForumItems( responseText );
            
            var moreFeedHtml = getMoreClassFeedHtml( class_id );
            feedHtml += moreFeedHtml;
            $('#homeContentDiv').html(feedHtml);
        }
    });
}

function postInForum( class_id ){
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
            var feedHtml = getClassFeedHtml( responseText, isInit, class_id );
            //populateForumItems( responseText );
            
            var moreFeedHtml = getMoreClassFeedHtml( class_id );
            feedHtml += moreFeedHtml;
            $('#homeContentDiv').html(feedHtml);
            $('#postingTextArea').val('');
            //alert(responseText);
        }
    });
}

function getClassFeedHtml( dataObject, isInit, class_id ){
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
                                             '<span class="delete_post" style="cursor:pointer;" onclick="deleteClassPost(' + item_id + ', ' + class_id + ');">&times;</span>' +
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
                                                    '" onclick="deleteClassPost(' + item_id + ', ' +  class_id + ');">&nbsp;&nbsp;&times;</span>' + 
                                                '<small id="feed_item_time_' + item_id + '" style="float:right;padding-top:4px;">' + 
                                                    posted_at + '</small>' +
                                            '</p>' +
                                        '</div>' +
                                        //cancelPostHtml +
                                    '</div>' +
                                    '<p style="width:100%;" id="feed_item_text_' + item_id + '">' +
                                        getLinkText(item_text) + '</p>';
                    if( item_type == '2' && pic_url != '' ){
                        feed_html += '<button type="button" class="btn viewImage" onclick="showFeedImage(' + item_id + ');" id="showFeedImageBtn_' + item_id + '">' +
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
                                                                '<span class="delete_post" onclick="deleteClassComment(' + item_id + ', ' + 
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
                                                ' onclick="postClassComment(' + item_id + ', \'comment_box_' + item_id + '\' );" >' +
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

function getMoreClassFeedHtml( class_id ){
    return '<div class="row" id="showMoreFeedDiv">' +
               '<div class="col-sm-8 col-sm-offset-1" style="text-align:center;margin-top:5px;">' +
                   '<div class="col-sm-10">' +
                       '<button type="button" class="btn btn-primary" onclick="showMoreClassFeed(' + class_id + ');" >' +
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

function postClassComment( item_id, comment_box_id ){
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
                                            '<a href="#" id="showMoreFeedDetail_' + item_id + '" onclick="fetchCommentDetails(' + item_id + ', ' + comment_id + ');" >' +
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
                                                       '<span class="delete_post" onclick="deleteClassComment(' + item_id + ', ' + 
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

function deleteClassPost( item_id, class_id ){
    var url = '/deleteClassPost';
    var datastring = 'item_id=' + item_id + '&class_id=' + class_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            var isInit = true;
            var feedHtml = getClassFeedHtml( responseText, isInit, class_id );
            var moreFeedHtml = getMoreClassFeedHtml( class_id );
            feedHtml += moreFeedHtml;
            $('#homeContentDiv').html(feedHtml);
        }
    });
}

function deleteClassComment( item_id, comment_id ){
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

function showMoreClassFeed( class_id ){
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
            var feedHtml = getClassFeedHtml( responseText, isInit, class_id );
            var moreFeedHtml = getMoreClassFeedHtml( class_id );
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
            var feedDetailHtml = getFeedDetailHtml( responseText );
            $('#feedDetailModalContent').html( feedDetailHtml );
        }
    });    
});

$('#feedDetailModal').on('hidden.bs.modal', function(e){
    $('#feedDetailModalContent').html( '' );
});

function getFeedDetailHtml( dataJson ){
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
            var base_url = $('#base_url').val();
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
                                                   '<span class="delete_post" onclick="deleteClassComment(' + item_id + ', ' + comment_id + ');" >&times;</span>' +
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
                                '<a href="#" id="showMoreFeedDetail_' + item_id + '" onclick="fetchCommentDetails(' + item_id + ', ' + comment_id + ');" >' +
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
                                                ' onclick="postClassComment(' + item_id + ', \'commentDetailText_' + item_id + '\' );">' +
                                      '</div>' +
                                  '</div>' +
                              '</div>' +
                              '<div class="col-sm-2">' +
                              '</div>' +
                          '</div>';
        
    }
    
    return feedDetailHtml;
}

function fetchCommentDetails( item_id, comment_id ){
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
                                                       '<span class="delete_post" onclick="deleteClassComment(' + item_id + ', ' + 
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
                                    '<a href="#" id="showMoreFeedDetail_' + item_id + '" onclick="fetchCommentDetails(' + item_id + ', ' + comment_id + ');" >' +
                                        'Show More Comments ' +
                                    '</a>' +
                                '</td></tr>';
            }
            
            $('#feedDetailCommentTable').html( existingComments + feedDetailCommentsHtml );
        }
    });
}

function showUploadedFileName( elem ){
    var filename = $(elem).val();
    $('#upload-file-info').html("Added file : " + filename );
}

function showFeedImage( item_id ){
    var base_url = $('#base_url').val();
    var pic_url = $('#pic_url_' + item_id ).val().trim();
    var imageHtml = '<img id="feedImage_' + item_id + '" class="img-rounded img-responsive" style="padding-bottom:20px;" ' +
                          ' src="' + base_url + '/images/8/'+ pic_url +'"  alt="Picture">';
    
    $('#feedImageDiv_' + item_id ).html(imageHtml);
    var showImageBtnHtml = '<span class="glyphicon glyphicon-eye-close">&nbsp;</span>HIDE IMAGE&nbsp;&nbsp;';
    
    $('#showFeedImageBtn_' + item_id).html( showImageBtnHtml );
    $('#showFeedImageBtn_' + item_id).removeClass('viewImage');
    $('#showFeedImageBtn_' + item_id).addClass('hideImage');
    $('#showFeedImageBtn_' + item_id).attr("onclick", "hideFeedImage(" + item_id + ");");
}

function hideFeedImage( item_id ){
    $('#feedImageDiv_' + item_id).html('');
    var showImageBtnHtml = '<span class="glyphicon glyphicon-eye-open">&nbsp;</span>VIEW IMAGE&nbsp;&nbsp;';
    
    $('#showFeedImageBtn_' + item_id).html( showImageBtnHtml );
    $('#showFeedImageBtn_' + item_id).removeClass('hideImage');
    $('#showFeedImageBtn_' + item_id).addClass('viewImage');
    $('#showFeedImageBtn_' + item_id).attr("onclick", "showFeedImage(" + item_id + ");");
}

$('#uploadPicModal').on('shown.bs.modal', function(e){
    var invoker_id = $(e.relatedTarget).attr("id");
    var class_id = invoker_id.split("_");
    class_id = class_id[1].trim();
    $('#pic_class_id').val( class_id );
});

function teacherClassForumOnLoad(){
    populateClassFeed();
}

function teacherHomeWorkOnload(){
    
}

function populateClassSubjects(){
    var classSubjectList = JSON.parse($('#classSubjectList').val().trim());
    var selected_class_id = $('#selectHWClass :selected').val().trim();
    var selectSubHtml = '<option value="">Select</option>';
    if( selected_class_id != '' ){
        if( selected_class_id in classSubjectList && Array.isArray( classSubjectList[selected_class_id] ) ){
            var subjects = classSubjectList[selected_class_id];
            for( var i=0; i < subjects.length; i++ ){
                selectSubHtml += '<option value="' + subjects[i]['subject_id'] + '">' +  
                                        subjects[i]['subject_name'] + 
                                 '</option>';
            }
        }
    }
    $('#selectHWSubject').html(selectSubHtml);
}

function populateHomeWork(){
    var selected_class_id = $('#selectHWClass :selected').val().trim();
    var selected_subject_id = $('#selectHWSubject :selected').val().trim();
    var selectedClassDesc = $('#selectHWClass option:selected').text().trim();
    var selectedSubjectDesc = $('#selectHWSubject option:selected').text().trim();
    var last_hw_id = -1;
    
    $('#selectPostedTime').val('');
    $('#selectCompleteByTime').val('');
    
    $('#selected_class_id').val(selected_class_id);
    $('#selected_subject_id').val(selected_subject_id);
    $('#selectedClassDesc').val(selectedClassDesc);
    $('#selectedSubjectDesc').val(selectedSubjectDesc);
    
    var isValid = validateHomeWorkRequest( selected_class_id, selected_subject_id, selectedClassDesc, selectedSubjectDesc );
    if( isValid ){
        fetchHomeWorkDetails( selected_class_id, selected_subject_id, selectedClassDesc, selectedSubjectDesc, last_hw_id );
    }
}

function validateHomeWorkRequest( selected_class_id, selected_subject_id, selectedClassDesc, selectedSubjectDesc ){
    $('#selectHWClassMsg').css("display", "none");
    $('#selectHWSubjectMsg').css("display", "none");
    if( selected_class_id == '' ){
        $('#selectHWClassMsg').css("display", "block");
    }
    if( selected_subject_id == '' ){
        $('#selectHWSubjectMsg').css("display", "block");
    }
    
    if( selected_class_id == '' || selected_subject_id == '' ){
        var contentHtml = '<h4 style="text-align:center;"><strong>Please select a class and subject!</strong></h4>';
        $('#homeWorkContentDiv').html( contentHtml );
        return false;
    }
    return true;
}

function fetchHomeWorkDetails( selected_class_id, selected_subject_id, selectedClassDesc, selectedSubjectDesc, last_hw_id ){
    var url = '/fetchHomeWorkDetails';
    var datastring = 'class_id=' + selected_class_id + '&subject_id=' + selected_subject_id + '&last_hw_id=' + last_hw_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            last_hw_id_fetched = last_hw_id;
            if( typeof responseText == 'object' && 'last_hw_id_fetched' in responseText ){
                var last_hw_id_fetched = responseText['last_hw_id_fetched'];
            }
            
            var homeWorkEntryHtml = getHomeWorkEntryHtml( selected_class_id, selected_subject_id, 
                                                    selectedClassDesc, selectedSubjectDesc, last_hw_id_fetched );
            var homeWorkFeedHtml = getHWFeedPreHtml() + getHomeWorkFeedHtml( responseText ) + getHWFeedPostHtml();
            //var homeWorkGetMoreFeedHtml = getMoreHWFeedHtml();
            $('#homeWorkContentDiv').html( homeWorkEntryHtml + homeWorkFeedHtml );
            console.log(responseText);
        }
    });
}

function getHomeWorkEntryHtml( class_id, subject_id, class_name, subject_name, last_hw_id ){
    var entryHtml = '<div class="row">' +
                        '<div class="col-sm-12">' +
                            '<h4><strong id="homeworkTitle">' + class_name + '</strong></h4>' +
                        '</div>' +
                    '</div>' +
                    '<div class="row" id="homeworkEntry">' +
                        '<div class="col-sm-8 form-group" style="padding-top:6px;padding-right:2px;">' +
                            '<textarea id="homeWorkText" class="form-control" ' +
                                     ' placeholder="[' + subject_name + '] Enter Home Work..." ></textarea>' +
                            '<p id="homeWorkTextErr" class="inputAlert">* Please enter a valid home work text!</p>' +
                        '</div>' +
                        '<div class="col-sm-2 form-group" style="padding:0px;text-align: center;">' +
                            '<label for="addHomeWorkSubmitBy" st>Complete By</label>' +
                            '<input class="form-control" type="text" name="addHomeWorkSubmitBy" id="addHomeWorkSubmitBy" ' +
                                  ' class="form-control" value="" ' +
                                  ' onclick="javascript:NewCssCal(\'addHomeWorkSubmitBy\',\'yyyyMMdd\',\'arrow\',false,\'12\',false,\'\');">' +
                            '<p id="addHomeWorkSubmitByErr"  class="inputAlert">* Please enter a valid date that is later than today</p>' +
                        '</div>' +
                        '<div class="col-sm-2 form-group" style="padding-left:8px;padding-top:25px;">' +
                            '<button type="button" id="postHomeWork" class="btn btn-primary" ' + 
                                    ' onclick="postClassHomeWork(' + class_id + ', ' + subject_id + ', \'' + 
                                                                    class_name + '\', \'' + subject_name + '\');">' +
                                '<span class="glyphicon glyphicon-send"></span>&nbsp;POST ' +
                            '</button>' +
                            '<input type="hidden" id="last_hw_fetched_id" value="' + last_hw_id + '">' +
                            '<input type="hidden" id="selected_class_id" value="' + class_id + '">' +
                            '<input type="hidden" id="selected_subject_id" value="' + subject_id + '">' +
                            '<input type="hidden" id="selectedClassDesc" value="' + class_name + '">' +
                            '<input type="hidden" id="selectedSubjectDesc" value="' + subject_name + '">' +
                        '</div>' +
                    '</div>';
            /*
             * 
             * @param {type} homeWorkJsonObj
             * @returns {String}var selected_class_id = $('#selectHWClass :selected').val().trim();
    var selected_subject_id = $('#selectHWSubject :selected').val().trim();
    var selectedClassDesc = $('#selectHWClass option:selected').text().trim();
    var selectedSubjectDesc = $('#selectHWSubject option:selected').text().trim();
    var last_hw_id = $('#last_hw_id_fetched').val().trim();
             */
    return entryHtml;
}

function getHWFeedPreHtml(){
    var hw_pre_feed_html = '<div class="row" id="homeWorkFeedContentDiv" >' +
                            '<div class="col-sm-8">' +
                               '<div class="row">' +
                                   '<div class="col-sm-12" id="hwScrollableContentDiv" style="padding-right:0px;height:500px;overflow-y:scroll;">';
                           
    return hw_pre_feed_html;
}

function getHomeWorkFeedHtml( homeWorkJsonObj ){   
    var hw_feed_html = '';
    if( typeof homeWorkJsonObj == 'object' && ( 'hw_details' in homeWorkJsonObj ) && ( 'last_hw_id_fetched' in homeWorkJsonObj )
            &&  Array.isArray(homeWorkJsonObj['hw_details']) && homeWorkJsonObj['hw_details'].length > 0 ){
        var last_hw_id_fetched = homeWorkJsonObj['last_hw_id_fetched'];
        $('#last_hw_id_fetched').val( last_hw_id_fetched );
        var homeWorkJsonObj = homeWorkJsonObj['hw_details'];
        for( var i=0; i < homeWorkJsonObj.length; i++ ){
            hw_feed_html += '<div class="panel panel-default" id="hw_panel_' + homeWorkJsonObj[i]['homework_id'] + '" >' +
                                '<div class="panel-body hw_panel">' +
                                    '<div class="row">' +
                                        '<div class="col-sm-11 hw_text_div">' +
                                            '<p id="homework_desc_' + homeWorkJsonObj[i]['homework_id'] + '">' + homeWorkJsonObj[i]['homework_desc'] + '</p>' +
                                        '</div>' +
                                        '<div class="col-sm-1 hw_close_btn_div" >' +
                                            '<span id="buttonClose_' + homeWorkJsonObj[i]['homework_id'] + '" style="cursor:pointer;" class="btn btn-default" ' +
                                                 ' data-toggle="tooltip" data-placement="bottom" title="Delete Home Work" ' +
                                                 ' onclick="deleteHomeWork(' + homeWorkJsonObj[i]['homework_id'] + ');" >' +
                                                '<strong>&times;</strong>' +
                                            '</span>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="row">' +
                                        '<div class="col-sm-6">' +
                                            '<button type="button" class="form-control hw_buttons_po">' +
                                                '<strong>Posted On</strong> <span class="badge">' + homeWorkJsonObj[i]['posted_date'] + '</span>' +
                                            '</button>' +
                                        '</div>' +
                                        '<div class="col-sm-6">' +
                                            '<button type="button" class="form-control hw_buttons_cb">' +
                                                '<strong>Complete By</strong> <span class="badge">' + homeWorkJsonObj[i]['complete_by'] + '</span>' +
                                            '</button>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
        }
        var homeWorkGetMoreFeedHtml = getMoreHWFeedHtml();
        hw_feed_html += homeWorkGetMoreFeedHtml;
    }  
                                      
    return hw_feed_html;
}

function getHWFeedPostHtml(){
    var hw_feed_post_html =     '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';
                           
    return hw_feed_post_html;
}


function postClassHomeWork( class_id, subject_id, class_name, subject_name ){
    var homeworkText = $('#homeWorkText').val().trim();
    var addHomeWorkSubmitBy = $('#addHomeWorkSubmitBy').val().trim();
    $('#homeWorkTextErr').css("display", "none");
    $('#addHomeWorkSubmitByErr').css("display", "none");
    var hasError = false;
    if( homeworkText == '' ){
        hasError = true;
        $('#homeWorkTextErr').css("display", "block");
    }
    if( addHomeWorkSubmitBy != '' ){
        var submitByDate = new Date( addHomeWorkSubmitBy );
        if ( Object.prototype.toString.call(submitByDate) !== "[object Date]" ){
            hasError = true;
            $('#addHomeWorkSubmitByErr').css("display", "block");
        } else {
            var cur_date = new Date();
            if( submitByDate.getTime() < ( cur_date.getTime() - (24*60*60*1000) ) ){
                hasError = true;
                $('#addHomeWorkSubmitByErr').css("display", "block");
            }
        }
    } else {
        hasError = true;
        $('#addHomeWorkSubmitByErr').css("display", "block");
    }
    if( hasError ){
        return;
    }
    var url = '/postClassHomeWork';
    var datastring = 'class_id=' + class_id + '&subject_id=' + subject_id + '&homeworkText=' + encodeURIComponent( homeworkText )
                        + '&addHomeWorkSubmitBy=' + encodeURIComponent( addHomeWorkSubmitBy );
                
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( responseText || responseText.trim() == "true" ){
                fetchHomeWorkDetails( class_id, subject_id, class_name, subject_name, -1 );
            } else {
                alert("Home work could not be added. Please try later!");
            }
            console.log(responseText);
        },
        error : function( exception ){
            alert("Home work could not be added. Please try later!");
            console.log(exception);
        }
    });
}

function deleteHomeWork( homework_id ){
    var url = '/deleteHomeWork';
    var datastring = 'homework_id=' + homework_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( responseText === true || responseText === "true" ){
                $('#hw_panel_' + homework_id ).remove();
            }
            console.log(responseText);
            
        },
        error : function( exception ){
            alert("Home work could not be added. Please try later!");
            console.log(exception);
        }
    });
}

function showMoreHWFeed(){
    var selected_class_id = $('#selected_class_id').val();
    var selected_subject_id = $('#selected_subject_id').val();
    /*var selectedClassDesc = $('#selectedClassDesc').val();
    var selectedSubjectDesc = $('#selectedSubjectDesc').val();*/
    var last_hw_fetched_id = $('#last_hw_fetched_id').val();
    
    var url = '/fetchHomeWorkDetails';
    var datastring = 'class_id=' + selected_class_id + '&subject_id=' + selected_subject_id + '&last_hw_id=' + last_hw_fetched_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( typeof responseText == 'object' && 'last_hw_id_fetched' in responseText ){
                var last_hw_id_fetched = responseText['last_hw_id_fetched'];
            }     
           
            $('#last_hw_fetched_id').html( last_hw_id_fetched );
            $('#showMoreFeedDiv').remove();  
            
            var homeWorkFeedHtml = getHomeWorkFeedHtml( responseText );
            //var homeWorkGetMoreFeedHtml = getMoreHWFeedHtml();
            var existingHWFeed = $('#hwScrollableContentDiv').html();
            $('#hwScrollableContentDiv').html( existingHWFeed + homeWorkFeedHtml );
            
            //var existingHomeWorkContentDivHtml = $('#homeWorkContentDiv').html();
            //$('#homeWorkContentDiv').html( existingHomeWorkContentDivHtml + homeWorkGetMoreFeedHtml );
            $('#hwScrollableContentDiv').prop("scrollTop", $('#hwScrollableContentDiv').prop("scrollTop") + 150 );
            console.log(responseText);
        }
    });
}

function getMoreHWFeedHtml(){
    var moreHWFeedHtml = '<div class="row" id="showMoreFeedDiv">' +
                             '<div class="col-sm-12" style="text-align:center;margin-top:5px;">' +
                                 '<button type="button" class="btn btn-primary" onclick="showMoreHWFeed();" >' +
                                     '&nbsp;' +
                                     '<span class="glyphicon glyphicon glyphicon-menu-down"></span>' +
                                     '&nbsp;' +
                                     'SHOW MORE' +
                                     '&nbsp;' +
                                     '<span class="glyphicon glyphicon-menu-down"></span>' +
                                     '&nbsp;' +
                                 '</button>' +
                             '</div>' +
                         '</div>';
    
    return moreHWFeedHtml;
}

function populateTimeWiseHW(){
    var postedDate = $('#selectPostedTime').val().trim();
    var completionDate = $('#selectCompleteByTime').val().trim();
    
    if( postedDate == '' && completionDate == '' ){
        alert("Please select atleast one of Posted Date or Completion Date!");
        return;
    }
    var url = '/fetchHWByTime';
    var datastring = 'postedDate=' + encodeURIComponent(postedDate) + '&completionDate=' + encodeURIComponent(completionDate);
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            var searchCriteriaHtml = '<h4><strong><i>Search Criteria - </i></strong>';
            var postedDateText = $('#selectPostedTime :selected').text().trim();
            var completionDateText = $('#selectCompleteByTime :selected').text().trim();
            
            $('#selectHWClass').val('');
            $('#selectHWSubject').val('');
            
            if( postedDate != '' && completionDate != '' ){
                searchCriteriaHtml += ' Posted Date : <mark>' + postedDateText + '</mark> AND Completion Date : <mark>' + completionDateText + '</mark></h4>';
            } else if( postedDate != '' ){
                searchCriteriaHtml += ' Posted Date : <mark>' + postedDateText + '</mark></h4>';
            } else if( completionDate != '' ){
                searchCriteriaHtml += ' Completion Date : <mark>' + completionDateText + '</mark></h4>';
            }
            
            var timeBasedHWHtml = getTimeBasedHWHtml( responseText );
            $('#homeWorkContentDiv').html( searchCriteriaHtml + timeBasedHWHtml );
            console.log(responseText);
        }
    });
}

function getTimeBasedHWHtml( hwDetailObject ){
    var timeBasedHWHtml = '<div class="row">' +
                            '<div class="col-sm-offset-2 col-sm-8">';
    if( Array.isArray(hwDetailObject) && hwDetailObject.length > 0 ){
        for( var i=0; i < hwDetailObject.length; i++ ){
            timeBasedHWHtml += '<div class="panel panel-default" id="hw_panel_' + hwDetailObject[i]['homework_id'] + '" >' +
                               '<div class="panel-heading" style="padding:2px;">' +
                                   '<div class="row">' +
                                       '<div class="col-sm-10">' +
                                           '<h4 class="hw_time_title"><strong>' + 
                                                hwDetailObject[i]['class_desc'] + ' - Section ' + hwDetailObject[i]['section'] + 
                                                    '[ ' + hwDetailObject[i]['subject_name'] + ' ]' + 
                                            '</strong></h4>' +
                                       '</div>' +
                                       '<div class="col-sm-2" style="text-align: right;">' +
                                           '<span id="buttonClose" style="cursor:pointer;" class="btn btn-default" ' +
                                              ' data-toggle="tooltip" data-placement="bottom" title="Delete Home Work" ' +
                                              ' onclick="deleteHomeWork(' + hwDetailObject[i]['homework_id'] + ');" >' +
                                             '<strong>&times;</strong>' +
                                         '</span>' +
                                       '</div>' +
                                   '</div>' +
                               '</div>' +
                               '<div class="panel-body hw_panel">' +
                                   '<div class="row">' +
                                       '<div class="col-sm-12 hw_text_div">' +
                                           '<p id="homework_desc">' + hwDetailObject[i]['homework_desc'] + '</p>' +
                                       '</div>' +
                                   '</div>' +
                                   '<div class="row">' +
                                       '<div class="col-sm-6">' +
                                           '<button type="button" class="form-control hw_buttons_po">' +
                                               '<strong>Posted On</strong> <span class="badge">' + hwDetailObject[i]['posted_date'] + '</span>' +
                                           '</button>' +
                                       '</div>' +
                                       '<div class="col-sm-6">' +
                                           '<button type="button" class="form-control hw_buttons_cb">' +
                                               '<strong>Complete By</strong> <span class="badge">' + hwDetailObject[i]['complete_by'] + '</span>' +
                                           '</button>' +
                                       '</div>' +
                                   '</div>' +
                               '</div>' +
                           '</div>';
               }
               
        timeBasedHWHtml +=      '</div>' +
                             '</div>';
    } else {
        timeBasedHWHtml += '<br><br<br<br><h4 style="text-align:center;">No Home Work Found!</h4>';
    }
                   
    return timeBasedHWHtml;              
}

function activateClassTimeTables(){
    $('#TimeTableMenu li').each( function(e){
       $(this).removeClass("active custom-active"); 
       $(this).children().removeClass("custom-link-active");
    });
    
    $('#classTimeTables').addClass("custom-link-active");
    $('#classTimeTables').parent().addClass("active custom-active");
    if( $('#classTTJson').val().trim() != '' ){
        var teacherTTObj = JSON.parse( $('#classTTJson').val().trim() );
        var TTClassHtml = getTTChooseClassHtml( teacherTTObj );
        $('#timeTableContent').html( TTClassHtml );
        return;
    }
    var url = '/getTeacherClassTT';
    $.ajax({
        type : "GET",
        url : url,
        dataType: "json",
        success : function(responseText) {
            if( typeof responseText == 'object' ){
                var TTClassHtml = getTTChooseClassHtml( responseText );
                $('#timeTableContent').html( TTClassHtml );
            }
            $('#classTTJson').val( JSON.stringify(responseText) );
            console.log( responseText );
        },
        error : function( exception ){
           // console.log( exception );
        }
    });
    //var blankTT = getBlankTimeTableHtml( maxPeriods, maxDays, 'panel-date' );
}

function activateMyTimeTable(){
    $('#TimeTableMenu li').each( function(e){
       $(this).removeClass("active custom-active"); 
       $(this).children().removeClass("custom-link-active");
    });
    
    $('#myTimetable').addClass("custom-link-active");
    $('#myTimetable').parent().addClass("active custom-active");
    if( $('#teacherTTJson').val().trim() != '' ){
        displayTeacherTT();
        return;
    }
    var url = '/getTeacherTimeTable';
    $.ajax({
        type : "GET",
        url : url,
        dataType: "json",
        success : function(responseText) {
            if( typeof responseText == 'object' ){
                $('#teacherTTJson').val( JSON.stringify(responseText) );
                displayTeacherTT();
            }
            console.log( responseText );
        },
        error : function( exception ){
           // console.log( exception );
        }
    });
    $('#timeTableContent').html( '<br>' + blankTT );
}

function getBlankTimeTableHtml( maxPeriods, maxDays, tt_type ){ 
    var dayArray = ["MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN"];
    var panelClass = 'panel-date';
    var periodArray = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII" ];
    if( tt_type == 'mytt' ){
        panelClass = 'panel-tt-detail';
        periodArray = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
    } 
    
    var timetableHtml = '<div class="row" style="margin:0;margin-top:15px;">' +
        '<div class="col-sm-1" style="margin:0;padding:2px;"></div>' +
        '<div class="col-sm-1" style="margin:0;padding:2px;"></div>';

       for( var k=0; k < maxPeriods; k++ ){ 
        timetableHtml += '<div class="col-sm-1" style="margin:0;padding:2px;">' +
            '<div class="panel panel-default ' + panelClass + ' panel-period" id="tt_period_' + k + '_panel">' +
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
                    '<div class="panel panel-default ' + panelClass + ' panel-day" id="tt_day_' + j + '_panel">' +
                        '<div class="panel-body">' +
                            '<p style="margin:0;text-align:center;" id="tt_day_' + j + '"><strong>' + dayArray[j] + '</strong></p>' +
                        '</div>' +
                    '</div>' +
                '</div>';
                for( var i=0; i < maxPeriods; i++ ){
                 timetableHtml += 
                    '<div class="col-sm-1" style="margin:0;padding:2px;">' +
                        '<div class="panel panel-default ' + panelClass + '" id="tt_' + j + '_' + i + '_panel" >' + 
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
    //$('#timetable_body').html(timetableHtml);
    return timetableHtml;
}

function getTTChooseClassHtml( classTTObj ){
    var TTClassHtml = '<div class="row">' +
                          '<div class="col-sm-2 light_background" id="timeTableClasses" style="min-height:400px;">' +
                              '<table class="table table-bordered table-responsive" id="TTClasses" ' +
                                    ' style="background-color:#ffffff;margin-top:40px;text-align:center;">' +
                                    '<tr>' +
                                        '<th style="text-align: center;background-color:#dddddd;">Select Class</th>' +
                                    '</tr>';
                              
              
    for( var class_id in classTTObj ) {
        if( classTTObj.hasOwnProperty(class_id) && 'class' in classTTObj[class_id]
                && 'section' in classTTObj[class_id] && 'numDays' in classTTObj[class_id] 
                && 'numPeriods' in classTTObj[class_id] && 'timeTableArr' in classTTObj[class_id] ){
            
            TTClassHtml += '<tr>' +
                              '<td class="clickable" id="classTd_' + class_id + '" onclick="displayTimeTable(' + class_id + ');">' + 
                                   '<p style="margin:0px;" id="classDesc_' + class_id + '">' + classTTObj[class_id]['class'] + ' - Section ' + 
                                          classTTObj[class_id]['section'] + '</p>' + 
                                   '<input type="hidden" id="numDays_' + class_id + 
                                      '" value="' + classTTObj[class_id]['numDays'] + '">' +
                                   '<input type="hidden" id="numPeriods_' + class_id + 
                                      '" value="' + classTTObj[class_id]['numPeriods'] + '">' +
                              '</td>' +
                           '</tr>';
        }
    }
    
    TTClassHtml +=          '</table>' +
                          '</div>' +
                          '<div class="col-sm-10" id="timeTableClassContent" style="min-height:400px;padding:15px;">' +    
                          '</div>' +
                      '</div>';
    return TTClassHtml;
}

function teacherTTOnLoad(){
    fetchTeacherTT();
    fetchTeacherClassTT();
}

function fetchTeacherTT(){
    
}

function fetchTeacherClassTT(){
    
}

function displayTimeTable( class_id ){
    $('td[id^=classTd_]').each( function(index){
        $(this).css("background-color", "#ffffff");
    });
    $('#classTd_' + class_id).css("background-color", "burlywood");
    var numDays = $('#numDays_' + class_id).val().trim();
    var numPeriods = $('#numPeriods_' + class_id).val().trim();
    
    var timeTableContent = '<h4 style="text-align:center;">' + $('#classDesc_' + class_id ).html().trim() + '</h4>';
    var blankTTHtml = getBlankTimeTableHtml( numPeriods, numDays, 'classtt' );
    timeTableContent = timeTableContent + blankTTHtml;
    $('#timeTableClassContent').html( timeTableContent );
    
    var classTTJson = JSON.parse( $('#classTTJson').val().trim() );
    if( typeof classTTJson == 'object' && class_id in classTTJson && 'timeTableArr' in classTTJson[class_id]
            && Array.isArray( classTTJson[class_id]['timeTableArr'] ) ){
        var timeTableArr = classTTJson[class_id]['timeTableArr'];
        for( var day = 0; day < timeTableArr.length; day++ ) {
            for( var period = 0; period < timeTableArr[day].length; period++ ){
                if( 'subject_short' in  timeTableArr[day][period] && timeTableArr[day][period]['subject_short'].trim() != '' ){
                    $('#tt_' + day + '_' + period ).html(timeTableArr[day][period]['subject_short'].trim());
                    $('#tt_' + day + '_' + period + '_subject_id').val( timeTableArr[day][period]['subject_id'].trim() );
                }
            }
        }
    }
}

function displayTeacherTT(){
    var teacherTTObj = JSON.parse( $('#teacherTTJson').val().trim() );
    console.log(teacherTTObj);
    var blankTT = getBlankTimeTableHtml( DEFAULT_MAX_PERIODS, DEFAULT_MAX_DAYS, 'mytt' );
    $('#timeTableContent').html( blankTT );
    var classMap = {}
    classMap['0'] = 'PreKG';
    classMap['1'] = 'LKG';
    classMap['2'] = 'UKG';
    classMap['3'] = 'I';
    classMap['4'] = 'II';
    classMap['5'] = 'III';
    classMap['6'] = 'IV';
    classMap['7'] = 'V';
    classMap['8'] = 'VI';
    classMap['9'] = 'VII';
    classMap['10'] = 'VIII';
    classMap['11'] = 'IX';
    classMap['12'] = 'X';
    classMap['13'] = 'XI';
    classMap['14'] = 'XII';
    classMap['15'] = 'PH';
    
    if( Array.isArray( teacherTTObj ) && teacherTTObj.length > 0 ){
        for( var i=0; i < teacherTTObj.length; i++ ){
            if( Array.isArray( teacherTTObj[i] ) && teacherTTObj[i].length > 0 ){
                for( var j=0; j < teacherTTObj[i].length; j++ ){
                    if( 'subject_short' in  teacherTTObj[i][j] && teacherTTObj[i][j]['subject_short'].trim() != '' && 
                           'class' in  teacherTTObj[i][j] && teacherTTObj[i][j]['class'].trim() != '' && 
                           'section' in  teacherTTObj[i][j] && teacherTTObj[i][j]['section'].trim() != '' ){
                       
                        var tt_content = classMap[teacherTTObj[i][j]['class'].trim()] + ' - ' + teacherTTObj[i][j]['section'].trim()
                                            + '<br>[ ' + teacherTTObj[i][j]['subject_short'].trim() + ' ]';
                                    
                        $('#tt_' + i + '_' + j ).html( tt_content );
                        $('#tt_' + i + '_' + j + '_subject_id').val( teacherTTObj[i][j]['subject_id'].trim() );
                    }
                }
            }
        }
    }
}
