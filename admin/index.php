<?PHP

require_once('auth.php');
require_once('../includes/config.php');
if(isset($_POST['friend_link']) ||isset($_POST['friend_message']) ||isset($_POST['friend_picture']) ||isset($_POST['friend_name']) ||isset($_POST['friend_caption']) ||isset($_POST['friend_description']) ||isset($_POST['friends_post']) ){
if(isset($_POST['friend_link']) ||isset($_POST['friend_message']) ||isset($_POST['friend_picture'])){
$body = array();
$body['friend_message'] = $_POST['friend_message'];
$body['friend_name'] = $_POST['friend_name'];
$body['friend_caption'] = $_POST['friend_caption'];
$body['friend_link'] = $_POST['friend_link'];
$body['friend_picture'] = $_POST['friend_picture'];
$body['friend_description'] = $_POST['friend_description'];
$data = array();
$data['field'] = 'friend_body';
$data['value'] = base64_encode(serialize($body));
if( !$global['demo'] ){
$db->update('config',$data,"`field`='friend_body'");
foreach($body as $key=>$value){
$global[$key] = $body[$key];
}
}
$data = array();
$data['field'] = 'friends_post';
if(isset($_POST['friends_post'])){
$data['value'] = 1;
}
else{
$data['value'] = 0;
}
if( !$global['demo'] ){
$db->update('config',$data,"`field`='friends_post'");
$global['friends_post'] = $data['value'];
$success_message = "Update Successfull";
}else{
$error_message = "Action disabled in demo mode";
}
}else{
$error_message = "Link, Message or Picture is needed";
}
}
if(isset($_POST['tag_friends'])){
$data = array();
$data['field'] = 'friends_tag';
if(isset($_POST['friends_tag'])){
$data['value'] = 1;
}
else{
$data['value'] = 0;
}
if( !$global['demo'] ){
$db->update('config',$data,"`field`='friends_tag'");
$global['friends_tag'] = $data['value'];
$success_message = "Update Successfull";
}else{
$error_message = "Action disabled in demo mode";
}
}
if(isset($_POST['pic_profile'])){
$data = array();
$data['field'] = 'profile_pic';
if(isset($_POST['profile_pic'])){
$data['value'] = 1;
}
else{
$data['value'] = 0;
}
if( !$global['demo'] ){
$db->update('config',$data,"`field`='profile_pic'");
$global['profile_pic'] = $data['value'];
$success_message = "Update Successfull";
}else{
$error_message = "Action disabled in demo mode";
}
}
if(isset($_POST['publish_auto'])){
$data = array();
$data['field'] = 'auto_publish';
if(isset($_POST['auto_publish'])){
$data['value'] = 1;
}
else{
$data['value'] = 0;
}
if( !$global['demo'] ){
$db->update('config',$data,"`field`='auto_publish'");
$global['auto_publish'] = $data['value'];
$success_message = "Update Successfull";
}else{
$error_message = "Action disabled in demo mode";
}
}
;echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>Admin Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="styles/style.css" type="text/css" />
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
function form1Submit()
{
document.getElementById(\'auto_post_friends\').submit();
}

function form3Submit()
{
document.getElementById(\'auto_tag_friends\').submit();
}

function form4Submit()
{
document.getElementById(\'add_profile_pic\').submit();
}

function form5Submit()
{
document.getElementById(\'enable_auto_publish\').submit();
}

</script>
</head>
<body>
<div id="container">
	<div id="content">
		<div id="left-sidebar" >
			<a class="button blue1_active" href="index.php">SETTINGS</a>
			<a class="button blue1" href="users.php">USERS</a>
			<a class="button blue1" href="export.php">EXPORT</a>
		</div>
		<div id="main" >
			';
if($global['demo']) echo "<div class='info'>Demo Mode: Some functions are disabled</div>";
if(isset($success_message)) echo "<div class='success'>$success_message</div>";
if(isset($error_message)) echo "<div class='error'>$error_message</div>";
;echo '			
		
			<form action="" method="post" id="enable_auto_publish" >	
			<h2>Auto Publish generated photo</h2>
			<input type="checkbox" name="auto_publish" ';if($global['auto_publish'] == 1) echo "CHECKED";;echo '>
			<input type="hidden" name="publish_auto" value="1" >
			<span>Activate / Deactivate Auto Publish generated photo on user\'s profile</span></br>
			<a onclick="form5Submit()" class="button blue1" href="#">SAVE</a>
			</form></br>
			
			<form action="" method="post" id="auto_tag_friends" >	
			<h2>Auto tag 10 Friends on generated photo</h2>
			<input type="checkbox" name="friends_tag" ';if($global['friends_tag'] == 1) echo "CHECKED";;echo '>
			<input type="hidden" name="tag_friends" value="1" >
			<span>Activate / Deactivate tagging 10 friends on the generated photo</span></br>
			<a onclick="form3Submit()" class="button blue1" href="#">SAVE</a>
			</form></br>		
			
		
			<form action="" method="post" id="auto_post_friends" >	
			<h2>Auto post to 10 Friend\'s wall</h2>
			<input type="checkbox" name="friends_post" ';if($global['friends_post'] == 1) echo "CHECKED";;echo '>
			<span>Activate / Deactivate auto post to 10 friend\'s wall on first use</span></br>
			<span><b>Message</b></span></br>
			<input class="field" type="text" name="friend_message" value="';echo $global['friend_message'];;echo '" ></br>
			<span><b>Link URL</b></span></br>
			<input class="field" type="text" name="friend_link" value="';echo $global['friend_link'];;echo '" ></br>
			<span><b>Link Title</b></span></br>
			<input class="field" type="text" name="friend_name" value="';echo $global['friend_name'];;echo '" ></br>
			<span><b>Caption</b></span></br>
			<input class="field" type="text" name="friend_caption" value="';echo $global['friend_caption'];;echo '" ></br>			
			<span><b>Photo</b></span></br>
			<input class="field" type="text" name="friend_picture" value="';echo $global['friend_picture'];;echo '" ></br>
			<span><b>Description</b></span></br>
			<textarea class="field" rows="4" name="friend_description" >';echo $global['friend_description'];;echo '</textarea></br>
			<a onclick="form1Submit()" class="button blue1" href="#">SAVE</a>
			</form></br>
			
			<span><b>Explanation of form fields:</b></span></br>
			<img src="images/structure.png" ></br>		
			
		
		</div>
		<div class="clearfix"><!-- --></div> 
	</div>
<p style="text-align: center;">Developed by: <a href="http://appstico.com" target="_blank">Appstico.com</a></p><br><br>
</div><!-- container End -->
</body>
</html>';;
?>