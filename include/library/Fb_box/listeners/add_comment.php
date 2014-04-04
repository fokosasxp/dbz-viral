<?php
$post_id = $_POST['post_id'];
$comment = $_POST['comment'];
$user_id = $_POST['user_id'];
$name = $_POST['name'];
$token = $_POST['token'];

$created = date('Y-m-d').'T'.date('H:i:s').'Z';

//$pos = strpos($post_id, '_');
//$post_id = substr($post_id, ($pos+1));

$f1 = new Fb_ypbox();
$postParms = 'access_token='.$token.'&message='.$comment;
$url = 'https://graph.facebook.com/'.$post_id.'/comments';

$results = $f1->postDataToURL($url, $postParms);
$results = json_decode($results, true);

if($results['id']!='') {
	$d1 = new Fb_ypbox_display();
	$criteria2['userid'] = $user_id;
	$criteria2['name'] = $name;
	$criteria2['comment'] = $comment;
	$criteria2['created'] = $created;
	$display = $d1->displaySingleComment($criteria2);
	echo $display;
}
else {
	echo '<div>The Facebook API didn\'t allow adding this comment to this post</div>';
}

?>