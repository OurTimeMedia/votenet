<?php
class registrantreport extends common
{
	//Property
	var $rpt_reg_id;
	var $client_id;
	var $voter_email;
	var $voter_state_id;
	var $voter_zipcode;
	
	var $voter_reg_source;
	var $voting_date;
	
	
	function registrantreport()
	{
		$this->client_id = 0;
		$this->voter_email = "";
		$this->voter_state_id = 0;
		$this->voter_zipcode = 0;		
		$this->voter_reg_source = 'Website';		
	}
	
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="rpt_reg_id")
	{
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
		$condition  =  " and rpt_reg_id = ". $id .$condition;
		}
		
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", rr.rpt_reg_id desc";
		}
	
		$strQuery="SELECT  rr.*,rs.state_name FROM ".REPORT_DB_PREFIX."rpt_registration  rr, ".REPORT_DB_PREFIX."rpt_state rs WHERE rr.voter_state_id=rs.state_id 
						  " . $condition . $order;
						  
		//echo $strQuery;				  
		$rs=mysql_query($strQuery);
		return $rs;
	}
	
	//Function to retrieve recordset of table
	function fetchRecordSetReport($id="",$condition="",$order="rr.rpt_reg_id")
	{		
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", rr.rpt_reg_id desc";
		}
	
		$strQuery="SELECT  rr.*,rs.state_name FROM ".REPORT_DB_PREFIX."rpt_registration  rr, ".REPORT_DB_PREFIX."rpt_state rs WHERE rr.voter_state_id=rs.state_id AND rr.client_id='".$this->client_id."' 
						  " . $condition . $order;
						  
		// echo $strQuery;				  
		$rs=mysql_query($strQuery);
		return $rs;
	}
	
	//Function to retrieve recordset of table
	function fetchRecordSetReportAll($id="",$condition="",$order="rpt_reg_id")
	{
		
		
	}
	
	function setAllValues($id = "",$condition = "")
	{
		$rs = $this->fetchRecordSet($id, $condition);
		$artf_user =  array();
		
		if(mysql_num_rows($rs) > 0)
			$artf_user =  mysql_fetch_assoc($rs);
		
			
		return $artf_user;
	}
	
	//Function to get particular field value
	function fieldValue($field = "rpt_reg_id",$id = "",$condition = "",$order = "")
	{
		$rs = $this->fetchRecordSet($id, $condition, $order);
		$ret = 0;
		while($rw = mysql_fetch_assoc($rs))
		{
			$ret = $rw[$field];
		}
		return $ret;
	}
	
	//Function to delete record from table
	function delete() 
	{			
		$entryDetailArr = $this->setAllValues($this->checkedids);
		
		print_r($entryDetailArr);
		
		
		$regdate_arr = explode(" ", $entryDetailArr['voting_date']);
		$regrime_arr = explode(":", $regdate_arr[1]);
		
		$query_regsource = "";
		$query_timing = "";
		
		if($entryDetailArr['voter_reg_source'] == "Website")
			$query_regsource = ", tot_cnt_website = (tot_cnt_website-1) ";
		else if($entryDetailArr['voter_reg_source'] == "Facebook")
			$query_regsource = ", tot_cnt_facebook = (tot_cnt_facebook-1) ";
		else if($entryDetailArr['voter_reg_source'] == "Gadget")
			$query_regsource = ", tot_cnt_gadget = (tot_cnt_gadget-1) ";
		
		if($regrime_arr[0] >= 18)
			$query_timing = ", cnt_6_to_mid = (cnt_6_to_mid-1) ";
		else if($regrime_arr[0] >= 15)
			$query_timing = ", cnt_3_to_6 = (cnt_3_to_6-1) ";
		else if($regrime_arr[0] >= 12)
			$query_timing = ", cnt_noon_to_3 = (cnt_noon_to_3-1) ";
		else if($regrime_arr[0] >= 10)
			$query_timing = ", cnt_10_to_noon = (cnt_10_to_noon-1) ";
		else if($regrime_arr[0] >= 7)
			$query_timing = ", cnt_7_to_10 = (cnt_7_to_10-1) ";
		else
			$query_timing = ", cnt_mid_to_7 = (cnt_mid_to_7-1) ";
				
		$sQuery = "update ".REPORT_DB_PREFIX."rpt_datetiming_reg set tot_cnt = (tot_cnt-1)".$query_timing." WHERE reg_date = '".$regdate_arr[0]."' AND client_id='".$entryDetailArr['client_id']."'";
		$this->runquery($sQuery);
		
		$sQuery = "update ".REPORT_DB_PREFIX."rpt_date_source_reg set tot_registration = (tot_registration-1)".$query_regsource." WHERE reg_date = '".$regdate_arr[0]."' AND client_id='".$entryDetailArr['client_id']."'";
		$this->runquery($sQuery);
		
		$sQuery = "update ".REPORT_DB_PREFIX."rpt_state_reg set tot_cnt = (tot_cnt-1) WHERE reg_date = '".$regdate_arr[0]."' AND client_id='".$entryDetailArr['client_id']."' And state_id='".$entryDetailArr['voter_state_id']."'";
		$this->runquery($sQuery);
		
		$sQuery = "DELETE FROM ".REPORT_DB_PREFIX."rpt_registration  WHERE rpt_reg_id in(".$this->checkedids.")";
		$this->runquery($sQuery);
		
		$sQuery = "DELETE FROM ".REPORT_DB_PREFIX."rpt_datetiming_reg  WHERE tot_cnt = '0'";
		$this->runquery($sQuery);
		
		$sQuery = "DELETE FROM ".REPORT_DB_PREFIX."rpt_date_source_reg  WHERE tot_registration = '0'";
		$this->runquery($sQuery);
		
		$sQuery = "DELETE FROM ".REPORT_DB_PREFIX."rpt_state_reg  WHERE tot_cnt = '0'";
		$this->runquery($sQuery);
		
		$sQuery = "DELETE FROM ".DB_PREFIX."entry_detail  WHERE entry_id in(select entry_id FROM ".DB_PREFIX."entry  WHERE voter_id in(".$this->checkedids."))";
		$this->runquery($sQuery);	
		
		$sQuery = "DELETE FROM ".DB_PREFIX."entry  WHERE voter_id in(".$this->checkedids.")";
		$this->runquery($sQuery);
		
		$sQuery = "DELETE FROM ".DB_PREFIX."voter  WHERE voter_id in(".$this->checkedids.")";
		$this->runquery($sQuery);
	}
}
?>