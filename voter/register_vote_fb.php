<?php
session_start();
require_once("include/common_includes.php");
require_once '../client/include/facebook-platform/src/facebook.php'; 
$cmn = new common();

$api_key = '234813906622727';
$api_secret_key = 'e4090273b465dfd939d8a87560b71f65';

$facebook = new Facebook(array(
  'appId'  => $api_key,
  'secret' => $api_secret_key
));


$signed_request = $facebook->getSignedRequest();
$user = $facebook->getUser();

if (isset($signed_request['page']['liked']) && $signed_request['page']['liked'] != "") 
{
	$fb_client_id = 0;
	$condition = " AND page_id = '".$signed_request['page']['id']."'";
	$objFBClient = new facebookclient();
	$client_id = $objFBClient->fieldValue("client_id", "", $condition);

	$objWebsite = new website();
	$objWebsite->setAllValues($client_id);

	if($objWebsite->is_subdomain == 1)
		$voting_url = "https://".$objWebsite->domain."/index.php?votingSource=Facebook";
	else
		$voting_url = "https://".$objWebsite->domain.".".SITE_DOMAIN_NAME."/index.php?votingSource=Facebook";
	
	header("location: ".$voting_url);
	exit;
}
else { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<table border="0" width="100%">
									<tr>
									<td width="100%" align="center">
<img src="images/like-banner.jpg" border="0">
</td>
</tr>
</table>
<?php }
?>