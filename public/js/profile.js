$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

function teacherProfileOnLoad(){
    var elementId = "teacherProfilePic";
    var url = $('#teacherProPicUrl').val().trim();
    if( url.trim() != "" ){
        loadImage( elementId, url );
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

function editProfileField( user_type, curElemId, fieldId, fieldName ){
    if( $('#' + fieldId ).find("input").length > 0 ){
        return;
    }
    var existingValue = $('#' + fieldId ).html().trim();
    var editableProfileFieldHtml = '<div class="input-group">' +
                                        '<input type="text" class="form-control" id="' + fieldId + '_text" value="' + existingValue + '">' +
                                        '<span class="input-group-btn">' +
                                            '<button class="btn btn-default" type="button" ' + 
                                                ' onclick="saveProfileField(\'' + user_type + '\', \'' + curElemId + '\', \'' + fieldName + '\', \'' + fieldId + '\');">SAVE</button>' +
                                        '</span>' +
                                    '</div>';
                            
    $('#' + fieldId ).html( editableProfileFieldHtml );
    $('#' + curElemId ).attr( "onclick", "uneditProfileField('" + user_type + "', '" + curElemId + "', '" + fieldId + "', '" + fieldName + "')" );
}

function uneditProfileField( user_type, curElemId, fieldId, fieldName ){
    var fieldText = $('#' + fieldId + '_text').val().trim();
    $('#' + fieldId ).html(fieldText);
    $('#' + curElemId ).attr( "onclick", "editProfileField('" + user_type + "', '" + curElemId + "', '" + fieldId + "', '" + fieldName + "')" );
}

function editAddressField( user_type, curElemId, fieldId, fieldName ){
    if( $('#' + fieldId ).find("textarea").length > 0 ){
        return;
    }
    var existingValue = $('#' + fieldId ).html().trim();
    var editableProfileFieldHtml = '<div class="row">' +
                                        '<div class="col-sm-9">' +
                                            '<textarea rows="3" class="form-control" id="' + fieldId + '_text" >' + 
                                                existingValue + 
                                            '</textarea>' +
                                        '</div>' +
                                        '<div class="col-sm-3">' +
                                            '<button class="btn btn-default" type="button" ' + 
                                                ' onclick="saveAddressField(\'' + user_type + '\', \'' + curElemId + '\', \'' + fieldName + '\', \'' + fieldId + '\');">SAVE</button>' +
                                        '</div>' +
                                    '</div>';
                            
    $('#' + fieldId ).html( editableProfileFieldHtml );
    $('#' + curElemId ).attr( "onclick", "uneditProfileField('" + user_type + "', '" + curElemId + "', '" + fieldId + "', '" + fieldName + "')" );
}

function uneditAddressField( user_type, curElemId, fieldId, fieldName ){
    var fieldText = $('#' + fieldId + '_text').val().trim();
    $('#' + fieldId ).html(fieldText);
    $('#' + curElemId ).attr( "onclick", "editAddressField('" + user_type + "', '" + curElemId + "', '" + fieldId + "', '" + fieldName + "')" );
}

function saveProfileField( user_type, curElemId, fieldName, fieldId ){
    var fieldValue = $('#' + fieldId + '_text').val().trim();
    if( fieldName.trim() == 'pincode' ){
        if( fieldValue.length != 6 || !( /^\d+$/.test(fieldValue) ) ){
            alert( "Please enter a valid pincode!" );
            return;
        }
    }
    if( fieldName.trim() == 'phone' ){
        if( fieldValue.length != 10 || !( /^\d+$/.test(fieldValue) ) ){
            alert( "Please enter a valid 10 digit phone number!" );
            return;
        }
    }
    
    if( fieldName.trim() == 'email' || fieldName.trim() == 'email_id' ){
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if( fieldValue == '' || !re.test(fieldValue) ){
            alert( "Please enter a valid email id!" );
            return;
        }
    }
    
    var url = '/saveProfileField';
    var datastring = 'user_type=' + encodeURIComponent(user_type) + '&fieldName=' + encodeURIComponent(fieldName) + '&fieldValue=' + encodeURIComponent(fieldValue);
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( responseText === true || responseText == "true" ){
                $('#' + fieldId ).html( fieldValue );
                $('#' + curElemId ).attr( "onclick", "editProfileField('" + user_type + "', '" + curElemId + "', '" + fieldId + "', '" + fieldName + "')" );
            } else {
                alert("Could not save " + fieldName );
            }
            console.log( responseText );
        }
    });
}

function saveAddressField( user_type, curElemId, fieldName, fieldId ){
    var fieldValue = $('#' + fieldId + '_text').val().trim();
    
    var url = '/saveProfileField';
    var datastring = 'user_type=' + encodeURIComponent(user_type) + '&fieldName=' + encodeURIComponent(fieldName) + '&fieldValue=' + encodeURIComponent(fieldValue);
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( responseText === true || responseText == "true" ){
                $('#' + fieldId ).html( fieldValue );
                $('#' + curElemId ).attr( "onclick", "editAddressField('" + user_type + "', '" + curElemId + "', '" + fieldId + "', '" + fieldName + "')" );
            } else {
                alert("Could not save " + fieldName );
            }
            console.log( responseText );
        }
    });
}

function showUploadedFileName( elem ){
    var filename = $(elem).val();
    $('#upload-file-info').html("Added file : " + filename );
}

function editBulkField( user_type, curElemId, fieldName, fieldId ){
    for( var i=1; i <= 5; i++ ){
        if( $('#' + fieldId + i ).find("textarea").length > 0 ){
            continue;
        }
        var existingValue = $('#' + fieldId + i ).html().trim();
        var editableProfileFieldHtml = '<textarea rows="3" class="form-control" id="' + fieldId + i + '_text" >' + 
                                           existingValue + 
                                       '</textarea>';

        $('#' + fieldId + i ).html( editableProfileFieldHtml );
    }
    $('#' + curElemId ).addClass("btn btn-default");
    $('#' + curElemId ).prop("title", "Save Changes");
    $('#' + curElemId ).html("SAVE");
    $('#' + curElemId ).tooltip();
    $('#' + curElemId ).attr( "onclick", "saveBulkEdit('" + user_type + "', '" + curElemId + "', '" + fieldId + "', '" + fieldName + "')" );
}

function saveBulkEdit( user_type, curElemId, fieldName, fieldId ){
    var url='/saveBulkEdit';
    var datastring='user_type=' + encodeURIComponent(user_type);
    for( var i=1; i <= 5; i++ ){
        var fieldVal = $('#' + fieldId + i + '_text' ).val().trim();
        if( i == 0 ){
            datastring += 'fieldName' + i + '=' + fieldName + i + '&fieldValue' + i + '=' + encodeURIComponent( fieldVal );
        } else {
            datastring += '&fieldName' + i + '=' + fieldName + i + '&fieldValue' + i + '=' + encodeURIComponent( fieldVal );
        }
    }
    
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( responseText === true || responseText == "true" ){
                $('#' + curElemId ).removeClass("btn btn-default");
                $('#' + curElemId ).prop( "title", "Edit" );
                $('#' + curElemId ).html('<span class="glyphicon glyphicon-pencil"></span>');
                $('#' + curElemId ).tooltip();
                $('#' + curElemId ).attr( "onclick", "editBulkField('" + user_type + "', '" + curElemId + "', '" + fieldId + "', '" + fieldName + "')" );
                for( var i=1; i <= 5; i++ ){
                    $('#' + fieldId + i ).html( $('#' + fieldId + i + '_text' ).val().trim() );
                }
            } else {
                alert("Could not save the details!" );
            }
            console.log( responseText );
        }
    });
}

function editProfileDateField( user_type, startYr, curElemId, fieldId, fieldName, selectName ){
    if( $('#' + fieldId ).find("select").length > 0 ){
        return;
    }
    var existingValue = $('#' + fieldId ).html().trim();
    var year = '';
    var month = '';
    var date = '';
    if( existingValue != '' ){
        var dateArr = existingValue.split('-');
        if( dateArr.length == 3 ){
            date = dateArr[0].trim();
            month = dateArr[1].trim();
            year = dateArr[2].trim();
        }
    }
    
    var yearOptions;
    if( year == '' ){
        yearOptions = '<option value="" selected>Select</option>';
    } else {
        yearOptions = '<option value="">Select</option>';
    }
     
    for( var i=startYr; i >= 1900; i-- ){
        if( year != '' && i == parseInt(year) ){
            yearOptions += '<option value="' + i + '" selected>' + i + '</option>';
        } else {
            yearOptions += '<option value="' + i + '" >' + i + '</option>';
        } 
    }
    
    var monthArr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var monthOptions;
    if( month == '' ){
        monthOptions = '<option value="" selected>Select</option>';
    } else {
        monthOptions = '<option value="">Select</option>';
    }
    for( var j=0; j < 12; j++ ){
        if( month != '' && monthArr[j] == month ){
            monthOptions += '<option value="' + monthArr[j] + '" selected>' + monthArr[j] + '</option>';
        } else {
            monthOptions += '<option value="' + monthArr[j] + '" >' + monthArr[j] + '</option>';
        }
    }
    
    var dateOptions;
    if( date == '' ){
        dateOptions = '<option value="" selected>Select</option>';
    } else {
        dateOptions = '<option value="">Select</option>';
    }
     
    for( var i=1; i <= 31; i++ ){
        if( date != '' && i == parseInt(date) ){
            dateOptions += '<option value="' + i + '" selected>' + i + '</option>';
        } else {
            dateOptions += '<option value="' + i + '" >' + i + '</option>';
        } 
    }
    
    var editableProfileDateFieldHtml = '<div class="row">' +
                                        '<div class="col-sm-4">' +
                                            '<label for="' + selectName + 'Year">Choose Year</label>' +
                                            '<select id="' + selectName + 'Year" class="form-control" onchange="checkMonthDays(\'' + selectName + '\');">' +
                                                yearOptions +
                                            '</select>' +
                                            '<p id="' + selectName + 'YearErr" class="inputAlert">* Please select an year</p>' +
                                        '</div>' +
                                        '<div class="col-sm-4">' +
                                            '<label for="' + selectName + 'Month">Choose Month</label>' +
                                            '<select id="' + selectName + 'Month" class="form-control" onchange="checkMonthDays(\'' + selectName + '\');">' +
                                                monthOptions +
                                            '</select>' +
                                            '<p id="' + selectName + 'MonthErr" class="inputAlert">* Please select a month</p>' +
                                        '</div>' +
                                        '<div class="col-sm-4">' +
                                            '<label for="' + selectName + 'Day">Choose Day</label>' +
                                            '<select id="' + selectName + 'Day" class="form-control">' +
                                                dateOptions +
                                            '</select>' +
                                            '<p id="' + selectName + 'DayErr" class="inputAlert">* Please select a date</p>' +
                                        '</div>' +
                                    '</div>';
                            
    $('#' + fieldId ).html( editableProfileDateFieldHtml );
    $('#' + curElemId ).addClass("btn btn-default");
    $('#' + curElemId ).prop("title", "Save Changes");
    $('#' + curElemId ).html("SAVE");
    $('#' + curElemId ).tooltip();
    $('#' + curElemId ).attr( "onclick", "saveProfileDateField('" + user_type + "', '" + startYr + "', '" + curElemId + "', '" + fieldId + "', '" + fieldName + "', '" + selectName + "' )" );
    
    if( date != '' ){
        checkMonthDays(selectName);
        //$('#' + selectName + 'Day' ).val( date );
    }
}

function saveProfileDateField( user_type, startYr, curElemId, fieldId, fieldName, selectName ){
    var year = $('#' + selectName + 'Year').val().trim();
    var month = $('#' + selectName + 'Month').val().trim();
    var date = $('#' + selectName + 'Day').val().trim();
    $('#' + selectName + 'YearErr' ).css("display", "none");
    $('#' + selectName + 'MonthErr' ).css("display", "none");
    $('#' + selectName + 'DayErr' ).css("display", "none");
    
    var isValid = true;
    if( year == '' ){
        $('#' + selectName + 'YearErr' ).css("display", "block");
        isValid = false;
    }
    if( month == '' ){
        $('#' + selectName + 'MonthErr' ).css("display", "block");
        isValid = false;
    }
    if( date == '' ){
        $('#' + selectName + 'DayErr' ).css("display", "block");
        isValid = false;
    }
    
    if( !isValid ){
        return;
    }
    
    var date_desc = date + '-' + month + '-' + year;
    var url='/saveProfileDate';
    var datastring='user_type=' + encodeURIComponent(user_type) + '&fieldName=' + fieldName + '&fieldValue=' + encodeURIComponent( date_desc );
    
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            if( responseText === true || responseText == "true" ){
                $('#' + curElemId ).removeClass("btn btn-default");
                $('#' + curElemId ).prop( "title", "Edit" );
                $('#' + curElemId ).html('<span class="glyphicon glyphicon-pencil"></span>');
                $('#' + curElemId ).attr( "onclick", "editProfileDateField('" + user_type + "', '" + startYr + "', '" + curElemId + "', '" + fieldId + "', '" + fieldName + "', '" + selectName + "')" );
                $('#' + fieldId).html( date_desc );
            } else {
                alert("Could not save the details!" );
            }
            console.log( responseText );
        }
    });
}

function checkMonthDays( selectName ){
    var year = $('#' + selectName + 'Year').val().trim();
    var month = $('#' + selectName + 'Month').val().trim();
    var date = $('#' + selectName + 'Day').val().trim();
    
    if( year == '' || month == '' ){
        return false;
    }
    
    var monthMap = {};
    monthMap['Jan'] = 31;
    monthMap['Feb'] = 29;
    monthMap['Mar'] = 31;
    monthMap['Apr'] = 30;
    monthMap['May'] = 31;
    monthMap['Jun'] = 30;
    monthMap['Jul'] = 31;
    monthMap['Aug'] = 31;
    monthMap['Sep'] = 30;
    monthMap['Oct'] = 31;
    monthMap['Nov'] = 30;
    monthMap['Dec'] = 31;
    
    if( (parseInt(year))%4 != 0 ){
        monthMap['Feb'] = 28;
    }
    
    var dateHtml = '<option value="" selected>Select</option>';
    for( var i = 1; i <= parseInt(monthMap[month]); i++ ){
        dateHtml += '<option value="' + i + '">' + i + '</option>';
    }
    $('#' + selectName + 'Day').html( dateHtml );
    if( date != '' && parseInt(date) < 29 ){
        $('#' + selectName + 'Day').val(date);
    }
    return true;
}

function changePassword(){
    var isValid = true;
    $('#oldPasswordErr').css("display", "none");
    $('#newPasswordErr').css("display", "none");
    $('#confirmPasswordErr').css("display", "none");
    
    var oldPassword = $('#oldPassword').val().trim();
    var newPassword = $('#newPassword').val().trim();
    var confirmPassword = $('#confirmPassword').val().trim();
    
    if( oldPassword == '' ){
        isValid = false;
        $('#oldPasswordErr').css("display", "block");
    }
    if( newPassword == '' ){
        isValid = false;
        $('#newPasswordErr').css("display", "block");
    }
    if( confirmPassword == '' ){
        isValid = false;
        $('#confirmPasswordErr').html('* Please enter the new password again');
        $('#confirmPasswordErr').css("display", "block");
    }
    
    if( !isValid ){
        return false;
    }
    
    if( newPassword != confirmPassword ){
        isValid = false;
        $('#confirmPasswordErr').html('* The confirmed password is not the same as the new password');
        $('#confirmPasswordErr').css("display", "block");
        return false;
    }
    
    var url = '/changePassword';
    var datastring = 'oldPassword=' + encodeURIComponent( oldPassword ) + '&newPassword=' + encodeURIComponent(newPassword)
                     + '&confirmPassword=' + encodeURIComponent(confirmPassword);
             
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "text",
        success : function(responseText) {
            if( responseText === true || responseText == "true" ){
                $('#changePasswordModal').modal('hide');
                alert("Password changed successfully!");
                return;
            } else if( responseText.indexOf("false") >= 0 ) {
                responseText = responseText.split("~~");
                var failReason = responseText[1].trim();
                alert( failReason );
            }
            console.log( responseText );
        },
        error : function( exception ){
            alert("Could not update the password. Please try later!");
            console.log( exception );
        }
    }); 
}

function parentProfileOnLoad(){
    var elementId = "parentProfilePic";
    var url = $('#parentProPicUrl').val().trim();
    if( url.trim() != "" ){
        loadImage( elementId, url );
    }
}

function studentProfileOnLoad(){
    var elementId = "studentProfilePic";
    var url = $('#studentProPicUrl').val().trim();
    if( url.trim() != "" ){
        loadImage( elementId, url );
    }
}

function editStudentProfile(){
    var studentProfileUrl = 'http://' + window.location.hostname + '/showStudentProfile';
    window.location.assign( studentProfileUrl );
}

function editParentProfile(){
    var studentProfileUrl = 'http://' + window.location.hostname + '/showProfile';
    window.location.assign( studentProfileUrl );
}

function schoolProfileOnLoad(){
    var elementId = "schoolProfilePic";
    var url = $('#schoolProPicUrl').val().trim();
    if( url.trim() != "" ){
        loadImage( elementId, url );
    }
}

$('#changePrivacyModal').on('shown.bs.modal', function(e){
    var url = '/getPrivacySettings';
    $.ajax({
        type : "GET",
        url : url,
        dataType: "json",
        success : function(responseText) {
            console.log(responseText);
            if( Array.isArray(responseText) ){
                populatePrivacy(responseText);
                $("select option[value='']").attr('disabled', true ); 
                /* if( $('#profile_type').val() == 'teacher' ){
                    populateTeacherPrivacy(responseText);
                }
                if( $('#profile_type').val() == 'school_login' ){
                    populateSLPrivacy(responseText);
                }
                if( $('#profile_type').val() == 'parent' ){
                    populateParentPrivacy(responseText);
                }
                if( $('#profile_type').val() == 'student' ){
                    populateStudentPrivacy(responseText);
                } */
            } else {
                alert("Could not fetch the privacy settings.");
            }
        }
    });
});

function populatePrivacy( privacyArr ){
    for( var i=0; i < privacyArr.length; i++ ){
        if( privacyArr[i].hasOwnProperty('permission_field') &&
                privacyArr[i].hasOwnProperty('level') ){
            
            var permission_field = privacyArr[i]['permission_field'];
            var level = privacyArr[i]['level'];
            if( permission_field == 'address' ){
                $('#address_priv').val( level );
            }
            
            if( permission_field == 'blog' ){
                $('#blog_priv').val( level );
            }
            
            if( permission_field == 'date_of_anniversary' ){
                $('#doa_priv').val( level );
            }
            
            if( permission_field == 'date_of_birth' ){
                $('#dob_priv').val( level );
            }
            
            if( permission_field == 'date_of_joining' ){
                $('#doj_priv').val( level );
            }
            
            if( permission_field == 'email_id' || permission_field == 'email' ){
                $('#email_priv').val( level );
            }
            
            if( permission_field == 'phone' ){
                $('#phone_priv').val( level );
            }
            
            if( permission_field == 'qualification' ){
                $('#qual_priv').val( level );
            }
            
            if( permission_field == 'twitter' ){
                $('#twitter_priv').val( level );
            }
            
            //to do
            if( permission_field == 'place_of_work' ){
                $('#twitter_priv').val( level );
            }
        }
    }
}