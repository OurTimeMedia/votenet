<?php

	if ( isset($_REQUEST['btnsave']))
	{
		$blockuser_id = intval($_REQUEST["hdnblockuser_id"]);

		$objvalidation = new validation();

		$condition = " AND user_username='".$_POST['txtuser']."'";
		$objSecurityBlockUser->user_id = $objUser->fieldValue("user_id","",$condition);

		$objvalidation->addValidation("txtuser", "User Name ", "req");
		$definedUsers = substr($_POST['definedUsers'],0,-1);
		$definedUsers = explode(",",$_POST['definedUsers']);
		
		$objvalidation->addValidation($objSecurityBlockUser->user_id, "User Name ", "dupli", "", DB_PREFIX."block_user|user_id|blockuser_id|".$blockuser_id."| client_id | 0");
	
		if($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			include_once SERVER_ADMIN_ROOT."security_block_user_field.php";
			
			//Code to add record.
			if (trim($_POST['hdnmode']) == ADD)
			{
				$objSecurityBlockUser->add();
				$msg->sendMsg("security_block_user.php","User ",78);
				exit();
			}
		}
	}
	
	//Code to public private selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'unblock')
	{	
		if (count($_POST['unblockids']) == 0)
		{
			$msg->sendMsg("security_block_user.php","User ",9);
		}
		else
		{	
			$objSecurityBlockUser->checkedids = implode(",",$_POST['unblockids']);
			$objSecurityBlockUser->unblock();
			$msg->sendMsg("security_block_user.php","User ",76);
		}
		exit();
	}


?>