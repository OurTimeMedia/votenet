<?php

	$objSecurityBlockUser->blockuser_id = $cmn->setVal(trim($cmn->readValueSubmission($objEncDec->decrypt($_POST["hdnblockuser_id"]),"")));

	$objSecurityBlockUser->client_id = $cmn->setVal(trim($cmn->readValueSubmission($_POST["hdnclient_id"],"")));
	
	$objSecurityBlockUser->user = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtuser"],"")));
	
	$objSecurityBlockUser->reason = $cmn->setVal(trim($cmn->readValueHTML($_POST["txtreason"],"")));
	
	$objSecurityBlockUser->created_by = $cmn->getSession(ADMIN_USER_ID);
	
	$objSecurityBlockUser->updated_by = $cmn->getSession(ADMIN_USER_ID);
	
?>