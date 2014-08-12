<?php

	$objSecurityBlockIP->block_ipaddress_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnblock_ipaddress_id"],"")));

	$objSecurityBlockIP->client_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnclient_id"],"")));
	
	$objSecurityBlockIP->ipaddress = $cmn->setVal(trim($cmn->readValue($_POST["txtipaddress"],"")));
	
	$objSecurityBlockIP->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	
	$objSecurityBlockIP->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	
?>