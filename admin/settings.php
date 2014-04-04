<?php
include_once('../include/webzone.php');

$current_page = 'settings';

include_once('./include/presentation/header.php');
?>

<div class="container">	
	
	<div class="blueTable" style="padding:5px;">
		<div>Here you can define the general settings of your app.</div>
	</div>
	<br>
	
	<?php
	
	$result = get_settings();
	for($i=0; $i<count($result); $i++) {
		$settings[$result[$i]['meta_key']] = $result[$i]['meta_value'];
	}
	
	//locked content
	echo '<form id="locked_content_form" name="locked_content_form">';
	
		echo '<div style="margin-bottom:5px;">
		<b>Content only viewable by connected users:</b> 
		<small>(HTML code possible - Use <font color="green"><i>{name}</i></font> or <font color="green"><i>{picture}</i></font> to replace with connected user data)</small>
		</div>';
		
		echo '<textarea id="locked_content" name="locked_content" class="ckeditor">'.stripslashes($settings['locked_content']).'</textarea><br>';
		
		echo '<p style="margin-top:5px;"><input type="submit" id="locked_content_save_btn" value="Save"> - <a href="./">Cancel</a></p>';
		
	echo '</form>';
	
	?>
	
</div>

<?php
include_once('./include/presentation/footer.php');
?>