<?php 
	defined('PAGE_EXECUTE') or die( 'Restricted access.' );
	if ( isset($_POST['btnsubmit']) ) {
		
		$objvalidation = new validation();		
		
		$objvalidation->add_validation("txtuser_role_name", "user role", "req");
		$objvalidation->add_validation("txtuser_role_name", "user role", "dupli" , "",DB_PREFIX."user_role|user_role_name|user_role_id|" . (int) $user_role_id . "|1|1");
		
		if($objvalidation->validate()){

			//Code to assign value of control to all property of object.
			$objuser_role->user_role_id = (int) $user_role_id;
			$objuser_role->user_role_name = $cmn->setval(trim($cmn->read_value($_POST["txtuser_role_name"],"")));
			$objuser_role->user_role_active = $cmn->setval(trim($cmn->read_value($_POST["rdouser_role_active"],"y")));

			//Code to add record.
			if ($strmode == 'add')
			{
				$objuser_role->add();
				$msg->send_msg("user-role-list.php","User Role ",3);
			}

			//Code to edit record
			if ($strmode == 'edit' && intval($user_role_id) > 0 )
			{
				$objuser_role->update();
				$msg->send_msg("user-role-list.php","User Role ",4);
			}

		}
		
	}
	
	//Code to delete selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'delete') {
		if (count($_POST['deletedids']) == 0)
		{
			$msg->send_msg("user-role-list.php","User Role ",9);
		}
		else
		{
			$objuser_role->checkedids = implode(",",$_POST['deletedids']);
			$objuser_role->delete();
			$msg->send_msg("user-role-list.php","User Role ",5);
		}
		exit();
	}

	//Code to active inactive selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'active') {
		if (isset($_POST['activeids']))
			$arrayactiveids = $_POST['activeids'];
		else
			$arrayactiveids = array("0");
		$objuser_role->checkedids = implode(",",$arrayactiveids);
		$objuser_role->uncheckedids = $_POST['inactiveids'];
		$objuser_role->activeinactive();
		$msg->send_msg("user-role-list.php","User Role ",15);
		exit();
	}
	
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'export') {
		$cmn->export_to_csv('user_role', 'user-role.csv');
	}
?>