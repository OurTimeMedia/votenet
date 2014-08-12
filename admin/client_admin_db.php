<?php	
	if ( isset($_REQUEST['btnsave']))
	{		
		$user_id = intval($_REQUEST["hdnuser_id"]);

		$objvalidation = new validation();
		$objvalidation->addValidation("txtuser_username", "Username", "req");
		$objvalidation->addValidation("txtuser_username", "Username", "dupli" , "",DB_PREFIX."user|user_username|user_id|".$user_id."|1|1");
		$objvalidation->addValidation("user_password", "Password", "password");
		$objvalidation->addValidation("user_confirmpassword", "Confirm Password", "req");
		$objvalidation->addValidation("user_confirmpassword", "Confirm Password", "eqelmnt","","user_password|Password");
		$objvalidation->addValidation("txtuser_firstname", "First Name", "req");
		$objvalidation->addValidation("txtuser_firstname", "First Name", "alpha");
		$objvalidation->addValidation("txtuser_lastname", "Last Name", "req");
		$objvalidation->addValidation("txtuser_lastname", "Last Name", "alpha");
		$objvalidation->addValidation("txtuser_company", "Company", "req");
		$objvalidation->addValidation("txtuser_email", "Email", "req");
		$objvalidation->addValidation("txtuser_email", "Email", "email");
		$objvalidation->addValidation("selPlan", "Plan", "req");
		$objvalidation->addValidation("txtexpiry_date", "Expire Date", "req");
		//$objvalidation->addValidation("txtuser_email", "Email", "dupli" , "",DB_PREFIX."user|user_email|user_id|".$user_id."|1|1");
		
		$objvalidation->addValidation("rdouser_isactive", "Status", "req");

		if ($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			include("client_admin_field.php");
						
			//print_r($_POST);exit;
			if(trim($_POST['hdnmode']) !='add')
			{
				//echo $objClientAdmin->plan_id."==".$_POST['selPlan'];exit;
				if($_POST['currentplan'] != $_POST['selPlan'] || $_POST['currentExpiry'] != $_POST['txtexpiry_date'])
				{
					$objClientAdmin->plan_id=$_POST['selPlan'];
					$objclientpayment->plancharges();
					$objclientpayment->addPaymentDetail();
				}
				$objClientAdmin->plan_id=$_POST['selPlan'];
			}
			//Code to add record.
			if (trim($_POST['hdnmode']) == 'add')
			{
				$objClientAdmin->addClient();
				$objClientAdmin->add();
				$objclientpayment->client_id=$objClientAdmin->client_id;
				$objclientpayment->plancharges();
				$objclientpayment->addPaymentDetail();
				$emailTo = $objClientAdmin->user_email;
				/*$aEmailID = $cmn->fetchSuperAdminEmailID(ADMIN_USER_TYPE_ID);
				$emailFrom = $aEmailID['user_email'];*/
				$emailFrom = CLIENT_EMAIL;
				
				$objClientAdmin->clientRegistrationMail(CLIENT_REGISTRATION_ADMIN,$emailTo,$emailFrom);
								
				$msg->sendMsg("client_admin_list.php","Client Admin ",3);
			}

			//Code to edit record
			if (trim($_POST['hdnmode']) == 'edit' && !empty($_POST['hdnuser_id']))
			{
				//$objClientAdmin->updateClient();
				$objClientAdmin->updateClientCredit();
				$objClientAdmin->update();
				$msg->sendMsg("client_admin_list.php","Client Admin ",4);
			}
		}
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
		$msg->sendMsg("client_admin_list.php","Client Admin ",15);
		exit();
	}
	
	if (isset($_POST["btndelete"]))
	{
		//Code to delete selected record.
		if (trim($mode) == DELETE)
		{
			if (count($_POST['user_id']) == 0)
			{
				$msg->sendMsg("client_admin_list.php","Client Admin ",9);
				exit();
			}
			else
			{
				$objClientAdmin->checkedids = $_POST['user_id'];
				$objClientAdmin->delete();
				$msg->sendMsg("client_admin_list.php","Client Admin ",5);
				exit();			
			}
		}
	}
	
	if (isset($_POST["btnsave_access"]))
	{
		//Code to save admin user access
		if (count($_POST['chk_access']) == 0)
		{
			$msg->sendMsg("client_admin_access.php?user_id=".$user_id,"Admin user access rights",9);
			exit();
		}
		else
		{
			$objClientAdmin->user_id = $user_id;
			$objClientAdmin->checkedids = $_POST['chk_access'];
			$objClientAdmin->saveAccessRights();
			$msg->sendMsg("client_admin_access.php?user_id=".$user_id,"Admin user access rights",4);
			exit();			
		}
	}

?>