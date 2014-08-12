<?php
class website_pages extends common
{
	//Property
	var $page_id;
	var $client_id;
	var $page_name;
	var $page_type;
	var $page_link;
	var $page_content;	
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;
	
	function website_pages()
	{
		$this->page_id = 0;		
		$this->client_id = 0;		
		$this->page_name = "";		
		$this->page_type = 1;		
		$this->page_link = "";		
		$this->page_content = "";		
	}

	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id = "",$condition = "",$order = "client_id")
	{		
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
			$condition  =  " and page_id = ". $id .$condition;
		}
		if($order !=  "" && $order !=   NULL && is_null($order) == false)
		{
			$order  =  " order by " . $order;
		}
		$sQuery = "SELECT * FROM ".DB_PREFIX."website_pages WHERE 1 = 1 " . $condition . $order;
		
		$rs  =  $this->runquery($sQuery);
		return $rs;
	}
	
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="page_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND page_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND page_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."website_pages WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_security= mysql_fetch_array($rs))
		{
			$arrlist[$i]["page_id"] = $artf_security["page_id"];
			$arrlist[$i]["client_id"] = $artf_security["client_id"];
			$arrlist[$i]["page_name"] = $artf_security["page_name"];
			$arrlist[$i]["page_type"] = $artf_security["page_type"];
			$arrlist[$i]["page_link"] = $artf_security["page_link"];
			$arrlist[$i]["page_content"] = $artf_security["page_content"];
			$arrlist[$i]["created_by"] = $artf_security["created_by"];
			$arrlist[$i]["created_date"] = $artf_security["created_date"];
			$arrlist[$i]["updated_by"] = $artf_security["updated_by"];
			$arrlist[$i]["updated_date"] = $artf_security["updated_date"];
			$i++;
		}
		return $arrlist;
	}
	
	//Function to set field values into object properties
	function setAllValues($id = "",$condition = "")
	{
		$rs = $this->fetchRecordSet($id, $condition);
	
		if($artf_user =  mysql_fetch_assoc($rs))		
		{
			$this->page_id  =  $artf_user["page_id"];
			$this->client_id  =  $artf_user["client_id"];
			$this->page_name  =  $artf_user["page_name"];			
			$this->page_type  =  $artf_user["page_type"];			
			$this->page_link  =  $artf_user["page_link"];			
			$this->page_content  =  $artf_user["page_content"];
		}
	}

	//Function to get particular field value
	function fieldValue($field = "client_id",$id = "",$condition = "",$order = "")
	{
		$rs = $this->fetchRecordSet($id, $condition, $order);
		$ret = 0;
		while($rw = mysql_fetch_assoc($rs))
		{
			$ret = $rw[$field];
		}
		return $ret;
	}
	
	function add()
	{
		$strquery="INSERT INTO ".DB_PREFIX."website_pages 
					(client_id, page_name, page_type, page_link, page_content, created_by, 
					created_date, updated_by, updated_date) 
					
					values('".$this->client_id."','".$this->page_name."',
						  '".$this->page_type."','".$this->page_link."','".$this->page_content."','".$this->created_by."',
						  '".currentScriptDate()."','".$this->updated_by."',
						  '".currentScriptDate()."')";
		
		mysql_query($strquery) or die(mysql_error());
		
		$this->page_id = mysql_insert_id();
		return mysql_insert_id();
	}
	
	//Function to update record of table
	function update() 
	{
		$sQuery = "UPDATE ".DB_PREFIX."website_pages SET 
					page_name = '".$this->page_name."', 					
					page_type = '".$this->page_type."', 					
					page_link = '".$this->page_link."', 					
					page_content = '".$this->page_content."', 					
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 					
					WHERE page_id = ".$this->page_id;		
	
		return $this->runquery($sQuery);
	}	
	
	//Function to delete record from table
	function delete() 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."website_pages  WHERE page_id in(".$this->page_id.")";
		
		return mysql_query($sQuery) or die(mysql_error());
	}
	
	function findPageVisits($page_id = '0')
	{
		$strQuery="SELECT total_visits FROM ".DB_PREFIX."website_page_visits WHERE client_id='".$this->client_id."' AND page_id='".$page_id."' AND  visit_date='".currentScriptDateOnly()."'";
		$rs = mysql_query($strQuery) or die(mysql_error());
		$totVisits = 0;
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			$totVisits = $res['total_visits'];
		}
		
		return $totVisits;
	}
	
	function addWebsitePageVisits($page_id = '0')
	{	
		$strQuery="INSERT INTO ".DB_PREFIX."website_page_visits (client_id,page_id,total_visits,visit_date) VALUES ('".$this->client_id."','".$page_id."','".$this->total_visits."','".currentScriptDateOnly()."') ";
		mysql_query($strQuery) or die(mysql_error());
	}
	
	function updateWebsitePageVisits($page_id = '0')
	{
		$strQuery="UPDATE ".DB_PREFIX."website_page_visits SET total_visits = '".$this->total_visits."' WHERE client_id='".$this->client_id."' AND  visit_date='".currentScriptDateOnly()."' AND page_id='".$page_id."'";
		mysql_query($strQuery) or die(mysql_error());
	}
}
?>