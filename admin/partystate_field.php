<?php	
	if(isset($_REQUEST["party_state_id"]) && $_REQUEST["party_state_id"] > 0)
	{
		$objpartystate->setAllValues($_REQUEST["party_state_id"]);
		$objpartystate->party_state_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["party_state_id"],"")));
	}	
	
	$objpartystate->state_id = $cmn->setVal(trim($cmn->readValue($_POST["selState"],"")));
	$objpartystate->party_id = $cmn->setVal(trim($cmn->readValue($_POST["selParty"],"")));
	
$objpartystate->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objpartystate->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>