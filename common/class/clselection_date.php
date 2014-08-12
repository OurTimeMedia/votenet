<?php
class election_date extends common
{
	var $election_date_id;
	var $election_type_id;
	var $state_id;
	var $election_date;
	var $election_description;
	var $reg_deadline_date;
	var $reg_deadline_description;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;
	var $defaultlanguage_id;
	var $state_code;
	var $state_name;
	var $election_type_name;
		
	function election_date()
	{
		$this->election_date_id = 0;
		$this->election_type_id = 0;
		$this->state_id = 0;
		$this->election_date = "";		
		$this->election_description = "";
		$this->reg_deadline_date = "";
		$this->reg_deadline_description = "";			
		$this->defaultlanguage_id =1;
	}

	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="election_date_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and election_date_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", election_date_id desc";
		}
		
		$strquery="SELECT ed.*, s.state_code,s.state_name, et.election_type_name FROM ".DB_PREFIX."election_date ed, ".DB_PREFIX."state s, ".DB_PREFIX."election_type et WHERE 1=1 and ed.state_id = s.state_id and ed.election_type_id = et.election_type_id " . $condition . $order;
		$rs=mysql_query($strquery);
		
		return $rs;
	}
	
	function fetchRecordSetReport($id="",$condition="",$order="election_date_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and election_date_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", election_date_id desc";
		}
		
		$strquery="SELECT ed.*, s.state_code, if(sl.state_name = '' OR sl.state_name IS NULL, s.state_name, sl.state_name) as state_name, if(etl.election_type_name = '' OR etl.election_type_name IS NULL, et.election_type_name, etl.election_type_name) as election_type_name FROM ".DB_PREFIX."election_date ed, ".DB_PREFIX."state s left join ".DB_PREFIX."state_language as sl on sl.state_id = s.state_id and sl.language_id = '".$this->language_id."', ".DB_PREFIX."election_type et left join ".DB_PREFIX."election_type_language as etl on etl.election_type_id = et.election_type_id and etl.language_id = '".$this->language_id."' WHERE 1=1 and ed.state_id = s.state_id and ed.election_type_id = et.election_type_id " . $condition . $order;
		$rs=mysql_query($strquery);
		
		return $rs;
	}
	
	function fetchAllAsArray($id = "",$condition = "",$order = "election_date_id")
	{
		$arrlist = array();
		$sQuery = "SELECT ed.*, s.state_code,s.state_name, et.election_type_name FROM ".DB_PREFIX."election_date ed, ".DB_PREFIX."state s, ".DB_PREFIX."election_type et WHERE 1 = 1 and ed.state_id = s.state_id and ed.election_type_id = et.election_type_id " . $condition ." order by  ". $order;
		
		$rs=mysql_query($sQuery);
		$i=0;
		while($arstate= mysql_fetch_array($rs))
		{
			$arrlist[$i]["election_date_id"] = $arstate["election_date_id"];
			$arrlist[$i]["election_type_id"] = $arstate["election_type_id"];
			$arrlist[$i]["state_id"] = $arstate["state_id"];
			$arrlist[$i]["election_date"] = $arstate["election_date"];
			$arrlist[$i]["election_description"] = $arstate["election_description"];
			$arrlist[$i]["reg_deadline_date"] = $arstate["reg_deadline_date"];
			$arrlist[$i]["reg_deadline_description"] = $arstate["reg_deadline_description"];
			$arrlist[$i]["state_code"] = $arstate["state_code"];
			$arrlist[$i]["state_name"] = $arstate["state_name"];
			$arrlist[$i]["election_type_name"] = $arstate["election_type_name"];
			$arrlist[$i]["created_date"] = $arstate["created_date"];
			
			$i++;
		}
		
		return $arrlist;
	}
	
	//Function to get particular field value
	function fieldValue($field="election_date_id",$id="",$condition="",$order="")
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
	function addelection_date()
	{
		$strQuery="INSERT INTO ".DB_PREFIX."election_date 
					(election_type_id, state_id, election_date, election_description, reg_deadline_date,
					reg_deadline_description, created_by, created_date, updated_by, updated_date) 
		  values('".$this->election_type_id."','".$this->state_id."','".$this->election_date."',
				 '".$this->election_description."','".$this->reg_deadline_date."','".$this->reg_deadline_description."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
			$this->election_date_id = mysql_insert_id();
			return mysql_insert_id();	
	}
	
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		$i=0;

		while($arstate= mysql_fetch_array($rs))
		{
			$this->election_date_id = $arstate["election_date_id"];
			$this->election_type_id = $arstate["election_type_id"];
			$this->state_id = $arstate["state_id"];
			$this->election_date = $arstate["election_date"];
			$this->election_description = $arstate["election_description"];
			$this->reg_deadline_date = $arstate["reg_deadline_date"];
			$this->reg_deadline_description = $arstate["reg_deadline_description"];
			$this->state_code = $arstate["state_code"];
			$this->state_name = $arstate["state_name"];
			$this->election_type_name = $arstate["election_type_name"];			
			$i++;
		}		
	}
	
	//Function to update recordset of table
	function updateelection_date()
	{		
		$strQuery="UPDATE ".DB_PREFIX."election_date SET
					election_type_id = '".$this->election_type_id."', 
					state_id = '".$this->state_id."', 
					election_date = '".$this->election_date."', 
					election_description = '".$this->election_description."', 
					reg_deadline_date = '".$this->reg_deadline_date."', 
					reg_deadline_description = '".$this->reg_deadline_description."', 
					updated_by = '".$this->updated_by."', 
					updated_date = '".currentScriptDate()."' 
					WHERE election_date_id='".$this->election_date_id."'";
	  	mysql_query($strQuery) or die(mysql_error());
		return 1;	
	}
	
	//Function to delete record from table
	function deleteelection_date($election_date_id) 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."election_date  WHERE election_date_id =".$election_date_id;
		return $this->runquery($sQuery);
	}
	
	function createLanguageDetailForElectionDate($language_id)
	{
		$strquery="SELECT election_date_language_id FROM ".DB_PREFIX."election_date_language WHERE 1=1 AND election_date_id='".$this->election_date_id."' AND language_id='".$language_id."'";
		$rs=mysql_query($strquery);
		
		if(mysql_num_rows($rs)==0)
		{
			$strQuery="INSERT INTO ".DB_PREFIX."election_date_language 
					(election_date_id, language_id, election_description, reg_deadline_description, created_by, created_date, updated_by, updated_date) 
		 	 values('".$this->election_date_id."','".$language_id."','".$this->election_description."','".$this->reg_deadline_description."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
		}
		else
		{
			$strQuery="UPDATE ".DB_PREFIX."election_date_language SET
					election_description='".$this->election_description."', 
					reg_deadline_description='".$this->reg_deadline_description."', 
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE 1=1 AND election_date_id='".$this->election_date_id."' AND language_id='".$language_id."'";
			mysql_query($strQuery) or die(mysql_error());
		}		
	}
	
	function fetchElectionDateLanguage()
	{			
		$strquery="SELECT * FROM ".DB_PREFIX."election_date_language WHERE 1=1 AND election_date_id='".$this->election_date_id."'";
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
	
	function deleteLanguageDetailForElectionDate($language_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."election_date_language WHERE 1=1 AND election_date_id='".$this->election_date_id."' AND language_id='".$language_id."'";
		mysql_query($strquery);
	}
	
	function deleteAllLanguageDetailForElectionDate($election_date_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."election_date_language WHERE 1=1 AND election_date_id='".$election_date_id."'";
		mysql_query($strquery);
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$sQuery	 = 	"UPDATE ".DB_PREFIX."election_date SET state_active = 'n' WHERE election_date_id =".$this->election_date_id;
		return $this->runquery($sQuery);
	}
	
	function fetchElectionDateLanguageDetail()
	{
		$strquery="SELECT * FROM ".DB_PREFIX."election_date_language WHERE 1=1 AND election_date_id='".$this->election_date_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_statelanguage = mysql_fetch_array($rs))
			{
				$arrList[$artf_statelanguage['language_id']]["election_description"] = $artf_statelanguage['election_description'];
				$arrList[$artf_statelanguage['language_id']]["reg_deadline_description"] = $artf_statelanguage['reg_deadline_description'];
			}
		}
		return $arrList;
	}
	
	function getFirstElectionDate($condition)
	{
		$strquery="SELECT * FROM ".DB_PREFIX."election_date WHERE 1=1 " . $condition . " order by election_date asc limit 0,1";
		$rs=mysql_query($strquery);
		
		if(mysql_num_rows($rs) > 0)
		{
			$rowElectionDate = mysql_fetch_assoc($rs);
			return $rowElectionDate['election_date'];
		}
		else
		{
			return currentScriptDateOnly();
		}
	}	
}