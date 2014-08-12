<?php
	if ( isset($_REQUEST['btnsave']))
	{
		$site_config_id = intval($_REQUEST["hdnsite_config_id"]);

		$objvalidation = new validation();

		$objvalidation->addValidation("rdosite_config_isonline", "Site Status", "req");
		$objvalidation->addValidation("rdosite_config_isonline", "Site Status","selone");
		$objvalidation->addValidation("txtsite_config_offline_message", "Off-line Message", "req");
	
		$uploadFlag = $objSystemMaintenance->uploadMaintananceImage();
	
		if($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			include_once SERVER_ADMIN_ROOT."system_maintenance_field.php";	
			//Code to edit record.
			if (trim($_POST['hdnmode']) == 'edit')
			{
				$objSystemMaintenance->systemMaintananceEdit();
				$msg->sendMsg("system_maintenance.php","System Maintenance ",4);
				exit();
			}
		}
	}
?>