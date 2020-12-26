$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

function parentHomeOnLoad(){
    fetchForumItems();
    fetchClassNotifications();
}

function fetchForumItems(){
    var url = '/fetchForumItems';
    var datastring = 'to_time=' + $('#last_feed_fetched_time').val();
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            console.log(responseText);
            var isInit = true;
            var feedHtml = getFeedHtml( responseText, isInit );
            //populateForumItems( responseText );
            
            var moreFeedHtml = getMoreFeedHtml();
            feedHtml += moreFeedHtml;
            $('#homeContentDiv').html(feedHtml);
        }
    });
}

function postInForum(){
    var postedText = $('#postingTextArea').val().trim();
    if( typeof postedText != 'undefined' && postedText.trim() == '' ){
        alert( "Please enter a post!" );
        return;
    }
    var url = '/addTextPost';
    var datastring = 'text=' + encodeURIComponent(postedText);
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            console.log(responseText);
            var isInit = true;
            var feedHtml = getFeedHtml( responseText, isInit );
            //populateForumItems( responseText );
            
            var moreFeedHtml = getMoreFeedHtml();
            feedHtml += moreFeedHtml;
            $('#homeContentDiv').html(feedHtml);
            $('#postingTextArea').val('');
            //alert(responseText);
        }
    });
}

function getFeedHtml( dataObject, isInit ){
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
                                             '<span class="delete_post" style="cursor:pointer;" onclick="deletePost(' + item_id + ');">&times;</span>' +
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
                                                    '" onclick="deletePost(' + item_id + ');">&nbsp;&nbsp;&times;</span>' + 
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
                                                                '<span class="delete_post" onclick="deleteComment(' + item_id + ', ' + 
                                                                                comment_id + ');" style="float:right;' + cancelCommentStyle + '">&nbsp;&nbsp;&times;</span>' +
                                                                '<small id="comment_time_' + item_id + '_' + comment_id + '" style="float:right;padding-top:4px;">'+ 
                                                                    posted_at + '</small>' + 
                                                            '</p>' +
                                                        '</div>' +
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
                                                ' onclick="postComment(' + item_id + ', \'comment_box_' + item_id + '\' );" >' +
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

function getMoreFeedHtml(){
    return '<div class="row" id="showMoreFeedDiv">' +
               '<div class="col-sm-8 col-sm-offset-1" style="text-align:center;margin-top:5px;">' +
                   '<div class="col-sm-10">' +
                       '<button type="button" class="btn btn-primary" onclick="showMoreFeed();">' +
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

function getLinkText( text ){
    var pattern = /(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/;
    if( pattern.test( text ) ){
        var res = text.replace(pattern, function replaceFunc(x){return '<a href="' + x + '" target="_blank" >' + x + '</a>' });
        return res;
    } else {
        return text;
    }
}

function postComment( item_id, comment_box_id ){
    var comment = $('#' + comment_box_id ).val();
    if( typeof comment != 'undefined' && comment.trim() == '' ){
        alert( "Please enter a comment!" );
        return;
    }
    var url = '/postComment';
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
        }
    });    
}

function deletePost( item_id ){
    var url = '/deletePost';
    var datastring = 'item_id=' + item_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            var isInit = true;
            var feedHtml = getFeedHtml( responseText, isInit );
            var moreFeedHtml = getMoreFeedHtml();
            feedHtml += moreFeedHtml;
            $('#homeContentDiv').html(feedHtml);
        }
    });
}

function deleteComment( item_id, comment_id ){
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

function showMoreFeed(){
    var url = '/fetchForumItems';
    var datastring = 'to_time=' + $('#last_feed_fetched_time').val();
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
            var feedHtml = getFeedHtml( responseText, isInit );
            var moreFeedHtml = getMoreFeedHtml();
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
                
                var cancelCommentStyle = ' display:none; ';
                if( editable_comment ){
                    cancelCommentStyle = ' display:block; ';
                }
                            
                feedDetailHtml += '<tr>' +
                                      '<td style="padding-top:0px; padding-bottom:0px;padding-right:1px;">' +
                                           '<div class="row" style="margin-right:0px;">' +
                                               '<div class="col-sm-6">' +
                                                   '<p style="width:100%;"><strong id="commentDetail_username_' + item_id + '_' + comment_id + '">'+ 
                                                       user_name + '</strong></p>' +
                                               '</div>' +
                                               '<div class="col-sm-3 col-sm-offset-3 feed_time_comment_div">' +
                                                   '<p style="width:100%;">' + 
                                                       '<span class="delete_post" onclick="deleteComment(' + item_id + ', ' + 
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
                                                ' onclick="postComment(' + item_id + ', \'commentDetailText_' + item_id + '\' );">' +
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
                                               '<div class="row" style="margin-right: 0px">' +
                                                   '<div class="col-sm-6">' +
                                                       '<p style="width:100%;"><strong id="commentDetail_username_' + item_id + '_' + comment_id + '">'+ 
                                                           user_name + '</strong></p>' +
                                                   '</div>' +
                                                   '<div class="col-sm-3 col-sm-offset-3 feed_time_comment_div">' +
                                                        '<p style="width:100%;">' + 
                                                            '<span class="delete_post" onclick="deleteComment(' + item_id + ', ' + 
                                                                            comment_id + ');" style="float:right;' + cancelCommentStyle + '">&nbsp;&nbsp;&times;</span>' +
                                                            '<small id="commentDetail_time_' + item_id + '_' + comment_id + '" style="float:right;padding-top:4px;">'+ 
                                                                posted_at + '</small>' + 
                                                        '</p>' +
                                                   '</div>' +
                                               '</div>' +
                                               '<p id="comment_' + item_id + '_' + comment_id + '">' + 
                                                   getLinkText(comment_text) + '</p>' +
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

function parentHomeWorkOnload(){
    $('#selectPostedTime').val('1');
    populateParentTimeWiseHW();
}

function fetchSubjectHW( class_id, subject_id ){
    var url = '/fetchSubjectHW';
    var datastring = 'class_id=' + class_id + '&subject_id=' + subject_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            console.log( responseText );
            $('#selectPostedTime').val('');
            $('#selectCompleteByTime').val('');
            var subjectName = $('#subject_desc_' + subject_id).html();
            var homeWorkFeedHtml = getHWFeedPreHtml( subjectName ) + getSubjectHWHtml( responseText, subjectName, class_id, subject_id ) + getHWFeedPostHtml();
            //var homeWorkGetMoreFeedHtml = getMoreHWFeedHtml();
            $('#homeWorkContentDiv').html( homeWorkFeedHtml );
        },
        error : function( exception ){
            
        }
    });
}

function getMoreHWHtml( class_id, subject_id ){
    var moreHWFeedHtml = '<div class="row" id="showMoreFeedDiv">' +
                             '<div class="col-sm-12" style="text-align:center;margin-top:5px;">' +
                                 '<button type="button" class="btn btn-primary" ' + 
                                     ' onclick="showMoreSubjectHWFeed(' + class_id + ', ' + subject_id + ');" >' +
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

function showMoreSubjectHWFeed( class_id, subject_id ){
    var last_fetched_hw_id = $('#last_fetched_hw_id').val();
    var url = '/fetchSubjectHW';
    var datastring = 'class_id=' + class_id + '&subject_id=' + subject_id + '&last_hw_id='+last_fetched_hw_id;
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function(responseText) {
            console.log( responseText );
            $('#showMoreFeedDiv').remove();
            var existingSubjectHWHtml = $('#hwScrollableContentDiv').html();
            var subjectHWHtml = getSubjectHWHtml( responseText );
            $('#hwScrollableContentDiv').html( existingSubjectHWHtml + subjectHWHtml );
            $('#hwScrollableContentDiv').prop("scrollTop", $('#hwScrollableContentDiv').prop("scrollTop") + 150 );
        },
        error : function( exception ){
            
        }
    });
}

function getHWFeedPreHtml( subjectName ){
    var hw_pre_feed_html = '<div class="row" id="homeWorkFeedContentDiv" >' +
                                '<h4 id="searchedHWSubject" style="text-align:center;">' + 
                                    '<i>Subject : </i>' +
                                    '<strong>' + subjectName + '</strong></h4>' +
                                '<div class="col-sm-12" id="hwScrollableContentDiv" style="padding-right:0px;height:500px;overflow-y:scroll;">';
                           
    return hw_pre_feed_html;
}

function getSubjectHWHtml( homeWorkJsonObj, subjectName, class_id, subject_id ){
    var hw_feed_html = '';
    hw_feed_html += '<div class="row">' +
                        '<div class="col-sm-offset-2 col-sm-8">';
    if( typeof homeWorkJsonObj == 'object' && ( 'hw_details' in homeWorkJsonObj ) && ( 'last_hw_id_fetched' in homeWorkJsonObj )
            &&  Array.isArray(homeWorkJsonObj['hw_details']) && homeWorkJsonObj['hw_details'].length > 0 ){
        var last_hw_id_fetched = homeWorkJsonObj['last_hw_id_fetched'];
        $('#last_fetched_hw_id').val( last_hw_id_fetched );
        var homeWorkJsonObj = homeWorkJsonObj['hw_details'];
        for( var i=0; i < homeWorkJsonObj.length; i++ ){
            hw_feed_html += '<div class="panel panel-default" id="hw_panel_' + homeWorkJsonObj[i]['homework_id'] + '" >' +
                                '<div class="panel-body hw_panel">' +
                                    '<div class="row">' +
                                        '<div class="col-sm-12 hw_text_div">' +
                                            '<p id="homework_desc_' + homeWorkJsonObj[i]['homework_id'] + '">' + homeWorkJsonObj[i]['homework_desc'] + '</p>' +
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
    }  
    var homeWorkGetMoreFeedHtml = getMoreHWHtml( class_id, subject_id );
    hw_feed_html += homeWorkGetMoreFeedHtml;
        
    hw_feed_html +=     '</div>' +
                      '</div>';
                                      
    return hw_feed_html;
}

function getHWFeedPostHtml(){
    var hw_feed_post_html =     '</div>' +
                            '</div>';
                           
    return hw_feed_post_html;
}

function populateParentTimeWiseHW(){
    var postedDate = $('#selectPostedTime').val().trim();
    var completionDate = $('#selectCompleteByTime').val().trim();
    
    if( postedDate == '' && completionDate == '' ){
        alert("Please select atleast one of Posted Date or Completion Date!");
        return;
    }
    var url = '/fetchHWByTimeParent';
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
            
            if( postedDate != '' && completionDate != '' ){
                searchCriteriaHtml += ' Posted Date : <mark>' + postedDateText + '</mark> AND Completion Date : <mark>' + completionDateText + '</mark></h4>';
            } else if( postedDate != '' ){
                searchCriteriaHtml += ' Posted Date : <mark>' + postedDateText + '</mark></h4>';
            } else if( completionDate != '' ){
                searchCriteriaHtml += ' Completion Date : <mark>' + completionDateText + '</mark></h4>';
            }
            
            var timeBasedHWHtml = getParentTimeBasedHWHtml( responseText );
            $('#homeWorkContentDiv').html( searchCriteriaHtml + timeBasedHWHtml );
            console.log(responseText);
        }
    });
}

function getParentTimeBasedHWHtml( hwDetailObject ){
    var timeBasedHWHtml = '<div class="row">' +
                            '<div class="col-sm-offset-2 col-sm-8">';
    if( Array.isArray(hwDetailObject) && hwDetailObject.length > 0 ){
        for( var i=0; i < hwDetailObject.length; i++ ){
            timeBasedHWHtml += '<div class="panel panel-default" id="hw_panel_' + hwDetailObject[i]['homework_id'] + '" >' +
                               '<div class="panel-heading" style="padding:2px;">' +
                                   '<div class="row">' +
                                       '<div class="col-sm-12">' +
                                           '<h4 class="hw_time_title"><strong>' + 
                                                hwDetailObject[i]['subject_name'] + 
                                            '</strong></h4>' +
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

function parentTTOnLoad(){
    
}

function fetchClassNotifications(){
    var classNotifTable = document.getElementById('classNotifTable');
    while( classNotifTable.rows.length > 1 ){
        classNotifTable.deleteRow(-1);
    }
    var url = '/fetchClassNotifications';
    var datastring = 'class_id=-1';
    $.ajax({
        type : "POST",
        url : url,
        data : datastring,
        dataType: "json",
        success : function( responseText ) {
            var classNotifHtml = getClassNotificationHtml( responseText );
            $('#classNotifTable tr:last').after( classNotifHtml );
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