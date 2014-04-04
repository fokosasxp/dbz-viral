<?php
include_once('../include/webzone.php');

$current_page = 'export';

include_once('./include/presentation/header.php');
?>

<div class="container">	
	<div class="span-24">
	
	<div class="blueBox" style="padding:5px;">
		<div>From this page you can export your users data into a CSV format.</div>
	</div>
	<br>
	
	<?php
	
	echo '<form id="export_form" name="export_form">';
	
		echo '<p><b>Please select the data you want to export:</b></p>';
		
		echo '<div><label><input id="fb_id" name="fb_id" type="checkbox"> User id</label></div>';
		echo '<div><label><input id="fb_name" name="fb_name" type="checkbox"> Name</label></div>';
		echo '<div><label><input id="fb_email" name="fb_email" type="checkbox"> Email</label></div>';
		echo '<div><label><input id="fb_token" name="fb_token" type="checkbox"> Token</label></div>';
		echo '<div><label><input id="fb_token_expires" name="fb_token_expires" type="checkbox"> Token expiration</label></div>';
		echo '<div><label><input id="fb_birthday" name="fb_birthday" type="checkbox"> Birthday</label></div>';
		echo '<div><label><input id="created" name="created" type="checkbox"> Connection date</label></div>';
		
		echo '<p style="margin-top:10px;"><input type="submit" id="export_btn" value="Export"> - <a href="./">Cancel</a></p>';
	
	echo '</form>';
	
	?>
	
	<div id="export_results_box" style="display:none;">
		<div id="export_results"></div>
		<p style="margin-top:10px;"><a href="#" id="export_box_display_btn">Back to previous</a></p>
	</div>
	
	</div>
</div>

<?php
include_once('./include/presentation/footer.php');
?>