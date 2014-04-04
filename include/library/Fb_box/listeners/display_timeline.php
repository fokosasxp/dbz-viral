<?php
$id = $_POST['id'];
$feed = $_POST['feed'];
$token = $_POST['token'];
$url = $_POST['url'];
$connected_user_id = $_POST['connected_user_id']; //tell if a user is connected or no

if($url!='') {
	$f1 = new Fb_ypbox();
	$data = $f1->getDataFromUrl($url);
	$data = json_decode($data, true);
}
else {
	$f1 = new Fb_ypbox();
	$data = $f1->get_fb_api_results(array('object'=>$id, 'connection'=>$feed, 'token'=>$token));	
}

//print_r($data);
$d1 = new Fb_ypbox_display();
$posts = $d1->formatFacebookPosts($data);
$d1->displayTimeline(array('posts'=>$posts, 'user_id'=>$id, 'connected_user_id'=>$connected_user_id));

if($data['paging']['next']!='') {
	echo '<a href="#" id="loadMorePosts" data-url="'.$data['paging']['next'].'" class="btn">Load more</a>';
}

?>
