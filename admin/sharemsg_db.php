<?php
	if ( isset($_REQUEST['btnSave']))
	{
		$objvalidation = new validation();
	
		$objvalidation->addValidation("fcontent", "Facebook Content ", "req");
		$objvalidation->addValidation("tcontent", "Twitter Content ", "req");
		$objvalidation->addValidation("gtitle", "Google Plus title", "req");
		$objvalidation->addValidation("gcontent", "Google Plus description", "req");
		$objvalidation->addValidation("tumblrtitle", "Tumblr title ", "req");
		$objvalidation->addValidation("tucontent", "Tumblr  Content ", "req");
		$objvalidation->addValidation("txtreason", "Reason ", "req");
		$objclientsocialmediacontent->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
		$objclientsocialmediacontent->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
		
		if($objvalidation->validate())
		{
			//Code to add record.
			$objclientsocialmediacontent->updatecontent($_POST,0);
			$msg->sendMsg("sharemsg.php","Share Messages ",4);
		}
	}
?>