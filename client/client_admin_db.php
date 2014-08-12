<?php
	
	if ( isset($_REQUEST['btnsave']))
	{	
		$user_id = intval($objEncDec->decrypt($_REQUEST["hdnuser_id"]));
		
		$objvalidation = new validation();

		$objvalidation->addValidation("txtuser_username", "Username", "req");
		$objvalidation->addValidation("txtuser_username", "Username", "dupli" , "",DB_PREFIX."user|user_username|user_id|".$user_id."|client_id|".$objClientAdmin->client_id);
		
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

			include("client_admin_field.php");
			
			//Code to add record.
			if (trim($_POST['hdnmode']) == 'add')
			{ 
				$fromEmailDetail = $objClientAdmin->fieldValue("user_email",$cmn->getSession(ADMIN_USER_ID));
				$superClientUserName = $objClientAdmin->fieldValue("user_username",$cmn->getSession(ADMIN_USER_ID));

				$objClientAdmin->add();
				$objClientAdmin->clientRegistrationMail(CLIENT_REGISTRATION_ADMIN,$objClientAdmin->user_email,CLIENT_EMAIL,$superClientUserName);
				$msg->sendMsg("client_admin_list.php","Admin ",3);
				exit;
			}

			//Code to edit record
			if (trim($_POST['hdnmode']) == 'edit' && !empty($_POST['hdnuser_id']))
			{	
				$objClientAdmin->update();
				$msg->sendMsg("client_admin_list.php","Admin ",4);
				exit;
			}

		}
		

	}

	//Code to delete selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'delete')
	{
		if (count($_POST['deletedids']) == 0)
		{
			$msg->sendMsg("client_admin_list.php","Admin ",9);
		}
		else
		{
			global $aClientAdminLookupTables;
	
			if (!empty($_POST['deletedids'])) 
			{
				foreach ($_POST['deletedids'] as $kId)
				{
					if($cmn->validateDeletedIds($kId, $aClientAdminLookupTables)==false)
					{
						$errId[] = $kId;
					}	
				}
				
				if (!empty($errId)) 
				{
					$errIds = implode(' ,', $errId);
					$msg->sendMsg("client_admin_list.php","Admins with Id ".$errIds,47);
					exit;
				}
			}
			
			$objClientAdmin->checkedids = implode(",",$_POST['deletedids']);
			$objClientAdmin->delete();
			$msg->sendMsg("client_admin_list.php","Admin ",5);
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
		$objClientAdmin->checkedids = implode(",",$arrayactiveids);
		$objClientAdmin->uncheckedids = $_POST['inactiveids'];
		$objClientAdmin->activeInactive();
		$msg->sendMsg("client_admin_list.php","Admin ",15);
		exit();
	}
	
	if (isset($_POST["btndelete"]))
	{
		//Code to delete selected record.
		if (trim($mode) == DELETE)
		{
			if (count($_POST['user_id']) == 0)
			{
				$msg->sendMsg("client_admin_list.php","Admin ",9);
				exit();
			}
			else
			{	
				$objClientAdmin->checkedids = $objEncDec->decrypt($_POST['user_id']);

				$objClientAdmin->delete();
				$msg->sendMsg("client_admin_list.php","Admin ",5);
				exit();			
			}
		}
	}
	
	if (isset($_POST["btnsave_access"]))
	{
		//Code to save admin user access
		if (count($_POST['chk_access']) == 0)
		{
			$msg->sendMsg("client_admin_access.php?user_id=".$objEncDec->encrypt($user_id),"Admin user access rights",9);
			exit();
		}
		else
		{
		
			$objClientAdmin->user_id = $user_id;
			$objClientAdmin->checkedids = $_POST['chk_access'];			
			$objClientAdmin->saveAccessRights();
			$msg->sendMsg("client_admin_access.php?user_id=".$objEncDec->encrypt($user_id),"Admin user access rights",4);
			exit();			
		}
	}

?>