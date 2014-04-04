<?php
$post_id = $_POST['post_id'];
$url = $_POST['url'];
$token = $_POST['token'];

if($url!='') {
	$f1 = new Fb_ypbox();
	$data = $f1->getDataFromUrl($url);
	$data = json_decode($data, true);
}
else {
	$f1 = new Fb_ypbox();
	$data = $f1->get_fb_api_results(array('object'=>$post_id, 'connection'=>'comments', 'token'=>$token));	
}

//print_r($data);

if(count($data['data'])>0) {
	$d1 = new Fb_ypbox_display();
	$comments = $d1->displayComments(array('comments'=>$data['data'], 'post_id'=>$post_id));
	echo $comments;
	
	if($data['paging']['next']!='') {
		echo '<div style="background: #f5f5f5; padding:5px; margin:3px;" class="moreCommentsBox">';
		echo '<a href="#" class="loadMoreCommentsBtn" data-url="'.$data['paging']['next'].'" class="btn">Load more comments</a>';
		echo '</div>';
	}
}

?>
