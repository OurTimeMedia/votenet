<?php

	if ( isset($_REQUEST['btnsave']))
	{

		$block_ipaddress_id = intval($_REQUEST["hdnblock_ipaddress_id"]);

		$objvalidation = new validation();

		$objvalidation->addValidation("txtipaddress", "IP Address ", "req");
		$objvalidation->addValidation("txtipaddress", "IP Address ", "ipaddress");
		$objvalidation->addValidation("txtipaddress", "IP Address ", "dupli", "", DB_PREFIX."block_ipaddress|ipaddress|block_ipaddress_id|".$block_ipaddress_id."| client_id | 0");
	
		if($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			include_once SERVER_ADMIN_ROOT."security_block_ip_field.php";	
			//Code to add record.
			if (trim($_POST['hdnmode']) == ADD)
			{
				$objSecurityBlockIP->add();
				$msg->sendMsg("security_block_ip_list.php","IP Address ",78);
			}
		}

	}
	
	//Code to public private selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'unblock')
	{	
		if (count($_POST['unblockids']) == 0)
		{
			$msg->sendMsg("security_block_ip_list.php","IP Address ",9);
		}
		else
		{	
			$objSecurityBlockIP->checkedids = implode(",",$_POST['unblockids']);
			$objSecurityBlockIP->unblock();
			$msg->sendMsg("security_block_ip_list.php","IP Address ",76);
		}
		exit();
	}


?>