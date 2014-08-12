<?php	
	$defaultlanguage_id = intval($_POST["hdndefaultlanguage_id"]);
	
	$objField->client_id = 0;
	$objField->field_order = $_REQUEST["hidMax_Field_Order"];
	$objField->field_type_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnfield_type"],"")));
	$objField->field_mapping_id = $cmn->setVal(trim($cmn->readValue($_POST["selFieldType"],"")));
	$objField->reg_type = $cmn->setVal(trim($cmn->readValue($_POST["selRegType"],"")));
	
	if($_POST["selFieldType"] == 1)
		$objField->field_header_field = 0;
	else
		$objField->field_header_field = $cmn->setVal(trim($cmn->readValue($_POST["selHeaderField"],"")));
	
	$objField->pdf_field_name = $cmn->setVal(trim($cmn->readValue($_POST["txtPdfFieldName"],"")));
	$objField->field_name = $cmn->setVal(trim($cmn->readValue($_POST["txtFieldName"],"")));
	$objField->field_caption = $cmn->setVal(trim($cmn->readValue($_POST["txtFieldLabel_".$defaultlanguage_id],"")));
	$objField->field_note = $cmn->setVal(trim($cmn->readValue($_POST["txtFieldNote_".$defaultlanguage_id],"")));
	
	$objField->is_required = 0;
	if(isset($_POST["chkRequired"]) && $_POST["chkRequired"] == "1")
		$objField->is_required = 1;
		
	$objField->field_ishide = 0;
	if(isset($_POST["chkHideDefault"]) && $_POST["chkHideDefault"] == "1")
		$objField->field_ishide = 1;

	$objField->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	$objField->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);			
?>