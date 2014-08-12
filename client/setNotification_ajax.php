<?PHP
	require_once("include/general_includes.php");

	// check if user has logged in
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objNotification = new notification();
	$objSendNotification = new send_notification();

	$userID = $cmn->getSession(ADMIN_USER_ID);
	$objNotification->user_id = $userID;

	$objClient = new client();
	$objNotification->client_id = $objClient->fieldValue("client_id",$userID);
	$objNotification->created_by = $cmn->getSession(ADMIN_USER_ID);
	$objNotification->updated_by = $cmn->getSession(ADMIN_USER_ID);

	$objNotification->system_notification_id = $_REQUEST['system_notification_id'];

	// Delete Previous Day's Notifications
	$objNotification->deleteNotifications();

	$aSystemNotifications = $objNotification->fetchTodaysSystemNotifications();
	$arrNotifications = $aSystemNotifications;

	//Sort Notifications by Timings
	$arrNotifications = $cmn->multisort($arrNotifications, 'timings');

	$setMaxCount = 0;
	if(count($arrNotifications)>3)
	{
		$setMaxCount = 3;
	}
	else
	{
		$setMaxCount = count($arrNotifications);
	}

	$setNotificaions = '';

	if(count($arrNotifications)>0)
	{
    	$setNotificaions.='
		<div class="notification-main">
		<div class="notification-title">Notifications</div>
		<div class="notification-mid">';
		 for($m=0;$m<$setMaxCount;$m++) {
		  $setNotificaions.='<div class="notification">
			  <a href="javascript:changeOrder('.$arrNotifications[$m]['system_notification_id'].','.$m.',this,'.$arrNotifications[$m]['is_admin_notification'].');"><img alt="" class="fright" src="'.SERVER_CLIENT_HOST.'images/delete.gif"></a>
			  <a href="#">'.$cmn->dateTimeFormat($arrNotifications[$m]['timings'],"%M %d, %Y").'</a><br>
			  <strong>'.$arrNotifications[$m]['subject'].',</strong><br>';
			  $setNotificaions.= substr( $cmn->readValueDetail(html_entity_decode($arrNotifications[$m]['message'])),0,70); if(strlen($arrNotifications[$m]['message'])>70) { $setNotificaions.= "..."; }
		  $setNotificaions.= '</div>';
		  }
		$setNotificaions.= '</div>
		<div class="notification-bot"></div>
	</div>';
	}
	else
	{
		$objNotification->order = 1;
		$objNotification->subject = "";
		$objNotification->message = "";
		$objNotification->timings = @date("Y-m-d H:i:s");
		$objNotification->is_display = 1;
		$objNotification->insetNotificationDtl();
	}
	echo $setNotificaions;
	exit;