<?php

	$objEmaiTemplates->email_templates_id = $cmn->setVal(trim($cmn->readValueSubmission($objEncDec->decrypt($_POST["hdnemail_templates_id"]),"")));

	$objEmaiTemplates->email_templates_name = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtemail_templates_name"],"")));
	
	$objEmaiTemplates->email_subject = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtemail_subject"],"")));
	
	$objEmaiTemplates->email_type = $cmn->setVal(trim($cmn->readValueSubmission($_POST["hdnemail_type"],"")));
	
	$objEmaiTemplates->email_body = $cmn->setVal(trim($cmn->readValue($_POST["txtemail_body"],"")));
	
	$objEmaiTemplates->client_id = $cmn->setVal(trim($cmn->readValueSubmission($_POST["hdnclient_id"],"")));
	
	$objEmaiTemplates->created_by = $cmn->getSession(ADMIN_USER_ID);
	
	$objEmaiTemplates->updated_by = $cmn->getSession(ADMIN_USER_ID);
	
?>