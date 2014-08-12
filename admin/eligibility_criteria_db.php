<?php	
if ( isset($_REQUEST['btnsave']))
{
	$objvalidation = new validation();
	$defaultlanguage_id = intval($_REQUEST["hdndefaultlanguage_id"]);
	
	$objvalidation->addValidation("eligibility_criteria_".$defaultlanguage_id, "Eligibility Criteria ", "req");
			
	if ($objvalidation->validate())
	{	
		//Code to assign value of control to all property of object.
		include("eligibility_criteria_field.php");
		
		//Code to add record
		if (trim($mode) == 'add')
		{
			$eligibility_criteria_id = $objEligCrit->addEligibilityCriteria();				
		}
		else if (trim($mode) == 'edit')
		{						
			$objEligCrit->updateEligibilityCriteria();				
		}
		
		$objLanguage = new language();
		$aLanguage = $objLanguage->fetchAllAsArray();
		//print_r($_POST);
		//exit;
		for($i=0;$i<count($aLanguage);$i++)
		{
			if(isset($_POST['language']) && in_array($aLanguage[$i]['language_id'], $_POST['language']))
			{
				$objEligCrit->eligibility_criteria = $_POST['eligibility_criteria_'.$aLanguage[$i]['language_id']];
				
				if($objEligCrit->eligibility_criteria!="")
				{
					$objEligCrit->createLanguageDetailForEligibilityCriteria($aLanguage[$i]['language_id']);
				}
				else
				{
					$objEligCrit->deleteLanguageDetailForEligibilityCriteria($aLanguage[$i]['language_id']);
				}
			}
			else
			{
				$objEligCrit->deleteLanguageDetailForEligibilityCriteria($aLanguage[$i]['language_id']);
			}
		}	
		
		if (trim($mode) == 'add')
			$msg->sendMsg("eligibility_criteria_list.php","Eligibility Criteria ",3);
		else if (trim($mode) == 'edit')
			$msg->sendMsg("eligibility_criteria_list.php","Eligibility Criteria ",4);
		exit;	
	}
}

if (isset($_POST["btndelete"]))
{
	//Code to delete selected record.
	if (trim($mode) == DELETE)
	{
		if (count($_POST['eligibility_criteria_id']) == 0)
		{
			$msg->sendMsg("eligibility_criteria_list.php","Eligibility Criteria ",9);
			exit();
		}
		else
		{
			$objEligCrit->deleteAllLanguageDetailForEligibilityCriteria($_REQUEST['eligibility_criteria_id']);
			$objEligCrit->deleteEligibilityCriteria($_REQUEST['eligibility_criteria_id']);			
			$msg->sendMsg("eligibility_criteria_list.php","Eligibility Criteria ",5);
			exit();			
		}
	}
}
?>