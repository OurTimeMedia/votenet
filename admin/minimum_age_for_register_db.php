<?php	
if (isset($_REQUEST['btnUpdate']))
{	
	foreach($_POST as $pkey=>$pval)
	{
		$objstate = new state();
		$pkeyarr = array();
		$pkeyarr = explode("_", $pkey);
		
		if($pkeyarr[0] == "txtNote")
		{
			if(count($pkeyarr) > 2)
			{
				$objstate->state_id = $pkeyarr[1];
				$objstate->language_id = $pkeyarr[2];
				$objstate->state_minimum_age_text = $pval;
				
				$objstate->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);		
				$objstate->updateMinimumAgeDetailLanguage();					
			}
			else
			{
				$objstate->state_id = $pkeyarr[1];
				
				$objstate->state_minimum_age_criteria = "";
				if(isset($_POST['chkAgeCriteria_'.$pkeyarr[1]]))
					$objstate->state_minimum_age_criteria = implode(",", $_POST['chkAgeCriteria_'.$pkeyarr[1]]);
				
				$objstate->state_minimum_age_criteria_election_type = "";
				if(isset($_POST['chkAgeCriteria_'.$pkeyarr[1]]) && in_array(5, $_POST['chkAgeCriteria_'.$pkeyarr[1]]))
					$objstate->state_minimum_age_criteria_election_type = implode(",", $_POST['selElectionType_'.$pkeyarr[1]]);
					
				$objstate->state_minimum_age_text = $pval;
				$objstate->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
				$objstate->updateMinimumAgeDetail();
			}	
		}	
	}
	
	$msg->sendMsg("minimum_age_for_register.php","Minimum Age for Register to Vote ",4);
	exit;
}
?>