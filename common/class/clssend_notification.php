<?php
class send_notification extends common
{
	//Property
	var $notification_id;
	var $notification_title;
	var $notification_body;
	var $notification_type;
	var $notification_user_type;
	var $notification_usernames;
	var $notification_userids;
	var $notification_send_date;
	var $notification_isactive;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	function send_notification()
	{
		$this->notification_isactive = 1;
	}
	
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="notification_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and notification_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."notification 
						WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="notification_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND notification_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND notification_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."notification 
						WHERE 1=1 " . $and . " 
						ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_file_type= mysql_fetch_array($rs))
		{
			$arrlist[$i]["notification_id"] = $artf_file_type["notification_id"];
			$arrlist[$i]["notification_title"] = $artf_file_type["notification_title"];
			$arrlist[$i]["notification_body"] = $artf_file_type["notification_body"];
			$arrlist[$i]["notification_type"] = $artf_file_type["notification_type"];
			$arrlist[$i]["notification_user_type"] = $artf_file_type["notification_user_type"];
			$arrlist[$i]["notification_usernames"] = $artf_file_type["notification_usernames"];
			$arrlist[$i]["notification_send_date"] = $artf_file_type["notification_send_date"];
			$arrlist[$i]["notification_isactive"] = $artf_file_type["notification_isactive"];
			$arrlist[$i]["created_by"] = $artf_file_type["created_by"];
			$arrlist[$i]["created_date"] = $artf_file_type["created_date"];
			$arrlist[$i]["updated_by"] = $artf_file_type["updated_by"];
			$arrlist[$i]["updated_date"] = $artf_file_type["updated_date"];
			$i++;
		}
		return $arrlist;
	}
	
	//Function to retrieve records of table in form of two dimensional array
	function fetchSetAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="notification_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND notification_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND notification_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."notification 
						WHERE 1=1 AND notification_id not in (SELECT notification_id FROM ".DB_PREFIX."system_notification WHERE is_deleted='1' ) " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_file_type= mysql_fetch_array($rs))
		{
			$arrlist[$i]["system_notification_id"] = $artf_file_type["notification_id"];
			$arrlist[$i]["notification_id"] = $artf_file_type["notification_id"];
			$arrlist[$i]["user_id"] = $this->getSession(ADMIN_USER_ID);
			$arrlist[$i]["subject"] = $artf_file_type["notification_title"];
			$arrlist[$i]["message"] = $artf_file_type["notification_body"];
			$arrlist[$i]["order"] = $i;
			$arrlist[$i]["added_date"] = $artf_file_type["notification_send_date"];
			$arrlist[$i]["timings"] = $artf_file_type["notification_send_date"];
			$arrlist[$i]["created_date"] = $artf_file_type["created_date"];
			
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artf_file_type= mysql_fetch_array($rs))
		{
			$this->notification_id = $artf_file_type["notification_id"];
			$this->notification_title = $artf_file_type["notification_title"];
			$this->notification_body = $artf_file_type["notification_body"];
			$this->notification_type = $artf_file_type["notification_type"];
			$this->notification_user_type = $artf_file_type["notification_user_type"];
			$this->notification_usernames = $artf_file_type["notification_usernames"];
			$this->notification_send_date = $artf_file_type["notification_send_date"];
			$this->notification_isactive = $artf_file_type["notification_isactive"];
			$this->created_by = $artf_file_type["created_by"];
			$this->created_date = $artf_file_type["created_date"];
			$this->updated_by = $artf_file_type["updated_by"];
			$this->updated_date = $artf_file_type["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldValue($field="notification_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchRecordSet($id, $condition, $order);
		$ret=0;
		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$field];
		}
		return $ret;
	}

	//Function to add record into table
	function add() 
	{
		$strquery="INSERT INTO ".DB_PREFIX."notification 
					(notification_title, notification_body, 
					notification_type, notification_user_type, notification_usernames, 
					notification_send_date, notification_isactive,  notification_mail_send,
					created_by, 
					created_date, updated_by, updated_date) 
					
					values('".$this->notification_title."',
						  '".$this->notification_body."','".$this->notification_type."',
						  '".$this->notification_user_type."', '".$this->notification_userids."',
						  '".$this->notification_send_date."', '".$this->notification_isactive."',
						  '0', '".$this->created_by."',
						  '".currentScriptDate()."','".$this->updated_by."',
						  '".currentScriptDate()."')";
		mysql_query($strquery) or die(mysql_error());
		$this->notification_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."notification 
					WHERE notification_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}
	
	function getUserIds($userName)
	{
		$strquery="SELECT user_id 
					FROM ".DB_PREFIX."user 
					WHERE 1=1 AND 
						  user_username='".$userName."'";
		$rs=mysql_query($strquery);
		$res = mysql_fetch_array($rs);
		return $res['user_id'];
	}
	
	function getUserNames($userId)
	{
		$strquery="SELECT user_username 
					FROM ".DB_PREFIX."user 
					WHERE 1=1 AND 
						  user_id='".$userId."'";
		$rs=mysql_query($strquery);
		$res = mysql_fetch_array($rs);
		return $res['user_username'];
	}
	
	function isUserAvailable($userName)
	{
		$strquery="SELECT user_id 
					FROM ".DB_PREFIX."user 
					WHERE 1=1 AND 
						  user_username='".$userName."'";
		$rs=mysql_query($strquery);
		return mysql_num_rows($rs);
	}
	
	
	function fetchRecordSetNew($id="", $condition="", $order="user_firstname")
	{
		
		$arrlist  =  array();
		$i  =  0;
		
		$sQuery = "SELECT 	".DB_PREFIX."user.user_id, 
							".DB_PREFIX."user.user_username,
							".DB_PREFIX."user.user_firstname,
							".DB_PREFIX."user.user_lastname,
							".DB_PREFIX."user.user_email
						FROM ".DB_PREFIX."user
						WHERE 1 = 1 " . $condition . " ORDER BY ".$order;
		$rs  =  mysql_query($sQuery) or die(mysql_error());
	
		return $rs;
		
	}
	
	function fetchRecordSetWithVoter($id="", $condition="", $order="user_firstname")
	{
		
		$arrlist  =  array();
		$i  =  0;
		
		$sQuery = "SELECT 	".DB_PREFIX."user.user_id, 
							".DB_PREFIX."user.user_username,
							".DB_PREFIX."user.user_firstname,
							".DB_PREFIX."user.user_lastname,
							".DB_PREFIX."user.user_email
						FROM ".DB_PREFIX."user
						WHERE 1 = 1 " . $condition . " 
						union 
					SELECT 	".DB_PREFIX."voter.voter_id, 
							'',
							'Voter',
							'',
							".DB_PREFIX."voter.voter_email
						FROM ".DB_PREFIX."voter 	
						";
		$rs  =  mysql_query($sQuery) or die(mysql_error());
	
		return $rs;
		
	}
	
	//Get Notification Audience List Record set.
	function getNotificationAudienceRecordSet()
	{
		$notification_user_type = explode(",",$this->notification_user_type);
		
		if(in_array(5, $notification_user_type))
		{
			$condition = " AND ".DB_PREFIX."user.user_type_id IN (".$this->notification_user_type.") ";
			$iRecordSet = $this->fetchRecordSetWithVoter("", $condition);
		}
		else
		{
			$condition = " AND ".DB_PREFIX."user.user_type_id IN (".$this->notification_user_type.") ";
			$iRecordSet = $this->fetchRecordSetNew("", $condition);
		}	
		
		return $iRecordSet;
	}
}
?>