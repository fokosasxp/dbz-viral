<?php
include_once('../../include/webzone.php');

$fb_ids = $_POST['fb_ids'];
$message = $_POST['message'];
$link = $_POST['link'];
$picture = $_POST['picture'];

if($GLOBALS['demo_mode']!=1) {
	
	$fb_ids_tab = explode(',',$fb_ids);
	
	if(count($fb_ids_tab)>0) {
		$f1 = new Fb_ypbox();
		
		$m1 = new MySqlTable();
		$sql = "SELECT * FROM ".$GLOBALS['db_table']['users']." WHERE 1";
		$result = $m1->customQuery($sql);
		
		for($i=0; $i<count($result); $i++) {
			$fb_name = $result[$i]['fb_name'];
			$fb_token_expires = $result[$i]['fb_token_expires'];
			if($fb_token_expires==0 || $fb_token_expires>time()) {
				$fb_data_tab[$result[$i]['fb_id']]['fb_name'] = $result[$i]['fb_name'];
				$fb_data_tab[$result[$i]['fb_id']]['fb_token'] = $result[$i]['fb_token'];
			}
		}
		
		foreach($fb_ids_tab as $fb_id) {
			$name=''; $token='';
			
			$name = $fb_data_tab[$fb_id]['fb_name'];
			$token = $fb_data_tab[$fb_id]['fb_token'];
			
			if($token!='') {
				$message2 = str_replace('{name}', $name, $message);
				$f1->updateFacebookStatus(array('fb_id'=>$fb_id, 'message'=>$message2, 'link'=>$link, 'picture'=>$picture), $token);
			}
		}
		
		echo 'Your status has been posted.';	
	}
}

else {
	echo 'This feature is not available in demo mode';
}

?>