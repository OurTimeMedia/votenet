<?php
class theme
{
		//Property
	var $theme_id;
	var $user_id;
	var $theme_color;
	var $theme_backimage;
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="theme_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and theme_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."theme WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="theme_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND theme_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND theme_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."theme WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artheme= mysql_fetch_array($rs))
		{
			$arrlist[$i]["theme_id"] = $artheme["theme_id"];
			$arrlist[$i]["user_id"] = $artheme["user_id"];
			$arrlist[$i]["theme_color"] = $artheme["theme_color"];
			$arrlist[$i]["theme_backimage"] = $artheme["theme_backimage"];
			$arrlist[$i]["created_date"] = $artheme["created_date"];
			$arrlist[$i]["created_by"] = $artheme["created_by"];
			$arrlist[$i]["updated_date"] = $artheme["updated_date"];
			$arrlist[$i]["updated_by"] = $artheme["updated_by"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artheme= mysql_fetch_array($rs))
		{
			$this->theme_id = $artheme["theme_id"];
			$this->user_id = $artheme["user_id"];
			$this->theme_color = $artheme["theme_color"];
			$this->theme_backimage = $artheme["theme_backimage"];
			$this->created_date = $artheme["created_date"];
			$this->created_by = $artheme["created_by"];
			$this->updated_date = $artheme["updated_date"];
			$this->updated_by = $artheme["updated_by"];
		}
	}

	//Function to get particular field value
	function fieldValue($field="theme_id",$id="",$condition="",$order="")
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
		$arr = $this->fetchAllAsArray("",""," and user_id=".$this->user_id);
		if (count($arr)==0)
		{
			$strquery="INSERT INTO ".DB_PREFIX."theme (user_id, theme_color, created_date, created_by) values('".$this->user_id."','".$this->theme_color."','".$this->created_date."','".$this->created_by."')";
			mysql_query($strquery) or die(mysql_error());
			$this->theme_id = mysql_insert_id();
			return mysql_insert_id();
		}
		else
		{
			$strquery="UPDATE ".DB_PREFIX."theme SET theme_color='".$this->theme_color."', updated_date='".$this->updated_date."', updated_by='".$this->updated_by."' WHERE theme_id=".$arr[0]["theme_id"];
			mysql_query($strquery) or die(mysql_error());
			$this->theme_id = $arr[0]["theme_id"];
			return $this->theme_id;
		}
	}

	//Function to update record of table
	function updateBackImage() 
	{
		$strquery="UPDATE ".DB_PREFIX."theme SET theme_backimage='".$this->theme_backimage."', updated_date='".$this->updated_date."', updated_by='".$this->updated_by."' WHERE theme_id=".$this->theme_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function deleteImage() 
	{
		$filename = $this->fieldValue("theme_backimage",""," and user_id=".$this->user_id);
		if (trim($filename)!="" && file_exists(THEME_BACK_IMAGE.$filename))
			unlink(THEME_BACK_IMAGE.$filename);
		
		$strquery="UPDATE ".DB_PREFIX."theme SET theme_backimage='', updated_date='".$this->updated_date."', updated_by='".$this->updated_by."' WHERE user_id=".$this->user_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function getCount($condition="")
	{
		$strquery	=	"select count(theme_id) as cnt from " . DB_PREFIX . "theme WHERE 1=1 ".$condition;
		$result = mysql_query($strquery) or die(mysql_error());
		
		$rw = mysql_fetch_array($result);
		return $rw["cnt"];
	}
}
?>