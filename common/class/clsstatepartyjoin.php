<?php
class statepartyjoin extends common
{
	//Property
	var $state_party_id;
	var $language_name;
	var $state_party;
	var $language_id;
	var $state_party_active;
	var $created_by;
	var $totfields;
	var $pagingType;
	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="state_party_id")
	{
		if($id != "" && $id !=  NULL && is_null($id)  ==  false)
		{
		$condition = " and state_party_id=". $id .$condition;
		}
		if($order  !=  "" && $order !=  NULL && is_null($order) == false)
		{
			$order = " order by " . $order." ";
		}
		 $strquery="SELECT * FROM ".DB_PREFIX."state_party 
		 left join ".DB_PREFIX."state on ".DB_PREFIX."state.state_mapid=".DB_PREFIX."state_party.state_mapid
		 left join ".DB_PREFIX."party on ".DB_PREFIX."party.party_mapid=".DB_PREFIX."state_party.party_mapid
		 WHERE 1=1 and ".DB_PREFIX."party.language_id=1 and ".DB_PREFIX."state.language_id=1 group by ".DB_PREFIX."state_party.state_mapid" .$order;
		 echo $strquery;
		$rs  =  $this->runquery($strquery);
		return $rs;
	}
function fetchRecordSet1($id="",$condition="",$order="state_party_id")
	{
		if($id != "" && $id !=  NULL && is_null($id)  ==  false)
		{
		$condition = " and state_party_id=". $id .$condition;
		}
		if($order  !=  "" && $order !=  NULL && is_null($order) == false)
		{
			$order = " order by " . $order." ";
		}
		 $strquery="SELECT * FROM ".DB_PREFIX."state_party 
		left join ".DB_PREFIX."state on ".DB_PREFIX."state.state_mapid=".DB_PREFIX."state_party.state_mapid
		left join ".DB_PREFIX."party on ".DB_PREFIX."party.party_mapid=".DB_PREFIX."state_party.party_mapid
		WHERE 1=1 and ".DB_PREFIX."party.language_id=1 and ".DB_PREFIX."state.language_id=1 ".$order;
		$rs  =  $this->runquery($strquery);
		return $rs;
		/*$rs=mysql_query($strquery);
		$i=0;
		echo $strquery;
		while($langua =  mysql_fetch_assoc($rs))
		{
			$res1[$i]['state_party_id']=$langua['state_party_id'];
			$res1[$i]['state_party']=$langua['state_party'];
			$res1[$i]['state_party_id']=$langua['state_party_id'];
			$res1[$i]['for_all_state']=$langua['for_all_state'];
			$i++;
		}
		print_r($res1);
		return $res1;*/
	}
	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="state_party_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid) != "") $and .= " AND state_party_id = " . $intid;
		
		 $strquery="SELECT * FROM ".DB_PREFIX."state_party where ei_party.language_id=1 " . $and . " ORDER BY ".$order;
		echo  $strquery;
		$rs=mysql_query($strquery);
		while($areligibility= mysql_fetch_array($rs))
		{
			$arrlist[$i]["state_party_id"] = $areligibility["state_party_id"];
			$arrlist[$i]["language_name"] = $areligibility["language_name"];
			$arrlist[$i]["state_party_name"] = $areligibility["state_party_name"];
			$arrlist[$i]["state_party_id"] = $areligibility["state_party_id"];
			$arrlist[$i]["state_party_active"] = $areligibility["state_party_active"];
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
			$this->state_party_id = $areligibility["state_party_id"];
			$this->language_name = $areligibility["language_name"];
			$this->state_party = $areligibility["state_party"];
			$this->state_party_id = $areligibility["state_party_id"];
			$this->state_party_active = $areligibility["state_party_active"];
			$this->state_name = $areligibility["state_name"];
			$this->created_by = $areligibility["created_by"];
		}
	}
	function setAllpartyarr($state_mapid)
	{
		$sql="select * from ei_state_party
		left join ei_state on ei_state_party.state_mapid=ei_state.state_mapid
		left join ei_party on ei_party.party_mapid=ei_state_party.party_mapid
		 where ei_party.language_id=1 and ei_state.language_id=1 and ei_state_party.state_mapid = ".$state_mapid;
//echo $sql;
		$res=mysql_query($sql);
		$i=0;
		while($arr=mysql_fetch_array($res))
		{
			$statedetail[$i]['state_mapid'] = $arr["state_mapid"];
			$statedetail[$i]['state_name'] = $arr["state_name"];
			$statedetail[$i]['party_name'] = $arr["party_name"];		
			$statedetail[$i]['party_mapid'] = $arr["party_mapid"];		
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
			$arr[$i]['state_party_id'] = $areligibility["state_party_id"];
			$arr[$i]['language_name'] = $areligibility["language_name"];
			$arr[$i]['language_id'] = $areligibility["edlangid"];
			$arr[$i]['state_party'] = $areligibility["state_party"];
			$arr[$i]['election_type_name'] = $areligibility["election_type_name"];
			$arr[$i]['state_name'] = $areligibility["state_name"];
			$arr[$i]['description'] = $areligibility["description"];
			$arr[$i]['registration_deadline_date'] = $areligibility["registration_deadline_date"];
			$arr[$i]['registration_deadline_description'] = $areligibility["registration_deadline_description"];
			$arr[$i]['state_party_id'] = $areligibility["state_party_id"];
			$arr[$i]['election_type_mapid'] = $areligibility["election_type_mapid"];
			$arr[$i]['state_mapid'] = $areligibility["state_mapid"];
			$arr[$i]['language_icon'] = $areligibility["language_icon"];
			$i++;
		}
		return $arr;
	}
	//Function to get particular field value
	function fieldValue($field="state_party_id",$id="",$condition="",$order="")
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
		for($i=0;$i<count($post['party_mapid']);$i++)
		{
				$strquery="INSERT INTO ".DB_PREFIX."state_party set
				state_mapid=".$post['txtstate_mapid'].",				
				party_mapid ='".$post['party_mapid'][$i]."',
				created_by=".$this->getSession(SYSTEM_ADMIN_USER_ID);
				//echo $strquery;
				mysql_query($strquery) or die(mysql_error());
				$this->state_party_id = $state_party_id;
		}
		//exit;
		return $this->state_party_id;
	}
	//Function to update record of table
	function update($post) 
	{
//	print "<pre>";
	//	print_r($post);
		
		 $sql="delete from ".DB_PREFIX."state_party  where state_mapid=".$post['state_mapid'];
		mysql_query($sql);
		for($i=0;$i<count($post['party_mapid']);$i++)
		{
				$strquery="INSERT INTO ".DB_PREFIX."state_party set
				state_mapid=".$post['state_mapid'].",				
				party_mapid ='".$post['party_mapid'][$i]."',
				created_by=".$this->getSession(SYSTEM_ADMIN_USER_ID);
		//		echo $strquery."<br>";
				mysql_query($strquery) or die(mysql_error());
				$this->state_party_id = $state_party_id;
		}
		//exit;
		return $this->state_party_id;
	}
	//Function to delete record from table
	function delete($state_id) 
	{	
		$strquery="DELETE FROM ".DB_PREFIX."state_party  WHERE state_mapid =".$state_id;
				//echo $strquery."<br>";exit;
		return mysql_query($strquery) or die(mysql_error());
	}
	//Function to active-inactive record of table
	function activeInactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "state_party SET state_party_active='n' WHERE state_party_id = ". $this->uncheckedids ;
		$result = mysql_query($strquery) or die(mysql_error());
		if($result  ==  false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "state_party SET state_party_active='y' WHERE state_party_id =" . $this->checkedids;
		return mysql_query($strquery) or die(mysql_error());
	}
	
	


}
?>