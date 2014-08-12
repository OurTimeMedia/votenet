<?php
	class strongmail_response
	{
		var $strongmail_id;
		var $email_notification_id;
		var $strongmail_notification_type;
	
		var $strongmail_context;
		var $strongmail_action;
		var $strongmail_response;
		
		var $strongmail_mailing_file;
		var $strongmail_mailing_status;
		var $strongmail_mailing_error;
		
		var $strongmail_date;
		var $strongmail_schedule_time;
		
		function strongmail_response()
		{			
			$this->strongmail_context = "mailing";
			$this->strongmail_action = "save";
			$this->strongmail_response = "1";
			$this->strongmail_mailing_file = "";
			$this->strongmail_mailing_status = "1";
			$this->strongmail_mailing_error = "";
			$this->strongmail_date = date("m/d/Y H:i");		
			$this->strongmail_schedule_time = date("m/d/Y H:i"); 		
		}
			
		//Function to retrieve recordset of table
		function fetchRecordSet($id="", $condition="", $order="strongmail_id")
		{
			if($id!="" && $id!= NULL && is_null($id)==false)
			{
			$condition = " and email_notification_id=". $id .$condition;
			}
			if($order!="" && $order!= NULL && is_null($order)==false)
			{
				$order = " order by " . $order.", strongmail_id desc";
			}
			$strquery="SELECT * FROM ".DB_PREFIX."strongmail WHERE 1=1 " . $condition . $order;
			$rs=mysql_query($strquery);
			return $rs;
		}
		
		//Function to retrieve records of table in form of two dimensional array
		function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="strongmail_id")
		{
			$arrlist = array();
			$i = 0;
			$and = $condition;
			if(!is_null($intid) && trim($intid)!="") $and .= " AND email_notification_id = " . $intid;
			if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND email_notification_id like '" . $stralphabet . "%'";
			$strquery="SELECT * FROM ".DB_PREFIX."strongmail WHERE 1=1 " . $and . " ORDER BY ".$order;
			$rs=mysql_query($strquery);
			
			while($artf_email_notification= mysql_fetch_array($rs))
			{
				$arrlist[$i] = $artf_email_notification;
				$i++;
			}
			return $arrlist;
		}
	
		//Function to set field values into object properties
		function setAllValues($id="",$condition="")
		{
			$rs = $this->fetchRecordSet($id, $condition);
			
			if($artf_strongmail = mysql_fetch_array($rs))
			{
				if (!empty($artf_strongmail))
				{
					foreach ($artf_strongmail as $k=>$v)
					{
						$this->$k = $v;
					}
						
				}
			}
		}
	
		//Function to get particular field value
		function fieldValue($field="email_notification_id",$id="",$condition="",$order="")
		{
			$rs=$this->fetchRecordSet($id, $condition, $order);
			$ret=0;
			while($rw=mysql_fetch_assoc($rs))
			{
				$ret=$rw[$field];
			}
			return $ret;
		}
	
		//Function to update record of table
		function update() 
		{
			$strquery="UPDATE ".DB_PREFIX."strongmail SET 
						strongmail_context='".$this->strongmail_context."',
						strongmail_action='".$this->strongmail_action."',
						strongmail_response='".$this->strongmail_response."',
						strongmail_schedule_time='".$this->strongmail_schedule_time."',
						strongmail_mailing_file='".$this->strongmail_mailing_file."',
						strongmail_mailing_status='".$this->strongmail_mailing_status."',
						strongmail_mailing_error='".$this->strongmail_mailing_error."',
						strongmail_date='".currentScriptDate()."'
						WHERE email_notification_id=".$this->email_notification_id;
			
			return mysql_query($strquery) or die(mysql_error());
		}
		
		function add()
		{
			$strquery = "INSERT INTO ".DB_PREFIX."strongmail 
						(email_notification_id, 
						strongmail_notification_type,
						strongmail_context, 
						strongmail_action,
						strongmail_response,
						strongmail_schedule_time,
						strongmail_mailing_file,
						strongmail_mailing_status,
						strongmail_mailing_error,
						strongmail_date) 
						
						values('".$this->email_notification_id."',
							  '".$this->strongmail_notification_type."',
							  '".$this->strongmail_context."',
							  '".$this->strongmail_action."',
							  '".$this->strongmail_response."',
								'".$this->strongmail_schedule_time."',
							  '".$this->strongmail_mailing_file."',
							  '".$this->strongmail_mailing_status."',
							  '".$this->strongmail_mailing_error."',
							  '".currentScriptDate()."')";
			
			mysql_query($strquery) or die(mysql_error());
			$this->strongmail_id = mysql_insert_id();
			return mysql_insert_id();
		}
		
		function delete()
		{
			$strQuery="DELETE FROM ".DB_PREFIX."strongmail
						WHERE email_notification_id='".$this->email_notification_id."'";
			mysql_query($strQuery) or die(mysql_error());
		}
	}
?>