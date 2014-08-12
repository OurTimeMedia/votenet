<?php	
	if(isset($_REQUEST["party_id"]) && $_REQUEST["party_id"] > 0)
	{
		$objparty->setAllValues($_REQUEST["party_id"]);
		$objparty->party_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["party_id"],"")));
	}	
	
	$objparty->party_name = $cmn->setVal(trim($cmn->readValue($_POST["party_name_".$defaultlanguage_id],"")));
	$objparty->party_active = $cmn->setVal(trim($cmn->readValue($_POST["party_active"],"")));
	
	$objparty->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objparty->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>