<?php	
	if(isset($_REQUEST["id_number_id"]) && $_REQUEST["id_number_id"] > 0)
	{
		$objid_number->setAllValues($_REQUEST["id_number_id"]);
		$objid_number->id_number_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["id_number_id"],"")));
	}	
	
	$objid_number->id_number_name = $cmn->setVal(trim($cmn->readValue($_POST["id_number_name_".$defaultlanguage_id],"")));
	$objid_number->id_number_length = $cmn->setVal(trim($cmn->readValue($_POST["id_number_length"],"")));
	$objid_number->id_number_active = $cmn->setVal(trim($cmn->readValue($_POST["id_number_active"],"")));
	
	$objid_number->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objid_number->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>