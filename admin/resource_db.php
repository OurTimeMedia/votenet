<?php

	if ( isset($_REQUEST['btnsave'])){

		$resource_id = intval($_REQUEST["hdnresource_id"]);

		$objvalidation = new validation();

		$objvalidation->addValidation("txtresource_name", "resource name", "req");
		$objvalidation->addValidation("txtresource_text", "resource text", "req");
	
		if($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			$objResource->resource_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnresource_id"],"")));
			$objResource->resource_name = $cmn->setVal(trim($cmn->readValue($_POST["txtresource_name"],"")));
			$objResource->resource_text = $cmn->setVal(trim($cmn->readValue($_POST["txtresource_text"],"")));
			$objResource->resource_page = $cmn->setVal(trim($cmn->readValue($_POST["txtresource_page"],"")));
			$objResource->resource_isactive = $cmn->setVal(trim($cmn->readValue($_POST["rdoresource_isactive"],"")));

			$objResource->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
			$objResource->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
			
			//Code to add record.
			if (trim($_POST['hdnmode']) == ADD)
			{
				$objResource->add();
				$msg->sendMsg("resource_list.php","Resource ",3);
			}

			//Code to edit record
			if (trim($_POST['hdnmode']) == EDIT && !empty($_POST['hdnresource_id']))
			{
				$objResource->update();
				$msg->sendMsg("resource_list.php","Resource ",4);
			}

		}

	}

	//Code to delete selected record.
	if (isset($_REQUEST["btndelete"]))
	{
		//Code to delete selected record.
		if (count($_REQUEST['resource_id']) == 0)
		{
			$msg->sendMsg("resource_list.php","Resource ",9);
			exit();
		}
		else
		{
			$objResource->checkedids = $_REQUEST['resource_id'];
			$objResource->delete();
			$msg->sendMsg("resource_list.php","Resource ",5);
			exit();			
		}
		
	}

	//Code to active inactive selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'active')
	{
		if (isset($_POST['activeids']))
			$arrayactiveids = $_POST['activeids'];
		else
			$arrayactiveids = array("0");
		$objResource->checkedids = implode(",",$arrayactiveids);
		$objResource->uncheckedids = $_POST['inactiveids'];
		$objResource->activeInactive();
		$msg->sendMsg("resource_list.php","Resource ",15);
		exit();
	}

?>