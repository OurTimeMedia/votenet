<?php
class field_attribute extends common
{
	//Property
	var $field_attribute_id;
	var $field_id;
	var $field_type_id;
	var $field_type_attribute_id;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $attribute_value;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchrecordset($id="",$condition="",$order="field_attribute_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and field_attribute_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."field_attribute WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchallasarray($intid=NULL, $stralphabet=NULL,$condition="",$order="field_attribute_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND field_attribute_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND field_attribute_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."field_attribute WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($arfield_attribute= mysql_fetch_array($rs))
		{
			$arrlist[$i]["field_attribute_id"] = $arfield_attribute["field_attribute_id"];
			$arrlist[$i]["field_id"] = $arfield_attribute["field_id"];
			$arrlist[$i]["field_type_id"] = $arfield_attribute["field_type_id"];
			$arrlist[$i]["field_type_attribute_id"] = $arfield_attribute["field_type_attribute_id"];
			$arrlist[$i]["attribute_value"] = $arfield_attribute["attribute_value"];
			$arrlist[$i]["created_by"] = $arfield_attribute["created_by"];
			$arrlist[$i]["created_date"] = $arfield_attribute["created_date"];
			$arrlist[$i]["updated_by"] = $arfield_attribute["updated_by"];
			$arrlist[$i]["updated_date"] = $arfield_attribute["updated_date"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setallvalues($id="",$condition="")
	{
		$rs=$this->fetchrecordset($id, $condition);
		if($arfield_attribute= mysql_fetch_array($rs))
		{
			$this->field_attribute_id = $arfield_attribute["field_attribute_id"];
			$this->field_id = $arfield_attribute["field_id"];
			$this->field_type_id = $arfield_attribute["field_type_id"];
			$this->  	field_type_attribute_id = $arfield_attribute["field_type_attribute_id"];
			$this->created_by = $arfield_attribute["created_by"];
			$this->created_date = $arfield_attribute["created_date"];
			$this->updated_by = $arfield_attribute["updated_by"];
			$this->  	updated_date = $arfield_attribute["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldvalue($field="field_attribute_id",$id="",$condition="",$order="")
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
		$strquery="INSERT INTO ".DB_PREFIX."field_attribute (field_id, field_type_id, field_type_attribute_id, attribute_value, created_by, created_date, updated_by,	updated_date) values('".$this->field_id."','".$this->field_type_id."','".$this->field_type_attribute_id."', '".htmlspecialchars($this->attribute_value,ENT_QUOTES)."','".parent::getSession(ADMIN_USER_ID)."','".currentScriptDate()."','".parent::getSession(ADMIN_USER_ID)."','".currentScriptDate()."')";
		mysql_query($strquery) or die(mysql_error());
		$this->field_attribute_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."field_attribute SET field_id='".$this->field_id."', field_type_id='".$this->field_type_id."',   	field_type_attribute_id='".$this->field_type_attribute_id."', attribute_value = ".$this->attribute_value.", created_by='".$this->created_by."', created_date='".$this->created_date."', updated_by='".$this->updated_by."',   	updated_date='".$this->updated_date."' WHERE field_attribute_id=".$this->field_attribute_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."field_attribute  WHERE field_attribute_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "field_attribute SET ='n' WHERE field_attribute_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "field_attribute SET ='y' WHERE field_attribute_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
}
?>