<?php 
require_once("include/common_includes.php");
require COMMON_CLASS_DIR.'clssocialnetworking.php';
require COMMON_CLASS_DIR.'clsclientsocialmediacontent.php';
require COMMON_CLASS_DIR.'clsclient.php';

$objClientAdmin = new client();
$clientdata = $objClientAdmin->getSuperClientDetail($_SESSION['client_id']);
$company_name = $clientdata['user_company'];

$objsocialnetworking=new socialnetworking();
$socaildata=$objsocialnetworking->fetchvalues($_SESSION['client_id']);

$objShareMessage=new clientsocialmediacontent();
$condition = " AND (".DB_PREFIX."socialmediacontent.client_id='".$_SESSION['client_id']."' OR ".DB_PREFIX."socialmediacontent.client_id='0') ";
$objShareMessage->setAllValues("", $condition);

include COMMON_CLASS_DIR.'lib/EpiCurl.php';
include COMMON_CLASS_DIR.'lib/EpiOAuth.php';
include COMMON_CLASS_DIR.'lib/EpiTwitter.php';
include COMMON_CLASS_DIR.'lib/secret.php';

$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
$oauth_token = $_GET['oauth_token'];

if($oauth_token == '')
{ 
	$twitterObj->setCallback($_REQUEST['callback']."twitter.php");
	$url = $twitterObj->getAuthorizationUrl();
	header("Location: ".$url);
	exit;
} 
if(isset($_POST['submit']) || isset($_POST['submit_x']))
{
	$msg = $_REQUEST['tweet'];

	$twitterObj->setToken($_SESSION['ot'], $_SESSION['ots']);
	$update_status = $twitterObj->post_statusesUpdate(array('status' => $msg));
	$temp = $update_status->response;
	
	echo "<div align='center'>Updated your Timeline Successfully.</div>";
	echo "<script language='javascript'>window.close();</script>";
}
else
{
	$twitterObj->setToken($_GET['oauth_token']);
	$token = $twitterObj->getAccessToken();
	$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);	  	
	$_SESSION['ot'] = $token->oauth_token;
	$_SESSION['ots'] = $token->oauth_token_secret;
	$twitterInfo= $twitterObj->get_accountVerify_credentials();

	$usernametweet = $twitterInfo->screen_name;
	$profilepic = $twitterInfo->profile_image_url;
	
	$twitter_message = $objShareMessage->tw_content;
	$twitter_message = str_replace("##username##",$usernametweet,$twitter_message);
	$twitter_message = str_replace("##site_url##",SERVER_HOST,$twitter_message);
	$twitter_message = str_replace("##company_name##",$company_name,$twitter_message);
	
	$twitterObj->setToken($_SESSION['ot'], $_SESSION['ots']);
	$update_status = $twitterObj->post_statusesUpdate(array('status' => $twitter_message));
	$temp = $update_status->response;
	
	echo "<div align='center'>Updated your Timeline Successfully.</div>";
	echo "<script language='javascript'>window.close();</script>";
}	
?> 
<script type="text/javascript">
$(document).ready(function()
{
$("#tweet").keyup(function()
{
var box=$(this).val();
var main = box.length *100;
var value= (main / 140);
var count= 140 - box.length;

if(box.length <= 140)
{
$('#count').html(count);
$('#bar').animate(
{
"width": value+'%',
}, 1);
}
else
{
alert('Character Limit Exceeded!');

;
}
return false;
});

});
</script>