<?php
class cron_report extends common
{
	function cron_report()
	{
	}
	
	function addStateRptDetail($date = "", $last_voter_id = "")
	{
		$condition = "";

		if($date != "")
			$condition = " and date(v.created_date) = '".$date."' ";

		if($last_voter_id != "")
			$condition.= " and v.voter_id <= '".$last_voter_id."' ";

		$sQuery =  "DELETE From ".DB_PREFIX."rpt_state_reg where reg_date = '".$date."'";
		$this->runquery($sQuery);


		$sQuery1 =  "INSERT INTO ".DB_PREFIX."rpt_state_reg (client_id, state_id, reg_date, state_code, state_name, tot_cnt)
					Select v.client_id, v.voter_state_id, date(v.created_date) as reg_date, s.state_code , s.state_name, count(voter_id) as tot_cnt  from ".MAIN_DB_NAME.".".DB_PREFIX."voter v, ".MAIN_DB_NAME.".".DB_PREFIX."state s where s.state_id = v.voter_state_id ".$condition." group by client_id, v.voter_state_id, date(v.created_date) order by reg_date";
		$this->runquery($sQuery1);
	}

	function addRegSourceRptDetail($date = "", $last_voter_id = "")
	{
		$condition = "";

		if($date != "")
			$condition = " and date(v.created_date) = '".$date."' ";

		if($last_voter_id != "")
			$condition.= " and v.voter_id <= '".$last_voter_id."' ";

		$sQuery =  "DELETE From ".DB_PREFIX."rpt_date_source_reg where reg_date = '".$date."'";
		$this->runquery($sQuery);


		$sQuery1 =  "INSERT INTO ".DB_PREFIX."rpt_date_source_reg (client_id, reg_date, tot_cnt_website, tot_cnt_facebook, tot_cnt_gadget, tot_cnt_api, tot_cnt_mobile,tot_registration)
					Select v.client_id, date(v.created_date) as reg_date, (select count(*) as tot_website from ".MAIN_DB_NAME.".".DB_PREFIX."voter v1 where voter_reg_source='Website' and v1.client_id = v.client_id and date(v1.created_date) = date(v.created_date)) as tot_cnt_website, (select count(*) as tot_facebook from ".MAIN_DB_NAME.".".DB_PREFIX."voter v1 where voter_reg_source='Facebook' and v1.client_id = v.client_id  and date(v1.created_date) = date(v.created_date)) as tot_cnt_facebook, (select count(*) as tot_gadget from ".MAIN_DB_NAME.".".DB_PREFIX."voter v1 where voter_reg_source='Gadget' and v1.client_id = v.client_id  and date(v1.created_date) = date(v.created_date)) as tot_cnt_gadget, (select count(*) as tot_api from ".MAIN_DB_NAME.".".DB_PREFIX."voter v1 where voter_reg_source='APl' and v1.client_id = v.client_id  and date(v1.created_date) = date(v.created_date)) as tot_cnt_api, (select count(*) as tot_mobile from ".MAIN_DB_NAME.".".DB_PREFIX."voter v1 where voter_reg_source='Mobile' and v1.client_id = v.client_id  and date(v1.created_date) = date(v.created_date)) as tot_cnt_mobile, count(voter_id) as tot_cnt  from ".MAIN_DB_NAME.".".DB_PREFIX."voter v where 1=1 ".$condition." group by client_id, date(v.created_date) order by reg_date";

		$this->runquery($sQuery1);
	}

	function addRegTimingDetail($date = "", $last_voter_id = "")
	{
		$condition = "";

		if($date != "")
			$condition = " and date(v.created_date) = '".$date."' ";

		if($last_voter_id != "")
			$condition.= " and v.voter_id <= '".$last_voter_id."' ";

		$sQuery =  "DELETE From ".DB_PREFIX."rpt_datetiming_reg where reg_date = '".$date."'";
		$this->runquery($sQuery);
		
		$start_slot1 = $date." "."00:00:00";
		$end_slot1 = $date." "."07:00:00";
		$start_slot2 = $date." "."07:00:01";
		$end_slot2 = $date." "."10:00:00";
		$start_slot3 = $date." "."10:00:01";
		$end_slot3 = $date." "."12:00:00";
		$start_slot4 = $date." "."12:00:01";
		$end_slot4 = $date." "."15:00:00";
		$start_slot5 = $date." "."15:00:01";
		$end_slot5 = $date." "."18:00:00";
		$start_slot6 = $date." "."18:00:01";
		$end_slot6 = $date." "."23:59:59";
		
		$query_slot1 = "(select count(*) as tot_mid_to_7 from ".MAIN_DB_NAME.".".DB_PREFIX."voter v1 where v1.client_id = v.client_id and v1.created_date >= '".$start_slot1."' and v1.created_date <= '".$end_slot1."') as cnt_mid_to_7";
		$query_slot2 = "(select count(*) as tot_7_to_10 from ".MAIN_DB_NAME.".".DB_PREFIX."voter v1 where v1.client_id = v.client_id and v1.created_date >= '".$start_slot2."' and v1.created_date <= '".$end_slot2."') as cnt_7_to_10";
		$query_slot3 = "(select count(*) as tot_10_to_noon from ".MAIN_DB_NAME.".".DB_PREFIX."voter v1 where v1.client_id = v.client_id and v1.created_date >= '".$start_slot3."' and v1.created_date <= '".$end_slot3."') as cnt_10_to_noon";
		$query_slot4 = "(select count(*) as tot_noon_to_3 from ".MAIN_DB_NAME.".".DB_PREFIX."voter v1 where v1.client_id = v.client_id and v1.created_date >= '".$start_slot4."' and v1.created_date <= '".$end_slot4."') as cnt_noon_to_3";
		$query_slot5 = "(select count(*) as tot_3_to_6 from ".MAIN_DB_NAME.".".DB_PREFIX."voter v1 where v1.client_id = v.client_id and v1.created_date >= '".$start_slot5."' and v1.created_date <= '".$end_slot5."') as cnt_3_to_6";
		$query_slot6 = "(select count(*) as tot_6_to_mid from ".MAIN_DB_NAME.".".DB_PREFIX."voter v1 where v1.client_id = v.client_id and v1.created_date >= '".$start_slot6."' and v1.created_date <= '".$end_slot6."') as cnt_6_to_mid";


		$sQuery1 =  "INSERT INTO ".DB_PREFIX."rpt_datetiming_reg (client_id, reg_date, cnt_mid_to_7, cnt_7_to_10, cnt_10_to_noon, cnt_noon_to_3, cnt_3_to_6, cnt_6_to_mid, tot_cnt)
					Select v.client_id, date(v.created_date) as reg_date, ".$query_slot1.", ".$query_slot2.", ".$query_slot3.", ".$query_slot4.", ".$query_slot5.", ".$query_slot6.", count(voter_id) as tot_cnt  from ".MAIN_DB_NAME.".".DB_PREFIX."voter v where 1=1 ".$condition." group by client_id, date(v.created_date) order by reg_date";
		
		$this->runquery($sQuery1);
	}
	
	function addHitDetail($date = "", $last_voter_id = "")
	{
		$condition = "";

		if($date != "")
			$condition = " and visit_date = '".$date."' ";

		$sQuery =  "DELETE From ".DB_PREFIX."rpt_page_hit where reg_date = '".$date."'";
		$this->runquery($sQuery);


		$sQuery1 =  "INSERT INTO ".DB_PREFIX."rpt_page_hit (`client_id`, `reg_date`, `page_id`, `tot_cnt`)
					Select client_id, '".$date."',page_id, total_visits from ".MAIN_DB_NAME.".".DB_PREFIX."website_page_visits wpv where 1=1 ".$condition." order by website_visits_id ";
		$this->runquery($sQuery1);
		
		$sQuery1 =  "DELETE From ".DB_PREFIX."rpt_page_hit where page_id > 0 AND page_id NOT in (select page_id from ".DB_PREFIX."rpt_website_pages)";
		$this->runquery($sQuery1);
	}

	function addClientDetail()
	{
		$sQuery =  "TRUNCATE TABLE ".DB_PREFIX."rpt_client";
		$this->runquery($sQuery);

		$sQuery1 =  "INSERT INTO ".DB_PREFIX."rpt_client (client_id, client_name, client_username, client_domain, client_email)
					Select c.client_id, CONCAT(u.user_firstname,' ', u.user_lastname) as client_name, u.user_username, w.domain, u.user_email from ".MAIN_DB_NAME.".".DB_PREFIX."client c, ".MAIN_DB_NAME.".".DB_PREFIX."user u, ".MAIN_DB_NAME.".".DB_PREFIX."website w where c.client_id = u.client_id and  c.client_id = w.client_id and u.user_type_id = '3' order by c.client_id";

		$this->runquery($sQuery1);
	}
	
	function addPageDetail()
	{
		$sQuery =  "TRUNCATE TABLE ".DB_PREFIX."rpt_website_pages";
		$this->runquery($sQuery);

		$sQuery1 =  "INSERT INTO ".DB_PREFIX."rpt_website_pages (page_id, client_id, page_name)
					Select wp.page_id, wp.client_id, wp.page_name from ".MAIN_DB_NAME.".".DB_PREFIX."website_pages wp order by wp.page_id ";

		$this->runquery($sQuery1);
	}
	
	function addFieldDetail()
	{
		$sQuery =  "TRUNCATE TABLE ".DB_PREFIX."rpt_field";
		$this->runquery($sQuery);

		$sQuery1 =  "INSERT INTO ".DB_PREFIX."rpt_field (rpt_field_id, client_id, form_id, field_type_id, field_mapping_id, field_header_field, reg_type, pdf_field_name, field_name, field_caption, field_note, is_required, field_ishide, field_iscondition, field_order, field_isactive)
					Select f.field_id, f.client_id, f.form_id, f.field_type_id, f.field_mapping_id, f.field_header_field, f.reg_type, f.pdf_field_name, f.field_name, f.field_caption, f.field_note, f.is_required, f.field_ishide, f.field_iscondition, f.field_order, f.field_isactive from ".MAIN_DB_NAME.".".DB_PREFIX."field f order by f.field_id";

		$this->runquery($sQuery1);
	}

	function getLastVoterId()
	{
		$sQuery1 =  "Select Max(voter_id) as last_voter_id from ".MAIN_DB_NAME.".".DB_PREFIX."voter ";
		$rs  =  $this->runquery($sQuery1);

		$rw = mysql_fetch_assoc($rs);
		$ret = $rw['last_voter_id'];

		return $ret;
	}

	function getRptMasterInformation()
	{
		$sQuery1 =  "Select * from ".DB_PREFIX."rpt_master order by report_id desc limit 0,1 ";
		$rs  =  $this->runquery($sQuery1);

		$masterArr = array();
		if(mysql_num_rows($rs) > 0)
		{
			$masterArr = mysql_fetch_assoc($rs);
		}

		return $masterArr;
	}

	function addRptMasterInformation($date, $last_voter_id, $last_field_id)
	{
		$sQuery1 =  "INSERT INTO ".DB_PREFIX."rpt_master (last_voter_id, report_date, last_field_id) values ('".$last_voter_id."','".$date."', '".$last_field_id."')";

		$this->runquery($sQuery1);
	}
	
	function alterRegistrationTable($last_field_id)
	{
		$sQuery1 =  "Select * from ".DB_PREFIX."rpt_field where rpt_field_id > '".$last_field_id."'";
		$rs  =  $this->runquery($sQuery1);
		
		$tbl_field = "";
		if(mysql_num_rows($rs) > 0)
		{
			while($arField = mysql_fetch_array($rs))			
			{
				if($arField['field_mapping_id'] != 1)
				{				
					if($arField['field_mapping_id'] == 11)
						$field_type = "varchar(255)";
					else if($arField['field_mapping_id'] == 14 || $arField['field_mapping_id'] == 16)
						$field_type = "int(11)";
					else if($arField['field_mapping_id'] == 13 || $arField['field_mapping_id'] == 15 || $arField['field_mapping_id'] == 7 || $arField['field_mapping_id'] == 8 || $arField['field_mapping_id'] == 9 || $arField['field_mapping_id'] == 10)
						$field_type = "varchar(255)";	
					else
						$field_type = "text";

					$fieldname = "field_".$arField['rpt_field_id'];
					
					$last_field_id = $arField['rpt_field_id'];
					
					if($tbl_field == "")
						$tbl_field.= " ADD ".$fieldname." ".$field_type;
					else	
						$tbl_field.= ", ADD ".$fieldname."  ".$field_type;
				}									
			}
			
			if($tbl_field != "")	
			{
				$sql = "ALTER TABLE ".DB_PREFIX."rpt_registration ".$tbl_field;
				$this->runquery($sql);
			}
		}
		
		return $last_field_id;
	}
	
	function addVoterRegistrationDetail($last_voter_id, $new_last_voter_id)
	{	
		$sQuery1 =  "Select rpt_field_id, field_mapping_id  from ".DB_PREFIX."rpt_field where field_header_field <> '0'";
		$rs  =  $this->runquery($sQuery1);
		
		$pivotQuery = "";
		$insertField = "";
		
		if(mysql_num_rows($rs) > 0)
		{
			while($arField = mysql_fetch_assoc($rs))			
			{
				$insertField.= ", field_".$arField['rpt_field_id'];
				$pivotQuery.= ", Max(IF(trim(field_id) = '".$arField['rpt_field_id']."', trim(field_value), NULL)) AS 'field_".$arField['rpt_field_id']."'";
			}
		}	
		
		$sQuery1 =  "INSERT into ".DB_PREFIX."rpt_registration (client_id, voter_id, voter_email, voter_state_id, voter_zipcode, voter_language_id, voter_reg_source, voting_date".$insertField.") Select v.client_id, v.voter_id, v.voter_email, v.voter_state_id, IF(voter_zipcode <> '',voter_zipcode,NULL) as voter_zipcode, e.language_id, v.voter_reg_source, v.created_date ".$pivotQuery." from ".MAIN_DB_NAME.".".DB_PREFIX."voter as v, ".MAIN_DB_NAME.".".DB_PREFIX."entry as e, ".MAIN_DB_NAME.".".DB_PREFIX."entry_detail as ed where v.voter_id > '".$last_voter_id."' and v.voter_id <= '".$new_last_voter_id."' and v.voter_id = e.voter_id and e.entry_id = ed.entry_id group by e.entry_id order by v.voter_id";
				
		$rs  =  $this->runquery($sQuery1);
		
		$sQuery1 =  "Select rpt_field_id, field_mapping_id  from ".DB_PREFIX."rpt_field where field_mapping_id = '3'";
		$rs  =  $this->runquery($sQuery1);
		
		if(mysql_num_rows($rs) > 0)
		{
			while($arField = mysql_fetch_assoc($rs))			
			{
				$sQuery1 =  "update ".DB_PREFIX."rpt_registration set field_".$arField['rpt_field_id'] ." = 'Yes' where field_".$arField['rpt_field_id'] ." <> '' and voter_id > '".$last_voter_id."'";
				
				$rs1  =  $this->runquery($sQuery1);
			}
		}	
		
		$sQuery1 =  "Select rpt_field_id, field_mapping_id  from ".DB_PREFIX."rpt_field where field_mapping_id = '2' or field_mapping_id = '4'";
		$rs  =  $this->runquery($sQuery1);
		
		if(mysql_num_rows($rs) > 0)
		{
			while($arField = mysql_fetch_assoc($rs))			
			{
				$sQuery1 =  "update ".DB_PREFIX."rpt_registration as r inner join (SELECT rpt_reg_id, GROUP_CONCAT(field_option) as field_options FROM ".DB_PREFIX."rpt_registration err, ".MAIN_DB_NAME.".".DB_PREFIX."field_option efo WHERE err.field_".$arField['rpt_field_id'] ." <> '' AND FIND_IN_SET(field_option_id,REPLACE(REPLACE(err.field_".$arField['rpt_field_id'] .",' ',''),'_',',')) GROUP BY rpt_reg_id) as tmp on tmp.rpt_reg_id = r.rpt_reg_id set field_".$arField['rpt_field_id'] ." = tmp.field_options where r.field_".$arField['rpt_field_id'] ." <> '' and r.voter_id > '".$last_voter_id."'";				
				$rs1  =  $this->runquery($sQuery1);
			}
		}		
	}
}
?>