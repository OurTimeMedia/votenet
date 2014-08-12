<?php
	$objStrongMail = new strongmail();
	$objStrongMailResponse = new strongmail_response();

	if ( isset($_REQUEST['btnsave']))
	{

		$notification_id = intval($_REQUEST["hdnnotification_id"]);

		$objvalidation = new validation();

		$objvalidation->addValidation("txtnotification_title", "Title/Subject Line ", "req");
		$objvalidation->addValidation("txtnotification_body", "Message ", "req");
		$objvalidation->addValidation("selnotification_type", "Message Type ", "selone");
		//$objvalidation->addValidation("selnotification_user_type", "User Type ", "selone");
		//$objvalidation->addValidation("txtnotification_usernames", "User Names ", "req");
		
		/*$definedUsers = substr($_POST['definedUsers'],0,-1);
		$definedUsers = explode(",",$_POST['definedUsers']);*/
		if($_POST["txtnotification_usernames"]!="")
		{
			$selectedUsers = explode(",",$_POST["txtnotification_usernames"]);
			for($k=0;$k<count($selectedUsers);$k++)
			{	
				if($objSendNotification->isUserAvailable($selectedUsers[$k])==0)
				{	
					$objvalidation->addValidation("txtnotification_usernames", "User Names ", "inarr");
					
				}
			}
		}

		$objvalidation->addValidation("txtnotification_send_date", "Send Date-Time ", "req");
		//$objvalidation->addValidation("txtnotification_send_time", "Send Time ", "req");
		
		$objvalidation->addValidation("rdonotification_isactive", "Active", "req");
		$objvalidation->addValidation("rdonotification_isactive", "Active","selone");

		if(isset($_POST["txtnotification_send_date"]) && !empty($_POST["txtnotification_send_date"]))
		{
			$notification_send_datechk = $cmn->setVal(trim($cmn->readValue($cmn->convertFormtTime($_POST["txtnotification_send_date"]),"")));
			$objvalidation->addValidation("today (".$cmn->currentDate().")", " for Send Notification", "comparedatev","",$notification_send_datechk);
		}

		if($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			include_once SERVER_ADMIN_ROOT."send_notification_field.php";
			
			//Code to add record.
			if (trim($_POST['hdnmode']) == ADD)
			{
				$objSendNotification->add();
				
				if ($objSendNotification->notification_type == 0 || $objSendNotification->notification_type == 2)
				{
					$iEmailDesignTemplateId = 1;
					
					// Set all variable to send xml request to strond mail server - start
					$objStrongMail->file_prefix = "ElectionImpact_Admin_Notification";
					$objStrongMail->config_id = $objSendNotification->notification_id;
					$objStrongMail->message_id = $objSendNotification->notification_id;
					$objStrongMail->database_id = $objSendNotification->notification_id;
					$objStrongMail->subject = $objSendNotification->notification_title;
					$objStrongMail->from_email = SYSTEM_EMAIL;
					$objStrongMail->reply_email = SYSTEM_EMAIL;
					$objStrongMail->bounce_email = SYSTEM_EMAIL;
					$objStrongMail->message_body = $objSendNotification->notification_body;				
					$objStrongMail->message_template = "common.html";
					$objStrongMail->email_send_date = date('m/d/Y H:i:s',strtotime($objSendNotification->notification_send_date));
					$objStrongMail->message_body_antispam = "";
					// Set all variable to send xml request to strond mail server - end
					
					
					//_____________________ StrongMail Save Action Start ___________________//
					
					$iRecordSet = $objSendNotification->getNotificationAudienceRecordSet();
					$sSaveRequest = $objStrongMail->save($iRecordSet);
					$aResponse = $objStrongMail->saveMailings($sSaveRequest);
					
					$sErrorMsg = $objStrongMail->chkStrongMailError($aResponse);
					
					if (!empty($sErrorMsg))
					{
						$msg->sendMsg("send_notification_list.php","Error Occured.",$sErrorMsg,"","","set");
					}
					else
					{
					
						$aTemp = $objStrongMail->xml2array($aResponse['response']);
						
						$objStrongMailResponse = new strongmail_response();
						
						//Code to assign value of control to all property of object.
						$objStrongMailResponse->email_notification_id = $objSendNotification->notification_id;
						$objStrongMailResponse->strongmail_notification_type = "admin_notification";
						$objStrongMailResponse->strongmail_context = $aTemp['strongmail-client_attr']['context'];
						$objStrongMailResponse->strongmail_action = $aTemp['strongmail-client_attr']['action'];
						$objStrongMailResponse->strongmail_response = $aTemp['strongmail-client_attr']['response'];
						$objStrongMailResponse->strongmail_mailing_file = $aTemp['strongmail-client']['mailing_attr']['file'];
						$objStrongMailResponse->strongmail_mailing_status = $aTemp['strongmail-client']['mailing']['status_attr']['code'];
						
						$objStrongMailResponse->add();
							
						//_____________________ StrongMail Schedule Action Start ___________________//
						
						$sCondition = " AND strongmail_notification_type='admin_notification' ";
						$iResponseResult = $objStrongMailResponse->fetchRecordSet($objStrongMailResponse->email_notification_id,$sCondition);
						$aStrongMailResponse = mysql_fetch_array($iResponseResult);
						$objStrongMail->mailing_file = $aStrongMailResponse['strongmail_mailing_file'];
						$objStrongMail->action = "schedule"; 
						$sScheduleRequest = $objStrongMail->schedule();
						$aResponse = $objStrongMail->saveMailings($sScheduleRequest);
						
						$sErrorMsg = $objStrongMail->chkStrongMailError($aResponse);
					
						if (!empty($sErrorMsg))
						{
							$msg->sendMsg("send_notification_list.php","Error Occured.",$sErrorMsg,"","","set");
						}
						else
						{
							$aTemp = $objStrongMail->xml2array($aResponse['response']);
							
							//Code to assign value of control to all property of object.
							$objStrongMailResponse->email_notification_id = $objSendNotification->notification_id;
							$objStrongMailResponse->strongmail_context = $aTemp['strongmail-client_attr']['context'];
							$objStrongMailResponse->strongmail_action = $aTemp['strongmail-client_attr']['action'];
							$objStrongMailResponse->strongmail_schedule_time = date('m/d/Y H:i:s',strtotime($objSendNotification->notification_send_date));
							$objStrongMailResponse->strongmail_response = $aTemp['strongmail-client_attr']['response'];
							$objStrongMailResponse->strongmail_mailing_file = $aTemp['strongmail-client']['mailing_attr']['file'];
							$objStrongMailResponse->strongmail_mailing_status = $aTemp['strongmail-client']['mailing']['status_attr']['code'];
							$sCondition = " AND strongmail_notification_type='admin_notification' ";
							$iRecordSet = $objStrongMailResponse->fetchRecordSet($objStrongMailResponse->email_notification_id,$sCondition);
							
							$iCount = mysql_num_rows($iRecordSet);
							
							if ($iCount > 0)
							{
								$objStrongMailResponse->update();
							}
							else
							{
								$objStrongMailResponse->add();
							}
						//_____________________ StrongMail Schedule Action End ___________________//
							
						}
						
						//_____________________ StrongMail Save Action End ___________________//
					}
				}
				
				$msg->sendMsg("send_notification_list.php","Notification ",3);
				exit();
			}

		}

	}
	
	//Code to delete selected record.
	if ( isset($_REQUEST['btndelete']))
	{		
		if (isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'delete')
		{
			if (count($_POST['deletedids']) == 0)
			{
				$msg->sendMsg("send_notification_list.php","Notification ",9);
			}
			else
			{
				for ($i=0; $i<count($_REQUEST['deletedids']); $i++)
				{
					$objSendNotification->checkedids = $_REQUEST['deletedids'][$i];
				
					$objSendNotification->notification_id = $_REQUEST['deletedids'][$i];
					
					//_____________________ StrongMail Delete Action Start ___________________//
					
					// Set Notification ID for delete mailing on strong mail server
					$objStrongMail->config_id = $objSendNotification->notification_id;
					
					// Get mailing file path from strong mail response table
					$sCondition = " AND strongmail_notification_type='admin_notification' ";
					$rStrongMailResponseResult = $objStrongMailResponse->fetchRecordSet($objSendNotification->notification_id,$sCondition);
					$aStrongMailResponse = mysql_fetch_array($rStrongMailResponseResult);
					
					
					if (!empty($aStrongMailResponse))
					{
						// Set Mailing File to Unschedule & Delete functionality					
						$objStrongMail->mailing_file = $aStrongMailResponse['strongmail_mailing_file']; 
						$objStrongMail->email_send_date = $aStrongMailResponse['strongmail_schedule_time']; 
					}
					
					// Execute Unschedule functionality
					$objStrongMail->action = "unschedule"; // Set Action
					$sUnScheduleRequest = $objStrongMail->unschedule(); // Set xml for unscedule
					$aResponse = $objStrongMail->saveMailings($sUnScheduleRequest); // Execute Unschedule
					
					$sErrorMsg = $objStrongMail->chkStrongMailError($aResponse);
					
					if (!empty($sErrorMsg))
					{
						$msg->sendMsg("send_notification_list.php","Error Occured.",$sErrorMsg,"","","set");
					}
					else
					{
						// Execute Delete functionality
						$objStrongMail->action = "delete";  // Set Action
						$sDeleteRequest = $objStrongMail->delete(); // Set xml for delete
						$aResponse = $objStrongMail->saveMailings($sDeleteRequest); // Execute Delete
							
						$sErrorMsg = $objStrongMail->chkStrongMailError($aResponse);
					
						if (!empty($sErrorMsg))
						{
							$msg->sendMsg("send_notification_list.php","Error Occured.",$sErrorMsg,"","","set");
						}
						else
						{
							$objStrongMailResponse->email_notification_id = $objSendNotification->notification_id;
							$objStrongMailResponse->delete();
							$objSendNotification->delete();
							
						}
					
					}						
					//_____________________ StrongMail Delete Action End ___________________//		
				}								
				
			}
			$msg->sendMsg("send_notification_list.php","Notification ",5);
			exit();
		}
	}
?>