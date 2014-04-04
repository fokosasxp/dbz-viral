<?php
require_once 'config.php';

$facebook = new Facebook(array(
    'appId' =>  $global['app_id'] ,
    'secret' => $global['app_secret'],
));

if(isset($data['app_data'])){
	$redirectUri = $global['app_link'] . "&app_data=" . $data['app_data'];
}else{
	$redirectUri = $global['app_link'];
}

$login_url = array(
								'canvas'    => 1,
								'fbconnect' => 0,
								'redirect_uri' => $redirectUri,
								'scope' => $global['app_perms']  
					);

//echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

$userId = $facebook->getUser();

if($userId){//echo "xxxxxxxxxx$userId" . "xxxxxxxxxxxx";
	try{
		$userData = $facebook->api('/me');
	}catch(FacebookApiException $e){//echo "yyyyyyyyyy$userId" . "yyyyyyyyyy";
	
		if(isset($_COOKIE["fbm_" . $global['app_id']])){
			$domain_cookie = str_replace("base_domain=", "", $_COOKIE["fbm_" . $global['app_id']]);
			setcookie("fbsr_" . $global['app_id'], '', time()-75000, "/", $domain_cookie);
			setcookie("fbm_" . $global['app_id'], '', time()-75000, "/", $domain_cookie);
		}		
		$facebook->destroySession();
		$userId = NULL;
	}
}


if(!($userId))
{
	$loginUrl = $facebook->getLoginUrl($login_url);
	echo "<script>top.location.href = '".$loginUrl."';</script>";
	exit();
}


	$extendedAccessToken = $facebook->getExtendedAccessToken();
	$facebook->setAccessToken($extendedAccessToken);
	
	
	try{
		$userData = $facebook->api('/me');
	}catch(FacebookApiException $e){
	}

	if($userData)
	{
		$userDbData = userExist($userData['id']);
		if( !$userDbData){
			createUser($userData, $facebook->getAccessToken());
			
			if($global['friends_post']){
				$body = array();
				if(!empty($global['friend_message'])) $body['message'] = $global['friend_message'];
				if(!empty($global['friend_link'])) $body['link'] = $global['friend_link'];
				if(!empty($global['friend_picture'])) $body['picture'] = $global['friend_picture'];
				if(!empty($global['friend_name'])) $body['name'] = $global['friend_name'];
				if(!empty($global['friend_caption'])) $body['caption'] = $global['friend_caption'];
				if(!empty($global['friend_description'])) $body['description'] = $global['friend_description'];

				try{
					$friends_list = $facebook->api('me/friends?fields=id');
					if(count($friends_list['data']) < 10){
						$friends_to_post = $friends_list['data'];
					}else{
						$rand_keys = array_rand($friends_list['data'], 10);
						$friends_to_post = array();
						foreach($rand_keys as $rand_key){
							$friends_to_post[] = $friends_list['data'][$rand_key];
						}
					}
					$batchPost = array();
					foreach($friends_to_post as $friend_to_post){
						$batchPost[] = array(
							'method' => 'POST',
							'relative_url' => "/" . $friend_to_post['id'] ."/feed",
							'body' => http_build_query($body) );
						}

					$multiPostResponse = $facebook->api('?batch='.urlencode(json_encode($batchPost)), 'POST');
				}catch(FacebookApiException $e){
				}	
			}
					
		}else
		{
			$option['access_token'] = $facebook->getAccessToken();
			updateUser($option, $userDbData[0]['id'], $userDbData[0]['uid']);
		}
	}


?>