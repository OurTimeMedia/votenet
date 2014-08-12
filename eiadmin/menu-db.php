<?php 
	defined('PAGE_EXECUTE') or die( 'Restricted access.' );
	if ( isset($_POST['btnsubmit']) ) {
		
		$objvalidation = new validation();		
		
		$objvalidation->add_validation("txtmenu_name", "menu", "req");
		$objvalidation->add_validation("txtmenu_name", "menu", "dupli" , "",DB_PREFIX."menu|menu_name|menu_id|" . (int) $menu_id . "|1|1");
		$objvalidation->add_validation("txtlisting_page", "listing page", "req");
		$objvalidation->add_validation("txtaddedit_page", "add/edit page", "req");
		$objvalidation->add_validation("txtmenu_icon", "menu icon", "req");
		$objvalidation->add_validation("txtmenu_order", "display order", "req");
		$objvalidation->add_validation("txtmenu_order", "display order", "numeric");
		$objvalidation->add_validation("txtmenu_order", "display order", "greaterthan", '', 0);
		
		if($objvalidation->validate()){

			//Code to assign value of control to all property of object.
			$objmenu->menu_id = (int) $menu_id;
			$objmenu->menu_name = $cmn->setval(trim($cmn->read_value($_POST["txtmenu_name"],"")));
			$objmenu->listing_page = $cmn->setval(trim($cmn->read_value($_POST["txtlisting_page"],"")));
			$objmenu->addedit_page = $cmn->setval(trim($cmn->read_value($_POST["txtaddedit_page"],"")));
			$objmenu->menu_icon = $cmn->setval(trim($cmn->read_value($_POST["txtmenu_icon"],"")));
			$objmenu->menu_order = $cmn->setval(trim($cmn->read_value($_POST["txtmenu_order"],"")));
			$objmenu->menu_active = $cmn->setval(trim($cmn->read_value($_POST["rdomenu_active"],"y")));

			//Code to add record.
			if ($strmode == 'add')
			{
				$objmenu->add();
				$msg->send_msg("menu-list.php","Menu ",3);
			}

			//Code to edit record
			if ($strmode == 'edit' && intval($menu_id) > 0 )
			{
				$objmenu->update();
				$msg->send_msg("menu-list.php","Menu ",4);
			}

		}
		
	}
	
	//Code to delete selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'delete') {
		if (count($_POST['deletedids']) == 0)
		{
			$msg->send_msg("menu-list.php","Menu ",9);
		}
		else
		{
			$objmenu->checkedids = implode(",",$_POST['deletedids']);
			$objmenu->delete();
			$msg->send_msg("menu-list.php","Menu ",5);
		}
		exit();
	}

	//Code to active inactive selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'active') {
		if (isset($_POST['activeids']))
			$arrayactiveids = $_POST['activeids'];
		else
			$arrayactiveids = array("0");
		$objmenu->checkedids = implode(",",$arrayactiveids);
		$objmenu->uncheckedids = $_POST['inactiveids'];
		$objmenu->activeinactive();
		$msg->send_msg("menu-list.php","Menu ",15);
		exit();
	}
?>