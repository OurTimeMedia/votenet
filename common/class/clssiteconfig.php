<?php
class siteconfig
{
	//Property
	var $site_config_id;
	var $site_config_name;
	var $site_config_url;
	var $site_config_email;
	var $site_config_email_from_name;
	var $site_config_mode;
	var $site_config_recipient_email;
	var $site_config_isonline;
	var $site_config_offline_message;
	var $pagingType;
	var $checkedids;
	var $uncheckedids;

	function siteConfig()
	{
		$this->setAllValues(1);
		if ($GLOBALS["scope"] == "client")
		{
			$cmn = new common();
			// Check if site is Offline/Online. If site is offline then only admin users who has access to view member profile can login front side.
			if ($this->site_config_isonline == SITE_OFFLINE && ($cmn->isAdminLoggedin()!=1 || $cmn->isClientLoggedin()!=1))
			{
				$msg = new message();
				$msg->clearMsg();
				$template_body = $cmn->getFileContent(TEMPLATE_DIR . TEMPLATE_SITE_OFFLINE);
				$template_body = eregi_replace("[\]",'',$template_body);	
				$template_body = str_replace("##site_name##", $this->site_config_name, $template_body);
				$template_body = str_replace("##offline_message##", $this->site_config_offline_message, $template_body);
				$template_body = str_replace("images", $this->site_config_url."/images", $template_body);
				print $template_body;
				exit;
			}
		}
	}
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$cond="",$ord="site_config_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$cond = " and site_config_id=". $id .$cond;
		}
		if($ord!="" && $ord!= NULL && is_null($ord)==false)
		{
			$ord = " order by " . $ord;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."site_config WHERE 1=1 " . $cond . $ord;
		//echo $strquery;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL)
	{
		$arrlist = array();
		$i = 0;
		$and = "";
		if(!is_null($intid))$and .= " AND site_config_id = " . $intid;
		if(!is_null($stralphabet))	$and .= " AND site_config_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."site_config WHERE 1=1 " . $and . " ORDER BY site_config_id";
		$rs=mysql_query($strquery);
		while($arsite_config= mysql_fetch_array($rs))
		{
			$arrlist[$i]["site_config_id"] = $arsite_config["site_config_id"];
			$arrlist[$i]["site_config_name"] = $arsite_config["site_config_name"];
			$arrlist[$i]["site_config_url"] = $arsite_config["site_config_url"];
			$arrlist[$i]["site_config_email"] = $arsite_config["site_config_email"];
			$arrlist[$i]["site_config_email_from_name"] = $arsite_config["site_config_email_from_name"];
			$arrlist[$i]["site_config_mode"] = $arsite_config["site_config_mode"];
			$arrlist[$i]["site_config_recipient_email"] = $arsite_config["site_config_recipient_email"];
			$arrlist[$i]["site_config_isonline"] = $arsite_config["site_config_isonline"];
			$arrlist[$i]["site_config_offline_message"] = $arsite_config["site_config_offline_message"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$cond="")
	{
		$rs=$this->fetchRecordSet($id, $cond);
		if($arsite_config= mysql_fetch_array($rs))
		{
			$this->site_config_id = $arsite_config["site_config_id"];
			$this->site_config_name = $arsite_config["site_config_name"];
			$this->site_config_url = $arsite_config["site_config_url"];
			$this->site_config_email = $arsite_config["site_config_email"];
			$this->site_config_email_from_name = $arsite_config["site_config_email_from_name"];
			$this->site_config_mode = $arsite_config["site_config_mode"];
			$this->site_config_recipient_email = $arsite_config["site_config_recipient_email"];
			$this->site_config_isonline = $arsite_config["site_config_isonline"];
			$this->site_config_offline_message = $arsite_config["site_config_offline_message"];
		}
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."site_config SET site_config_id='".$this->site_config_id."', site_config_name='".$this->site_config_name."', site_config_url='".$this->site_config_url."', site_config_email='".$this->site_config_email."', site_config_email_from_name='".$this->site_config_email_from_name."', site_config_mode='".$this->site_config_mode."', site_config_recipient_email='".$this->site_config_recipient_email."' WHERE site_config_id=".$this->site_config_id;
		return mysql_query($strquery) or die(mysql_error());
	}
	
	//Function to update record of table
	function updateOffline() 
	{
		$strquery="UPDATE ".DB_PREFIX."site_config SET site_config_isonline='".$this->site_config_isonline."', site_config_offline_message='".$this->site_config_offline_message."' WHERE site_config_id=".$this->site_config_id;
		return mysql_query($strquery) or die(mysql_error());
	}
}
?>