<?php
class form
{
	//Property
	var $form_id;
	var $client_id;
	var $form_background;
	var $form_header_text;
	var $form_normal_text;
	var $form_normal_text_bg;
	var $form_isactive;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	function form()
	{
		$this->form_background = "";
		$this->form_header_text = "";
		$this->form_normal_text = "";
		$this->form_normal_text_bg = "";
		$this->form_isactive = "";
	}
	//Method
	//Function to retrieve recordset of table
	function fetchrecordset($id="",$condition="",$order="form_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and form_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."form WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchallasarray($intid=NULL, $stralphabet=NULL,$condition="",$order="form_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND form_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND form_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."form WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($ar_form= mysql_fetch_array($rs))
		{
			$arrlist[$i]["form_id"] = $ar_form["form_id"];
			$arrlist[$i]["client_id"] = $ar_form["client_id"];
			$arrlist[$i]["form_background"] = $ar_form["form_background"];
			$arrlist[$i]["form_header_text"] = $ar_form["form_header_text"];
			$arrlist[$i]["form_normal_text"] = $ar_form["form_normal_text"];
			$arrlist[$i]["form_normal_text_bg"] = $ar_form["form_normal_text_bg"];
			$arrlist[$i]["form_isactive"] = $ar_form["form_isactive"];
			$arrlist[$i]["created_by"] = $ar_form["created_by"];
			$arrlist[$i]["created_date"] = $ar_form["created_date"];
			$arrlist[$i]["updated_by"] = $ar_form["updated_by"];
			$arrlist[$i]["updated_date"] = $ar_form["updated_date"];
			$i++;
		}

		return $arrlist;
	}

	//Function to set field values into object properties
	function setallvalues($id="",$condition="")
	{
		$rs=$this->fetchrecordset($id, $condition);
		
		if(mysql_num_rows($rs) > 0)
		{
			if($ar_form= mysql_fetch_array($rs))
			{
				$this->form_id = $ar_form["form_id"];
				$this->client_id = $ar_form["client_id"];
				$this->form_background = $ar_form["form_background"];
				$this->form_header_text = $ar_form["form_header_text"];
				$this->form_normal_text = $ar_form["form_normal_text"];
				$this->form_normal_text_bg = $ar_form["form_normal_text_bg"];
				$this->form_isactive = $ar_form["form_isactive"];
				$this->created_by = $ar_form["created_by"];
				$this->created_date = $ar_form["created_date"];
				$this->updated_by = $ar_form["updated_by"];
				$this->updated_date = $ar_form["updated_date"];
			}
		}
	}

	//Function to get particular field value
	function fieldvalue($field="form_id",$id="",$condition="",$order="")
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
		$strquery="INSERT INTO ".DB_PREFIX."form (client_id, form_background, form_header_text, form_normal_text, form_normal_text_bg, form_isactive, created_by, created_date, updated_by, updated_date) values('".$this->client_id."','".$this->form_background."','".$this->form_header_text."','".$this->form_normal_text."','".$this->form_normal_text_bg."','".$this->form_isactive."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
		mysql_query($strquery) or die(mysql_error());
		$this->form_id = mysql_insert_id();
		return mysql_insert_id();
	}
	
	//Function to add record into table
	function addLayoutDetail() 
	{
		$rs = $this->fetchrecordset("", " and client_id = ".$this->client_id, "");
		if(!(mysql_num_rows($rs) > 0))
		{
			$strquery="INSERT INTO ".DB_PREFIX."form (client_id, form_background, form_header_text, form_normal_text, form_normal_text_bg, form_isactive, created_by, created_date, updated_by, updated_date) values('".$this->client_id."','".$this->form_background."','".$this->form_header_text."','".$this->form_normal_text."','".$this->form_normal_text_bg."','1','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			
			mysql_query($strquery) or die(mysql_error());
		}	
		else
		{
			$arr = mysql_fetch_array($rs);
			$this->form_id = $arr["form_id"];
			
			$strquery="UPDATE ".DB_PREFIX."form SET form_background='".$this->form_background."', form_header_text='".$this->form_header_text."', form_normal_text='".$this->form_normal_text."', form_normal_text_bg='".$this->form_normal_text_bg."', updated_by='".$this->updated_by."', updated_date='".currentScriptDate()."' WHERE form_id=".$this->form_id;
			
			return mysql_query($strquery) or die(mysql_error());
		}		
	}
	
	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."form SET client_id='".$this->client_id."', form_background='".$this->form_background."', form_header_text='".$this->form_header_text."', form_normal_text='".$this->form_normal_text."', form_normal_text_bg='".$this->form_normal_text_bg."', form_isactive='".$this->form_isactive."', created_by='".$this->created_by."', created_date='".$this->created_date."', updated_by='".$this->updated_by."', updated_date='".$this->updated_date."' WHERE form_id=".$this->form_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."form  WHERE form_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "form SET form_isactive='n' WHERE form_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "form SET form_isactive='y' WHERE form_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}

	function add_with_check() 
	{
		$rs = $this->fetchrecordset("", " and client_id = ".$this->client_id, "");
		if(!(mysql_num_rows($rs) > 0))
		{
			$strquery="INSERT INTO ".DB_PREFIX."form (client_id, form_isactive, created_by, created_date, updated_by, updated_date) values('".$this->client_id."','".$this->form_isactive."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			mysql_query($strquery) or die(mysql_error());
			$this->form_id = mysql_insert_id();
			return mysql_insert_id();
		}
		else
		{
			$arr = mysql_fetch_array($rs);
			$this->form_id = $arr["form_id"];
			return 	$this->form_id;	
		}
	}
	
	function uploadHeaderBackground()
	{
		if (!empty($_FILES) && $_FILES['judge_photo']['error'] == 0)
		{
			$my_upload = new file_upload;

			$my_upload->upload_dir = SERVER_ROOT."common/files/templatebg/";

			global $extensions;
			$my_upload->extensions = $extensions['image'];// specify the allowed extensions here

			$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
			$my_upload->rename_file = true;

			$my_upload->create_directory = true;

			$my_upload->the_temp_file = $_FILES['judge_photo']['tmp_name'];
			$my_upload->the_file = $_FILES['judge_photo']['name'];
			$my_upload->http_error = $_FILES['judge_photo']['error'];
			$my_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "y"; // because only a checked checkboxes is true
			
			
			$my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
		
			$new_name = (isset($_POST['name'])) ? $_POST['name'] : time();
		
			if ($my_upload->upload($new_name))
			{ // new name is an additional filename information, use this to rename the uploaded file
			
				$org_image_name= str_replace($new_name,$new_name."_org", $my_upload->file_copy);
				copy($my_upload->upload_dir. $my_upload->file_copy, $my_upload->upload_dir.$org_image_name);
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
					$this->form_background = $_REQUEST['alreadyUploaded'];	
				}
				return false;
			}
		}
		else 
		{
			if (!empty($_REQUEST['alreadyUploaded']))
			{
				$this->form_background = $_REQUEST['alreadyUploaded'];	
			}
			return true;
		}
	}
	
	function uploadHeaderBackgroundImage()
	{		
		if (!empty($_FILES) && $_FILES['filHeaderBg']['error'] == 0)
		{	
			$my_upload = new file_upload;

			$my_upload->upload_dir = SERVER_ROOT."common/files/background/";

			global $extensions;
			$my_upload->extensions = $extensions['image'];// specify the allowed extensions here

			$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
			$my_upload->rename_file = true;

			$my_upload->create_directory = true;

			$my_upload->the_temp_file = $_FILES['filHeaderBg']['tmp_name'];
			$my_upload->the_file = $_FILES['filHeaderBg']['name'];
			$my_upload->http_error = $_FILES['filHeaderBg']['error'];
			$my_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "y"; // because only a checked checkboxes is true
			
			
			$my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
			
			$new_name = (isset($this->contest_id)) ? "headerbgImage_".$this->client_id : time();
		
			if ($my_upload->upload($new_name))
			{ // new name is an additional filename information, use this to rename the uploaded file
				$this->form_background = $my_upload->file_copy;
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
				if (!empty($_REQUEST['alreadyUploaded_HB']))
				{
					$this->form_background = $_REQUEST['alreadyUploaded_HB'];	
				}
				return false;
			}
		
		}
		else 
		{
			if (!empty($_REQUEST['alreadyUploaded_HB']))
			{
				$this->form_background = $_REQUEST['alreadyUploaded_HB'];	
			}
			return true;
		}
	}
}
?>