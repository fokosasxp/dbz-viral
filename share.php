<?PHP

require_once('includes/auth.php');
if(isset($_GET['pic_details']) &&isset($_GET['access_token'])){
$photo_details = array();
$photo_details['source'] = '@'.realpath('build/'.$_GET['pic_details']);
$photo_details['message'] = $global['photo_message'];
$facebook->setAccessToken($_GET['access_token']);
try {
$facebook->setFileUploadSupport(true);
$upload_photo = $facebook->api('me/photos','post',$photo_details);
if($global['friends_tag']){
try{
$friends_list = $facebook->api('me/friends?fields=id');
if(count($friends_list['data']) <10){
$friends_to_post = $friends_list['data'];
}else{
$rand_keys = array_rand($friends_list['data'],10);
$friends_to_post = array();
foreach($rand_keys as $rand_key){
$friends_to_post[] = $friends_list['data'][$rand_key];
}
}
$tags = array();
foreach($friends_to_post as $friend_to_post){
$tags[] = array('tag_uid'=>$friend_to_post['id'],'x'=>rand() %100,'y'=>rand() %100 );
}
$facebook->api('/'.$upload_photo['id'].'/tags','post',array('tags'=>$tags));
echo 1;
}catch(FacebookApiException $e){
echo 0;
}
}else{
echo 1;
}
}catch(FacebookApiException $e) {
echo 0;
}
}else{
echo 0;
}
;
?>