<?php

	$objTemplate->template_id = $cmn->setVal(trim($cmn->readValue($_POST["hdntemplate_id"],"")));

	$objTemplate->template_name = $cmn->setVal(trim($cmn->readValue($_POST["txttemplate_name"],"")));
	
	$objTemplate->template_folder = $cmn->setVal(trim($cmn->readValue($_POST["template_folder"],"")));
	
	$objTemplate->template_header_image = $cmn->setVal(trim($cmn->readValue($_POST["template_header_image"],"")));
	
	$objTemplate->template_background_color = $cmn->setVal(trim($cmn->readValue($_POST["template_background_color"],"")));
	
	$objTemplate->template_background_image = $cmn->setVal(trim($cmn->readValue($_POST["template_background_image"],"")));
	
	$objTemplate->template_isprivate = $cmn->setVal(trim($cmn->readValue($_POST["rdotemplate_isprivate"],"")));
	
	$objTemplate->template_ispublish = $cmn->setVal(trim($cmn->readValue($_POST["rdotemplate_ispublish"],"")));
	
	$objTemplate->template_isactive = $cmn->setVal(trim($cmn->readValue($_POST["rdotemplate_isactive"],"")));
	
	$objTemplate->template_extension = $cmn->setVal(trim($cmn->readValue($_POST["txttemplate_extension"],"")));
	
	$objTemplate->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	
	$objTemplate->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	
?>