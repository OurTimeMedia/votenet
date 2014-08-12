<?php
class user_role
{
	//Property
	var $user_role_id;
	var $user_role_name;
	var $user_role_active;

	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchrecordset($id="",$condition="",$order="user_role_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and user_role_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."user_role WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchallasarray($intid=NULL, $stralphabet=NULL,$condition="",$order="user_role_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND user_role_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND user_role_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."user_role WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($aruser_role= mysql_fetch_array($rs))
		{
			$arrlist[$i]["user_role_id"] = $aruser_role["user_role_id"];
			$arrlist[$i]["user_role_name"] = $aruser_role["user_role_name"];
			$arrlist[$i]["user_role_active"] = $aruser_role["user_role_active"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setallvalues($id="",$condition="")
	{
		$rs=$this->fetchrecordset($id, $condition);
		if($aruser_role= mysql_fetch_array($rs))
		{
			$this->user_role_id = $aruser_role["user_role_id"];
			$this->user_role_name = $aruser_role["user_role_name"];
			$this->user_role_active = $aruser_role["user_role_active"];
			$this->create_date = $aruser_role["create_date"];
		}
	}

	//Function to get particular field value
	function fieldvalue($field="user_role_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchrecordset($id, $condition, $order);
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
		$strquery="INSERT INTO ".DB_PREFIX."user_role (user_role_name, user_role_active) values('".$this->user_role_name."','".$this->user_role_active."')";
		mysql_query($strquery) or die(mysql_error());
		$this->user_role_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."user_role SET user_role_name='".$this->user_role_name."', user_role_active='".$this->user_role_active."' WHERE user_role_id=".$this->user_role_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."user_role  WHERE user_role_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "user_role SET user_role_active='n' WHERE user_role_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "user_role SET user_role_active='y' WHERE user_role_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
}
?>