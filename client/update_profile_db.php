<?php
	
	if ( isset($_REQUEST['btnsave']))
	{
		$user_id = intval($_REQUEST["hdnuser_id"]);

		$objvalidation = new validation();

		$objvalidation->addValidation("txtuser_firstname", "First Name", "req");
		$objvalidation->addValidation("txtuser_firstname", "First Name", "alpha");
		
		$objvalidation->addValidation("txtuser_lastname", "Last Name", "req");
		$objvalidation->addValidation("txtuser_lastname", "Last Name", "alpha");
		
		$objvalidation->addValidation("txtuser_company", "Company", "req");
		
		$objvalidation->addValidation("txtuser_email", "Email", "req");
		$objvalidation->addValidation("txtuser_email", "Email", "email");
		//$objvalidation->addValidation("txtuser_email", "Email", "dupli" , "",DB_PREFIX."user|user_email|user_id|".$user_id."|1|1");
		
		if ($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			include("update_profile_field.php");
			$loginpage = 2;
			//Code to add record.
			if (trim($_POST['hdnmode']) == 'edit')
			{
				$objClientAdmin->update();
				$msg->sendMsg("update_profile.php","Profile ",4);
				exit;
			}
		}
	}
?>