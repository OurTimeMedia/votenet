<?php	
	if(isset($_REQUEST["race_group_id"]) && $_REQUEST["race_group_id"] > 0)
	{
		$objrace_group->setAllValues($_REQUEST["race_group_id"]);
		$objrace_group->race_group_id = $cmn->setVal(trim($cmn->readValue($_REQUEST["race_group_id"],"")));
	}	
	
	$objrace_group->race_group_name = $cmn->setVal(trim($cmn->readValue($_POST["race_group_name_".$defaultlanguage_id],"")));
	$objrace_group->race_group_active = $cmn->setVal(trim($cmn->readValue($_POST["race_group_active"],"")));
	
	$objrace_group->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objrace_group->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>