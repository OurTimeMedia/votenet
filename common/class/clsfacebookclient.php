<?php
class facebookclient extends common
{
	//Property
	var $fb_client_id;
	var $client_id;
	var $page_id;	
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;
		
	function facebookclient()
	{
		$this->client_id = 0;		
		$this->page_id = 0;
	}

	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id = "",$condition = "",$order = "fb_client_id")
	{		
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
			$condition  =  " and fb_client_id = ". $id .$condition;
		}
		if($order !=  "" && $order !=   NULL && is_null($order) == false)
		{
			$order  =  " order by " . $order.", fb_client_id desc";
		}
		$sQuery = "SELECT * FROM ".DB_PREFIX."facebook_client WHERE 1 = 1 " . $condition . $order;
		// echo $sQuery;
		$rs  =  $this->runquery($sQuery);
		return $rs;
	}
		
	//Function to set field values into object properties
	function setAllValues($id = "",$condition = "")
	{
		$rs = $this->fetchRecordSet($id, $condition);
	
		if(mysql_num_rows($rs) > 0)
		{
			if($artf_user =  mysql_fetch_assoc($rs))		
			{
				$this->fb_client_id  =  $artf_user["fb_client_id"];
				$this->client_id  =  $artf_user["client_id"];
				$this->page_id  =  $artf_user["page_id"];			
			}		
		}	
	}
	
	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid = NULL, $condition = "",$order = "user_id")
	{
		$arrlist  =  array();
		$i  =  0;
		$and  =  $condition;
		
		if(!is_null($intid) && trim($intid) !=  "") $and .=  " AND fb_client_id  =  " . $intid;
		
		$sQuery = "SELECT * FROM ".DB_PREFIX."user WHERE 1 = 1 " . $and . " ORDER BY ".$order;
		$rs  =  $this->runquery($sQuery);
		
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_user =  mysql_fetch_assoc($rs))
			{
				$arrlist[$i]["fb_client_id"]  =  $artf_user["fb_client_id"];
				$arrlist[$i]["client_id"]  =  $artf_user["client_id"];
				$arrlist[$i]["page_id"]  =  $artf_user["page_id"];
				$i++;
			}
		}
		
		return $arrlist;
	}

	//Function to get particular field value
	function fieldValue($field = "fb_client_id",$id = "",$condition = "",$order = "")
	{
		$rs = $this->fetchRecordSet($id, $condition, $order);
		$ret = 0;
		
		if(mysql_num_rows($rs) > 0)
		{
			while($rw = mysql_fetch_assoc($rs))
			{
				$ret = $rw[$field];
			}
		}	
		return $ret;
	}
	
	function addFacebookInfo()
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."facebook_client (client_id, page_id, created_date, created_by, updated_date, updated_by) 
					values('".$this->client_id."', '".$this->page_id."', '".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
		
		$this->runquery($sQuery);
		$this->fb_client_id  =  mysql_insert_id();	
				
		return $this->fb_client_id;
	}
	
	function delete()
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."facebook_client  WHERE client_id in(".$this->client_id.")";
		
		return mysql_query($sQuery) or die(mysql_error());
	}
}
?>