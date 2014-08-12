<?php
class user extends common
{
	//Property
	var $user_id;
	var $client_id;
	var $user_type_id;
	var $user_username;
	var $user_password;
	var $user_firstname;
	var $user_lastname;
	var $user_email;
	var $user_company;
	var $user_designation;
	var $user_phone;
	var $user_address1;
	var $user_address2;
	var $user_city;
	var $user_state;
	var $user_country;
	var $user_zipcode;
	var $user_lastlogin;
	var $user_isactive;
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;
	var $pagingType;
	var $checkedids;
	var $uncheckedids;
	
	function user()
	{
		$this->client_id = 0;
		$this->user_isactive = 1;
		$this->user_country = 0;
		$this->user_lastlogin = '0000-00-00 00:00:00';
	}

	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id = "",$condition = "",$order = "user_id")
	{
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
		$condition  =  " and user_id = ". $id .$condition;
		}
		if($order !=  "" && $order !=   NULL && is_null($order) == false)
		{
			$order  =  " order by " . $order;
		}
		$sQuery = "SELECT * FROM ".DB_PREFIX."user WHERE 1 = 1 " . $condition . $order;
		
		$rs  =  $this->runquery($sQuery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid = NULL, $stralphabet = NULL,$condition = "",$order = "user_id")
	{
		$arrlist  =  array();
		$i  =  0;
		$and  =  $condition;
		if(!is_null($intid) && trim($intid) !=  "") $and .=  " AND user_id  =  " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet) !=  "")	$and .=  " AND user_id like '" . $stralphabet . "%'";
		$sQuery = "SELECT * FROM ".DB_PREFIX."user WHERE 1 = 1 " . $and . " ORDER BY ".$order;
		$rs  =  $this->runquery($sQuery);
		while($artf_user =  mysql_fetch_array($rs))
		{
			$arrlist[$i]["user_id"]  =  $artf_user["user_id"];
			$arrlist[$i]["client_id"]  =  $artf_user["client_id"];
			$arrlist[$i]["user_type_id"]  =  $artf_user["user_type_id"];
			$arrlist[$i]["user_username"]  =  $artf_user["user_username"];
			$arrlist[$i]["user_password"]  =  $artf_user["user_password"];
			$arrlist[$i]["user_firstname"]  =  $artf_user["user_firstname"];
			$arrlist[$i]["user_lastname"]  =  $artf_user["user_lastname"];
			$arrlist[$i]["user_email"]  =  $artf_user["user_email"];
			$arrlist[$i]["user_company"]  =  $artf_user["user_company"];
			$arrlist[$i]["user_designation"]  =  $artf_user["user_designation"];
			$arrlist[$i]["user_phone"]  =  $artf_user["user_phone"];
			$arrlist[$i]["user_address1"]  =  $artf_user["user_address1"];
			$arrlist[$i]["user_address2"]  =  $artf_user["user_address2"];
			$arrlist[$i]["user_city"]  =  $artf_user["user_city"];
			$arrlist[$i]["user_state"]  =  $artf_user["user_state"];
			$arrlist[$i]["user_zipcode"]  =  $artf_user["user_zipcode"];
			$arrlist[$i]["user_lastlogin"]  =  $artf_user["user_lastlogin"];
			$arrlist[$i]["user_isactive"]  =  $artf_user["user_isactive"];
			$arrlist[$i]["created_date"]  =  $artf_user["created_date"];
			$arrlist[$i]["created_by"]  =  $artf_user["created_by"];
			$arrlist[$i]["updated_date"]  =  $artf_user["updated_date"];
			$arrlist[$i]["updated_by"]  =  $artf_user["updated_by"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id = "",$condition = "")
	{
		$rs = $this->fetchRecordSet($id, $condition);
		if($artf_user =  mysql_fetch_array($rs))
		{
			$this->user_id  =  $artf_user["user_id"];
			$this->client_id  =  $artf_user["client_id"];
			$this->user_type_id  =  $artf_user["user_type_id"];
			$this->user_username  =  $artf_user["user_username"];
			$this->user_password  =  $artf_user["user_password"];
			$this->user_firstname  =  $artf_user["user_firstname"];
			$this->user_lastname  =  $artf_user["user_lastname"];
			$this->user_email  =  $artf_user["user_email"];
			$this->user_company  =  $artf_user["user_company"];
			$this->user_designation  =  $artf_user["user_designation"];
			$this->user_phone  =  $artf_user["user_phone"];
			$this->user_address1  =  $artf_user["user_address1"];
			$this->user_address2  =  $artf_user["user_address2"];
			$this->user_city  =  $artf_user["user_city"];
			$this->user_state  =  $artf_user["user_state"];
			$this->user_country  =  $artf_user["user_country"];
			$this->user_zipcode  =  $artf_user["user_zipcode"];
			$this->user_lastlogin  =  $artf_user["user_lastlogin"];
			$this->user_isactive  =  $artf_user["user_isactive"];
			$this->created_date  =  $artf_user["created_date"];
			$this->created_by  =  $artf_user["created_by"];
			$this->updated_date  =  $artf_user["updated_date"];
			$this->updated_by  =  $artf_user["updated_by"];
		}
	}

	//Function to get particular field value
	function fieldValue($field = "user_id",$id = "",$condition = "",$order = "")
	{
		$rs = $this->fetchRecordSet($id, $condition, $order);
		$ret = 0;
		while($rw = mysql_fetch_assoc($rs))
		{
			$ret = $rw[$field];
		}
		return $ret;
	}

	//Function to add record into table
	function add() 
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."user 
					
					(client_id, user_type_id, user_username, user_password, 
					user_firstname, user_lastname, user_email, user_company,
					user_designation, user_phone,user_address1, user_address2,
					user_city, user_state, user_country, user_zipcode, 
					user_lastlogin, user_isactive, created_date, created_by, 
					updated_date, updated_by) 
					
					values(
							'".$this->client_id."', '".$this->user_type_id."',
							'".$this->user_username."', '".$this->user_password."',
							'".$this->user_firstname."','".$this->user_lastname."',
							'".$this->user_email."','".$this->user_company."',
							'".$this->user_designation."','".$this->user_phone."',
							'".$this->user_address1."','".$this->user_address2."',
							'".$this->user_city."','".$this->user_state."',
							'".$this->user_country."','".$this->user_zipcode."',
							'".$this->user_lastlogin."','".$this->user_isactive."',
							'".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
		
		$this->runquery($sQuery);
		$this->user_id  =  mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$sQuery = "UPDATE ".DB_PREFIX."user SET 
					client_id = '".$this->client_id."', 
					user_type_id = '".$this->user_type_id."', 
					user_username = '".$this->user_username."', 
					user_password = '".$this->user_password."', 
					user_firstname = '".$this->user_firstname."', 
					user_lastname = '".$this->user_lastname."', 
					user_email = '".$this->user_email."', 
					user_company = '".$this->user_company."', 
					user_designation = '".$this->user_designation."', 
					user_phone = '".$this->user_phone."', 
					user_address1 = '".$this->user_address1."', 
					user_address2 = '".$this->user_address2."', 
					user_city = '".$this->user_city."', 
					user_state = '".$this->user_state."', 
					user_country = '".$this->user_country."', 
					user_zipcode = '".$this->user_zipcode."', 
					user_lastlogin = '".$this->user_lastlogin."', 
					user_isactive = '".$this->user_isactive."',
					updated_date = '".currentScriptDate()."', 
					updated_by = '".$this->updated_by."' 
				
					WHERE user_id = ".$this->user_id;
		
		return $this->runquery($sQuery);
	}

	//Function to delete record from table
	function delete() 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."user  WHERE user_id in(".$this->checkedids.")";
		
		$this->runquery($sQuery);
		
		$sQuery = "DELETE FROM ".DB_PREFIX."admin_user_menu  WHERE user_id in(".$this->checkedids.")";
		
		$this->runquery($sQuery);
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$sQuery	 = 	"UPDATE " . DB_PREFIX . "user SET user_isactive = 'n' WHERE user_id in(" . $this->uncheckedids . ")";
		$result  =  $this->runquery($sQuery);
		if($result  ==  false)
			return ;
		$sQuery	 = 	"UPDATE " . DB_PREFIX . "user SET user_isactive = 'y' WHERE user_id in(" . $this->checkedids . ")";
		return $this->runquery($sQuery);;
	}
	
	function saveAccessRights()
	{
		$ids = implode(",",$this->checkedids);
		
		/*$strquery = "delete from ".DB_PREFIX."admin_user_menu where user_id='".$this->user_id."' and menu_id not in (".$ids.")";*/
		
		$strquery = "delete from ".DB_PREFIX."admin_user_menu where user_id='".$this->user_id."'";
		mysql_query($strquery);
		
		for ($i=0;$i<count($this->checkedids);$i++)
		{
			if ($this->getMenuCount(" and user_id='".$this->user_id."' and admin_menu_id='".$this->checkedids[$i]."'")==0)
			{
				$strquery = "insert into ".DB_PREFIX."admin_user_menu (admin_menu_id, user_id) values ('".$this->checkedids[$i]."','".$this->user_id."')";
				mysql_query($strquery);
			}
		}
		
	}
	function getMenuCount($condition)
	{
		$strquery = "select count(user_id)as cnt from ".DB_PREFIX."admin_user_menu where 1=1 ".$condition;
		$rs = mysql_query($strquery);
		$rw = mysql_fetch_array($rs);
		return $rw["cnt"];
	}
	
	function getUserTypeDtl($user_type_id)
	{
		$condition = "";
		if($user_type_id!='')
		{
			$condition = " AND user_type_id='".$user_type_id."' ";
		}
		$strquery = "select * from ".DB_PREFIX."user_type where 1=1 ".$condition;
		$rs = mysql_query($strquery);
		$rw = mysql_fetch_assoc($rs);
		return $rw["user_type_name"];
	}
	
}
?>