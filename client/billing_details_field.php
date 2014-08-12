<?php

	$objClientAdmin->client_id = $cmn->setVal(trim($cmn->readValueSubmission($_POST["hdnclient_id"],"")));
	$objClientAdmin->allow_credit = $cmn->setVal(trim($cmn->readValueSubmission($_POST["hdnallow_credit"],"")));
	$objClientAdmin->bill_name = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtbill_name"],"")));
	$objClientAdmin->bill_address1 = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtbill_address1"],"")));
	$objClientAdmin->bill_address2 = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtbill_address2"],"")));
	$objClientAdmin->bill_city = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtbill_city"],"")));
	$objClientAdmin->bill_state = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtbill_state"],"")));
	$objClientAdmin->bill_country_id = $cmn->setVal(trim($cmn->readValueSubmission($_POST["selcountry_id"],"")));
	$objClientAdmin->bill_zipcode = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtbill_zipcode"],"")));

?>