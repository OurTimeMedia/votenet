<?php

	$objClientAdmin->user_id = $cmn->setVal(trim($cmn->readValueSubmission($_POST["hdnuser_id"],"")));
	$objClientAdmin->client_id = $cmn->setVal(trim($cmn->readValueSubmission($_POST["hdnclient_id"],"")));
	$objClientAdmin->user_type_id = $cmn->setVal(trim($cmn->readValueSubmission($_POST["seluser_type_id"],"")));
	$objClientAdmin->user_username = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser_username"],"")));
	$objClientAdmin->user_password = $cmn->setVal(trim($cmn->readValueSubmission($_POST["user_password"],"")));
	$objClientAdmin->user_firstname = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser_firstname"],"")));
	$objClientAdmin->user_lastname = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser_lastname"],"")));
	$objClientAdmin->user_email = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser_email"],"")));
	$objClientAdmin->user_company = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser_company"],"")));
	$objClientAdmin->user_designation = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser_designation"],"")));
	$objClientAdmin->user_phone = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser_phone"],"")));
	$objClientAdmin->user_address1 = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser_address1"],"")));
	$objClientAdmin->user_address2 = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser_address2"],"")));
	$objClientAdmin->user_city = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser_city"],"")));
	$objClientAdmin->user_state = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser_state"],"")));
	$objClientAdmin->user_country = $cmn->setVal(trim($cmn->readValueSubmission($_POST["selcountry_id"],"")));
	$objClientAdmin->user_zipcode = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser_zipcode"],"")));
	$confirmPassword = $cmn->setVal(trim($cmn->readValueSubmission($_POST["user_confirmpassword"],"")));
	$oldpassword = $cmn->setVal(trim($cmn->readValueSubmission($_POST["user_oldpassword"],"")));

	$objClientAdmin->updated_by = $cmn->getSession(ADMIN_USER_ID);

?>