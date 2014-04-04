<?php

function get_nb_users($criteria=array()) {
	$expired_filter = $criteria['expired_filter']; //flag
	
	$m1 = new MySqlTable();
	$sql = "SELECT count(*) nb FROM ".$GLOBALS['db_table']['users']." WHERE 1 ";
	
	//expired filter
	if($expired_filter==1) {
		$sql .= " AND fb_token_expires>".time()." || fb_token_expires=0";
	}
	elseif($expired_filter==2) {
		$sql .= " AND fb_token_expires<".time()." && fb_token_expires!=0";
	}
	
	$result = $m1->customQuery($sql);
	return $result[0]['nb'];
}

function get_users($criteria=array()) {
	$id = $criteria['id'];
	$fb_user_id = $criteria['fb_user_id'];
	$page_number = $criteria['page_number'];
	$nb_display = $criteria['nb_display'];
	$expired_filter = $criteria['expired_filter']; //flag
	
	if($nb_display=='') $nb_display='20';
	$start = $page_number*$nb_display-$nb_display;
	
	$m1 = new MySqlTable();
	$sql = "SELECT * FROM ".$GLOBALS['db_table']['users']." WHERE 1 ";
	
	//expired filter
	if($expired_filter==1) {
		$sql .= " AND fb_token_expires>".time()." || fb_token_expires=0";
	}
	elseif($expired_filter==2) {
		$sql .= " AND fb_token_expires<".time()." && fb_token_expires!=0";
	}
	
	if($id!='') $sql .= " AND id='".$m1->escape($id)."'";
	if($fb_user_id!='') $sql .= " AND fb_id='".$m1->escape($fb_user_id)."'";
	
	$sql .= " ORDER BY id DESC";
	
	if($page_number!='') $sql .= " LIMIT $start, $nb_display";
	
	$result = $m1->customQuery($sql);
	
	if($GLOBALS['demo_mode']==1) {
		for($i=0; $i<count($result); $i++) {
			$result[$i]['fb_name'] = 'Name (hidden in demo mode)';
			$result[$i]['fb_email'] = 'Email (hidden in demo mode)';
			$result[$i]['fb_birthday'] = 'Birthday (hidden in demo mode)';
			$result[$i]['fb_token'] = 'Token (hidden in demo mode)';
		}
	}
	
	return $result;
}

function get_settings($criteria=array()) {
	$meta_key = $criteria['meta_key'];
	
	$s1 = new MySqlTable();
	$sql = "SELECT * FROM ".$GLOBALS['db_table']['settings']." WHERE 1";
	if($meta_key!='') $sql .= " AND meta_key='".$s1->escape($meta_key)."'";
	
	$result = $s1->customQuery($sql);
	return $result;
}

function delete_setting($key) {
	$s1 = new MySqlTable();
	$sql = "DELETE FROM ".$GLOBALS['db_table']['settings']." WHERE meta_key='".$s1->escape($key)."'";
	$s1->executeQuery($sql);
}

function add_setting($key, $value) {
	if($key!='') {
		$s1 = new MySqlTable();
		$result = get_settings(array('meta_key'=>$key));
		if(count($result)>0) {
			$sql = "UPDATE ".$GLOBALS['db_table']['settings']." SET meta_value='".$s1->escape($value)."' WHERE meta_key='".$s1->escape($key)."'";
			$s1->executeQuery($sql);
		}
		else {
			$sql = "INSERT INTO ".$GLOBALS['db_table']['settings']." (meta_key, meta_value) VALUES ('".$s1->escape($key)."', '".$s1->escape($value)."')";
			$s1->executeQuery($sql);
		}
	}
}

/*
START Default add/update functions
*/

function save_posted_data($data, $table_name) {
	
	$s1 = new MySqlTable();
	
	$fields='';
	$fields_values='';
	if(count($data)>0) {
		foreach($data as $ind => $value) {
			$fields .= $s1->escape($ind).',';
			$fields_values .= "'".$s1->escape($value)."',";
		}
	}
	
	$fields = substr($fields,0,-1);
	$fields_values = substr($fields_values,0,-1);
	
	$sql = "INSERT INTO $table_name ($fields) VALUES ($fields_values)";
	$s1->executeQuery($sql);
}

function update_posted_data($data, $id, $table_name) {
	
	$s1 = new MySqlTable();
	
	$fields='';
	if(count($data)>0) {
		foreach($data as $ind => $value) {
			$fields .= $s1->escape($ind)."='".$s1->escape($value)."',";
		}
	}
	
	$fields = substr($fields,0,-1);
	$fields_values = substr($fields_values,0,-1);
	
	$sql = "UPDATE $table_name SET $fields WHERE id='".$s1->escape($id)."'";
	$s1->executeQuery($sql);
}

?>