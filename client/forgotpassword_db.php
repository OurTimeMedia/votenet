<?php
	
	if ( isset($_REQUEST['btnsave']))
	{
		$objvalidation = new validation();

		$objvalidation->addValidation("txtuser_username", "Username", "req");
		//$objvalidation->addValidation("txtuser_email", "Email", "email");
		
		if ($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			include("forgotpassword_field.php");
			
			//Code to add record.
			if (trim($_POST['hdnmode']) == 'add')
			{
				$chkType = USER_TYPE_SUPER_CLIENT_ADMIN.",".USER_TYPE_CLIENT_ADMIN;
				
				$userName = $objClientAdmin->user_username;
				$condition = " AND user_username='".$userName."' AND ".DB_PREFIX."user.client_id='".$objClientAdmin->client_id."'  ";
				$emailTo = $objClientAdmin->fieldValue("user_email","",$condition);
								
				$emailFrom = SYSTEM_EMAIL_NOREPLY;
				
				$sendMail = $objClientAdmin->sendForgotPasswordMail(FORGOTPASS_CLIENT_USER,$emailTo,$emailFrom,SERVER_ADMIN_HOST,$chkType,$condition);
				if($sendMail==1)
				{
					$msg->sendMsg("index.php","Password ",80);
				}
				else if($sendMail==2)
				{
					$msg->sendMsg("forgotpassword.php","Password ",81);
				}
				else if($sendMail==3)
				{
					$msg->sendMsg("forgotpassword.php","Password ",82);
				}
			}
		}
	}
?>