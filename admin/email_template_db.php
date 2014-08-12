<?php

	if ( isset($_REQUEST['btnsave']))
	{

		$email_templates_id = intval($_REQUEST["hdnemail_templates_id"]);

		$objvalidation = new validation();

		$objvalidation->addValidation("txtemail_templates_name", "Name of Email Template ", "req");
		$objvalidation->addValidation("txtemail_subject", "Subject ", "req");
		$objvalidation->addValidation("txtemail_body", "Content ", "req");
		

		if($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			include_once SERVER_ADMIN_ROOT."email_template_field.php";
		
			//Code to edit record
			if (trim($_POST['hdnmode']) == EDIT && !empty($_POST['hdnemail_templates_id']))
			{
				$objEmaiTemplates->updateTemplateDetail();
				$msg->sendMsg("email_template_list.php","Email Template ",4);
			}

		}

	}
?>