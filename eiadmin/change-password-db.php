<?php 
	defined('PAGE_EXECUTE') or die( 'Restricted access.' );
	if ( isset($_POST['btnsubmit']) ) {
		$objvalidation = new validation();
		$objvalidation->add_validation("txtold_password", "old password", "req");
		$objvalidation->add_validation("txtnew_password", "new password", "req");
		$objvalidation->add_validation("txtconfirm_password", "confirm password", "req");
		$objvalidation->add_validation("txtconfirm_password", "Confirm password", "eqelmnt","","txtnew_password|Password");
		if ($objvalidation->validate())
		{				
			$strold_password = $cmn->setval(trim($cmn->read_value($_POST["txtold_password"],"")));
			$strnew_password = $cmn->setval(trim($cmn->read_value($_POST["txtnew_password"],"")));
			$strconfirm_password = $cmn->setval(trim($cmn->read_value($_POST["txtconfirm_password"],"")));
			if ( $objuser->change_password($strold_password, $strnew_password) == 1) {
				/* $log->log_action(6); */
				$msg->send_msg("change-password.php","Password",13);
			}
			else {
				$msg->send_msg("change-password.php","Old Password",16);
			}
		}
	}
?>