<?php
include('../include/webzone.php');

$f1 = new Fb_ypbox();
$f1->fb_connect_flow(array('current_url'=>$GLOBALS['fb_page_tab_url']));

?>