<?php

class Fb_ypbox_images extends Fb_ypbox
{
	
	function get_galleries($criteria=array()) {
		$user_id = $criteria['user_id'];
		$token = $criteria['token'];
		
		if($user_id=='') $user_id = 'me';
		
		$results = parent::get_fb_api_results(array('connection'=>'albums', 'object'=>$user_id, 'token'=>$token));
		
		return $results;
	}
	
	function get_gallery_images($criteria=array()) {
		$gallery_id = $criteria['gallery_id'];
		$token = $criteria['token'];
		$limit = $criteria['limit'];
				
		if($gallery_id!='') {
			$results = parent::get_fb_api_results(array('connection'=>'photos', 'object'=>$gallery_id, 'token'=>$token, 'limit'=>$limit));
		}
		
		return $results;
	}
}

?>