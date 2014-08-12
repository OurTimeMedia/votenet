<?php
class state extends common
{
	var $state_id;
	var $state_code;
	var $state_name;
	var $state_secretary_fname;
	var $state_secretary_mname;
	var $state_secretary_lname;
	var $state_address1;
	var $state_address2;
	var $state_city;
	var $zipcode;
	var $hotlineno;
	var $tollfree;
	var $phoneno;
	var $faxno;
	var $email;
	var $state_active;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;
	var $defaultlanguage_id;
	var $language_id;
	
		
	function state()
	{
		$this->state_id = 0;
		$this->state_code = "";
		$this->state_name = "";
		$this->state_secretary_fname = "";
		$this->state_secretary_mname = "";
		$this->state_secretary_lname = "";
		$this->state_address1 = "";
		$this->state_address2 = "";
		$this->state_city = "";
		$this->zipcode = "";
		$this->hotlineno = "";
		$this->tollfree = "";
		$this->phoneno = "";
		$this->faxno = "";
		$this->email = "";
		$this->state_active = 1;		
		$this->defaultlanguage_id =1;
	}

	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="state_id",$join="")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and state_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", ".DB_PREFIX."state.state_id desc";
		}
		
		 $strquery="SELECT * FROM ".DB_PREFIX."state ".$join."  WHERE 1=1 " . $condition . $order;
//		 echo $strquery;
		$rs=mysql_query($strquery);
		return $rs;
	}
	function findhomestate($condition,$order="state_name")
	{
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by ".DB_PREFIX."state_zipcode.".$order." desc";
		}
		
		$query="select * from ".DB_PREFIX."state_zipcode
		left join ".DB_PREFIX."state on ".DB_PREFIX."state.state_code=".DB_PREFIX."state_zipcode.state
		where 1=1 ".$condition.$order;
				
		$rs=mysql_query($query);
		$i=0;
		$arrlist = array();
		while($arstate= mysql_fetch_array($rs))
		{
			$arrlist[$i]["state_id"] = $arstate["state_id"];
			$arrlist[$i]["state_code"] = $arstate["state_code"];
			$arrlist[$i]["state_name"] = $arstate["state_name"];
			$arrlist[$i]["state_active"] = $arstate["state_active"];
			$i++;
		}
		return $arrlist;
	}
	function fetchAllAsArray($id = "",$condition = "",$order = "state_name")
	{		
		$arrlist = array();
		 $sQuery = "SELECT * FROM ".DB_PREFIX."state 
		WHERE 1 = 1 " . $condition ." order by  ". $order;
		
		$rs=mysql_query($sQuery);
		$i=0;
		while($arstate= mysql_fetch_array($rs))
		{
			$arrlist[$i]["state_id"] = $arstate["state_id"];
			$arrlist[$i]["state_code"] = $arstate["state_code"];
			$arrlist[$i]["state_name"] = $arstate["state_name"];
			$arrlist[$i]["state_active"] = $arstate["state_active"];
		
			$i++;
		}
		
		return $arrlist;
	}
	
	function fetchAllAsArrayFront($id = "",$condition = "",$order = "state_name")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($id) && trim($id)!="") $and .= " AND s.state_id = " . $id;
				
		$strquery="SELECT s.*, if(sl.state_name is NULL or sl.state_name = '', s.state_name, sl.state_name) as langstate_name FROM ".DB_PREFIX."state s LEFT JOIN ".DB_PREFIX."state_language sl ON ( sl.state_id=s.state_id AND language_id='".$this->language_id."') WHERE 1=1 " . $and . " ORDER BY ".$order;
		//echo $strquery;
		$rs=mysql_query($strquery);		
		
		while($arstate= mysql_fetch_array($rs))
		{
			$arrlist[$i]["state_id"] = $arstate["state_id"];
			$arrlist[$i]["state_code"] = $arstate["state_code"];
			$arrlist[$i]["state_name"] = $arstate["langstate_name"];
			$arrlist[$i]["state_active"] = $arstate["state_active"];
			$i++;
		}
		return $arrlist;
	}
	
	function fetchAllAsArrayLanguage($languageid = "",$condition = "",$order = "state_id")
	{		
		$arrlist = array();
		$sQuery = "SELECT if(".DB_PREFIX."state_language.state_name='' OR ".DB_PREFIX."state_language.state_name is NULL,".DB_PREFIX."state.state_name,".DB_PREFIX."state_language.state_name) as statename ,".DB_PREFIX."state.* FROM ".DB_PREFIX."state 
		left join ".DB_PREFIX."state_language on (".DB_PREFIX."state.state_id=".DB_PREFIX."state_language.state_id and ".DB_PREFIX."state_language.language_id=".$languageid." )
		WHERE 1 = 1 " . $condition ." order by  ".DB_PREFIX."state.". $order;
		
		$rs=mysql_query($sQuery);
		$i=0;
		while($arstate= mysql_fetch_array($rs))
		{
			$arrlist[$i]["state_id"] = $arstate["state_id"];
			$arrlist[$i]["state_code"] = $arstate["state_code"];
			$arrlist[$i]["state_name"] = $arstate["statename"];
			$arrlist[$i]["state_active"] = $arstate["state_active"];
			$i++;
		}
		return $arrlist;
	}
	
	function fetchStateAddressInfoFront($languageid = "",$condition = "",$order = "state_id")
	{		
		$arrlist = array();
		$sQuery = "SELECT s.state_id, s.state_code, if(sl.state_name='' OR sl.state_name is NULL,s.state_name,sl.state_name) as statename,
		if(sl.state_secretary_fname ='' OR sl.state_secretary_fname is NULL,s.state_secretary_fname,sl.state_secretary_fname) as state_secretary_fname,
		if(sl.state_secretary_mname ='' OR sl.state_secretary_mname is NULL,s.state_secretary_mname,sl.state_secretary_mname) as state_secretary_mname,
		if(sl.state_secretary_lname ='' OR sl.state_secretary_lname is NULL,s.state_secretary_lname,sl.state_secretary_lname) as state_secretary_lname,
		if(sl.state_address1 ='' OR sl.state_address1 is NULL,s.state_address1,sl.state_address1) as state_address1,
		if(sl.state_address2 ='' OR sl.state_address2 is NULL,s.state_address2,sl.state_address2) as state_address2,
		if(sl.state_city='' OR sl.state_city is NULL,s.state_city,sl.state_city) as state_city,
		s.zipcode FROM ".DB_PREFIX."state s 
		left join ".DB_PREFIX."state_language sl on (s.state_id=sl.state_id and sl.language_id=".$languageid." )
		WHERE 1 = 1 " . $condition ." order by  s.". $order;
		
		//echo $sQuery;
		
		$rs=mysql_query($sQuery);
		$i=0;
		while($arstate= mysql_fetch_array($rs))
		{
			$arrlist[$i]["state_id"] = $arstate["state_id"];
			$arrlist[$i]["state_code"] = $arstate["state_code"];
			$arrlist[$i]["state_name"] = $arstate["statename"];		
			$arrlist[$i]["state_secretary_fname"] = $arstate["state_secretary_fname"];		
			$arrlist[$i]["state_secretary_mname"] = $arstate["state_secretary_mname"];		
			$arrlist[$i]["state_secretary_lname"] = $arstate["state_secretary_lname"];		
			$arrlist[$i]["state_address1"] = $arstate["state_address1"];		
			$arrlist[$i]["state_address2"] = $arstate["state_address2"];		
			$arrlist[$i]["state_city"] = $arstate["state_city"];		
			$arrlist[$i]["zipcode"] = $arstate["zipcode"];		
			$i++;
		}
		return $arrlist;
	}
	//Function to get particular field value
	function fieldValue($field="state_id",$id="",$condition="",$order="")
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
	function addstate()
	{
		$strQuery="INSERT INTO ".DB_PREFIX."state 
					(state_code, state_name, state_secretary_fname, state_secretary_mname, state_secretary_lname,
					state_address1, state_address2, state_city, zipcode,
					hotlineno, tollfree, phoneno, faxno, email, state_active, created_by, created_date, updated_by, updated_date) 
		  values('".$this->state_code."','".$this->state_name."','".$this->state_secretary_fname."',
				 '".$this->state_secretary_mname."','".$this->state_secretary_lname."','".$this->state_address1."','".$this->state_address2."',
				 '".$this->state_city."','".$this->zipcode."','".$this->hotlineno."','".$this->tollfree."', '".$this->phoneno."','".$this->faxno."','".$this->email."','".$this->state_active."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
			$this->state_id = mysql_insert_id();
			return mysql_insert_id();
	}
	
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		$i=0;

		while($arstate= mysql_fetch_array($rs))
		{
			$this->state_id = $arstate["state_id"];
			$this->state_code = $arstate["state_code"];
			$this->state_name = $arstate["state_name"];
			$this->state_secretary_fname = $arstate["state_secretary_fname"];
			$this->state_secretary_mname = $arstate["state_secretary_mname"];
			$this->state_secretary_lname = $arstate["state_secretary_lname"];
			$this->state_address1 = $arstate["state_address1"];
			$this->state_address2 = $arstate["state_address2"];
			$this->state_city = $arstate["state_city"];
			$this->zipcode = $arstate["zipcode"];
			$this->hotlineno = $arstate["hotlineno"];
			$this->tollfree = $arstate["tollfree"];
			$this->phoneno = $arstate["phoneno"];
			$this->faxno = $arstate["faxno"];
			$this->email = $arstate["email"];
			$this->state_minimum_age_criteria = $arstate["state_minimum_age_criteria"];
			$this->state_minimum_age_criteria_election_type = $arstate["state_minimum_age_criteria_election_type"];
			$this->state_minimum_age_text = $arstate["state_minimum_age_text"];
			$this->state_active = $arstate["state_active"];			
			$i++;
		}		
	}
	
	//Function to update recordset of table
	function updatestate()
	{		
		$strQuery="UPDATE ".DB_PREFIX."state SET
					state_code = '".$this->state_code."', 
					state_name = '".$this->state_name."', 
					state_secretary_fname = '".$this->state_secretary_fname."', 
					state_secretary_mname = '".$this->state_secretary_mname."', 
					state_secretary_lname = '".$this->state_secretary_lname."', 
					state_address1 = '".$this->state_address1."', 
					state_address2 = '".$this->state_address2."', 
					state_city = '".$this->state_city."',
					zipcode = '".$this->zipcode."', 
					hotlineno = '".$this->hotlineno."', 
					tollfree = '".$this->tollfree."', 
					phoneno = '".$this->phoneno."', 
					faxno = '".$this->faxno."',
					email = '".$this->email."', 
					state_active = '".$this->state_active."', 
					updated_by = '".$this->updated_by."', 
					updated_date = '".currentScriptDate()."' 
					WHERE state_id='".$this->state_id."'";
	  			    mysql_query($strQuery) or die(mysql_error());
					return 1;	
	}
	
	//Function to delete record from table
	function deletestate($state_id) 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."state  WHERE state_id =".$state_id;
		return $this->runquery($sQuery);
	}
	
	function createLanguageDetailForState($language_id)
	{
		$strquery="SELECT state_language_id FROM ".DB_PREFIX."state_language WHERE 1=1 AND state_id='".$this->state_id."' AND language_id='".$language_id."'";
		$rs=mysql_query($strquery);
		if(mysql_num_rows($rs)==0)
		{
			 $strQuery="INSERT INTO ".DB_PREFIX."state_language 
					(state_id, language_id, state_name, state_secretary_fname, state_secretary_mname, state_secretary_lname, state_address1, state_address2, state_city, created_by, created_date, updated_by, updated_date) 
		 	 values('".$this->state_id."','".$language_id."','".$this->state_name."','".$this->state_secretary_fname."','".$this->state_secretary_mname."','".$this->state_secretary_lname."','".$this->state_address1."','".$this->state_address2."','".$this->state_city."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
		}
		else
		{
			 $strQuery="UPDATE ".DB_PREFIX."state_language SET
					state_name='".$this->state_name."', 
					state_secretary_fname='".$this->state_secretary_fname."', 
					state_secretary_mname='".$this->state_secretary_mname."',
					state_secretary_lname='".$this->state_secretary_lname."',
					state_address1='".$this->state_address1."',
					state_address2='".$this->state_address2."',
					state_city='".$this->state_city."',
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE 1=1 AND state_id='".$this->state_id."' AND language_id='".$language_id."'";
			mysql_query($strQuery) or die(mysql_error());
		}
	}
	
	function fetchStateLanguage()
	{			
		$strquery="SELECT * FROM ".DB_PREFIX."state_language WHERE 1=1 AND state_id='".$this->state_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		$i = 0;
		while($artf_statelanguage = mysql_fetch_array($rs))
		{
			$arrList[$i] = $artf_statelanguage['language_id'];
			$i++;
		}
		
		return $arrList;
	}
	
	function deleteLanguageDetailForState($language_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."state_language WHERE 1=1 AND state_id='".$this->state_id."' AND language_id='".$language_id."'";
		mysql_query($strquery);
	}
	
	function deleteAllLanguageDetailForState($state_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."state_language WHERE 1=1 AND state_id='".$state_id."'";
		mysql_query($strquery);
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$sQuery	 = 	"UPDATE ".DB_PREFIX."state SET state_active = 'n' WHERE state_id =".$this->state_id;
		return $this->runquery($sQuery);
	}
	
	function fetchStateLanguageDetail()
	{
		$strquery="SELECT * FROM ".DB_PREFIX."state_language WHERE 1=1 AND state_id='".$this->state_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_statelanguage = mysql_fetch_array($rs))
			{
				$arrList[$artf_statelanguage['language_id']]["state_name"] = $artf_statelanguage['state_name'];
				$arrList[$artf_statelanguage['language_id']]["state_secretary_fname"] = $artf_statelanguage['state_secretary_fname'];
				$arrList[$artf_statelanguage['language_id']]["state_secretary_mname"] = $artf_statelanguage['state_secretary_mname'];
				$arrList[$artf_statelanguage['language_id']]["state_secretary_lname"] = $artf_statelanguage['state_secretary_lname'];
				$arrList[$artf_statelanguage['language_id']]["state_address1"] = $artf_statelanguage['state_address1'];	
				$arrList[$artf_statelanguage['language_id']]["state_address2"] = $artf_statelanguage['state_address2'];	
				$arrList[$artf_statelanguage['language_id']]["state_city"] = $artf_statelanguage['state_city'];				
				$arrList[$artf_statelanguage['language_id']]["state_minimum_age_text"] = $artf_statelanguage['state_minimum_age_text'];				
			}
		}
		return $arrList;
	}
	
	//Function to update recordset of table
	function updateMinimumAgeDetail()
	{		
		$strQuery="UPDATE ".DB_PREFIX."state SET
					state_minimum_age_criteria = '".$this->state_minimum_age_criteria."', 
					state_minimum_age_criteria_election_type = '".$this->state_minimum_age_criteria_election_type."', 
					state_minimum_age_text = '".$this->state_minimum_age_text."'
					WHERE state_id='".$this->state_id."'";
	  	mysql_query($strQuery) or die(mysql_error());
		return 1;	
	}
	
	function updateMinimumAgeDetailLanguage()
	{		
		$strQuery="UPDATE ".DB_PREFIX."state_language SET
					state_minimum_age_text = '".$this->state_minimum_age_text."'
					WHERE state_id='".$this->state_id."' AND language_id='".$this->language_id."'";
	  	mysql_query($strQuery) or die(mysql_error());
		return 1;	
	}
}