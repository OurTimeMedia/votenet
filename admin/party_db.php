<?php	
if ( isset($_REQUEST['btnsave']))
{
	$objvalidation = new validation();
	$defaultlanguage_id = intval($_REQUEST["hdndefaultlanguage_id"]);
	include("party_field.php");
	
	$party_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["party_id"],"")));
		
	$objvalidation->addValidation("party_name_".$defaultlanguage_id, "Party Name ", "req");
	$objvalidation->addValidation("party_name_".$defaultlanguage_id, "Party Name ", "dupli", "", DB_PREFIX."party|party_name|party_id|".$party_id."|1|1");
			
	if ($objvalidation->validate())
	{	
		//Code to add record
		if (trim($mode) == 'add')
		{
			$party_id = $objparty->addparty();				
		}
		else if (trim($mode) == 'edit')
		{						
			$objparty->updateparty();				
		}
		
		$objLanguage = new language();
		$aLanguage = $objLanguage->fetchAllAsArray();
		
		for($i=0;$i<count($aLanguage);$i++)
		{
			if(isset($_POST['language']) && in_array($aLanguage[$i]['language_id'], $_POST['language']))
			{
				$objparty->party_name = $_POST['party_name_'.$aLanguage[$i]['language_id']];
				
				if($objparty->party_name!="")
				{
					$objparty->createLanguageDetailForParty($aLanguage[$i]['language_id']);
				}
				else
				{
					$objparty->deleteLanguageDetailForParty($aLanguage[$i]['language_id']);
				}
			}
			else
			{
				$objparty->deleteLanguageDetailForParty($aLanguage[$i]['language_id']);
			}
		}	
		
		if (trim($mode) == 'add')
			$msg->sendMsg("party_list.php","Party ",3);
		else if (trim($mode) == 'edit')
			$msg->sendMsg("party_list.php","Party ",4);
		exit;	
	}
}

if (isset($_POST["btndelete"]))
{
	//Code to delete selected record.
	if (trim($mode) == DELETE)
	{
		if (count($_POST['party_id']) == 0)
		{
			$msg->sendMsg("party_list.php","Party ",9);
			exit();
		}
		else
		{
			$objparty->deleteAllLanguageDetailForParty($_REQUEST['party_id']);
			$objparty->deleteparty($_REQUEST['party_id']);			
			$msg->sendMsg("party_list.php","Party ",5);
			exit();			
		}
	}
}
?>