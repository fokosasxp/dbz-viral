<?php

class Fb_ypbox_events extends Fb_ypbox
{
	
	//get events
	function get_user_events($criteria=array()) {
		$id = $criteria['id'];
		$connection = 'events';
		$content = parent::get_fb_api_results(array('object'=>$id, 'connection'=>$connection));
		$content = $this->format_fb_events($content);
		return $content;
	}
	
	function updateRsvpStatus($criteria=array()) {
		$fb_event_id = $criteria['fb_event_id'];
		$rsvp_status = $criteria['rsvp_status'];
		
		if($token=='') $token = $this->getAccessToken();
		
		if($fb_event_id!=''&&$rsvp_status!='') {
			$url = 'https://graph.facebook.com/'.$fb_event_id.'/'.$rsvp_status;
			if($token!='') $url .= '?access_token='.$token;
			$results = $this->postDataToURL($url);
		}
		
		return $results;
	}
	
	//format the events
	function format_fb_events($content) {
		$data = $content['data'];
		
		if(count($data)>0) {
			for($i=0; $i<count($data); $i++) {
				$start_time = $data[$i]['start_time'];
				$end_time = $data[$i]['end_time'];
				$id = $data[$i]['id'];
				
				//format date and time
				if($start_time!='') {
					$start_time = $this->convertIso8601DateToTimestamp($start_time);
					$start_date = date('Y-m-d',$start_time);
					$start_time = date('H:i:s',$start_time);
				}
				if($end_time!='') {
					$end_time = $this->convertIso8601DateToTimestamp($end_time);
					$end_date = date('Y-m-d',$end_time);
					$end_time = date('H:i:s',$end_time);
				}
				
				$data[$i]['start_date'] = $start_date;
				$data[$i]['start_time'] = $start_time;
				$data[$i]['end_date'] = $end_date;
				$data[$i]['end_time'] = $end_time;
				$data[$i]['fb_event_id'] = $id;
				
				unset($data[$i]['id']);
			}
		}
		
		$content['data'] = $data;
		
		return $content;
	}
	
	//convert Facebook date format
	function convertIso8601DateToTimestamp($datestring) {
		// 2010-10-07T11:43:20+0000
		$date = explode('T', $datestring);
		$d1 = explode('-', $date[0]);
		$t1 = explode(':', substr($date[1],0,8));
		$timestamp = mktime($t1[0], $t1[1], $t1[2], $d1[1], $d1[2], $d1[0]);
		return $timestamp;
	}
	
}

?>