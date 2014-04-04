<?php
include_once('include/webzone.php');
?>

<div style="padding:20px;">

<b>Step 1:</b><br>
Make sure you complete the "include/config.php" file as specified in the documentation.

<br><br>

<b>Step 2:</b><br>

<?php
$add_to_page_link = "https://www.facebook.com/dialog/pagetab?app_id=".$GLOBALS['fb_app_id']."&next=".$GLOBALS['app_url'].$GLOBALS['app_folder'];
echo '<a href="'.$add_to_page_link.'">Add this app to my Facebook page</a>';
?>

<br><br>

<b>Step 3:</b><br>
Your app is accessible on your <a href="<?php echo $GLOBALS['fb_page_tab_url']; ?>">Facebook page tab</a> :)

</div>