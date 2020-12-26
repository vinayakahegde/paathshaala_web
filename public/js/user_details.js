function activateTeacherDetails(){
    $('#TeacherMenu li').each( function(e){
       $(this).removeClass("active custom-active"); 
       $(this).children().removeClass("custom-link-active");
    });
    
    $('#teacherDetails').addClass("custom-link-active");
    $('#teacherDetails').parent().addClass("active custom-active");
    
    var teacher_id = $('#selectedTeacherId').val();
    var pic_url = $('#teacher_pic_url_' + teacher_id).val().trim();
    $('#teacherTimeTableContent').css( "display", "none" );
    $('#teacherDetailContent').css( "display", "block" );
    loadImage('teacherDetailImg', pic_url);
}

function activateTeacherTimeTables(){
    $('#TeacherMenu li').each( function(e){
       $(this).removeClass("active custom-active"); 
       $(this).children().removeClass("custom-link-active");
    });
    
    $('#teacherTimeTable').addClass("custom-link-active");
    $('#teacherTimeTable').parent().addClass("active custom-active");
    
    $('#teacherDetailContent').css( "display", "none" );
    $('#teacherTimeTableContent').css( "display", "block" );
}

$('#teacherModal').on( 'shown.bs.modal', function(e){
    var invoker_id = $(e.relatedTarget).attr("id");
    var teacher_id = invoker_id.split("_");
    teacher_id = teacher_id[2];
    $('#selectedTeacherId').val(teacher_id);
    var url = '/fetchTeacherDetails';
    var datastring = 'teacher_id=' + teacher_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( typeof responseText == 'object' && 'teacherProfileDetails' in responseText && 'teacherTimeTable' in responseText ){
                var profileDetails = responseText['teacherProfileDetails'];
                var timetableDetails = responseText['teacherTimeTable'];
                populateTeacherDetails( profileDetails );
                populateTeacherTTDetails( timetableDetails );
            }
            console.log( responseText );
        },
        error : function( exception ){
           // console.log( exception );
        }
    });
    activateTeacherDetails();
});

$('#teacherModal').on( 'hidden.bs.modal', function(e){
    $('#teacherDetailImg').prop("src", "");
});

function populateTeacherDetails( profileDetails ){
    console.log( profileDetails );
    $('#teacherNameHeading').html('');
    $('#teacher_firstname').html('');
    $('#teacher_lastname').html('');
    $('#teacher_birthday').html('');
    $('#teacher_qualification').html('');
    $('#teacher_experience').html('');
    $('#teacher_doj').html('');
    $('#teacher_address').html('');
    $('#teacher_phone').html('');
    $('#teacher_email').html('');
    $('#teacher_twitter').html('');
    $('#teacher_blog').html('');
    
    if( 'firstname' in profileDetails ){
        $('#teacher_firstname').html( profileDetails['firstname'].trim() );
        $('#teacherNameHeading').html( profileDetails['firstname'].trim() );
    }
    if( 'lastname' in profileDetails ){
        $('#teacher_lastname').html( profileDetails['lastname'].trim() );
        $('#teacherNameHeading').html( $('#teacherNameHeading').html() + ' ' + profileDetails['lastname'].trim() );
    }
    if( 'date_of_birth' in profileDetails ){
        $('#teacher_birthday').html( profileDetails['date_of_birth'].trim() );
    }
    if( 'qualification' in profileDetails ){
        $('#teacher_qualification').html( profileDetails['qualification'].trim() );
    }
    if( 'experience' in profileDetails ){
        $('#teacher_experience').html( profileDetails['experience'].trim() );
    }
    if( 'date_of_joining' in profileDetails ){
        $('#teacher_doj').html( profileDetails['date_of_joining'].trim() );
    }
    if( 'address' in profileDetails ){
        $('#teacher_address').html( profileDetails['address'].trim() );
    }
    if( 'phone' in profileDetails ){
        $('#teacher_phone').html( profileDetails['phone'].trim() );
    }
    if( 'email_id' in profileDetails ){
        $('#teacher_email').html( profileDetails['email_id'].trim() );
    }
    if( 'twitter' in profileDetails ){
        $('#teacher_twitter').html( profileDetails['twitter'].trim() );
    }
    if( 'blog' in profileDetails ){
        $('#teacher_blog').html( profileDetails['blog'].trim() );
    }
    var othersExist = false;
    for( var i=1; i <= 5; i++ ){
        var hobby_id = 'hobby_' + i;
        var achievement_id = 'achievement_' + i;
        $('#' + hobby_id).html('');
        $('#' + achievement_id ).html('');
        if( hobby_id in profileDetails && profileDetails[hobby_id].trim() != '' ){
            othersExist = true;
            $('#' + hobby_id).html( profileDetails[hobby_id].trim() );
        }
        if( achievement_id in profileDetails && profileDetails[achievement_id].trim() != '' ){
            othersExist = true;
            $('#' + achievement_id ).html( profileDetails[achievement_id].trim() );
        }
    }
    
    if( !othersExist ){
        $('#otherDetails').css("display", "none");
    } else {
        $('#otherDetails').css("display", "block");
    }
}

function populateTeacherTTDetails( timetableDetails ){
    if( Array.isArray( timetableDetails ) && timetableDetails.length > 0 ){
        for( var day_id=0; day_id < timetableDetails.length; day_id++ ){
            for( var period_id=0; period_id < timetableDetails[day_id].length; period_id++ ){
                var tt_content = timetableDetails[day_id][period_id]['class'] + '-' + timetableDetails[day_id][period_id]['section'];
                $('#tt_' + day_id + '_' + period_id ).html( tt_content );
            }
        }
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

$('#studentDetailModal').on('shown.bs.modal', function(e){
    var invoker_id = $(e.relatedTarget).attr("id");
    var student_id = invoker_id.split("_");
    student_id = student_id[2];
    var url = '/fetchStudentDetails';
    var datastring = 'student_id=' + student_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( typeof responseText == 'object' && 'studentAndParentDetails' in responseText && 'studentSCDetails' in responseText ){
                var studentAndParentDetails = responseText['studentAndParentDetails'];
                var studentSCDetails = responseText['studentSCDetails'];
                
                $('#selectedStudentId').val( student_id );
                $('#studentDetailTitle').html($('#student_name_' + student_id).html().trim());
                $('#studentAndParentDetails').val( JSON.stringify(studentAndParentDetails) );
                $('#scoreCardDetailsJson').val( JSON.stringify(studentSCDetails) );
                populateStudentDetails();
                populateFatherDetails();
                populateMotherDetails();
                populateStudentSC();
                showStudentProfile();
            }
            console.log( responseText );
        },
        error : function( exception ){
           // console.log( exception );
        }
    });
});

function populateStudentDetails(){
    var studentAndParentDetails = JSON.parse( $('#studentAndParentDetails').val().trim() );
    if( 'firstname' in studentAndParentDetails ){
        $('#student_firstname').html( studentAndParentDetails['firstname'].trim() );
    }
    if( 'lastname' in studentAndParentDetails ){
        $('#student_lastname').html( studentAndParentDetails['lastname'].trim() );
    }
    if( 'date_of_birth' in studentAndParentDetails ){
        $('#student_birthday').html( studentAndParentDetails['date_of_birth'].trim() );
    }
    if( 'class_desc' in studentAndParentDetails ){
        $('#student_class').html( studentAndParentDetails['class_desc'].trim() + ' - Section ' + studentAndParentDetails['section'].trim() );
    }
    if( 'student_roll_no' in studentAndParentDetails ){
        $('#student_roll').html( studentAndParentDetails['student_roll_no'].trim() );
    }
    if( 'exam_register_no' in studentAndParentDetails ){
        $('#student_exam_regno').html( studentAndParentDetails['exam_register_no'].trim() );
    }
    if( 'date_of_joining' in studentAndParentDetails ){
        $('#student_doj').html( studentAndParentDetails['date_of_joining'].trim() );
    }
    if( 'address' in studentAndParentDetails ){
        $('#student_address').html( studentAndParentDetails['address'].trim() );
    }
    if( 'phone' in studentAndParentDetails ){
        $('#student_phone').html( studentAndParentDetails['phone'].trim() );
    }
    if( 'email_id' in studentAndParentDetails ){
        $('#student_email').html( studentAndParentDetails['email_id'].trim() );
    }
    if( 'twitter' in studentAndParentDetails ){
        $('#student_twitter').html( studentAndParentDetails['twitter'].trim() );
    }
    if( 'blog' in studentAndParentDetails ){
        $('#student_blog').html( studentAndParentDetails['blog'].trim() );
    }
    var othersExist = false;
    for( var i=1; i <= 5; i++ ){
        var hobby_id = 'hobby_' + i;
        var achievement_id = 'achievement_' + i;
        if( hobby_id in studentAndParentDetails && studentAndParentDetails[hobby_id].trim() != '' ){
            othersExist = true;
            $('#' + hobby_id).html( studentAndParentDetails[hobby_id].trim() );
        }
        if( achievement_id in studentAndParentDetails && studentAndParentDetails[achievement_id].trim() != '' ){
            othersExist = true;
            $('#' + achievement_id ).html( studentAndParentDetails[achievement_id].trim() );
        }
    }
    
    if( !othersExist ){
        $('#otherDetails').css("display", "none");
    } else {
        $('#otherDetails').css("display", "block");
    }
}

function populateFatherDetails(){
    var studentAndParentDetails = JSON.parse( $('#studentAndParentDetails').val().trim() );
    if( 'father_firstname' in studentAndParentDetails ){
        $('#father_firstname').html( studentAndParentDetails['father_firstname'].trim() );
    }
    if( 'father_lastname' in studentAndParentDetails ){
        $('#father_lastname').html( studentAndParentDetails['father_lastname'].trim() );
    }
    if( 'father_dob' in studentAndParentDetails ){
        $('#father_birthday').html( studentAndParentDetails['father_dob'].trim() );
    }
    if( 'father_doa' in studentAndParentDetails ){
        $('#father_anniversary').html( studentAndParentDetails['father_doa'].trim() );
    }
    if( 'father_qualification' in studentAndParentDetails ){
        $('#father_qualification').html( studentAndParentDetails['father_qualification'].trim() );
    }
    if( 'father_pow' in studentAndParentDetails ){
        $('#father_pow').html( studentAndParentDetails['father_pow'].trim() );
    }
    if( 'father_address' in studentAndParentDetails ){
        $('#father_address').html( studentAndParentDetails['father_address'].trim() );
    }
    if( 'father_phone' in studentAndParentDetails ){
        $('#father_phone').html( studentAndParentDetails['father_phone'].trim() );
    }
    if( 'father_email' in studentAndParentDetails ){
        $('#father_email').html( studentAndParentDetails['father_email'].trim() );
    }
    if( 'father_twitter' in studentAndParentDetails ){
        $('#father_twitter').html( studentAndParentDetails['father_twitter'].trim() );
    }
    if( 'father_blog' in studentAndParentDetails ){
        $('#father_blog').html( studentAndParentDetails['father_blog'].trim() );
    }
}

function populateMotherDetails(){
    var studentAndParentDetails = JSON.parse( $('#studentAndParentDetails').val().trim() );
    if( 'mother_firstname' in studentAndParentDetails ){
        $('#mother_firstname').html( studentAndParentDetails['mother_firstname'].trim() );
    }
    if( 'mother_lastname' in studentAndParentDetails ){
        $('#mother_lastname').html( studentAndParentDetails['mother_lastname'].trim() );
    }
    if( 'mother_dob' in studentAndParentDetails ){
        $('#mother_birthday').html( studentAndParentDetails['mother_dob'].trim() );
    }
    if( 'mother_doa' in studentAndParentDetails ){
        $('#mother_anniversary').html( studentAndParentDetails['mother_doa'].trim() );
    }
    if( 'mother_qualification' in studentAndParentDetails ){
        $('#mother_qualification').html( studentAndParentDetails['mother_qualification'].trim() );
    }
    if( 'mother_pow' in studentAndParentDetails ){
        $('#mother_pow').html( studentAndParentDetails['mother_pow'].trim() );
    }
    if( 'mother_address' in studentAndParentDetails ){
        $('#mother_address').html( studentAndParentDetails['mother_address'].trim() );
    }
    if( 'mother_phone' in studentAndParentDetails ){
        $('#mother_phone').html( studentAndParentDetails['mother_phone'].trim() );
    }
    if( 'mother_email' in studentAndParentDetails ){
        $('#mother_email').html( studentAndParentDetails['mother_email'].trim() );
    }
    if( 'mother_twitter' in studentAndParentDetails ){
        $('#mother_twitter').html( studentAndParentDetails['mother_twitter'].trim() );
    }
    if( 'mother_blog' in studentAndParentDetails ){
        $('#mother_blog').html( studentAndParentDetails['mother_blog'].trim() );
    }
}

function showStudentProfile(){
    $('#studentOwnProfile').css("display", "block");
    $('#studentFatherProfile').css("display", "none");
    $('#studentMotherProfile').css("display", "none");
    $('#studentScoreCard').css("display", "none");
    
    $('#studentProfileOpt').css("background", "burlywood");
    $('#fatherProfileOpt').css("background", "#ffffff");
    $('#motherProfileOpt').css("background", "#ffffff");
    $('#studentScoreCardOpt').css("background", "#ffffff");
    
    var student_id = $('#selectedStudentId').val();
    var pic_url = $('#student_pic_url_' + student_id ).val().trim();
    loadImage( 'studentProfileImg', pic_url );
    
}

function showFatherProfile(){
    $('#studentOwnProfile').css("display", "none");
    $('#studentFatherProfile').css("display", "block");
    $('#studentMotherProfile').css("display", "none");
    $('#studentScoreCard').css("display", "none");
    
    $('#studentProfileOpt').css("background", "#ffffff");
    $('#fatherProfileOpt').css("background", "burlywood");
    $('#motherProfileOpt').css("background", "#ffffff");
    $('#studentScoreCardOpt').css("background", "#ffffff");
    
    var student_id = $('#selectedStudentId').val();
    var pic_url = $('#student_father_pic_url_' + student_id ).val().trim();
    loadImage( 'fatherProfileImg', pic_url );
}

function showMotherProfile(){
    $('#studentOwnProfile').css("display", "none");
    $('#studentFatherProfile').css("display", "none");
    $('#studentMotherProfile').css("display", "block");
    $('#studentScoreCard').css("display", "none");
    
    $('#studentProfileOpt').css("background", "#ffffff");
    $('#fatherProfileOpt').css("background", "#ffffff");
    $('#motherProfileOpt').css("background", "burlywood");
    $('#studentScoreCardOpt').css("background", "#ffffff");
    
    var student_id = $('#selectedStudentId').val();
    var pic_url = $('#student_mother_pic_url_' + student_id ).val().trim();
    loadImage( 'motherProfileImg', pic_url );
}

function showStudentScoreCards(){
    $('#studentOwnProfile').css("display", "none");
    $('#studentFatherProfile').css("display", "none");
    $('#studentMotherProfile').css("display", "none");
    $('#studentScoreCard').css("display", "block");
    
    $('#studentProfileOpt').css("background", "#ffffff");
    $('#fatherProfileOpt').css("background", "#ffffff");
    $('#motherProfileOpt').css("background", "#ffffff");
    $('#studentScoreCardOpt').css("background", "burlywood");
}

function populateStudentSC(){
    //console.log(responseText);
    if( !($('#studentScoreCard').length) ){
        return;
    }
    var scoreCardDetailsObj = JSON.parse( $('#scoreCardDetailsJson').val() );
    var studentTestDetailsTbl = document.getElementById('studentTestDetailsTbl');
    while( studentTestDetailsTbl.rows.length > 1 ){
        studentTestDetailsTbl.deleteRow( -1 );
    }
    var cnt=0;
    var menuHtml = '<ul class="nav nav-tabs nav-justified">';
    var scoreCardHtml = '';
    for (var test_id in scoreCardDetailsObj ) {
        if( scoreCardDetailsObj.hasOwnProperty(test_id) && 'test_name' in scoreCardDetailsObj[test_id] ){
            if( cnt == 0 ){
                /*$('#details_testDate').html( test_details[subject_id]['test_date'] );
                $('#details_gradingType').html( test_details[subject_id]['grading_type_desc'] );
                $('#gradingType').val( test_details[subject_id]['grading_type'] );*/
                menuHtml += '<li role="presentation" class="active custom-active">' +
                                '<a href="#" class="custom-link-active" onclick="activateTestMenu(' + test_id 
                                    + ');" id="menu_test_' + test_id + '">' 
                                    + scoreCardDetailsObj[test_id]['test_name'] + 
                                '</a>' +
                            '</li>';
                
                if( 'details' in scoreCardDetailsObj[test_id] ){
                    var details = scoreCardDetailsObj[test_id]['details'];
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
                                    + scoreCardDetailsObj[test_id]['test_name'] + 
                                '</a>' +
                            '</li>';
            }
        }
        cnt++;
    }
    $('#studentTestDetailsMenu').html( menuHtml );
    $('#studentTestDetailsTbl tr:last').after( scoreCardHtml );
}

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

function parentStudentOnLoad(){
    $("img[id^='studentImage_']").each( function(e){
        var id = $(this).prop("id");
        var student_id = id.split('_');
        student_id = student_id[1].trim();
        
        var pic_url = $('#student_pic_url_' + student_id).val().trim();
        loadImage(id, pic_url);
    });
}

function addPanelHighLight( panel_id ){
    $( '#' + panel_id ).addClass('panel-highlight');
}

function removePanelHighlight( panel_id ){
    $( '#' + panel_id ).removeClass('panel-highlight');
}
