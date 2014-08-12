<?php

	$objLanguage->language_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnlanguage_id"],"")));

	$objLanguage->language_name = $cmn->setVal(trim($cmn->readValue($_POST["txtlanguage_name"],"")));
	
	$objLanguage->language_code = $cmn->setVal(trim($cmn->readValue($_POST["txtlanguage_code"],"")));
	
	$objLanguage->language_order = $cmn->setVal(trim($cmn->readValue($_POST["txtlanguage_order"],"")));
	
	$objLanguage->language_isactive = $cmn->setVal(trim($cmn->readValue($_POST["rdolanguage_isactive"],"")));
	
	$objLanguage->language_ispublish = $cmn->setVal(trim($cmn->readValue($_POST["rdolanguage_ispublish"],"")));
	
	$objLanguage->totfields = $cmn->setVal(trim($cmn->readValue($_POST["txttotfields"],0)));
	
	for($i=0;$i<$_POST["txttotfields"];$i++)
	{	
		$fieldname = "txtField".$i;
		$fieldvalue = $cmn->setVal(trim($cmn->readValue($_POST[$fieldname],"")));
		$fieldvalue = explode("###",$fieldvalue);
		$field = "txt".$fieldvalue[0];
		$objLanguage->$field = $cmn->setVal(trim($cmn->readValueSubmission($_POST[$field],"")));
	}
	
	$objLanguage->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	
	$objLanguage->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	
?>