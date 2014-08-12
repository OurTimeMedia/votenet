<?php
class reports extends common
{
	//Property
	var $report_field_id;
	var $report_field_name;
	var $report_field_caption;
	var $report_field_type;
	var $report_field_order;
	var $report_field_isactive;
	var $field_for;
	var $field_on_right_align;
	
	var $report_filed_selection_id;
	var $report_filed_id;
	var $user_id;
	var $pagingType;
	
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;

	
	function reports()
	{
		$this->report_field_id = 0;
		$this->report_field_name = "";
		$this->report_field_caption = "";
		$this->report_field_type = 0;
		$this->report_field_order = 0;
		$this->report_field_isactive = 0;
		$this->field_for = 0;
		$this->field_on_right_align = 0;
		
		$this->report_filed_selection_id = 0;
		$this->report_filed_id = "";
		$this->user_id = 0;
	}
	
	function fetchFields()
	{
		$strQuery = "SELECT ".DB_PREFIX."report_fields.* FROM ".DB_PREFIX."report_fields WHERE report_field_type='".$this->report_field_type."' AND field_for='".$this->field_for."' AND report_field_isactive='1' AND field_for=1 ORDER BY report_field_order asc ";
		$rsOrder = mysql_query($strQuery) or die(mysql_error());
		$i=0;
		$arList = array();
		while($arfield = mysql_fetch_array($rsOrder))
		{
			$arList[$i]["report_field_id"] = $arfield["report_field_id"];
			$arList[$i]["report_field_name"] = $arfield["report_field_name"];
			$arList[$i]["report_field_caption"] = $arfield["report_field_caption"];
			$arList[$i]["report_field_name"] = $arfield["report_field_name"];
			$arList[$i]["field_from_table"] = $arfield["field_from_table"];	
			$arList[$i]["report_field_type"] = $arfield["report_field_type"];	
			$arList[$i]["report_field_default"] = $arfield["report_field_default"];
			$arList[$i]["report_field_order"] = $arfield["report_field_order"];	
			$arList[$i]["report_field_isactive"] = $arfield["report_field_isactive"];	
			$arList[$i]["field_on_right_align"] = $arfield["field_on_right_align"];
			$arList[$i]["field_for"] = $arfield["field_for"];	
			
			$i++;
		}
		return $arList;
	}
	
	function fetchSelectedFields()
	{
		$strQuery = "SELECT rf.* FROM ".DB_PREFIX."report_fields rf,".DB_PREFIX."report_filed_selection  rfs WHERE report_field_type='".$this->report_field_type."' AND rf.report_field_id=rfs.report_field_id AND rfs.user_id='".$this->user_id."' AND field_for='".$this->field_for."' AND report_field_isactive='1' AND field_for=1 ORDER BY report_field_order asc ";
		$rsOrder = mysql_query($strQuery) or die(mysql_error());
		$i=0;
		$arList = array();
		while($arfield = mysql_fetch_array($rsOrder))
		{
			$arList[$i]["report_field_id"] = $arfield["report_field_id"];
			$arList[$i]["report_field_name"] = $arfield["report_field_name"];
			$arList[$i]["report_field_caption"] = $arfield["report_field_caption"];
			$arList[$i]["report_field_name"] = $arfield["report_field_name"];
			$arList[$i]["field_from_table"] = $arfield["field_from_table"];			
			$arList[$i]["report_field_type"] = $arfield["report_field_type"];	
			$arList[$i]["report_field_default"] = $arfield["report_field_default"];
			$arList[$i]["report_field_order"] = $arfield["report_field_order"];	
			$arList[$i]["report_field_isactive"] = $arfield["report_field_isactive"];
			$arList[$i]["field_on_right_align"] = $arfield["field_on_right_align"];
			$arList[$i]["field_for"] = $arfield["field_for"];	
			
			$i++;
		}
		return $arList;
	}
	
	function deleteReportViewDtl()
	{
		$strQuery = "DELETE FROM ".DB_PREFIX."report_filed_selection WHERE report_field_id='".$this->report_field_id."' AND user_id='".$this->user_id."'";
		mysql_query($strQuery) or die(mysql_error());
	}
	
	function insertSelectedFields()
	{
		$strQuery = "SELECT * FROM ".DB_PREFIX."report_filed_selection WHERE report_field_id='".$this->report_field_id."' AND user_id='".$this->user_id."'";
		$rs = mysql_query($strQuery);
		
		if(mysql_num_rows($rs)==0) {
			$strQuery = "INSERT INTO ".DB_PREFIX."report_filed_selection (report_field_id,user_id,created_by,created_Date,updated_by,updated_date) values ('".$this->report_field_id."','".$this->user_id."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."') ";
			mysql_query($strQuery) or die(mysql_error());
		}
	}
}
?>