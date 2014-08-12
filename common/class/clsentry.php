<?php
class entry extends common
{
	//Property
	var $entry_id;
	var $voter_id;
	var $client_id;
	var $entry_date;
	var $language_id;
	var $entry_status;

	var $entry_detail_id;
	var $field_id;
	var $field_caption;
	var $field_value;
	
	var $entry_option_id;
	var $field_option_id;
	var $field_option_value;
	var $pagingType ;
	
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;
	var $checkedids;
	var $uncheckedids;
	
	
	function entry()
	{
		$this->entry_id = 0;
		$this->voter_id = 0;
		
		$this->language_id = 0;
		$this->entry_status = 0;
		
		$this->entry_detail_id = 0;
		$this->field_id = 0;
		$this->field_caption = "";
		$this->field_value = "";
		
		$this->entry_option_id = 0;
		$this->field_option_id = 0;
		$this->field_option_value = "";	
	}
	
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="entry_date")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and entry_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", entry_date desc";
		}
				
		$strQuery="SELECT * FROM ".DB_PREFIX."entry WHERE 1=1 AND ".DB_PREFIX."entry.entry_status=1 " . $condition . $order;
		$rs=mysql_query($strQuery);
		return $rs;
	}
		
	
	
	
	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$order = '';
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and entry_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", entry_id desc";
		}
	
		$strquery="SELECT ".DB_PREFIX."entry.* FROM ".DB_PREFIX."entry WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		
		if($artf_entry= mysql_fetch_array($rs))
		{
			$this->entry_id = $artf_entry["entry_id"];
			$this->voter_id = $artf_entry["voter_id"];
			$this->entry_date = $artf_entry["entry_date"];
			$this->language_id = $artf_entry["language_id"];
			$this->entry_status = $artf_entry["entry_status"];
			$this->created_by = $artf_entry["created_by"];
			$this->created_date = $artf_entry["created_date"];
			$this->updated_by = $artf_entry["updated_by"];
			$this->updated_date = $artf_entry["updated_date"];
		}
	}
		
	function deleteEntry()
	{
		$strquery="UPDATE ".DB_PREFIX."entry SET entry_iscancel=1 WHERE entry_id='".$this->entry_id."'";
		mysql_query($strquery) or die(mysql_error());
	}
	
	function approveEntry()
	{
		$strquery="UPDATE ".DB_PREFIX."entry SET entry_status=1, status_date='".currentScriptDate()."' WHERE entry_id='".$this->entry_id."'";
		mysql_query($strquery) or die(mysql_error());
	}
	
	function rejectEntry()
	{
		$strquery="UPDATE ".DB_PREFIX."entry SET entry_status=2, status_date='".currentScriptDate()."' WHERE entry_id='".$this->entry_id."'";
		mysql_query($strquery) or die(mysql_error());
	}
	
	//Function to get particular field value
	function fieldValue($field = "field_option_id",$id = "",$condition = "",$order = "")
	{
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
			$condition  =  " and ".DB_PREFIX."field_option.field_option_id = ". $id .$condition;
		}
	
		$sQuery = "SELECT * FROM ".DB_PREFIX."field_option WHERE 1 = 1 " . $condition . $order;
		$rs  =  $this->runquery($sQuery);
		
		$ret = 0;
		while($rw = mysql_fetch_assoc($rs))
		{
			$ret = $rw[$field];
		}
		return $ret;
	}
	
	
	//Function to get particular field value
	function fieldSingleValue($field = "entry_id",$id = "",$condition = "",$order = "")
	{
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
			$condition  =  " and ".DB_PREFIX."entry.entry_id = ". $id .$condition;
		}
	
		$sQuery = "SELECT * FROM ".DB_PREFIX."entry WHERE 1 = 1 " . $condition . $order;
		$rs  =  $this->runquery($sQuery);
		
		$ret = 0;
		while($rw = mysql_fetch_assoc($rs))
		{
			$ret = $rw[$field];
		}
		return $ret;
	}
	
	//Function to get particular field value
	function fieldValueFront($field = "field_option_id",$id = "",$condition = "",$order = "")
	{
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
			$condition  =  " and fo.field_option_id = ". $id .$condition;
		}
	
		$sQuery="SELECT if(flo.field_option='',fo.field_option,flo.field_option) as field_option FROM ".DB_PREFIX."field_option fo LEFT JOIN ".DB_PREFIX."field_option_language_text flo ON ( flo.field_option_id=fo.field_option_id AND language_id='".$this->language_id."') WHERE 1=1 " . $condition;
		$rs  =  $this->runquery($sQuery);
		
		$ret = 0;
		while($rw = mysql_fetch_assoc($rs))
		{
			$ret = $rw[$field];
		}
		return $ret;
	}
		
	function fetchEntryDetail()
	{
		$strQuery = "SELECT field_value,entry_detail_id,field_caption FROM ".DB_PREFIX."entry_detail WHERE 1=1 AND field_id='".$this->field_id."' AND entry_id='".$this->entry_id."'";
		
		$rs=mysql_query($strQuery);
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			$this->entry_detail_id = $res['entry_detail_id'];
			$this->field_caption = $res['field_caption'];
			return $res['field_value'];
		}
		else
		{
			return "!!Not Found!!";
		}
	}
	
	//Function to set field values into object properties
	function fetchEntryDetailVal($id="",$condition="")
	{
		$order = '';
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and entry_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", entry_id desc";
		}
	
		$strquery="SELECT ".DB_PREFIX."entry_detail.* FROM ".DB_PREFIX."entry_detail WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		
		$entryDetailArr = array();
		while($artf_entry= mysql_fetch_array($rs))
		{			
			$entryDetailArr["field_".$artf_entry['field_id']] = $artf_entry['field_value'];
		}
		
		return $entryDetailArr;
	}
		
		
	function fetchEntryDetailValues()
	{
		$strQuery = "SELECT field_value,entry_detail_id,field_caption FROM ".DB_PREFIX."entry_detail WHERE 1=1 AND field_id='".$this->field_id."' AND entry_id='".$this->entry_id."'";
		
		$rs=mysql_query($strQuery);
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			$this->entry_detail_id = $res['entry_detail_id'];
			$this->field_caption = $res['field_caption'];
			return $res['field_value'];
		}
		else
		{
			$this->entry_detail_id = "";
			$this->field_caption = "";
			return "";
		}
	}
	
	function deleteEntryOptions()
	{
		$strQuery = "DELETE FROM ".DB_PREFIX."entry_options WHERE 1=1 AND field_id='".$this->field_id."' AND entry_detail_id='".$this->entry_detail_id."' ";
		
		$rs=mysql_query($strQuery);
	}
	
	function deleteEntryDetail()
	{
		$strQuery = "DELETE FROM ".DB_PREFIX."entry_detail WHERE 1=1 AND entry_detail_id='".$this->entry_detail_id."' ";
		
		$rs=mysql_query($strQuery);
	}
	
	function fetchEntryDetailOptions()
	{
		$strQuery = "SELECT * FROM ".DB_PREFIX."entry_options WHERE 1=1 AND field_id='".$this->field_id."' AND entry_detail_id='".$this->entry_detail_id."' AND field_option_id='".$this->field_option_id."'";
		
		$rs=mysql_query($strQuery);
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			$this->field_option_value = utf8_decode($res['field_option_value']);
			return mysql_num_rows($rs);
		}
		else
		{
			return "!!Not Found!!";
		}
	}
	
	function fetchEntryDetailOptionsExist()
	{
		$strQuery = "SELECT * FROM ".DB_PREFIX."entry_options WHERE 1=1 AND field_id='".$this->field_id."' AND entry_detail_id='".$this->entry_detail_id."' AND field_option_id='".$this->field_option_id."'";
		
		$rs=mysql_query($strQuery);
		
		if(mysql_num_rows($rs)>0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	function findTotEntires($condition='')
	{
		$strQuery = "SELECT count(e.entry_id) as entries FROM ".DB_PREFIX."contest ct,".DB_PREFIX."entry e WHERE 1=1 AND e.entry_iscancel=0 AND e.entry_status=1 ".$condition."";
		$rs=mysql_query($strQuery);
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			return $res['entries'];
		}
		else
		{
			return 0;
		}
	}
	
	//Function to add record into table
	function insertEntryForm() 
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."entry 
					
					(voter_id, entry_date, language_id, entry_status, created_date, created_by, 
					updated_date, updated_by) 
					
					values(
							'".$this->voter_id."','".currentScriptDate()."', 
							'".$this->language_id."',
							'".$this->entry_status."',
							'".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
	
		$this->runquery($sQuery);
		return mysql_insert_id();
	}
	
	function insertEntryDetail()
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."entry_detail 
					
					(entry_id, field_id, field_caption, field_value, 
					created_date, created_by, updated_date, updated_by) 
					values(
							'".$this->entry_id."', '".$this->field_id."', 
							'".$this->field_caption."', '".$this->field_value."',
							'".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
	
		$this->runquery($sQuery);
		return mysql_insert_id();
	}
	
	function updateEntryDetail()
	{
		$sQuery  =  "UPDATE ".DB_PREFIX."entry_detail 
					SET field_caption = '".$this->field_caption."', 
						field_value = '".$this->field_value."',
						updated_date = '".currentScriptDate()."',
						updated_by = '".$this->updated_by."'
					WHERE
						entry_id = '".$this->entry_id."' AND
						field_id = '".$this->field_id."'";
					
		$this->runquery($sQuery);
		$this->voter_id  =  mysql_insert_id();
		return mysql_insert_id();
	}
	
	
	function findEntryDetailExist()
	{
		$sQuery  =  "SELECT entry_detail_id FROM ".DB_PREFIX."entry_detail 
					WHERE
						entry_id = '".$this->entry_id."' AND
						field_id = '".$this->field_id."'";
					
		$rst = mysql_query($sQuery);
		return mysql_num_rows($rst);
	}
	
	function insertEntryOptions()
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."entry_options 
					
					(entry_detail_id, field_id, field_option_id, field_option_value, 
					created_date, created_by, updated_date, updated_by) 
					values(
							'".$this->entry_detail_id."', '".$this->field_id."', 
							'".$this->field_option_id."', '".$this->field_option_value."',
							'".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
	
		$this->runquery($sQuery);
		$this->voter_id  =  mysql_insert_id();
		return mysql_insert_id();
	}
	
	function findEntry()
	{}
			
	function entrySubmissionMail($emailID, $email_to, $email_from, $serverroot, $registration_link, $client_id)
	{
		$aMailDetail = $this->fetchMailDetail($emailID);
		
		require_once (COMMON_CLASS_DIR ."clsuser.php");

		$objUser = new user();
		$cond = " AND client_id='".$client_id."' AND user_type_id = '3' ";
		$objUser->setAllValues("", $cond);

		if(empty($aMailDetail))
		{
			$aMailDetail = $this->fetchMailDetail($emailID);
		}
	
		$emailMessage = $aMailDetail['email_body'];
		$emailMessage = str_replace('{SERVER_ADMIN_HOST}',$serverroot,$emailMessage);
		$emailMessage = str_replace('{download_registration_link}',$registration_link,$emailMessage);
		$emailMessage = str_replace('{client_name}',$objUser->user_company,$emailMessage);
		
		$emailSubject = $aMailDetail['email_subject'];
		$emailSubject = str_replace('{client_name}',$objUser->user_company,$emailSubject);
				
		$this->phpMailer($email_to, $emailSubject, $emailMessage , '',  $email_from,'',$aMailDetail['email_cc'],'',$aMailDetail['email_bcc'],'',false);	
	}
}
?>