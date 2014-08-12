<?php
	
	//Code to active inactive selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'active')
	{
		if (isset($_POST['activeids']))
			$arrayactiveids = $_POST['activeids'];
		else
			$arrayactiveids = array("0");
		$objTemplate->checkedids = implode(",",$arrayactiveids);
		$objTemplate->uncheckedids = $_POST['inactiveids'];
		$objTemplate->activeInactive();
		$msg->sendMsg("template_list.php","Template ",15);
		exit();
	}
	
	//Code to public private selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'private')
	{
		if (isset($_POST['privateids']))
			$arrayprivateids = $_POST['privateids'];
		else
			$arrayprivateids = array("0");
		$objTemplate->checkedids = implode(",",$arrayprivateids);
		$objTemplate->uncheckedids = $_POST['inactiveids'];
		$objTemplate->publicPrivate();
		$msg->sendMsg("template_list.php","Template ",73);
		exit();
	}
	
	//Code to update selected record.
	if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'update')
	{
		if (isset($_POST['activeids']))
			$arrayactiveids = $_POST['activeids'];
		else
			$arrayactiveids = array("0");
		$objTemplate->checkedids = implode(",",$arrayactiveids);
		$objTemplate->uncheckedids = $_POST['inactiveids'];
		$objTemplate->activeInactive();
	
		if (isset($_POST['privateids']))
			$arrayprivateids = $_POST['privateids'];
		else
			$arrayprivateids = array("0");
		$objTemplate->checkedids = implode(",",$arrayprivateids);
		$objTemplate->uncheckedids = $_POST['inactiveids'];
		$objTemplate->publicPrivate();
		$msg->sendMsg("template_list.php","Template ",4);
		exit();
	}

?>