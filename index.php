<?php
include_once('include/webzone.php');
include_once('include/presentation/header.php');

//data from Facebook
$signed_request = $_POST['signed_request'];
$data = parse_signed_request($signed_request, $GLOBALS['fb_app_secret']);
//set to variables
$fb_page_id = $data['page']['id'];
$liked = $data['page']['liked'];
$admin = $data['page']['admin'];
$country = $data['user']['country'];
$locale = $data['user']['locale'];
$age_min = $data['user']['age']['min'];
$user_id = $data['user_id'];
$token = $data['oauth_token'];
$token_expires = $data['expires'];
$issued_at = $data['issued_at'];

echo '<div class="fb_container">';
	//displayed only on the Facebook page tab
	if($fb_page_id!='') {
		//if the page has been liked by the user
		if($liked || $GLOBALS['page_like_required']==0) {
			include_once('index_after_like.php');
		}
		//the user didn't like the page yet
		else {
			include_once('index_before_like.php');
		}
	}
	//displayed only on the web server (not on the Facebook page)
	else {
		echo '<script>window.location="'.$GLOBALS['fb_page_tab_url'].'";</script>';
	}
echo '</div>';

include_once('include/presentation/footer.php');
?>