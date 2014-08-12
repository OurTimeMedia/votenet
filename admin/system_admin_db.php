<?php
	
	if ( isset($_REQUEST['btnsave']))
	{
		$user_id = intval($_REQUEST["hdnuser_id"]);
		$objvalidation = new validation();
		$objvalidation->addValidation("txtuser_username", "Username", "req");
		$objvalidation->addValidation("txtuser_username", "Username", "dupli" , "",DB_PREFIX."user|user_username|user_id|".$user_id."|1|1");
		//$objvalidation->addValidation("txtuser_username", "Username", "dupli" , "",DB_PREFIX."voter|voter_username|voter_id|0|1|1");
		$objvalidation->addValidation("user_password", "Password", "req");
		$objvalidation->addValidation("user_password", "Password", "password");
		$objvalidation->addValidation("user_confirmpassword", "Confirm Password", "req");
		$objvalidation->addValidation("user_confirmpassword", "Confirm Password", "eqelmnt","","user_password|Password");
		$objvalidation->addValidation("txtuser_firstname", "First Name", "req");
		$objvalidation->addValidation("txtuser_firstname", "First Name", "alpha");
		$objvalidation->addValidation("txtuser_lastname", "Last Name", "req");
		$objvalidation->addValidation("txtuser_lastname", "Last Name", "alpha");
		$objvalidation->addValidation("txtuser_designation", "Designation", "req");
		$objvalidation->addValidation("txtuser_email", "Email", "req");
		$objvalidation->addValidation("txtuser_email", "Email", "email");
		//$objvalidation->addValidation("txtuser_email", "Email", "dupli" , "",DB_PREFIX."user|user_email|user_id|".$user_id."|1|1");
		
		
		$objvalidation->addValidation("rdouser_isactive", "Status", "req");

		if ($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			include("system_admin_field.php");
			
			//Code to add record.
			if (trim($_POST['hdnmode']) == 'add')
			{
				$objSystemAdmin->add();
				$msg->sendMsg("system_admin_list.php","System Admin ",3);
			}
			//Code to edit record
			if (trim($_POST['hdnmode']) == 'edit' && !empty($_POST['hdnuser_id']))
			{
				$objSystemAdmin->update();
				$msg->sendMsg("system_admin_list.php","System Admin ",4);
			}
		}
	}

	//Code to delete selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'delete')
	{
		if (count($_POST['deletedids']) == 0)
		{
			$msg->sendMsg("system_admin_list.php","System Admin ",9);
		}
		else
		{
			global $aSystemAdminLookupTables;
	
			if (!empty($_POST['deletedids'])) 
			{
				foreach ($_POST['deletedids'] as $kId)
				{
					if($cmn->validateDeletedIds($kId, $aSystemAdminLookupTables)==false)
					{
						$errId[] = $kId;
					}	
				}
				
				if (!empty($errId)) 
				{
					$errIds = implode(' ,', $errId);
					$msg->sendMsg("system_admin_list.php","System Admins with Id ".$errIds,47);
				}
			}
			
			$objSystemAdmin->checkedids = implode(",",$_POST['deletedids']);
			$objSystemAdmin->delete();
			$msg->sendMsg("system_admin_list.php","System Admin ",5);
		}
		exit();
	}

	//Code to active inactive selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'active')
	{
		if (isset($_POST['activeids']))
			$arrayactiveids = $_POST['activeids'];
		else
			$arrayactiveids = array("0");
		$objSystemAdmin->checkedids = implode(",",$arrayactiveids);
		$objSystemAdmin->uncheckedids = $_POST['inactiveids'];
		$objSystemAdmin->activeInactive();
		$msg->sendMsg("system_admin_list.php","System Admin ",15);
		exit();
	}
	
	if (isset($_POST["btndelete"]))
	{
		//Code to delete selected record.
		if (trim($mode) == DELETE)
		{
			if (count($_POST['user_id']) == 0)
			{
				$msg->sendMsg("system_admin_list.php","System Admin ",9);
				exit();
			}
			else
			{
				$objSystemAdmin->checkedids = $_POST['user_id'];
				$objSystemAdmin->delete();
				$msg->sendMsg("system_admin_list.php","System Admin ",5);
				exit();			
			}
		}
	}
	
	if (isset($_POST["btnsave_access"]))
	{
		//Code to save admin user access
		if(!isset($_POST['chk_access']))
		{
			$msg->sendMsg("system_admin_access.php?user_id=".$user_id,"Admin user access rights",9);
			exit();
		}
		else if (count($_POST['chk_access']) == 0)
		{
			$msg->sendMsg("system_admin_access.php?user_id=".$user_id,"Admin user access rights",9);
			exit();
		}
		else
		{
			$objSystemAdmin->user_id = $user_id;
			$objSystemAdmin->checkedids = $_POST['chk_access'];
			$objSystemAdmin->saveAccessRights();
			$msg->sendMsg("system_admin_access.php?user_id=".$user_id,"Admin user access rights",4);
			exit();			
		}
	}

?>