<html>
<head>
<meta charset="utf-8">
<title></title>
<link rel="stylesheet" type="text/css" media="all" href="include/css/style.css" /> 

</head>

<body>

<?php
if($GLOBALS['fb_app_id']!='') {
?>
	<div id="fb-root"></div>
	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '<?php echo $GLOBALS['fb_app_id']; ?>',
	      status     : true,
	      xfbml      : true
	    });
	    FB.Canvas.setSize();
	  };
	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "//connect.facebook.net/<?php echo $GLOBALS['fb_sdk_lang']; ?>/all.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>
<?php
}
?>