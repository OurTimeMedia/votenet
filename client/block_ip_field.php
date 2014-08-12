<?php

	$objSecurityBlockIP->block_ipaddress_id = $cmn->setVal(trim($cmn->readValueSubmission($objEncDec->decrypt($_POST["hdnblock_ipaddress_id"]),"")));

	$objSecurityBlockIP->client_id = $cmn->setVal(trim($cmn->readValueSubmission($_POST["hdnclient_id"],"")));
	
	$objSecurityBlockIP->ipaddress = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtipaddress"],"")));
	
	$objSecurityBlockIP->reason = $cmn->setVal(trim($cmn->readValueHTML($_POST["txtreason"],"")));
	
	$objSecurityBlockIP->created_by = $cmn->getSession(ADMIN_USER_ID);
	 
	$objSecurityBlockIP->updated_by = $cmn->getSession(ADMIN_USER_ID);
	
?>