<?php
$token = $_POST['token'];

$f1 = new Fb_ypbox();
$data = $f1->get_fb_api_results(array('object'=>'me', 'connection'=>'friends?fields=id,name,username,birthday', 'token'=>$token));

//echo count($data['data']).'<br>';

$data = formatBirthdays($data);
print_r($data);

?>