<?php
class poll_booth extends common
{
	var $poll_booth_id;
	var $state_id;
	var $poll_booth_for;
	var $poll_booth_country;
	var $official_title;
	var $building_name;
	var $poll_booth_address1;
	var $poll_booth_address2;
	var $poll_booth_city;
	var $poll_booth_zipcode;
	var $poll_booth_phone;
	var $poll_booth_fax;
	var $url;
	var $poll_booth_url;
	var $poll_booth_active;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;	
	var $state_code;
	var $state_name;
	var $pagingType;
	var $defaultlanguage_id;
		
	function poll_booth()
	{
		$this->poll_booth_id = 0;
		$this->state_id = 0;
		$this->poll_booth_for = 1;
		$this->poll_booth_country = "";
		$this->official_title = "";
		$this->building_name = "";
		$this->poll_booth_address1 = "";
		$this->poll_booth_address2 = "";
		$this->poll_booth_city = "";
		$this->poll_booth_zipcode = "";
		$this->poll_booth_phone = "";
		$this->poll_booth_fax = "";
		$this->url = "";
		$this->poll_booth_url = "";
		$this->poll_booth_active = 1;
		$this->state_code = "";
		$this->state_name = "";		
		$this->defaultlanguage_id =1;
	}

	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="poll_booth_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and poll_booth_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", poll_booth_id desc";
		}
		
		$strquery="SELECT pba.*,s.state_name,s.state_code FROM ".DB_PREFIX."poll_booth_address pba, ".DB_PREFIX."state s WHERE 1=1 AND pba.state_id = s.state_id " . $condition . $order;
		
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	function fetchRecordSetReport($id="",$condition="",$order="poll_booth_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and poll_booth_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", poll_booth_id desc";
		}
				
		$strquery="SELECT pba.poll_booth_id, pba.state_id, if(pbal.official_title = '' OR pbal.official_title IS NULL, pba.official_title, pbal.official_title) as official_title,	if(pbal.building_name = '' OR pbal.building_name IS NULL, pba.building_name, pbal.building_name) as building_name, if(pbal.poll_booth_address1 = '' OR pbal.poll_booth_address1 IS NULL, pba.poll_booth_address1, pbal.poll_booth_address1) as poll_booth_address1, if(pbal.poll_booth_address2 = '' OR pbal.poll_booth_address2 IS NULL, pba.poll_booth_address2, pbal.poll_booth_address2) as poll_booth_address2, if(pbal.poll_booth_city = '' OR pbal.poll_booth_city IS NULL, pba.poll_booth_city, pbal.poll_booth_city) as poll_booth_city, pba.poll_booth_zipcode, pba.poll_booth_phone, pba.poll_booth_fax, pba.url, pba.poll_booth_url, s.state_code, if(sl.state_name = '' OR sl.state_name IS NULL, s.state_name, sl.state_name) as state_name FROM ".DB_PREFIX."poll_booth_address pba left join ".DB_PREFIX."poll_booth_address_language as pbal on pbal.poll_booth_id = pba.poll_booth_id and pbal.language_id = '".$this->language_id."', ".DB_PREFIX."state s left join ".DB_PREFIX."state_language as sl on sl.state_id = s.state_id and sl.language_id = '".$this->language_id."' WHERE 1=1 AND pba.state_id = s.state_id " . $condition . $order;
		
		$rs=mysql_query($strquery);
		
		return $rs;
	}
	
	function fetchAllAsArray($id = "",$condition = "",$order = "poll_booth_id")
	{		
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", poll_booth_id desc";
		}
		
		 $strquery="SELECT pba.*,s.state_name,s.state_code FROM ".DB_PREFIX."poll_booth_address pba, ".DB_PREFIX."state s WHERE 1=1 AND pba.state_id = s.state_id " . $condition . $order;
		
		$rs=mysql_query($strquery);
		$i=0;
		$arrlist = array();
		while($areligibility= mysql_fetch_array($rs))
		{
			$arrlist[$i]["poll_booth_id"] = $areligibility["poll_booth_id"];
			$arrlist[$i]["state_id"] = $areligibility["state_id"];
			$arrlist[$i]["state_code"] = $areligibility["state_code"];
			$arrlist[$i]["state_name"] = $areligibility["state_name"];
			$arrlist[$i]["poll_booth_for"] = $areligibility["poll_booth_for"];
			$arrlist[$i]["poll_booth_country"] = $areligibility["poll_booth_country"];
			$arrlist[$i]["official_title"] = $areligibility["official_title"];
			$arrlist[$i]["building_name"] = $areligibility["building_name"];
			$arrlist[$i]["poll_booth_address1"] = $areligibility["poll_booth_address1"];
			$arrlist[$i]["poll_booth_address2"] = $areligibility["poll_booth_address2"];
			$arrlist[$i]["poll_booth_city"] = $areligibility["poll_booth_city"];
			$arrlist[$i]["poll_booth_zipcode"] = $areligibility["poll_booth_zipcode"];
			$arrlist[$i]["poll_booth_phone"] = $areligibility["poll_booth_phone"];
			$arrlist[$i]["poll_booth_fax"] = $areligibility["poll_booth_fax"];
			$arrlist[$i]["url"] = $areligibility["url"];
			$arrlist[$i]["poll_booth_url"] = $areligibility["poll_booth_url"];
			$arrlist[$i]["poll_booth_active"] = $areligibility["poll_booth_active"];
			
			$i++;
		}
		return $arrlist;
	}
	
	//Function to get particular field value
	function fieldValue($field="poll_booth_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchRecordSet($id, $condition, $order);
		$ret=0;
		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$field];
		}
		return $ret;
	}
	
	//Function to add recordset of table
	function addPollBooth()
	{
		$strQuery="INSERT INTO ".DB_PREFIX."poll_booth_address 
					(state_id, poll_booth_for, poll_booth_country, official_title, building_name, poll_booth_address1, poll_booth_address2, poll_booth_city, poll_booth_zipcode, poll_booth_phone, poll_booth_fax, url, poll_booth_url, poll_booth_active, created_by, created_date, updated_by, updated_date) 
		  values('".$this->state_id."', '".$this->poll_booth_for."', '".$this->poll_booth_country."', '".$this->official_title."', '".$this->building_name."', '".$this->poll_booth_address1."', '".$this->poll_booth_address2."', '".$this->poll_booth_city."', '".$this->poll_booth_zipcode."', '".$this->poll_booth_phone."', '".$this->poll_booth_fax."', '".$this->url."', '".$this->poll_booth_url."', '".$this->poll_booth_active."', '".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";

		mysql_query($strQuery) or die(mysql_error());
		$this->poll_booth_id = mysql_insert_id();
		return mysql_insert_id();
	}
	
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		$i=0;

		while($arec= mysql_fetch_array($rs))
		{
			$this->poll_booth_id = $arec["poll_booth_id"];			
			$this->state_id = $arec["state_id"];
			$this->state_code = $arec["state_code"];
			$this->state_name = $arec["state_name"];
			$this->poll_booth_for = $arec["poll_booth_for"];
			$this->poll_booth_country = $arec["poll_booth_country"];
			$this->official_title = $arec["official_title"];
			$this->building_name = $arec["building_name"];
			$this->poll_booth_address1 = $arec["poll_booth_address1"];
			$this->poll_booth_address2 = $arec["poll_booth_address2"];
			$this->poll_booth_city = $arec["poll_booth_city"];
			$this->poll_booth_zipcode = $arec["poll_booth_zipcode"];
			$this->poll_booth_phone = $arec["poll_booth_phone"];
			$this->poll_booth_fax = $arec["poll_booth_fax"];
			$this->url = $arec["url"];
			$this->poll_booth_url = $arec["poll_booth_url"];
			$this->poll_booth_active = $arec["poll_booth_active"];
			
			$i++;
		}		
	}
	
	//Function to update recordset of table
	function updatePollBooth()
	{		
		$strQuery="UPDATE ".DB_PREFIX."poll_booth_address SET
					state_id = '".$this->state_id."', 										
					poll_booth_for = '".$this->poll_booth_for."', 										
					poll_booth_country = '".$this->poll_booth_country."', 										
					official_title = '".$this->official_title."', 										
					building_name = '".$this->building_name."', 										
					poll_booth_address1 = '".$this->poll_booth_address1."', 										
					poll_booth_address2 = '".$this->poll_booth_address2."', 										
					poll_booth_city = '".$this->poll_booth_city."', 										
					poll_booth_zipcode = '".$this->poll_booth_zipcode."', 										
					poll_booth_phone = '".$this->poll_booth_phone."', 										
					poll_booth_fax = '".$this->poll_booth_fax."', 										
					url = '".$this->url."', 										
					poll_booth_url = '".$this->poll_booth_url."', 										
					poll_booth_active = '".$this->poll_booth_active."', 										
					updated_by = '".$this->updated_by."', 
					updated_date = '".currentScriptDate()."' 
					WHERE poll_booth_id='".$this->poll_booth_id."'";
					
		mysql_query($strQuery) or die(mysql_error());
		return 1;	
	}
	
	//Function to delete record from table
	function deletePollBooth($poll_booth_id) 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."poll_booth_address WHERE poll_booth_id =".$poll_booth_id;
		return $this->runquery($sQuery);
	}	
	
	function fetchPollBoothLanguage()
	{			
		$strquery="SELECT * FROM ".DB_PREFIX."poll_booth_address_language WHERE 1=1 AND poll_booth_id='".$this->poll_booth_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		$i = 0;
		while($artf_eclanguage = mysql_fetch_array($rs))
		{
			$arrList[$i] = $artf_eclanguage['language_id'];
			$i++;
		}
		
		return $arrList;
	}
	
	function fetchPollBoothLanguageDetail()
	{
		$strquery="SELECT * FROM ".DB_PREFIX."poll_booth_address_language WHERE 1=1 AND poll_booth_id='".$this->poll_booth_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_eclanguage = mysql_fetch_array($rs))
			{
				$arrList[$artf_eclanguage['language_id']]["official_title"] = $artf_eclanguage['official_title'];
				$arrList[$artf_eclanguage['language_id']]["building_name"] = $artf_eclanguage['building_name'];				
				$arrList[$artf_eclanguage['language_id']]["poll_booth_address1"] = $artf_eclanguage['poll_booth_address1'];
				$arrList[$artf_eclanguage['language_id']]["poll_booth_address2"] = $artf_eclanguage['poll_booth_address2'];
				$arrList[$artf_eclanguage['language_id']]["poll_booth_city"] = $artf_eclanguage['poll_booth_city'];
			}
		}
		return $arrList;
	}
	
	
	function createLanguageDetailForPollBooth($language_id)
	{
		$strquery="SELECT poll_booth_language_id FROM ".DB_PREFIX."poll_booth_address_language WHERE 1=1 AND poll_booth_id='".$this->poll_booth_id."' AND language_id='".$language_id."'";
		
		$rs=mysql_query($strquery);
		
		if(mysql_num_rows($rs)==0)
		{
			$strQuery="INSERT INTO ".DB_PREFIX."poll_booth_address_language 
					(poll_booth_id, language_id, official_title, building_name, poll_booth_address1, poll_booth_address2, poll_booth_city, created_by, created_date, updated_by, updated_date) 
		 	 values('".$this->poll_booth_id."','".$language_id."','".$this->official_title."','".$this->building_name."','".$this->poll_booth_address1."','".$this->poll_booth_address2."','".$this->poll_booth_city."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
		}
		else
		{
			$strQuery="UPDATE ".DB_PREFIX."poll_booth_address_language SET
					official_title='".$this->official_title."', 
					building_name='".$this->building_name."', 
					poll_booth_address1='".$this->poll_booth_address1."', 
					poll_booth_address2='".$this->poll_booth_address2."', 
					poll_booth_city='".$this->poll_booth_city."', 
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE 1=1 AND poll_booth_id='".$this->poll_booth_id."' AND language_id='".$language_id."'";
			mysql_query($strQuery) or die(mysql_error());
		}		
	}
	
	function deleteLanguageDetailForPollBooth($language_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."poll_booth_address_language WHERE 1=1 AND poll_booth_id='".$this->poll_booth_id."' AND language_id='".$language_id."'";
		mysql_query($strquery);
	}
	
	function deleteAllLanguageDetailForIdNumber($id_number_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."poll_booth_address_language WHERE 1=1 AND poll_booth_id='".$id_number_id."'";
		mysql_query($strquery);
	}
}
?>