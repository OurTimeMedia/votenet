<?php	
if ( isset($_REQUEST['btnsave']))
{
	$objvalidation = new validation();
	$defaultlanguage_id = intval($_REQUEST["hdndefaultlanguage_id"]);
	
	include("state_field.php");
	
	if(isset($_REQUEST["state_id"]) && $_REQUEST["state_id"] > 0)
	{	
		$state_id = intval($_REQUEST["state_id"]);
		
		$objvalidation->addValidation("state_code", "State Code", "req");
		$objvalidation->addValidation("state_code", "State Code", "dupli" , "",DB_PREFIX."state|state_code|state_id|".$state_id."|1|1");
	}
	else
	{
		$objvalidation->addValidation("state_code", "State Code", "req");
		$objvalidation->addValidation("state_code", "State Code", "dupli" , "",DB_PREFIX."state|state_code|state_id");
	}		

	$objvalidation->addValidation("state_name_".$defaultlanguage_id, "State Name", "req");
	/* $objvalidation->addValidation("state_secretary_fname_".$defaultlanguage_id, "Secretary First Name", "req");
	$objvalidation->addValidation("state_secretary_mname_".$defaultlanguage_id, "Secretary Middle Name", "req");
	$objvalidation->addValidation("state_secretary_lname_".$defaultlanguage_id, "Secretary Last Name", "req");
	$objvalidation->addValidation("state_address1_".$defaultlanguage_id, "Address1", "req");
	$objvalidation->addValidation("state_address2_".$defaultlanguage_id, "Address2", "req");
	$objvalidation->addValidation("state_city_".$defaultlanguage_id, "City", "req");
	$objvalidation->addValidation("email", "Email", "req");
	$objvalidation->addValidation("email", "Email", "email");*/
			
	if ($objvalidation->validate())
	{	
		//Code to add record
		if (trim($mode) == 'add')
		{
			$state_id = $objstate->addstate();				
		}
		else if (trim($mode) == 'edit')
		{						
			$objstate->updatestate();				
		}
		
		$objLanguage = new language();
		$aLanguage = $objLanguage->fetchAllAsArray();
		
		for($i=0;$i<count($aLanguage);$i++)
		{
			if(isset($_POST['language']) && in_array($aLanguage[$i]['language_id'], $_POST['language']))
			{
				$objstate->state_name = $_POST['state_name_'.$aLanguage[$i]['language_id']];
				$objstate->state_secretary_fname = $_POST['state_secretary_fname_'.$aLanguage[$i]['language_id']];
				$objstate->state_secretary_mname = $_POST['state_secretary_mname_'.$aLanguage[$i]['language_id']];					
				$objstate->state_secretary_lname = $_POST['state_secretary_lname_'.$aLanguage[$i]['language_id']];
				$objstate->state_address1 = $_POST['state_address1_'.$aLanguage[$i]['language_id']];
				$objstate->state_address2 = $_POST['state_address2_'.$aLanguage[$i]['language_id']];
				$objstate->state_city = $_POST['state_city_'.$aLanguage[$i]['language_id']];
				
				if($objstate->state_name!="" || $objstate->state_secretary_fname!="" || $objstate->state_secretary_mname!="" || $objstate->state_secretary_lname!="" || $objstate->state_address1!="" || $objstate->state_address2!="" || $objstate->state_city!="")
				{
					$objstate->createLanguageDetailForState($aLanguage[$i]['language_id']);
				}
				else
				{
					$objstate->deleteLanguageDetailForState($aLanguage[$i]['language_id']);
				}
			}
			else
			{
				$objstate->deleteLanguageDetailForState($aLanguage[$i]['language_id']);
			}
		}	
		
		if (trim($mode) == 'add')
			$msg->sendMsg("state_list.php","State ",3);
		else if (trim($mode) == 'edit')
			$msg->sendMsg("state_list.php","State ",4);
		exit;	
	}
}

if (isset($_POST["btndelete"]))
{
	//Code to delete selected record.
	if (trim($mode) == DELETE)
	{
		if (count($_POST['state_id']) == 0)
		{
			$msg->sendMsg("state_list.php","State ",9);
			exit();
		}
		else
		{
			$objstate->deleteAllLanguageDetailForState($_REQUEST['state_id']);
			$objstate->deletestate($_REQUEST['state_id']);			
			$msg->sendMsg("state_list.php","State ",5);
			exit();			
		}
	}
}
?>