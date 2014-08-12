<?php
class security
{
	//Property
	var $user_login_history_id;
	var $client_id;
	var $user_id;
	var $loginuser_name;
	var $login_date;
	var $ip_address;
	var $login_result;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="user_login_history_id")
	{
		if($order=="user_type_name")
		{
			return $this->fetchRecordSetNew($id,$condition,$order);
		}
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and user_login_history_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."user_login_history WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	//Function to retrieve recordset of table
	function fetchRecordSetNew($id="",$condition="",$order="contest_payment_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and contest_payment_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		//$strquery="SELECT * FROM ".DB_PREFIX."user_login_history ulh,".DB_PREFIX."user u,".DB_PREFIX."user_type ut WHERE 1=1 AND ulh.user_id=u.user_id AND u.user_type_id=ut.user_type_id " . $condition . $order;
		$strquery="SELECT * FROM ".DB_PREFIX."user_login_history ulh WHERE 1=1  " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="user_login_history_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND user_login_history_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND user_login_history_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."user_login_history WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_security= mysql_fetch_array($rs))
		{
			$arrlist[$i]["user_login_history_id"] = $artf_security["user_login_history_id"];
			$arrlist[$i]["client_id"] = $artf_security["client_id"];
			$arrlist[$i]["user_id"] = $artf_security["user_id"];
			$arrlist[$i]["loginuser_name"] = $artf_security["loginuser_name"];
			$arrlist[$i]["login_date"] = $artf_security["login_date"];
			$arrlist[$i]["ip_address"] = $artf_security["ip_address"];
			$arrlist[$i]["login_result"] = $artf_security["login_result"];
			$arrlist[$i]["created_by"] = $artf_security["created_by"];
			$arrlist[$i]["created_date"] = $artf_security["created_date"];
			$arrlist[$i]["updated_by"] = $artf_security["updated_by"];
			$arrlist[$i]["updated_date"] = $artf_security["updated_date"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artf_security= mysql_fetch_array($rs))
		{
			$this->user_login_history_id = $artf_security["user_login_history_id"];
			$this->client_id = $artf_security["client_id"];
			$this->user_id = $artf_security["user_id"];
			$this->loginuser_name = $artf_security["loginuser_name"];
			$this->login_date = $artf_security["login_date"];
			$this->ip_address = $artf_security["ip_address"];
			$this->login_result = $artf_security["login_result"];
			$this->created_by = $artf_security["created_by"];
			$this->created_date = $artf_security["created_date"];
			$this->updated_by = $artf_security["updated_by"];
			$this->updated_date = $artf_security["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldValue($field="user_login_history_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchRecordSet($id, $condition, $order);
		$ret=0;
		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$field];
		}
		return $ret;
	}

}
?>