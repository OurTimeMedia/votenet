<?php	
	//assign values to class object
	if(isset($_REQUEST["election_date_id"]) && $_REQUEST["election_date_id"] > 0)
	{
		$objElectionDate->setAllValues($_REQUEST["election_date_id"]);
		$objElectionDate->election_date_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["election_date_id"],"")));
	}	
	
	$objElectionDate->election_type_id = $cmn->setVal(trim($cmn->readValue($_POST["selElectionType"],"")));
	$objElectionDate->state_id = $cmn->setVal(trim($cmn->readValue($_POST["selState"],"")));
	$objElectionDate->election_date = $cmn->setVal(trim($cmn->readValue($_POST["election_date"],"")));
	$objElectionDate->election_description = $cmn->setVal(trim($cmn->readValue($_POST["election_description_".$defaultlanguage_id],"")));
	$objElectionDate->reg_deadline_date = $cmn->setVal(trim($cmn->readValue($_POST["reg_deadline_date"],"")));
	$objElectionDate->reg_deadline_description = $cmn->setVal(trim($cmn->readValue($_POST["reg_deadline_description_".$defaultlanguage_id],"")));
		
	$objElectionDate->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objElectionDate->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>