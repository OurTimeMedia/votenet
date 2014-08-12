<?php
	$objClientAdmin->user_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnuser_id"],"")));
	$objClientAdmin->client_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnclient_id"],"")));
	$objClientAdmin->user_type_id = $cmn->setVal(trim($cmn->readValue($_POST["seluser_type_id"],"")));
	$objClientAdmin->user_username = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_username"],"")));
	$objClientAdmin->user_password = $cmn->setVal(trim($cmn->readValue($_POST["user_password"],"")));
	$objClientAdmin->user_firstname = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_firstname"],"")));
	$objClientAdmin->user_lastname = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_lastname"],"")));
	$objClientAdmin->user_email = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_email"],"")));
	$objClientAdmin->user_company = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_company"],"")));
	$objClientAdmin->user_designation = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_designation"],"")));
	$objClientAdmin->user_phone = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_phone"],"")));
	$objClientAdmin->user_address1 = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_address1"],"")));
	$objClientAdmin->user_address2 = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_address2"],"")));
	$objClientAdmin->user_city = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_city"],"")));
	$objClientAdmin->user_state = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_state"],"")));
	$objClientAdmin->user_country = $cmn->setVal(trim($cmn->readValue($_POST["selcountry_id"],"")));
	$objClientAdmin->user_zipcode = $cmn->setVal(trim($cmn->readValue($_POST["hdnuser_zipcode"],"")));
	$objClientAdmin->user_isactive = $cmn->setVal(trim($cmn->readValue($_POST["rdouser_isactive"],"")));
	$objClientAdmin->expiry_date = $cmn->setVal(trim($cmn->readValue($_POST["txtexpiry_date"],"")));
	$objClientAdmin->bill_name = $objClientAdmin->user_firstname." ".$objClientAdmin->user_lastname;
	$objClientAdmin->bill_address1 = $objClientAdmin->user_address1;
	$objClientAdmin->bill_address2 = $objClientAdmin->user_address2;
	$objClientAdmin->bill_city = $objClientAdmin->user_city;
	$objClientAdmin->bill_state = $objClientAdmin->user_state;
	$objClientAdmin->bill_country_id = $objClientAdmin->user_country;
	$objClientAdmin->bill_zipcode = $objClientAdmin->user_zipcode;
	
	$objClientAdmin->languages = 1;
	
	if(isset($_POST['language']) && is_array($_POST['language']))
		$objClientAdmin->languages = "1,".implode(",", $_POST['language']);
	
	$objClientAdmin->plan_id = $cmn->setVal(trim($cmn->readValue($_POST["selPlan"],"")));
	$objClientAdmin->allow_credit = $cmn->setVal(trim($cmn->readValue($_POST["rdoallow_credit"],"")));
	$objClientAdmin->expiry_date = $cmn->setVal(trim($cmn->readValue(date("Y-m-d",strtotime($_POST["txtexpiry_date"])),"")));
	
	$objClientAdmin->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objClientAdmin->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
			
	if($_POST['currentplan'] != $_POST['selPlan'] || $_POST['currentExpiry'] != $_POST['txtexpiry_date'])
	{		
		$objclientpayment->client_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnclient_id"],"")));
		$objclientpayment->plan_id = $objClientAdmin->plan_id;
		$objclientpayment->bill_name = $objClientAdmin->user_firstname." ".$objClientAdmin->user_lastname;
		
		$objclientpayment->bill_address1 = $objClientAdmin->user_address1;
		$objclientpayment->bill_address2 = $objClientAdmin->user_address2;
		$objclientpayment->bill_city = $objClientAdmin->user_city;
		$objclientpayment->bill_state = $objClientAdmin->user_state;
		$objclientpayment->bill_state = $objClientAdmin->user_state;
		$objclientpayment->bill_country_id = $objClientAdmin->user_country;
		$objclientpayment->bill_zipcode = $objClientAdmin->user_zipcode;
		$objclientpayment->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
		$objclientpayment->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	}
?>