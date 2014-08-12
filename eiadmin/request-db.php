<?php
	defined('PAGE_EXECUTE') or die( 'Restricted access.' );

	if ( isset($_POST['btnsubmit'])){

		$objvalidation = new validation();

		$objvalidation->add_validation("txttitle", "title", "req");
		$objvalidation->add_validation("txttitle", "title", "dupli", "", DB_PREFIX."request|title|id|".$id."|1|1");
		$objvalidation->add_validation("txtcontent", "content", "req");
		
		if($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			$obj->id			= (int) $id;
			$obj->title			= $cmn->setval(trim($cmn->read_value($_POST['txttitle'],'')));
			$obj->content		= $cmn->store_db_compatiblevalue(trim($cmn->read_value($_POST['txtcontent'],'')));
			$obj->date			= $cmn->setval(trim($cmn->read_value($_POST['txtdate'],'')));
			$obj->active		= $cmn->setval(trim($cmn->read_value($_POST['rdoactive'],'')));
			$obj->by_name		= $cmn->setval(trim($cmn->read_value($_FILES['txt_file']['name'],'')));
			$obj->old_by_name	= $cmn->setval(trim($cmn->read_value($_POST['txtold_file'],'')));

			//Code to add record.
			if ($strmode == 'add')
			{
				$obj->add();
				$msg->send_msg('request-list.php','request ',3);
			}

			//Code to edit record
			if ($strmode == 'edit' && intval($id) > 0)
			{
				$obj->update();
				$msg->send_msg('request-list.php','request ',4);
			}
		}
	}

	//Code to delete selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'delete')
	{
		if (count($_POST['deletedids']) == 0)
		{
			$msg->send_msg('request-list.php','request ',9);
		}
		else
		{
			$obj->checkedids = implode(',',$_POST['deletedids']);
			$obj->delete();
			$msg->send_msg('request-list.php','request ',5);
		}
		exit();
	}

	//Code to active inactive selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'active')
	{
		if (isset($_POST['activeids']))
			$arrayactiveids = $_POST['activeids'];
		else
			$arrayactiveids = array('0');
		$obj->checkedids = implode(',',$arrayactiveids);
		$obj->uncheckedids = $_POST['inactiveids'];
		$obj->activeinactive();
		$msg->send_msg('request-list.php','request ',15);
		exit();
	}

	//Code to export table.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'export')
	{
		$cmn->export_to_csv('request', 'request.csv');
	}
	
	//Code to delete document
	if(isset($_POST['hdnmodedeleterequest']))
	{
        $obj->deleteFiles((int)$_POST['hdnmodedeleterequest']);
		$obj->updateImage((int)$_POST['hdnmodedeleterequest']);
	}