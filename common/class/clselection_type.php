<?php
class election_type extends common
{
	var $election_type_id;
	var $election_type_name;
	var $election_type_active;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;
	var $defaultlanguage_id;
		
	function election_type()
	{
		$this->election_type_id = 0;
		$this->election_type_name = "";
		$this->election_type_active = 1;		
		$this->defaultlanguage_id =1;
	}

	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="election_type_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and election_type_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", election_type_id desc";
		}
		
		$strquery="SELECT * FROM ".DB_PREFIX."election_type WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	function fetchAllAsArray($id = "",$condition = "",$order = "election_type_id")
	{		
		$arrlist = array();
		$sQuery = "SELECT * FROM ".DB_PREFIX."election_type 
		WHERE 1 = 1 " . $condition ." order by  ". $order;
		
		$rs=mysql_query($sQuery);
		$i=0;
		while($arelection_type= mysql_fetch_array($rs))
		{
			$arrlist[$i]["election_type_id"] = $arelection_type["election_type_id"];
			$arrlist[$i]["election_type_name"] = $arelection_type["election_type_name"];
			$arrlist[$i]["election_type_active"] = $arelection_type["election_type_active"];
		
			$i++;
		}
		
		return $arrlist;
	}
	
	//Function to get particular field value
	function fieldValue($field="election_type_id",$id="",$condition="",$order="")
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
	function addelection_type()
	{
		$strQuery="INSERT INTO ".DB_PREFIX."election_type 
					(election_type_name, election_type_active, created_by, created_date, updated_by, updated_date) 
		  values('".$this->election_type_name."','".$this->election_type_active."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
			$this->election_type_id = mysql_insert_id();
			return mysql_insert_id();
	}
	
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		$i=0;

		while($arelection_type= mysql_fetch_array($rs))
		{
			$this->election_type_id = $arelection_type["election_type_id"];
			$this->election_type_name = $arelection_type["election_type_name"];
			$this->election_type_active = $arelection_type["election_type_active"];			
			$i++;
		}		
	}
	
	//Function to update recordset of table
	function updateelection_type()
	{		
		$strQuery="UPDATE ".DB_PREFIX."election_type SET
					election_type_name = '".$this->election_type_name."', 
					election_type_active = '".$this->election_type_active."', 
					updated_by = '".$this->updated_by."', 
					updated_date = '".currentScriptDate()."' 
					WHERE election_type_id='".$this->election_type_id."'";
	  			    mysql_query($strQuery) or die(mysql_error());
					return 1;	
	}
	
	//Function to delete record from table
	function deleteelection_type($election_type_id) 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."election_type  WHERE election_type_id =".$election_type_id;
		return $this->runquery($sQuery);
	}
	
	function createLanguageDetailForElectionType($language_id)
	{
		$strquery="SELECT election_type_language_id FROM ".DB_PREFIX."election_type_language WHERE 1=1 AND election_type_id='".$this->election_type_id."' AND language_id='".$language_id."'";
		$rs=mysql_query($strquery);
		if(mysql_num_rows($rs)==0)
		{
			$strQuery="INSERT INTO ".DB_PREFIX."election_type_language 
					(election_type_id, language_id, election_type_name, created_by, created_date, updated_by, updated_date) 
		 	 values('".$this->election_type_id."','".$language_id."','".$this->election_type_name."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
		}
		else
		{
			$strQuery="UPDATE ".DB_PREFIX."election_type_language SET
					election_type_name='".$this->election_type_name."', 
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE 1=1 AND election_type_id='".$this->election_type_id."' AND language_id='".$language_id."'";
			mysql_query($strQuery) or die(mysql_error());
		}
	}
	
	function fetchElectionTypeLanguage()
	{			
		$strquery="SELECT * FROM ".DB_PREFIX."election_type_language WHERE 1=1 AND election_type_id='".$this->election_type_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		$i = 0;
		while($artf_election_typelanguage = mysql_fetch_array($rs))
		{
			$arrList[$i] = $artf_election_typelanguage['language_id'];
			$i++;
		}
		
		return $arrList;
	}
	
	function deleteLanguageDetailForElectionType($language_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."election_type_language WHERE 1=1 AND election_type_id='".$this->election_type_id."' AND language_id='".$language_id."'";
		mysql_query($strquery);
	}
	
	function deleteAllLanguageDetailForElectionType($election_type_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."election_type_language WHERE 1=1 AND election_type_id='".$election_type_id."'";
		mysql_query($strquery);
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$sQuery	 = 	"UPDATE ".DB_PREFIX."election_type SET election_type_active = 'n' WHERE election_type_id =".$this->election_type_id;
		return $this->runquery($sQuery);
	}
	
	function fetchElectionTypeLanguageDetail()
	{
		$strquery="SELECT * FROM ".DB_PREFIX."election_type_language WHERE 1=1 AND election_type_id='".$this->election_type_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_election_typelanguage = mysql_fetch_array($rs))
			{
				$arrList[$artf_election_typelanguage['language_id']]["election_type_name"] = $artf_election_typelanguage['election_type_name'];				
			}
		}
		return $arrList;
	}
}