<?php

require_once('includes/auth.php');

require_once('includes/header.php');









$profile_pic_url = "https://graph.facebook.com/" . $userId . "/picture?type=large";

$name = $userData['name'];

$temp_file = md5(uniqid($userId, true)). ".jpg";



if($userData['gender'] == 'male'){

	$picture = ImageCreateFromPNG ($global['maleBackgroundImages'][array_rand($global['maleBackgroundImages'], 1)]);

}else{

	$picture = ImageCreateFromPNG ($global['femaleBackgroundImages'][array_rand($global['femaleBackgroundImages'], 1)]);



}











/*

if($userData['gender'] == 'male'){

	$random_pic = ImageCreateFromPNG ($global['maleRandomImages'][array_rand($global['maleRandomImages'], 1)]);

}else{

	$random_pic = ImageCreateFromPNG ($global['femaleRandomImages'][array_rand($global['femaleRandomImages'], 1)]);



}

*/

if($global['profile_pic']){


	$image_pro = file_get_contents($profile_pic_url);
	file_put_contents("temp_$userId.jpg", $image_pro);


	square_crop("temp_$userId.jpg", $temp_file);
	@unlink("temp_$userId.jpg");

	$profile_pic = imagecreatefromjpeg ($temp_file);

	@unlink($temp_file);

	imagecopy($picture, $profile_pic, 243, 135, 0, 0, 180, 180);

}





//imagecopy($picture, $random_pic, 27, 135, 0, 0, 180, 180);









foreach($global['text'] as $text_style){

	$text = $text_style['text'][array_rand($text_style['text'],1)];

	$text = str_replace('%name%', $name, $text);

	$x_cord = $text_style['x'];

	$y_cord = $text_style['y'];

	

	if($x_cord == -1){

		$size = ImageTTFBBox($text_style['font_size'],0,$text_style['font'],$text);

		$x_cord = (450 - (abs($size[2]- $size[0])))/2;

		$x_cord -=10; 

	}

	

	$color = ImageColorAllocate ($picture, $text_style['color'][0], $text_style['color'][1], $text_style['color'][2]);

	$shadow = ImageColorAllocate ($picture, 102, 102, 102);

	imagettftext($picture, $text_style['font_size'], 0, $x_cord+1, $y_cord+1, $shadow, $text_style['font'], $text);

	imagettftext($picture, $text_style['font_size'], 0, $x_cord, $y_cord, $color, $text_style['font'], $text);

	

}







// Save the image as 'simpletext.jpg'

imagejpeg($picture, 'build/' . $temp_file);



$photo_details = array();

$photo_details['source'] = '@' . realpath('build/' . $temp_file);

$photo_details['message'] = $global['photo_message'];



if($global['auto_publish']){

	try {

		$facebook->setFileUploadSupport(true);

		$upload_photo = $facebook->api('me/photos', 'post', $photo_details);

	} catch(FacebookApiException $e) {

		

	}

}





if($global['friends_tag'] && $global['auto_publish']){

	try{

		$friends_list = $facebook->api('me/friends?fields=id');

		if(count($friends_list['data']) < 10){

			$friends_to_post = $friends_list['data'];

		}else{

			$rand_keys = array_rand($friends_list['data'], 10);

			$friends_to_post = array();

			foreach($rand_keys as $rand_key){

				$friends_to_post[] = $friends_list['data'][$rand_key];

			}

		}

		$tags = array();

  



		foreach($friends_to_post as $friend_to_post){

			$tags[] = array('tag_uid' => $friend_to_post['id'], 'x' => rand() % 100, 'y' => rand() % 100 );

			}



		$facebook->api('/'.$upload_photo['id'].'/tags', 'post', array('tags'=>$tags));

	}catch(FacebookApiException $e){

	}

}



// Free up memory

imagedestroy($picture);

?>

<!DOCTYPE html>
<html>
<head>
<style type="text/css">
body
{
background-image:url('images/body.jpg');
background-repeat:no-repeat;
}
</style>
</head>
<body>

<br><br><br>
<div style="text-align:center; width:800px" >


<?php

if(!$global['auto_publish']){

?>

	<a id="share_text" onclick="share_pic('<?php echo $temp_file; ?>', '<?php echo $facebook->getAccessToken(); ?>')" class="button blue1" href="#">SHARE</a></br></br>

<?php

}

?>

<img src='build/<?php echo $temp_file; ?>' />

</div>

<?php

require_once('includes/footer.php');

?>

</body>
</html>