<?php
include_once('../../include/webzone.php');

$locked_content = $_POST['locked_content2'];

if($GLOBALS['demo_mode']!=1) {
	add_setting('locked_content', $locked_content);
}

?>