<?php	
	if(isset($_REQUEST["state_id"]) && $_REQUEST["state_id"] > 0)
	{
		$objstate->setAllValues($_REQUEST["state_id"]);
		$objstate->state_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["state_id"],"")));
	}	
	
	$objstate->state_code = $cmn->setVal(trim($cmn->readValue($_POST["state_code"],"")));
	$objstate->state_name = $cmn->setVal(trim($cmn->readValue($_POST["state_name_".$defaultlanguage_id],"")));
	$objstate->state_secretary_fname = $cmn->setVal(trim($cmn->readValue($_POST["state_secretary_fname_".$defaultlanguage_id],"")));
	$objstate->state_secretary_mname = $cmn->setVal(trim($cmn->readValue($_POST["state_secretary_mname_".$defaultlanguage_id],"")));
	$objstate->state_secretary_lname = $cmn->setVal(trim($cmn->readValue($_POST["state_secretary_lname_".$defaultlanguage_id],"")));
	$objstate->state_address1 = $cmn->setVal(trim($cmn->readValue($_POST["state_address1_".$defaultlanguage_id],"")));
	$objstate->state_address2 = $cmn->setVal(trim($cmn->readValue($_POST["state_address2_".$defaultlanguage_id],"")));
	$objstate->state_city = $cmn->setVal(trim($cmn->readValue($_POST["state_city_".$defaultlanguage_id],"")));
	$objstate->zipcode = $cmn->setVal(trim($cmn->readValue($_POST["zipcode"],"")));
	$objstate->hotlineno = $cmn->setVal(trim($cmn->readValue($_POST["hotlineno"],"")));
	$objstate->tollfree = $cmn->setVal(trim($cmn->readValue($_POST["tollfree"],"")));
	$objstate->phoneno = $cmn->setVal(trim($cmn->readValue($_POST["phoneno"],"")));
	$objstate->faxno = $cmn->setVal(trim($cmn->readValue($_POST["faxno"],"")));
	$objstate->email = $cmn->setVal(trim($cmn->readValue($_POST["email"],"")));
	$objstate->state_active = $cmn->setVal(trim($cmn->readValue($_POST["state_active"],"")));
	
	$objstate->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objstate->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>