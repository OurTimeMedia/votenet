<?php
$cmn = new common();
$cmn->chkSiteOfflineClient();

require_once (COMMON_INCLUDE_DIR ."languages.php");

ob_start();
require_once (COMMON_INCLUDE_DIR ."common-js.php");
$header_data = ob_get_contents();
ob_end_clean();

//COMMON TEMPLATE CLASS FOR TEMPLATE FUNCTIONS
$msg = new messagelanguage();
$siteconfig = new siteconfig();

$tmpl = new templates();

if (!defined('SITE_TITLE')) {
	define('SITE_TITLE',$siteconfig->site_config_name);
}

if(!isset($_REQUEST['domain']) && $_REQUEST['domain']=="")
{	
	header("Location:".SERVER_ROOT);
	exit;
}

$contest_id = 0;

$domain = $_REQUEST['domain'];
$pos = strpos($_SERVER['HTTP_HOST'], CURRENT_DOMAIN);
if($pos===false)
{
	$domain = $_SERVER['HTTP_HOST'];
}
else
{ 
	$domain = $_REQUEST['domain'];
}

$objWebsite = new website();
$condition = " AND domain='".$domain."' ";
$client_id = $objWebsite->fieldValue("client_id","",$condition);
$_SESSION['client_id']=$client_id;
if(isset($_SESSION[SESSION_VOTER_PREFIX.SYSTEM_CLIENT_ID]) && $_SESSION[SESSION_VOTER_PREFIX.SYSTEM_CLIENT_ID]!=""  && $_SESSION[SESSION_VOTER_PREFIX.SYSTEM_CLIENT_ID]!=$client_id)
{
	$cmn->logoutAdmin('voter_user');
}

if($client_id==0)
{	
	header("Location:".SERVER_HOST);
	exit;
}

$objWebsite->setAllValues($client_id);

/*
$totVisits = $objWebsite->findVisits();
if((!isset($_SESSION['isVisit'])) || (isset($_SESSION['isVisit']) && $_SESSION['isVisit']!=$objWebsite->client_id))
{
	if($totVisits==0)
	{
		$objWebsite->total_visits = $totVisits+1;
		$objWebsite->addWebsiteVisits();
	}
	else
	{
		$objWebsite->total_visits = $totVisits+1;
		$objWebsite->updateWebsiteVisits();
	}
	$_SESSION['isVisit']=$objWebsite->client_id;
}
*/

$objTemplate = new template();
$objTemplate->setAllValues($objWebsite->template_id);
$site_template_path = $objTemplate->template_folder;

$objEncdec = new encdec();
if(isset($_REQUEST['pid']) && $_REQUEST['pid'] !="")
	$page_id = $objEncdec->decrypt($_REQUEST['pid']);
else
	$page_id = 0;
	
$objWebsitePages = new website_pages();
$objWebsitePages->client_id = $client_id;
$totPageVisits = $objWebsitePages->findPageVisits($page_id);
if((!isset($_SESSION['isVisit_'.$page_id])) || (isset($_SESSION['isVisit_'.$page_id]) && $_SESSION['isVisit_'.$page_id]!=$page_id))
{
	if($totPageVisits==0)
	{
		$objWebsitePages->total_visits = $totPageVisits+1;
		$objWebsitePages->addWebsitePageVisits($page_id);
	}
	else
	{
		$objWebsitePages->total_visits = $totPageVisits+1;
		$objWebsitePages->updateWebsitePageVisits($page_id);
	}
	$_SESSION['isVisit_'.$page_id]=$page_id;
}

if (!defined('SITE_TEMPLATE_DIR')) {
	define('SITE_TEMPLATE_DIR', $site_template_path);
}

if (!defined('SITE_IMAGE_DIR')) {
	define('SITE_IMAGE_DIR', DESIGN_TEMPLATES_DIR.SITE_TEMPLATE_DIR."/images/");
}
?>