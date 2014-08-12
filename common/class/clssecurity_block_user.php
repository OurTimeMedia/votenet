<?php
class security_block_user
{
	//Property
	var $blockuser_id;
	var $client_id;
	var $user_id;
	var $reason;
	var $user;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	function security_block_user()
	{
	}
	
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="blockuser_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and blockuser_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."block_user WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	function fetchRecordSetNew($id="",$condition="",$order="blockuser_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and blockuser_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery1=" SELECT ".DB_PREFIX."block_user.*,".DB_PREFIX."user.user_username FROM ".DB_PREFIX."block_user,".DB_PREFIX."user WHERE 1=1 AND (".DB_PREFIX."user.user_id=".DB_PREFIX."block_user.user_id) AND ".DB_PREFIX."block_user.user_id!=0 " . $condition ." GROUP BY ".DB_PREFIX."block_user.user_id ";
				
		$strquery = $strquery1." ". $order.", blockuser_id desc ";
		
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="blockuser_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND blockuser_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND blockuser_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."block_user WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_security= mysql_fetch_array($rs))
		{
			$arrlist[$i]["blockuser_id"] = $artf_security["blockuser_id"];
			$arrlist[$i]["client_id"] = $artf_security["client_id"];
			$arrlist[$i]["user_id"] = $artf_security["user_id"];
			$arrlist[$i]["reason"] = $artf_security["reason"];
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
			$this->blockuser_id = $artf_security["blockuser_id"];
			$this->client_id = $artf_security["client_id"];
			$this->user_id = $artf_security["user_id"];
			$this->reason = $artf_security["reason"];
			$this->created_by = $artf_security["created_by"];
			$this->created_date = $artf_security["created_date"];
			$this->updated_by = $artf_security["updated_by"];
			$this->updated_date = $artf_security["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldValue($field="blockuser_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchRecordSet($id, $condition, $order);
		$ret=0;
		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$field];
		}
		return $ret;
	}
	
	function add()
	{
		$strquery="INSERT INTO ".DB_PREFIX."block_user 
					(client_id, user_id, reason, created_by, 
					created_date, updated_by, updated_date) 
					
					values('".$this->client_id."','".$this->user_id."',
						  '".$this->reason."','".$this->created_by."',
						  '".currentScriptDate()."','".$this->updated_by."',
						  '".currentScriptDate()."')";
		mysql_query($strquery) or die(mysql_error());
		$this->blockuser_id = mysql_insert_id();
		return mysql_insert_id();
	}
	
	function update()
	{
		$sQuery="UPDATE ".DB_PREFIX."block_user SET 
					client_id='".$this->client_id."', 
					user_id='".$this->user_id."', 
					reason='".$this->reason."',
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE blockuser_id=".$this->blockuser_id;
		
		return mysql_query($sQuery) or die(mysql_error());
	}

	function unblock()
	{	
		$sQuery = "DELETE FROM ".DB_PREFIX."block_user  WHERE blockuser_id in(".$this->checkedids.")";
		
		return mysql_query($sQuery);
	}
	
	//Function to delete record from table
	function delete() 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."block_user  WHERE blockuser_id in(".$this->checkedids.")";
		
		return mysql_query($sQuery) or die(mysql_error());
	}
	
	function isUserAvailable($userName)
	{
		$strquery="SELECT user_id FROM ".DB_PREFIX."user WHERE 1=1 AND user_username='".$userName."' AND client_id='".$this->client_id."' ";
		$rs=mysql_query($strquery);
		return mysql_num_rows($rs);
	}
}
?>