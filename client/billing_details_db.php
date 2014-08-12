<?php
	
	if ( isset($_REQUEST['btnsave']))
	{
		$client_id = intval($_REQUEST["hdnclient_id"]);

		$objvalidation = new validation();

		$objvalidation->addValidation("txtbill_name", "Billing Name", "req");
		
		if ($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			include("billing_details_field.php");
			//Code to add record.
		
			$passwordChange = $objClientAdmin->updateClient();
			$msg->sendMsg("billing_details.php","Billing Details ",4);
			exit;
		}
	}
?>