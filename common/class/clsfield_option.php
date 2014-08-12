<?php
class field_option extends common
{
	//Property
	var $field_option_id;
	var $field_id;
	var $field_option;
	var $file_type_id;
	var $show_field_ids;
	var $hide_field_ids;
	var $field_option_order;
	var $field_option_isactive;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;
	
	var $language_id;

	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchrecordset($id="",$condition="",$order="field_option_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and field_option_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."field_option WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchallasarray($intid=NULL, $stralphabet=NULL,$condition="",$order="field_option_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND field_option_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND field_option_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."field_option WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);		
		while($arfield_option= mysql_fetch_array($rs))
		{
			$arrlist[$i]["field_option_id"] = $arfield_option["field_option_id"];
			$arrlist[$i]["field_id"] = $arfield_option["field_id"];
			$arrlist[$i]["field_option"] = $arfield_option["field_option"];
			$arrlist[$i]["file_type_id"] = $arfield_option["file_type_id"];
			$arrlist[$i]["show_field_ids"] = $arfield_option["show_field_ids"];
			$arrlist[$i]["hide_field_ids"] = $arfield_option["hide_field_ids"];
			$arrlist[$i]["field_option_order"] = $arfield_option["field_option_order"];
			$arrlist[$i]["field_option_isactive"] = $arfield_option["field_option_isactive"];
			$arrlist[$i]["created_by"] = $arfield_option["created_by"];
			$arrlist[$i]["created_date"] = $arfield_option["created_date"];
			$arrlist[$i]["updated_by"] = $arfield_option["updated_by"];
			$arrlist[$i]["updated_date"] = $arfield_option["updated_date"];
			$i++;
		}
		return $arrlist;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArrayFront($intid=NULL, $stralphabet=NULL,$condition="",$order="field_option_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND field_option_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND field_option_id like '" . $stralphabet . "%'";
				
		$strquery="SELECT fo.*, if(flo.field_option='',fo.field_option,flo.field_option) as langfield_option FROM ".DB_PREFIX."field_option fo LEFT JOIN ".DB_PREFIX."field_option_language_text flo ON ( flo.field_option_id=fo.field_option_id AND language_id='".$this->language_id."') WHERE 1=1 " . $and . " ORDER BY ".$order;
		// echo $strquery;
		$rs=mysql_query($strquery);		
		while($arfield_option= mysql_fetch_array($rs))
		{
			$arrlist[$i]["field_option_id"] = $arfield_option["field_option_id"];
			$arrlist[$i]["field_id"] = $arfield_option["field_id"];
			$arrlist[$i]["field_option"] = $arfield_option["langfield_option"];
			$arrlist[$i]["file_type_id"] = $arfield_option["file_type_id"];
			$arrlist[$i]["show_field_ids"] = $arfield_option["show_field_ids"];
			$arrlist[$i]["hide_field_ids"] = $arfield_option["hide_field_ids"];
			$arrlist[$i]["field_option_order"] = $arfield_option["field_option_order"];
			$arrlist[$i]["field_option_isactive"] = $arfield_option["field_option_isactive"];
			$arrlist[$i]["created_by"] = $arfield_option["created_by"];
			$arrlist[$i]["created_date"] = $arfield_option["created_date"];
			$arrlist[$i]["updated_by"] = $arfield_option["updated_by"];
			$arrlist[$i]["updated_date"] = $arfield_option["updated_date"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setallvalues($id="",$condition="")
	{
		$rs=$this->fetchrecordset($id, $condition);
		if($arfield_option= mysql_fetch_array($rs))
		{
			$this->field_option_id = $arfield_option["field_option_id"];
			$this->field_id = $arfield_option["field_id"];
			$this->field_option = $arfield_option["field_option"];
			$this->file_type_id = $arfield_option["file_type_id"];
			$this->show_field_ids = $arfield_option["show_field_ids"];
			$this->hide_field_ids = $arfield_option["hide_field_ids"];
			$this->field_option_order = $arfield_option["field_option_order"];
			$this->field_option_isactive = $arfield_option["field_option_isactive"];
			$this->created_by = $arfield_option["created_by"];
			$this->created_date = $arfield_option["created_date"];
			$this->updated_by = $arfield_option["updated_by"];
			$this->updated_date = $arfield_option["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldvalue($field="field_option_id",$id="",$condition="",$order="")
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
		$strquery="INSERT INTO ".DB_PREFIX."field_option (field_id, field_option, file_type_id, show_field_ids, hide_field_ids, field_option_order, field_option_isactive, created_by, created_date, updated_by, updated_date) values('".$this->field_id."','".$this->field_option."','".$this->file_type_id."','".$this->show_field_ids."','".$this->hide_field_ids."','".$this->field_option_order."','".$this->field_option_isactive."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
		mysql_query($strquery) or die(mysql_error());
		$this->field_option_id = mysql_insert_id();
		return mysql_insert_id();
	}
	
	//Function to add record into table
	function add_option_language() 
	{
		$strquery="INSERT INTO ".DB_PREFIX."field_option_language_text (field_option_id, language_id, field_option, created_by, created_date, updated_by, updated_date) values('".$this->field_option_id."','".$this->language_id."','".$this->field_option."','".$this->created_by."', '".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
		
		mysql_query($strquery) or die(mysql_error());
		$this->field_option_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."field_option SET field_id='".$this->field_id."', field_option='".$this->field_option."', file_type_id='".$this->file_type_id."', show_field_ids='".$this->show_field_ids."', hide_field_ids='".$this->hide_field_ids."', field_option_order='".$this->field_option_order."', field_option_isactive='".$this->field_option_isactive."', created_by='".$this->created_by."', created_date='".$this->created_date."', updated_by='".$this->updated_by."', updated_date='".$this->updated_date."' WHERE field_option_id=".$this->field_option_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."field_option  WHERE field_option_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "field_option SET field_option_isactive='n' WHERE field_option_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "field_option SET field_option_isactive='y' WHERE field_option_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
	
	//function that will fetch all the options including the field names
	function getAllOption_With_Fields($client_id = 0, $field_id = 0)
	{
		$cond = "";
		if($field_id != 0)
			$cond = " and f.field_id != ".$field_id;
		
		$strquery = "SELECT field_option_id, field_option, f.field_id, f.field_caption  FROM " . DB_PREFIX . "field_option fo, " . DB_PREFIX . "field f, " . DB_PREFIX . "form form WHERE fo.field_id = f.field_id AND f.form_id = form.form_id AND f.field_isactive = '1' AND form.client_id = ".$client_id.$cond." order by field_order, field_option_order";		
		$rs=mysql_query($strquery);
		$i=0;
		$arrlist = array();
		while($arfield_option= mysql_fetch_array($rs))
		{
			$arrlist[$i]["field_option_id"] = $arfield_option["field_option_id"];
			$arrlist[$i]["field_option"] = $arfield_option["field_option"];
			$arrlist[$i]["field_id"] = $arfield_option["field_id"];
			$arrlist[$i]["field_caption"] = $arfield_option["field_caption"];			
			$i++;
		}
		return $arrlist;	
	}	
	
	//function that will fetch all the options for edit sued to allocate the value to hidden field
	function getAllOption_For_Fields_For_Edit($field_id)
	{
		$strquery = "SELECT field_option_language_text_id, folt.field_option_id, language_id, folt.field_option FROM " . DB_PREFIX . "field_option_language_text folt, " . DB_PREFIX . "field_option fo WHERE folt.field_option_id = fo.field_option_id AND fo.field_id = $field_id order by field_option_id, language_id";		
		$rs=mysql_query($strquery);	
		$previous_field_option_id = 0;
		$retStr = "";
		$i = 0;
		
		while($i <= mysql_num_rows($rs))
		{
			if(!($i >=  mysql_num_rows($rs)))
				$arfield_option = mysql_fetch_array($rs);
				
			if($previous_field_option_id == $arfield_option["field_option_id"])
			{
				$retStr = $retStr . "#^#" . $arfield_option["field_option"];
			}
			else
			{
				if($retStr == "")
					$retStr = $arfield_option["field_option"];
				else
					$retStr = $retStr . "^#^" . $arfield_option["field_option"];
			}
			$previous_field_option_id = $arfield_option["field_option_id"];
			$i++;
		}
		//echo $retStr;
		//exit;
		return $retStr;	
	}	
	
	//function that will fetch all the options id for edit to allocate the value to hidden field
	function getAllOption_For_Fields_Id_For_Edit($field_id)
	{
		$strquery = "SELECT field_option_id FROM " . DB_PREFIX . "field_option WHERE field_id = $field_id order by field_option_id";		
		$rs=mysql_query($strquery);	
		$previous_field_option_id = 0;
		$retStr = "";
		$i = 0;
		
		while($i < mysql_num_rows($rs))
		{
			$arfield_option = mysql_fetch_array($rs);
							
			if($retStr == "")
				$retStr = $arfield_option["field_option_id"];
			else
				$retStr = $retStr . "," . $arfield_option["field_option_id"];
				
			$i++;
		}
		
		return $retStr;	
	}	
	
	//function that will fetch all the options id for edit to allocate the value to hidden field
	function insertOption_In_Temp_Table($field_id)
	{
		/*$strquery_1 = "select * from " . DB_PREFIX . "field_condition where field_id = $field_id";
		$rs1 = mysql_query($strquery_1);
		while($arfield_option= mysql_fetch_array($rs1))
		{
			if($arfield_option["show_field_ids"] != "" && $arfield_option["hide_field_ids"] != "")
			{*/
				$strquery = "insert into " . DB_PREFIX . "field_option_temp (field_option_id, field_id, field_option, file_type_id, show_field_ids, hide_field_ids, field_option_order, field_option_isactive, created_by, created_date, updated_by, updated_date) select field_option_id, field_id, field_option, file_type_id, (select show_field_ids from " . DB_PREFIX . "field_condition where field_id = $field_id and field_option_id = fo.field_option_id), (select hide_field_ids from " . DB_PREFIX . "field_condition where field_id = $field_id and field_option_id = fo.field_option_id), field_option_order, field_option_isactive, created_by, created_date, updated_by, updated_date from " . DB_PREFIX . "field_option fo where field_id = $field_id";
				
				mysql_query($strquery);
		//	}
	//	}
	}	
	
	// function to get the field option id from the field_temp table
	function getField_Option_Temp($field_id, $field_option)
	{
		$strquery = "select * from " . DB_PREFIX . "field_option_temp where field_id = $field_id and field_option = '$field_option' and show_field_ids IS NOT NULL and hide_field_ids IS NOT NULL order by field_option_order";		
		//echo $strquery;
		$rs = mysql_query($strquery);
		return $rs;
	}
	
	function deleteFieldOption()
	{
		
		$strremove_conditon = "update ".DB_PREFIX."field_condition set show_field_ids = replace(show_field_ids, ',".$this->field_id."', ''), hide_field_ids = replace(hide_field_ids, ',".$this->field_id."', '')";
		mysql_query($strremove_conditon) or die(mysql_error());
		
		$strdelete_condition = "delete from ".DB_PREFIX."field_condition where field_id=".$this->field_id;
		mysql_query($strdelete_condition) or die(mysql_error());
				
		$strdelete_field_option_language_text = "delete from ".DB_PREFIX."field_option_language_text where field_option_id in ( select field_option_id from ".DB_PREFIX."field_option where field_id = ".$this->field_id.")";
		mysql_query($strdelete_field_option_language_text) or die(mysql_error());
		
		$strdelete_field_option = "delete from ".DB_PREFIX."field_option where field_id = ".$this->field_id;
		mysql_query($strdelete_field_option) or die(mysql_error());		
	}
}
?>