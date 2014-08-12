<?php
class clientsocialmediacontent extends common
{
	var $socialmediacontent_id;
	var $client_id;
	var $fb_content;
	var $tw_content;
	var $google_title;
	var $google_content;
	var $tumblr_title;
	var $tumblr_content;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	
	function clientsocialmediacontent()
	{
		$this->client_id = 0;
		$this->fb_content = "";
		$this->tw_content = "";
		$this->google_title = "";
		$this->google_content = "";
		$this->tumblr_title = "";
		$this->tumblr_content = "";
	}
	
	function fetchRecordSet($id="",$condition="",$order="")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and socialmediacontent_id=". $id .$condition;
		}
		
		$order = " order by client_id desc";
		
		$strquery="SELECT * FROM ".DB_PREFIX."socialmediacontent WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artf_email_templates= mysql_fetch_array($rs))
		{
			$this->socialmediacontent_id = $artf_email_templates["socialmediacontent_id"];
			$this->client_id = $artf_email_templates["client_id"];
			$this->fb_content = $artf_email_templates["fb_content"];
			$this->tw_content = $artf_email_templates["tw_content"];
			$this->google_title = $artf_email_templates["google_title"];
			$this->google_content = $artf_email_templates["google_content"];
			$this->tumblr_title = $artf_email_templates["tumblr_title"];
			$this->tumblr_content = $artf_email_templates["tumblr_content"];
		}
	}
	
	function savemessages()
	{
		$condition = " AND client_id='".$this->client_id."' ";
		$resSocial = $this->fetchRecordSet("", $condition);
		
		if(mysql_num_rows($resSocial) > 0)
		{
			$sQuery1 = "UPDATE ".DB_PREFIX."socialmediacontent SET 
					fb_content = '".$this->fb_content."', 					
					tw_content = '".$this->tw_content."', 
					google_title = '".$this->google_title."', 
					google_content = '".$this->google_content."', 
					tumblr_title = '".$this->tumblr_title."', 
					tumblr_content = '".$this->tumblr_content."', 
					updated_date = '".currentScriptDate()."', 
					updated_by = '".$this->updated_by."' 
					WHERE client_id = ".$this->client_id;
		}
		else
		{			
			$sQuery1 =  "INSERT INTO ".DB_PREFIX."socialmediacontent 					
					(client_id, fb_content, tw_content, google_title, google_content, tumblr_title, tumblr_content, created_date, created_by, updated_date, updated_by)
					values('".$this->client_id."', '".$this->fb_content."', '".$this->tw_content."', '".$this->google_title."', '".$this->google_content."', '".$this->tumblr_title."', '".$this->tumblr_content."', '".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";							
		}
		
		return $this->runquery($sQuery1);
	}

	function fetchclientcontent($client_id=0)
	{
		 $sql="select * from ".DB_PREFIX."socialmediacontent where client_id=".$client_id;
		$res=mysql_query($sql);
		$data=mysql_fetch_array($res);
		return $data;
	}
	
	function fetchclientadmincontent($client_id=0)
	{
		$sql="select * from ".DB_PREFIX."socialmediacontent where if(client_id=".$client_id.",client_id=0,1)";
		//echo $sql;exit;
		$res=mysql_query($sql);
		$data=mysql_fetch_array($res);
		return $data;
	}
	
	function addcontent($post,$client_id=0)
	{
		$sql="select * from ".DB_PREFIX."socialmediacontent where client_id=".$client_id;
		$res=mysql_query($sql);
		$data=mysql_fetch_array($res);
	
		if(isset($data['fb_content']) || isset($data['tw_content']) || isset($data['google_content']) || isset($data['tumblr_content']))
		{
			if($post['currentshow']==1)
			{
				$sql="update ".DB_PREFIX."socialmediacontent set
				fb_content='".$this->setVal(trim($this->readValueSubmission($post['fcontent'])))."'
				 where client_id=".$client_id;
			}
			else if($post['currentshow']==2)
			{
				$sql="update ".DB_PREFIX."socialmediacontent set
				tw_content='".$this->setVal(trim($this->readValueSubmission($post['tcontent'])))."' where client_id=".$client_id;
			}
			else if($post['currentshow']==3)
			{
				$sql="update ".DB_PREFIX."socialmediacontent set
				google_content='".$this->setVal(trim($this->readValueSubmission($post['gcontent'])))."',google_title='".$this->setVal(trim($this->readValueSubmission($post['gtitle'])))."' where client_id=".$client_id;
			}
			else if($post['currentshow']==4)
			{
				$sql="update ".DB_PREFIX."socialmediacontent set tumblr_title='".$this->setVal(trim($this->readValueSubmission($post['tumblrtitle'])))."',
				tumblr_content='".$this->setVal(trim($this->readValueSubmission($post['tucontent'])))."' where client_id=".$client_id;
			}
			
			$res=mysql_query($sql);
		}
		else
		{
			if($post['currentshow']==1)
			{
				$sql="insert into ".DB_PREFIX."socialmediacontent set
				client_id=".$client_id.",
				fb_content='".$this->setVal(trim($this->readValueSubmission($post['fcontent'])))."',
				created_by=".$this->created_by.",
				created_date='".currentScriptDate()."',
				updated_by=".$this->updated_by.",
				updated_date='".currentScriptDate()."'";
			}
			else if($post['currentshow']==2)
			{
				$sql="insert into ".DB_PREFIX."socialmediacontent set
				client_id=".$client_id.",
				tw_content='".$this->setVal(trim($this->readValueSubmission($post['tcontent'])))."',
				created_by=".$this->created_by.",
				created_date='".currentScriptDate()."',
				updated_by=".$this->updated_by.",
				updated_date='".currentScriptDate()."'";
			}
			else if($post['currentshow']==3)
			{
				$sql="insert into ".DB_PREFIX."socialmediacontent set
				client_id=".$client_id.",
				google_title='".$this->setVal(trim($this->readValueSubmission($post['gtitle'])))."',
				google_content='".$this->setVal(trim($this->readValueSubmission($post['gcontent'])))."',
				created_by=".$this->created_by.",
				created_date='".currentScriptDate()."',
				updated_by=".$this->updated_by.",
				updated_date='".currentScriptDate()."'";
			}
			else if($post['currentshow']==4)
			{
				$sql="insert into ".DB_PREFIX."socialmediacontent set
				client_id=".$client_id.",
				tumblr_title='".$this->setVal(trim($this->readValueSubmission($post['tumblrtitle'])))."',
				tumblr_content='".$this->setVal(trim($this->readValueSubmission($post['tucontent'])))."',
				created_by=".$this->created_by.",
				created_date='".currentScriptDate()."',
				updated_by=".$this->updated_by.",
				updated_date='".currentScriptDate()."'";
			}			
			
			$res=mysql_query($sql);			
		}
		
		return $res;		
	}
	function updatecontent($post,$client_id=0)
	{
		$sql = "update ".DB_PREFIX."socialmediacontent set
			fb_content='".$this->setVal(trim($this->readValueSubmission($post['fcontent'])))."',
			tw_content='".$this->setVal(trim($this->readValueSubmission($post['tcontent'])))."',
			tumblr_title='".$this->setVal(trim($this->readValueSubmission($post['tumblrtitle'])))."',
			tumblr_content='".$this->setVal(trim($this->readValueSubmission($post['tucontent'])))."',
			google_title='".$this->setVal(trim($this->readValueSubmission($post['gtitle'])))."',
			google_content='".$this->setVal(trim($this->readValueSubmission($post['gcontent'])))."',
			updated_by=".$this->updated_by.",
			updated_date='".currentScriptDate()."'			
			where client_id=".$client_id;
			
		$res = mysql_query($sql);
		return $res;		
	}
}
?>