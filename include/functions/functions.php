<?php

function sendMail($from, $to, $subject, $message, $bcc='') {
	$headers  = "From: $from\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	if($bcc!='') $headers .= "Bcc: $bcc";
	mail($to, $subject, $message, $headers);
}

function parse_signed_request($signed_request, $secret) {
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

  // decode the data
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);

  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }

  // check sig
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }

  return $data;
}

function base64_url_decode($input) {
  return base64_decode(strtr($input, '-_', '+/'));
}

function postDataToURL($url, $postParms) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postParms);
	$results = curl_exec($ch);
	curl_close($ch);
	return $results;
}

function getDataFromUrl($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function time_since($original,$today='') {
    // array of time period chunks
    $chunks = array(
	array(60 * 60 * 24 * 365 , 'year'),
	array(60 * 60 * 24 * 30 , 'month'),
	array(60 * 60 * 24 * 7, 'week'),
	array(60 * 60 * 24 , 'day'),
	array(60 * 60 , 'hour'),
	array(60 , 'min'),
	array(1 , 'sec'),
    );

    if($today=='') $today = time(); /* Current unix time  */
    $since = $today - $original;

    // $j saves performing the count function each time around the loop
    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
		$seconds = $chunks[$i][0];
		$name = $chunks[$i][1];
	
		// finding the biggest chunk (if the chunk fits, break)
		if (($count = floor($since / $seconds)) != 0) {
		    break;
		}
    }

    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";

    if ($i + 1 < $j) {
		// now getting the second item
		$seconds2 = $chunks[$i + 1][0];
		$name2 = $chunks[$i + 1][1];
	
		// add second item if its greater than 0
		if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
		    $print .= ($count2 == 1) ? ', 1 '.$name2 : " $count2 {$name2}s";
		}
    }
    return $print;
}

?>