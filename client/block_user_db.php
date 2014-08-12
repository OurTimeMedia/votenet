<?php

	if ( isset($_REQUEST['btnsave']))
	{
		$blockuser_id = intval($objEncDec->decrypt($_REQUEST["hdnblockuser_id"]));

		$objvalidation = new validation();

		$condition = " AND user_username='".$_POST['txtuser']."'";
		$objSecurityBlockUser->user_id = $objUser->fieldValue("user_id","",$condition);		
				
		$objvalidation->addValidation("txtuser", "Username ", "req");
		
		if($objSecurityBlockUser->user_id == $cmn->getSession(ADMIN_USER_ID))
		{
			$objvalidation->addValidation("txtuser", "Username ", "blockself");
		}
		else if($objSecurityBlockUser->isUserAvailable($_POST["txtuser"])==0)
		{	
			$objvalidation->addValidation("txtuser", "Username ", "inarr");
		}
		else
		{	
			if($objSecurityBlockUser->user_id!=0)
			{
				$objvalidation->addValidation($objSecurityBlockUser->user_id, "Username ", "dupli", "", DB_PREFIX."block_user|user_id|blockuser_id|".$blockuser_id."| client_id | ".$_POST['hdnclient_id']."");
			}			
		}
		
		if($objvalidation->validate())
		{		
			//Code to assign value of control to all property of object.
			include_once SERVER_CLIENT_ROOT."block_user_field.php";

			//Code to add record.
			if (trim($_POST['hdnmode']) == ADD)
			{
				$objSecurityBlockUser->add();
				$msg->sendMsg("block_user_list.php","User ",78);
				exit();
			}
		
			//Code to edit record
			if (trim($_POST['hdnmode']) == 'edit' && !empty($_POST['hdnblockuser_id']))
			{	
				$objSecurityBlockUser->update();
				$msg->sendMsg("block_user_list.php","User ",4);
				exit;
			}
		}
	}
	
	//Code to public private selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'unblock')
	{	
		if (count($_POST['unblockids']) == 0)
		{
			$msg->sendMsg("block_user_list.php","User ",9);
		}
		else
		{	
			$objSecurityBlockUser->checkedids = implode(",",$_POST['unblockids']);
			$objSecurityBlockUser->unblock();
			$msg->sendMsg("block_user_list.php","User ",76);
		}
		exit();
	}
	
	if (isset($_POST["btndelete"]))
	{	
		//Code to delete selected record.
		if (trim($mode) == DELETE)
		{
			if (count($_POST['blockuser_id']) == 0)
			{
				$msg->sendMsg("block_user_list.php","User ",9);
				exit();
			}
			else
			{	
				$objSecurityBlockUser->checkedids = $objEncDec->decrypt($_POST['blockuser_id']);
				$objSecurityBlockUser->delete();
				$msg->sendMsg("block_user_list.php","User ",104);
				exit();			
			}
		}
	}



?>