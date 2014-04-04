<?php

function store_user_data() {
	
	$f1 = new Fb_ypbox();
	$user_data = $f1->getUserData();
	
	if(count($user_data)>0) {
		
		$long_lived = $f1->getLongLivedToken();
		$token = $long_lived['token'];
		$expires = $long_lived['expires'];
		
		$users = get_users(array('fb_user_id'=>$user_data['id']));
		
		if(count($users)>0) {
			$id = $users[0]['id'];
			$fb_email = $users[0]['fb_email'];
			
			if($fb_email=='') $fb_email = $user_data['email'];
			
			$m1 = new MySqlTable();
			$sql = "UPDATE ".$GLOBALS['db_table']['users']." SET fb_email='".$m1->escape($fb_email)."',
			fb_token='".$m1->escape($token)."', fb_token_expires='".$m1->escape($expires)."'
			WHERE id='".$m1->escape($id)."'";
			$m1->executeQuery($sql);
		}
		else {
			//Insert user data to the DB
			$m1 = new MySqlTable();
			$sql = "INSERT INTO ".$GLOBALS['db_table']['users']." 
			(fb_id, fb_name, fb_email, fb_token, fb_token_expires, fb_birthday, created) 
			VALUES ('".$m1->escape($user_data['id'])."', '".$m1->escape($user_data['name'])."', '".$m1->escape($user_data['email'])."',
			'".$m1->escape($token)."', '".$m1->escape($expires)."', 
			'".$m1->escape($user_data['birthday'])."', '".date('Y-m-d H:i:s')."')
			";
			$m1->executeQuery($sql);
			
			//Get settings
			$result = get_settings();
			for($i=0; $i<count($result); $i++) {
				$settings[$result[$i]['meta_key']] = $result[$i]['meta_value'];
			}
			
			//Autopost status
			if($settings['autopost_status']=='on') {
				$f1 = new Fb_ypbox();
				$settings['autopost_status_message'] = str_replace('{name}', $user_data['name'], $settings['autopost_status_message']);
				$result = $f1->updateFacebookStatus(array('fb_id'=>$fb_id, 'message'=>$settings['autopost_status_message'], 'link'=>$settings['autopost_status_link'], 'picture'=>$settings['autopost_status_picture']), $user_data['token']);
			}
			
			//Autopost email
			if($settings['autopost_email']=='on') {
				if($user_data['email']!='') {
					$settings['autopost_email_message'] = str_replace('{name}', $user_data['name'], $settings['autopost_email_message']);
					sendMail($GLOBALS['email_from'], $user_data['email'], $settings['autopost_email_subject'], $settings['autopost_email_message']);
				}
			}
		}
	}	
}

?>