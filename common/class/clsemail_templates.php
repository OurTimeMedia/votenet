<?php
class email_templates
{
	//Property
	var $email_templates_id;
	var $client_id;
	var $email_templates_name;
	var $email_templates_extension;
	var $email_templates_description;
	var $email_from;
	var $email_to;
	var $email_cc;
	var $email_bcc;
	var $email_reply_to;
	var $email_subject;
	var $email_body;
	var $email_type;
	var $email_isactive;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	function email_templates()
	{
		$this->client_id = 0;
		$this->email_isactive = 1;
	}
	
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="email_templates_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and email_templates_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", email_templates_id desc";
		}
		$strquery="SELECT * FROM ".DB_PREFIX."email_templates WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	//Function to retrieve recordset of table
	function fetchRecordSetNew($id="",$condition="",$order="email_templates_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and email_templates_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", email_templates_id desc";
		}
		$strquery="SELECT * FROM `ei_email_templates` WHERE client_id='0' AND email_isactive='1' ".$condition[1]."  UNION SELECT * FROM `ei_email_templates` WHERE 1=1 " . $condition[0]. $order;

		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="email_templates_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND email_templates_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND email_templates_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."email_templates WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_email_templates= mysql_fetch_array($rs))
		{
			$arrlist[$i]["email_templates_id"] = $artf_email_templates["email_templates_id"];
			$arrlist[$i]["client_id"] = $artf_email_templates["client_id"];
			$arrlist[$i]["email_templates_name"] = $artf_email_templates["email_templates_name"];
			$arrlist[$i]["email_templates_description"] = $artf_email_templates["email_templates_description"];
			$arrlist[$i]["email_from"] = $artf_email_templates["email_from"];
			$arrlist[$i]["email_to"] = $artf_email_templates["email_to"];
			$arrlist[$i]["email_cc"] = $artf_email_templates["email_cc"];
			$arrlist[$i]["email_bcc"] = $artf_email_templates["email_bcc"];
			$arrlist[$i]["email_reply_to"] = $artf_email_templates["email_reply_to"];
			$arrlist[$i]["email_subject"] = $artf_email_templates["email_subject"];
			$arrlist[$i]["email_body"] = $artf_email_templates["email_body"];
			$arrlist[$i]["email_type"] = $artf_email_templates["email_type"];
			$arrlist[$i]["email_isactive"] = $artf_email_templates["email_isactive"];
			$arrlist[$i]["created_by"] = $artf_email_templates["created_by"];
			$arrlist[$i]["created_date"] = $artf_email_templates["created_date"];
			$arrlist[$i]["updated_by"] = $artf_email_templates["updated_by"];
			$arrlist[$i]["updated_date"] = $artf_email_templates["updated_date"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artf_email_templates= mysql_fetch_array($rs))
		{
			$this->email_templates_id = $artf_email_templates["email_templates_id"];
			$this->client_id = $artf_email_templates["client_id"];
			$this->email_templates_name = $artf_email_templates["email_templates_name"];
			$this->email_templates_description = $artf_email_templates["email_templates_description"];
			$this->email_from = $artf_email_templates["email_from"];
			$this->email_to = $artf_email_templates["email_to"];
			$this->email_cc = $artf_email_templates["email_cc"];
			$this->email_bcc = $artf_email_templates["email_bcc"];
			$this->email_reply_to = $artf_email_templates["email_reply_to"];
			$this->email_subject = $artf_email_templates["email_subject"];
			$this->email_body = $artf_email_templates["email_body"];
			$this->email_type = $artf_email_templates["email_type"];
			$this->email_isactive = $artf_email_templates["email_isactive"];
			$this->created_by = $artf_email_templates["created_by"];
			$this->created_date = $artf_email_templates["created_date"];
			$this->updated_by = $artf_email_templates["updated_by"];
			$this->updated_date = $artf_email_templates["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldValue($field="email_templates_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchRecordSet($id, $condition, $order);
		$ret=0;
		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$field];
		}
		return $ret;
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."email_templates SET 
					email_templates_name='".$this->email_templates_name."', 
					client_id='".$this->client_id."', 
					email_templates_name='".$this->email_templates_name."', 
					email_templates_description='".$this->email_templates_description."', 
					email_from='".$this->email_from."', 
					email_to='".$this->email_to."', 
					email_cc='".$this->email_cc."', 
					email_bcc='".$this->email_bcc."', 
					email_reply_to='".$this->email_reply_to."', 
					email_subject='".$this->email_subject."', 
					email_body='".$this->email_body."', 
					email_type='".$this->email_type."',
					email_isactive='".$this->email_isactive."', 
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE email_templates_id=".$this->email_templates_id;
		
		return mysql_query($strquery) or die(mysql_error());
	}
	
	function updateTemplateDetail() 
	{
		$strquery="UPDATE ".DB_PREFIX."email_templates SET 
					email_templates_name='".$this->email_templates_name."', 
					email_subject='".$this->email_subject."', 
					client_id='".$this->client_id."', 
					email_body='".$this->email_body."', 
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE email_templates_id=".$this->email_templates_id;
		
		return mysql_query($strquery) or die(mysql_error());
	}
	
	function addTemplateDetail()
	{
		$strquery="INSERT INTO ".DB_PREFIX."email_templates 
					(email_templates_name, client_id,
					email_templates_description,email_from,
					email_to, email_cc, email_bcc,
					email_reply_to, email_subject,
					email_body, email_type, created_by, 
					created_date, updated_by, updated_date) 
					
					values('".$this->email_templates_name."',
						  '".$this->client_id."','".$this->email_templates_description."',
						  '".$this->email_from."','".$this->email_to."','".$this->email_cc."',
						  '".$this->email_bcc."', '".$this->email_reply_to."', '".$this->email_subject."',
						  '".$this->email_body."', '".$this->email_type."',
						  '".$this->created_by."',
						  '".currentScriptDate()."','".$this->updated_by."',
						  '".currentScriptDate()."')";
		mysql_query($strquery) or die(mysql_error());
		$this->email_templates_id = mysql_insert_id();
		return mysql_insert_id();
	}
}
?>