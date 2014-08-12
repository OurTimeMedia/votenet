<?php
class userform extends common
{
	//Property
	var $client_id;
	var $client_plan_id;
	var $domain;
	var $user_id;
	var $currency_id;
	var $collect_entry_fees;
	var $fees_value;
	var $payment_method;
	var $paypal_busines_account;
	var $offline_payment_message;
	var $template_id;
	var $background_type;
	var $background_image;
	var $background_color;
	var $header_banner_image;
	var $navigation_bg_color;
	var $navigation_selected_color;
	var $navigation_fore_color;
	var $navigation_selected_fore_color;
	var $css_file;
	var $net_amount;
	var $payment_status;
	var $payment_iscancel;
	var $issponsors_in_email;
	var $istitle_on_header;
	var $defaultlanguage_id;
	var $completed_step;
	var $ismonitory_awards;
	var $total_visits;
	var $pagingType;
	var $isView;
	var $publish_winner;
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;
	var $checkedids;
	var $uncheckedids;
	
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="user_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and user_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", user_id desc";
		}
		$strquery="SELECT * FROM ".DB_PREFIX."user WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to get particular field value
	function fieldValue($field="user_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchRecordSet($id, $condition, $order);
		$ret=0;
		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$field];
		}
		return $ret;
	}
	
	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($rs!="")
		{
			if($artf_contest= mysql_fetch_array($rs))
			{
				$this->user_id = $artf_contest["user_id"];
				$this->client_id = $artf_contest["client_id"];
				$this->user_type_id = $artf_contest["user_type_id"];
				$this->user_username = $artf_contest["user_username"];
				$this->user_password = $artf_contest["user_password"];
				$this->user_firstname = $artf_contest["user_firstname"];
				$this->user_lastname = $artf_contest["user_lastname"];
				$this->user_email = $artf_contest["user_email"];
				$this->user_company = $artf_contest["user_company"];
				$this->user_designation = $artf_contest["user_designation"];
				$this->user_phone = $artf_contest["user_phone"];
				$this->user_address1 = $artf_contest["user_address1"];
				$this->user_address2 = $artf_contest["user_address2"];
				$this->user_city = $artf_contest["user_city"];
				$this->user_state = $artf_contest["user_state"];
				$this->user_country = $artf_contest["user_country"];
				$this->user_zipcode = $artf_contest["user_zipcode"];
				$this->user_lastlogin = $artf_contest["user_lastlogin"];
				$this->user_isactive = $artf_contest["user_isactive"];
				$this->user_verification = $artf_contest["user_verification"];
				$this->domain = $artf_contest["domain"];
				$this->template_id = $artf_contest["template_id"];
				$this->totalvisitor = $artf_contest["totalvisitor"];
				$this->created_date = $artf_contest["created_date"];
				$this->created_by = $artf_contest["created_by"];
				$this->updated_date = $artf_contest["updated_date"];
				$this->updated_by = $artf_contest["updated_by"];
				
			}
		}
	}
	
	function addVoterVisits()
	{	
		$strQuery="INSERT INTO ".DB_PREFIX."voters_visit (voter_ip,visit_date) VALUES ('".
$_SERVER['REMOTE_ADDR']."','".currentScriptDateOnly()."') ";
		mysql_query($strQuery) or die(mysql_error());
	}
	
	function updateVoterVisits()
	{
		$strQuery="UPDATE ".DB_PREFIX."user SET totalvisitor = '".$this->total_visits."' WHERE user_id='".$this->user_id."'";
		mysql_query($strQuery) or die(mysql_error());
	}
	
	function fetchlanguagedetail($user_id)
	{
		 $strquery="SELECT ".DB_PREFIX."field_language_text.language_id,language_name FROM ".DB_PREFIX."field 
		left join ".DB_PREFIX."field_language_text  on ".DB_PREFIX."field_language_text.field_id= ".DB_PREFIX."field.field_id
		left join ".DB_PREFIX."language on ".DB_PREFIX."language.language_id= ".DB_PREFIX."field_language_text.language_id
		WHERE client_id=".$user_id;
		$rs=mysql_query($strquery);
		$i=0;
		while($result=mysql_fetch_assoc($rs))
		{
			$resultdata[$i]['language_name']=$result['language_name'];
			$resultdata[$i]['language_id']=$result['language_id'];
			$i++;
		}	
	
		return $resultdata;
	}
	
	function fetchAllFieldFront($client_id,$condition="")
	{
		$strQuery = "SELECT fi.*, if(flt.field_caption='',fi.field_caption,flt.field_caption) as langfield_caption FROM ".DB_PREFIX."form fo,".DB_PREFIX."field fi 
		LEFT JOIN ".DB_PREFIX."field_language_text flt 
	ON ( flt.field_id=fi.field_id ) WHERE language_id='".$this->language_id."' ".$condition." 
		and field_isactive = 1 and fo.form_id = fi.form_id AND (fo.client_id = ".$client_id." or fo.client_id=0) ".$condition." group by flt.field_caption order by field_order"; 
	//	echo $strQuery;exit;
		$rsOrder = mysql_query($strQuery) or die(mysql_error());
		$i=0;
		$arList = array();
		while($arfield = mysql_fetch_array($rsOrder))
		{
			$arList[$i]["field_id"] = $arfield["field_id"];
			$arList[$i]["form_id"] = $arfield["form_id"];
			$arList[$i]["field_type_id"] = $arfield["field_type_id"];
			$arList[$i]["field_name"] = $arfield["field_name"];	
			$arList[$i]["field_caption"] = utf8_decode($arfield["langfield_caption"]);	
			$arList[$i]["is_required"] = $arfield["is_required"];
			$arList[$i]["field_ishide"] = $arfield["field_ishide"];
			$arList[$i]["field_iscondition"] = $arfield["field_iscondition"];
			$arList[$i]["field_order"] = $arfield["field_order"];
			$arList[$i]["field_mapping_id"] = $arfield["field_mapping_id"];
			$i++;
		}
		return $arList;
	}
	
	function getField_Type_Attributes($field_type_id)
	{		
		$i = 0;				
		$strquery="SELECT * FROM ".DB_PREFIX."field_type_attribute WHERE field_type_id = ".$field_type_id." and 	field_type_attribute_isactive = 1 ORDER BY field_type_attribute_order";		
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
}
?>
		

	