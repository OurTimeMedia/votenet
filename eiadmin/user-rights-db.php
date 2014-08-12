<?php 
	defined('PAGE_EXECUTE') or die( 'Restricted access.' );
	if ( isset($_POST['btnsubmit']) ) {
		
		#STEP 1 - REMOVE ALL RIGHTS
		$objuser_rights->user_role_id = (int) $user_role_id;
		$objuser_rights->delete();
		
		#STEP 2 - ADD RIGHTS
		if ( isset($_POST['chkrights']) && is_array($_POST['chkrights']) && count($_POST['chkrights']) ) {
			foreach ( $_POST['chkrights'] as $key => $value ) {
				$arright = explode('|', $value);	
				if ( is_array($arright) && count($arright) ) {
					$objuser_rights->menu_id = (int) $arright[0];
					$objuser_rights->user_right = (int) $arright[1];
					$objuser_rights->add();
				}
			}
		}
		$msg->send_msg("user-rights-list.php","User Rights ",4);
	}
	
	//Code to delete selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'delete') {
		if (count($_POST['deletedids']) == 0)
		{
			$msg->send_msg("user-role-list.php","User Role ",9);
		}
		else
		{
			if ( is_array($_POST['deletedids']) && count($_POST['deletedids']) ) {
				foreach ( $_POST['deletedids'] as $key => $user_role_id ) {
					$objuser_rights->user_role_id = (int) $user_role_id;
					$objuser_rights->delete();		
				}	
			}
			$msg->send_msg("user-rights-list.php","User Rights ",5);
		}
		exit();
	}
	
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'export') {
		$cmn->export_to_csv('user_rights', 'user-rights.csv');
	}
?>