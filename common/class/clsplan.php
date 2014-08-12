<?php
class plan extends common
{
	//Property
	var $plan_id;
	var $plan_title;
	var $plan_description;
	var $plan_amount;
	var $custom_domain;
	var $custom_field;
	var $custom_color;
	var $download_data;
	var $FB_application;
	var $API_access;
	var $plan_ispublish;
	var $plan_isactive;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;
	var $checkedids;
	var $uncheckedids;

	function plan()
	{
		$this->plan_ispublish = 1;
		$this->custom_domain = 1;
		$this->custom_field = 1;
		$this->custom_color = 1;
		$this->download_data = 1;		
		$this->FB_application = 1;
		$this->API_access = 1;
		$this->plan_isactive = 1;
	}
	
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="plan_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and plan_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", plan_id desc";
		}
		$strquery="SELECT * FROM ".DB_PREFIX."plan WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve recordset of table
	function fetchRecordSetReport($id="",$condition="",$order="ct.contest_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and ct.contest_id=". $id .$condition;
		}
		
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", ct.contest_id desc";
		}
		
		$strquery =  " SELECT 
						ct.contest_id,ct.contest_title,
						ct.entry_start_date,ct.winner_announce_date,
						cv.total_visits,cv.visit_date 
						
						FROM 
						".DB_PREFIX."contest ct,
						".DB_PREFIX."contest_visits cv 
						
						WHERE 
						1=1 AND 
						ct.contest_id=cv.contest_id AND 
						contest_status=1 " . $condition . $order;
		//echo $strquery; exit;
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	function selectTotalVisits($visit_date)
	{
		$strQuery="SELECT total_visits FROM ".DB_PREFIX."contest_visits WHERE 1=1 AND contest_id='".$this->contest_id."' AND visit_date = '".$visit_date."'";
		$rs=mysql_query($strQuery);
		$totVisits = 0;
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			$totVisits = $res['total_visits'];
		}
		return $totVisits;
	}
	
	function selectTotalVisitsBetweenDates($visit_startdate, $visit_enddate = "")
	{
		if($visit_enddate == "")
			$strQuery="SELECT sum(total_visits) as total_visits FROM ".DB_PREFIX."contest_visits WHERE 1=1 AND contest_id='".$this->contest_id."' AND visit_date = '".$visit_startdate."'";
		else
			$strQuery="SELECT sum(total_visits) as total_visits FROM ".DB_PREFIX."contest_visits WHERE 1=1 AND contest_id='".$this->contest_id."' AND visit_date <= '".$visit_startdate."'  AND visit_date > '".$visit_enddate."'";
			
		$rs=mysql_query($strQuery);
		$totVisits = 0;
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			
			if($res['total_visits'] != "")
				$totVisits = $res['total_visits'];
		}
		return $totVisits;
	}
	
	function selectTotalVisitsByMonth($visit_month)
	{
		$visittime = explode("-",$visit_month);
		
		$strQuery="SELECT sum(total_visits) as total_visits FROM ".DB_PREFIX."contest_visits WHERE 1=1 AND contest_id='".$this->contest_id."' AND MONTHNAME(visit_date) = '".$visittime[0]."' AND YEAR(visit_date) = '".$visittime[1]."'";
		
		$rs=mysql_query($strQuery);
		$totVisits = 0;
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			
			if($res['total_visits'] != "")
				$totVisits = $res['total_visits'];
		}
		return $totVisits;
	}

	function selectContestEntries($contestDate)
	{
		$strQuery="SELECT count(e.entry_id) as totalEntries FROM ".DB_PREFIX."entry e WHERE 1=1 AND e.contest_id='".$this->contest_id."' AND entry_date like '%".$contestDate."%'";
		$rs=mysql_query($strQuery);
		$totEntries = 0;
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			$totEntries = $res['totalEntries'];
		}
		return $totEntries;
	}
	
	function selectContestEntriesBetweenDates($contestDate1, $contestDate2 = "")
	{
		if($contestDate2 == "")
			$strQuery="SELECT count(e.entry_id) as totalEntries FROM ".DB_PREFIX."entry e WHERE 1=1 AND e.contest_id='".$this->contest_id."' AND entry_date like '%".$contestDate1."%'";
		else	
		{
			$strQuery="SELECT count(e.entry_id) as totalEntries FROM ".DB_PREFIX."entry e WHERE 1=1 AND e.contest_id='".$this->contest_id."' AND entry_date <= '".$contestDate1."' and entry_date > '".$contestDate2."'";
		}	
		$rs=mysql_query($strQuery);
		$totEntries = 0;
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			
			if($res['totalEntries'] != "")
				$totEntries = $res['totalEntries'];
		}
		return $totEntries;
	}
	
	function selectContestEntriesByMonth($contestMonth)
	{
		$contesttime = explode("-",$contestMonth);
		$strQuery="SELECT count(e.entry_id) as totalEntries FROM ".DB_PREFIX."entry e WHERE 1=1 AND e.contest_id='".$this->contest_id."' AND MONTHNAME(entry_date) = '".$contesttime[0]."' AND YEAR(entry_date) = '".$contesttime[1]."'";
		$rs=mysql_query($strQuery);
		$totEntries = 0;
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			
			if($res['totalEntries'] != "")
				$totEntries = $res['totalEntries'];
		}
		return $totEntries;
	}
	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="plan_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND plan_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND plan_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."plan WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_plan= mysql_fetch_array($rs))
		{
			$arrlist[$i]["plan_id"] = $artf_plan["plan_id"];
			$arrlist[$i]["plan_title"] = $artf_plan["plan_title"];
			$arrlist[$i]["plan_description"] = $artf_plan["plan_description"];
			$arrlist[$i]["plan_amount"] = $artf_plan["plan_amount"];
			$arrlist[$i]["custom_domain"] = $artf_plan["custom_domain"];
			$arrlist[$i]["custom_field"] = $artf_plan["custom_field"];
			$arrlist[$i]["plan_ispublish"] = $artf_plan["plan_ispublish"];
			$arrlist[$i]["custom_color"] = $artf_plan["custom_color"];
			$arrlist[$i]["download_data"] = $artf_plan["download_data"];
			$arrlist[$i]["FB_application"] = $artf_plan["FB_application"];
			$arrlist[$i]["API_access"] = $artf_plan["API_access"];
			$arrlist[$i]["plan_isactive"] = $artf_plan["plan_isactive"];
			$arrlist[$i]["created_by"] = $artf_plan["created_by"];
			$arrlist[$i]["created_date"] = $artf_plan["created_date"];
			$arrlist[$i]["updated_by"] = $artf_plan["updated_by"];
			$arrlist[$i]["updated_date"] = $artf_plan["updated_date"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artf_plan= mysql_fetch_array($rs))
		{
			$this->plan_id = $artf_plan["plan_id"];
			$this->plan_title = $artf_plan["plan_title"];
			$this->plan_description = $artf_plan["plan_description"];
			$this->plan_amount = $artf_plan["plan_amount"];
			$this->plan_ispublish = $artf_plan["plan_ispublish"];
			$this->plan_isactive = $artf_plan["plan_isactive"];
			$this->custom_domain = $artf_plan["custom_domain"];
			$this->custom_field = $artf_plan["custom_field"];
			$this->custom_color = $artf_plan["custom_color"];
			$this->download_data = $artf_plan["download_data"];
			$this->FB_application = $artf_plan["FB_application"];
			$this->API_access = $artf_plan["API_access"];
			$this->created_by = $artf_plan["created_by"];
			$this->created_date = $artf_plan["created_date"];
			$this->updated_by = $artf_plan["updated_by"];
			$this->updated_date = $artf_plan["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldValue($field="plan_id",$id="",$condition="",$order="")
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
		
		$strquery="INSERT INTO ".DB_PREFIX."plan set
			plan_title='".$this->plan_title."',
			plan_description='".$this->plan_description."',
			plan_amount='".$this->plan_amount."',
			custom_domain='".$this->custom_domain."',
			custom_field='".$this->custom_field."',
			custom_color='".$this->custom_color."',
			download_data='".$this->download_data."',
			FB_application='".$this->FB_application."',
			API_access='".$this->API_access."',
			plan_ispublish='".$this->plan_ispublish."',
			plan_isactive='".$this->plan_isactive."',
			created_by='".$this->getSession(SYSTEM_ADMIN_USER_ID)."',
			created_date=now(),
			updated_by='".$this->getSession(SYSTEM_ADMIN_USER_ID)."',
			updated_date=now()";
		//	echo $strquery;//exit;
		mysql_query($strquery) or die(mysql_error());
		$this->plan_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."plan SET 
			plan_title='".$this->plan_title."',
			plan_description='".$this->plan_description."',
			plan_amount='".$this->plan_amount."',
			custom_domain='".$this->custom_domain."',
			custom_field='".$this->custom_field."',
			custom_color='".$this->custom_color."',
			download_data='".$this->download_data."',
			FB_application='".$this->FB_application."',
			API_access='".$this->API_access."',
			plan_ispublish='".$this->plan_ispublish."',
			plan_isactive='".$this->plan_isactive."',
			updated_by='".$this->getSession(SYSTEM_ADMIN_USER_ID)."',
			updated_date=now() 
			WHERE plan_id=".$this->plan_id;
		return mysql_query($strquery) or die(mysql_error());
	}
	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."plan  WHERE plan_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "plan SET plan_isactive='n' WHERE plan_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "plan SET plan_isactive='y' WHERE plan_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
	
}
?>