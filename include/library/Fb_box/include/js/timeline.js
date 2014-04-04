/*! 
Author: Yougapi Technology | http://yougapi.com/license/
License: A valid license is required to use this script or "Yougapi" written permission
This script is protected by International laws on copyright
*/

$('.display_wall_post_btn').live('click', function(event) {
	event.preventDefault();
	var id = $(this).attr('data-id');
	var obj = {"to":id, "link":"", "name":"", "picture":""};
	postToUserFeed(obj);
});

function postToUserFeed(obj) {
	var param = {};
	param.method = 'feed';
	if(obj.to!=undefined && obj.to!='') param.to = obj.to;
	if(obj.link!=undefined && obj.link!='') param.link = obj.link;
	if(obj.picture!=undefined && obj.picture!='') param.picture = obj.picture;
	if(obj.name!=undefined && obj.name!='') param.name = obj.name;
	if(obj.description!=undefined && obj.description!='') param.description = obj.description;
	
	function callback(response) {
	  	//document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
	}
	
	FB.ui(param, callback);
}

$('#update_status_btn').live('click', function(event) {
	event.preventDefault();
	FB.ui({
		method: 'feed',
	});
});

/*
Friends display
*/
$('.displayFriendsBtn').live('click', function(event) {
	event.preventDefault();
	$('#loading').addClass('loading').html('&nbsp;');
	var url = $(this).attr('data-url');
	$.ajax({
	  type: 'POST',
	  url: Fb_ypbox.ajaxurl + '/index.php?q=displayFriends',
	  data: 'id=' + Fb_ypbox.user_id + '&url=' + escape(url) + '&token=' + Fb_ypbox.token,
	  success: function(msg){
	  	//$('#displayMoreFriendsBox').remove();
	  	$('#loading').removeClass('loading').html('');
	  	if(url=='') $('#timeline').html(msg);
	  	else $('#timeline').prepend(msg);
	  }
	});
});

$('.loadMoreFriendsBtn').live('click', function(event) {
	event.preventDefault();
	var url = $(this).attr('data-url');
	$.ajax({
	  type: 'POST',
	  url: Fb_ypbox.ajaxurl + '/index.php?q=displayFriends',
	  data: 'id=' + Fb_ypbox.user_id + '&url=' + escape(url) + '&token=' + Fb_ypbox.token,
	  success: function(msg){
	  	if(msg=='') $('#displayMoreFriendsBox').remove();
	  	else $('#timeline').prepend(msg);
	  }
	});
});

/*
Display timeline
*/
function displayTimeline(obj) {
	var feed = obj.feed;
	var user_id = obj.user_id;
	var token = obj.token;
	
	if(feed===undefined || feed=='') feed='home';
	if(user_id===undefined || user_id=='') user_id=Fb_ypbox.user_id;
	if(token===undefined || token=='') token=Fb_ypbox.token;
	
	$('#loading').addClass('loading').html('&nbsp;');
	$.ajax({
	  type: 'POST',
	  url: Fb_ypbox.ajaxurl + '/index.php?q=displayTimeline',
	  data: 'id=' + user_id + '&token=' + token + '&feed=' + feed + '&connected_user_id=' + Fb_ypbox.user_id,
	  success: function(msg){
	  	$('#loading').removeClass('loading').html('');
	  	$('#timeline').html(msg);
	  	$('.created').prettyDate();
	  }
	});
}

$('.loadTimeline').live('click', function(event) {
	event.preventDefault();
	var feed = $(this).attr('data-feed');
	var user_id = $(this).attr('data-user-id');
	displayTimeline({"feed":feed, "user_id":user_id});
	$('.created').prettyDate();
});

$('#loadMorePosts').live('click', function(event) {
	event.preventDefault();
	var url = $(this).attr('data-url');
	$('#loadMorePosts').html('Loading...');
	$.ajax({
	  type: 'POST',
	  url: Fb_ypbox.ajaxurl + '/index.php?q=displayTimeline',
	  data: 'url=' + escape(url),
	  success: function(msg){
	  	$('#loadMorePosts').remove();
	  	$('#timeline').append(msg);
	  	$('.created').prettyDate();
	  }
	});
});

/*
Comments
*/
$('.postCommentBtn').live('click', function(event) {
	event.preventDefault();
	var itemBox = $(this).closest('.itemBox');
	var post_id = itemBox.attr('data-post-id');
	var comment = $('.commentArea', itemBox).val();
	$('.commentArea', itemBox).attr('disabled', 'disabled');
	$(this).attr('disabled', 'disabled');
	$.ajax({
	  type: 'POST',
	  url: Fb_ypbox.ajaxurl + '/index.php?q=addComment',
	  data: 'post_id=' + post_id + '&comment=' + comment + '&user_id=' + Fb_ypbox.user_id + '&name=' + Fb_ypbox.name + '&token=' + Fb_ypbox.token,
	  success: function(msg){
	  	$('.commentArea', itemBox).val('').removeAttr('disabled');
	  	$('.postCommentBtn').removeAttr('disabled');
	  	$('.added_comments', itemBox).append(msg);
	  	$('.created').prettyDate();
	  }
	});
});

$('.commentArea').live('focus', function(event) {
	event.preventDefault();
	var itemBox = $(this).closest('.itemBox');
	$('.addCommentBox', itemBox).css('display', 'block');
});

$('.loadMoreCommentsBtn').live('click', function(event) {
	event.preventDefault();
	var itemBox = $(this).closest('.itemBox');
	var post_id = itemBox.attr('data-post-id');
	var url = $(this).attr('data-url');
	$(this).html('Loading...');
	$.ajax({
	  type: 'POST',
	  url: Fb_ypbox.ajaxurl + '/index.php?q=displayComments',
	  data: 'post_id=' + post_id + '&url=' + escape(url) + '&token=' + Fb_ypbox.token,
	  success: function(msg){
	  	$('.moreCommentsBox', itemBox).remove();
	  	if(url=='') $('.commentsList', itemBox).html(msg);
	  	else $('.commentsList', itemBox).append(msg);
	  }
	});
});

$('.hideCommentBtn').live('click', function(event) {
	event.preventDefault();
	var itemBox = $(this).closest('.itemBox');
	$('.addCommentBox', itemBox).css('display', 'none');
});
