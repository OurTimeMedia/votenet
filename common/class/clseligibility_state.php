<?php
class eligibility_state extends common
{
	var $eligibility_state_id;
	var $state_id;
	var $eligibility_criteria_id;
	var $state_code;
	var $state_name;
	var $eligibility_criteria;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;	
	var $pagingType;
	var $defaultlanguage_id;
		
	function eligibility_state()
	{
		$this->eligibility_state_id = 0;
		$this->state_id = 0;
		$this->eligibility_criteria_id = 0;
		$this->state_code = "";
		$this->state_name = "";
		$this->eligibility_criteria = "";		
	}
		 
function setAllcriteriarr($state_mapid)
	{
		$strquery = "select if(es.eligibility_criteria_id is null, ec.eligibility_criteria_id ,es.eligibility_criteria_id) eligibility_criteria_id,ec.eligibility_criteria  from ".DB_PREFIX."eligibility_criteria ec left join ".DB_PREFIX."eligibility_state es on es.eligibility_criteria_id=ec.eligibility_criteria_id ";
		
		if($languageid>1)
		$strquery.=" ec left join ".DB_PREFIX."eligibility_criteria_language ecl  on ecl.eligibility_criteria_id=ec.eligibility_criteria_id ";
		
		$strquery.=" left join ".DB_PREFIX."state s on es.state_id=s.state_id
		where (ec.for_all_state=1 or es.state_id=".$stateid.")";
		$res=mysql_query($sql);
		$i=0;
		while($arr=mysql_fetch_array($res))
		{
			$statedetail[$i]['state_mapid'] = $arr["state_mapid"];
			$statedetail[$i]['state_name'] = $arr["state_name"];
			$statedetail[$i]['eligibility_criteria'] = $arr["eligibility_criteria"];		
			$statedetail[$i]['eligibility_criteria_mapid'] = $arr["eligibility_criteria_mapid"];		
			$i++;
		}
		return $statedetail;
	}
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="s.state_code")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and eligibility_state_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", s.state_code asc";
		}
		
		$strquery="SELECT es.*,s.state_name,s.state_code,ec.eligibility_criteria FROM ".DB_PREFIX."eligibility_state es, ".DB_PREFIX."state s, ".DB_PREFIX."eligibility_criteria ec WHERE 1=1 AND es.state_id = s.state_id AND es.eligibility_criteria_id = ec.eligibility_criteria_id " . $condition ." group by s.state_code ". $order;
		
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	function fetchAllAsArray($condition = "",$order = " order by eligibility_state_id")
	{		
		$strquery="SELECT es.*,s.state_name,s.state_code,ec.eligibility_criteria FROM ".DB_PREFIX."eligibility_state es, ".DB_PREFIX."state s, ".DB_PREFIX."eligibility_criteria ec WHERE 1=1 AND es.state_id = s.state_id AND es.eligibility_criteria_id = ec.eligibility_criteria_id " . $condition . $order;
		//echo $strquery;
		$rs=mysql_query($strquery);
		$i=0;
		while($areligibility= mysql_fetch_array($rs))
		{
			$arrlist[$i]["eligibility_state_id"] = $areligibility["eligibility_state_id"];
			$arrlist[$i]["state_id"] = $areligibility["state_id"];
			$arrlist[$i]["eligibility_criteria_id"] = $areligibility["eligibility_criteria_id"];
			$arrlist[$i]["state_code"] = $areligibility["state_code"];
			$arrlist[$i]["state_name"] = $areligibility["state_name"];
			$arrlist[$i]["eligibility_criteria"] = $areligibility["eligibility_criteria"];
			$i++;
		}
		return $arrlist;
	}
	function fetchstatewiseAsArray($stateid = "",$languageid=1,$order = "eligibility_state_id")
	{
		$strquery = "select  ec.eligibility_criteria_id, if(ecl.eligibility_criteria is null or ecl.eligibility_criteria = '', ec.eligibility_criteria ,ecl.eligibility_criteria) langeligibility_criteria  from ".DB_PREFIX."eligibility_criteria ec left join ".DB_PREFIX."eligibility_state es on es.eligibility_criteria_id=ec.eligibility_criteria_id ";
			
		$strquery.=" left join ".DB_PREFIX."eligibility_criteria_language ecl  on ecl.eligibility_criteria_id=ec.eligibility_criteria_id and ecl.language_id=".$languageid;
		
		$strquery.=" left join ".DB_PREFIX."state s on es.state_id=s.state_id
		where (ec.for_all_state=1 or es.state_id=".$stateid.")";
		
		/*if($languageid>1)
		$strquery.=" and ecl.language_id=".$languageid;*/
				
		$arrlist = array();
		$rs=mysql_query($strquery);
		$i=0;
		while($areligibility= mysql_fetch_array($rs))
		{
			//$arrlist[$i]["eligibility_state_id"] = $areligibility["eligibility_state_id"];
			//$arrlist[$i]["state_id"] = $areligibility["state_id"];
			$arrlist[$i]["eligibility_criteria_id"] = $areligibility["eligibility_criteria_id"];
			//$arrlist[$i]["state_code"] = $areligibility["state_code"];
			//$arrlist[$i]["state_name"] = $areligibility["state_name"];
			$arrlist[$i]["eligibility_criteria"] = $areligibility["langeligibility_criteria"];
			$i++;
		}
		return $arrlist;
	}
	//Function to get particular field value
	function fieldValue($field="eligibility_state_id",$id="",$condition="",$order="")
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
	function addStateEligibility($post)
	{
		/*$strQuery="INSERT INTO ".DB_PREFIX."eligibility_state 
					(eligibility_criteria_id, state_id, created_by, created_date, updated_by, updated_date) 
		  values('".$this->eligibility_criteria_id."','".$this->state_id."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";*/
		  $sql="delete from ".DB_PREFIX."eligibility_state where state_id=".$post['selState'];
		  mysql_query($sql);
		//  print_r($post);
	$eligval=explode(",",$post['selEligibilityCriteria']);
		  for($i=0;$i<count($eligval);$i++)
		  {
		$strQuery="INSERT INTO ".DB_PREFIX."eligibility_state 
					(eligibility_criteria_id, state_id, created_by, created_date, updated_by, updated_date) 
		  values('".$eligval[$i]."','".$this->state_id."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')"; 
		  //echo $strQuery;exit;
		mysql_query($strQuery) or die(mysql_error());
		}
		$this->eligibility_state_id = mysql_insert_id();
		return mysql_insert_id();
	}
	
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		$i=0;

		while($arec= mysql_fetch_array($rs))
		{
			$this->eligibility_state_id = $arec["eligibility_state_id"];			
			$this->state_id = $arec["state_id"];
			$this->eligibility_criteria_id = $arec["eligibility_criteria_id"];
			$this->state_code = $arec["state_code"];
			$this->state_name = $arec["state_name"];
			$this->eligibility_criteria = $arec["eligibility_criteria"];
		
			$i++;
		}		
	}
	
	//Function to update recordset of table
	function updateStateEligibility($post)
	{		
		$strQuery="UPDATE ".DB_PREFIX."eligibility_state SET
					state_id = '".$this->state_id."', 										
					eligibility_criteria_id = '".$this->eligibility_criteria_id."', 
					updated_date = '".currentScriptDate()."' 
					WHERE eligibility_state_id='".$this->eligibility_state_id."'";
	  			    mysql_query($strQuery) or die(mysql_error());
					return 1;	
	}
	
	//Function to delete record from table
	function deleteStateEligibility($state_id) 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."eligibility_state WHERE state_id =".$state_id;
		return $this->runquery($sQuery);
	}	
}
?>