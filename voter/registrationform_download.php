<?php	
require_once("include/common_includes.php");
$page_id = 4;
require_once("include/general_includes.php");

if (isset($_REQUEST["lng"]))
{
	header("Location: index.php");
	exit;
}	

if ($cmn->getSession('Home_State_ID') == "")
{
	header("location: index.php");
	exit;
}

if(!empty($_POST['btnsubmit1']) || !empty($_POST['btnsubmit1_x']) || !empty($_POST['btnsubmit_email'])) {

} else
{
    header("Location: index.php");
    exit;
}

// set up auto-loader
include DWOO_DIR . 'dwooAutoload.php';

$template_file = DESIGN_TEMPLATES_DIR.SITE_TEMPLATE_DIR."/registrationform_download.tpl";

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
$data['main_menu'] = 0;
$data['header_data'] = $header_data;
$data = $tmpl->get_ragister_form_language($data);
$data['hide_banner'] = $objWebsite->hide_banner;
$data['hide_navigation'] = $objWebsite->hide_navigation;
$data['hide_steps'] = $objWebsite->hide_steps;
$data['client_id'] = $objWebsite->client_id;

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