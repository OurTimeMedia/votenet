<?php	
if ( isset($_REQUEST['btnsave']))
{
	$objvalidation = new validation();
	$defaultlanguage_id = intval($_REQUEST["hdndefaultlanguage_id"]);
	$racegroup_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["race_group_id"],"")));
	include("race_group_field.php");
		
	$objvalidation->addValidation("race_group_name_".$defaultlanguage_id, "Race Group Name", "req");
	$objvalidation->addValidation("race_group_name_".$defaultlanguage_id, "Race Group Name ", "dupli", "", DB_PREFIX."race_group|race_group_name|race_group_id|".$racegroup_id."|1|1");
	
	if ($objvalidation->validate())
	{	
		//Code to add record
		if (trim($mode) == 'add')
		{
			$race_group_id = $objrace_group->addrace_group();				
		}
		else if (trim($mode) == 'edit')
		{						
			$objrace_group->updaterace_group();				
		}
		
		$objLanguage = new language();
		$aLanguage = $objLanguage->fetchAllAsArray();
		
		for($i=0;$i<count($aLanguage);$i++)
		{
			if(isset($_POST['language']) && in_array($aLanguage[$i]['language_id'], $_POST['language']))
			{
				$objrace_group->race_group_name = $_POST['race_group_name_'.$aLanguage[$i]['language_id']];
				
				if($objrace_group->race_group_name!="")
				{
					$objrace_group->createLanguageDetailForRaceGroup($aLanguage[$i]['language_id']);
				}
				else
				{
					$objrace_group->deleteLanguageDetailForRaceGroup($aLanguage[$i]['language_id']);
				}
			}
			else
			{
				$objrace_group->deleteLanguageDetailForRaceGroup($aLanguage[$i]['language_id']);
			}
		}	
		
		if (trim($mode) == 'add')
			$msg->sendMsg("race_group_list.php","Race Group ",3);
		else if (trim($mode) == 'edit')
			$msg->sendMsg("race_group_list.php","Race Group ",4);
		exit;	
	}
}

if (isset($_POST["btndelete"]))
{
	//Code to delete selected record.
	if (trim($mode) == DELETE)
	{
		if (count($_POST['race_group_id']) == 0)
		{
			$msg->sendMsg("race_group_list.php","Race Group ",9);
			exit();
		}
		else
		{
			$objrace_group->deleteAllLanguageDetailForRaceGroup($_REQUEST['race_group_id']);
			$objrace_group->deleterace_group($_REQUEST['race_group_id']);			
			$msg->sendMsg("race_group_list.php","Race Group ",5);
			exit();			
		}
	}
}
?>