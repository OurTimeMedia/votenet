<?php	
if ( isset($_REQUEST['btnsave']))
{
	$objvalidation = new validation();
	$defaultlanguage_id = intval($_REQUEST["hdndefaultlanguage_id"]);
	$idnumber_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["id_number_id"],"")));
	include("id_number_field.php");
		
	$objvalidation->addValidation("id_number_name_".$defaultlanguage_id, "ID Number Name ", "req");
	$objvalidation->addValidation("id_number_name_".$defaultlanguage_id, "ID Number Name ", "dupli", "", DB_PREFIX."id_number|id_number_name|id_number_id|".$idnumber_id."|1|1");
			
	if ($objvalidation->validate())
	{			
		//Code to add record
		if (trim($mode) == 'add')
		{
			$id_number_id = $objid_number->addid_number();				
		}
		else if (trim($mode) == 'edit')
		{						
			$objid_number->updateid_number();				
		}
		
		$objLanguage = new language();
		$aLanguage = $objLanguage->fetchAllAsArray();
		
		for($i=0;$i<count($aLanguage);$i++)
		{
			if(isset($_POST['language']) && in_array($aLanguage[$i]['language_id'], $_POST['language']))
			{
				$objid_number->id_number_name = $_POST['id_number_name_'.$aLanguage[$i]['language_id']];
				
				if($objid_number->id_number_name!="")
				{
					$objid_number->createLanguageDetailForIdNumber($aLanguage[$i]['language_id']);
				}
				else
				{
					$objid_number->deleteLanguageDetailForIdNumber($aLanguage[$i]['language_id']);
				}
			}
			else
			{
				$objid_number->deleteLanguageDetailForIdNumber($aLanguage[$i]['language_id']);
			}
		}
		
		if (trim($mode) == 'add')
			$msg->sendMsg("id_number_list.php","ID Number ",3);
		else if (trim($mode) == 'edit')
			$msg->sendMsg("id_number_list.php","ID Number ",4);
		exit;	
	}
}

if (isset($_POST["btndelete"]))
{
	//Code to delete selected record.
	if (trim($mode) == DELETE)
	{
		if (count($_POST['id_number_id']) == 0)
		{
			$msg->sendMsg("id_number_list.php","ID Number ",9);
			exit();
		}
		else
		{
			$objid_number->deleteAllLanguageDetailForIdNumber($_REQUEST['id_number_id']);
			$objid_number->deleteid_number($_REQUEST['id_number_id']);			
			$msg->sendMsg("id_number_list.php","ID Number ",5);
			exit();			
		}
	}
}
?>