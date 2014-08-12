<?php	
if ( isset($_REQUEST['btnsave']))
{
	$objvalidation = new validation();
	$defaultlanguage_id = intval($_REQUEST["hdndefaultlanguage_id"]);
	
	$objvalidation->addValidation("selState", "State ", "req");
	$objvalidation->addValidation("poll_booth_address1_".$defaultlanguage_id, "Address1 ", "req");
	$objvalidation->addValidation("poll_booth_city_".$defaultlanguage_id, "City ", "req");
				
	if ($objvalidation->validate())
	{	
		//Code to assign value of control to all property of object.
		include("poll_booth_address_field.php");
		
		//Code to add record
		if (trim($mode) == 'add')
		{
			$poll_booth_id = $objPollBooth->addPollBooth();				
		}
		else if (trim($mode) == 'edit')
		{						
			$objPollBooth->updatePollBooth();				
		}
		
		$objLanguage = new language();
		$aLanguage = $objLanguage->fetchAllAsArray();
		
		for($i=0;$i<count($aLanguage);$i++)
		{
			if(isset($_POST['language']) && in_array($aLanguage[$i]['language_id'], $_POST['language']))
			{
				$objPollBooth->poll_booth_id = $poll_booth_id;
				$objPollBooth->official_title = $_POST['official_title_'.$aLanguage[$i]['language_id']];
				$objPollBooth->building_name = $_POST['building_name_'.$aLanguage[$i]['language_id']];
				$objPollBooth->poll_booth_address1 = $_POST['poll_booth_address1_'.$aLanguage[$i]['language_id']];
				$objPollBooth->poll_booth_address2 = $_POST['poll_booth_address2_'.$aLanguage[$i]['language_id']];
				$objPollBooth->poll_booth_city = $_POST['poll_booth_city_'.$aLanguage[$i]['language_id']];
				
				if($objPollBooth->poll_booth_address1!="")
				{
					$objPollBooth->createLanguageDetailForPollBooth($aLanguage[$i]['language_id']);
				}
				else
				{
					$objPollBooth->deleteLanguageDetailForPollBooth($aLanguage[$i]['language_id']);
				}
			}
			else
			{
				$objPollBooth->deleteLanguageDetailForPollBooth($aLanguage[$i]['language_id']);
			}
		}	
		
		if (trim($mode) == 'add')
			$msg->sendMsg("poll_booth_address_list.php","State Voter Registration Office Location ",3);
		else if (trim($mode) == 'edit')
			$msg->sendMsg("poll_booth_address_list.php","State Voter Registration Office Location ",4);
		exit;	
	}
}

if (isset($_POST["btndelete"]))
{
	//Code to delete selected record.
	if (trim($mode) == DELETE)
	{
		if (count($_POST['poll_booth_id']) == 0)
		{
			$msg->sendMsg("poll_booth_address_list.php","State Voter Registration Office Location ",9);
			exit();
		}
		else
		{
			$objPollBooth->deletePollBooth($_REQUEST['poll_booth_id']);			
			$objPollBooth->deleteAllLanguageDetailForIdNumber($_REQUEST['poll_booth_id']);
			$msg->sendMsg("poll_booth_address_list.php","State Voter Registration Office Location ",5);
			exit();			
		}
	}
}
?>