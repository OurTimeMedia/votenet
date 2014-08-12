<?php
class language
{
	//Property
	var $language_id;
	var $language_name;
	var $language_code;
	var $language_icon;
	var $language_ispublish;
	var $language_order;
	var $language_isactive;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $totfields;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="language_order")
	{
		if($id != "" && $id !=  NULL && is_null($id)  ==  false)
		{
		$condition = " and language_id=". $id .$condition;
		}
		if($order  !=  "" && $order !=  NULL && is_null($order) == false)
		{
			$order = " order by " . $order.", language_id desc";
		}
		
		$strquery="SELECT * FROM ".DB_PREFIX."language WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		$i=0;
		
		while($langua =  mysql_fetch_assoc($rs))
		{
			$res[$i]['language_id']=$langua['language_id'];
			$res[$i]['language_name']=$langua['language_name'];
			$res[$i]['language_code']=$langua['language_code'];
			$res[$i]['language_icon']=$langua['language_icon'];
			$res[$i]['language_isactive']=$langua['language_isactive'];
			$i++;
		}
		
		return $res;
	}
	
	function fetchRecordSetObj($id="",$condition="",$order="language_order")
	{
		if($id != "" && $id !=  NULL && is_null($id)  ==  false)
		{
		$condition = " and language_id=". $id .$condition;
		}
		if($order  !=  "" && $order !=  NULL && is_null($order) == false)
		{
			$order = " order by " . $order.", language_id desc";
		}
		
		$strquery="SELECT * FROM ".DB_PREFIX."language WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		$i=0;
				
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="language_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid) != "") $and .= " AND language_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet) != "")	$and .= " AND language_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."language WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($arlanguage= mysql_fetch_array($rs))
		{
			$arrlist[$i]["language_id"] = $arlanguage["language_id"];
			$arrlist[$i]["language_name"] = $arlanguage["language_name"];
			$arrlist[$i]["language_code"] = $arlanguage["language_code"];
			$arrlist[$i]["language_icon"] = $arlanguage["language_icon"];
			$arrlist[$i]["language_ispublish"] = $arlanguage["language_ispublish"];
			$arrlist[$i]["language_order"] = $arlanguage["language_order"];
			$arrlist[$i]["language_isactive"] = $arlanguage["language_isactive"];
			$arrlist[$i]["created_by"] = $arlanguage["created_by"];
			$arrlist[$i]["created_date"] = $arlanguage["created_date"];
			$arrlist[$i]["updated_by"] = $arlanguage["updated_by"];
			$arrlist[$i]["updated_date"] = $arlanguage["updated_date"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSetObj($id, $condition);
		$i=0;

		while($arlanguage= mysql_fetch_array($rs))
		{
			$this->language_id = $arlanguage["language_id"];
			$this->language_name = $arlanguage["language_name"];
			$this->language_code = $arlanguage["language_code"];
			$this->language_icon = $arlanguage["language_icon"];
			$this->language_ispublish = $arlanguage["language_ispublish"];
			$this->language_order = $arlanguage["language_order"];
			$this->language_isactive = $arlanguage["language_isactive"];
			
			$i++;
		}		
	}

	//Function to get particular field value
	function fieldValue($field="language_id",$id="",$condition="",$order="")
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
		$strquery="INSERT INTO ".DB_PREFIX."language (language_name, language_code, language_ispublish, language_order, language_isactive, created_by, created_date, updated_by, updated_date) values('".$this->language_name."','".$this->language_code."','".$this->language_ispublish."','".$this->language_order."','".$this->language_isactive."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
		mysql_query($strquery) or die(mysql_error());
		$this->language_id = mysql_insert_id();
		
		for($i=0;$i<$this->totfields;$i++)
		{	
			$fieldname = "txtField".$i;
			$fieldvalue = $_POST[$fieldname];
			$fieldvalue = explode("###",$fieldvalue);
			$field = "txt".$fieldvalue[0];
			
			$strquery="INSERT INTO ".DB_PREFIX."language_resource (language_id, resource_id, resource_text, created_by, created_date, updated_by, updated_date) values('".$this->language_id."','".$fieldvalue[0]."','".$this->$field."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			mysql_query($strquery) or die(mysql_error());
		
		}
		return $this->language_id;
	}

	//Function to update record of table
	function update() 
	{
		$this->updateImage();
		for($i=0;$i<$this->totfields;$i++)
		{	
			$fieldname = "txtField".$i;
			$fieldvalue = $_POST[$fieldname];
			$fieldvalue = explode("###",$fieldvalue);
			$field = "txt".$fieldvalue[0];
			
			$strquery="SELECT language_id FROM ".DB_PREFIX."language_resource WHERE language_id=".$this->language_id." AND resource_id='".$fieldvalue[0]."'";
			$resm = mysql_query($strquery) or die(mysql_error());
			if(mysql_num_rows($resm)>0)
			{
				$strquery="UPDATE ".DB_PREFIX."language_resource SET resource_text='".$this->$field."', updated_by='".$this->updated_by."', updated_date='".currentScriptDate()."' WHERE language_id=".$this->language_id." AND resource_id='".$fieldvalue[0]."'";
			}
			else
			{
				$strquery="INSERT INTO ".DB_PREFIX."language_resource (language_id, resource_id, resource_text, created_by, created_date, updated_by, updated_date) values('".$this->language_id."','".$fieldvalue[0]."','".$this->$field."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			}
			mysql_query($strquery) or die(mysql_error());
		}

		$strquery="UPDATE ".DB_PREFIX."language SET language_name='".$this->language_name."', language_code='".$this->language_code."', language_ispublish='".$this->language_ispublish."', language_order='".$this->language_order."', language_isactive='".$this->language_isactive."', updated_by='".$this->updated_by."', updated_date='".currentScriptDate()."' WHERE language_id=".$this->language_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{	
		$rs = $this->fetchRecordSet($this->checkedids);
		
		if($artf_language = mysql_fetch_array($rs))
		{
			$this->language_icon = $artf_language["language_icon"];
		}
		
		if (!empty($this->language_icon)) 
		{
			$sImgPath = SERVER_ROOT."common/files/languages/".$this->language_icon;
			
			if (file_exists($sImgPath)) 
			{	
				unlink($sImgPath);	
			}
			
		}
		
		$this->deleteLangResRel();
		$strquery="DELETE FROM ".DB_PREFIX."language  WHERE language_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}
	
	function deleteLangResRel()
	{
		$strquery="DELETE FROM ".DB_PREFIX."language_resource  WHERE language_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "language SET language_isactive='n' WHERE language_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result  ==  false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "language SET language_isactive='y' WHERE language_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
	
	// Function to Fetch Language Resource Detail
	function fetchLanguageResourceRel($resource_id,$language_id=1)
	{	
		if($language_id=='')
		{
			$language_id = 1;
		}
		$and = " AND language_id = '".$language_id."' ";
		$strquery="SELECT * FROM ".DB_PREFIX."language_resource WHERE 1=1 AND resource_id='".$resource_id."' " . $and . " LIMIT 0,1";
		$rs=mysql_query($strquery);
		
		return mysql_fetch_array($rs);
	}
	
	function updateImage()
	{
		if (!empty($this->language_icon) && $_FILES['language_icon']['error'] == 0) 		{
			if (!empty($_REQUEST['alreadyUploaded'])) 
			{
				$sImgPath = SERVER_ROOT."common/files/languages/".$_REQUEST['alreadyUploaded'];
				
				if (file_exists($sImgPath)) 
				{	
					unlink($sImgPath);	
				}
			}
			
			$srcImage = SERVER_ROOT."common/files/languages/".$this->language_icon;
			
			$imgExt = explode(".",$this->language_icon);
			
			$new_image = strtolower($this->language_name).".".$imgExt[1];
			
			$destImage = SERVER_ROOT."common/files/languages/".$new_image;
			
			rename($srcImage,$destImage);		
			
			$strquery="UPDATE ".DB_PREFIX."language SET 
		
					language_icon='".$new_image."'
					WHERE language_id=".$this->language_id;
		
			return mysql_query($strquery) or die(mysql_error());	
		}
	}
	
	
	function uploadLanguageImage()
	{
		if (!empty($_FILES) && $_FILES['language_icon']['error'] == 0)
		{
			$my_upload = new file_upload;

			$my_upload->upload_dir = SERVER_ROOT."common/files/languages/";

			global $extensions;
			$my_upload->extensions = $extensions['image'];// specify the allowed extensions here

			$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
			$my_upload->rename_file = true;

			$my_upload->create_directory = true;

			$my_upload->the_temp_file = $_FILES['language_icon']['tmp_name'];
			$my_upload->the_file = $_FILES['language_icon']['name'];
			$my_upload->http_error = $_FILES['language_icon']['error'];
			$my_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "y"; // because only a checked checkboxes is true
			
			
			$my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
			
			$new_name = (isset($_POST['name'])) ? $_POST['name'] : time();
		
			if ($my_upload->upload($new_name))
			{ // new name is an additional filename information, use this to rename the uploaded file
				$this->language_icon = $my_upload->file_copy;
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
					$this->language_icon = $_REQUEST['alreadyUploaded'];	
				}
				return false;
			}
		
		}
		else 
		{
			return true;
		}
	}


}
?>