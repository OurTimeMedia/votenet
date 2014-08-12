<?php	
	if(isset($_REQUEST["idnumber_state_id"]) && $_REQUEST["idnumber_state_id"] > 0)
	{
		$objStateIdNumber->setAllValues($_REQUEST["idnumber_state_id"]);
		$objStateIdNumber->idnumber_state_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["idnumber_state_id"],"")));
	}	
	
	$objStateIdNumber->state_id = $cmn->setVal(trim($cmn->readValue($_POST["selState"],"")));
	$objStateIdNumber->id_number_id = $cmn->setVal(trim($cmn->readValue($_POST["selidnumber"],"")));
	
	$objStateIdNumber->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objStateIdNumber->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>