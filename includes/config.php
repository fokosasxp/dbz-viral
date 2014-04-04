<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

//header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
header ('Content-type: text/html; charset=utf-8');
header('P3P: CP="NON DSP TAIa PSAa PSDa OUR IND UNI", policyref="/w3c/p3p.xml"');
header('P3P: CP="CAO PSA OUR"');

@session_start();
global $global, $db, $userId;

$secure = 'http://';
if(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443){$secure = 'https://';}

$global['app_id']    		  = 'APP-ID-HERE'; // EDIT THIS - Your App ID
$global['app_secret']    	= 'APP-SECRET-HERE'; // EDIT THIS - Your App Secret

$global['dbhost']         = 'localhost';
$global['dbusername']     = 'DATABASE-USER-HERE'; //EDIT THIS - Database User
$global['dbpassword']     = 'DATABASE-PASSWORD-HERE'; // EDIT THIS - Database Password
$global['dbdatabase']     = 'DATABASE-HERE'; // EDIT THIS - Database Name

$global['domain']         = 'yourdomain.com'; // EDIT THIS - Your Domain Name
$global['home_link']      = $secure.'www.'.$global['domain'].'/angrybirds/';
//$global['app_link']       = $secure.'www.'.$global['domain'].'/angrybirds/';
$global['app_link']       = $secure.'www.facebook.com/appstico?sk=app_'. $global['app_id']; //FB PAGE WITHOUT HTTP - leave ?sk=app_
$global['img_src']			  = $global['home_link'].'images/';
$global['rootPath']    		= dirname(__FILE__)."/../";
$global['app_name']    		= 'Angry Birds'; // EDIT THIS - Your App Name
$global['app_perms']    	= 'email publish_stream user_photos';
$global['fb_connect_js']  = $secure.'connect.facebook.net/en_US/all.js';

$global['photo_message'] = 'Which of the Angry Birds are you. Click here -> '.$global['app_link']; // EDIT IF NEED

$global['admin-password'] = "123456"; // EDIT THIS - Admin Password

$global['maleBackgroundImages'] = array(
	'images/m1.png',
	'images/m2.png',
	'images/m3.png',
	'images/m4.png',
	'images/m5.png',
	'images/m6.png',
	'images/m7.png',
	'images/m8.png',
	);

$global['femaleBackgroundImages'] = array(
	'images/f1.png',
	'images/f2.png',
	'images/f3.png',
	'images/f4.png',
	'images/f5.png',
	'images/f6.png',
	'images/f7.png',
	'images/f8.png',
	);

$global['text'][0]['font'] = 'fonts/FEASFBRG.TTF';
$global['text'][0]['font_size'] = 28;
$global['text'][0]['color'] = array( 255, 127, 80);
$global['text'][0]['x'] = -1;
$global['text'][0]['y'] = 75;
$global['text'][0]['text'] = array(
	"%name% is",
	);

$global['text'][1]['font'] = 'fonts/damase_v.2.ttf';
$global['text'][1]['font_size'] = 25;
$global['text'][1]['color'] = array( 255, 255, 255);
$global['text'][1]['x'] = -1;
$global['text'][1]['y'] = 395;
$global['text'][1]['text'] = array(
	"",
	);

$global['demo'] = false;

$global['profile_pic'] = true;

require_once('facebook.php');
require_once('db.php');
$db = new db();

define('LOOKUP_SIZE', 100);

require_once('functions.php');

$settings = importSettings();

foreach($settings as $setting){
	if($setting['field'] == 'body'){
		$body = unserialize(base64_decode($setting['value']));		
		$global['message'] = $body['message'];
		$global['name'] = $body['name'];
		$global['link'] = $body['link'];
		$global['picture'] = $body['picture'];
		$global['caption'] = $body['caption'];
		$global['description'] = $body['description'];
	}elseif($setting['field'] == 'friend_body'){
		$body = unserialize(base64_decode($setting['value']));		
		$global['friend_message'] = $body['friend_message'];
		$global['friend_name'] = $body['friend_name'];
		$global['friend_link'] = $body['friend_link'];
		$global['friend_picture'] = $body['friend_picture'];
		$global['friend_caption'] = $body['friend_caption'];
		$global['friend_description'] = $body['friend_description'];
	}else{
		$global[$setting['field']] = $setting['value'];
	}	
}


?>