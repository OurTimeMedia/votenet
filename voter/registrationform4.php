<?php	
require_once("include/common_includes.php");
require_once("include/general_includes.php");

if (isset($_REQUEST["lng"]))
{
	header("Location: index.php");
	exit;
}	

// set up auto-loader
include DWOO_DIR . 'dwooAutoload.php';

$template_file = DESIGN_TEMPLATES_DIR.SITE_TEMPLATE_DIR."/registrationform4.tpl";

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
$data['client_id'] = $objWebsite->client_id;

$data = $tmpl->get_site_array($data); 
$data['islanguage'] = 0;

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
