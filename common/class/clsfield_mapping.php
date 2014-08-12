<?php
class field_mapping extends common
{
	/* decalre general variables */
	
	function get_all_mapping_field($client_id  = 0, $mode="Add")
	{	
		$arrlist = array();
		
		if($client_id != 0)
			$condition  = " AND field_mapping_id not in (select distinct(field_mapping_id) From ".DB_PREFIX."field where (client_id = '0' or client_id = '".$client_id."') and field_mapping_id in (7,8,9,10,11,13,14,15,16,17)) ";
		else
		{
			if($mode != "Add")
				$condition  = "";
			else
				$condition  = " AND field_mapping_id not in (select distinct(field_mapping_id) From ".DB_PREFIX."field where client_id = '0' and field_mapping_id in (7,8,9,10,11)) ";
		}	
		
		$i = 0;
		$strquery="SELECT * FROM ".DB_PREFIX."field_mapping WHERE 1 = 1 AND field_mapping_isactive = '1' ".$condition." ORDER BY `field_mapping_id`";
		// echo $strquery;
		$rs=mysql_query($strquery);
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_contest_plan= mysql_fetch_array($rs))
			{
				$arrlist[$i]["field_mapping_id"] = $artf_contest_plan["field_mapping_id"];
				$arrlist[$i]["field_mapping_name"] = $artf_contest_plan["field_mapping_name"];
				$arrlist[$i]["field_mapping_image"] = $artf_contest_plan["field_mapping_image"];
				$i++;
			}
		}
		return $arrlist;
	}
	
	function getmapping_field($mapping_id)
	{
		$arrlist = array();
		$i = 0;
		$strquery="SELECT * FROM ".DB_PREFIX."field_mapping_child WHERE field_mapping_id = ".$mapping_id." ORDER BY `order`";
		//echo $strquery;
		$rs=mysql_query($strquery);
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_contest_plan= mysql_fetch_array($rs))
			{
				$arrlist[$i]["field_mapping_child_id"] = $artf_contest_plan["field_mapping_child_id"];
				$arrlist[$i]["field_type_id"] = $artf_contest_plan["field_type_id"];
				$arrlist[$i]["field_mapping_id"] = $artf_contest_plan["field_mapping_id"];
				$arrlist[$i]["field_name"] = $artf_contest_plan["field_name"];
				$arrlist[$i]["label_name"] = $artf_contest_plan["label_name"];
				$arrlist[$i]["order"] = $artf_contest_plan["order"];
				$i++;
			}
		}
		return $arrlist;
	}
	
	function getcontest_mapping_options($contest_id)
	{
		$arrlist = array();
		$i = 0;
		$strquery="SELECT * FROM ".DB_PREFIX."field_mapping_child WHERE field_mapping_id = ".$mapping_id." ORDER BY `order`";
		//echo $strquery;
		$rs=mysql_query($strquery);
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_contest_plan= mysql_fetch_array($rs))
			{
				$arrlist[$i]["field_mapping_child_id"] = $artf_contest_plan["field_mapping_child_id"];
				$arrlist[$i]["field_type_id"] = $artf_contest_plan["field_type_id"];
				$arrlist[$i]["field_mapping_id"] = $artf_contest_plan["field_mapping_id"];
				$arrlist[$i]["field_name"] = $artf_contest_plan["field_name"];
				$arrlist[$i]["label_name"] = $artf_contest_plan["label_name"];
				$arrlist[$i]["order"] = $artf_contest_plan["order"];
				$i++;
			}
		}
		return $arrlist;
	}
}