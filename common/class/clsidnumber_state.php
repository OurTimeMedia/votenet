<?php
class idnumber_state extends common
{
	var $idnumber_state_id;
	var $state_id;
	var $id_number_id;
	var $state_code;
	var $state_name;
	var $id_number_name;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;	
	var $pagingType;
	var $defaultlanguage_id;
	var $language_id;
		
	function idnumber_state()
	{
		$this->idnumber_state_id = 0;
		$this->state_id = 0;
		$this->id_number_id = 0;
		$this->state_code = "";
		$this->state_name = "";
		$this->id_number_name = "";		
	}

	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="idnumber_state_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and idnumber_state_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", s.state_code asc";
		}
		
		$strquery="SELECT es.*,s.state_name,s.state_code,ec.id_number_name FROM ".DB_PREFIX."idnumber_state es, ".DB_PREFIX."state s, ".DB_PREFIX."id_number ec WHERE 1=1 AND es.state_id = s.state_id AND es.id_number_id = ec.id_number_id " . $condition ." group by s.state_code " . $order;
		//echo $strquery;//exit;
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	function fetchAllAsArray($condition = "",$order = "idnumber_state_id")
	{		
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", idnumber_state_id desc";
		}
		
		$strquery="SELECT es.*,s.state_name,s.state_code,ec.id_number_name FROM ".DB_PREFIX."idnumber_state es, ".DB_PREFIX."state s, ".DB_PREFIX."id_number ec WHERE 1=1 AND es.state_id = s.state_id AND es.id_number_id = ec.id_number_id " . $condition . $order;
		
		$rs=mysql_query($strquery);
		$i=0;
		$arrlist = array();
		while($areligibility= mysql_fetch_array($rs))
		{
			$arrlist[$i]["idnumber_state_id"] = $areligibility["idnumber_state_id"];
			$arrlist[$i]["state_id"] = $areligibility["state_id"];
			$arrlist[$i]["id_number_id"] = $areligibility["id_number_id"];
			$arrlist[$i]["state_code"] = $areligibility["state_code"];
			$arrlist[$i]["state_name"] = $areligibility["state_name"];
			$arrlist[$i]["id_number_name"] = $areligibility["id_number_name"];
			
			$i++;
		}
		return $arrlist;
	}
	
	function fetchAllAsArrayFront($condition = "",$order = "idnumber_state_id")
	{
		$arrlist = array();
		$i = 0;
		
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", idnumber_state_id desc";
		}
				
		
		$strquery="SELECT es.*,s.state_name,s.state_code, if(inl.id_number_name is NULL or inl.id_number_name = '', ec.id_number_name, inl.id_number_name) as langid_number_name,ec.id_number_length  FROM ".DB_PREFIX."idnumber_state es, ".DB_PREFIX."state s, ".DB_PREFIX."id_number ec LEFT JOIN ".DB_PREFIX."id_number_language inl ON ( ec.id_number_id=inl.id_number_id AND language_id='".$this->language_id."')  WHERE 1=1 AND es.state_id = s.state_id AND es.id_number_id = ec.id_number_id " . $condition . $order;
		
		$rs=mysql_query($strquery);		
		
		if(mysql_num_rows($rs) > 0)
		{
			while($areligibility= mysql_fetch_array($rs))
			{
				$arrlist[$i]["idnumber_state_id"] = $areligibility["idnumber_state_id"];
				$arrlist[$i]["state_id"] = $areligibility["state_id"];
				$arrlist[$i]["id_number_id"] = $areligibility["id_number_id"];
				$arrlist[$i]["state_code"] = $areligibility["state_code"];
				$arrlist[$i]["state_name"] = $areligibility["state_name"];
				$arrlist[$i]["id_number_length"] = $areligibility["id_number_length"];
				$arrlist[$i]["id_number_name"] = $areligibility["langid_number_name"];
				$i++;
			}
		}	
		return $arrlist;
	}
	
	//Function to get particular field value
	function fieldValue($field="idnumber_state_id",$id="",$condition="",$order="")
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
	function addStateidnumber()
	{
		$sql="delete from ".DB_PREFIX."idnumber_state where state_id=".$this->state_id;
		mysql_query($sql);
		$idnumbal=explode(",",$this->id_number_id);
		for($i=0;$i<count($idnumbal);$i++)
		{
		$strQuery="INSERT INTO ".DB_PREFIX."idnumber_state 
					(id_number_id, state_id, created_by, created_date, updated_by, updated_date) 
		  values('".$idnumbal[$i]."','".$this->state_id."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
		 
		mysql_query($strQuery) or die(mysql_error());
		}
		$this->idnumber_state_id = mysql_insert_id();
		return mysql_insert_id();
	}
	
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		$i=0;

		while($arec= mysql_fetch_array($rs))
		{
			$this->idnumber_state_id = $arec["idnumber_state_id"];			
			$this->state_id = $arec["state_id"];
			$this->id_number_id = $arec["id_number_id"];
			$this->state_code = $arec["state_code"];
			$this->state_name = $arec["state_name"];
			$this->id_number_name = $arec["id_number_name"];
		
			$i++;
		}		
	}
	
	//Function to update recordset of table
	function updateStateRaceGroup()
	{		
		$strQuery="UPDATE ".DB_PREFIX."idnumber_state SET
					state_id = '".$this->state_id."', 										
					id_number_id = '".$this->id_number_id."', 
					updated_date = '".currentScriptDate()."' 
					WHERE idnumber_state_id='".$this->idnumber_state_id."'";
	  			    mysql_query($strQuery) or die(mysql_error());
					return 1;	
	}
	
	//Function to delete record from table
	function deleteStateIDNumber($state_id) 
	{		
		$sQuery = "DELETE FROM ".DB_PREFIX."state_idnumber_note_language WHERE state_id =".$state_id;
		$this->runquery($sQuery);
		
		$sQuery = "DELETE FROM ".DB_PREFIX."idnumber_state WHERE state_id =".$state_id;
		return $this->runquery($sQuery);
		
	}	
	
	function fetchIdNumberNoteLanguage()
	{			
		$strquery="SELECT * FROM ".DB_PREFIX."state_idnumber_note_language WHERE 1=1 AND state_id='".$this->state_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		$i = 0;
		while($artf_id_numberlanguage = mysql_fetch_array($rs))
		{
			$arrList[$i] = $artf_id_numberlanguage['language_id'];
			$i++;
		}
		
		return $arrList;
	}
	
	function fetchIdNumberLanguageDetail()
	{
		$strquery="SELECT * FROM ".DB_PREFIX."state_idnumber_note_language WHERE 1=1 AND state_id='".$this->state_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_id_numberlanguage = mysql_fetch_array($rs))
			{
				$arrList[$artf_id_numberlanguage['language_id']]["state_idnumber_note_text"] = $artf_id_numberlanguage['state_idnumber_note_text'];				
			}
		}
		return $arrList;
	}
	
	function fetchIdNumberNotes()
	{
		$strquery="SELECT * FROM ".DB_PREFIX."state_idnumber_note_language WHERE 1=1 AND state_id='".$this->state_id."' AND language_id='".$this->language_id."'";
		$rs=mysql_query($strquery);
		
		$id_number_note = "";
		
		if(mysql_num_rows($rs) > 0)
		{
			$artf_id_numberlanguage = mysql_fetch_assoc($rs);			
			$id_number_note = $artf_id_numberlanguage['state_idnumber_note_text'];
		}
		return $id_number_note;
	}
	
	function createLanguageDetailForIdNumberNote($language_id)
	{
		$strquery="SELECT state_idnumber_note_language_id FROM ".DB_PREFIX."state_idnumber_note_language WHERE 1=1 AND state_id='".$this->state_id."' AND language_id='".$language_id."'";
		$rs=mysql_query($strquery);
		
		if(mysql_num_rows($rs)==0)
		{
			$strQuery="INSERT INTO ".DB_PREFIX."state_idnumber_note_language 
					(state_id, language_id, state_idnumber_note_text) 
		 	 values('".$this->state_id."','".$language_id."','".$this->state_idnumber_note_text."')";
			mysql_query($strQuery) or die(mysql_error());
		}
		else
		{
			$strQuery="UPDATE ".DB_PREFIX."state_idnumber_note_language SET
					state_idnumber_note_text='".$this->state_idnumber_note_text."'
					WHERE 1=1 AND state_id='".$this->state_id."' AND language_id='".$language_id."'";
			mysql_query($strQuery) or die(mysql_error());
		}
	}
	
	function deleteLanguageDetailForIdNumberNote($language_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."state_idnumber_note_language WHERE 1=1 AND state_id='".$this->state_id."' AND language_id='".$language_id."'";
		mysql_query($strquery);
	}
}
?>