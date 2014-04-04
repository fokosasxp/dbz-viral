<?php
include_once('../../include/webzone.php');

$id = $_POST['id'];
$fb_id = $_POST['fb_id'];

if($GLOBALS['demo_mode']!=1) {
	$m1 = new MySqlTable();
	$sql = "SELECT * FROM ".$GLOBALS['db_table']['users']." WHERE id='".$m1->escape($id)."' AND fb_id='".$m1->escape($fb_id)."'";
	$result = $m1->customQuery($sql);
	
	if(count($result)>0) {
		$sql = "DELETE FROM ".$GLOBALS['db_table']['users']." WHERE id='".$m1->escape($id)."'";
		$m1->executeQuery($sql);	
	}
}

?>