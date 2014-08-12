<?php
class system_maintenance
{
	//Property
	var $site_config_id;
	var $site_config_isonline;
	var $site_config_offline_message;
	var $site_config_image;
	var $pagingType;
	
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="site_config_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and site_config_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."site_config WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="site_config_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND site_config_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND site_config_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."site_config WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_security= mysql_fetch_array($rs))
		{
			$arrlist[$i]["site_config_id"] = $artf_security["site_config_id"];
			$arrlist[$i]["site_config_isonline"] = $artf_security["site_config_isonline"];
			$arrlist[$i]["site_config_offline_message"] = $artf_security["site_config_offline_message"];
			$arrlist[$i]["site_config_image"] = $artf_security["site_config_image"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artf_security= mysql_fetch_array($rs))
		{
			$this->site_config_id = $artf_security["site_config_id"];
			$this->site_config_isonline = $artf_security["site_config_isonline"];
			$this->site_config_offline_message = $artf_security["site_config_offline_message"];
			$this->site_config_image = $artf_security["site_config_image"];
		}
	}

	//Function to get particular field value
	function fieldValue($field="site_config_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchRecordSet($id, $condition, $order);
		$ret=0;
		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$field];
		}
		return $ret;
	}
	
	function systemMaintananceEdit()
	{
		$strQuery="UPDATE ".DB_PREFIX."site_config SET 
					site_config_isonline = '".$this->site_config_isonline."',
					site_config_offline_message  = '".$this->site_config_offline_message."',
					site_config_image = '".$this->site_config_image."'
				  WHERE site_config_id = '".$this->site_config_id."'
					";
		mysql_query($strQuery) or die(mysql_error());
		$this->site_config_id = mysql_insert_id();
		return mysql_insert_id();
	}
	
	function uploadMaintananceImage()
	{
		if (!empty($_FILES) && $_FILES['site_config_image']['error'] == 0)
		{
			$my_upload = new file_upload;

			$my_upload->upload_dir = SERVER_ROOT."common/files/maintanance/";

			global $extensions;
			$my_upload->extensions = $extensions['image'];// specify the allowed extensions here

			$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
			$my_upload->rename_file = true;

			$my_upload->create_directory = true;

			$my_upload->the_temp_file = $_FILES['site_config_image']['tmp_name'];
			$my_upload->the_file = $_FILES['site_config_image']['name'];
			$my_upload->http_error = $_FILES['site_config_image']['error'];
			$my_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "y"; // because only a checked checkboxes is true
			
			
			$my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
			
			$new_name = "maintanance";
		
			if ($my_upload->upload($new_name))
			{ // new name is an additional filename information, use this to rename the uploaded file
				$this->site_config_image = $my_upload->file_copy;
			}
			else
			{
				$this->errorUpload = 1;	
			}
			if (empty($this->errorUpload)) 
			{
				return true;
			}
			else 
			{
				if (!empty($_REQUEST['alreadyUploaded']))
				{
					$this->site_config_image = $_REQUEST['alreadyUploaded'];	
				}
				return false;
			}
		
		}
		else 
		{	if (!empty($_REQUEST['alreadyUploaded']))
			{
				$this->site_config_image = $_REQUEST['alreadyUploaded'];	
			}
			return true;
		}
	}
}
?>