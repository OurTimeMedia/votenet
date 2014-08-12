<?php

	if ( isset($_REQUEST['btnsave']))
	{

		$block_ipaddress_id = intval($objEncDec->decrypt($_REQUEST["hdnblock_ipaddress_id"]));

		$objvalidation = new validation(); 
		
		$objvalidation->addValidation("txtipaddress", "IP Address ", "req");
		$objvalidation->addValidation("txtipaddress", "IP Address ", "ipaddress");
		$objvalidation->addValidation("txtipaddress", "IP Address ", "dupli", "", DB_PREFIX."block_ipaddress|ipaddress|block_ipaddress_id|".$block_ipaddress_id."| client_id | ".$_POST['hdnclient_id']."");
		$objvalidation->addValidation("txtreason", "Reason ", "req");
		
		if($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			include_once "block_ip_field.php";	
			//Code to add record.
			if (trim($_POST['hdnmode']) == ADD)
			{
				$objSecurityBlockIP->add();
				$msg->sendMsg("block_ip_list.php","IP Address ",78);
			}
			
			//Code to edit record
			if (trim($_POST['hdnmode']) == 'edit' && !empty($_POST['hdnblock_ipaddress_id']))
			{
				$objSecurityBlockIP->update();
				$msg->sendMsg("block_ip_list.php","IP Address ",4);
				exit;
			}
		}

	}
	
	//Code to public private selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'unblock')
	{	
		if (count($_POST['unblockids']) == 0)
		{
			$msg->sendMsg("block_ip_list.php","IP Address ",9);
		}
		else
		{	
			$objSecurityBlockIP->checkedids = implode(",",$_POST['unblockids']);
			$objSecurityBlockIP->unblock();
			$msg->sendMsg("block_ip_list.php","IP Address ",76);
		}
		exit();
	}
	
	if (isset($_POST["btndelete"]))
	{
		//Code to delete selected record.
		if (trim($mode) == DELETE)
		{
			if (count($_POST['block_ipaddress_id']) == 0)
			{
				$msg->sendMsg("block_ip_list.php","IP Address ",9);
				exit();
			}
			else
			{
				$objSecurityBlockIP->checkedids = $objEncDec->decrypt($_POST['block_ipaddress_id']);
				$objSecurityBlockIP->delete();
				$msg->sendMsg("block_ip_list.php","IP Address ",5);
				exit();			
			}
		}
	}


?>