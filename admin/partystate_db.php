<?php	
if ( isset($_REQUEST['btnpartysave']))
{
	$objvalidation = new validation();
	
	$objvalidation->addValidation("selState", "State ", "req");
	$objvalidation->addValidation("selParty", "Party ", "req");
			
	if ($objvalidation->validate())
	{	
		//Code to assign value of control to all property of object.
		include("partystate_field.php");
	
		//Code to add record
		if (trim($mode) == 'add')
		{
			$party_state_id = $objpartystate->addStateParty($_POST);	
		}
		else if (trim($mode) == 'edit')
		{						
			$objpartystate->updateStateParty();				
		}
		
		if (trim($mode) == 'add')
			$msg->sendMsg("partystate_list.php","State - Party Join ",3);
		else if (trim($mode) == 'edit')
			$msg->sendMsg("partystate_list.php","State - Party Join ",4);
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
			$msg->sendMsg("partystate_list.php","State - Party Join ",9);
			exit();
		}
		else
		{
			$objPartyState->deleteStateParty($_REQUEST['state_id']);		
			$msg->sendMsg("partystate_list.php","State - Party Join ",5);
			exit();			
		}
	}
}
?>