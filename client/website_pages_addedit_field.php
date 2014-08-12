<?php

	$objWebsitePages->page_id = $cmn->setVal(trim($cmn->readValueSubmission($objEncDec->decrypt($_POST["hdnpage_id"]),"")));
	
	$objWebsitePages->client_id = $client_id;

	$objWebsitePages->page_name = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtPageName"],"")));
	
	$objWebsitePages->page_type = $cmn->setVal(trim($cmn->readValueSubmission($_POST["rdoOption"],"")));
	
	if($objWebsitePages->page_type == 1)
		$objWebsitePages->page_link = $cmn->setVal(trim($cmn->readValueHTML($_POST["txtLink"],"")));
	else 
		$objWebsitePages->page_content = $cmn->setVal(trim($cmn->readValueHTML($_POST["txtContent"],"")));
	
	$objWebsitePages->created_by = $cmn->getSession(ADMIN_USER_ID);
	
	$objWebsitePages->updated_by = $cmn->getSession(ADMIN_USER_ID);
	
?>