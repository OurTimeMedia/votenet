<?php
require_once("include/common_includes.php");
$cmn = new common();
$objEncDec = new encdec();
$client_id = $objEncDec->decrypt($_REQUEST['user']);	

$objWebsite = new website();
$objWebsite->setAllValues($client_id);

if($objWebsite->is_subdomain == 1)
	$voting_url = "http://".$objWebsite->domain."/?votingSource=Gadget";
else
	$voting_url = "http://".$objWebsite->domain.".".SITE_DOMAIN_NAME."/?votingSource=Gadget";

header("location: ".$voting_url);
exit;
?>