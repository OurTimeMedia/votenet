<?php	
if ( isset($_REQUEST['btnEligibilityCriteria']))
{
	$objvalidation = new validation();
	
	$objvalidation->addValidation("selState", "State ", "req");
	$objvalidation->addValidation("selEligibilityCriteria", "Eligibility Criteria ", "req");
			
	if ($objvalidation->validate())
	{	
		//Code to assign value of control to all property of object.
		include("eligibility_state_field.php");
		
		//Code to add record
		if (trim($mode) == 'add')
		{
			$eligibility_state_id = $objStateElig->addStateEligibility($_POST);				
		}
		else if (trim($mode) == 'edit')
		{						
			$objStateElig->updateStateEligibility();				
		}
		
		if (trim($mode) == 'add')
			$msg->sendMsg("eligibility_state_list.php","State - Eligibility Criteria Join ",3);
		else if (trim($mode) == 'edit')
			$msg->sendMsg("eligibility_state_list.php","State - Eligibility Criteria Join ",4);
		exit;	
	}
}

if (isset($_POST["btndelete"]))
{
	//Code to delete selected record.
	if (trim($mode) == DELETE)
	{
		if (count($_REQUEST['state_id']) == 0)
		{
			$msg->sendMsg("eligibility_state_list.php","State - Eligibility Criteria Join ",9);
			exit();
		}
		else
		{
			$objStateElig->deleteStateEligibility($_REQUEST['state_id']);			
			$msg->sendMsg("eligibility_state_list.php","State - Eligibility Criteria Join ",5);
			exit();			
		}
	}
}
?>