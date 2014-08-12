<?php	
	if(isset($_REQUEST["racegroup_state_id"]) && $_REQUEST["racegroup_state_id"] > 0)
	{
		$objStateRaceGroup->setAllValues($_REQUEST["racegroup_state_id"]);
		$objStateRaceGroup->racegroup_state_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["racegroup_state_id"],"")));
	}	
	
	$objStateRaceGroup->state_id = $cmn->setVal(trim($cmn->readValue($_POST["selState"],"")));
	$objStateRaceGroup->race_group_id = $cmn->setVal(trim($cmn->readValue($_POST["selRaceGroup"],"")));
	
	$objStateRaceGroup->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objStateRaceGroup->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>