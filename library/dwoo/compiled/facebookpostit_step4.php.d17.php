<?php
/* template head */
/* end template head */ ob_start(); /* template body */ ?><?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require COMMON_CLASS_DIR.'fbsdk3/src/facebook.php';
require COMMON_CLASS_DIR.'clssocialnetworking.php';
require COMMON_CLASS_DIR.'clsclientsocialmediacontent.php';
require COMMON_CLASS_DIR.'clsclient.php';
//print_r($_SESSION);
$objClientAdmin = new client();
$clientdata = $objClientAdmin->getSuperClientDetail($_SESSION['client_id']);
$company_name = $clientdata['user_company'];

$objsocialnetworking=new socialnetworking();
$socaildata=$objsocialnetworking->fetchvalues($_SESSION['client_id']);

$objShareMessage=new clientsocialmediacontent();
$condition = " AND (".DB_PREFIX."socialmediacontent.client_id='".$_SESSION['client_id']."' OR ".DB_PREFIX."socialmediacontent.client_id='0') ";
$objShareMessage->setAllValues("", $condition);

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => $socaildata[0]['facebook_appId'],
  'secret' => $socaildata[0]['facebook_appsecret'],
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// 	n or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl(	array(
       'scope' => 'publish_stream',
	   'display' => 'popup'
	  ));
}

$result ='';
?>
	
 <?php if ($user){  		
	//$attachment = array('message' => $user_profile['name'].' just registered to vote with Election Impact\'s ('.SERVER_HOST.') online voter registration tool.');
	$fb_message = $objShareMessage->fb_content;
	$fb_message = str_replace("##username##",$user_profile['name'],$fb_message);
	$fb_message = str_replace("##site_url##",SERVER_HOST,$fb_message);
	$fb_message = str_replace("##company_name##",$company_name,$fb_message);
	$attachment = array('message' => $fb_message);
	$result = $facebook->api("/me/feed/",'post', $attachment);	
 ?>
 <script language='javascript'>
	function logoutclose(path)
	{
		setTimeout("window.close()",200);
		document.location.href=path;
	}
 
   logoutclose('<?php echo $logoutUrl; ?>');
 </script>
<?php 
}else{
header("Location: ".$loginUrl);
exit;

}
?>


<script language='javascript'>
function checkmsg()
{
	var msg=document.selectFriend.message.value;
	if(msg.length>2)
	{
		return true;
	}
	else
	{
		alert("Please Enter Message");
		document.selectFriend.message.focus();
		return false;
	}
}	
</script><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>