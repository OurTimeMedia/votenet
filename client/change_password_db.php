<?php
	
	if ( isset($_REQUEST['btnsave']))
	{
		$user_id = intval($_REQUEST["hdnuser_id"]);

		$objvalidation = new validation();
		
		$objvalidation->addValidation("user_oldpassword", "Old password", "req");
		$objvalidation->addValidation("user_password", "New password", "req");
		$objvalidation->addValidation("user_confirmpassword", "Confirm Password", "req");
		$objvalidation->addValidation("user_confirmpassword", "Confirm Password", "eqelmnt","","user_password|Password");
		$objvalidation->addValidation("user_confirmpassword", "Confirm Password", "eqelmntPassword","","user_password|Password|".$currentPassword);
		
		if ($objvalidation->validate())
		{	
			//Code to assign value of control to all property of object.
			include("change_password_field.php");
			//Code to add record.
			
			$passwordChange = $objClientAdmin->changePassword();
			
			if($passwordChange==1)
			{
				$msg->sendMsg("change_password.php","Password ",4);
				exit;
			}
			else if($passwordChange==2)
			{
				$msg->sendMsg("change_password.php","Old Password ",16);
				exit;
			}
			
		}
	}
?>