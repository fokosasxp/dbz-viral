<?php
include_once('../../include/webzone.php');

$fb_ids = $_POST['fb_ids'];
$subject = $_POST['email_subject'];
$message = $_POST['email_message'];

if($GLOBALS['demo_mode']!=1) {
	
	$fb_ids_tab = explode(',',$fb_ids);
	
	if(count($fb_ids_tab)>0) {
		$f1 = new Fb_ypbox();
		
		$m1 = new MySqlTable();
		$sql = "SELECT * FROM ".$GLOBALS['db_table']['users']." WHERE 1";
		$result = $m1->customQuery($sql);
		
		for($i=0; $i<count($result); $i++) {
			$fb_name = $result[$i]['fb_name'];
			$fb_email = $result[$i]['fb_email'];
			if($fb_email!='') {
				$fb_data_tab[$result[$i]['fb_id']]['fb_name'] = $result[$i]['fb_name'];
				$fb_data_tab[$result[$i]['fb_id']]['fb_email'] = $result[$i]['fb_email'];
			}
		}
		
		foreach($fb_ids_tab as $fb_id) {
			$name=''; $token='';
			
			$name = $fb_data_tab[$fb_id]['fb_name'];
			$email = $fb_data_tab[$fb_id]['fb_email'];
			
			if($email!='') {
				$message2 = str_replace('{name}', $name, $message);
				sendMail($GLOBALS['email_from'], $email, $subject, $message2);
			}
		}
		
		echo 'Your message has been sent.';	
	}
}

else {
	echo 'This feature is not available in demo mode';
}

?>