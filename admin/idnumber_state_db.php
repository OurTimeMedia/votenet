<?php	
if ( isset($_REQUEST['btnidnumbersave']))
{
	$objvalidation = new validation();
	
	$objvalidation->addValidation("selState", "State ", "req");
	$objvalidation->addValidation("selidnumber", "ID Number ", "req");
					//echo $mode;exit;
	if ($objvalidation->validate())
	{	
		//Code to assign value of control to all property of object.
		include("idnumber_state_field.php");

		//Code to add record
		if (trim($mode) == 'add')
		{
			$idnumber_state_id = $objStateIdNumber->addStateidnumber($_POST);
		}
		else if (trim($mode) == 'edit')
		{						
			$objStateIdNumber->updateStateRaceGroup();				
		}
		
		$objLanguage = new language();
		$aLanguage = $objLanguage->fetchAllAsArray();
		
		for($i=0;$i<count($aLanguage);$i++)
		{
			$objStateIdNumber->state_idnumber_note_text = $_POST['id_number_note_'.$aLanguage[$i]['language_id']];
			
			if($objStateIdNumber->state_idnumber_note_text!="")
			{
				$objStateIdNumber->createLanguageDetailForIdNumberNote($aLanguage[$i]['language_id']);
			}
			else
			{
				$objStateIdNumber->deleteLanguageDetailForIdNumberNote($aLanguage[$i]['language_id']);
			}
		}
		
		if (trim($mode) == 'add')
			$msg->sendMsg("idnumber_state_list.php","State - ID Number Join ",3);
		else if (trim($mode) == 'edit')
			$msg->sendMsg("idnumber_state_list.php","State - ID Number Join ",4);
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
			$msg->sendMsg("idnumber_state_list.php","State - ID Number Join ",9);
			exit();
		}
		else
		{
			$objidnumber->deleteStateIDNumber($_REQUEST['state_id']);			
			$msg->sendMsg("idnumber_state_list.php","State - ID Number Join ",5);
			exit();			
		}
	}
}
?>