<?php	
	if(isset($_REQUEST["poll_booth_id"]) && $_REQUEST["poll_booth_id"] > 0)
	{
		$objPollBooth->setAllValues($_REQUEST["poll_booth_id"]);
		$objPollBooth->poll_booth_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["poll_booth_id"],"")));
	}	
	
	$objPollBooth->state_id = $cmn->setVal(trim($cmn->readValue($_POST["selState"],"")));
	$objPollBooth->poll_booth_for = $cmn->setVal(trim($cmn->readValue($_POST["poll_booth_for"],"")));
	$objPollBooth->poll_booth_country = $cmn->setVal(trim($cmn->readValue($_POST["poll_booth_country"],"")));
	$objPollBooth->official_title = $cmn->setVal(trim($cmn->readValue($_POST["official_title_".$defaultlanguage_id],"")));
	$objPollBooth->building_name = $cmn->setVal(trim($cmn->readValue($_POST["building_name_".$defaultlanguage_id],"")));
	$objPollBooth->poll_booth_address1 = $cmn->setVal(trim($cmn->readValue($_POST["poll_booth_address1_".$defaultlanguage_id],"")));
	$objPollBooth->poll_booth_address2 = $cmn->setVal(trim($cmn->readValue($_POST["poll_booth_address2_".$defaultlanguage_id],"")));
	$objPollBooth->poll_booth_city = $cmn->setVal(trim($cmn->readValue($_POST["poll_booth_city_".$defaultlanguage_id],"")));
	$objPollBooth->poll_booth_zipcode = $cmn->setVal(trim($cmn->readValue($_POST["poll_booth_zipcode"],"")));
	$objPollBooth->poll_booth_phone = $cmn->setVal(trim($cmn->readValue($_POST["poll_booth_phone"],"")));
	$objPollBooth->poll_booth_fax = $cmn->setVal(trim($cmn->readValue($_POST["poll_booth_fax"],"")));
	$objPollBooth->url = $cmn->setVal(trim($cmn->readValue($_POST["url"],"")));
	$objPollBooth->poll_booth_url = $cmn->setVal(trim($cmn->readValue($_POST["poll_booth_url"],"")));
	$objPollBooth->poll_booth_active = $cmn->setVal(trim($cmn->readValue($_POST["poll_booth_active"],"")));
	
	$objPollBooth->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objPollBooth->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>