<?php
//$domain = findDomainName();
$domain = 'ourtime';
$objWebsite = new website();
$condition = " AND domain='".$domain."' ";
$client_id = $objWebsite->fieldValue("client_id","",$condition);

require_once (COMMON_CLASS_DIR ."clsclient.php");
$objClientAdmin = new client();
$clientdata = $objClientAdmin->getSuperClientDetail($client_id);
$company_name = $clientdata['user_company'];

require_once (COMMON_CLASS_DIR ."clsclientsocialmediacontent.php");
$objShareMessage=new clientsocialmediacontent();
$condition = " AND (".DB_PREFIX."socialmediacontent.client_id='".$client_id."' OR ".DB_PREFIX."socialmediacontent.client_id='0') ";
$objShareMessage->setAllValues("", $condition);

$google_desc = str_replace("##site_url##",SERVER_HOST,$objShareMessage->google_content);
$google_desc = str_replace("##company_name##",$company_name,$google_desc);
echo "<meta property=\"og:title\" content=\"".$objShareMessage->google_title."\"/>
<meta property=\"og:description\" content=\"".$google_desc."\"/>";
?>