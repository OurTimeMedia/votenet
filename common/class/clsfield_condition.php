<?php
class field_condition extends common
{
	//Property
	var $field_condition_id;
	var $field_id;
	var $field_option_id;
	var $show_field_ids;
	var $hide_field_ids;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchrecordset($id="",$condition="",$order="field_condition_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and field_condition_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."field_condition WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchallasarray($intid=NULL, $stralphabet=NULL,$condition="",$order="field_condition_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND field_condition_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND field_condition_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."field_condition WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($arfield_condition= mysql_fetch_array($rs))
		{
			$arrlist[$i]["field_condition_id"] = $arfield_condition["field_condition_id"];
			$arrlist[$i]["field_id"] = $arfield_condition["field_id"];
			$arrlist[$i]["field_option_id"] = $arfield_condition["field_option_id"];
			$arrlist[$i]["show_field_ids"] = $arfield_condition["show_field_ids"];
			$arrlist[$i]["hide_field_ids"] = $arfield_condition["hide_field_ids"];
			$arrlist[$i]["created_by"] = $arfield_condition["created_by"];
			$arrlist[$i]["created_date"] = $arfield_condition["created_date"];
			$arrlist[$i]["updated_by"] = $arfield_condition["updated_by"];
			$arrlist[$i]["updated_date"] = $arfield_condition["updated_date"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setallvalues($id="",$condition="")
	{
		$rs=$this->fetchrecordset($id, $condition);
		if($arfield_condition= mysql_fetch_array($rs))
		{
			$this->field_condition_id = $arfield_condition["field_condition_id"];
			$this->field_id = $arfield_condition["field_id"];
			$this->field_option_id = $arfield_condition["field_option_id"];
			$this->show_field_ids = $arfield_condition["show_field_ids"];
			$this->hide_field_ids = $arfield_condition["hide_field_ids"];
			$this->created_by = $arfield_condition["created_by"];
			$this->created_date = $arfield_condition["created_date"];
			$this->updated_by = $arfield_condition["updated_by"];
			$this->updated_date = $arfield_condition["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldvalue($field="field_condition_id",$id="",$condition="",$order="")
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
		if($this->field_id == "")
		{
			$strQuery_Field_id = "select field_id from ".DB_PREFIX."field_option where field_option_id = ".$this->field_option_id;			
			$rs = mysql_query($strQuery_Field_id) or die(mysql_error());
			$arrfield = mysql_fetch_array($rs);
			$this->field_id = $arrfield["field_id"];
		}		
		
		if($this->show_field_ids != "")
			$this->show_field_ids = ",".$this->show_field_ids;
			
		if($this->hide_field_ids != "")
			$this->hide_field_ids = ",".$this->hide_field_ids;
		
		$strGet_Count = "select * from ".DB_PREFIX."field_condition where field_option_id = ".$this->field_option_id;
		$rsGet_Count = mysql_query($strGet_Count);
		
		$strquery_field_upd = "";
		if(mysql_num_rows($rsGet_Count) > 0)
		{
			if($this->show_field_ids == "" && $this->hide_field_ids == "")
				$strquery="update ".DB_PREFIX."field_condition set show_field_ids='', hide_field_ids = '' where field_option_id = ".$this->field_option_id;
			else
				$strquery="update ".DB_PREFIX."field_condition set show_field_ids=concat(show_field_ids,'".$this->show_field_ids."'), hide_field_ids = concat(hide_field_ids,'".$this->hide_field_ids."') where field_option_id = ".$this->field_option_id;
				
			mysql_query($strquery) or die(mysql_error());
			$this->field_condition_id = 0;
			
			if($this->show_field_ids != "")
				$strquery_field_upd = "update ".DB_PREFIX."field set field_iscondition = 1 where field_id = ".substr($this->show_field_ids,1);
			
			if($this->hide_field_ids != "")
				$strquery_field_upd = "update ".DB_PREFIX."field set field_iscondition = 1 where field_id = ".substr($this->hide_field_ids,1);
			
			if($strquery_field_upd != "")
				mysql_query($strquery_field_upd);
			return 0;
		}
		else
		{		
			$strquery="INSERT INTO ".DB_PREFIX."field_condition (field_id, field_option_id, show_field_ids, hide_field_ids, created_by, created_date, updated_by, updated_date) values('".$this->field_id."','".$this->field_option_id."', concat(show_field_ids,'".$this->show_field_ids."'), concat(hide_field_ids,'".$this->hide_field_ids."'),'".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			mysql_query($strquery) or die(mysql_error());
			$this->field_condition_id = mysql_insert_id();
			
			if($this->show_field_ids != "")
				$strquery_field_upd = "update ".DB_PREFIX."field set field_iscondition = 1 where field_id = ".substr($this->show_field_ids,1);				
			
			if($this->hide_field_ids != "")
				$strquery_field_upd = "update ".DB_PREFIX."field set field_iscondition = 1 where field_id = ".substr($this->hide_field_ids,1);
			
			
			mysql_query($strquery_field_upd);
			
			return $this->field_condition_id;
		}
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."field_condition SET field_id='".$this->field_id."', field_option_id='".$this->field_option_id."', show_field_ids='".$this->show_field_ids."', hide_field_ids='".$this->hide_field_ids."', created_by='".$this->created_by."', created_date='".$this->created_date."', updated_by='".$this->updated_by."', updated_date='".$this->updated_date."' WHERE field_condition_id=".$this->field_condition_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."field_condition  WHERE field_condition_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "field_condition SET ='n' WHERE field_condition_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "field_condition SET ='y' WHERE field_condition_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
	
	function insertFromTempTable($field_id, $field_option_id, $show_field_ids, $hide_field_ids) 
	{
		$strquery="insert into " . DB_PREFIX . "field_condition (field_id, field_option_id, show_field_ids, hide_field_ids, created_by, created_date, updated_by, updated_date) values($field_id, $field_option_id, '$show_field_ids', '$hide_field_ids', '1', '".currentScriptDate()."', '1', '".currentScriptDate()."')";
		//echo $strquery;
		mysql_query($strquery);
		return mysql_insert_id();
	}
	
	function deleteFromTempTable($field_id) 
	{
		//$strquery="insert into tf_field_condition (field_id, field_option_id, show_field_ids, hide_field_ids, created_by, created_date, updated_by,    updated_date) values($field_id, $field_option_id, '$show_field_ids', '$hide_field_ids', '1', '".currentScriptDate()."', '1', '".currentScriptDate()."')";
		//echo $strquery;
		$strquery = "delete from " . DB_PREFIX . "field_option_temp where field_id = $field_id";
		//echo $strquery;
		mysql_query($strquery);		
	}
	
}
?>