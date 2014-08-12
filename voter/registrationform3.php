<?php	
require_once("include/common_includes.php");
$page_id = 5;
require_once("include/general_includes.php");

if (isset($_REQUEST["lng"]))
{
	header("Location: index.php");
	exit;
}	

// set up auto-loader
include DWOO_DIR . 'dwooAutoload.php';

$template_file = DESIGN_TEMPLATES_DIR.SITE_TEMPLATE_DIR."/registrationform3.tpl";

// create Dwoo object
$dwoo = new Dwoo();

// read template file
$tpl = new Dwoo_Template_File($template_file);

if(!empty($_SESSION["err"]))
{
	// Set red border for error fields
	if(isset($_SESSION["err_fields"]))
	{
		$err_fields = split("\|", $_SESSION["err_fields"]);
		unset($_SESSION["err_fields"]);
		for ($i=0;$i<count($err_fields);$i++)
		{
			$err_fields[$i] = "class_".$err_fields[$i];
			$$err_fields[$i] = "input-red-border";
		}
	}
	
}

	$extraJs = array("thickbox.js");
// assign values to template variables
$data = array();
$data['main_menu'] = 0;
$data['header_data'] = $header_data;
$data = $tmpl->get_ragister_form_language($data);
$data['client_id'] = $objWebsite->client_id;
$data['hide_banner'] = $objWebsite->hide_banner;
$data['hide_navigation'] = $objWebsite->hide_navigation;
$data['hide_steps'] = $objWebsite->hide_steps;

if($objWebsite->background_color != "")
	$data['background_color'] = $objWebsite->background_color;
	
if($objWebsite->background_image != "")
	$data['background_image'] = SERVER_HOST.BACKGROUND_IMAGE.$objWebsite->background_image;
	//$data['background_image'] = BACKGROUND_IMAGE_DIR_S3.$objWebsite->background_image;

if($objWebsite->banner_image != "")
	$data['banner_image'] = SERVER_HOST.BANNER_IMAGE.$objWebsite->banner_image;
	//$data['banner_image'] = BANNER_DIR_S3.$objWebsite->banner_image;

if($objWebsite->top_nav_background_color != "")
	$data['nav_background_color'] = $objWebsite->top_nav_background_color;
	
if($objWebsite->top_nav_text_color != "")
	$data['nav_text_color'] = $objWebsite->top_nav_text_color;	
	
if(!isset($data['banner_image']))
{
	$data['hide_banner'] = 1;
}
	
$data = $tmpl->get_site_array($data); 
$data['islanguage'] = 0;

require_once (COMMON_CLASS_DIR ."clscreate_client_sponsors.php");
require_once (COMMON_CLASS_DIR ."clsclientsocialmediacontent.php");
require_once (COMMON_CLASS_DIR ."clsclient.php");

$objClientSponsors = new create_client_sponsors();
$condition = " AND ".DB_PREFIX."sponsors.client_id='".$objWebsite->client_id."' ";
$orderby = "sponsors_id asc";
$aSponsorsDetail = $objClientSponsors->fetchAllAsArraySponsors("","",$condition,$orderby);

$data['sponsers'] = $tmpl->get_sponsers_array($aSponsorsDetail); 
$data['issponsers'] = 0;
if(count($data['sponsers'])>0)
{
	$data['issponsers']=1;
}

$objShareMessage=new clientsocialmediacontent();
$condition = " AND (".DB_PREFIX."socialmediacontent.client_id='".$objWebsite->client_id."' OR ".DB_PREFIX."socialmediacontent.client_id='0') ";
$objShareMessage->setAllValues("", $condition);

$objClientAdmin = new client();
$clientdata = $objClientAdmin->getSuperClientDetail($objWebsite->client_id);
$company_name = $clientdata['user_company'];

$tumblr_content = str_replace("##site_url##",SERVER_HOST,$objShareMessage->tumblr_content);
$tumblr_content = str_replace("##company_name##",$company_name,$tumblr_content);

$data['tumblr_string'] = "<a href=\"http://www.tumblr.com/share/link?url=".urlencode(SERVER_HOST)."&name=".urlencode($objShareMessage->tumblr_title)."&description=".urlencode($tumblr_content)."\" title=".urlencode("'".$objShareMessage->tumblr_title."'")."\" style=\"display:inline-block; text-indent:-9999px; overflow:hidden; width:81px; height:20px; background:url('".SERVER_HOST."images/share_1.png') top left no-repeat transparent;\">Share on Tumblr</a>";

$data['submit_form'] = $_SERVER['REQUEST_URI'];
$data['Voting_Source'] = "Website";

$data['mobile_device'] = ismobile();

if ($cmn->getSession('votingSource') == "Facebook")
{
	$data['Voting_Source'] = "Facebook";
	$data['issponsers'] = 0;
}
//________________ End ________________//
// interpolate values into template
// send interpolated result to output device
$dwoo->output($tpl, $data);
?>
