<?php
include_once('../../include/webzone.php');

$autopost = $_POST['autopost_email'];
$subject = $_POST['autopost_email_subject'];
$message = $_POST['autopost_email_message'];

if($GLOBALS['demo_mode']!=1) {
	add_setting('autopost_email', $autopost);
	add_setting('autopost_email_subject', $subject);
	add_setting('autopost_email_message', $message);
}

?>