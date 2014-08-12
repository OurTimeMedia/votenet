<?php
class tickets extends common
{
	//Property
	var $ticket_id;
	var $client_id;
	var $user_id;
	var $ticket_no;
	var $ticket_priority;
	var $ticket_status;
	var $ticket_type_id;
	var $assign_to_user_id;
	var $oppened_by_user_id;
	var $open_date;
	var $due_date;
	var $closed_by_user_id;
	var $close_date;
	var $ticket_description;
	var $ticket_title;
	var $adminuser_firstname;
	var $adminuser_lastname;
	var $admin_mail;
	var $from_mail;
	var $adminuser_name;
	
	var $ticket_email_id;
	var $user_email;
	var $email_sent_date;
	var $assign_client_id;
	var $mail_user_id;
	
	var $ticket_history_id;
	var $post_date;
	var $notes;
	
	var $ticket_type_name;
	var $ticket_type_order;
	var $ticket_type_isactive;
	
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	function tickets()
	{
		$this->ticket_id = 0;
		$this->client_id = 0;
		$this->user_id = 0;
		$this->ticket_no = "";
		$this->ticket_priority = "";
		$this->ticket_status = 1;
		$this->ticket_type_id = 0;
		$this->assign_to_user_id = 0;
		$this->oppened_by_user_id = 0;
		$this->open_date = "";
		$this->due_date = "";
		$this->closed_by_user_id = 0;
		$this->close_date = "0000-00-00 00:00:00";
		$this->ticket_description = "";
		$this->ticket_title = "";
		
		$this->adminuser_firstname = "";
		$this->adminuser_lastname = "";
		$this->admin_mail = "";
		$this->from_mail = "";
		$this->adminuser_name = "";
		$this->assign_client_id = "";
		$this->mail_user_id = "";
		
		$this->ticket_email_id = 0;
		$this->user_email = "";
		$this->email_sent_date = "";
		
		$this->ticket_history_id = 0;
		$this->post_date = "";
		$this->notes = "";
		
		$this->ticket_type_name = "";
		$this->ticket_type_order = 0;
		$this->ticket_type_isactive = 0;
	}
	
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="ticket_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and ticket_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", ticket_id desc";
		}
		$strquery="SELECT t.*,ttp.ticket_type_name,concat(ur.user_firstname,' ',ur.user_lastname) as openedBy FROM ".DB_PREFIX."ticket t,".DB_PREFIX."ticket_type ttp,".DB_PREFIX."user ur WHERE 1=1 AND ttp.ticket_type_id=t.ticket_type_id AND ur.user_id=t.oppened_by_user_id " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="ticket_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND ticket_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND ticket_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."ticket WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artickets= mysql_fetch_array($rs))
		{
			$arrlist[$i]["ticket_id"] = $artickets["ticket_id"];
			$arrlist[$i]["client_id"] = $artickets["client_id"];
			$arrlist[$i]["user_id"] = $artickets["user_id"];
			$arrlist[$i]["ticket_no"] = $artickets["ticket_no"];
			$arrlist[$i]["ticket_priority"] = $artickets["ticket_priority"];
			$arrlist[$i]["ticket_status"] = $artickets["ticket_status"];
			$arrlist[$i]["ticket_type_id"] = $artickets["ticket_type_id"];
			$arrlist[$i]["assign_to_user_id"] = $artickets["assign_to_user_id"];
			$arrlist[$i]["oppened_by_user_id"] = $artickets["oppened_by_user_id"];
			$arrlist[$i]["open_date"] = $artickets["open_date"];
			$arrlist[$i]["due_date"] = $artickets["due_date"];
			$arrlist[$i]["closed_by_user_id"] = $artickets["closed_by_user_id"];
			$arrlist[$i]["close_date"] = $artickets["close_date"];
			$arrlist[$i]["ticket_description"] = $artickets["ticket_description"];
			$arrlist[$i]["ticket_title"] = $artickets["ticket_title"];
			$arrlist[$i]["created_by"] = $artickets["created_by"];
			$arrlist[$i]["created_date"] = $artickets["created_date"];
			$arrlist[$i]["updated_by"] = $artickets["updated_by"];
			$arrlist[$i]["updated_date"] = $artickets["updated_date"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artickets= mysql_fetch_array($rs))
		{
			$this->ticket_id = $artickets["ticket_id"];
			$this->client_id = $artickets["client_id"];
			$this->user_id = $artickets["user_id"];
			$this->ticket_no = $artickets["ticket_no"];
			$this->ticket_priority = $artickets["ticket_priority"];
			$this->ticket_status = $artickets["ticket_status"];
			$this->ticket_type_id = $artickets["ticket_type_id"];
			$this->assign_to_user_id = $artickets["assign_to_user_id"];
			$this->oppened_by_user_id = $artickets["oppened_by_user_id"];
			$this->open_date = $artickets["open_date"];
			$this->due_date = $artickets["due_date"];
			$this->closed_by_user_id = $artickets["closed_by_user_id"];
			$this->close_date = $artickets["close_date"];
			$this->ticket_description = $artickets["ticket_description"];
			$this->ticket_title = $artickets["ticket_title"];
			$this->created_by = $artickets["created_by"];
			$this->created_date = $artickets["created_date"];
			$this->updated_by = $artickets["updated_by"];
			$this->updated_date = $artickets["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldValue($field="ticket_id",$id="",$condition="",$order="")
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
		$strquery="INSERT INTO ".DB_PREFIX."ticket 
					(client_id, user_id, 
					ticket_no, ticket_priority, 
					ticket_status, ticket_type_id, 
					assign_to_user_id, oppened_by_user_id,
					open_date, due_date,
					closed_by_user_id, close_date, ticket_title, ticket_description,
					created_by, created_date, 
					updated_by, updated_date) 
				
					values('".$this->client_id."',
							'".$this->user_id."',
							'".$this->ticket_no."',
							'".$this->ticket_priority."',
							'".$this->ticket_status."',
							'".$this->ticket_type_id."',
							'".$this->assign_to_user_id."',
							'".$this->oppened_by_user_id."',
							'".currentScriptDate()."',
							'".$this->due_date."',
							'".$this->closed_by_user_id."',
							'".$this->close_date."',
							'".$this->ticket_title."',
							'".$this->ticket_description."',
							'".$this->created_by."',
							'".currentScriptDate()."',
							'".$this->updated_by."',
							'".currentScriptDate()."')";
		
		mysql_query($strquery) or die(mysql_error());
		$this->ticket_id = mysql_insert_id();
		
		$strQuery="UPDATE ".DB_PREFIX."ticket SET 
					ticket_no='".$this->ticket_id."'
					WHERE ticket_id=".$this->ticket_id;
		mysql_query($strQuery) or die(mysql_error());
		
		$this->notes = $this->ticket_description;
		$this->user_id = $this->created_by;
		$this->insertTicketHistory();
		
		return $this->ticket_id;
	}

	//Function to update record of table
	function update() 
	{   
		$strquery="UPDATE ".DB_PREFIX."ticket SET 
					ticket_priority='".$this->ticket_priority."', 
					ticket_status='".$this->ticket_status."', 
					ticket_type_id='".$this->ticket_type_id."', 
					closed_by_user_id='".$this->closed_by_user_id."', 
					close_date='".$this->close_date."',
					ticket_title='".$this->ticket_title."',
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE ticket_id=".$this->ticket_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."ticket  WHERE ticket_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}
	
	
	//// Ticket History
	function insertTicketHistory()
	{
		$strquery="INSERT INTO ".DB_PREFIX."ticket_history 
					(ticket_id, client_id, 
					user_id, post_date, 
					notes,
					created_by, created_date, 
					updated_by, updated_date) 
				
					values('".$this->ticket_id."',
							'".$this->client_id."',
							'".$this->user_id."',
							'".currentScriptDate()."',
							'".$this->notes."',
							'".$this->created_by."',
							'".currentScriptDate()."',
							'".$this->updated_by."',
							'".currentScriptDate()."')";
		
		mysql_query($strquery) or die(mysql_error());
		$this->ticket_history_id = mysql_insert_id();
		return mysql_insert_id();
	}
	
	//Function to retrieve records for history
	function fetchAllHistoryArray($intid=NULL, $stralphabet=NULL,$condition="",$order="ticket_history_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND ticket_history_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND ticket_history_id like '" . $stralphabet . "%'";
		$strquery="SELECT th.*, concat(u.user_firstname,' ',u.user_lastname) as userName,u.user_type_id FROM ".DB_PREFIX."ticket_history th,".DB_PREFIX."user u WHERE 1=1 AND th.user_id=u.user_id " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artickets_history= mysql_fetch_array($rs))
		{
			$arrlist[$i]["ticket_history_id"] = $artickets_history["ticket_history_id"];
			$arrlist[$i]["ticket_id"] = $artickets_history["ticket_id"];
			$arrlist[$i]["client_id"] = $artickets_history["client_id"];
			$arrlist[$i]["user_id"] = $artickets_history["user_id"];
			$arrlist[$i]["post_date"] = $artickets_history["post_date"];
			$arrlist[$i]["notes"] = $artickets_history["notes"];
			$arrlist[$i]["created_by"] = $artickets_history["created_by"];
			$arrlist[$i]["created_date"] = $artickets_history["created_date"];
			$arrlist[$i]["updated_by"] = $artickets_history["updated_by"];
			$arrlist[$i]["updated_date"] = $artickets_history["updated_date"];
			$arrlist[$i]["userName"] = $artickets_history["userName"];
			$arrlist[$i]["user_type_id"] = $artickets_history["user_type_id"];
			$i++;
		}
		return $arrlist;
	}
	
	
	// Fetch Ticket Types
	function fetchTicketTypes()
	{
		$arrlist = array();
		$i = 0;
		
		$strquery="SELECT * FROM ".DB_PREFIX."ticket_type WHERE 1=1 AND ticket_type_isactive=1 ORDER BY ticket_type_order";
		$rs=mysql_query($strquery);
		while($articket_type= mysql_fetch_array($rs))
		{
			$arrlist[$i]["ticket_type_id"] = $articket_type["ticket_type_id"];
			$arrlist[$i]["ticket_type_name"] = $articket_type["ticket_type_name"];
			$arrlist[$i]["ticket_type_order"] = $articket_type["ticket_type_order"];
			$arrlist[$i]["ticket_type_isactive"] = $articket_type["ticket_type_isactive"];
			$i++;
		}
		return $arrlist;
	}
	
	
	/// Send Mail
	function sendTicketNotificationMail()
    {
    	$strSubject = TICKET_MAIL_SUBJECT;        
        $body = file_get_contents(EMAIL_TEMPLATE_TICKET);
        $body = str_replace("##to_name##",$this->adminuser_firstname." ".$this->adminuser_lastname,$body);
        $body = str_replace("##from_name##",$this->getSession(ADMIN_USER_DISPLAYNAME),$body);
        $body = str_replace("##message##",html_entity_decode(str_replace( '\n', '<br />', str_replace( '\r', '',$this->ticket_description))),$body);
		$body = str_replace("##server_host##",SERVER_HOST,$body);
	
		$aEmailID = $this->admin_email;
		$emailFrom = $this->from_mail;
		
        $sendMail = $this->phpMailer($aEmailID, $strSubject, $body , '',  $emailFrom,'','','','','',false);
            
        if(isset($sendMail)) {
        	return 1;
        } else {
			return 2;
			
    	}
     }
    
	// Insert Ticket Email   
	function insertTicketEmail()
	{
		$this->sendTicketNotificationMailToClients();
		$strquery="INSERT INTO ".DB_PREFIX."ticket_email 
					(ticket_id, user_id, 
					user_email, email_sent_date,
					created_by, created_date, 
					updated_by, updated_date) 
				
					values('".$this->ticket_id."',
							'".$this->user_id."',
							'".$this->user_email."',
							'".currentScriptDate()."',
							'".$this->created_by."',
							'".currentScriptDate()."',
							'".$this->updated_by."',
							'".currentScriptDate()."')";
		
		mysql_query($strquery) or die(mysql_error());
		$this->ticket_email_id = mysql_insert_id();
		return mysql_insert_id();
	}  
	
	/// Send Mail
	function sendTicketNotificationMailToClients()
    {
    	$strSubject = TICKET_MAIL_SUBJECT_ADMIN;        
        $body = file_get_contents(EMAIL_TEMPLATE_TICKET);
		
		
        $body = str_replace("##to_name##",$this->adminuser_name,$body);
        $body = str_replace("##from_name##",$this->getSession(SYSTEM_ADMIN_USER_DISPLAYNAME),$body);
        $body = str_replace("##message##",html_entity_decode(str_replace( '\n', '<br />', str_replace( '\r', '',$this->ticket_description))),$body);
		$body = str_replace("##server_host##",SERVER_HOST,$body);
	
		$aEmailID = $this->admin_email;
		$emailFrom = $this->from_mail;
		
        $sendMail = $this->phpMailer($aEmailID, $strSubject, $body , '',  $emailFrom,'','','','','',false);
            
        if(isset($sendMail)) {
        	return 1;
        } else {
			return 2;
			
    	}
     }
	 
	 function updateAssignment()
	 {
	 	$strQuery="UPDATE ".DB_PREFIX."ticket SET 
					assign_to_user_id='".$this->assign_to_user_id."'
					WHERE ticket_id=".$this->ticket_id;
		mysql_query($strQuery) or die(mysql_error());
	 }
	 
	 function deleteTicket()
	 {
	 	$strQuery="DELETE FROM ".DB_PREFIX."ticket_email
					WHERE ticket_id='".$this->ticket_id."'";
		mysql_query($strQuery) or die(mysql_error());
		
		$strQuery="DELETE FROM ".DB_PREFIX."ticket_history
					WHERE ticket_id='".$this->ticket_id."'";
		mysql_query($strQuery) or die(mysql_error());
		
		$strQuery="DELETE FROM ".DB_PREFIX."ticket
					WHERE ticket_id='".$this->ticket_id."'";
		mysql_query($strQuery) or die(mysql_error());
	 }
	 
	  function updateStatus()
	 {
	 	$strQuery="UPDATE ".DB_PREFIX."ticket SET 
					ticket_status ='".$this->ticket_status."',
					closed_by_user_id='".$this->closed_by_user_id."', 
					close_date='".$this->close_date."'
					WHERE ticket_id='".$this->ticket_id."'";
		mysql_query($strQuery) or die(mysql_error());
	 }
	 
}
?>