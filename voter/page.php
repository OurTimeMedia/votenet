<?php	
require_once("include/common_includes.php");
require_once("include/general_includes.php");
require_once (COMMON_CLASS_DIR ."clsencdec.php");
$objEncdec = new encdec();

require_once (COMMON_CLASS_DIR ."clswebsite_pages.php");
$objWebsitePages = new website_pages();

if(isset($_REQUEST['pid']) && $_REQUEST['pid'] !="")
{
	$page_id = $objEncdec->decrypt($_REQUEST['pid']);
	$objWebsitePages->setAllValues($page_id);	
}
else 
{
	header("Location: index.php");
	exit;
}	

if($objWebsitePages->page_type == 1)
{
	header("Location: ".$objWebsitePages->page_link);
	exit;
}

// set up auto-loader
include DWOO_DIR . 'dwooAutoload.php';
$template_file = DESIGN_TEMPLATES_DIR.SITE_TEMPLATE_DIR."/page.tpl";
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

// assign values to template variables
$data = array();
$data['header_data'] = $header_data;
$data['main_menu'] = 0;
$data['client_id'] = $objWebsite->client_id;

if($objWebsite->background_color != "")
	$data['background_color'] = $objWebsite->background_color;
	
if($objWebsite->background_image != "")
	$data['background_image'] = SERVER_HOST.BACKGROUND_IMAGE.$objWebsite->background_image;
	//$data['background_image'] = BACKGROUND_IMAGE_DIR_S3.$objWebsite->background_image;

if($objWebsite->banner_image != "")
	$data['banner_image'] = SERVER_HOST.BANNER_IMAGE.$objWebsite->banner_image;
	//$data['banner_image'] = BANNER_DIR_S3.$objWebsite->banner_image;

$data = $tmpl->get_site_array($data); 
$data['islanguage'] = 0;
$data['page_detail'] = html_entity_decode(nl2br($objWebsitePages->page_content));

require_once (COMMON_CLASS_DIR ."clscreate_client_sponsors.php");

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

$data['submit_form'] = $_SERVER['REQUEST_URI'];
$data['Voting_Source'] = "Website";

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