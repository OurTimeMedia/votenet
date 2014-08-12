<?php
	if ( isset($_REQUEST['btnsave']))
	{
		$plan_id = intval($_REQUEST["hdnplan_id"]);
		$objvalidation = new validation();
		$objvalidation->addValidation("plan_title", "Title", "req");
		$objvalidation->addValidation("plan_title", "Title", "dupli", "", DB_PREFIX."plan|plan_title|plan_id|".$plan_id."|1|1");
		$objvalidation->addValidation("plan_amount", "Amount", "req");
		$objvalidation->addValidation("plan_amount", "Amount", "float");
		$objvalidation->addValidation("plan_amount", "Amount", "greaterthan", "", -1);
		$objvalidation->addValidation("plan_ispublish", "Publish", "req");
		$objvalidation->addValidation("plan_ispublish", "Publish","selone");
		$objvalidation->addValidation("custom_domain", "Custom Domain", "req");
		$objvalidation->addValidation("custom_domain", "Custom Domain","selone");
		$objvalidation->addValidation("custom_field", "Custom Field", "req");
		$objvalidation->addValidation("custom_field", "Custom Field","selone");
		$objvalidation->addValidation("custom_color", "Custom Color", "req");
		$objvalidation->addValidation("custom_color", "Custom Color","selone");
		$objvalidation->addValidation("download_data", "Download Data", "req");
		$objvalidation->addValidation("download_data", "Download Data","selone");
		$objvalidation->addValidation("FB_application", "FaceBook Application", "req");
		$objvalidation->addValidation("FB_application", "FaceBook Application","selone");
		$objvalidation->addValidation("API_access", "API Access", "req");
		$objvalidation->addValidation("API_access", "API Access","selone");
		$objvalidation->addValidation("rdoplan_isactive", "Active", "req");
		$objvalidation->addValidation("rdoplan_isactive", "Active","selone");
		if($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			//include_once SERVER_ADMIN_ROOT."plan_field.php";
			//Code to add record.
			
			if (trim($_POST['hdnmode']) == ADD)
			{			
				$objPlan->add();
				$msg->sendMsg("plan_list.php","Plan ",3);
			}
			//Code to edit record
			if (trim($_POST['hdnmode']) == EDIT && !empty($_POST['hdnplan_id']))
			{
				$objPlan->update();
				$msg->sendMsg("plan_list.php","Plan ",4);
			}
		}
	}

	//Code to delete selected record.
	if (isset($_POST["btndelete"]))
	{
		//Code to delete selected record.
		if (trim($mode) == DELETE)
		{
			if (count($_POST['plan_id']) == 0)
			{
				$msg->sendMsg("plan_list.php","Plan ",9);
				exit();
			}
			else
			{
				$objPlan->checkedids = $_POST['plan_id'];
				$objPlan->delete();
				$msg->sendMsg("plan_list.php","Plan ",5);
				exit();			
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
		$objPlan->checkedids = implode(",",$arrayactiveids);
		$objPlan->uncheckedids = $_POST['inactiveids'];
		$objPlan->activeInactive();
		$msg->sendMsg("plan_list.php","Plan ",15);
		exit();
	}

?>