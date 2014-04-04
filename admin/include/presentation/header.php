<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html lang="en"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<title>Facebook Viral App Admin</title> 

<link rel="stylesheet" href="include/css/style.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="include/css/grid.css" type="text/css" media="screen, projection">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="include/js/script.js"></script>
<script src="../include/library/ckeditor/ckeditor.js"></script>

<script>
$(document).ready(function() {
	
})
</script>

</head>
<body>

<div class="container">
	<br>
	
	<h1 style="margin-bottom:5px;">Facebook Viral App Admin</h1>
	
	<div style="margin-bottom:5px; margin-top:5px;">
		
		<?php
		if($current_page=='home') echo '<b><a href="./" style="color:black;">Users</a></b> - ';
		else echo '<a href="./">Users</a> - ';
		if($current_page=='autopost') echo '<b><a href="./autopost.php" style="color:black;">Autopost</a></b> - ';
		else echo '<a href="./autopost.php">Autopost</a> - ';
		if($current_page=='settings') echo '<b><a href="./settings.php" style="color:black;">Settings</a></b> - ';
		else echo '<a href="./settings.php">Settings</a> - ';
		if($current_page=='export') echo '<b><a href="./export.php" style="color:black;">Export</a></b>';
		else echo '<a href="./export.php">Export</a>';
		?>
		
	</div>
	
	<hr>
	
	<?php
	
	if($GLOBALS['demo_mode']==1) {
		?>
		<div class="yellowBox" style="padding:10px; margin-bottom:20px; color:#780000;">
		<b>Please note that some functions are disabled in this demo, but you can have an overview of all the available features !</b>
		</div>
		<?php
	}
	
	?>
	
</div>
