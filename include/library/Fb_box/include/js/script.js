/*! 
Author: Yougapi Technology | http://yougapi.com/license/
License: A valid license is required to use this script or "Yougapi" written permission
This script is protected by International laws on copyright
*/

function onFbSdkCallbackFB_box() {
	FB.getLoginStatus(function(response) {
	  if (response.status === 'connected') {
	  	//alert(JSON.stringify(response));
	    var uid = response.authResponse.userID;
	    var accessToken = response.authResponse.accessToken;
	    if(Fb_ypbox.token=='') {
	    	//window.location.reload();
	    }
	  } 
	  else if (response.status === 'not_authorized') {
	    //alert('not authorized');
	  } 
	  else {
	    //alert('not logged');
	  }
	});
}

/*
START Facebook login logout functionalities
*/

$('#fb_box_fb_login_btn').live('click', function(event) {
	event.preventDefault();
	fb_box_fb_login();
});

$('#fb_box_fb_logout_btn').live('click', function(event) {
	event.preventDefault();
	fb_box_fb_logout();
});

function fb_box_fb_logout() {
	FB.getLoginStatus(function(ret) {
	    if(ret.authResponse) {
	        FB.logout(function(response) {
				if(Fb_ypbox.logout_redirect!='') window.location = Fb_ypbox.logout_redirect;
				else window.location.reload(true);
	        });
	    }
	    else {
			if(Fb_ypbox.logout_redirect!='') window.location = Fb_ypbox.logout_redirect;
			else window.location.reload(true);
	    }
	});
}

function fb_box_fb_login() {
	FB.login(function(response) {
	
	if ($.browser.opera) {
        FB.XD._transport="postmessage";
        FB.XD.PostMessage.init();
	}
	
	if (response.authResponse) {
		if(Fb_ypbox.connect_redirect!='') window.location = Fb_ypbox.connect_redirect;
		else window.location.reload(true);
	}
	else {
	}
	}, {scope:Fb_ypbox.scope});
}

/*
END Facebook login logout functionalities
*/
