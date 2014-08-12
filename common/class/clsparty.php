<?php
class party extends common
{
	var $party_id;
	var $party_name;
	var $party_active;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;
	var $defaultlanguage_id;
		
	function party()
	{
		$this->party_id = 0;
		$this->party_name = "";
		$this->party_active = 1;		
		$this->defaultlanguage_id =1;
	}

	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="party_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and party_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", party_id desc";
		}
		
		$strquery="SELECT * FROM ".DB_PREFIX."party WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	function fetchAllAsArray($id = "",$condition = "",$order = "party_name")
	{		
		$arrlist = array();
		$sQuery = "SELECT * FROM ".DB_PREFIX."party 
		WHERE 1 = 1 " . $condition ." order by  ". $order;
		
		$rs=mysql_query($sQuery);
		$i=0;
		while($arparty= mysql_fetch_array($rs))
		{
			$arrlist[$i]["party_id"] = $arparty["party_id"];
			$arrlist[$i]["party_name"] = $arparty["party_name"];
			$arrlist[$i]["party_active"] = $arparty["party_active"];
		
			$i++;
		}
		
		return $arrlist;
	}
	
	//Function to get particular field value
	function fieldValue($field="party_id",$id="",$condition="",$order="")
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
	function addparty()
	{
		$strQuery="INSERT INTO ".DB_PREFIX."party 
					(party_name, party_active, created_by, created_date, updated_by, updated_date) 
		  values('".$this->party_name."','".$this->party_active."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
			$this->party_id = mysql_insert_id();
			return mysql_insert_id();
	}
	
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		$i=0;

		while($arparty= mysql_fetch_array($rs))
		{
			$this->party_id = $arparty["party_id"];
			$this->party_name = $arparty["party_name"];
			$this->party_active = $arparty["party_active"];			
			$i++;
		}		
	}
	
	//Function to update recordset of table
	function updateparty()
	{		
		$strQuery="UPDATE ".DB_PREFIX."party SET
					party_name = '".$this->party_name."', 
					party_active = '".$this->party_active."', 
					updated_by = '".$this->updated_by."', 
					updated_date = '".currentScriptDate()."' 
					WHERE party_id='".$this->party_id."'";
	  			    mysql_query($strQuery) or die(mysql_error());
					return 1;	
	}
	
	//Function to delete record from table
	function deleteparty($party_id) 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."party  WHERE party_id =".$party_id;
		return $this->runquery($sQuery);
	}
	
	function createLanguageDetailForParty($language_id)
	{
		$strquery="SELECT party_language_id FROM ".DB_PREFIX."party_language WHERE 1=1 AND party_id='".$this->party_id."' AND language_id='".$language_id."'";
		$rs=mysql_query($strquery);
		if(mysql_num_rows($rs)==0)
		{
			$strQuery="INSERT INTO ".DB_PREFIX."party_language 
					(party_id, language_id, party_name, created_by, created_date, updated_by, updated_date) 
		 	 values('".$this->party_id."','".$language_id."','".$this->party_name."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
		}
		else
		{
			$strQuery="UPDATE ".DB_PREFIX."party_language SET
					party_name='".$this->party_name."', 
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE 1=1 AND party_id='".$this->party_id."' AND language_id='".$language_id."'";
			mysql_query($strQuery) or die(mysql_error());
		}
	}
	
	function fetchPartyLanguage()
	{			
		$strquery="SELECT * FROM ".DB_PREFIX."party_language WHERE 1=1 AND party_id='".$this->party_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		$i = 0;
		while($artf_partylanguage = mysql_fetch_array($rs))
		{
			$arrList[$i] = $artf_partylanguage['language_id'];
			$i++;
		}
		
		return $arrList;
	}
	
	function deleteLanguageDetailForParty($language_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."party_language WHERE 1=1 AND party_id='".$this->party_id."' AND language_id='".$language_id."'";
		mysql_query($strquery);
	}
	
	function deleteAllLanguageDetailForParty($party_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."party_language WHERE 1=1 AND party_id='".$party_id."'";
		mysql_query($strquery);
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$sQuery	 = 	"UPDATE ".DB_PREFIX."party SET party_active = 'n' WHERE party_id =".$this->party_id;
		return $this->runquery($sQuery);
	}
	
	function fetchPartyLanguageDetail()
	{
		$strquery="SELECT * FROM ".DB_PREFIX."party_language WHERE 1=1 AND party_id='".$this->party_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_partylanguage = mysql_fetch_array($rs))
			{
				$arrList[$artf_partylanguage['language_id']]["party_name"] = $artf_partylanguage['party_name'];				
			}
		}
		return $arrList;
	}
}