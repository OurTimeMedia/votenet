<?php

if(isset($_REQUEST['btnsave']))
{
	//validation
	$objvalidation = new validation();
	$defaultlanguage_id = intval($_REQUEST["hdndefaultlanguage_id"]);
	include("election_type_field.php");
	
	$election_type_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["election_type_id"],"")));
	
	$objvalidation->addValidation("election_type_name_".$defaultlanguage_id, "Election Type Name ", "req");
	$objvalidation->addValidation("election_type_name_".$defaultlanguage_id, "Election Type Name ", "dupli", "", DB_PREFIX."election_type|election_type_name|election_type_id|".$election_type_id."|1|1");
	
	if ($objvalidation->validate())
	{	
		//Code to add record
		if (trim($mode) == 'add')
		{
			$election_type_id = $objelection_type->addelection_type();				
		}
		else if (trim($mode) == 'edit')
		{						
			$objelection_type->updateelection_type();				
		}
		
		//fetch all language data
		$objLanguage = new language();
		$aLanguage = $objLanguage->fetchAllAsArray();
		
		for($i=0;$i<count($aLanguage);$i++)
		{
			if(isset($_POST['language']) && in_array($aLanguage[$i]['language_id'], $_POST['language']))
			{
				$objelection_type->election_type_name = $_POST['election_type_name_'.$aLanguage[$i]['language_id']];
				
				if($objelection_type->election_type_name!="")
				{
					$objelection_type->createLanguageDetailForElectionType($aLanguage[$i]['language_id']);
				}
				else
				{
					$objelection_type->deleteLanguageDetailForElectionType($aLanguage[$i]['language_id']);
				}
			}
			else
			{
				$objelection_type->deleteLanguageDetailForElectionType($aLanguage[$i]['language_id']);
			}
		}	
		
		if (trim($mode) == 'add')
			$msg->sendMsg("election_type_list.php","Election Type ",3);
		else if (trim($mode) == 'edit')
			$msg->sendMsg("election_type_list.php","Election Type ",4);
		exit;	
	}
}

if (isset($_POST["btndelete"]))
{
	//Code to delete selected record.
	if (trim($mode) == DELETE)
	{
		if (count($_POST['election_type_id']) == 0)
		{
			$msg->sendMsg("election_type_list.php","Election Type ",9);
			exit();
		}
		else
		{
			$objelection_type->deleteAllLanguageDetailForElectionType($_REQUEST['election_type_id']);
			$objelection_type->deleteelection_type($_REQUEST['election_type_id']);			
			$msg->sendMsg("election_type_list.php","Election Type ",5);
			exit();			
		}
	}
}
?>