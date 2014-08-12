<?php

	$objSponsors->sponsors_id = $cmn->setVal(trim($cmn->readValueSubmission($objEncDec->decrypt($_POST["hdnsponsors_id"]),"")));
	
	$objSponsors->client_id = $client_id;

	$objSponsors->sponsors_name = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtsponsors_name"],"")));
	$objSponsors->sponsors_description = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtsponsors_description"],"")));
	$objSponsors->sponsors_website = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtsponsors_website"],"")));
	$objSponsors->sponsors_isactive = 1;
	
	$objSponsors->created_by = $cmn->getSession(ADMIN_USER_ID);
	
	$objSponsors->updated_by = $cmn->getSession(ADMIN_USER_ID);
	
	print_r($objSponsors);
	
?>