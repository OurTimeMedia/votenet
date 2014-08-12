<?php
class user
{
	//Property
	var $user_id;
	var $user_role_id;
	var $first_name;
	var $last_name;
	var $email;
	var $user_name;
	var $password;
	var $user_active;

	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchrecordset($id="",$condition="",$order="user_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and user_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT *, (SELECT user_role_name FROM " . DB_PREFIX . "user_role WHERE user_role_id = " . DB_PREFIX . "user.user_role_id) user_role_name FROM ".DB_PREFIX."user WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchallasarray($intid=NULL, $stralphabet=NULL,$condition="",$order="user_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND user_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND user_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."user WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($aruser= mysql_fetch_array($rs))
		{
			$arrlist[$i]["user_id"] = $aruser["user_id"];
			$arrlist[$i]["user_role_id"] = $aruser["user_role_id"];
			$arrlist[$i]["first_name"] = $aruser["first_name"];
			$arrlist[$i]["last_name"] = $aruser["last_name"];
			$arrlist[$i]["email"] = $aruser["email"];
			$arrlist[$i]["user_name"] = $aruser["user_name"];
			$arrlist[$i]["password"] = $aruser["password"];
			$arrlist[$i]["user_active"] = $aruser["user_active"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setallvalues($id="",$condition="")
	{
		$rs=$this->fetchrecordset($id, $condition);
		if($aruser= mysql_fetch_array($rs))
		{
			$this->user_id = $aruser["user_id"];
			$this->user_role_id = $aruser["user_role_id"];
			$this->first_name = $aruser["first_name"];
			$this->last_name = $aruser["last_name"];
			$this->email = $aruser["email"];
			$this->user_name = $aruser["user_name"];
			$this->password = $aruser["password"];
			$this->user_active = $aruser["user_active"];
		}
	}

	//Function to get particular field value
	function fieldvalue($field="user_id",$id="",$condition="",$order="")
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
		$strquery="INSERT INTO ".DB_PREFIX."user (user_role_id, first_name, last_name, email, user_name, password, user_active) values('".$this->user_role_id."','".$this->first_name."','".$this->last_name."','".$this->email."','".$this->user_name."','".$this->password."','".$this->user_active."')";
		mysql_query($strquery) or die(mysql_error());
		$this->user_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."user SET user_role_id='".$this->user_role_id."', first_name='".$this->first_name."', last_name='".$this->last_name."', email='".$this->email."', user_name='".$this->user_name."', password='".$this->password."', user_active='".$this->user_active."' WHERE user_id=".$this->user_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."user  WHERE user_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "user SET user_active='n' WHERE user_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "user SET user_active='y' WHERE user_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
	
	function change_password ( $old_password, $new_password ) {
		global $cmn;
		$user_id = $cmn->get_session(ADMIN_USER_ID);
		$strquery = 'UPDATE ' . DB_PREFIX . 'user SET password = \'' . $new_password . '\' WHERE user_id = ' . (int) $user_id . ' AND password = \'' . $old_password . '\'';
		mysql_query($strquery) or die(mysql_error());
		return mysql_affected_rows();
	}
}
?>