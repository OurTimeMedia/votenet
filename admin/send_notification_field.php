<?php

	$objSendNotification->notification_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnnotification_id"],"")));

	$objSendNotification->notification_title = $cmn->setVal(trim($cmn->readValue($_POST["txtnotification_title"],"")));
	
	$objSendNotification->notification_body = $cmn->setVal(trim($cmn->readValue($_POST["txtnotification_body"],"")));
	
	$objSendNotification->notification_type = $cmn->setVal(trim($cmn->readValue($_POST["selnotification_type"],"")));
	
	$notification_user_type = "";
	if(isset($_POST["selnotification_user_type"]))
	{
		$notification_user_type = $_POST["selnotification_user_type"];
	}
	if(is_array($notification_user_type)) {
	$notification_user_type = implode(",",$notification_user_type);
	}
	$objSendNotification->notification_user_type = $cmn->setVal(trim($cmn->readValue($notification_user_type,"")));
	
	$objSendNotification->notification_usernames = $cmn->setVal(trim($cmn->readValue($_POST["txtnotification_usernames"],"")));
	
	$aUserNames = explode(",",$objSendNotification->notification_usernames);
	$sUserIds = '';
	for($i=0;$i<count($aUserNames);$i++)
	{
		$sUserIds.= $objSendNotification->getUserIds($aUserNames[$i]).",";
	}
	$objSendNotification->notification_userids = substr($sUserIds,0,-1);
	
	$objSendNotification->notification_send_date = $cmn->setVal(trim($cmn->readValueSubmission($_POST["txtnotification_send_date"],"")));
	
	$objSendNotification->notification_isactive = $cmn->setVal(trim($cmn->readValue($_POST["rdonotification_isactive"],"")));
	
	if(empty($_SESSION["err"]))
	{
		$objSendNotification->notification_send_date = $cmn->setVal(trim($cmn->readValue($cmn->convertFormtTime($_POST["txtnotification_send_date"]),"")));		
	}
	
	$objSendNotification->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	
	$objSendNotification->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
	
?>