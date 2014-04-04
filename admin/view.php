<?php
include_once('../include/webzone.php');
include_once('./include/presentation/header.php');

$id = $_GET['id'];

?>

<div class="container">
	
	<div class="span-24">
	
		<?php
		$item = get_users(array('id'=>$id));
		
		echo '<div><img src="https://graph.facebook.com/'.$item[0]['fb_id'].'/picture" style="vertical-align:middle; margin-right:10px;"> '.$item[0]['fb_name'].'</div><br>';
		
		echo '<table style="width:100%;">';
		echo '<tr><td style="width:140px;">User id:</td><td>'.$item[0]['fb_id'].'</td></tr>';
		//echo '<tr><td>Name:</td><td>'.$item[0]['fb_name'].'</td></tr>';
		echo '<tr><td>Email:</td><td>'.$item[0]['fb_email'].'</td></tr>';
		echo '<tr><td>Token:</td><td><input type="text" value="'.$item[0]['fb_token'].'" style="width:360px;"> ('.strlen($item[0]['fb_token']).')</td></tr>';
		
		echo '<tr><td>Token expiration:</td>';
		if(time()>$item[0]['fb_token_expires'] && $item[0]['fb_token_expires']!='0') echo '<td><font color="red">Expired</font> - The user needs to connect again to get a new valid token</td>';
		else if($item[0]['fb_token_expires']=='0') echo '<td>0</td>';
		else echo '<td>'.date('Y-m-d H:i:s', $item[0]['fb_token_expires']).' ('.$item[0]['fb_token_expires'].')</td>';
		echo '</tr>';
		
		echo '<tr><td>Birthday:</td><td>'.$item[0]['fb_birthday'].'</td></tr>';
		echo '<tr><td>Created:</td><td>'.$item[0]['created'].'</td></tr>';
		echo '</table>';
		?>
	
		<br><p><a href="./">Back to previous</a></p>
	
	</div>
</div>

<?php
include_once('./include/presentation/footer.php');
?>