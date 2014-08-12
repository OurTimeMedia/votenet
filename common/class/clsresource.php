<?php
class resource
{
	//Property
	var $resource_id;
	var $resource_name;
	var $resource_text;
	var $resource_page;
	var $resource_order;
	var $resource_isactive;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	function resource()
	{
		$this->resource_order = 0;
	}
	
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="resource_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and resource_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."resource WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="resource_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND resource_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND resource_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."resource WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($arresource= mysql_fetch_array($rs))
		{
			$arrlist[$i]["resource_id"] = $arresource["resource_id"];
			$arrlist[$i]["resource_name"] = $arresource["resource_name"];
			$arrlist[$i]["resource_text"] = $arresource["resource_text"];
			$arrlist[$i]["resource_page"] = $arresource["resource_page"];
			$arrlist[$i]["resource_order"] = $arresource["resource_order"];
			$arrlist[$i]["resource_isactive"] = $arresource["resource_isactive"];
			$arrlist[$i]["created_by"] = $arresource["created_by"];
			$arrlist[$i]["created_date"] = $arresource["created_date"];
			$arrlist[$i]["updated_by"] = $arresource["updated_by"];
			$arrlist[$i]["updated_date"] = $arresource["updated_date"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($arresource= mysql_fetch_array($rs))
		{
			$this->resource_id = $arresource["resource_id"];
			$this->resource_name = $arresource["resource_name"];
			$this->resource_text = $arresource["resource_text"];
			$this->resource_page = $arresource["resource_page"];
			$this->resource_order = $arresource["resource_order"];
			$this->resource_isactive = $arresource["resource_isactive"];
			$this->created_by = $arresource["created_by"];
			$this->created_date = $arresource["created_date"];
			$this->updated_by = $arresource["updated_by"];
			$this->updated_date = $arresource["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldValue($field="resource_id",$id="",$condition="",$order="")
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
		$strquery="INSERT INTO ".DB_PREFIX."resource (resource_name, resource_text, resource_page, resource_order, resource_isactive, created_by, created_date, updated_by, updated_date) values('".$this->resource_name."','".$this->resource_text."','".$this->resource_page."','".$this->resource_order."','".$this->resource_isactive."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
		mysql_query($strquery) or die(mysql_error());
		$this->resource_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."resource SET resource_name='".$this->resource_name."', resource_text='".$this->resource_text."', resource_page='".$this->resource_page."', resource_order='".$this->resource_order."', resource_isactive='".$this->resource_isactive."', updated_by='".$this->updated_by."', updated_date='".currentScriptDate()."' WHERE resource_id=".$this->resource_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."resource  WHERE resource_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "resource SET resource_isactive='n' WHERE resource_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "resource SET resource_isactive='y' WHERE resource_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
}
?>