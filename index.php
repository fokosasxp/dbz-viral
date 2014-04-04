<?PHP

require_once('includes/config.php');
if(empty($_REQUEST["signed_request"])) {
if (isset($_GET['request_ids'])) {
header ('Location: '.$global['app_link'] .'&app_data=req'.$_GET['request_ids']);
exit;
}else{
if(isset($_GET['app_data'])){
header ('Location: '.$global['app_link'] .'&app_data='.$_GET['app_data']);
}else{
header ('Location: '.$global['app_link']);
}
exit;
}
echo "this page was not accessed through a Facebook page tab";
}else {
$data = parse_signed_request($_REQUEST["signed_request"],$global['app_secret']);
if( !isset($data["page"]) ){
if (isset($_GET['request_ids'])){
echo "<script>top.location.href = '".$global['app_link'] ."&app_data=req".$_GET['request_ids'] ."';</script>";
}else{
echo "<script>top.location.href = '".$global['app_link'] ."';</script>";
}
exit();
}
if (empty($data["page"]["liked"])) {
;echo '<div style="position:absolute;top:0;"><img src="images/landing.jpg" /></div>';
}else {
require_once('includes/auth.php');
echo "<script>self.location.href = 'home.php';</script>";
exit();
}
}
;
?>