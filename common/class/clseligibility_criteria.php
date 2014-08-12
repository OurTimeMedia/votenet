<?php
class eligibility_criteria extends common
{
	var $eligibility_criteria_id;
	var $eligibility_criteria;
	var $for_all_state;
	var $eligibility_active;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;	
	var $pagingType;
	var $defaultlanguage_id;
		
	function eligibility_criteria()
	{
		$this->eligibility_criteria_id = 0;
		$this->eligibility_criteria = "";
		$this->for_all_state = 1;		
		$this->eligibility_active = 1;		
		$this->defaultlanguage_id =1;
	}

	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="eligibility_criteria_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and eligibility_criteria_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", eligibility_criteria_id desc";
		}
		
		$strquery="SELECT * FROM ".DB_PREFIX."eligibility_criteria WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	function fetchAllAsArray($id = "",$condition = "",$order = "eligibility_criteria_id")
	{		
		 $sQuery = "SELECT * FROM ".DB_PREFIX."eligibility_criteria 
		WHERE 1 = 1 " . $condition ." order by  ". $order;
		
		$rs=mysql_query($sQuery);
		$i=0;
		while($areligibility= mysql_fetch_array($rs))
		{
			$arrlist[$i]["eligibility_criteria_id"] = $areligibility["eligibility_criteria_id"];
			$arrlist[$i]["eligibility_criteria"] = $areligibility["eligibility_criteria"];
			$arrlist[$i]["for_all_state"] = $areligibility["for_all_state"];
			$arrlist[$i]["eligibility_active"] = $areligibility["eligibility_active"];
		
			$i++;
		}
		return $arrlist;
	}
	
	//Function to get particular field value
	function fieldValue($field="eligibility_criteria_id",$id="",$condition="",$order="")
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
	function addEligibilityCriteria()
	{
		$strQuery="INSERT INTO ".DB_PREFIX."eligibility_criteria 
					(eligibility_criteria, for_all_state, eligibility_active, created_by, created_date, updated_by, updated_date) 
		  values('".$this->eligibility_criteria."','".$this->for_all_state."','".$this->eligibility_active."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
			$this->eligibility_criteria_id = mysql_insert_id();
			return mysql_insert_id();
	}
	
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		$i=0;

		while($arec= mysql_fetch_array($rs))
		{

			$this->eligibility_criteria_id = $arec["eligibility_criteria_id"];
			$this->eligibility_criteria = $arec["eligibility_criteria"];
			$this->for_all_state = $arec["for_all_state"];
			$this->eligibility_active = $arec["eligibility_active"];			
			$i++;
		}		
	}
	
	//Function to update recordset of table
	function updateEligibilityCriteria()
	{		
		$strQuery="UPDATE ".DB_PREFIX."eligibility_criteria SET
					eligibility_criteria = '".$this->eligibility_criteria."', 
					for_all_state = '".$this->for_all_state."', 					
					eligibility_active = '".$this->eligibility_active."', 
					updated_by = '".$this->updated_by."', 
					updated_date = '".currentScriptDate()."' 
					WHERE eligibility_criteria_id='".$this->eligibility_criteria_id."'";
	  			    mysql_query($strQuery) or die(mysql_error());
					return 1;	
	}
	
	//Function to delete record from table
	function deleteEligibilityCriteria($eligibility_criteria_id) 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."eligibility_criteria  WHERE eligibility_criteria_id =".$eligibility_criteria_id;
		return $this->runquery($sQuery);
	}
	
	function createLanguageDetailForEligibilityCriteria($language_id)
	{
		$strquery="SELECT eligibility_criteria_language_id FROM ".DB_PREFIX."eligibility_criteria_language WHERE 1=1 AND eligibility_criteria_id='".$this->eligibility_criteria_id."' AND language_id='".$language_id."'";
		$rs=mysql_query($strquery);
		if(mysql_num_rows($rs)==0)
		{
			 $strQuery="INSERT INTO ".DB_PREFIX."eligibility_criteria_language 
					(eligibility_criteria_id, language_id, eligibility_criteria, created_by, created_date, updated_by, updated_date) 
		 	 values('".$this->eligibility_criteria_id."','".$language_id."','".$this->eligibility_criteria."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
		}
		else
		{
			 $strQuery="UPDATE ".DB_PREFIX."eligibility_criteria_language SET
					eligibility_criteria='".$this->eligibility_criteria."', 
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE 1=1 AND eligibility_criteria_id='".$this->eligibility_criteria_id."' AND language_id='".$language_id."'";
			mysql_query($strQuery) or die(mysql_error());
		}
		return 1;
	}
	
	function fetchEligibilityCriteriaLanguage()
	{			
		$strquery="SELECT * FROM ".DB_PREFIX."eligibility_criteria_language WHERE 1=1 AND eligibility_criteria_id='".$this->eligibility_criteria_id."'";
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
	
	function deleteLanguageDetailForEligibilityCriteria($language_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."eligibility_criteria_language WHERE 1=1 AND eligibility_criteria_id='".$this->eligibility_criteria_id."' AND language_id='".$language_id."'";
		mysql_query($strquery);
	}
	
	function deleteAllLanguageDetailForEligibilityCriteria($eligibility_criteria_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."eligibility_criteria_language WHERE 1=1 AND eligibility_criteria_id='".$eligibility_criteria_id."'";
		mysql_query($strquery);
	}
	
	function fetchEligibilityCriteriaLanguageDetail()
	{
		$strquery="SELECT * FROM ".DB_PREFIX."eligibility_criteria_language WHERE 1=1 AND eligibility_criteria_id='".$this->eligibility_criteria_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_eclanguage = mysql_fetch_array($rs))
			{
				$arrList[$artf_eclanguage['language_id']]["eligibility_criteria"] = $artf_eclanguage['eligibility_criteria'];				
			}
		}
		return $arrList;
	}
}