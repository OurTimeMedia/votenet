<?php
	$objClientAdmin->user_id = $cmn->setVal(trim($cmn->readValueSubmission($_POST["hdnuser_id"],"")));
	$objClientAdmin->user_oldpassword = $cmn->setVal(trim($cmn->readValueSubmission($_POST["user_oldpassword"],"")));
	$objClientAdmin->user_password = $cmn->setVal(trim($cmn->readValueSubmission($_POST["user_password"],"")));
	$objClientAdmin->updated_by = $cmn->getSession(ADMIN_USER_ID);

?>