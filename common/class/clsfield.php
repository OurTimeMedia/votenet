<?php
class field extends common
{
	// Declaration of the public variables 
	var $field_id;
	var $client_id;
	var $form_id;
	var $field_mapping_id;
	var $field_type_id;
	var $field_header_field;
	var $reg_type;
	var $pdf_field_name;
	var $field_name;
	var $field_caption;
	var $field_note;
	var $is_required;
	var $field_ishide;
	var $field_iscondition;
	var $field_order;
	var $field_isactive;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $field_language_text_id;
	var $pagingType;
		
	// ALl the public functions 
	function getField_Type_Attributes()
	{		
		$i = 0;				
		$strquery="SELECT * FROM ".DB_PREFIX."field_type_attribute WHERE field_type_id = ".$this->field_type_id." and 	field_type_attribute_isactive = 1 ORDER BY field_type_attribute_order";		
		$arAttributes = array();
		$rs=mysql_query($strquery);			
		if(mysql_num_rows($rs) > 0)
		{	
			while($arAttributes_row = mysql_fetch_array($rs))
			{
				$arAttributes[$i]["field_type_attribute_id"] = $arAttributes_row["field_type_attribute_id"];
				
				$arAttributes[$i]["field_type_id"] = $arAttributes_row["field_type_id"];
				$arAttributes[$i]["field_type_attribute_name"] = $arAttributes_row["field_type_attribute_name"];
				$arAttributes[$i]["field_type_attribute_display_name"] = $arAttributes_row["field_type_attribute_display_name"];
				$arAttributes[$i]["field_type_attribute_order"] = $arAttributes_row["field_type_attribute_order"];
				$arAttributes[$i]["field_type_attribute_isactive"] = $arAttributes_row["field_type_attribute_isactive"];
				$i++;
			}
		}
		return $arAttributes;
	}
	
	//Function to get particular field value
	function fieldValue($field = "field_id",$id = "",$condition = "",$order = "")
	{
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
			$condition  =  " and ".DB_PREFIX."field.field_id = ". $id .$condition;
		}
	
		$sQuery = "SELECT * FROM ".DB_PREFIX."field WHERE 1 = 1 " . $condition . $order;
		$rs  =  $this->runquery($sQuery);
		
		$ret = 0;
		while($rw = mysql_fetch_assoc($rs))
		{
			$ret = $rw[$field];
		}
		return $ret;
	}
	
	function Insert_Field($insert_form="1")
	{	
		$objForm = new form();		
		
		$current_form_id = "";
		$current_form_id = $objForm->fieldValue("form_id",""," and client_id = ".$this->client_id,"");
		
		if($current_form_id == "")	// if this is 0 then insert in form 
		{			
			$objForm->client_id = $this->client_id;
			$objForm->form_isactive = "1";
			$objForm->created_by = $this->created_by;			
			$objForm->updated_by = $this->updated_by;
			$this->form_id = $objForm->add_with_check();
		}
		else
		{
			$this->form_id =$objForm->fieldValue("form_id",""," and client_id = ".$this->client_id,"");		
		}
				
		
		if($this->field_type_id == 1)
			$strQuery_For_Update = "(select ((IFNULL(max(field_order),0)) + 1) as next_order from ".DB_PREFIX."field where form_id = ".$this->form_id." and field_header_field = '0')";
		else
			$strQuery_For_Update = "(select ((IFNULL(max(field_order),0)) + 1) as next_order from ".DB_PREFIX."field where form_id = ".$this->form_id." and field_header_field = '".$this->field_header_field."')";
		
		$rsOrder = mysql_query($strQuery_For_Update) or die(mysql_error());
		$arrOrder = mysql_fetch_array($rsOrder);
				
		$order = (int)$arrOrder['next_order'];
		
		$strQuery_Field = "insert into ".DB_PREFIX."field (client_id, form_id, field_mapping_id, field_type_id, field_header_field, reg_type, pdf_field_name, field_name, field_caption, field_note, is_required, field_ishide, field_iscondition, field_order, created_by, created_date, updated_by, updated_date) values (".$this->client_id.", ".$this->form_id.", ".$this->field_mapping_id.", ".$this->field_type_id.", '".$this->field_header_field."',  '".$this->reg_type."', '".htmlspecialchars($this->pdf_field_name,ENT_QUOTES)."', '".htmlspecialchars($this->field_name,ENT_QUOTES)."','".htmlspecialchars($this->field_caption,ENT_QUOTES)."','".htmlspecialchars($this->field_note,ENT_QUOTES)."','".$this->is_required."','" . $this->field_ishide . "',0, $order, '".$this->created_by."', '".currentScriptDate()."', '".$this->updated_by."' ,'".currentScriptDate()."')";
		
		mysql_query($strQuery_Field) or die(mysql_error());
		$this->field_id = mysql_insert_id();
		
		$this->Insert_Field_Language(ENGLISH_LANGUAGE_ID);
		
		return $this->field_id;		
	}
	
	function Insert_Field_Language($language_id="-1")
	{			
		if($language_id != "-1")
			$this->language_id = $language_id;
		
		$strQuery_Field = "insert into  ".DB_PREFIX."field_language_text (field_id, language_id, field_caption, field_note ,created_by, created_date, updated_by, updated_date) values (".$this->field_id.", '".$this->language_id."','".htmlspecialchars($this->field_caption,ENT_QUOTES)."','".htmlspecialchars($this->field_note,ENT_QUOTES)."',".$this->created_by.", '".currentScriptDate()."', ".$this->updated_by.",'".currentScriptDate()."')";
		mysql_query($strQuery_Field) or die(mysql_error());
		$this->field_language_text_id = mysql_insert_id();
		return mysql_insert_id();		
		//echo $strQuery_Field;
		//exit;
	}
	
	
	function Update_Field($insert_form="1")
	{	
		$strQuery_Field = "update ".DB_PREFIX."field SET field_header_field = '".$this->field_header_field."', reg_type = '".$this->reg_type."', pdf_field_name='".htmlspecialchars($this->pdf_field_name,ENT_QUOTES)."', field_name='".htmlspecialchars($this->field_name,ENT_QUOTES)."', field_caption = '".htmlspecialchars($this->field_caption,ENT_QUOTES)."', field_note = '".htmlspecialchars($this->field_note,ENT_QUOTES)."', is_required = '".$this->is_required."', field_ishide='" . $this->field_ishide . "', field_iscondition = '0', updated_by='".$this->updated_by."', updated_date='".currentScriptDate()."' where field_id='".$this->field_id."'";
		mysql_query($strQuery_Field) or die(mysql_error());
		$this->Update_Field_Language(ENGLISH_LANGUAGE_ID);
		
		return $this->field_id;		
	}
	
	function Update_Field_Language($language_id="-1")
	{			
		if($language_id != "-1")
			$this->language_id = $language_id;
		
		$strQuery_Field = "update ".DB_PREFIX."field_language_text set field_caption = '".htmlspecialchars($this->field_caption,ENT_QUOTES)."', field_note = '".htmlspecialchars($this->field_note,ENT_QUOTES)."', updated_by='".$this->updated_by."', updated_date='".currentScriptDate()."' where field_id='".$this->field_id."' and language_id='".$this->language_id."'";
		
		mysql_query($strQuery_Field) or die(mysql_error());
		return;				
	}
	
	function getLast_Order($client_id)
	{
		$strQuery_For_Update = "SELECT ((IFNULL( max( field_order ) , 0 )) +1) AS next_order FROM ".DB_PREFIX."field fi, ".DB_PREFIX."form fo WHERE fo.form_id = fi.form_id AND fo.client_id = ".$client_id;
		$rsOrder = mysql_query($strQuery_For_Update) or die(mysql_error());
		$arrOrder = mysql_fetch_array($rsOrder);
		return $arrOrder["next_order"];
	}
	
	function fetchAll_Field($client_id="0",$condition="")
	{
		$strQuery = "SELECT fi.* FROM ".DB_PREFIX."field fi, ".DB_PREFIX."form fo WHERE field_isactive = 1 and fo.form_id = fi.form_id AND fo.client_id = ".$client_id." ".$condition."  order by field_order";
		//echo $strQuery;
		$rsOrder = mysql_query($strQuery) or die(mysql_error());
		$i=0;
		$arList = array();
		while($arfield = mysql_fetch_array($rsOrder))
		{
			$arList[$i]["field_id"] = $arfield["field_id"];
			$arList[$i]["client_id"] = $arfield["client_id"];
			$arList[$i]["form_id"] = $arfield["form_id"];
			$arList[$i]["field_mapping_id"] = $arfield["field_mapping_id"];
			$arList[$i]["field_type_id"] = $arfield["field_type_id"];
			$arList[$i]["field_header_field"] = $arfield["field_header_field"];
			$arList[$i]["reg_type"] = $arfield["reg_type"];
			$arList[$i]["pdf_field_name"] = $arfield["pdf_field_name"];
			$arList[$i]["field_name"] = $arfield["field_name"];
			$arList[$i]["field_caption"] = $arfield["field_caption"];
			$arList[$i]["field_note"] = $arfield["field_note"];
			$arList[$i]["is_required"] = $arfield["is_required"];
			$arList[$i]["field_ishide"] = $arfield["field_ishide"];
			$arList[$i]["field_iscondition"] = $arfield["field_iscondition"];
			$arList[$i]["field_order"] = $arfield["field_order"];
			$arList[$i]["field_isactive"] = $arfield["field_isactive"];

			$i++;
		}
		return $arList;
	}
	
	function fetchAllFieldFront($client_id,$condition="")
	{
		$strQuery = "SELECT fi.*, if(flt.field_caption='',fi.field_caption,flt.field_caption) as langfield_caption, if(flt.field_note='',fi.field_note,flt.field_note) as langfield_note FROM ".DB_PREFIX."form fo,".DB_PREFIX."field fi LEFT JOIN ".DB_PREFIX."field_language_text flt ON ( flt.field_id=fi.field_id AND language_id='".$this->language_id."' ".$condition.") WHERE field_isactive = 1 and fo.form_id = fi.form_id AND (fi.client_id = ".$client_id." or fi.client_id='0') ".$condition." order by client_id, field_order";
		//echo $strQuery;
		$rsOrder = mysql_query($strQuery) or die(mysql_error());
		$i=0;
		$arList = array();
		while($arfield = mysql_fetch_array($rsOrder))
		{
			$arList[$i]["field_id"] = $arfield["field_id"];
			$arList[$i]["client_id"] = $arfield["client_id"];
			$arList[$i]["form_id"] = $arfield["form_id"];
			$arList[$i]["field_mapping_id"] = $arfield["field_mapping_id"];
			$arList[$i]["field_type_id"] = $arfield["field_type_id"];
			$arList[$i]["field_header_field"] = $arfield["field_header_field"];
			$arList[$i]["reg_type"] = $arfield["reg_type"];
			$arList[$i]["pdf_field_name"] = $arfield["pdf_field_name"];
			$arList[$i]["field_name"] = $arfield["field_name"];
			$arList[$i]["field_caption"] = $arfield["langfield_caption"];
			//$arList[$i]["field_note"] = $arfield["field_note"];
			$arList[$i]["field_note"] = $arfield["langfield_note"];
			$arList[$i]["is_required"] = $arfield["is_required"];
			$arList[$i]["field_ishide"] = $arfield["field_ishide"];
			$arList[$i]["field_iscondition"] = $arfield["field_iscondition"];
			$arList[$i]["field_order"] = $arfield["field_order"];
			$arList[$i]["field_isactive"] = $arfield["field_isactive"];
			
			$i++;
		}
		
		return $arList;
	}
	
	function fetchAllFieldReport($client_id,$condition="")
	{
		$strQuery = "SELECT fi.*, if(flt.field_caption='',fi.field_caption,flt.field_caption) as langfield_caption, if(flt.field_note='',fi.field_note,flt.field_note) as langfield_note FROM ".REPORT_DB_PREFIX."rpt_field fi LEFT JOIN ".DB_PREFIX."field_language_text flt ON ( flt.field_id=fi.rpt_field_id AND language_id='".$this->language_id."' ".$condition.") WHERE field_isactive = 1 and (fi.client_id = ".$client_id." or fi.client_id='0') ".$condition." order by client_id, field_order";
		//echo $strQuery;
		$rsOrder = mysql_query($strQuery) or die(mysql_error());
		$i=0;
		$arList = array();
		while($arfield = mysql_fetch_array($rsOrder))
		{
			$arList[$i]["rpt_field_id"] = $arfield["rpt_field_id"];
			$arList[$i]["client_id"] = $arfield["client_id"];
			$arList[$i]["field_mapping_id"] = $arfield["field_mapping_id"];
			$arList[$i]["field_type_id"] = $arfield["field_type_id"];
			$arList[$i]["field_header_field"] = $arfield["field_header_field"];
			$arList[$i]["reg_type"] = $arfield["reg_type"];
			$arList[$i]["pdf_field_name"] = $arfield["pdf_field_name"];
			$arList[$i]["field_name"] = $arfield["field_name"];
			$arList[$i]["field_caption"] = $arfield["langfield_caption"];
			$arList[$i]["field_note"] = $arfield["field_note"];
			$arList[$i]["is_required"] = $arfield["is_required"];
			$arList[$i]["field_ishide"] = $arfield["field_ishide"];
			$arList[$i]["field_iscondition"] = $arfield["field_iscondition"];
			$arList[$i]["field_order"] = $arfield["field_order"];
			$arList[$i]["field_isactive"] = $arfield["field_isactive"];
			
			$i++;
		}
		
		return $arList;
	}
	
	//Function to get particular field value
	function fieldValueFront($field = "field_id",$id = "",$condition = "",$order = "")
	{
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
			$condition  =  " and fi.field_id = ". $id .$condition;
		}
	
		$sQuery = "SELECT  if(flt.field_caption='',fi.field_caption,flt.field_caption) as field_caption, if(flt.field_note='',fi.field_note,flt.field_note) as field_note FROM ".DB_PREFIX."form fo,".DB_PREFIX."field fi LEFT JOIN ".DB_PREFIX."field_language_text flt ON ( flt.field_id=fi.field_id AND language_id='".$this->language_id."' ".$condition.") WHERE field_isactive = 1 and fo.form_id = fi.form_id AND (fo.client_id = ".$this->client_id." or fo.client_id = 0) ".$condition." order by field_order";
		//$sQuery = "SELECT * FROM ".DB_PREFIX."field WHERE 1 = 1 " . $condition . $order;
				
		$rs  =  $this->runquery($sQuery);
		
		$ret = 0;
		while($rw = mysql_fetch_assoc($rs))
		{
			$ret = $rw[$field];
		}
		return $ret;
	}
	
	function deleteField()
	{		
		$strremove_conditon = "update ".DB_PREFIX."field_condition set show_field_ids = replace(show_field_ids, ',".$this->field_id."', ''), hide_field_ids = replace(hide_field_ids, ',".$this->field_id."', '')";
		mysql_query($strremove_conditon) or die(mysql_error());
		
		/*$strdelete_condition = "delete from ".DB_PREFIX."field_condition where field_id=".$this->field_id;
		mysql_query($strdelete_condition) or die(mysql_error());
			
		$strdelete_field_option_language_text = "delete from ".DB_PREFIX."field_option_language_text where field_option_id in ( select field_option_id from ".DB_PREFIX."field_option where field_id = ".$this->field_id.")";
		mysql_query($strdelete_field_option_language_text) or die(mysql_error());
		
		
		$strdelete_field_option = "delete from ".DB_PREFIX."field_option where field_id = ".$this->field_id;
		mysql_query($strdelete_field_option) or die(mysql_error());
		
		$strdelete_field_attribute = "delete from ".DB_PREFIX."field_attribute where field_id = ".$this->field_id;
		mysql_query($strdelete_field_attribute) or die(mysql_error());
		
		$strdelete_field_language_text = "delete from ".DB_PREFIX."field_language_text where field_id = ".$this->field_id;
		mysql_query($strdelete_field_language_text) or die(mysql_error());
		
		$strdelete_field = "delete from ".DB_PREFIX."field where field_id = ".$this->field_id;
		mysql_query($strdelete_field) or die(mysql_error());*/
		
		$strdelete_field = "update ".DB_PREFIX."field set field_isactive = '0' where field_id = ".$this->field_id;
		mysql_query($strdelete_field) or die(mysql_error());
	}
	
	function getField_Dtl_For_Edit()
	{
		$strQuery = "SELECT field_type_id, field_mapping_id, pdf_field_name, field_name, field_header_field, reg_type, field_caption `label_name` , field_order `order`, is_required, field_ishide, field_iscondition FROM ".DB_PREFIX."field WHERE field_id = ".$this->field_id;
		//echo $strQuery;
		
		$rs = mysql_query($strQuery);
		
		$i=0;
		$arList = array();
		while($arfield = mysql_fetch_array($rs))
		{
			$arList[$i]["field_type_id"] = $arfield["field_type_id"];
			$arList[$i]["field_mapping_id"] = $arfield["field_mapping_id"];
			$arList[$i]["field_header_field"] = $arfield["field_header_field"];
			$arList[$i]["reg_type"] = $arfield["reg_type"];
			$arList[$i]["pdf_field_name"] = $arfield["pdf_field_name"];
			$arList[$i]["field_name"] = $arfield["field_name"];
			$arList[$i]["label_name"] = $arfield["label_name"];	
			$arList[$i]["order"] = $arfield["order"];	
			$arList[$i]["is_required"] = $arfield["is_required"];
			$arList[$i]["field_ishide"] = $arfield["field_ishide"];
			$arList[$i]["field_iscondition"] = $arfield["field_iscondition"];
			
			$i++;
		}
		return $arList;
	}
	
	function getField_Language_Text_For_Edit()
	{
		$strQuery = "SELECT * FROM ".DB_PREFIX."field_language_text WHERE field_id = ".$this->field_id." and language_id = ".$this->language_id;
		//echo $strQuery;

		
		$rs = mysql_query($strQuery);
		
		$i=0;
		$arList = array();
		while($arfield = mysql_fetch_array($rs))
		{
			$arList[$i]["field_language_text_id"] = $arfield["field_language_text_id"];
			$arList[$i]["field_id"] = $arfield["field_id"];
			$arList[$i]["language_id"] = $arfield["language_id"];	
			$arList[$i]["field_caption"] = $arfield["field_caption"];	
			$arList[$i]["field_note"] = $arfield["field_note"];	
			$i++;
		}
		return $arList;
	}
	
	function deleteFieldFileType()
	{
		$strdelete_condition = "delete from ".DB_PREFIX."field_file_type where field_id = '".$this->field_id."' and file_type_id = '".$this->file_type_id."' ";
		mysql_query($strdelete_condition) or die(mysql_error());
	}
	
	function deleteFieldsFromFileType()
	{
		$strdelete_condition = "delete from ".DB_PREFIX."field_file_type where field_id = '".$this->field_id."'";
		mysql_query($strdelete_condition) or die(mysql_error());
	}
	
	
	function updateFieldOrder()
	{		
		$query_change_order = "update ".DB_PREFIX."field set field_order = '".$this->field_order."' where field_id = '".$this->field_id."'";
		mysql_query($query_change_order) or die(mysql_error());
	}	
}
?>