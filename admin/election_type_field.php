<?php	
	if(isset($_REQUEST["election_type_id"]) && $_REQUEST["election_type_id"] > 0)
	{
		$objelection_type->setAllValues($_REQUEST["election_type_id"]);
		$objelection_type->election_type_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["election_type_id"],"")));
	}	
	
	$objelection_type->election_type_name = $cmn->setVal(trim($cmn->readValue($_POST["election_type_name_".$defaultlanguage_id],"")));
	$objelection_type->election_type_active = $cmn->setVal(trim($cmn->readValue($_POST["election_type_active"],"")));
	
	$objelection_type->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objelection_type->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>