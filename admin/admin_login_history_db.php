<?php
	//Code to delete selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'delete')
	{
		if (count($_POST['deletedids']) == 0)
		{
			$msg->sendMsg("admin_login_history.php","System Admin Login History ",9);
		}
		else
		{
		
			$objAdminLoginHistory->checkedids = implode(",",$_POST['deletedids']);
			$objAdminLoginHistory->delete();
			$msg->sendMsg("admin_login_history.php","System Admin Login History ",5);
		}
		exit();
	}
?>