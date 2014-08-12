<?php	
require_once("include/common_includes.php");
$page_id = 1;
require_once("include/general_includes.php");
require_once (COMMON_CLASS_DIR ."clsclient.php");

if (isset($_REQUEST["lng"]))
{
	header("Location: index.php");
	exit;
}	

if(isset($_REQUEST['votingSource']) && $_REQUEST['votingSource'] == "Facebook")
{
	$cmn->setSession('votingSource', "Facebook");
	header("Location: index.php");
	exit;
}
else if(isset($_REQUEST['votingSource']) && $_REQUEST['votingSource'] == "Gadget")
{
	$cmn->setSession('votingSource', "Gadget");
	header("Location: index.php");
	exit;
}


if(isset($_POST['ispreview']) && $_POST['ispreview']==1)
{		
	$_SESSION['isPreview'] = $_POST['ispreview'];
	
	if(isset($_POST['bgColor']) && $_POST['bgColor']!="")
			$_SESSION['bgColor'] = $_POST['bgColor'];	
	else
	{
		if(isset($_SESSION['bgColor']))
			unset($_SESSION['bgColor']);
	}
	
	if(isset($_POST['navBgColor']) && $_POST['navBgColor']!="")
			$_SESSION['navBgColor'] = $_POST['navBgColor'];	
	else
	{
		if(isset($_SESSION['navBgColor']))
			unset($_SESSION['navBgColor']);
	}
	
	if(isset($_POST['navTextColor']) && $_POST['navTextColor']!="")
			$_SESSION['navTextColor'] = $_POST['navTextColor'];	
	else
	{
		if(isset($_SESSION['navTextColor']))
			unset($_SESSION['navTextColor']);
	}
	
	if(isset($_POST['HideBanner']) && $_POST['HideBanner']!="")
			$_SESSION['HideBanner'] = $_POST['HideBanner'];	
	else
	{
		$_SESSION['HideBanner'] = 0;	
	}
	
	if(isset($_POST['HideTopNavigation']) && $_POST['HideTopNavigation']!="")
			$_SESSION['HideTopNavigation'] = $_POST['HideTopNavigation'];	
	else
	{
		$_SESSION['HideTopNavigation'] = 0;	
	}
	
	if(isset($_POST['HideRegistrationStep']) && $_POST['HideRegistrationStep']!="")
			$_SESSION['HideRegistrationStep'] = $_POST['HideRegistrationStep'];	
	else
	{
		$_SESSION['HideRegistrationStep'] = 0;	
	}
	
	
	if(isset($_POST['previewform']) && $_POST['previewform']!="")
	{
		$_SESSION['previewform'] = 1;	
		
		$cmn->setSession('Home_State_ID', "5");
		$cmn->setSession('Home_State', "California");
		$cmn->setSession('voter_email', "demo@votenet.com");
			
		header("Location: registrationform1.php");
		exit;			
	}		
	else
	{
		if(isset($_SESSION['previewform']))
			unset($_SESSION['previewform']);
	}
	
	if(isset($_POST['bgImage']) && $_POST['bgImage']!="")
	{
			//$bgImage = BACKGROUND_IMAGE_DIR_S3."tmp_bgImage_".$objWebsite->client_id.".jpg";
			$bgImage = SERVER_HOST.BACKGROUND_IMAGE."tmp_bgImage_".$objWebsite->client_id.".jpg";
			$_SESSION['bgImage'] = $bgImage;
	}		
	else
	{
		if(isset($_SESSION['bgImage']))
			unset($_SESSION['bgImage']);
	}
	
	if(isset($_POST['bannerImage']) && $_POST['bannerImage']!="")
	{
		//$bannerImage = BANNER_DIR_S3."tmp_bannerImage_".$objWebsite->client_id.".jpg";
		$bannerImage = SERVER_HOST.BANNER_IMAGE."tmp_bannerImage_".$objWebsite->client_id.".jpg";
		$_SESSION['bannerImage'] = $bannerImage;
	}	
	else
	{
		if(isset($_SESSION['bannerImage']))
			unset($_SESSION['bannerImage']);
	}
	
	$msg->clearMsg();
	header("Location: index.php");
	exit;
}

$data = array();
$data = $tmpl->get_ragister_form_language($data);
$data['header_data'] = $header_data;
$data['value_email'] = "";
$data['value_zipcode'] = "";
$data['value_state'] = "";

if((isset($_POST['btnContinue']) && $_POST['btnContinue'] != "") || (isset($_POST['btnContinue_x']) && $_POST['btnContinue_x'] != "") )
{
	$cmn->removeSession('Home_State_ID');
	$cmn->removeSession('Home_State');
	$cmn->removeSession('Home_ZipCode');
	$cmn->removeSession('voter_email');
	
	$data['value_email'] = $_POST['Email'];
	
	if(isset($_POST['ZipCode']))	
		$data['value_zipcode'] = $_POST['ZipCode'];
		
	if(isset($_POST['state']))	
		$data['value_state'] = $_POST['state'];
	
	require_once (COMMON_CLASS_DIR ."clsvalidationlang.php");
	$objvalidation = new validationlang();
	$objvalidation->addValidation("Email", LANG_EMAIL, "req");
	$objvalidation->addValidation("Email", LANG_EMAIL, "email");
	
	if(!((isset($_REQUEST['ZipCode']) && strlen($_REQUEST['ZipCode']) != 5) || (isset($_REQUEST['state']) && strlen($_REQUEST['state'])>0)))
	{		
		$objvalidation->addValidation("ZipCode", "Zip Code or State", "req");
	}
	
	if ($objvalidation->validate())
	{
		$objState=new state();
		if(isset($_REQUEST['ZipCode']) && strlen($_REQUEST['ZipCode'])>1)
		{
			$condition = " and ".DB_PREFIX."state_zipcode.zip_code=".$_REQUEST['ZipCode'];
			$homestate = $objState->findhomestate($condition);
			if(count($homestate) > 0)
			{
				$condition = "  and ".DB_PREFIX."state.state_id=".$homestate[0]['state_id'];
				$statedetail = $objState->fetchAllAsArrayLanguage($_REQUEST['languageopt'],$condition);
				
				$cmn->setSession('Home_State_ID', $statedetail[0]['state_id']);
				$cmn->setSession('Home_State', $statedetail[0]['state_name']);
				$cmn->setSession('Home_ZipCode', $_REQUEST['ZipCode']);	
				$cmn->setSession('voter_email', $_POST['Email']);	
				header("Location: registrationform1.php");
				exit;
			}	
			else
			{		
				$msg->sendMsg("index.php","Zipcode ",109);		
			}	
			
		}
		if(isset($_REQUEST['state']) && $_REQUEST['state'] != "")
		{
			$condition = "  and ".DB_PREFIX."state.state_id=".$_REQUEST['state'];
			$statedetail = $objState->fetchAllAsArrayLanguage($_REQUEST['languageopt'],$condition);

			$cmn->setSession('Home_State_ID', $statedetail[0]['state_id']);
			$cmn->setSession('Home_State', $statedetail[0]['state_name']);
			$cmn->setSession('voter_email', $_POST['Email']);
			
			header("Location: registrationform1.php");
			exit;
		}
	}
}

// set up auto-loader
include DWOO_DIR . 'dwooAutoload.php';

if(isset($_SESSION['isPreview']) && $_SESSION['isPreview'] == 1)
	$template_file = DESIGN_TEMPLATES_DIR.SITE_TEMPLATE_DIR."/indexpreview.tpl";
else
	$template_file = DESIGN_TEMPLATES_DIR.SITE_TEMPLATE_DIR."/index.tpl";

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
$data['main_menu'] = 0;
$data['client_id'] = $objWebsite->client_id;
$data['hide_banner'] = $objWebsite->hide_banner;
$data['hide_navigation'] = $objWebsite->hide_navigation;
$data['hide_steps'] = $objWebsite->hide_steps;

if($objWebsite->background_color != "")
	$data['background_color'] = $objWebsite->background_color;
	
if($objWebsite->top_nav_background_color != "")
	$data['nav_background_color'] = $objWebsite->top_nav_background_color;
	
if($objWebsite->top_nav_text_color != "")
	$data['nav_text_color'] = $objWebsite->top_nav_text_color;	
	
if($objWebsite->background_image != "")
	$data['background_image'] = SERVER_HOST.BACKGROUND_IMAGE.$objWebsite->background_image;
	//$data['background_image'] = BACKGROUND_IMAGE_DIR_S3.$objWebsite->background_image;

if($objWebsite->banner_image != "")
	$data['banner_image'] = SERVER_HOST.BANNER_IMAGE.$objWebsite->banner_image;
	//$data['banner_image'] = BANNER_DIR_S3.$objWebsite->banner_image;

if(isset($_SESSION['bgColor']) && $_SESSION['bgColor'] != "")
{
	$data['background_color'] = $_SESSION['bgColor'];
	unset($data['background_image']);
}

if(isset($_SESSION['navBgColor']) && $_SESSION['navBgColor'] != "")
{
	$data['nav_background_color'] = $_SESSION['navBgColor'];	
}

if(isset($_SESSION['navTextColor']) && $_SESSION['navTextColor'] != "")
{
	$data['nav_text_color'] = $_SESSION['navTextColor'];
}

if(isset($_SESSION['HideBanner']))
{
	$data['hide_banner'] = $_SESSION['HideBanner'];
}

if(isset($_SESSION['HideTopNavigation']))
{
	$data['hide_navigation'] = $_SESSION['HideTopNavigation'];
}

if(isset($_SESSION['HideRegistrationStep']))
{
	$data['hide_steps'] = $_SESSION['HideRegistrationStep'];
}

if(isset($_SESSION['bgImage']) && $_SESSION['bgImage'] != "")
{
	$data['background_image'] = $_SESSION['bgImage'];
	unset($data['background_color']);
}

if(isset($_SESSION['bannerImage']) && $_SESSION['bannerImage'] != "")
{
	$data['banner_image'] = $_SESSION['bannerImage'];	
}
if(!isset($data['banner_image']))
{
	$data['hide_banner'] = 1;
}

$data = $tmpl->get_site_array($data); 
$data['islanguage'] = 0;

require_once (COMMON_CLASS_DIR ."clscreate_client_sponsors.php");

$objClientSponsors = new create_client_sponsors();
$condition = " AND ".DB_PREFIX."sponsors.client_id='".$objWebsite->client_id."' ";
$orderby = "sponsors_id asc";
$aSponsorsDetail = $objClientSponsors->fetchAllAsArraySponsors("","",$condition,$orderby);

$data['site_domain_link'] = "https://".$_SERVER['HTTP_HOST']; 
$data['sponsers'] = $tmpl->get_sponsers_array($aSponsorsDetail); 
$data['issponsers'] = 0;
if(count($data['sponsers'])>0)
{
	$data['issponsers']=1;
}

$data['submit_form'] = $_SERVER['REQUEST_URI'];

$data['err_msg'] = "";
$data['unsetErrorMsg'] = 0;

if(isset($_SESSION['err']))
{	
	$data['err_msg'] = str_replace("##imgpath##",BASE_DIR,stripslashes($_SESSION['err']));
	$data['unsetErrorMsg'] = 1;
	$msg->clearMsg();
}

$language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
require_once (COMMON_CLASS_DIR ."clsstate.php");
$objState=new state();
$condState= " and state_active = 1 ";
$objState->language_id = $language_id;
$statedata=$objState->fetchAllAsArrayFront('',$condState,'state_name');
$stateoption='';
for($k=0;$k<count($statedata);$k++)
{
	if(isset($_POST['state']) && $_POST['state'] == $statedata[$k]['state_name'])
		$stateoption .= "<option value='".$statedata[$k]['state_id']."' selected>".$statedata[$k]['state_name']."</option>"; 
	else	
		$stateoption .= "<option value='".$statedata[$k]['state_id']."'>".$statedata[$k]['state_name']."</option>"; 
}

$data['statedata']=$stateoption;

$formavali_language=$objWebsite->fetchlanguagedetail($client_id);

$objClient=new client();
$languages = $objClient->fetchClientLanguages($client_id);

$language_arr = array();
$language_arr = explode(",",$languages);

$data['language_preference_hide']="0";
if(count($language_arr) > 1)
{
	$sqr = "<select name='languageopt' id='languageopt' class='from-input' onChange='this.form.submit();'>";
	for($q=0;$q<count($formavali_language);$q++)
	{
		if(in_array($formavali_language[$q]['language_id'], $language_arr))
		{
			if($language_id == $formavali_language[$q]['language_id'])
				$sqr.='<option value="'.$formavali_language[$q]['language_id'].'" selected>'.$formavali_language[$q]['language_name']."</option>";		
			else
				$sqr.='<option value="'.$formavali_language[$q]['language_id'].'">'.$formavali_language[$q]['language_name']."</option>";		
		}	
	}

	$sqr.= "</select>";
}
else
{
	$sqr = "<input type='hidden' id='languageopt' name='languageopt' value='".$language_arr[0]."'>";
	
	$data['language_preference_hide']="1";
}	

$data['language_preference']=$sqr;

$sqr='<input type="radio" checked="checked" name="languageopt1" value="RegisterToVote"  />&nbsp;Register to vote';

$data['national_form_language_option']=$sqr;

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