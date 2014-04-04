<?php
include_once('../../include/webzone.php');

$autopost = $_POST['autopost'];

if($GLOBALS['demo_mode']!=1) {
	add_setting('autopost_status', $autopost);
}

?>