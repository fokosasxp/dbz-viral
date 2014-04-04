<?php

class Fb_ypbox_users extends Fb_ypbox
{
	
	/*
	//Get friends extended info
	/*
	for($i=0; $i<count($fb_friends); $i++) {
		$fb_ids[] = $fb_friends[$i]['id'];
	}
	$fb_ids_string = implode(',', $fb_ids);
	
	$url = 'https://graph.facebook.com/fql?access_token='.$f1->getAccessToken().'&q=';
	$query = 'SELECT uid,name,first_name,last_name,birthday_date FROM user WHERE uid IN ('.$fb_ids_string.')';
	$query = urlencode($query);
	$url .= $query;
	$data = $f1->getDataFromUrl($url);
	$data = json_decode($data,true);
	$fb_friends2 = $data['data'];
	*/
	
	/*
	START birthday related functions
	*/
	
	function getUsersListByBirthday() {
		
		$f1 = new Fb_ypbox();
		$data = $f1->get_fb_api_results(array('object'=>'me', 'connection'=>'friends?fields=id,name,username,birthday,gender'));
		$users_list = $this->formatBirthdays($data);
		
		//Get array of next birthdays
		//Returned values: user_id => next birthday timestamp
		if(count($users_list)>0) {
			$i=0;
			foreach($users_list as $value) {
				$birthday = strtotime( date('Y').'/'.$value['month'].'/'.$value['day'] );
				$now = time()-36000;
				//echo date('Y-m-d H:i:s', $now);
				if($now>=$birthday) {
					$birthday = strtotime( (date('Y')+1).'/'.$value['month'].'/'.$value['day'] );
					$coming_birthdays[$value['id']] = $birthday;
				}
				else {
					$coming_birthdays[$value['id']] = $birthday;
				}
			}
		}
		asort($coming_birthdays);
		
		//Get array of all the birthdays of the year
		//Returned values: user_id => birthday timestamp
		if(count($users_list)>0) {
			$i=0;
			foreach($users_list as $value) {
				$birthday = strtotime( date('Y').'-'.$value['month'].'-'.$value['day'] );
				$ordered_birthdays[$value['id']] = $birthday;
			}
		}
		asort($ordered_birthdays);
		
		//print_r($coming_birthdays);
		
		//Order users list by birthday date (January to December)
		if(count($ordered_birthdays)>0) {
			foreach($ordered_birthdays as $ind=>$value) {
				$tmpTab[$ind] = $users_list[$ind];
			}
		}
		$users_list = $tmpTab;
		
		$data['users_list'] = $users_list;
		$data['coming_birthdays'] = $coming_birthdays;
		$data['users_by_month_birthday'] = $this->getUsersByMonthBirthday($users_list);
		return $data;
	}
	
	//Format birthdays users information returned by the API
	function formatBirthdays($data) {
		for($i=0; $i<count($data['data']); $i++) {
			//Set birthday related stuff
			$birthday = $data['data'][$i]['birthday'];
			if($birthday!='') {
				$fb_user_id = $data['data'][$i]['id'];
				$data2[$fb_user_id]['id'] = $data['data'][$i]['id'];
				$data2[$fb_user_id]['name'] = $data['data'][$i]['name'];
				$data2[$fb_user_id]['birthday'] = $data['data'][$i]['birthday'];
				$data2[$fb_user_id]['gender'] = $data['data'][$i]['gender'];
				$data2[$fb_user_id]['link'] = 'http://www.facebook.com/profile.php?id='.$fb_user_id;
				$data2[$fb_user_id]['image'] = 'http://graph.facebook.com/'.$fb_user_id.'/picture';
				if(strlen($birthday)==10) {
					$data2[$fb_user_id]['month'] = substr($data['data'][$i]['birthday'], 0, 2);
					$data2[$fb_user_id]['day'] = substr($data['data'][$i]['birthday'], 3, 2);
					$data2[$fb_user_id]['year'] = substr($data['data'][$i]['birthday'], 6, 4);
					$data2[$fb_user_id]['nicer_birthday'] = round($data2[$fb_user_id]['day']).' '.$GLOBALS['Fb_box']['data_months'][round($data2[$fb_user_id]['month'])].' '.$data2[$fb_user_id]['year'];
				}
				else if(strlen($birthday)==5) {
					$data2[$fb_user_id]['month'] = substr($data['data'][$i]['birthday'], 0, 2);
					$data2[$fb_user_id]['day'] = substr($data['data'][$i]['birthday'], 3, 2);
					$data2[$fb_user_id]['nicer_birthday'] = round($data2[$fb_user_id]['day']).' '.$GLOBALS['Fb_box']['data_months'][round($data2[$fb_user_id]['month'])];
				}
			}
			
		}
		return $data2;
	}
	
	//Return a list on months with for each month the lists of users born that month
	function getUsersByMonthBirthday($data) {
		if(count($data)>0) {
			foreach($data as $ind => $value) {
				$data2[round($data[$ind]['month'])][] = $data[$ind]['id'];
			}
		}
		return $data2;
	}
}

?>