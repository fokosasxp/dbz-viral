<?php
include_once('../../include/webzone.php');

$autopost = $_POST['autopost_status'];
$message = $_POST['status_message'];
$link = $_POST['status_link'];
$picture = $_POST['status_picture'];

if($GLOBALS['demo_mode']!=1) {
	add_setting('autopost_status', $autopost);
	add_setting('autopost_status_message', $message);
	add_setting('autopost_status_link', $link);
	add_setting('autopost_status_picture', $picture);
}

?>