<?php
class party_state extends common
{
	var $party_state_id;
	var $state_id;
	var $party_id;
	var $state_code;
	var $state_name;
	var $party_name;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;	
	var $pagingType;
	var $defaultlanguage_id;
	var $language_id;
		
	function party_state()
	{
		$this->party_state_id = 0;
		$this->state_id = 0;
		$this->party_id = 0;
		$this->state_code = "";
		$this->state_name = "";
		$this->party_name = "";		
	}
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="party_state_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and party_state_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order." ";
		}
		$strquery="SELECT es.*,s.state_name,s.state_code,ec.party_name FROM ".DB_PREFIX."party_state es, ".DB_PREFIX."state s, ".DB_PREFIX."party ec WHERE 1=1 AND es.state_id = s.state_id AND es.party_id = ec.party_id " . $condition ."  group by s.state_code " .$order;
		
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($condition = "",$order = "party_name")
	{	
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", party_state_id desc";
		}
		$strquery="SELECT es.*,s.state_name,s.state_code,ec.party_name FROM ".DB_PREFIX."party_state es, ".DB_PREFIX."state s, ".DB_PREFIX."party ec WHERE 1=1 AND es.state_id = s.state_id AND es.party_id = ec.party_id " . $condition . $order;
		$arrlist = array();
		$rs=mysql_query($strquery);
		$i=0;
		while($areligibility= mysql_fetch_array($rs))
		{
			$arrlist[$i]["party_state_id"] = $areligibility["party_state_id"];
			$arrlist[$i]["state_id"] = $areligibility["state_id"];
			$arrlist[$i]["party_id"] = $areligibility["party_id"];
			$arrlist[$i]["state_code"] = $areligibility["state_code"];
			$arrlist[$i]["state_name"] = $areligibility["state_name"];
			$arrlist[$i]["party_name"] = $areligibility["party_name"];
			$i++;
		}
		return $arrlist;
	}
	
	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArrayFront($condition = "",$order = "party_state_id")
	{
		$arrlist = array();
		$i = 0;
		
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", party_state_id desc";
		}			
		
		$strquery="SELECT es.*,s.state_name,s.state_code, if(pl.party_name is NULL or pl.party_name = '', ec.party_name, pl.party_name) as langparty_name  FROM ".DB_PREFIX."party_state es, ".DB_PREFIX."state s, ".DB_PREFIX."party ec LEFT JOIN ".DB_PREFIX."party_language pl ON ( ec.party_id=pl.party_id AND language_id='".$this->language_id."')  WHERE 1=1 AND es.state_id = s.state_id AND es.party_id = ec.party_id " . $condition . $order;
		
		$rs=mysql_query($strquery);		
		
		if(mysql_num_rows($rs) > 0)
		{
			while($areligibility= mysql_fetch_array($rs))
			{
				$arrlist[$i]["party_state_id"] = $areligibility["party_state_id"];
				$arrlist[$i]["state_id"] = $areligibility["state_id"];
				$arrlist[$i]["party_id"] = $areligibility["party_id"];
				$arrlist[$i]["state_code"] = $areligibility["state_code"];
				$arrlist[$i]["state_name"] = $areligibility["state_name"];
				$arrlist[$i]["party_name"] = $areligibility["langparty_name"];
				$i++;
			}
		}	
		return $arrlist;
	}
	//Function to get particular field value
	function fieldValue($field="party_state_id",$id="",$condition="",$order="")
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
	function addStateParty($post)
	{
		//print "<pre>";
		//print_r($post);
		$partyids=explode(",",$post['selParty']);
		$sql="delete from ".DB_PREFIX."party_state where state_id=".$post['selState'];
		mysql_query($sql);
		for($i=0;$i<count($partyids);$i++)
		{
		$strQuery="INSERT INTO ".DB_PREFIX."party_state 
					(party_id, state_id, created_by, created_date, updated_by, updated_date) 
		  values('".$partyids[$i]."','".$post['selState']."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
		//  echo $strQuery."<br>";
		  mysql_query($strQuery) or die(mysql_error());
		}
		
		$this->state_id = $post['selState'];
		return mysql_insert_id();
	}
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		$i=0;

		while($arec= mysql_fetch_array($rs))
		{
			$this->party_state_id = $arec["party_state_id"];			
			$this->state_id = $arec["state_id"];
			$this->party_id = $arec["party_id"];
			$this->state_code = $arec["state_code"];
			$this->state_name = $arec["state_name"];
			$this->party_name = $arec["party_name"];
		
			$i++;
		}		
	}
	
	//Function to update recordset of table
	function updateStateParty()
	{		
		$strQuery="UPDATE ".DB_PREFIX."party_state SET
					state_id = '".$this->state_id."', 										
					party_id = '".$this->party_id."', 
					updated_date = '".currentScriptDate()."' 
					WHERE party_state_id='".$this->party_state_id."'";
	  			    mysql_query($strQuery) or die(mysql_error());
					return 1;	
	}
	
	//Function to delete record from table
	function deleteStateParty($state_id) 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."party_state WHERE state_id =".$state_id;
		return $this->runquery($sQuery);
	}	
	function fetchstatewisepartydata($state_id,$order="party_name")
	{
		$strquery="SELECT es.*,s.state_name,s.state_code,ec.party_name FROM ".DB_PREFIX."party_state es, ".DB_PREFIX."state s, ".DB_PREFIX."party ec WHERE 1=1 AND es.state_id = s.state_id AND es.party_id = ec.party_id " . $condition . $order;
		$arrlist = array();
		$rs=mysql_query($strquery);
		$i=0;
		while($areligibility= mysql_fetch_array($rs))
		{
			$arrlist[$i]["party_state_id"] = $areligibility["party_state_id"];
			$arrlist[$i]["state_id"] = $areligibility["state_id"];
			$arrlist[$i]["party_id"] = $areligibility["party_id"];
			$arrlist[$i]["state_code"] = $areligibility["state_code"];
			$arrlist[$i]["state_name"] = $areligibility["state_name"];
			$arrlist[$i]["party_name"] = $areligibility["party_name"];
			$i++;
		}
		return $arrlist;
	}
	
}
?>