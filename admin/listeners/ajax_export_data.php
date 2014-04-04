<?php
include_once('../../include/webzone.php');

if($GLOBALS['demo_mode']==1) {
	$display = 'Data not available in demo mode';
}

else {
	if(count($_POST)>0) {
		foreach($_POST as $ind => $value) {
			if($value=='on') $fields_tab[] = $ind;
		}
	}
	
	$fields = implode(',', $fields_tab);
	
	$m1 = new MySqlTable();
	$sql = "SELECT $fields FROM ".$GLOBALS['db_table']['users']." WHERE 1";
	$result = $m1->customQuery($sql);
	
	$display = $fields."\n";
	
	for($i=0; $i<count($result); $i++) {
		$value_tab = array();
		foreach($result[$i] as $ind => $value) {
			$value_tab[] = $value;
		}
		$value = implode(',', $value_tab);
		$display .= $value;
		if($i<count($result)-1) $display .= "\n";
	}
	
}

echo '<textarea style="width:800px; height:300px;">'.$display.'</textarea>';

?>