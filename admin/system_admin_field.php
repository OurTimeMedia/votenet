<?php
	$objSystemAdmin->user_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnuser_id"],"")));
	
	$objSystemAdmin->user_type_id = $cmn->setVal(trim($cmn->readValue($_POST["seluser_type_id"],"")));
	$objSystemAdmin->user_username = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_username"],"")));
	$objSystemAdmin->user_password = $cmn->setVal(trim($cmn->readValue($_POST["user_password"],"")));
	$objSystemAdmin->user_firstname = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_firstname"],"")));
	$objSystemAdmin->user_lastname = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_lastname"],"")));
	$objSystemAdmin->user_email = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_email"],"")));
	$objSystemAdmin->user_company = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_company"],"")));
	$objSystemAdmin->user_designation = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_designation"],"")));
	$objSystemAdmin->user_phone = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_phone"],"")));
	$objSystemAdmin->user_address1 = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_address1"],"")));
	$objSystemAdmin->user_address2 = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_address2"],"")));
	$objSystemAdmin->user_city = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_city"],"")));
	$objSystemAdmin->user_state = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_state"],"")));
	$objSystemAdmin->user_country = $cmn->setVal(trim($cmn->readValue($_POST["selcountry_id"],"")));
	$objSystemAdmin->user_zipcode = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_zipcode"],"")));
	$objSystemAdmin->user_isactive = $cmn->setVal(trim($cmn->readValue($_POST["rdouser_isactive"],"")));
	
	$objSystemAdmin->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objSystemAdmin->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
			
?>