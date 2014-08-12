<?php

	if ( isset($_REQUEST['btnsave']))
	{

		$language_id = intval($_REQUEST["hdnlanguage_id"]);

		$objvalidation = new validation();

		$objvalidation->addValidation("txtlanguage_name", "Language Name ", "req");
		
		$objvalidation->addValidation("txtlanguage_name", "Language Name ", "dupli", "", DB_PREFIX."language|language_name|language_id|".$language_id."|1|1");
		
		$objvalidation->addValidation("txtlanguage_code", "Language Code ", "req");
		$objvalidation->addValidation("txtlanguage_order", "Language Order ", "req");
		
		$objvalidation->addValidation("rdolanguage_isactive", "Active", "req");
		$objvalidation->addValidation("rdolanguage_isactive", "Active","selone");
		
		$objvalidation->addValidation("rdolanguage_ispublish", "Publish", "req");
		$objvalidation->addValidation("rdolanguage_ispublish", "Publish","selone");
		
		for($i=0;$i<$_POST["txttotfields"];$i++)
		{	
			$fieldname = "txtField".$i;
			$fieldvalue = $cmn->setVal(trim($cmn->readValue($_POST[$fieldname],"")));
			$fieldvalue = explode("###",$fieldvalue);
			$field = "txt".$fieldvalue[0];
			$objvalidation->addValidation($field, $fieldvalue[1], "req");
		}
		
		$uploadFlag = $objLanguage->uploadLanguageImage();
		
		if (!$uploadFlag) 
		{
			$_SESSION['err'] = "<div class='errror-message' style='color:red;margin-left:30px;'>There is an error in image upload</div>";
		
		}
		
		if($objvalidation->validate() && $uploadFlag)
		{
			//Code to assign value of control to all property of object.
			include_once SERVER_ADMIN_ROOT."language_field.php";
			
			//Code to add record.
			if (trim($_POST['hdnmode']) == ADD)
			{
				$objLanguage->add();
				$objLanguage->updateImage();
				$msg->sendMsg("language_list.php","Language ",3);
			}

			//Code to edit record
			if (trim($_POST['hdnmode']) == EDIT && !empty($_POST['hdnlanguage_id']))
			{
				$objLanguage->update();
				$msg->sendMsg("language_list.php","Language ",4);
			}

		}

	}

	//Code to delete selected record.
	if (isset($_POST["btndelete"]))
	{
		//Code to delete selected record.
		if (trim($mode) == DELETE)
		{
			if (count($_POST['language_id']) == 0)
			{
				$msg->sendMsg("language_list.php","Language ",9);
				exit();
			}
			else
			{
				$objLanguage->checkedids = $_POST['language_id'];
				$objLanguage->delete();
				$msg->sendMsg("language_list.php","Language ",5);
				exit();			
			}
		}
	}

	//Code to active inactive selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'active')
	{
		if (isset($_POST['activeids']))
			$arrayactiveids = $_POST['activeids'];
		else
			$arrayactiveids = array("0");
		$objLanguage->checkedids = implode(",",$arrayactiveids);
		$objLanguage->uncheckedids = $_POST['inactiveids'];
		$objLanguage->activeInactive();
		$msg->sendMsg("language_list.php","Language ",15);
		exit();
	}

?>