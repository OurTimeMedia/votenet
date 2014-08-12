<?php
if (isset($_REQUEST['btn_setDomain']))
{	
	$rdoisprivate_domain = $_REQUEST['rdoisprivate_domain'];
	
	$objvalidation = new validation();
	
	$objvalidation->addValidation("rdoisprivate_domain", "Domain Type", "selone");
	$objvalidation->addValidation("txtdomain", "Domain Name", "req");
	$objvalidation->addValidation("txtdomain", "Domain Name", "dupli" , "",DB_PREFIX."website|domain|client_id|".$client_id."|1|1");
	
	if ($objvalidation->validate())
	{	
		//Code to assign value of control to all property of object.
		$objWebsite->is_subdomain = $cmn->setVal(trim($cmn->readValueSubmission($_POST["rdoisprivate_domain"],0)));
		
		if($objWebsite->is_subdomain == 1)
		{
			$objWebsite->hide_steps = 1;
			$objWebsite->is_sharing = 0;		
		}
		
		$objWebsite->domain = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtdomain"],"")));
		$objWebsite->updated_by = $cmn->getSession(ADMIN_USER_ID);
		$objWebsite->update();
		
		$msg->sendMsg("website_templates.php","Domain ",4);
		exit;
	}
}
else if (isset($_REQUEST['btnTemplate']))
{	
	$objvalidation = new validation();
	
	if ($objvalidation->validate())
	{	
		$objWebsite->background_color = "";
		$objWebsite->background_image = "";
		
		$objWebsite->hide_navigation = $cmn->setVal(trim($cmn->readValue($_POST["chkHideTopNavigation"],"0")));
		$objWebsite->hide_banner = $cmn->setVal(trim($cmn->readValue($_POST["chkHideBanner"],"0")));
		$objWebsite->hide_steps = $cmn->setVal(trim($cmn->readValue($_POST["chkRegistrationStep"],"0")));
		
		if($objWebsite->hide_navigation == 1)
		{
			$objWebsite->top_nav_background_color = "AE030C";
			$objWebsite->top_nav_text_color = "FFFFFF";
		}
		else
		{
			$objWebsite->top_nav_background_color = $cmn->setVal(trim($cmn->readValue($_POST["txtTopNavBackgroundColor"],"")));
			$objWebsite->top_nav_text_color = $cmn->setVal(trim($cmn->readValue($_POST["txtTopNavTextColor"],"")));
		}	
		
		if(isset($_POST['rdobackground_type']) && $_POST['rdobackground_type']==1)
		{
			$objWebsite->background_color = $cmn->setVal(trim($cmn->readValue($_POST["txtBackgroundColor"],"")));
		}
		else if(isset($_POST['rdobackground_type']) && $_POST['rdobackground_type']==2)
		{	
			$objWebsite->uploadTemplateBackgroundImage();
		}
		
		if($objWebsite->hide_banner == 1)
		{	
			$objWebsite->deleteTemplateBannerImage();			
		}
		else
		{
			if(isset($_FILES['filBannerImage']) && !empty($_FILES['filBannerImage']))
			{
				$objWebsite->uploadTemplateBannerImage();
			}
		}	
		
		$objWebsite->background_type = $cmn->setVal(trim($cmn->readValue($_POST["rdobackground_type"],0)));
		$objWebsite->updated_by = $cmn->getSession(ADMIN_USER_ID);
		
		$objWebsite->update();
		
		$msg->sendMsg("website_templates.php","Templates ",4);
		exit;
	}
}
else if (isset($_REQUEST['btnShare']))
{	
	$objvalidation = new validation();
	
	if ($objvalidation->validate())
	{	
		$objWebsite->is_sharing = 1;
		if(isset($_POST['chkSharingEnable']))
		{
			$objWebsite->is_sharing = $cmn->setVal(trim($cmn->readValue($_POST["chkSharingEnable"],"")));
		}
		
		if(isset($_POST['chkRedirectURL']))
		{
			if(isset($_POST['txtRedirectURL']) && $_POST['txtRedirectURL'] != "")
				$objWebsite->sharing_redirect_url = $cmn->setVal(trim($cmn->readValue($_POST["txtRedirectURL"],"")));
			else
				$objWebsite->sharing_redirect_url = "";
		}
		else
			$objWebsite->sharing_redirect_url = "";
				
		$objWebsite->updated_by = $cmn->getSession(ADMIN_USER_ID);
		
		$objWebsite->update();
		
		$msg->sendMsg("website_templates.php","Templates ",4);
		exit;
	}
}
else if (isset($_REQUEST['btnSponsor']))
{	
	$objvalidation = new validation();
	
	$sponsors_id = intval($objEncDec->decrypt($_REQUEST["hdnsponsors_id"]));
	
	if (trim($_POST['hdnmode_S']) == 'edit' && !empty($_POST['hdnsponsors_id']))
	{	
		$objSponsors->setAllValuesSponsors($sponsors_id);		
	}
	
	$objvalidation->addValidation("txtsponsors_name", "Sponsor Name", "req");
	$objvalidation->addValidation("txtsponsors_logo", "Logo", "req");
	$objvalidation->addValidation("txtsponsors_website", "Website", "req");
	
	$uploadFlag = $objSponsors->uploadSponsorsLogo();

	if (!$uploadFlag) 
	{
		$_SESSION['err'] = "<div class='errror-message' style='color:red;margin-left:30px;'>There is an error in logo upload</div>";
	
	}
	
	if ($objvalidation->validate() && $uploadFlag)
	{	
		include_once "website_sponsors_addedit_field.php";	
		
		if (trim($_POST['hdnmode_S']) == ADD)
		{
			$objSponsors->addSponsorsInformation();			
			$msg->sendMsg("website_templates.php#Sp","Sponsor ",3);
			exit;			
		}
	
		//Code to edit record
		if (trim($_POST['hdnmode_S']) == 'edit' && !empty($_POST['hdnsponsors_id']))
		{	
			$objSponsors->updateSponsorsInformation();
			$msg->sendMsg("website_templates.php#Sp","Sponsor ",4);
			exit;
		}
		
		
	}
}
else if (isset($_REQUEST['act']) && $_REQUEST['act'] == "delbg")
{	
	$objWebsite->deleteTemplateBackgroundImage();
	$msg->sendMsg("website_templates.php","Templates ",4);
	exit;
}
else if (isset($_REQUEST['act']) && $_REQUEST['act'] == "delbanner")
{	
	$objWebsite->deleteTemplateBannerImage();
	$msg->sendMsg("website_templates.php","Templates ",4);
	exit;
}
?>