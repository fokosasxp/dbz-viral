<?php
include_once('../include/webzone.php');

$page_number = $_GET['page'];
$expired_filter = $_GET['expired_filter'];

if($expired_filter=='') $expired_filter=1;

if($page_number=='') $page_number=1;
$nb_display = 40;
$start = $page_number*$nb_display-$nb_display;

$current_page = 'home';

include_once('./include/presentation/header.php');
?>

<div class="container">	
	<div class="span-24">
	<?php
	
	$result = get_users(array('page_number'=>$page_number, 'nb_display'=>$nb_display, 'expired_filter'=>$expired_filter));
	$nb_users = get_nb_users(array('expired_filter'=>$expired_filter));
	
	//Status update
	echo '<div id="status_update_box" style="margin-bottom:10px; display:none;"><form id="status_update_form" name="status_update_form">';
		
		echo '<h2><b>Post a Facebook status message</b></h2>';
		
		echo 'Users:<br>';
		echo '<div id="users_list" style="margin-bottom:10px;"></div>';
		echo 'Status message:<br>';
		echo '<textarea id="message" name="message" style="width:620px; height:80px;"></textarea><br>';
		
		echo 'Link:<br><input type="text" id="link" name="link" style="width:620px;"><br>';
		echo 'Picture:<br><input type="text" id="picture" name="picture" style="width:620px;"><br>';
		
		echo '<p style="margin-top:5px;"><input type="submit" id="post_status_btn" value="Post status"> - <a href="./">Cancel</a></p>';
		
		echo '<p style="margin-top:10px;"><b>Tip:</b></p>';
		echo '<p>You can use <font color="green"><i>{name}</i></font> in the status message, and it will be replaced by each user\'s name.</p>';
		
	echo '</form></div>';
	
	//Send email
	echo '<div id="send_email_box" style="margin-bottom:10px; display:none;"><form id="send_email_form" name="send_email_form">';
		
		echo '<h2><b>Send an email</b></h2>';
		
		echo 'Users:<br>';
		echo '<div id="users_list_email" style="margin-bottom:10px;"></div>';
		
		echo 'Subject:<br><input type="text" id="email_subject" name="email_subject" style="width:620px;"><br>';
		echo 'Message:<br>';
		echo '<textarea id="email_message" name="email_message" style="width:620px; height:200px;"></textarea><br>';
		
		echo '<p style="margin-top:5px;"><input type="submit" id="send_email_btn" value="Send email"> - <a href="./">Cancel</a></p>';
		
		echo '<p style="margin-top:10px;"><b>Tips:</b></p>';
		echo '<p>- You can use <font color="green"><i>{name}</i></font> in the message, and it will be replaced by each user\'s name.</p>';
		echo '<p>- You can use HTML tags in your message content.</p>';
		
	echo '</form></div>';
	
	//users list display
	echo '<div id="users_display_box" class="checkboxes">';
		
		echo '<div style="padding:5px; background:#f5f5f5; margin-bottom:10px; position:relative;">';
			
			echo '<form>';
			echo '<label><input type="checkbox" id="check_all_btn" title="Check all"> <b>All users</b> ('.$nb_users.')</label>';
			
			$expired_filter_tab = array('1'=>'Valid tokens', '2'=>'Expired tokens');
			
			echo ' - <select onchange="form.submit();" name="expired_filter">';
			foreach($expired_filter_tab as $ind=>$value) {
				if($ind==$expired_filter) echo '<option selected value="'.$ind.'">'.$value.'</option>';
				else echo '<option value="'.$ind.'">'.$value.'</option>';
			}
			echo '</select>';
			
			echo '<div style="position:absolute; right:5px; top:8px;">';
			if($expired_filter==1) echo '<a href="#" id="update_users_wall_btn">Update users wall</a> - ';
			echo '<a href="#" id="send_email_box_btn">Send an email</a>';
			echo '</div>';
			
			echo '</form>';
			
		echo '</div>';
		
		for($i=0; $i<count($result); $i++) {
			$id = $result[$i]['id'];
			$fb_id = $result[$i]['fb_id'];
			$fb_name = $result[$i]['fb_name'];
			
			$picture = 'https://graph.facebook.com/'.$fb_id.'/picture';
			
			echo '<div class="item" style="border-bottom: 1px solid #e9e9e9; padding:5px; position:relative;">';
			echo '<label>';
			echo '<input type="checkbox" name="fb_accounts_selection[]" id="'.$fb_id.'"> ';
			echo '<img src="'.$picture.'" style="vertical-align: middle; margin-right:5px; width:24px;">';
			echo $fb_name;
			echo '</label>';
			echo '<div style="position:absolute; right:5px; top:8px;">
			<a href="./view.php?id='.$id.'">View</a> - 
			<a href="#" class="delete_user_btn" id="'.$id.'" name="'.$fb_id.'" style="color:red;">Delete</a>
			</div>';
			echo '</div>';
		}
		
		if($nb_users==0) echo 'No users found';
		
		echo '<br>'.display_pagination(array('start'=>$start, 'nb_display'=>$nb_display, 'nbTotal'=>$nb_users));
		
	echo '</div>';
	
	?>
	
	</div>
</div>

<?php
include_once('./include/presentation/footer.php');
?>