<?php	
	if(isset($_REQUEST["eligibility_state_id"]) && $_REQUEST["eligibility_state_id"] > 0)
	{
		$objStateElig->setAllValues($_REQUEST["eligibility_state_id"]);
		$objStateElig->eligibility_state_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["eligibility_state_id"],"")));
	}	
	
	$objStateElig->state_id = $cmn->setVal(trim($cmn->readValue($_POST["selState"],"")));
	$objStateElig->eligibility_criteria_id = $cmn->setVal(trim($cmn->readValue($_POST["selEligibilityCriteria"],"")));
	
	$objStateElig->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objStateElig->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>