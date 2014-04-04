<?php

//no slash at the end
$GLOBALS['app_url'] = 'http://dbzapps.appspot.com';
//your app folder - Leave empty if your app ins installed on the root of your domain
$GLOBALS['app_folder'] = '';

//link to the Facebook page tab
$GLOBALS['fb_page_tab_url'] = 'https://www.facebook.com/gokas.lt/app_258779147576754';

//Facebook app information
$GLOBALS['fb_app_id'] = '258779147576754';
$GLOBALS['fb_app_secret'] = '4911993ff5eb607f81bcebb20110cfe3';
$GLOBALS['fb_sdk_lang'] = 'lt_LT'; //en_US, fr_FR, etc...

//Require the users to like your page or not
$GLOBALS['page_like_required'] = 1; //possible values: 1 (like required), 0 (like not required)

//database access
$GLOBALS['db_host'] = '79.98.24.174';
$GLOBALS['db_name'] = 'apps_engine';
$GLOBALS['db_user'] = 'apps_engine';
$GLOBALS['db_password'] = 'O7xcIEJq';

//Email from used when sending emails from the backend
$GLOBALS['email_from'] = '';

//Demo mode or not. Possible values: 0, 1
$GLOBALS['demo_mode'] = 0;

/*
#############
###### System (not to be changed without knowing what you do)
*/

//$GLOBALS['base_url'] = $GLOBALS['app_url'].$GLOBALS['app_folder'];

//database tables names
$GLOBALS['db_table']['users'] = 'fb_app_viral_users';
$GLOBALS['db_table']['settings'] = 'fb_app_viral_settings';

//Facebook app settings
//read_stream,publish_stream,email,user_birthday,manage_pages,user_events,rsvp_event,create_event
//$GLOBALS['fb_ypbox_path'] = $GLOBALS['app_folder'].'/include/library/Fb_box'; //not to be modified
$GLOBALS['fb_scope'] = 'publish_stream,email'; 

?>