<?php
class stateracejoin extends common
{
	//Property
	var $state_racegroup_id;
	var $language_name;
	var $state_racejoin;
	var $language_id;
	var $state_racejoin_active;
	var $created_by;
	var $totfields;
	var $pagingType;
	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="state_racegroup_id")
	{
		if($id != "" && $id !=  NULL && is_null($id)  ==  false)
		{
		$condition = " and state_racegroup_id=". $id .$condition;
		}
		if($order  !=  "" && $order !=  NULL && is_null($order) == false)
		{
			$order = " order by " . $order." ";
		}
		 $strquery="SELECT * FROM ".DB_PREFIX."state_racegroup 
		 left join ".DB_PREFIX."state on ".DB_PREFIX."state.state_mapid=".DB_PREFIX."state_racegroup.state_mapid
		 left join ".DB_PREFIX."race_group on ".DB_PREFIX."race_group.race_group_mapid=".DB_PREFIX."state_racegroup.race_group_mapid
		 WHERE 1=1 and ".DB_PREFIX."race_group.language_id=1 and ".DB_PREFIX."state.language_id=1 group by ".DB_PREFIX."state_racegroup.state_mapid" .$order;
		// echo $strquery;
		$rs  =  $this->runquery($strquery);
		return $rs;
	}
function fetchRecordSet1($id="",$condition="",$order="state_racegroup_id")
	{
		if($id != "" && $id !=  NULL && is_null($id)  ==  false)
		{
		$condition = " and state_racegroup_id=". $id .$condition;
		}
		if($order  !=  "" && $order !=  NULL && is_null($order) == false)
		{
			$order = " order by " . $order." ";
		}
		 $strquery="SELECT * FROM ".DB_PREFIX."state_racegroup 
		left join ".DB_PREFIX."state on ".DB_PREFIX."state.state_mapid=".DB_PREFIX."state_racegroup.state_mapid
		left join ".DB_PREFIX."eligibility_criteria on ".DB_PREFIX."eligibility_criteria.race_group_mapid=".DB_PREFIX."state_racegroup.race_group_mapid
		WHERE 1=1 and ".DB_PREFIX."eligibility_criteria.language_id=1 and ".DB_PREFIX."state.language_id=1 ".$order;
		$rs  =  $this->runquery($strquery);
		return $rs;
		/*$rs=mysql_query($strquery);
		$i=0;
		echo $strquery;
		while($langua =  mysql_fetch_assoc($rs))
		{
			$res1[$i]['state_racegroup_id']=$langua['state_racegroup_id'];
			$res1[$i]['state_racejoin']=$langua['state_racejoin'];
			$res1[$i]['state_racegroup_id']=$langua['state_racegroup_id'];
			$res1[$i]['for_all_state']=$langua['for_all_state'];
			$i++;
		}
		print_r($res1);
		return $res1;*/
	}
	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="state_racegroup_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid) != "") $and .= " AND state_racegroup_id = " . $intid;
		
		 $strquery="SELECT * FROM ".DB_PREFIX."state_racegroup where ei_eligibility_criteria.language_id=1 " . $and . " ORDER BY ".$order;
	//	echo  $strquery;
		$rs=mysql_query($strquery);
		while($areligibility= mysql_fetch_array($rs))
		{
			$arrlist[$i]["state_racegroup_id"] = $areligibility["state_racegroup_id"];
			$arrlist[$i]["language_name"] = $areligibility["language_name"];
			$arrlist[$i]["state_racejoin_name"] = $areligibility["state_racejoin_name"];
			$arrlist[$i]["state_racegroup_id"] = $areligibility["state_racegroup_id"];
			$arrlist[$i]["state_racejoin_active"] = $areligibility["state_racejoin_active"];
			$arrlist[$i]["created_by"] = $areligibility["created_by"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($areligibility= mysql_fetch_array($rs))
		{
			$this->state_racegroup_id = $areligibility["state_racegroup_id"];
			$this->language_name = $areligibility["language_name"];
			$this->state_racejoin = $areligibility["state_racejoin"];
			$this->state_name = $areligibility["state_name"];
			$this->state_racegroup_id = $areligibility["state_racegroup_id"];
			$this->state_racejoin_active = $areligibility["state_racejoin_active"];
			$this->created_by = $areligibility["created_by"];
		}
	}
	function setAllracegrouparr($state_mapid)
	{
		$sql="select * from ei_state_racegroup
		left join ei_state on ei_state_racegroup.state_mapid=ei_state.state_mapid
		left join ei_race_group on ei_race_group.race_group_mapid=ei_state_racegroup.race_group_mapid
		 where ei_race_group.language_id=1 and ei_state.language_id=1 and ei_state_racegroup.state_mapid = ".$state_mapid;
//echo $sql;
		$res=mysql_query($sql);
		$i=0;
		while($arr=mysql_fetch_array($res))
		{
			$statedetail[$i]['state_mapid'] = $arr["state_mapid"];
			$statedetail[$i]['state_name'] = $arr["state_name"];
			$statedetail[$i]['race_group_name'] = $arr["race_group_name"];		
			$statedetail[$i]['race_group_mapid'] = $arr["race_group_mapid"];		
			$i++;
		}
		return $statedetail;
	}
	//Function to set field values into object properties
	function setAllValuesarr($id="",$condition="")
	{
		$rs=$this->fetchRecordSet1($id, $condition);
		$i=0;
		while($areligibility= mysql_fetch_array($rs))
		{
			$arr[$i]['state_racegroup_id'] = $areligibility["state_racegroup_id"];
			$arr[$i]['language_name'] = $areligibility["language_name"];
			$arr[$i]['language_id'] = $areligibility["edlangid"];
			$arr[$i]['state_racejoin'] = $areligibility["state_racejoin"];
			$arr[$i]['election_type_name'] = $areligibility["election_type_name"];
			$arr[$i]['state_name'] = $areligibility["state_name"];
			$arr[$i]['description'] = $areligibility["description"];
			$arr[$i]['registration_deadline_date'] = $areligibility["registration_deadline_date"];
			$arr[$i]['registration_deadline_description'] = $areligibility["registration_deadline_description"];
			$arr[$i]['state_racegroup_id'] = $areligibility["state_racegroup_id"];
			$arr[$i]['election_type_mapid'] = $areligibility["election_type_mapid"];
			$arr[$i]['state_mapid'] = $areligibility["state_mapid"];
			$arr[$i]['language_icon'] = $areligibility["language_icon"];
			$i++;
		}
		return $arr;
	}
	//Function to get particular field value
	function fieldValue($field="state_racegroup_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchRecordSet($id, $condition, $order);
		$ret=0;
		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$field];
		}
		return $ret;
	}
	//Function to add record into table
	function add($post) 
	{
		//print "<pre>";
		//print_r($post);
		for($i=0;$i<count($post['race_group_mapid']);$i++)
		{
				$strquery="INSERT INTO ".DB_PREFIX."state_racegroup set
				state_mapid=".$post['txtstate_mapid'].",				
				race_group_mapid ='".$post['race_group_mapid'][$i]."',
				created_by=".$this->getSession(SYSTEM_ADMIN_USER_ID);
				//echo $strquery;
				mysql_query($strquery) or die(mysql_error());
				$this->state_racegroup_id = $state_racegroup_id;
		}
		//exit;
		return $this->state_racegroup_id;
	}
	//Function to update record of table
	function update($post) 
	{
		 $sql="delete from ".DB_PREFIX."state_racegroup  where state_mapid=".$post['state_mapid'];
		mysql_query($sql);
		for($i=0;$i<count($post['race_group_mapid']);$i++)
		{
				$strquery="INSERT INTO ".DB_PREFIX."state_racegroup set
				state_mapid=".$post['state_mapid'].",				
				race_group_mapid ='".$post['race_group_mapid'][$i]."',
				created_by=".$this->getSession(SYSTEM_ADMIN_USER_ID);
				//echo $strquery."<br>";
				mysql_query($strquery) or die(mysql_error());
				$this->state_racegroup_id = $state_racegroup_id;
		}
		//exit;
		return $this->state_racegroup_id;
	}
	//Function to delete record from table
	function delete($state_mapid) 
	{	
		$strquery="DELETE FROM ".DB_PREFIX."state_racegroup  WHERE state_mapid =".$state_mapid;
		return mysql_query($strquery) or die(mysql_error());
	}
	//Function to active-inactive record of table
	function activeInactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "state_racejoin SET state_racejoin_active='n' WHERE state_racegroup_id = ". $this->uncheckedids ;
		$result = mysql_query($strquery) or die(mysql_error());
		if($result  ==  false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "state_racejoin SET state_racejoin_active='y' WHERE state_racegroup_id =" . $this->checkedids;
		return mysql_query($strquery) or die(mysql_error());
	}
	
	


}
?>