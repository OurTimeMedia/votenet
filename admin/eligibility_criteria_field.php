<?php	
	if(isset($_REQUEST["eligibility_criteria_id"]) && $_REQUEST["eligibility_criteria_id"] > 0)
	{
		$objEligCrit->setAllValues($_REQUEST["eligibility_criteria_id"]);
		$objEligCrit->eligibility_criteria_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["eligibility_criteria_id"],"")));
	}	
	
	$objEligCrit->eligibility_criteria = $cmn->setVal(trim($cmn->readValue($_POST["eligibility_criteria_".$defaultlanguage_id],"")));
	$objEligCrit->for_all_state = $cmn->setVal(trim($cmn->readValue($_POST["for_all_state"],"")));
	$objEligCrit->eligibility_active = $cmn->setVal(trim($cmn->readValue($_POST["eligibility_active"],"")));
	
	$objEligCrit->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objEligCrit->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>