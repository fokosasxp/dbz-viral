<?php
include('../include/webzone.php');
unset($_SESSION['ygp_fb_box']);
echo '<script>top.location.href = "'.$GLOBALS['fb_page_tab_url'].'";</script>';
?>