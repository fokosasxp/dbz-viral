<?php
include('../include/webzone.php');

store_user_data();

echo '<script>top.location.href = "'.$GLOBALS['fb_page_tab_url'].'";</script>';

?>