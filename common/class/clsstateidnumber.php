<?php
	class stateidnumber extends common
{
	//Property
	var $state_idnumber_id;
	var $language_name;
	var $state_idnumber;
	var $language_id;
	var $state_idnumber_active;
	var $created_by;
	var $totfields;
	var $pagingType;
	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="state_idnumber_id")
	{
		if($id != "" && $id !=  NULL && is_null($id)  ==  false)
		{
		$condition = " and state_idnumber_id=". $id .$condition;
		}
		if($order  !=  "" && $order !=  NULL && is_null($order) == false)
		{
			$order = " order by " . $order." ";
		}
		 $strquery="SELECT * FROM ".DB_PREFIX."state_idnumber 
		 left join ".DB_PREFIX."state on ".DB_PREFIX."state.state_mapid=".DB_PREFIX."state_idnumber.state_mapid
		 left join ".DB_PREFIX."id_number on ".DB_PREFIX."id_number.id_number_mapid=".DB_PREFIX."state_idnumber.id_number_mapid
		 WHERE 1=1 and ".DB_PREFIX."id_number.language_id=1 and ".DB_PREFIX."state.language_id=1 group by ".DB_PREFIX."state_idnumber.state_mapid" .$order;
		// echo $strquery;
		$rs  =  $this->runquery($strquery);
		return $rs;
	}
function fetchRecordSet1($id="",$condition="",$order="state_idnumber_id")
	{
		if($id != "" && $id !=  NULL && is_null($id)  ==  false)
		{
		$condition = " and state_idnumber_id=". $id .$condition;
		}
		if($order  !=  "" && $order !=  NULL && is_null($order) == false)
		{
			$order = " order by " . $order." ";
		}
		 $strquery="SELECT * FROM ".DB_PREFIX."state_idnumber 
		left join ".DB_PREFIX."state on ".DB_PREFIX."state.state_mapid=".DB_PREFIX."state_idnumber.state_mapid
		left join ".DB_PREFIX."id_number on ".DB_PREFIX."id_number.id_number_mapid=".DB_PREFIX."state_idnumber.id_number_mapid
		WHERE 1=1 and ".DB_PREFIX."id_number.language_id=1 and ".DB_PREFIX."state.language_id=1 ".$order;
		$rs  =  $this->runquery($strquery);
		return $rs;
		/*$rs=mysql_query($strquery);
		$i=0;
		echo $strquery;
		while($langua =  mysql_fetch_assoc($rs))
		{
			$res1[$i]['state_idnumber_id']=$langua['state_idnumber_id'];
			$res1[$i]['state_idnumber']=$langua['state_idnumber'];
			$res1[$i]['state_idnumber_id']=$langua['state_idnumber_id'];
			$res1[$i]['for_all_state']=$langua['for_all_state'];
			$i++;
		}
		print_r($res1);
		return $res1;*/
	}
	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="state_idnumber_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid) != "") $and .= " AND state_idnumber_id = " . $intid;
		
		 $strquery="SELECT * FROM ".DB_PREFIX."state_idnumber where ei_id_number.language_id=1 " . $and . " ORDER BY ".$order;
		//echo  $strquery;
		$rs=mysql_query($strquery);
		while($areligibility= mysql_fetch_array($rs))
		{
			$arrlist[$i]["state_idnumber_id"] = $areligibility["state_idnumber_id"];
			$arrlist[$i]["language_name"] = $areligibility["language_name"];
			$arrlist[$i]["state_idnumber_name"] = $areligibility["state_idnumber_name"];
			$arrlist[$i]["state_idnumber_id"] = $areligibility["state_idnumber_id"];
			$arrlist[$i]["state_idnumber_active"] = $areligibility["state_idnumber_active"];
			
			$arrlist[$i]["created_by"] = $areligibility["created_by"];
			$i++;
		}
		return $arrlist;
	}
function setAllidnumberarr($state_mapid)
	{
		$sql="select * from ".DB_PREFIX."state_idnumber
		left join ei_state on ".DB_PREFIX."state_idnumber.state_mapid=ei_state.state_mapid
		left join ei_id_number on ei_id_number.id_number_mapid=".DB_PREFIX."state_idnumber.id_number_mapid
		 where ei_id_number.language_id=1 and ei_state.language_id=1 and ".DB_PREFIX."state_idnumber.state_mapid = ".$state_mapid;
//echo $sql;
		$res=mysql_query($sql);
		$i=0;
		while($arr=mysql_fetch_array($res))
		{
			$statedetail[$i]['state_mapid'] = $arr["state_mapid"];
			$statedetail[$i]['state_name'] = $arr["state_name"];
			$statedetail[$i]['id_number_name'] = $arr["id_number_name"];		
			$statedetail[$i]['id_number_mapid'] = $arr["id_number_mapid"];		
			$i++;
		}
		return $statedetail;
	}
	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($areligibility= mysql_fetch_array($rs))
		{
			$this->state_idnumber_id = $areligibility["state_idnumber_id"];
			$this->language_name = $areligibility["language_name"];
			$this->state_idnumber = $areligibility["state_idnumber"];
			$this->state_idnumber_id = $areligibility["state_idnumber_id"];
			$this->state_idnumber_active = $areligibility["state_idnumber_active"];
			$this->created_by = $areligibility["created_by"];
			$this->state_name = $areligibility["state_name"];
		}
	}
	function setAllcriteriaarr($state_mapid)
	{
		$sql="select * from ei_state_idnumber
		left join ei_state on ei_state_idnumber.state_mapid=ei_state.state_mapid
		left join ei_id_number on ei_id_number.id_number_mapid=ei_state_idnumber.id_number_mapid
		 where ei_id_number.language_id=1 and ei_state.language_id=1 and ei_state_idnumber.state_mapid = ".$state_mapid;
//echo $sql;
		$res=mysql_query($sql);
		$i=0;
		while($arr=mysql_fetch_array($res))
		{
			$statedetail[$i]['state_mapid'] = $arr["state_mapid"];
			$statedetail[$i]['state_name'] = $arr["state_name"];
			$statedetail[$i]['id_number'] = $arr["id_number"];		
			$statedetail[$i]['id_number_mapid'] = $arr["id_number_mapid"];		
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
			$arr[$i]['state_idnumber_id'] = $areligibility["state_idnumber_id"];
			$arr[$i]['language_name'] = $areligibility["language_name"];
			$arr[$i]['language_id'] = $areligibility["edlangid"];
			$arr[$i]['state_idnumber'] = $areligibility["state_idnumber"];
			$arr[$i]['election_type_name'] = $areligibility["election_type_name"];
			$arr[$i]['state_name'] = $areligibility["state_name"];
			$arr[$i]['description'] = $areligibility["description"];
			$arr[$i]['registration_deadline_date'] = $areligibility["registration_deadline_date"];
			$arr[$i]['registration_deadline_description'] = $areligibility["registration_deadline_description"];
			$arr[$i]['state_idnumber_id'] = $areligibility["state_idnumber_id"];
			$arr[$i]['election_type_mapid'] = $areligibility["election_type_mapid"];
			$arr[$i]['state_mapid'] = $areligibility["state_mapid"];
			$arr[$i]['language_icon'] = $areligibility["language_icon"];
			$i++;
		}
		return $arr;
	}
	//Function to get particular field value
	function fieldValue($field="state_idnumber_id",$id="",$condition="",$order="")
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
		print "<pre>";
		print_r($post);
		for($i=0;$i<count($post['id_number_mapid']);$i++)
		{
				$strquery="INSERT INTO ".DB_PREFIX."state_idnumber set
				state_mapid=".$post['txtstate_mapid'].",				
				id_number_mapid ='".$post['id_number_mapid'][$i]."',
				created_by=".$this->getSession(SYSTEM_ADMIN_USER_ID);
				//echo $strquery;exit;
				mysql_query($strquery) or die(mysql_error());
				$this->state_idnumber_id = $state_idnumber_id;
		}
		return $this->state_idnumber_id;
	}
	//Function to update record of table
	function update($post) 
	{
		 $sql="delete from ".DB_PREFIX."state_idnumber  where state_mapid=".$post['state_mapid'];
		mysql_query($sql);
		for($i=0;$i<count($post['id_number_mapid']);$i++)
		{
				$strquery="INSERT INTO ".DB_PREFIX."state_idnumber set
				state_mapid=".$post['state_mapid'].",				
				id_number_mapid ='".$post['id_number_mapid'][$i]."',
				created_by=".$this->getSession(SYSTEM_ADMIN_USER_ID);
				//echo $strquery."<br>";
				mysql_query($strquery) or die(mysql_error());
				$this->state_idnumber_id = $state_idnumber_id;
		}
		//exit;
		return $this->state_idnumber_id;
	}
	//Function to delete record from table
	function delete($state_mapid) 
	{	
		$strquery="DELETE FROM ".DB_PREFIX."state_idnumber  WHERE state_mapid =".$state_mapid;
		return mysql_query($strquery) or die(mysql_error());
	}
	//Function to active-inactive record of table
	function activeInactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "state_idnumber SET state_idnumber_active='n' WHERE state_idnumber_id = ". $this->uncheckedids ;
		$result = mysql_query($strquery) or die(mysql_error());
		if($result  ==  false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "state_idnumber SET state_idnumber_active='y' WHERE state_idnumber_id =" . $this->checkedids;
		return mysql_query($strquery) or die(mysql_error());
	}
	
	


}
?>