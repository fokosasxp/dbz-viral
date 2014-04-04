<?PHP

function parse_signed_request($signed_request,$secret) {
list($encoded_sig,$payload) = explode('.',$signed_request,2);
$sig = base64_url_decode($encoded_sig);
$data = json_decode(base64_url_decode($payload),true);
if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
error_log('Unknown algorithm. Expected HMAC-SHA256');
return null;
}
$expected_sig = hash_hmac('sha256',$payload,$secret,$raw = true);
if ($sig !== $expected_sig) {
error_log('Bad Signed JSON signature!');
return null;
}
return $data;
}
function base64_url_decode($input) {
return base64_decode(strtr($input,'-_','+/'));
}
function userExist($fb_uid)
{
global $db;
$sqlQuery = "SELECT * FROM users WHERE uid = ".$fb_uid;
$result = $db->select($sqlQuery);
if($result){
return $result;
}
return false;
}
function getUserByUid($fb_uid)
{
global $db;
$sqlQuery = "SELECT * FROM users WHERE uid = ".$fb_uid;
return $result = $db->select($sqlQuery);
}
function getUserById($id)
{
global $db;
$sqlQuery = "SELECT * FROM users WHERE id = ".$id;
return $result = $db->select($sqlQuery);
}
function createUser($userArray,$access_token)
{
global $db,$global;
if($userArray)
{
$userObject = array();
$userObject['uid'] = $userArray['id'];
$userObject['name'] = $userArray['name'];
$userObject['email'] = $userArray['email'];
$userObject['access_token'] = $access_token;
$userObject['registered_date'] = date('Y-m-d H:i:s');
$db->insert('users',$userObject);
$newID = $db->insertid();
return $newID;
}
}
function updateUser($option,$id,$uid)
{
global $db;
$where = "id = '".$id."' ";
return $db->update('users',$option,$where);
}
function genRandomString($length = 50) {
$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
$string = '';
for ($p = 0;$p <$length;$p++) {
$string .= $characters[mt_rand(0,strlen($characters)-1)];
}
return $string;
}
function filenameExist($filename)
{
global $db;
$sqlQuery = "SELECT * FROM photos WHERE filename = '".$filename ."'";
$result = $db->select($sqlQuery);
if($result){
return $result;
}
return false;
}
function insertPhoto($photoArray)
{
global $db,$global;
if($photoArray)
{
$userObject = array();
$userObject['user_id'] = $photoArray['user_id'];
$userObject['filename'] = $photoArray['filename'];
$userObject['caption'] = $photoArray['caption'];
$userObject['description'] = $photoArray['description'];
$userObject['version'] = 1;
$userObject['votes'] = 0;
$userObject['upload_time'] = date('Y-m-d H:i:s');
$userObject['version'] = $global['version'];
$db->insert('photos',$userObject);
$newID = $db->insertid();
return $newID;
}
}
function isApproved($id)
{
global $db;
$sqlQuery = "SELECT * FROM photos WHERE id = $id AND approved = 1";
$result = $db->select($sqlQuery);
if($result){
return true;
}
return false;
}
function admin_countAll()
{
global $db,$global;
$sqlQuery = "SELECT * FROM users";
return $db->numrows($sqlQuery);
}
function admin_getUsers($start = -1,$limit = -1)
{
global $db,$global;
if($start <0 &&$limit <0)
$sqlQuery = "SELECT * FROM users WHERE 1";
else
$sqlQuery = "SELECT * FROM users WHERE 1 LIMIT $start, $limit";
return $result = $db->select($sqlQuery);
}
function admin_checkDateTime($data) {
if (date('Y-m-d H:i',strtotime($data)) == $data) {
return true;
}else {
return false;
}
}
function admin_csvexport($query) {
$sql_csv = mysql_query($query) or die("Error: ".mysql_error());
header("Content-type:text/octect-stream");
header("Content-Disposition:attachment;filename=data.csv");
while($row = mysql_fetch_row($sql_csv)) {
print '"'.stripslashes(implode('","',$row)) ."\"\n";
}
exit;
}
function admin_countphotosToApprove()
{
global $db,$global;
$sqlQuery = "SELECT * FROM photos WHERE approved = 0";
return $db->numrows($sqlQuery);
}
function admin_photosToApprove($start = -1,$limit = -1) {
global $db,$global;
if($start <0 &&$limit <0)
$sqlQuery = "SELECT * FROM photos WHERE approved = 0";
else
$sqlQuery = "SELECT * FROM photos WHERE approved = 0 LIMIT $start, $limit";
return $result = $db->select($sqlQuery);
}
function importSettings()
{
global $db,$global;
$sqlQuery = "SELECT * FROM config WHERE 1";
return $result = $db->select($sqlQuery);
}
function getExtension($str) {
$i = strrpos($str,".");
if (!$i) {return "";}
$l = strlen($str) -$i;
$ext = substr($str,$i+1,$l);
return $ext;
}
function square_crop($src_image,$dest_image,$thumb_size = 180,$jpg_quality = 90) {
$image = getimagesize($src_image);
if( $image[0] <= 0 ||$image[1] <= 0 ) return false;
$image['format'] = strtolower(preg_replace('/^.*?\//','',$image['mime']));
switch( $image['format'] ) {
case 'jpg':
case 'jpeg':
$image_data = imagecreatefromjpeg($src_image);
break;
case 'png':
$image_data = imagecreatefrompng($src_image);
break;
case 'gif':
$image_data = imagecreatefromgif($src_image);
break;
default:
return false;
break;
}
if( $image_data == false ) return false;
if( $image[0] >$image[1] ) {
$x_offset = ($image[0] -$image[1]) / 2;
$y_offset = 0;
$square_size = $image[0] -($x_offset * 2);
}else {
$x_offset = 0;
$y_offset = ($image[1] -$image[0]) / 2;
$square_size = $image[1] -($y_offset * 2);
}
$canvas = imagecreatetruecolor($thumb_size,$thumb_size);
if( imagecopyresampled(
$canvas,
$image_data,
0,
0,
$x_offset,
$y_offset,
$thumb_size,
$thumb_size,
$square_size,
$square_size
)) {
switch( strtolower(preg_replace('/^.*\./','',$dest_image)) ) {
case 'jpg':
case 'jpeg':
return imagejpeg($canvas,$dest_image,$jpg_quality);
break;
case 'png':
return imagepng($canvas,$dest_image);
break;
case 'gif':
return imagegif($canvas,$dest_image);
break;
default:
return false;
break;
}
}else {
return false;
}
}
function getPhotosofUser($user_id,$start = -1,$limit = -1)
{
global $db,$global;
if($start <0 &&$limit <0)
$sqlQuery = "SELECT * FROM photos WHERE user_id = $user_id AND version = ".$global['version'];
else
$sqlQuery = "SELECT * FROM photos WHERE user_id = $user_id AND version = ".$global['version'] ." LIMIT $start, $limit";
return $result = $db->select($sqlQuery);
}
function countPhotosofUser($user_id)
{
global $db,$global;
$sqlQuery = "SELECT * FROM photos WHERE user_id = $user_id AND version = ".$global['version'];
return $db->numrows($sqlQuery);
}
function getAllPhotos($start = -1,$limit = -1)
{
global $db,$global;
if($start <0 &&$limit <0)
$sqlQuery = "SELECT * FROM photos WHERE version = ".$global['version'] ." AND approved = 1";
else
$sqlQuery = "SELECT * FROM photos WHERE version = ".$global['version'] ." AND approved = 1 LIMIT $start, $limit";
return $result = $db->select($sqlQuery);
}
function countAllPhotos()
{
global $db,$global;
$sqlQuery = "SELECT * FROM photos WHERE version = ".$global['version'] ." AND approved = 1";
return $db->numrows($sqlQuery);
}
function topPhotos()
{
global $db,$global;
$sqlQuery = "SELECT * FROM photos WHERE version = ".$global['version'] ." AND approved = 1 ORDER BY votes DESC LIMIT 8";
return $result = $db->select($sqlQuery);
}
function hasVoted($pic_id,$user_id)
{
global $db;
$sqlQuery = "SELECT * FROM votes WHERE pic_id = ".$pic_id." AND user_id = ".$user_id;
$result = $db->select($sqlQuery);
if($result){
return $result;
}
return false;
}
function insertVote($voteArray)
{
global $db,$global;
if($voteArray)
{
$userObject = array();
$userObject['user_id'] = $voteArray['user_id'];
$userObject['pic_id'] = $voteArray['pic_id'];
$userObject['vote_time'] = date('Y-m-d H:i:s');
$rows = $db->numrows('SELECT * FROM votes WHERE `user_id`='.$userObject['user_id'] .' AND `pic_id`='.$userObject['pic_id']);
if($rows >0){
return false;
}else{
$db->insert('votes',$userObject);
$newID = $db->insertid();
$photoObject = array();
$photoObject['votes'] = 1;
return $db->increment('photos',$photoObject,'id='.$userObject['pic_id']);
}
}
}
function shortenString($string,$length){
return (strlen($string) >$length) ?substr($string,0,($length-3)).'...': $string;
}
function getPhotoById($id)
{
global $db;
$sqlQuery = "SELECT * FROM photos WHERE id = ".$id;
return $result = $db->select($sqlQuery);
}
function nextPhoto($id)
{
global $db,$global;
$sqlQuery = "SELECT * FROM photos WHERE id > ".$id ." AND version = ".$global['version']." AND approved = 1 ORDER BY id ASC LIMIT 1";
return $result = $db->select($sqlQuery);
}
function prevPhoto($id)
{
global $db,$global;
$sqlQuery = "SELECT * FROM photos WHERE id < ".$id ." AND version = ".$global['version']." AND approved = 1 ORDER BY id DESC LIMIT 1";
return $result = $db->select($sqlQuery);
}
function pagination($page,$photosCount,$limit,$adjacents){
$prev = $page -1;
$next = $page +1;
$lastpage = ceil($photosCount/$limit);
$lpm1 = $lastpage -1;
$pagination = "";
if($lastpage >1)
{
$pagination .= '<div class="pagination" ><ul id="pagination-digg">';
if ($page >1) 
$pagination.= '<li class="previous"><a href="?page='.($page-1) .'">« Previous</a></li>';
else
$pagination.= "";
if ($lastpage <7 +($adjacents * 2))	
{
for ($counter = 1;$counter <= $lastpage;$counter++)
{
if ($counter == $page)
$pagination.= '<li class="active">'.$counter .'</li>';
else
$pagination.= '<li><a href="?page='.$counter .'">'.$counter .'</a></li>';
}
}
elseif($lastpage >5 +($adjacents * 2))	
{
if($page <1 +($adjacents * 2))		
{
for ($counter = 1;$counter <4 +($adjacents * 2);$counter++)
{
if ($counter == $page)
$pagination.= '<li class="active">'.$counter .'</li>';
else
$pagination.= '<li><a href="?page='.$counter .'">'.$counter .'</a></li>';
}
$pagination.= "<li class='blank' >...</li>";
$pagination.= '<li><a href="?page='.$lpm1 .'">'.$lpm1 .'</a></li>';
$pagination.= '<li class="next"><a href="?page='.$lastpage .'">Last »»</a></li>';
}
elseif($lastpage -($adjacents * 2) >$page &&$page >($adjacents * 2))
{
$pagination.= '<li><a href="?page=1">1</a></li>';
$pagination.= '<li><a href="?page=2">2</a></li>';
$pagination.= "<li class='blank' >...</li>";
for ($counter = $page -$adjacents;$counter <= $page +$adjacents;$counter++)
{
if ($counter == $page)
$pagination.= '<li class="active">'.$counter .'</li>';
else
$pagination.= '<li><a href="?page='.$counter .'">'.$counter .'</a></li>';
}
$pagination.= "<li class='blank' >...</li>";
$pagination.= '<li><a href="?page='.$lpm1 .'">'.$lpm1 .'</a></li>';
$pagination.= '<li class="next"><a href="?page='.$lastpage .'">Last »»</a></li>';
}
else
{
$pagination.= '<li><a href="?page=1">1</a></li>';
$pagination.= '<li><a href="?page=2">2</a></li>';
$pagination.= "<li class='blank' >...</li>";
for ($counter = $lastpage -(2 +($adjacents * 2));$counter <= $lastpage;$counter++)
{
if ($counter == $page)
$pagination.= '<li class="active">'.$counter .'</li>';
else
$pagination.= '<li><a href="?page='.$counter .'">'.$counter .'</a></li>';
}
}
}
if ($page <$counter -1) 
$pagination.= '<li class="next"><a href="?page='.$next .'">Next »</a></li>';
else
$pagination.= "";
$pagination.= "</ul></div>";
}
return $pagination;
}
function insertRequest($requestArray)
{
global $db,$global;
if($requestArray)
{
$requestObject = array();
$requestObject['request_id'] = $requestArray['request_id'];
$requestObject['fb_id'] = $requestArray['fb_id'];
$requestObject['photo_id'] = $requestArray['photo_id'];
$db->insert('requests',$requestObject);
$newID = $db->insertid();
return $newID;
}
}

?>