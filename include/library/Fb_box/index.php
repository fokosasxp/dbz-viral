<?php
include_once("include/webzone.php");

if(@$_GET['q']=='displayTimeline') include("listeners/display_timeline.php");
else if(@$_GET['q']=='addComment') include("listeners/add_comment.php");
else if(@$_GET['q']=='displayComments') include("listeners/display_comments.php");
else if(@$_GET['q']=='displayFriends') include("listeners/display_friends.php");

else if(@$_GET['q']=='displayUsersBirthday') include("listeners/display_users_birthday.php");

else echo 'Silence is golden.';

?>