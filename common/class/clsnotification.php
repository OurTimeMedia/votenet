<?php
class notification extends common
{
	//Property
	var $system_notification_id;
	var $user_id;
	var $notification_id;
	var $message;
	var $order;
	var $added_date;
	var $client_id;
	var $subject;
	var $timings;
	var $pagingType;
	var $is_display;
	var $is_admin_notification;
	
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;
	
	function notification()
	{
		$this->system_notification_id = 0;
		$this->user_id = 0;
		$this->notification_id = 0;
		$this->client_id = 0;
		$this->message = "";
		$this->subject = "";
		$this->order = 0;
		$this->added_date = "";
		$this->timings = "";
		$this->pagingType = "";
		$this->is_display = 1;
		$this->is_admin_notification = 0;
	}

	function deleteNotification()
	{
		$sQuery = " DELETE FROM ei_system_notification 
						   WHERE user_id='".$this->user_id."' AND 
						   		 added_date != DATE( '".currentScriptDate()."' ) AND is_delete='0'";
		$rs = mysql_query($sQuery);		
		
		$sQuery = " DELETE FROM ei_system_notification 
						   WHERE user_id='".$this->user_id."' AND 
						   		 added_date <= DATE( DATE_SUB('".currentScriptDateOnly()."',INTERVAL 15 DAY) ) ";
		$rs = mysql_query($sQuery);	
	}
	
	function deleteNotifications()
	{
		$sQuery = " DELETE FROM ei_system_notification 
						   WHERE system_notification_id='".$this->system_notification_id."' ";	
		$rs = mysql_query($sQuery);
	}
	
	function deleteAdminNotifications()
	{
		$sQuery = " UPDATE ei_system_notification SET is_deleted='1'
						   WHERE system_notification_id='".$this->system_notification_id."' ";	
		$rs = mysql_query($sQuery);
	}
	
	
	function fetchNotificationsCount()
	{
		$sQuery = " SELECT system_notification_id 
						FROM ei_system_notification 
						WHERE user_id='".$this->user_id."' AND 
							  added_date='".@date("Y-m-d")."' AND is_deleted='0' ";	
		$rs = mysql_query($sQuery);	 
		return mysql_num_rows($rs);
	}
	
	function fetchAvailableNotifications()
	{
		$sQuery = " SELECT *,DATEDIFF(election_date,'".currentScriptDate()."') AS dategap FROM `ei_election_date`, `ei_election_type`, `ei_state` where 1=1 and `ei_election_date`.election_type_id = `ei_election_type`.election_type_id and `ei_election_date`.state_id = `ei_state`.state_id AND DATEDIFF(election_date,'".currentScriptDate()."') <= 15 AND DATEDIFF(election_date,'".currentScriptDate()."') >= 0 ORDER BY dategap";
		$rs = mysql_query($sQuery);
		
		$arrNotification = array();
		
	    $i = 0;
	    while($res = mysql_fetch_assoc($rs))
	    {
	  		$arrNotification[$i]['election_date_id'] = $res['election_date_id'];
			$arrNotification[$i]['election_type_name'] = $res['election_type_name'];
			$arrNotification[$i]['election_date'] = $res['election_date'];
			$arrNotification[$i]['state_name'] = $res['state_name'];			
			$i++;
	    }
		
		return $arrNotification;
	}
	
	function insetNotificationDtl()
	{
		$sQr = " INSERT INTO `ei_system_notification` (user_id, notification_id, subject, message,`order`,`added_date`,`timings`, is_display,is_admin_notification,created_by,created_date,updated_by,updated_date) values ('".$this->user_id."', '".$this->notification_id."','".$this->subject."','".$this->message."','".$this->order."','".@date("Y-m-d")."','".$this->timings."','".$this->is_display."','".$this->is_admin_notification."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
		$rs = mysql_query($sQr);
	}
	
	function insetNotificationForRegistrationCount()
	{
		$sQuery = "SELECT *  FROM `ei_system_notification` WHERE user_id='".$this->user_id."' AND timings = '".currentScriptDateOnly()." 00:00:00' AND `order` = 0";
		$rs = mysql_query($sQuery);
			
		if(mysql_num_rows($rs) > 0)			
		{
			$row = mysql_fetch_assoc($rs);
			$sQr = " UPDATE `ei_system_notification` set message = '".$this->message."' where system_notification_id = ".$row['system_notification_id'];
			$rs = mysql_query($sQr);
		}
		else
		{
			$sQr = " INSERT INTO `ei_system_notification` (user_id, notification_id, subject, message,`order`,`added_date`,`timings`, is_display,is_admin_notification,created_by,created_date,updated_by,updated_date) values ('".$this->user_id."', '".$this->notification_id."','".$this->subject."','".$this->message."','".$this->order."','".@date("Y-m-d")."','".$this->timings."','".$this->is_display."','".$this->is_admin_notification."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			$rs = mysql_query($sQr);
		}	
	}
	
	function findMaxOrderNumberTodaysNotifications()
	{
		$sQuery = "SELECT MAX(`order`) as `order` 
					FROM `ei_system_notification` 
					WHERE user_id='".$this->user_id."' AND 
						  added_date='".@date("Y-m-d")."' AND 
						  timings>'".currentScriptDate()."' 
					GROUP BY user_id 
					ORDER BY timings ";	
		$rs = mysql_query($sQuery);
		$maxOrder = 0;
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			$maxOrder = $res['order'];
		}
		return $maxOrder;
	}
	
	function updateOrder()
	{
		$sQuery = "UPDATE `ei_system_notification` SET `order`='".$this->order."' WHERE system_notification_id='".$this->system_notification_id."' ";	
		$rs = mysql_query($sQuery);
	}
	
	function fetchTodaysNotifications($home=0)
	{
		$limit = '';
		if($home == 1)
		{
			$limit = " LIMIT 0,3 ";
		}
		
		$sQuery = "SELECT * 
					FROM `ei_system_notification` 
					WHERE user_id='".$this->user_id."' AND 
						  added_date='".@date("Y-m-d")."' AND 
						  timings>'".currentScriptDate()."' AND
						  is_display = 1
					ORDER BY `timings` ".$limit;	
		$rs = mysql_query($sQuery);
		
		$arrNotification = array();
		
	    $i = 0;
	    while($res = mysql_fetch_assoc($rs))
	    {	
	  		$arrNotification[$i]['system_notification_id'] = $res['system_notification_id'];
			$arrNotification[$i]['user_id'] = $res['user_id'];
			$arrNotification[$i]['subject'] = $res['subject'];
			$arrNotification[$i]['message'] = $res['message'];
			$arrNotification[$i]['order'] = $res['order'];
			$arrNotification[$i]['added_date'] = $res['added_date'];
			$arrNotification[$i]['is_admin_notification'] = $res['is_admin_notification'];
			$arrNotification[$i]['timings'] = $res['timings'];
			$arrNotification[$i]['created_date'] = $res['created_date'];
	  		$i++;
	    }
		
		return $arrNotification;
	}
	
	//Function to retrieve array of System Notifications
	function fetchTodaysSystemNotifications()
	{
		$sQuery = "SELECT * 
					FROM `ei_system_notification` 
					WHERE user_id='".$this->user_id."' AND 
						  added_date='".@date("Y-m-d")."' AND 
						  timings>='".currentScriptDateOnly()."' AND
						  is_display = 1 AND
						  is_admin_notification = 0 AND
						  is_deleted = '0'
					ORDER BY `order`, `timings`, RAND()";	
		$rs = mysql_query($sQuery);
		
		$arrNotification = array();
		
	    $i = 0;
	    while($res = mysql_fetch_assoc($rs))
	    {	
	  		$arrNotification[$i]['system_notification_id'] = $res['system_notification_id'];
			$arrNotification[$i]['user_id'] = $res['user_id'];
			$arrNotification[$i]['subject'] = $res['subject'];
			$arrNotification[$i]['message'] = $res['message'];
			$arrNotification[$i]['order'] = $res['order'];
			$arrNotification[$i]['added_date'] = $res['added_date'];
			$arrNotification[$i]['is_admin_notification'] = $res['is_admin_notification'];
			$arrNotification[$i]['timings'] = $res['timings'];
			$arrNotification[$i]['created_date'] = $res['created_date'];
	  		$i++;
	    }
		
		return $arrNotification;
	}
	
	//Function to retrieve array of Admin Notifications
	function fetchTodaysAdminNotifications()
	{
		$sQuery = "SELECT * 
					FROM `ei_system_notification` 
					WHERE user_id='".$this->user_id."' AND 
						  added_date='".@date("Y-m-d")."' AND 
						  timings<='".currentScriptDate()."' AND
						  is_display = 1 AND
						  is_admin_notification = 1 AND
						  is_deleted = '0'
					ORDER BY `timings`";
		$rs = mysql_query($sQuery);
		
		$arrNotification = array();
		
	    $i = 0;
	    while($res = mysql_fetch_assoc($rs))
	    {	
	  		$arrNotification[$i]['system_notification_id'] = $res['system_notification_id'];
			$arrNotification[$i]['user_id'] = $res['user_id'];
			$arrNotification[$i]['subject'] = $res['subject'];
			$arrNotification[$i]['message'] = $res['message'];
			$arrNotification[$i]['order'] = $res['order'];
			$arrNotification[$i]['added_date'] = $res['added_date'];
			$arrNotification[$i]['is_admin_notification'] = $res['is_admin_notification'];
			$arrNotification[$i]['timings'] = $res['timings'];
			$arrNotification[$i]['created_date'] = $res['created_date'];
	  		$i++;
	    }
		
		return $arrNotification;
	}
	
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="system_notification_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and system_notification_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$sQuery = "SELECT * 
					FROM `ei_system_notification` 
					WHERE user_id='".$this->user_id."' AND 
						  added_date='".@date("Y-m-d")."' AND 
						  is_display = 1 AND
						  (timings>='".currentScriptDateOnly()."' or (is_admin_notification =1 and is_deleted = '0'))".$condition.$order;
								  
		$rs=mysql_query($sQuery);
		return $rs;
	}
	
	//Function to set field values into object properties
	function setAllValues($id = "",$condition = "")
	{
		$rs = $this->fetchRecordSet($id, $condition);
	
		if($artf_notification =  mysql_fetch_assoc($rs))		
		{
			$this->system_notification_id  =  $artf_notification["system_notification_id"];
			$this->user_id  =  $artf_notification["user_id"];
			$this->subject  =  $artf_notification["subject"];
			$this->message  =  $artf_notification["message"];
			$this->order  =  $artf_notification["order"];
			$this->added_date  =  $artf_notification["added_date"];
			$this->timings  =  $artf_notification["timings"];
			$this->is_display  =  $artf_notification["is_display"];
			$this->created_date  =  $artf_notification["created_date"];
			$this->created_by  =  $artf_notification["created_by"];
			$this->updated_date  =  $artf_notification["updated_date"];
			$this->updated_by  =  $artf_notification["updated_by"];
		}
	}
	
	
	function subject($type,$days,$contestName)
	{	
		$subject = '';
  		switch($type)
		{
			case "entryStart":
				$subject = "Entrant Round";
				break;
			case "entryEnd":
				$subject = "Entrant Round";
				break;
			case "judgeStart":
				$subject = "Judge Round";
				break;
			case "judgeEnd":
				$subject = "Judge Round";
				break;
			case "winnerDay":
				$subject = "Winner Announcement";
				break;		
		}
		return $subject;
	}
	
	function msg($type,$days,$contestName)
    {		
		$msg = '';
		if($days==1)
		{ $daysVal = 'Day'; }
		else
		{ $daysVal = 'Days'; }
	
  		switch($type)
		{
			case "entryStart":
				if($days==0)
				{	$msg = " Election for ".$contestName." will start Today! "; }
				else
				{	$msg = " Election for ".$contestName." will start within ".$days." ".$daysVal."! "; }
				break;
		}
		return $msg;
  	}
  
}
?>