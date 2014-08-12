<?php	
if ( isset($_REQUEST['btnLayout']))
{
	$objvalidation = new validation();
	$objForm->client_id = $client_id;
	
	$objvalidation->addValidation("txtHeaderBackground", "Normal Text Background", "req");
	$objvalidation->addValidation("txtHeaderText", "Header Text", "req");
	$objvalidation->addValidation("txtNormalBackground", "Normal Text Background", "req");
	$objvalidation->addValidation("txtNormalText", "Normal Text", "req");
	
	if ($objvalidation->validate())
	{	
		$objForm->form_background = "#".str_replace("#","",$cmn->setVal(trim($cmn->readValue($_POST["txtHeaderBackground"],""))));
		$objForm->form_header_text = "#".str_replace("#","",$cmn->setVal(trim($cmn->readValue($_POST["txtHeaderText"],""))));
		$objForm->form_normal_text = "#".str_replace("#","",$cmn->setVal(trim($cmn->readValue($_POST["txtNormalText"],""))));
		$objForm->form_normal_text_bg = "#".str_replace("#","",$cmn->setVal(trim($cmn->readValue($_POST["txtNormalBackground"],""))));
		$objForm->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
		$objForm->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);	
		
		$objForm->addLayoutDetail();
		
		$msg->sendMsg("customize_form.php","Layout ",4);
		exit;
	}	
}

if ( isset($_REQUEST['btnFormSubmit']))
{
	$objvalidation = new validation();
	$defaultlanguage_id = intval($_REQUEST["hdndefaultlanguage_id"]);
	
	$objvalidation->addValidation("selFieldType", "Field Type", "req");
	$objvalidation->addValidation("selRegType", "Registration Type", "req");
	
	if($_REQUEST['selFieldType'] != 1)
		$objvalidation->addValidation("selHeaderField", "Header Field", "req");		
	
	if($_REQUEST['selFieldType'] < 6 || $_REQUEST['selFieldType'] == 11 || $_REQUEST['selFieldType'] == 12 || $_REQUEST['selFieldType'] == 17)
	{
		$objvalidation->addValidation("txtFieldName", "Field Name", "req");	
		$objvalidation->addValidation("txtFieldLabel_".$defaultlanguage_id, "Label", "req");
	}	
		
	if ($objvalidation->validate())
	{	
		include("customize_form_field.php");
		
		if($_REQUEST['selFieldType'] == 7)
			$objField->field_caption = "Eligibility Criteria";
		else if($_REQUEST['selFieldType'] == 8)
			$objField->field_caption = "Party";
		else if($_REQUEST['selFieldType'] == 9)
			$objField->field_caption = "Race Group";
		else if($_REQUEST['selFieldType'] == 10)
			$objField->field_caption = "ID Number";
		else if($_REQUEST['selFieldType'] == 13)
			$objField->field_caption = "State";
		else if($_REQUEST['selFieldType'] == 14)
			$objField->field_caption = "Zip Code";
		else if($_REQUEST['selFieldType'] == 15)
			$objField->field_caption = "State";	
		else if($_REQUEST['selFieldType'] == 16)
			$objField->field_caption = "Zip Code";
			
		if(isset($_POST["hdnmode"]) && $_POST['hdnmode'] == "edit")
		{
			$objField->field_id = $_REQUEST['field_id'];
			$objField->Update_Field();
			
			for($i=0;$i<count($language);$i++)
			{			
				$objField->client_id = $client_id;
			
				$objField->language_id = $language[$i]['language_id'];
				$objField->field_caption = $cmn->setVal(trim($cmn->readValue($_POST["txtFieldLabel_".$language[$i]['language_id']],"")));
				$objField->field_note = $cmn->setVal(trim($cmn->readValue($_POST["txtFieldNote_".$language[$i]['language_id']],"")));
				
				$objField->Update_Field_Language();		
			}
		}
		else
		{	
			$objField->field_id = $objField->Insert_Field();
			
			for($i=0;$i<count($language);$i++)
			{		
				if($language[$i]['language_id'] != ENGLISH_LANGUAGE_ID)
				{
					$objField->client_id = $client_id;
				
					$objField->language_id = $language[$i]['language_id'];
					$objField->field_caption = $cmn->setVal(trim($cmn->readValue($_POST["txtFieldLabel_".$language[$i]['language_id']],"")));
					$objField->field_note = $cmn->setVal(trim($cmn->readValue($_POST["txtFieldNote_".$language[$i]['language_id']],"")));
					
					$objField->Insert_Field_Language();		
				}
			}
		}
		
		if($_REQUEST['selFieldType'] == "2" || $_REQUEST['selFieldType'] == "4" || $_REQUEST['selFieldType']=="6")	
		{
			$objfield_option = new field_option();
			
			$objfield_option->field_id = $objField->field_id;	
			
			$edit = 0;
			
			if(isset($_POST["hdnmode"]) && $_POST['hdnmode'] == "edit")
			{		
				$edit = 1;
				$objfield_option->insertOption_In_Temp_Table($objField->field_id);
				$objfield_option->deleteFieldOption();
			}
				
			$objfield_option->file_type_id = $_REQUEST['selFieldType'];
			$objfield_option->show_field_ids = "";
			$objfield_option->hide_field_ids = "";
			
			$allOptions = str_replace("~^~","&",$_POST["hidAll_Options"]);
			$arrOptions = explode("^#^", $allOptions);
						
			$cntr = 0;
			$option_id = 0;
			while($cntr < count($arrOptions))
			{	
				$arrLanguage_Text = explode("#^#",$arrOptions[$cntr]);
				$inner_cntr = 0;
				while($inner_cntr < count($language))
				{
					if($inner_cntr == 0)
					{
						$objfield_option->field_option_order = $cntr + 1;
						$objfield_option->field_option_isactive = "1";
						$objfield_option->field_option = $arrLanguage_Text[$inner_cntr];
						$objfield_option->created_by = $cmn->getSession(ADMIN_USER_ID);
						$objfield_option->updated_by = $cmn->getSession(ADMIN_USER_ID);	
					
						$option_id = $objfield_option->add();
						
						if(isset($_POST["hdnmode"]) && $_POST['hdnmode'] == "edit")
						{
							$rsTemp = $objfield_option->getField_Option_Temp($objField->field_id, $objfield_option->field_option);
							$field_option_temp_id = 0;
							if(mysql_num_rows($rsTemp) > 0)
							{
								$arr = mysql_fetch_array($rsTemp);
								$show_field_ids = $arr["show_field_ids"];
								$hide_field_ids = $arr["hide_field_ids"];
								
								$objfield_condition = new field_condition();
								
								if($show_field_ids != "" || $hide_field_ids != "")
								{						
									$condition_id = $objfield_condition->insertFromTempTable($objfield_option->field_id, $option_id, $show_field_ids, $hide_field_ids);
								}					
							}												
						}
					}
					
					$objfield_option->field_option_id = $option_id;
					$objfield_option->language_id = $language[$inner_cntr]['language_id'];
					$objfield_option->field_option = $arrLanguage_Text[$inner_cntr];
					
					if($objfield_option->field_option != "")
						$objfield_option->add_option_language();
						
					$inner_cntr++;						
				}
				$cntr++;
			}
		}
		
		if($_REQUEST['selFieldType'] == "3")	
		{
			$objfield_option = new field_option();			
			$objfield_option->field_id = $objField->field_id;	
			
			$edit = 0;
			
			if(isset($_POST["hdnmode"]) && $_POST['hdnmode'] == "edit")
			{		
				$edit = 1;
				$objfield_option->insertOption_In_Temp_Table($objField->field_id);
				$objfield_option->deleteFieldOption();
			}
				
			$objfield_option->file_type_id = $_REQUEST['selFieldType'];
			$objfield_option->show_field_ids = "";
			$objfield_option->hide_field_ids = "";
						
			$cntr = 0;
			$option_id = 0;
			$objfield_option->field_option_order = $cntr + 1;
			$objfield_option->field_option_isactive = "1";
			$objfield_option->field_option = "Checked";
			$objfield_option->created_by = $cmn->getSession(ADMIN_USER_ID);
			$objfield_option->updated_by = $cmn->getSession(ADMIN_USER_ID);	
		
			$option_id = $objfield_option->add();
			
			if(isset($_POST["hdnmode"]) && $_POST['hdnmode'] == "edit")
			{
				$rsTemp = $objfield_option->getField_Option_Temp($objField->field_id, $objfield_option->field_option);
				$field_option_temp_id = 0;
				if(mysql_num_rows($rsTemp) > 0)
				{
					$arr = mysql_fetch_array($rsTemp);
					$show_field_ids = $arr["show_field_ids"];
					$hide_field_ids = $arr["hide_field_ids"];
					
					$objfield_condition = new field_condition();
					
					if($show_field_ids != "" || $hide_field_ids != "")
					{						
						$condition_id = $objfield_condition->insertFromTempTable($objfield_option->field_id, $option_id, $show_field_ids, $hide_field_ids);
					}					
				}												
			}					
		}
		
		$objfield_condition1 = new field_condition();
		$objfield_condition1->deleteFromTempTable($objField->field_id);
		
		if(isset($_POST['condition']) && $_POST['condition'] != "")
		{
			$objfield_condition = new field_condition();
			
			$condarr = explode("-", $_POST['condition']);
	
			$objfield_condition->field_option_id = $condarr[1];	
			
			if($condarr[0] == "show")
			{
				$objfield_condition->show_field_ids = $objField->field_id;	
				$objfield_condition->hide_field_ids = "";
			}	
			else
			{
				$objfield_condition->show_field_ids = "";
				$objfield_condition->hide_field_ids = $objField->field_id;	
			}
			
			$objfield_condition->created_by = $cmn->getSession(ADMIN_USER_ID);
			$objfield_condition->updated_by = $cmn->getSession(ADMIN_USER_ID);	

			$objfield_condition->add();
		}
		
		if (trim($_POST['hdnmode']) == 'add')
		{
			$msg->sendMsg("customize_form.php","Field ",3);
			exit;
		}

		//Code to edit record
		if (trim($_POST['hdnmode']) == 'edit' && !empty($_POST['hdnfield_id']))
		{
			$msg->sendMsg("customize_form.php","Field ",4);
			exit;
		}
	}	
}
if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == "delete")
{
	$objField->field_id = $_REQUEST["field_id"];	
	$field_condition_id = $objField->deleteField();
	
	$msg->sendMsg("customize_form.php","Field ",5);
	exit;
}	
?>