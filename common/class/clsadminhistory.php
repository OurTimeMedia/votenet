<?php
class adminhistory extends common
{
	//Property
	var $admin_login_history_id;
	var $user_id;
	var $client_id;
	var $login_date;
	var $ip_address;
	var $pagingType;
	
	var $checkedids;
	var $uncheckedids;
	
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id = "",$condition = "",$order = "admin_login_history_id")
	{
		
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
			$condition  =  " and ".DB_PREFIX."admin_login_history.admin_login_history_id = ". $id .$condition;
		}
		if($order !=  "" && $order !=   NULL && is_null($order) == false)
		{
			$order  =  " order by " . $order;
		}
		
		$condition .= " AND ".DB_PREFIX."admin_login_history.client_id = c.client_id AND  ".DB_PREFIX."admin_login_history.user_id = u.user_id ";
		
		
		$sQuery = "SELECT ".DB_PREFIX."admin_login_history.*, 
							u.user_username, 
							c.user_firstname, c.user_lastname , c.user_id as cuser_id 
				 FROM ".DB_PREFIX."admin_login_history, 
				 	  ".DB_PREFIX."user u, 
				 	  ".DB_PREFIX."user c  WHERE 1 = 1 " . $condition . $order;
		//echo $sQuery; exit;
		$rs  =  $this->runquery($sQuery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid = NULL, $stralphabet = NULL,$condition = "",$order = "user_id")
	{
		$and  =  $condition;
		if(!is_null($intid) && trim($intid) !=  "") $and .=  " AND ".DB_PREFIX."admin_login_history.admin_login_history_id  =  " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet) !=  "")	$and .=  " AND ".DB_PREFIX."admin_login_history.admin_login_history_id like '" . $stralphabet . "%'";
		$arrlist  =  array();
		$i  =  0;
		$and = $condition;
		
		$and .= " AND ".DB_PREFIX."admin_login_history.client_id = c.client_id AND  ".DB_PREFIX."admin_login_history.user_id = u.user_id ";
		
		$sQuery = "SELECT ".DB_PREFIX."admin_login_history.*, 
							u.user_username,
							c.user_firstname, c.user_lastname, c.user_id as cuser_id 
							
					FROM ".DB_PREFIX."admin_login_history, 
						".DB_PREFIX."user u, 
						".DB_PREFIX."user c WHERE 1 = 1 " . $and . " ORDER BY ".$order;
		
		$rs  =  $this->runquery($sQuery);
		
		while($artf_user =  mysql_fetch_assoc($rs))
		{
			$arrlist[$i]["user_id"]  =  $artf_user["user_id"];
			$arrlist[$i]["client_id"]  =  $artf_user["client_id"];
			$arrlist[$i]["login_date"]  =  $artf_user["login_date"];
			$arrlist[$i]["ip_address"]  =  $artf_user["ip_address"];
			
			$i++;
		}
		return $arrlist;
	}

	
	//Function to delete record from table
	function delete() 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."admin_login_history  WHERE admin_login_history_id in(".$this->checkedids.")";
		
		return $this->runquery($sQuery);
	}

	function setLoginHistory()
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."admin_login_history 
					
					(	user_id, client_id,
						login_date, ip_address
					) 
					
					values(
							'".$this->getSession(SYSTEM_ADMIN_USER_ID)."', '".$this->client_id."',
							'".currentScriptDate()."', '".$this->getRealIpAddr()."'
						)";
		
		
		
		$this->runquery($sQuery);
		$this->admin_login_history_id  =  mysql_insert_id();
		return mysql_insert_id();
	}
}
?>