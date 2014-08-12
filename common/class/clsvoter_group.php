<?php
class voter_group
{
	//Property
	var $voter_group_id;
	var $client_id;
	var $voter_group_name;
	var $voter_group_description;
	var $voter_group_order;
	var $voter_group_isactive;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;

	function voter_group()
	{
		$this->voter_group_isactive = 1;
		$this->voter_group_order = 0;
	}
	
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="voter_group_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and voter_group_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", voter_group_name desc";
		}
		$strquery="SELECT * FROM ".DB_PREFIX."voter_group WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="voter_group_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND voter_group_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND voter_group_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."voter_group WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_judge_type= mysql_fetch_array($rs))
		{
			$arrlist[$i]["voter_group_id"] = $artf_judge_type["voter_group_id"];
			$arrlist[$i]["client_id"] = $artf_judge_type["client_id"];
			$arrlist[$i]["voter_group_name"] = $artf_judge_type["voter_group_name"];
			$arrlist[$i]["voter_group_description"] = $artf_judge_type["voter_group_description"];
			$arrlist[$i]["voter_group_order"] = $artf_judge_type["voter_group_order"];
			$arrlist[$i]["voter_group_isactive"] = $artf_judge_type["voter_group_isactive"];
			$arrlist[$i]["created_by"] = $artf_judge_type["created_by"];
			$arrlist[$i]["created_date"] = $artf_judge_type["created_date"];
			$arrlist[$i]["updated_by"] = $artf_judge_type["updated_by"];
			$arrlist[$i]["updated_date"] = $artf_judge_type["updated_date"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artf_judge_type= mysql_fetch_array($rs))
		{
			$this->voter_group_id = $artf_judge_type["voter_group_id"];
			$this->client_id = $artf_judge_type["client_id"];
			$this->voter_group_name = $artf_judge_type["voter_group_name"];
			$this->voter_group_description = $artf_judge_type["voter_group_description"];
			$this->voter_group_order = $artf_judge_type["voter_group_order"];
			$this->voter_group_isactive = $artf_judge_type["voter_group_isactive"];
			$this->created_by = $artf_judge_type["created_by"];
			$this->created_date = $artf_judge_type["created_date"];
			$this->updated_by = $artf_judge_type["updated_by"];
			$this->updated_date = $artf_judge_type["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldValue($field="voter_group_id",$id="",$condition="",$order="")
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
	function add() 
	{
		$strquery="INSERT INTO ".DB_PREFIX."voter_group 
					(client_id, voter_group_name, voter_group_description, voter_group_order, 
					voter_group_isactive, created_by, 
					created_date, updated_by, updated_date) 
					
					values('".$this->client_id."','".$this->voter_group_name."','".$this->voter_group_description."',
						  '".$this->voter_group_order."','".$this->voter_group_isactive."',
						  '".$this->created_by."','".currentScriptDate()."',
						  '".$this->updated_by."', '".currentScriptDate()."')";
		mysql_query($strquery) or die(mysql_error());
		$this->judge_type_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."voter_group SET 
					client_id='".$this->client_id."', 
					voter_group_name='".$this->voter_group_name."', 
					voter_group_description='".$this->voter_group_description."',
					voter_group_order='".$this->voter_group_order."', 
					voter_group_isactive='".$this->voter_group_isactive."',  
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE voter_group_id=".$this->voter_group_id;
		
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."voter_group  WHERE voter_group_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}
	
	//Function to delete record from table
	function deleteAssociatedVoters() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."voter WHERE voter_group_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "voter_group SET voter_group_isactive='n' WHERE voter_group_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "voter_group SET voter_group_isactive='y' WHERE voter_group_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
}
?>