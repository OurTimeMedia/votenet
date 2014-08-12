<?php
class race_group extends common
{
	var $race_group_id;
	var $race_group_name;
	var $race_group_active;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;
	var $defaultlanguage_id;
		
	function race_group()
	{
		$this->race_group_id = 0;
		$this->race_group_name = "";
		$this->race_group_active = 1;		
		$this->defaultlanguage_id =1;
	}

	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="race_group_name")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and race_group_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", race_group_id desc";
		}
		
		$strquery="SELECT * FROM ".DB_PREFIX."race_group WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	function fetchAllAsArray($id = "",$condition = "",$order = "race_group_name")
	{		
		$arrlist = array();
		$sQuery = "SELECT * FROM ".DB_PREFIX."race_group 
		WHERE 1 = 1 " . $condition ." order by  ". $order;
		
		$rs=mysql_query($sQuery);
		$i=0;
		while($arrace_group= mysql_fetch_array($rs))
		{
			$arrlist[$i]["race_group_id"] = $arrace_group["race_group_id"];
			$arrlist[$i]["race_group_name"] = $arrace_group["race_group_name"];
			$arrlist[$i]["race_group_active"] = $arrace_group["race_group_active"];
		
			$i++;
		}
		
		return $arrlist;
	}
	
	//Function to get particular field value
	function fieldValue($field="race_group_id",$id="",$condition="",$order="")
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
	function addrace_group()
	{
		$strQuery="INSERT INTO ".DB_PREFIX."race_group 
					(race_group_name, race_group_active, created_by, created_date, updated_by, updated_date) 
		  values('".$this->race_group_name."','".$this->race_group_active."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
			$this->race_group_id = mysql_insert_id();
			return mysql_insert_id();
	}
	
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		$i=0;

		while($arrace_group= mysql_fetch_array($rs))
		{
			$this->race_group_id = $arrace_group["race_group_id"];
			$this->race_group_name = $arrace_group["race_group_name"];
			$this->race_group_active = $arrace_group["race_group_active"];			
			$i++;
		}		
	}
	
	//Function to update recordset of table
	function updaterace_group()
	{		
		$strQuery="UPDATE ".DB_PREFIX."race_group SET
					race_group_name = '".$this->race_group_name."', 
					race_group_active = '".$this->race_group_active."', 
					updated_by = '".$this->updated_by."', 
					updated_date = '".currentScriptDate()."' 
					WHERE race_group_id='".$this->race_group_id."'";
	  			    mysql_query($strQuery) or die(mysql_error());
					return 1;	
	}
	
	//Function to delete record from table
	function deleterace_group($race_group_id) 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."race_group  WHERE race_group_id =".$race_group_id;
		return $this->runquery($sQuery);
	}
	
	function createLanguageDetailForRaceGroup($language_id)
	{
		$strquery="SELECT race_group_language_id FROM ".DB_PREFIX."race_group_language WHERE 1=1 AND race_group_id='".$this->race_group_id."' AND language_id='".$language_id."'";
		$rs=mysql_query($strquery);
		if(mysql_num_rows($rs)==0)
		{
			$strQuery="INSERT INTO ".DB_PREFIX."race_group_language 
					(race_group_id, language_id, race_group_name, created_by, created_date, updated_by, updated_date) 
		 	 values('".$this->race_group_id."','".$language_id."','".$this->race_group_name."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
		}
		else
		{
			$strQuery="UPDATE ".DB_PREFIX."race_group_language SET
					race_group_name='".$this->race_group_name."', 
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE 1=1 AND race_group_id='".$this->race_group_id."' AND language_id='".$language_id."'";
			mysql_query($strQuery) or die(mysql_error());
		}
	}
	
	function fetchRaceGroupLanguage()
	{			
		$strquery="SELECT * FROM ".DB_PREFIX."race_group_language WHERE 1=1 AND race_group_id='".$this->race_group_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		$i = 0;
		while($artf_race_grouplanguage = mysql_fetch_array($rs))
		{
			$arrList[$i] = $artf_race_grouplanguage['language_id'];
			$i++;
		}
		
		return $arrList;
	}
	
	function deleteLanguageDetailForRaceGroup($language_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."race_group_language WHERE 1=1 AND race_group_id='".$this->race_group_id."' AND language_id='".$language_id."'";
		mysql_query($strquery);
	}
	
	function deleteAllLanguageDetailForRaceGroup($race_group_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."race_group_language WHERE 1=1 AND race_group_id='".$race_group_id."'";
		mysql_query($strquery);
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$sQuery	 = 	"UPDATE ".DB_PREFIX."race_group SET race_group_active = 'n' WHERE race_group_id =".$this->race_group_id;
		return $this->runquery($sQuery);
	}
	
	function fetchRaceGroupLanguageDetail()
	{
		$strquery="SELECT * FROM ".DB_PREFIX."race_group_language WHERE 1=1 AND race_group_id='".$this->race_group_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_race_grouplanguage = mysql_fetch_array($rs))
			{
				$arrList[$artf_race_grouplanguage['language_id']]["race_group_name"] = $artf_race_grouplanguage['race_group_name'];				
			}
		}
		return $arrList;
	}
}