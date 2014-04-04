<?PHP

require_once 'config.php';
;echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>Photo Vote Contest</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="';echo $global['home_link'];echo 'js/jquery-1.7.2.min.js"></script>
<STYLE TYPE="text/css" MEDIA=screen>
.blue1 {
    background-color: #607FC1;
    border: 1px solid #3A4B70;
    box-shadow: 0 1px 0 0 #7491CE inset;
    color: #FFFFFF;
    display: inline-block;
    font-family: arial;
    font-size: 11px;
    font-weight: bold;
    height: 15px;
    margin: 5px 10px;
    padding: 9px 0 5px;
    text-decoration: none;
    text-shadow: 1px 1px 0 #3F62AC;
    width: 125px;
}
.button {
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    display: inline-block;
    font: 12px/100% Calibri,Arial,Helvetica,sans-serif;
    margin: 0;
    outline: medium none;
    padding: 0.4em 1.5em 0.45em;
    text-align: center;
    text-decoration: none;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
    vertical-align: baseline;
}
</STYLE>

</head>
<body>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : \'';echo $global['app_id'];;echo '\', // App ID
      channelUrl : \'//';echo $global['home_link'];;echo 'channel.php\', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    FB.Canvas.setSize({ height: 800 });
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = \'facebook-jssdk\', ref = d.getElementsByTagName(\'script\')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(\'script\'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
    
    function share_pic(pic_details, access_token)
	{
		$.ajax({
			 url: \'share.php?pic_details=\'+pic_details+\'&access_token=\'+access_token,
				success: function(data) {
					if(data == 1){
						$("#share_text").text("SHARED");
					}			
				}
		});
	}
   
</script>';;
?>