$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

function toggleSectionTab( element, class_num ){
    if( $('#' + element.id ).prop("checked") ){
        $('#sections_' + class_num).css("display", "block");
    } else {
        $('#sections_' + class_num).css("display", "none");
    }
}

function addClassesOnLoad(){
    
}

function updateSections(){
    var sections = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
                    'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    var numSections = $('#numSections').val();
    numSections = parseInt(numSections);
    $("div[id^='sections_'").each( function( index ){
        var div_id = $( this ).attr("id");
        var section_id = div_id.split("_");
        section_id = section_id[1];
        var html = ''; 
        for( var i=0; i<numSections; i++ ){
            html = html + '<input type="text" class="input-sm" id="class_'+ section_id + '_'+ i + 
                            '" name="class_'+ section_id + '_'+ i + '" value="' + sections[i] + '" >';
        }
        $(this).html(html);
    });
    alert("Number of sections updated");
}

function addTestsOnLoad(){
    if( $('#testsAdded').val().trim() == 'true' ){
        alert( "Tests added successfully! ");
        return;
    }
}

var addedTests = [];
var numTests = 0;
function addTest(){
    var addedTestHtml = '';
    var test_name = $('#test_name').val().trim();
    var fromTestPeriod = $('#fromTestPeriod').val().trim();
    var toTestPeriod = $('#toTestPeriod').val().trim();
    var gradingType = $('#gradingType').val().trim();
    
    addedTests[numTests] = [ test_name, fromTestPeriod, toTestPeriod, gradingType ];
    numTests++;
  
    var addedTestHtml = '<button class="btn btn-sm chosen_btn" id="test_' + numTests + '"' +
        'onclick="removeTest( ' + numTests + ' )">' +
        '<span class="glyphicon glyphicon-remove"></span>' + 
        '<strong>&nbsp;' + test_name + '</strong>' +
    '</button>&nbsp;';
    
    $('#addedTests').html( $('#addedTests').html() + addedTestHtml );
    
}

function populateAddTests(){
    numTests = 0;
    $('#addedTestsJson').val( JSON.stringify( addedTests ) );
    $('#addedTests').html('');
    return true;
}

function removeTest( test_num ){
    delete addedTests[test_num];
    $('#test_' + test_num ).remove();
}

