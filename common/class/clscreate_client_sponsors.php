<?php
class create_client_sponsors extends common
{
	//Property
	var $client_id;
	var $sponsors_id;
	var $sponsors_name;
	var $sponsors_description;
	var $sponsors_logo;
	var $sponsors_website;
	var $sponsors_isactive;
	var $pagingType;
	
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;

	var $checkedids;
	var $uncheckedids;
	
	function create_client_sponsors()
	{
		$this->client_id = 0;
		$this->sponsors_id = 0;
		$this->sponsors_name = "";
		$this->sponsors_description = "";
		$this->sponsors_logo = "";
		$this->sponsors_website = "";
		$this->sponsors_isactive = 1;
	}
		
	//Function to retrieve recordset of table
	function fetchRecordSetSponsors($id="",$condition="",$order="sponsors_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and sponsors_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", sponsors_id desc";
		}
		$strquery="SELECT * FROM ".DB_PREFIX."sponsors WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArraySponsors($intid=NULL, $stralphabet=NULL,$condition="",$order="sponsors_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND sponsors_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND sponsors_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."sponsors WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		
		while($artf_awards= mysql_fetch_array($rs))
		{	$arrlist[$i]["sponsors_id"] = $artf_awards["sponsors_id"];
			$arrlist[$i]["client_id"] = $artf_awards["client_id"];
			$arrlist[$i]["sponsors_name"] = $artf_awards["sponsors_name"];
			$arrlist[$i]["sponsors_description"] = $artf_awards["sponsors_description"];
			$arrlist[$i]["sponsors_logo"] = $artf_awards["sponsors_logo"];
			$arrlist[$i]["sponsors_website"] = $artf_awards["sponsors_website"];
			$arrlist[$i]["sponsors_isactive"] = $artf_awards["sponsors_isactive"];
			$arrlist[$i]["created_by"] = $artf_awards["created_by"];
			$arrlist[$i]["created_date"] = $artf_awards["created_date"];
			$arrlist[$i]["updated_by"] = $artf_awards["updated_by"];
			$arrlist[$i]["updated_date"] = $artf_awards["updated_date"];

			$i++;
		}
		return $arrlist;
	}
	
	//Function to set field values into object properties
	function setAllValuesSponsors($id="",$condition="")
	{
		$rs=$this->fetchRecordSetSponsors($id, $condition);
		if($artf_awards= mysql_fetch_array($rs))
		{
			$this->sponsors_id = $artf_awards["sponsors_id"];
			$this->client_id = $artf_awards["client_id"];
			$this->sponsors_name = $artf_awards["sponsors_name"];
			$this->sponsors_description = $artf_awards["sponsors_description"];
			$this->sponsors_logo = $artf_awards["sponsors_logo"];
			$this->sponsors_website = $artf_awards["sponsors_website"];
			$this->sponsors_isactive = $artf_awards["sponsors_isactive"];
			
			$this->created_date = $artf_awards["created_date"];
			$this->created_by = $artf_awards["created_by"];
			$this->updated_date = $artf_awards["updated_date"];
			$this->updated_by = $artf_awards["updated_by"];
		}
	}

	function addSponsorsInformation()
	{
		$strQuery="INSERT INTO ".DB_PREFIX."sponsors 
					(client_id, sponsors_name, 
					sponsors_description, sponsors_logo, sponsors_website, sponsors_isactive,
					created_by,created_date, updated_by, updated_date) 
		  values('".$this->client_id."', '".$this->sponsors_name."','".$this->sponsors_description."',
				 '".$this->sponsors_logo."','".$this->sponsors_website."','".$this->sponsors_isactive."',
				 '".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
				 
			mysql_query($strQuery) or die(mysql_error());
			$this->sponsors_id = mysql_insert_id();
			return mysql_insert_id();
	}
	
	function updateSponsorsInformation()
	{
		$strQuery="UPDATE ".DB_PREFIX."sponsors SET client_id='".$this->client_id."', sponsors_name = '".$this->sponsors_name."', sponsors_description='".$this->sponsors_description."',
					sponsors_logo='".$this->sponsors_logo."', sponsors_website = '".$this->sponsors_website."', 
					sponsors_isactive = '".$this->sponsors_isactive."',
					updated_by = '".$this->updated_by."', updated_date = '".currentScriptDate()."' WHERE sponsors_id='".$this->sponsors_id."'";
			mysql_query($strQuery) or die(mysql_error());
	}
	
	function updateSponsorsImgInformation()
	{
		$strQuery="UPDATE ".DB_PREFIX."sponsors SET sponsors_logo = '".$this->sponsors_logo."'
					WHERE sponsors_id='".$this->sponsors_id."'";
			mysql_query($strQuery) or die(mysql_error());
	}
	
	function deleteSponsorsDtl()
	{
		$sponser_dir = SERVER_ROOT.SPONSER_IMAGE;
		
		if(file_exists($sponser_dir.$this->sponsors_logo))
		{
			unlink($sponser_dir.$this->sponsors_logo);
		}
		$strQuery="DELETE FROM ".DB_PREFIX."sponsors
					WHERE sponsors_id='".$this->sponsors_id."'";
		mysql_query($strQuery) or die(mysql_error());
	}	
	
	function uploadSponsorsLogo()
	{		
		$fileName = "txtsponsors_logo";
		if (!empty($_FILES) && $_FILES[$fileName]['error'] == 0)
		{
			/*$old_sponsor_logo = "ElectionImpactProd/files/sponsors/".$this->sponsors_logo;
			$sponsor_img_width = 150;
			$sponsor_img_height = 150;
			
			require_once SERVER_ROOT.'common/class/s3/s3.php';
			
			$ext = strtolower(strrchr($_FILES[$fileName]['name'],"."));
			$new_name1 = "spImage_".time();
			$new_name = "ElectionImpactProd/files/sponsors/".$new_name1.$ext;
			$save = SERVER_ROOT."common/files/sponsors/".$new_name1.$ext;
			
			list($org_width, $org_height) = getimagesize($_FILES[$fileName]['tmp_name']);
			
			if($org_width > $org_height)	
				$sponsor_img_height = $sponsor_img_width * $org_height / $org_width;					
			else
				$sponsor_img_width = $sponsor_img_height * $org_width / $org_height;
				
			$image_p = imagecreatetruecolor($sponsor_img_width, $sponsor_img_height);
			$white = imagecolorallocate($image_p, 255, 255, 255);
			imagefill($image_p, 0, 0, $white);	
						
			switch($ext){
				case ".gif":
					$image = @imagecreatefromgif($_FILES[$fileName]['tmp_name']);
				break;
				case ".jpg":
					$image = @imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
				break;
				case ".jpeg":
					$image = @imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
				break;
				case ".png":
					$image = @imagecreatefrompng($_FILES[$fileName]['tmp_name']);
				break;
			}
			
			@imagecopyresampled($image_p, $image, 0, 0, 0, 0, $sponsor_img_width, $sponsor_img_height, $org_width, $org_height);
			
			switch($ext){
				case ".gif":
					if(!@imagegif($image_p, $save)){
						$errorList[]= "PERMISSION DENIED [GIF]";
					}
				break;
				case ".jpg":
					if(!@imagejpeg($image_p, $save, 100)){
						$errorList[]= "PERMISSION DENIED [JPG]";
					}
				break;
				case ".jpeg":
					if(!@imagejpeg($image_p, $save, 100)){
						$errorList[]= "PERMISSION DENIED [JPEG]";
					}
				break;
				case ".png":
					if(!@imagepng($image_p, $save, 0)){
						$errorList[]= "PERMISSION DENIED [PNG]";
					}
				break;
			}		
			
			$s3 = new s3(AMAZON_KEY, AMAZON_SECRET_KEY);
			if($s3->putObject(BUCKET_NAME, $new_name, $save, $_FILES[$fileName]['type'], sprintf("%u", filesize($save)), 'public-read', array(), ""))
			{
				$this->sponsors_logo = $new_name1.$ext;
				
				$s31 = new s3(AMAZON_KEY, AMAZON_SECRET_KEY);
				$s31->deleteObject(BUCKET_NAME,$old_sponsor_logo);
				unlink($save);
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
				if (!empty($_REQUEST['alreadyUploaded_S']))
				{
					$this->sponsors_logo = $_REQUEST['alreadyUploaded_S'];	
				}
				return false;
			}
		
		}
		else 
		{
			if (!empty($_REQUEST['alreadyUploaded_S']))
			{
				$this->sponsors_logo = $_REQUEST['alreadyUploaded_S'];	
			}
			return true;
		}*/
		
			$sponsor_img_width = 150;
			$sponsor_img_height = 150;
			
			$my_upload = new file_upload;

			$my_upload->upload_dir = SERVER_ROOT."common/files/sponsors/";

			global $extensions;
			$my_upload->extensions = $extensions['image'];// specify the allowed extensions here

			$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
			$my_upload->rename_file = true;

			$my_upload->create_directory = true;

			$my_upload->the_temp_file = $_FILES['txtsponsors_logo']['tmp_name'];
			$my_upload->the_file = $_FILES['txtsponsors_logo']['name'];
			$my_upload->http_error = $_FILES['txtsponsors_logo']['error'];
			$my_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "y"; // because only a checked checkboxes is true
			
			
			$my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
		
			$new_name = (isset($_POST['name'])) ? $_POST['name'] : time();
		
			if ($my_upload->upload($new_name))
			{ // new name is an additional filename information, use this to rename the uploaded file
			
				$org_image_name= str_replace($new_name,$new_name."_org", $my_upload->file_copy);
				copy($my_upload->upload_dir. $my_upload->file_copy, $my_upload->upload_dir.$org_image_name);
		
				list($org_width, $org_height, $org_type, $org_attr) = getimagesize($my_upload->upload_dir. $my_upload->file_copy);
					
				if($org_width > $org_height)	
				{					
					$sponsor_img_height = $sponsor_img_width * $org_height / $org_width;					
				}
				else
				{
					$sponsor_img_width = $sponsor_img_height * $org_width / $org_height;
				}
				
				$new_image = imagecreatetruecolor($sponsor_img_width, $sponsor_img_height);
				if (strtolower(end(explode('.',$my_upload->the_file))) == 'png')
					$source_image = imagecreatefrompng($my_upload->upload_dir.$org_image_name);
				else if (strtolower(end(explode('.',$my_upload->the_file))) == 'gif')
					$source_image = imagecreatefromgif($my_upload->upload_dir.$org_image_name);
				else 
					$source_image = imagecreatefromjpeg($my_upload->upload_dir.$org_image_name);
				imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $sponsor_img_width, $sponsor_img_height, $org_width, $org_height);
				
				imagejpeg($new_image, $my_upload->upload_dir.$my_upload->file_copy, 100);
				
				$this->sponsors_logo = $my_upload->file_copy;
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
			
				if (!empty($_REQUEST['alreadyUploaded_S']))
				{
					$this->sponsors_logo = $_REQUEST['alreadyUploaded_S'];	
				}
				return false;
			}
		
		}
		else 
		{
			
			if (!empty($_REQUEST['alreadyUploaded_S']))
			{
				$this->sponsors_logo = $_REQUEST['alreadyUploaded_S'];	
			}
			return true;
		}
	
	}
}
?>