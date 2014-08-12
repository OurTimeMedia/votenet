<?php
class website extends common
{
	//Property
	var $website_id;
	var $client_id;
	var $is_subdomain;
	var $domain;
	var $template_id;
	var $total_visit;
	var $background_type;
	var $top_nav_background_color;
	var $top_nav_text_color;
	var $background_color;
	var $background_image;
	var $banner_image;
	var $is_sharing;
	var $sharing_redirect_url;
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;
	var $api_key;
	var $IsActive;
	
	function client()
	{
		$this->client_id = 0;
		$this->is_subdomain = 0;
		$this->domain = "";
		$this->template_id = 1;
		$this->total_visit = 0;
		$this->background_type = 1;
		$this->top_nav_background_color = "AE030C";
		$this->top_nav_text_color = "FFFFFF";
		$this->background_color = "";		
		$this->background_image = "";
		$this->banner_image = "";
		$this->is_sharing = 1;
		$this->sharing_redirect_url = "";
	}
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id = "",$condition = "",$order = "client_id")
	{		
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
			$condition  =  " and client_id = ". $id .$condition;
		}
		if($order !=  "" && $order !=   NULL && is_null($order) == false)
		{
			$order  =  " order by " . $order;
		}
		$sQuery = "SELECT * FROM ".DB_PREFIX."website WHERE 1 = 1 " . $condition . $order;
		
		$rs  =  $this->runquery($sQuery);
		return $rs;
	}
	
	//Function to set field values into object properties
	function setAllValues($id = "",$condition = "")
	{
		$rs = $this->fetchRecordSet($id, $condition);
	
		if($artf_user =  mysql_fetch_assoc($rs))		
		{
			$this->website_id  =  $artf_user["website_id"];
			$this->client_id  =  $artf_user["client_id"];
			$this->is_subdomain  =  $artf_user["is_subdomain"];
			$this->domain  =  $artf_user["domain"];
			$this->template_id  =  $artf_user["template_id"];
			$this->total_visit  =  $artf_user["total_visit"];
			$this->background_type  =  $artf_user["background_type"];
			$this->top_nav_background_color = $artf_user["top_nav_background_color"];
			$this->top_nav_text_color = $artf_user["top_nav_text_color"];
			$this->background_color  =  $artf_user["background_color"];
			$this->background_image  =  $artf_user["background_image"];
			$this->banner_image  =  $artf_user["banner_image"];
			$this->is_sharing  =  $artf_user["is_sharing"];
			$this->sharing_redirect_url  =  $artf_user["sharing_redirect_url"];
			$this->hide_banner  =  $artf_user["hide_banner"];
			$this->hide_navigation  =  $artf_user["hide_navigation"];
			$this->hide_steps  =  $artf_user["hide_steps"];
		}
	}

	//Function to get particular field value
	function fieldValue($field = "client_id",$id = "",$condition = "",$order = "")
	{
		$rs = $this->fetchRecordSet($id, $condition, $order);
		$ret = 0;
		while($rw = mysql_fetch_assoc($rs))
		{
			$ret = $rw[$field];
		}
		return $ret;
	}
	
	//Function to update record of table
	function update() 
	{		
		$sQuery = "UPDATE ".DB_PREFIX."website SET 
					is_subdomain = '".$this->is_subdomain."', 
					domain = '".$this->domain."', 
					template_id = '".$this->template_id."', 
					total_visit = '".$this->total_visit."', 
					background_type = '".$this->background_type."', 
					top_nav_background_color = '".$this->top_nav_background_color."', 
					top_nav_text_color = '".$this->top_nav_text_color."', 
					background_color = '".$this->background_color."', 
					background_image = '".$this->background_image."',
					banner_image = '".$this->banner_image."',
					is_sharing = '".$this->is_sharing."',
					hide_banner = '".$this->hide_banner."',
					hide_navigation = '".$this->hide_navigation."',
					hide_steps = '".$this->hide_steps."',
					sharing_redirect_url = '".$this->sharing_redirect_url."'
					WHERE client_id = ".$this->client_id;
		
		return $this->runquery($sQuery);
	}
	
	function uploadTemplateBackgroundImage()
	{
		if (!empty($_FILES) && $_FILES['filBackgroundImage']['error'] == 0)
		{	
			 $my_upload = new file_upload;

			$my_upload->upload_dir = SERVER_ROOT.BACKGROUND_IMAGE;

			global $extensions;
			$my_upload->extensions = $extensions['image'];// specify the allowed extensions here

			$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
			$my_upload->rename_file = true;

			$my_upload->create_directory = true;

			$my_upload->the_temp_file = $_FILES['filBackgroundImage']['tmp_name'];
			$my_upload->the_file = $_FILES['filBackgroundImage']['name'];
			$my_upload->http_error = $_FILES['filBackgroundImage']['error'];
			$my_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "y"; // because only a checked checkboxes is true
			
			
			$my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
			
			$new_name = (isset($this->client_id)) ? "bgImage_".$this->client_id : time();
		
			if ($my_upload->upload($new_name))
			{ // new name is an additional filename information, use this to rename the uploaded file
				$this->background_image = $my_upload->file_copy;
			}
			else
			{
				$this->errorUpload = 1;	
			}
			
			/*require_once SERVER_ROOT.'common/class/s3/s3.php';
			
			$ext = strtolower(strrchr($_FILES['filBackgroundImage']['name'],"."));
			$new_name1 = (isset($this->client_id)) ? "bgImage_".$this->client_id : time();
			$new_name = "ElectionImpactProd/files/background/".$new_name1.$ext;			
			
			$s3 = new s3(AMAZON_KEY, AMAZON_SECRET_KEY);
			if($s3->putObject(BUCKET_NAME, $new_name, $_FILES['filBackgroundImage']['tmp_name'], $_FILES['filBackgroundImage']['type'], sprintf("%u", filesize($_FILES['filBackgroundImage']['tmp_name'])), 'public-read', array(), ""))
			{
				$this->background_image = $new_name1.$ext;
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
				if (!empty($_REQUEST['alreadyUploadedBg']))
				{
					$this->background_image = $_REQUEST['alreadyUploadedBg'];	
				}
				return false;
			}
		
		}
		else 
		{
			if (!empty($_REQUEST['alreadyUploadedBg']))
			{
				$this->background_image = $_REQUEST['alreadyUploadedBg'];	
			}
			return true;*/
		}
	}
	
	
	function uploadTemplateBannerImage()
	{
		if (!empty($_FILES) && $_FILES['filBannerImage']['error'] == 0)
		{
			$my_upload = new file_upload;

			$my_upload->upload_dir = SERVER_ROOT.BANNER_IMAGE;

			global $extensions;
			$my_upload->extensions = $extensions['image'];// specify the allowed extensions here

			$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
			$my_upload->rename_file = true;

			$my_upload->create_directory = true;

			$my_upload->the_temp_file = $_FILES['filBannerImage']['tmp_name'];
			$my_upload->the_file = $_FILES['filBannerImage']['name'];
			$my_upload->http_error = $_FILES['filBannerImage']['error'];
			$my_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "y"; // because only a checked checkboxes is true
			
			
			$my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
			
			$new_name = (isset($this->client_id)) ? "bannerImage_".$this->client_id : time();
		
			if ($my_upload->upload($new_name))
			{ // new name is an additional filename information, use this to rename the uploaded file
				$this->banner_image = $my_upload->file_copy;
			}
			else
			{
				$this->errorUpload = 1;	
			} 
						
			/*require_once SERVER_ROOT.'common/class/s3/s3.php';
			
			$ext = strtolower(strrchr($_FILES['filBannerImage']['name'],"."));
			$new_name1 = (isset($this->client_id)) ? "bannerImage_".$this->client_id : time();
			$new_name = "ElectionImpactProd/files/banners/".$new_name1.$ext;			
			
			$s3 = new s3(AMAZON_KEY, AMAZON_SECRET_KEY);
			if($s3->putObject(BUCKET_NAME, $new_name, $_FILES['filBannerImage']['tmp_name'], $_FILES['filBannerImage']['type'], sprintf("%u", filesize($_FILES['filBannerImage']['tmp_name'])), 'public-read', array(), ""))
			{
				$this->banner_image = $new_name1.$ext;
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
				if (!empty($_REQUEST['alreadyUploadedBn']))
				{
					$this->banner_image = $_REQUEST['alreadyUploadedBn'];	
				}
				return false;
			}
		
		}
		else 
		{
			if (!empty($_REQUEST['alreadyUploadedBn']))
			{
				$this->banner_image = $_REQUEST['alreadyUploadedBn'];	
			}
			return true;*/
		}
	}
	
	function findVisits()
	{
		$strQuery="SELECT total_visits FROM ".DB_PREFIX."website_visits WHERE client_id='".$this->client_id."' AND  visit_date='".currentScriptDateOnly()."'";
		$rs = mysql_query($strQuery) or die(mysql_error());
		$totVisits = 0;
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			$totVisits = $res['total_visits'];
		}
		
		return $totVisits;
	}
	
	function addWebsiteVisits()
	{	
		$strQuery="INSERT INTO ".DB_PREFIX."website_visits (client_id,total_visits,visit_date) VALUES ('".$this->client_id."','".$this->total_visits."','".currentScriptDateOnly()."') ";
		mysql_query($strQuery) or die(mysql_error());
	}
	
	function updateWebsiteVisits()
	{
		$strQuery="UPDATE ".DB_PREFIX."website_visits SET total_visits = '".$this->total_visits."' WHERE client_id='".$this->client_id."' AND  visit_date='".currentScriptDateOnly()."'";
		mysql_query($strQuery) or die(mysql_error());
	}
	
	function fetchlanguagedetail($client_id)
	{
		/* $strquery="SELECT distinct(".DB_PREFIX."field_language_text.language_id), language_name FROM ".DB_PREFIX."field 
		left join ".DB_PREFIX."field_language_text  on ".DB_PREFIX."field_language_text.field_id= ".DB_PREFIX."field.field_id
		left join ".DB_PREFIX."language on ".DB_PREFIX."language.language_id= ".DB_PREFIX."field_language_text.language_id
		WHERE (client_id=".$client_id." or client_id='0')";*/
		
		$strquery="SELECT * FROM ".DB_PREFIX."language WHERE 1=1 order by language_order";
		
		$rs=mysql_query($strquery);
		$i=0;
		
		$resultdata = array();
		while($result=mysql_fetch_assoc($rs))
		{
			$resultdata[$i]['language_name']=$result['language_name'];
			$resultdata[$i]['language_id']=$result['language_id'];
			$i++;
		}	
	
		return $resultdata;
	}
	
	function deleteTemplateBackgroundImage()
	{
		
		$background_dir = SERVER_ROOT.BACKGROUND_IMAGE;
		
		if(file_exists($background_dir.$this->background_image))
		{
			unlink($background_dir.$this->background_image);
		}
		
		
		/*$file_name = "ElectionImpactProd/files/background/".$this->background_image;
		require_once SERVER_ROOT.'common/class/s3/s3.php';
		$s3 = new s3(AMAZON_KEY, AMAZON_SECRET_KEY);
		$s3->deleteObject(BUCKET_NAME,$file_name);
		*/
		$sQuery = "UPDATE ".DB_PREFIX."website SET 
					background_type = '1', 
					background_image = ''
					WHERE client_id = ".$this->client_id;
		
		return $this->runquery($sQuery);
	}
	
	function deleteTemplateBannerImage()
	{
		 $banner_dir = SERVER_ROOT.BANNER_IMAGE;
		//echo file_exists($banner_dir.$this->banner_image);exit;
		if(file_exists($banner_dir.$this->banner_image))
		{
			unlink($banner_dir.$this->banner_image);
		}
		
		/*$file_name = "ElectionImpactProd/files/banners/".$this->banner_image;
		require_once SERVER_ROOT.'common/class/s3/s3.php';
		$s3 = new s3(AMAZON_KEY, AMAZON_SECRET_KEY);
		$s3->deleteObject(BUCKET_NAME,$file_name);
		*/
		
		
		$sQuery = "UPDATE ".DB_PREFIX."website SET 					
					banner_image = ''
					WHERE client_id = ".$this->client_id;
		
		return $this->runquery($sQuery);
	}
  
  /* Added By Prashant */
  
  function updateAPI() 
	{		
		$sQuery = "UPDATE ".DB_PREFIX."website SET 
					ActivationKey = '".$this->api_key."', 
					IsActive = ".$this->IsActive."
					WHERE ActivationKey = '' AND client_id = ".$this->client_id;
		return $this->runquery($sQuery);
	}
  
  //Function to set field values into object properties
	function selectAPIKeyByClientID($id = "",$condition = "")
	{
		$rs = $this->fetchRecordSet($id, $condition);
	
		if($artf_user =  mysql_fetch_assoc($rs))		
		{
			$this->api_key  =  $artf_user["ActivationKey"];
			$this->IsActive  =  $artf_user["IsActive"];			
		}
	}
  
  /* Added By Prashant */
}
?>