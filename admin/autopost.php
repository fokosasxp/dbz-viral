<?php
include_once('../include/webzone.php');

$current_page = 'autopost';

include_once('./include/presentation/header.php');
?>

<div class="container">	
	
	<div class="blueTable" style="padding:5px;">
		<div>Here you can define the information that get <b>automatically</b> posted on Facebook (users wall) or sent by email, when users connect for the first time.</div>
		<div><b>Tip:</b> You can use <font color="green"><i>{name}</i></font> in the message, and it will be replaced by each user's name when posted (or sent by email).</div>
	</div>
	<br>
	
	<?php
	
	$result = get_settings();
	for($i=0; $i<count($result); $i++) {
		$settings[$result[$i]['meta_key']] = $result[$i]['meta_value'];
	}
	
	//print_r($settings);
	
	$autopost_status = $settings['autopost_status'];
	if($autopost_status=='on') {
		$checked_autopost_status='checked';
	}
	else {
		$autopost_status_box_css = 'display:none;';
	}
	
	$autopost_email = $settings['autopost_email'];
	if($autopost_email=='on') {
		$checked_autopost_email='checked';
	}
	else {
		$autopost_email_box_css = 'display:none;';
	}
	
	//Status update
	echo '<form id="status_update_form" name="status_update_form" style="padding:5px; background: #f5f5f5;">';
	
		echo '<div><label><input id="autopost_status" name="autopost_status" type="checkbox" '.$checked_autopost_status.'> <b>Enable the status autopost</b> (Facebook)</label></div>';
		
		echo '<div id="status_update_box" style="margin-top:10px; margin-left:30px; '.$autopost_status_box_css.'">';
			
			echo 'Status message:<br>';
			echo '<textarea id="status_message" name="status_message" style="width:620px; height:80px;">'.$settings['autopost_status_message'].'</textarea><br>';
			
			echo 'Link:<br><input type="text" id="status_link" name="status_link" value="'.$settings['autopost_status_link'].'" style="width:620px;"><br>';
			echo 'Picture:<br><input type="text" id="status_picture" name="status_picture" value="'.$settings['autopost_status_picture'].'" style="width:620px;"><br>';
			
			echo '<p style="margin-top:5px;"><input type="submit" id="autopost_status_save_btn" value="Save"> - <a href="./">Cancel</a></p>';
			
		echo '</div>';
		
	echo '</form>';
	
	echo '<br>';
	
	//Email
	echo '<form id="autopost_email_form" name="email_form" style="padding:5px; background: #f5f5f5;">';
	
		echo '<div><label><input id="autopost_email" name="autopost_email" type="checkbox" '.$checked_autopost_email.'> <b>Enable the email autopost</b></label></div>';
		
		echo '<div id="autopost_email_box" style="margin-top:10px; margin-left:30px; '.$autopost_email_box_css.'">';
			
			echo 'Subject:<br><input type="text" id="autopost_email_subject" name="autopost_email_subject" value="'.$settings['autopost_email_subject'].'" style="width:620px;"><br>';
			
			echo 'Message:<br>';
			echo '<textarea id="autopost_email_message" name="autopost_email_message" style="width:620px; height:200px;">'.$settings['autopost_email_message'].'</textarea><br>';
			
			echo '<p style="margin-top:5px;"><input type="submit" id="autopost_email_save_btn" value="Save"> - <a href="./">Cancel</a></p>';
			
		echo '</div>';
		
	echo '</form>';
	
	?>
	
</div>

<?php
include_once('./include/presentation/footer.php');
?>