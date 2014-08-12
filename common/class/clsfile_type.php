<?php
class file_type
{
	//Property
	var $file_type_id;
	var $file_type_name;
	var $file_type_extension;
	var $file_type_description;
	var $file_type_isactive;
	var $file_type_base;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	function file_type()
	{
		$this->file_type_isactive = 1;
	}
	
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="file_type_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and file_type_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", file_type_id desc";
		}
		$strquery="SELECT * FROM ".DB_PREFIX."file_types WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="file_type_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND file_type_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND file_type_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."file_types WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_file_type= mysql_fetch_array($rs))
		{
			$arrlist[$i]["file_type_id"] = $artf_file_type["file_type_id"];
			$arrlist[$i]["file_type_name"] = $artf_file_type["file_type_name"];
			$arrlist[$i]["file_type_extension"] = $artf_file_type["file_type_extension"];
			$arrlist[$i]["file_type_description"] = $artf_file_type["file_type_description"];
			$arrlist[$i]["file_type_isactive"] = $artf_file_type["file_type_isactive"];
			$arrlist[$i]["file_type_base"] = $artf_file_type["file_type_base"];
			$arrlist[$i]["created_by"] = $artf_file_type["created_by"];
			$arrlist[$i]["created_date"] = $artf_file_type["created_date"];
			$arrlist[$i]["updated_by"] = $artf_file_type["updated_by"];
			$arrlist[$i]["updated_date"] = $artf_file_type["updated_date"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artf_file_type= mysql_fetch_array($rs))
		{
			$this->file_type_id = $artf_file_type["file_type_id"];
			$this->file_type_name = $artf_file_type["file_type_name"];
			$this->file_type_extension = $artf_file_type["file_type_extension"];
			$this->file_type_description = $artf_file_type["file_type_description"];
			$this->file_type_isactive = $artf_file_type["file_type_isactive"];
			$this->file_type_base = $artf_file_type["file_type_base"];
			$this->created_by = $artf_file_type["created_by"];
			$this->created_date = $artf_file_type["created_date"];
			$this->updated_by = $artf_file_type["updated_by"];
			$this->updated_date = $artf_file_type["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldValue($field="file_type_id",$id="",$condition="",$order="")
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
		$strquery="INSERT INTO ".DB_PREFIX."file_types 
					(file_type_name, file_type_description, 
					file_type_extension, file_type_isactive, file_type_base, created_by, 
					created_date, updated_by, updated_date) 
					
					values('".$this->file_type_name."',
						  '".$this->file_type_description."','".$this->file_type_extension."',
						  '".$this->file_type_isactive."', '".$this->file_type_base."', '".$this->created_by."',
						  '".currentScriptDate()."','".$this->updated_by."',
						  '".currentScriptDate()."')";
		mysql_query($strquery) or die(mysql_error());
		$this->file_type_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."file_types SET 
					file_type_name='".$this->file_type_name."', 
					file_type_description='".$this->file_type_description."', 
					file_type_extension='".$this->file_type_extension."', 
					file_type_isactive='".$this->file_type_isactive."', 
					file_type_base='".$this->file_type_base."',
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE file_type_id=".$this->file_type_id;
		
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."file_types  WHERE file_type_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "file_type SET file_type_isactive='n' WHERE file_type_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "file_type SET file_type_isactive='y' WHERE file_type_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
}
?>