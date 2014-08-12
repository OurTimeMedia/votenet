<?php	
if ( isset($_REQUEST['btnracegroupsave']))
{
	$objvalidation = new validation();
	$objvalidation->addValidation("selState", "State ", "req");
	$objvalidation->addValidation("selRaceGroup", "Race Group ", "req");
			
	if ($objvalidation->validate())
	{	
		//Code to assign value of control to all property of object.
		include("racegroup_state_field.php");
		//echo $mode;exit;
		//Code to add record
		if (trim($mode) == 'add')
		{
			$racegroup_state_id = $objStateRaceGroup->addStateRaceGroup($_POST);				
		}
		else if (trim($mode) == 'edit')
		{						
			$objStateRaceGroup->updateStateRaceGroup();				
		}
		
		if (trim($mode) == 'add')
			$msg->sendMsg("racegroup_state_list.php","State - Race Group Join ",3);
		else if (trim($mode) == 'edit')
			$msg->sendMsg("racegroup_state_list.php","State - Race Group Join ",4);
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
			$msg->sendMsg("racegroup_state_list.php","State - Race Group Join ",9);
			exit();
		}
		else
		{
			$objStateRaceGroup->deleteStateRaceGroup($_REQUEST['state_id']);			
			$msg->sendMsg("racegroup_state_list.php","State - Race Group Join ",5);
			exit();			
		}
	}
}
?>