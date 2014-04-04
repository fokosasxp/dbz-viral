<?php

class Fb_ypbox_display
{
	
	/*
	Display timeline
	*/
	
	function displayTimeline($criteria=array()) {
		$data = $criteria['posts'];
		$user_id = $criteria['user_id'];
		$connected_user_id = $criteria['connected_user_id'];
		
		//print_r($data);
		
		$display = '';
		
		for($i=0; $i<count($data); $i++) {
			$id = $data[$i]['id'];
			$from_id = $data[$i]['from_id'];
			$from_name = $data[$i]['from_name'];
			$type = $data[$i]['type'];
			$message = $data[$i]['message'];
			$picture = $data[$i]['picture'];
			$link = $data[$i]['link'];
			$source = $data[$i]['source'];
			$name = $data[$i]['name'];
			$caption = $data[$i]['caption'];
			$description = $data[$i]['description'];
			$icon = $data[$i]['icon'];
			$created = $data[$i]['created'];
			$attribution = $data[$i]['attribution'];
			$likes = $data[$i]['likes'];
			$likes_nb = $data[$i]['likes_nb'];
			$comments = $data[$i]['comments'];
			$comments_nb = $data[$i]['comments_nb'];
			$action_comment = $data[$i]['action_comment'];
			$picture_url = $data[$i]['picture_url'];
			$profile_url = $data[$i]['profile_url'];
			$post_link = $data[$i]['post_link'];
			
			$likesTab = array();
			
			$display .= '<div class="itemBox" data-post-id="'.$id.'" style="padding:10px; padding-top:20px; padding-bottom:20px;">'; //style="overflow: hidden;"
				
				$display .= '<div style="float:left;"><a href="'.$profile_url.'" title="'.$from_name.'" target="_blank">
				<img src="'.$picture_url.'" style="padding-right:10px; vertical-align:middle;"">
				</a></div>';
				
				$display .= '<div style="margin-left:80px;">';
					
					//username + message
					$display .= '<div><a href="'.$profile_url.'" title="'.$from_name.'" target="_blank">'.$from_name.'</a> ';
					if($message!='') $display .= ''.$message.'';
					$display .= '</div>';
					
					//content
					if($type=='status') {
						
					}
					else if($type=='photo') {
						$display .= '<div style="overflow:hidden; padding-top:15px;">';
						$display .= '<a href="'.$link.'" target="_blank"><img src="'.$picture.'" style="padding-right:10px;" align="left"></a>';
						if($name!='') $display .= '<a href="'.$link.'" target="_blank">'.$name.'</a><br>';
						if($caption!='') $display .= '<small><span>'.$caption.'</a></small>';
						$display .= '</div>';
					}
					else if($type=='link') {
						$display .= '<div style="overflow:hidden; padding-top:15px;">';
						if($picture!='') $display .= '<a href="'.$link.'" target="_blank" title="'.$name.'"><img src="'.$picture.'" style="padding-right:10px;" align="left"></a>';
						$display .= '<a href="'.$link.'" target="_blank" title="'.$caption.'">'.$name.'</a><br>';
						if($caption!='') $display .= '<small>'.$caption.'</a></small><br>';
						if($description!='') $display .= '<small>'.$description.'</a></small>';
						$display .= '</div>';
					}
					else {
						$display .= '<div style="overflow:hidden; padding-top:15px;">';
							
							$display .= '<div id="domImage" class="videoPlayBox" style="float:left;" >';
								$display .= '<a href="'.$link.'" target="_blank" title="'.$name.'">';
									if($picture!='') {
										$display .= '<img src="'.$picture.'" width=80 height=55 style="padding-right:10px;"/>';
										$display .= '<span class="play"></span>';
									}
								$display .= '</a>';
							$display .= '</div>';
						
							if($name!='') $display .= '<a href="'.$link.'" target="_blank">'.$name.'</a><br>';
							if($description!='') $display .= '<small><span>'.$description.'</span></small>';
							
						$display .= '</div>';
					}
					
					//date, comments
					$display .= '<div style="margin-top:15px; margin-bottom:10px;">';
						if($icon!='') $display .= '<img src="'.$icon.'"> ';
						$display .= '<small>';
						$display .= '<a href="'.$post_link.'" target="_blank" class="created" title="'.$created.'">'.$created.'</a>';
						$display .= '</small>';
						//$display .= ' - <small><a class="showCommentBtn" href="#">Comment</a></small>';
						//if($likes_nb>0) $display .= ' - <i class="fb-like">&nbsp;</i>'.$likes_nb.' people like this';
						//print_r($likes);
					$display .= '</div>';
					
					// ################## //
					// START Like Section //
					// ################## //
					if($likes_nb>0) {
						for($k=0; $k<count($likes); $k++) {
							$likesTab[] = $likes[$k]['id'];
						}
						$display .= '<div style="background: #f5f5f5; padding:5px; margin:3px;">';
						if($likes_nb==1) {
							if(in_array($user_id, $likesTab)) {
								$display .= '<i class="fb-like">&nbsp;</i>You like this';
							}
							else {
								$link = 'http://www.facebook.com/profile.php?id='.$likes[0]['id'];
								$display .= '<i class="fb-like">&nbsp;</i><a href="'.$link.'" target="_blank">'.$likes[0]['name'].'</a> likes this';								
							}
						}
						else if($likes_nb==2) {
							if(in_array($user_id, $likesTab)) {
								if($likes[0]['id']==$user_id) $flag=1;
								else $flag=0;
								$link = 'http://www.facebook.com/profile.php?id='.$likes[$flag]['id'];
								$display .= '<i class="fb-like">&nbsp;</i>You and <a href="'.$link.'" target="_blank">'.$likes[$flag]['name'].'</a> like this';
							}
							else {
								$link = 'http://www.facebook.com/profile.php?id='.$likes[0]['id'];
								$link2 = 'http://www.facebook.com/profile.php?id='.$likes[1]['id'];
								$display .= '<i class="fb-like">&nbsp;</i><a href="'.$link.'" target="_blank">'.$likes[0]['name'].'</a> and <a href="'.$link2.'" target="_blank">'.$likes[1]['name'].'</a> like this';
							}
						}
						else {
							if(in_array($user_id, $likesTab)) {
								$display .= '<i class="fb-like">&nbsp;</i>You and '.($likes_nb-1).' others like this';
							}
							else {
								$display .= '<i class="fb-like">&nbsp;</i>'.$likes_nb.' people like this';
							}
						}
						$display .= '</div>';
					}
					
					// ##################### //
					// START Comment Section //
					// ##################### //
					
					if($comments_nb>count($comments)) {
						$display .= '<div style="background: #f5f5f5; padding:5px; margin:3px;" class="moreCommentsBox">';
						if($comments_nb<25) $display .= '<i class="comments"></i> <a href="#" class="loadMoreCommentsBtn" data-url="">View all '.$comments_nb.' comments</a>';
						else $display .= '<i class="comments"></i> <a href="#" class="loadFirstCommentsBtn" data-url="">View first 25 comments</a>';
						$display .= '</div>';
					}
					
					$display .= '<div class="commentsList">';
						$display .= $this->displayComments(array('comments'=>$comments, 'comments_nb'=>$comments_nb, 'post_id'=>$id));
					$display .= '</div>';
					
					$display .= '<div class="added_comments"></div>';
					
					if($connected_user_id!='') {
						$display .= '<form style="background: #f5f5f5; padding:5px; margin:3px;">';
							$display .= '<textarea class="commentArea" placeholder="Write a comment..." style="width:98%; height:20px; color:#736F6E; margin-bottom:5px;" tabindex='.($randomNb+1).'></textarea>';
							$display .= '<div style="text-align:right; display:none;" class="addCommentBox">';
							$display .= '<a href="#" class="hideCommentBtn">Cancel</a> - ';
							$display .= '<input type="submit" class="btn postCommentBtn" tabindex='.($randomNb+1).' value="Post"></div>';
						$display .= '</form>';						
					}
					
					// ################### //
					// END Comment Section //
					// ################### //
					
				$display .= '</div>';
				
			$display .= '</div><hr style="margin:0px; margin-bottom:10px;">';
			
		}
		
		echo $display;
		
		//return $display;
	}
	
	function formatFacebookPosts($data) {
		
		for($i=0; $i<count($data['data']); $i++) {
			$id = $data['data'][$i]['id'];
			$from_id = $data['data'][$i]['from']['id'];
			$from_name = $data['data'][$i]['from']['name'];
			
			$type = $data['data'][$i]['type']; //video, link, status, picture, swf
			if($data['data'][$i]['message']!='') $message = $data['data'][$i]['message'];
			else $message = $data['data'][$i]['story'];
			$picture = $data['data'][$i]['picture'];
			$link = $data['data'][$i]['link'];
			$source = $data['data'][$i]['source']; //for videos
			$name = $data['data'][$i]['name']; //for videos or links
			$caption = $data['data'][$i]['caption']; //for videos (domain name url) or links
			$description = $data['data'][$i]['description']; //for videos
			$icon = $data['data'][$i]['icon'];
			$created = $data['data'][$i]['created_time'];
			$likes = $data['data'][$i]['likes']['data'];
			$likes_nb = $data['data'][$i]['likes']['count'];
			
			$comments = $data['data'][$i]['comments']['data']; //(message, created_time)
			$comments_nb = $data['data'][$i]['comments']['count'];
			$action_comment = $data['data'][$i]['actions'][0]['link'];
			
			$picture_url = 'https://graph.facebook.com/'.$from_id.'/picture';
			$profile_url = 'http://www.facebook.com/profile.php?id='.$from_id;
			
			$postIdsTab = explode('_', $id);
			$post_link = 'http://www.facebook.com/'.$postIdsTab[0].'/posts/'.$postIdsTab[1];
			
			$created = substr($created, 0, 10).'T'.substr($created, 11, 8).'Z';
			
			$attribution = $data['data'][$i]['attribution'];
			
			$dataList[$i]['id'] = $id;
			$dataList[$i]['from_id'] = $from_id;
			$dataList[$i]['from_name'] = $from_name;
			$dataList[$i]['type'] = $type;
			$dataList[$i]['message'] = $message;
			$dataList[$i]['picture'] = $picture;
			$dataList[$i]['link'] = $link;
			$dataList[$i]['source'] = $source;
			$dataList[$i]['name'] = $name;
			$dataList[$i]['caption'] = $caption;
			$dataList[$i]['description'] = $description;
			$dataList[$i]['icon'] = $icon;
			$dataList[$i]['created'] = $created;
			$dataList[$i]['attribution'] = $attribution;
			$dataList[$i]['likes'] = $likes;
			$dataList[$i]['likes_nb'] = $likes_nb;
			$dataList[$i]['comments'] = $comments;
			$dataList[$i]['comments_nb'] = $comments_nb;
			$dataList[$i]['action_comment'] = $action_comment;
			$dataList[$i]['picture_url'] = $picture_url;
			$dataList[$i]['profile_url'] = $profile_url;
			$dataList[$i]['post_link'] = $post_link;
		}
		
		//print_r($dataList);
		
		return $dataList;
	}
	
	/*
	Comments display
	*/
	
	function displayComments($criteria) {
		$comments_nb = $criteria['comments_nb'];
		$comments = $criteria['comments'];
		$post_id = $criteria['post_id'];
		
		$display = '';
		
		if(count($comments)>0) {
			foreach($comments as $value) {
				$commentid = $value['id'];
				$userid = $value['from']['id'];
				$name = $value['from']['name'];
				$comment = $value['message'];
				$created = $value['created_time'];
				
				$created = substr($created, 0, 10).'T'.substr($created, 11, 8).'Z';
				
				$criteria2['userid'] = $userid;
				$criteria2['name'] = $name;
				$criteria2['commentid'] = $commentid;
				$criteria2['comment'] = $comment;
				$criteria2['created'] = $created;
				$display .= $this->displaySingleComment($criteria2);
			}
		}
		
		return $display;
	}
	
	function displaySingleComment($criteria) {
		$userid = $criteria['userid'];
		$name = $criteria['name'];
		$commentid = $criteria['commentid'];
		$comment = $criteria['comment'];
		$created = $criteria['created'];
		
		$picture = 'http://graph.facebook.com/'.$userid.'/picture';
		$link = 'http://www.facebook.com/profile.php?id='.$userid;
		
		$display = '';
		
		$display .= '<div style="background: #f5f5f5; padding:5px; margin:3px;">';
		
			$display .= '<div style="float:left; margin-right:10px;"><a href="'.$link.'" target="_blank"><img src="'.$picture.'" alt="'.$name.'" title="'.$name.'" width=36 style="vertical-align:middle;"></a></div>';
			
			$display .= '<div style="padding:3px" width=100%>';
				if($link=='') $display .= $name;
				else $display .= '<a href="'.$link.'" target="_blank">'.$name.'</a>';
				$display .= '&nbsp;'.$comment;
				$display .= '<br><small><span class="created" title="'.$created.'" style="color:#736F6E">'.$created.'</span></small>';
			$display .= '</div>';
			
		$display .= '</div>';
		
		return $display;
	}
	
	function displayAddComment($criteria) {
		$domAddComment = 'domAddComment';
		$domAddCommentPicture = 'domAddCommentPicture';
		$domAddCommentSubmit = 'domAddCommentSubmit';
		
		$randomNb = rand(9999,9999999);
		$picture = 'https://graph.facebook.com/me/picture?access_token='.$this->facebook_access_token;
		$name = '';
		
		$display = '';
		
		$display .= '<form>';
		$display .= '<input type="hidden" id="addCommentHideOnAction" value="'.$hideOnAction.'">';
		
		$display .= '<table width=100% border=0 cellpadding=0 cellspacing=0><tr>';
		$display .= '<td id="'.$domAddCommentPicture.'" valign="top" style="display:none">';
		if($picture!='') $display .= '<img src="'.$picture.'" alt="'.$name.'" title="'.$name.'" width="36">';
		$display .= '</td>';
		$display .= '<td align="right">';
		
		$display .= '<textarea id="'.$domAddComment.'" name="'.$domAddComment.'" tabindex='.$randomNb.'
		style="width:99%; height:20px; padding-top:3px; padding-left:3px; color:#736F6E;">Write a comment...</textarea>'; //style="width:88%"
		
		$display .= '</td>';
		$display .= '</tr></table>';
		
		$display .= '<table width="100%" border=0 cellspacing=0 cellpadding=0 >';
		$display .= '<tr><td align="right" id="'.$domAddCommentSubmit.'" style="display:none;padding-top:5px;" >';
		
		$display .= '<a id="addCommentCancel" href="#" >Cancel</a> - ';
		
		$display .= '<input id="domAddCommentSubmitBtn" type="submit" tabindex='.($randomNb+1).' value="submit">';
		
		$display .= '</td></tr></table>';
		
		$display .= '</form>';
		
		return $display;
	}
}

?>