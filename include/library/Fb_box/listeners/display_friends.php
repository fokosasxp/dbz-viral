<?php
$token = $_POST['token'];
$url = $_POST['url'];

if($url!='') {
	$f1 = new Fb_ypbox();
	$data = $f1->getDataFromUrl($url);
	$data = json_decode($data, true);
}
else {
	$f1 = new Fb_ypbox();
	$data = $f1->get_fb_api_results(array('object'=>$id, 'connection'=>'friends', 'token'=>$token));	
}

$friends = $data['data'];

if($url=='' && count($friends)>0) {
	echo '<div><h3>'.count($friends).' friends</h3></div>';
}

for($i=0; $i<count($friends); $i++) {
	$id = $friends[$i]['id'];
	$name = $friends[$i]['name'];
	
	$image = 'https://graph.facebook.com/'.$id.'/picture';
	$link = 'https://www.facebook.com/profile.php?id='.$id;
	
	echo '<div style="position:relative; overflow:hidden;">';
	echo '<img src="'.$image.'" style="margin-right:10px; margin-bottom:10px; float:left;">';
	echo '<div><a href="'.$link.'" target="_blank">'.$name.'</a></div>';
	echo '<span style="position:absolute; right:0px; top:15px;">';
	echo '<a href="#" data-id="'.$id.'" class="display_wall_post_btn">Wall post</a>';
	echo '</span>';
	echo '</div>';
	echo '<hr style="margin-top:0px; margin-bottom:5px;">';
}

if($data['paging']['next']!='') {
	echo '<div id="displayMoreFriendsBox"><a href="#" class="loadMoreFriendsBtn btn" data-url="'.$data['paging']['next'].'" class="btn">Load more</a></div>';
}

?>