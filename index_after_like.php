<?php
/*
Main app content
*/
?>

<?php
$jsOnReady = "";
?>

<?php

$f1 = new Fb_ypbox();
$user_data = $f1->getUserData();

//Connected
if($token!='' && (count($user_data)==0 || $user_data['id']=='')) {    
	$long_lived = $f1->getLongLivedToken(array('token'=>$token));
	$token = $long_lived['token'];
	$token_expires = $long_lived['expires'];
	
 	$f1 = new Fb_ypbox();
 	$user_data = $f1->getUserDataFromApi(array('token'=>$token));
 	$user_data['token'] = $token;
 	$user_data['token_expires'] = $token_expires;
 	
 	$_SESSION['ygp_fb_box']['user'] = $user_data;
 	
 	//Store users info in database
 	store_user_data();
}

if(count($user_data)>0) {
	$users = get_users(array('fb_user_id'=>$user_data['id']));
	if(count($users)>0) {
		if($users[0]['fb_token_expires']!=0 && time()>$users[0]['fb_token_expires']) {
			$force_connect=1;
		}
	}
	else {
		$force_connect=1;
	}
}

echo '<div id="locked_content">';

	if(count($user_data)==0 || $force_connect==1) {
		echo '<br><br>';
		echo '<center>';
		echo '<h1>Click on the link bellow to unlock your content</h1>';
		echo 'You will also be able to check and try out the backend !<br><br>';
		echo '<img src="include/graph/icons/facebook32.png" style="vertical-align:middle; margin-right:10px; padding-bottom:8px;">';
		if($force_connect==1) echo '<a href="./account/fb_connect2.php" style="font-size:20px;" target="_top">Facebook connect</a>';
		else echo '<a href="./account/fb_connect.php" style="font-size:20px;" target="_top">Facebook connect</a>';
		echo '</center>';
	}
	else {
		//function situated in "include/functions/display_functions.php"
		displayLockedContent();
	}

echo '</div>';

?>

<script>	
$(document).ready(function() {
	<?php
	echo $jsOnReady;
	?>
})
</script>