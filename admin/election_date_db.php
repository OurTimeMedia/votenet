<?php	
if ( isset($_REQUEST['btnsave']))
{
	//assign validation
	$objvalidation = new validation();
	$defaultlanguage_id = intval($_REQUEST["hdndefaultlanguage_id"]);
		
	$objvalidation->addValidation("selElectionType", "Election Type", "req");
	$objvalidation->addValidation("selState", "State", "req");	
	$objvalidation->addValidation("election_date", "Election Date", "req");	
	$objvalidation->addValidation("election_description_".$defaultlanguage_id, "Description", "req");
	$objvalidation->addValidation("reg_deadline_date", "Registration Deadline Date", "req");	
	//$objvalidation->addValidation("reg_deadline_description_".$defaultlanguage_id, "Registration Deadline Description", "req");
	// check validation response		
	if ($objvalidation->validate())
	{	
		//Code to assign value of control to all property of object.
		include("election_date_field.php");
		
		$objElectionDate->election_date = $cmn->setVal(trim($cmn->readValue($cmn->convertFormtDate($objElectionDate->election_date),"")));
		$objElectionDate->reg_deadline_date = $cmn->setVal(trim($cmn->readValue($cmn->convertFormtDate($objElectionDate->reg_deadline_date),"")));
		
		//Code to add record
		if (trim($mode) == 'add')
		{
			$election_date_id = $objElectionDate->addelection_date();				
		}
		else if (trim($mode) == 'edit')//code to update record
		{						
			$objElectionDate->updateelection_date();				
		}
		
		//fetch all language details
		$objLanguage = new language();
		$aLanguage = $objLanguage->fetchAllAsArray();
		
		//set all langauge wise detail
		for($i=0;$i<count($aLanguage);$i++)
		{
			if(isset($_POST['language']) && in_array($aLanguage[$i]['language_id'], $_POST['language']))
			{
				$objElectionDate->election_description = $_POST['election_description_'.$aLanguage[$i]['language_id']];
				$objElectionDate->reg_deadline_description = $_POST['reg_deadline_description_'.$aLanguage[$i]['language_id']];
								
				if($objElectionDate->election_description!="" || $objElectionDate->reg_deadline_description!="")
				{
					$objElectionDate->createLanguageDetailForElectionDate($aLanguage[$i]['language_id']);
				}
				else
				{
					$objElectionDate->deleteLanguageDetailForElectionDate($aLanguage[$i]['language_id']);
				}
			}
			else
			{
				$objElectionDate->deleteLanguageDetailForElectionDate($aLanguage[$i]['language_id']);
			}
		}	
		
		if (trim($mode) == 'add')
			$msg->sendMsg("election_date_list.php","Election Date ",3);
		else if (trim($mode) == 'edit')
			$msg->sendMsg("election_date_list.php","Election Date ",4);
		exit;	
	}
}

if (isset($_POST["btndelete"]))
{
	//Code to delete selected record.
	if (trim($mode) == DELETE)
	{
		if (count($_POST['election_date_id']) == 0)
		{
			$msg->sendMsg("election_date_list.php","Election Date ",9);
			exit();
		}
		else
		{
			$objElectionDate->deleteAllLanguageDetailForElectionDate($_REQUEST['election_date_id']);
			$objElectionDate->deleteelection_date($_REQUEST['election_date_id']);			
			$msg->sendMsg("election_date_list.php","Election Date ",5);
			exit();			
		}
	}
}
?>