<?php
class racegroup_state extends common
{
	var $racegroup_state_id;
	var $state_id;
	var $race_group_id;
	var $state_code;
	var $state_name;
	var $race_group_name;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;	
	var $pagingType;
	var $defaultlanguage_id;
	var $language_id;
		
	function racegroup_state()
	{
		$this->racegroup_state_id = 0;
		$this->state_id = 0;
		$this->race_group_id = 0;
		$this->state_code = "";
		$this->state_name = "";
		$this->race_group_name = "";		
	}

	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="race_group_name")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and racegroup_state_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", racegroup_state_id desc";
		}
		
		$strquery="SELECT es.*,s.state_name,s.state_code,ec.race_group_name FROM ".DB_PREFIX."racegroup_state es, ".DB_PREFIX."state s, ".DB_PREFIX."race_group ec WHERE 1=1 AND es.state_id = s.state_id AND es.race_group_id = ec.race_group_id " . $condition ." group by s.state_code "  . $order;
		
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($condition = "",$order = "race_group_name")
	{		
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", racegroup_state_id desc";
		}
		
		$strquery="SELECT es.*,s.state_name,s.state_code,ec.race_group_name FROM ".DB_PREFIX."racegroup_state es, ".DB_PREFIX."state s, ".DB_PREFIX."race_group ec WHERE 1=1 AND es.state_id = s.state_id AND es.race_group_id = ec.race_group_id " . $condition . $order;
		$rs=mysql_query($strquery);
		$i=0;
		$arrlist = array();
		while($areligibility= mysql_fetch_array($rs))
		{
			$arrlist[$i]["racegroup_state_id"] = $areligibility["racegroup_state_id"];
			$arrlist[$i]["state_id"] = $areligibility["state_id"];
			$arrlist[$i]["race_group_id"] = $areligibility["race_group_id"];
			$arrlist[$i]["state_code"] = $areligibility["state_code"];
			$arrlist[$i]["state_name"] = $areligibility["state_name"];
			$arrlist[$i]["race_group_name"] = $areligibility["race_group_name"];
			$i++;
		}
		return $arrlist;
	}
	
	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArrayFront($condition = "",$order = "ec.race_group_name")
	{		
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", racegroup_state_id desc";
		}
		
		$strquery="SELECT es.*,s.state_name,s.state_code, if(pl.race_group_name is NULL or pl.race_group_name = '', ec.race_group_name, pl.race_group_name) as langrace_group_name FROM ".DB_PREFIX."racegroup_state es, ".DB_PREFIX."state s, ".DB_PREFIX."race_group ec LEFT JOIN ".DB_PREFIX."race_group_language pl ON ( ec.race_group_id=pl.race_group_id AND language_id='".$this->language_id."') WHERE 1=1 AND es.state_id = s.state_id AND es.race_group_id = ec.race_group_id " . $condition . $order;
		$rs=mysql_query($strquery);
		$i=0;
		$arrlist = array();
		while($areligibility= mysql_fetch_array($rs))
		{
			$arrlist[$i]["racegroup_state_id"] = $areligibility["racegroup_state_id"];
			$arrlist[$i]["state_id"] = $areligibility["state_id"];
			$arrlist[$i]["race_group_id"] = $areligibility["race_group_id"];
			$arrlist[$i]["state_code"] = $areligibility["state_code"];
			$arrlist[$i]["state_name"] = $areligibility["state_name"];
			$arrlist[$i]["race_group_name"] = $areligibility["langrace_group_name"];
			$i++;
		}
		return $arrlist;
	}
	
	//Function to get particular field value
	function fieldValue($field="racegroup_state_id",$id="",$condition="",$order="")
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
	function addStateRaceGroup($post)
	{
		$racegroupids=explode(",",$post['selRaceGroup']);
		$sql="delete from ".DB_PREFIX."racegroup_state where state_id=".$post['selState'];
		mysql_query($sql);
		for($i=0;$i<count($racegroupids);$i++)
		{
			$strQuery="INSERT INTO ".DB_PREFIX."racegroup_state 
					(race_group_id, state_id, created_by, created_date, updated_by, updated_date) 
		  values('".$racegroupids[$i]."','".$post['selState']."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
		}
	//	echo $strQuery;exit;
		$this->state_id = $post['selState'];
		return mysql_insert_id();
	}
	
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		$i=0;

		while($arec= mysql_fetch_array($rs))
		{
			$this->racegroup_state_id = $arec["racegroup_state_id"];			
			$this->state_id = $arec["state_id"];
			$this->race_group_id = $arec["race_group_id"];
			$this->state_code = $arec["state_code"];
			$this->state_name = $arec["state_name"];
			$this->race_group_name = $arec["race_group_name"];
		
			$i++;
		}		
	}
	
	//Function to update recordset of table
	function updateStateRaceGroup()
	{		
		$strQuery="UPDATE ".DB_PREFIX."racegroup_state SET
					state_id = '".$this->state_id."', 										
					race_group_id = '".$this->race_group_id."', 
					updated_date = '".currentScriptDate()."' 
					WHERE racegroup_state_id='".$this->racegroup_state_id."'";
	  			    mysql_query($strQuery) or die(mysql_error());
					return 1;	
	}
	
	//Function to delete record from table
	function deleteStateRaceGroup($state_id) 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."racegroup_state WHERE state_id =".$state_id;
		return $this->runquery($sQuery);
	}	
}
?>