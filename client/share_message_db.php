<?php
if ( isset($_REQUEST['btnSave']))
{	
	$objvalidation = new validation();
	
	$objclientsocialmediacontent->client_id = $cmn->setVal(trim($cmn->readValueSubmission($_POST["client_id"],"")));
	$objclientsocialmediacontent->fb_content = $cmn->setVal(trim($cmn->readValueSubmission($objclientsocialmediacontent->fb_content,"")));
	$objclientsocialmediacontent->tw_content = $cmn->setVal(trim($cmn->readValueSubmission($objclientsocialmediacontent->tw_content,"")));
	$objclientsocialmediacontent->google_title = $cmn->setVal(trim($cmn->readValueSubmission($objclientsocialmediacontent->google_title,"")));
	$objclientsocialmediacontent->google_content = $cmn->setVal(trim($cmn->readValueSubmission($objclientsocialmediacontent->google_content,"")));
	$objclientsocialmediacontent->tumblr_title = $cmn->setVal(trim($cmn->readValueSubmission($objclientsocialmediacontent->tumblr_title,"")));
	$objclientsocialmediacontent->tumblr_content = $cmn->setVal(trim($cmn->readValueSubmission($objclientsocialmediacontent->tumblr_content,"")));
	
	if($_REQUEST['currentshow']==1)
	{
		$objvalidation->addValidation("fcontent", "Facebook Message ", "req");				
		$objclientsocialmediacontent->fb_content = $cmn->setVal(trim($cmn->readValueSubmission($_POST["fcontent"],"")));
	}
	else if($_REQUEST['currentshow']==2)
	{
		$objvalidation->addValidation("tcontent", "Twitter Message ", "req");
		$objclientsocialmediacontent->tw_content = $cmn->setVal(trim($cmn->readValueSubmission($_POST["tcontent"],"")));
	}		
	else if($_REQUEST['currentshow']==3)
	{
		$objvalidation->addValidation("gtitle", "Google Title ", "req");
		$objvalidation->addValidation("gcontent", "Google Message ", "req");
		$objclientsocialmediacontent->google_title = $cmn->setVal(trim($cmn->readValueSubmission($_POST["gtitle"],"")));
		$objclientsocialmediacontent->google_content = $cmn->setVal(trim($cmn->readValueSubmission($_POST["gcontent"],"")));
	}
	else if($_REQUEST['currentshow']==4)
	{
		$objvalidation->addValidation("tumblrtitle", "Tumblr  Title ", "req");
		$objvalidation->addValidation("tucontent", "Tumblr  Message ", "req");
		$objclientsocialmediacontent->tumblr_title = $cmn->setVal(trim($cmn->readValueSubmission($_POST["tumblrtitle"],"")));
		$objclientsocialmediacontent->tumblr_content = $cmn->setVal(trim($cmn->readValueSubmission($_POST["tucontent"],"")));
	}
	
	$objvalidation->addValidation("txtreason", "Reason ", "req");
	
	$objclientsocialmediacontent->created_by = $cmn->getSession(ADMIN_USER_ID);
	$objclientsocialmediacontent->updated_by = $cmn->getSession(ADMIN_USER_ID);
	
	if($objvalidation->validate())
	{
		$objclientsocialmediacontent->savemessages();
		$msg->sendMsg("share_message.php","Share Messages ",4);
	}
}
?>