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

	// Delete Previous Day's Notifications
	$objNotification->deleteNotification();

	$todaysNotification = $objNotification->fetchNotificationsCount();
	$total_cnt = 3;
	$total_cnt_no = 0;
	
	if($todaysNotification==0)
	{
		$objClientDetail1 = new topclientreport();
		$aryClientDetail1 = $objClientDetail1->datewisedetail(date('Y-m-d'), date('Y-m-d'), '', $client_id);

		if (isset($aryClientDetail1[0]['tot_cnt']))
		{
			$objNotification->order = 0;
			$objNotification->subject = "";
			$objNotification->message = "Total registration count: ".$aryClientDetail1[0]['tot_cnt'];
			$objNotification->is_display = 1;
			$objNotification->is_admin_notification = 0;
			$objNotification->timings = date('Y-m-d');
			$objNotification->insetNotificationDtl();
		} 
		
		$m1 = 1;

		$arrNotification = $objNotification->fetchAvailableNotifications();
		$objNotification->notification_id = 0;

		for($m=0;$m<count($arrNotification);$m++)
		{
			$objNotification->order = $m1;
			$objNotification->subject = "";
			$objNotification->message = $arrNotification[$m]['state_name']." - ".$arrNotification[$m]['election_type_name'];
			$objNotification->is_display = 1;
			$objNotification->is_admin_notification = 0;
			$objNotification->timings = $arrNotification[$m]['election_date'];
			$objNotification->insetNotificationDtl();

			$m1++;
			$total_cnt_no++;			
		}
	}
	else
	{
		$objClientDetail1 = new topclientreport();
		$aryClientDetail1 = $objClientDetail1->datewisedetail(date('Y-m-d'), date('Y-m-d'), '', $client_id);

		if (isset($aryClientDetail1[0]['tot_cnt']))
		{
			$objNotification->order = 0;
			$objNotification->subject = "";
			$objNotification->message = "Total registration count: ".$aryClientDetail1[0]['tot_cnt'];
			$objNotification->is_display = 1;
			$objNotification->is_admin_notification = 0;
			$objNotification->timings = date('Y-m-d');
			$objNotification->insetNotificationForRegistrationCount();
		} 
	}

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

	if(count($arrNotifications)>0)
	{
	?>
    <div id="notification_div">
	<div class="notification-main">
		<div class="notification-title">Notifications</div>
		<div class="notification-mid">
		<?PHP for($m=0;$m<$setMaxCount;$m++) { ?>
		  <div class="notification">
			  <a href="javascript:changeOrder(<?PHP echo $arrNotifications[$m]['system_notification_id']; ?>,<?PHP echo $m; ?>,this,<?PHP echo $arrNotifications[$m]['is_admin_notification']; ?>);"><img alt="" class="fright" src="<?PHP echo SERVER_CLIENT_HOST ?>images/delete.gif"></a>
			  <a href="#"><?PHP echo $cmn->dateTimeFormat($arrNotifications[$m]['timings'],"%M %d, %Y"); ?></a><br>
			  <strong><?PHP echo $arrNotifications[$m]['message']; ?></strong>
		  </div>
		  <?php } ?>
		  <?PHP if(count($arrNotifications)>3) { ?>
		<div class="moretxt">&raquo; <a href="notifications_list.php">More</a></div>
		<?PHP } ?>
		</div>		
		<div class="notification-bot"></div>
	</div>
      </div>
	<?PHP } ?>

    <script type="text/javascript">

		function changeOrder(id,val,type,isadmin)
		{
			if(confirm("Are you sure you want to delete this notification?"))
			{
			    $("#f0").slideToggle("slow");
				setTimeout('$("#notification_div").load("setNotification_ajax.php?system_notification_id='+id+'&is_admin_notification='+isadmin+'")', 300);
			}
		}

	</script>
