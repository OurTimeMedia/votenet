<?php

	$objSecurityBlockUser->blockuser_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnblockuser_id"],"")));

	$objSecurityBlockUser->client_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnclient_id"],"")));
	
	$objSecurityBlockUser->voter_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnvoter_id"],"")));
	
	$objSecurityBlockUser->user = $cmn->setVal(trim($cmn->readValue($_POST["txtuser"],"")));
	
	$objSecurityBlockUser->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	
	$objSecurityBlockUser->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	
?>