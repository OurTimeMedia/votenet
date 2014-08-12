<?php
class topclientreport
{
	var $pagingType;
	var $noofdays;
	function topclientdetail($fromdate='',$todate='',$order='tot_cnt')
	{
		 $sql="SELECT * ,sum( tot_registration ) AS tot_cnt
		FROM ".REPORT_DB_PREFIX."rpt_date_source_reg rds
		left join ".REPORT_DB_PREFIX."rpt_client rc on rc.client_id=rds.client_id
		where 1=1 ";
		if($fromdate && $todate=='')
		{
			$sql .= " and reg_date>=".$fromdate;
		}	
		if($todate && $fromdate=='')
		{
			$sql .= " and reg_date<= ".$todate;
		}	
		if($todate!='' && $fromdate!='')
			$sql .= " and reg_date between '".$fromdate."' and '".$todate."'";

		$sql .= " GROUP BY rds.client_id ";
		
		if($order!='')
			$sql .= " order by ".$order;
			
		$sql .= " limit 0,10 ";
		//echo $sql;
		$rs=mysql_query($sql);
		$i=0;
		$arrlist=array();
		while($arrpt= mysql_fetch_array($rs))
		{
			$arrlist[$i]["client_id"] = $arrpt["client_id"];
			$arrlist[$i]["reg_date"] = $arrpt["reg_date"];
			$arrlist[$i]["tot_cnt"] = $arrpt["tot_cnt"];
			$arrlist[$i]["client_name"] = $arrpt["client_username"];
			$arrlist[$i]["tot_cnt_website"] = $arrpt["tot_cnt_website"];
			$arrlist[$i]["tot_cnt_facebook"] = $arrpt["tot_cnt_facebook"];
			$arrlist[$i]["tot_cnt_gadget"] = $arrpt["tot_cnt_gadget"];
			$arrlist[$i]["tot_cnt_api"] = $arrpt["tot_cnt_api"];	
			$i++;
		}	
		return $arrlist;
	}
	function topresourcedetail($fromdate='',$todate='',$client_id='')
	{
		 $sql="SELECT sum( tot_cnt_website ) AS tot_cnt_website,sum( tot_cnt_facebook ) AS tot_cnt_facebook,sum(tot_cnt_gadget) AS tot_cnt_gadget
		FROM ".REPORT_DB_PREFIX."rpt_date_source_reg where 1=1 ";
		if($fromdate && $todate=='')
		{
			$sql .= " and reg_date>=".$fromdate;
		}	
		if($todate && $fromdate=='')
		{
			$sql .= " and reg_date<= ".$todate;
		}	
		if($todate!='' && $fromdate!='')
			$sql .= " and reg_date between '".$fromdate."' and '".$todate."'";
		if($client_id!='')
			$sql .=" and client_id=".$client_id;
	//	$sql .= " GROUP BY client_id limit 0,10";
		//echo $sql;
		$rs=mysql_query($sql);
		$i=0;
		$arrlist=array();
		while($arrpt= mysql_fetch_array($rs))
		{
			$arrlist[$i]["tot_cnt_website"] = $arrpt["tot_cnt_website"];
			$arrlist[$i]["tot_cnt_facebook"] = $arrpt["tot_cnt_facebook"];
			$arrlist[$i]["tot_cnt_gadget"] = $arrpt["tot_cnt_gadget"];
			//$arrlist[$i]["tot_cnt_api"] = $arrpt["tot_cnt_api"];	
		}	
		return $arrlist;
	}
	function statebystatereport($id="",$condition="",$order="tot_cnt")
	{
		$sql="select sum(tot_cnt) as tot_cnt,state_name from ".REPORT_DB_PREFIX."rpt_state_reg where 1=1";
		$sql .= $condition;
		$sql .=" group by state_id";
		$sql .=" order by ".$order;
		//echo $sql;
		return mysql_query($sql);
	}
	function toptenstatereport($id="",$condition="")
	{
		$sql="select sum(tot_cnt) as tot_cnt,state_name from ".REPORT_DB_PREFIX."rpt_state_reg where 1=1";
		$sql .= $condition;
		$sql .=" group by state_id ";
		$sql .=" order by tot_cnt desc limit 0,10";
	//	echo $sql;
		return mysql_query($sql);
	}
	function mostactivedaysreport($id="",$condition="")
	{
		$sql="select sum(tot_registration) as tot_cnt,reg_date from ".REPORT_DB_PREFIX."rpt_date_source_reg where 1=1";
		$sql .= $condition;
		$sql .=" group by reg_date ";
		$sql .=" order by tot_cnt desc limit 0,".$this->noofdays;
		//echo $sql;
		return mysql_query($sql);
	}
	
	function mostactivetimereport($fromdate='',$client_id='',$order='rds.tot_cnt')
	{
		 $sql="SELECT sum( cnt_mid_to_7 ) AS cnt_mid_to_7,sum( cnt_7_to_10 ) AS cnt_7_to_10,sum(cnt_10_to_noon) AS cnt_10_to_noon,sum( cnt_noon_to_3 ) AS cnt_noon_to_3,sum( cnt_3_to_6 ) AS cnt_3_to_6,sum( cnt_6_to_mid ) AS cnt_6_to_mid, sum(tot_cnt) AS tot_cnt 
		FROM ".REPORT_DB_PREFIX."rpt_datetiming_reg  where 1=1 ";
		
		if($fromdate )
		{
			$sql .= " and reg_date='".$fromdate."'";
		}	
		
		if($client_id)
			$sql .= " and client_id=".$client_id;
		
	//	$sql .= " GROUP BY client_id limit 0,10";
		//echo $sql;
		$rs=mysql_query($sql);
		$i=0;
		$arrlist=array();
		while($arrpt= mysql_fetch_array($rs))
		{

			$arrlist[$i]["cnt_mid_to_7"] = $arrpt["cnt_mid_to_7"];
			$arrlist[$i]["cnt_7_to_10"] = $arrpt["cnt_7_to_10"];
			$arrlist[$i]["cnt_10_to_noon"] = $arrpt["cnt_10_to_noon"];
			$arrlist[$i]["cnt_noon_to_3"] = $arrpt["cnt_noon_to_3"];
			$arrlist[$i]["cnt_3_to_6"] = $arrpt["cnt_3_to_6"];
			$arrlist[$i]["cnt_6_to_mid"] = $arrpt["cnt_6_to_mid"];	
			$arrlist[$i]["tot_cnt"] = $arrpt["tot_cnt"];	
		}	
		return $arrlist;
	}
	function hitreport($id="",$condition="",$orderby=tot_cnt)
	{
		$sql="SELECT sum( tot_cnt ) AS tot_cnt,page_name	FROM ".REPORT_DB_PREFIX."rpt_page_hit  
		left join ".REPORT_DB_PREFIX."rpt_website_pages on ".REPORT_DB_PREFIX."rpt_website_pages.page_id=".REPORT_DB_PREFIX."rpt_page_hit.page_id
		where 1=1 ";
		$sql .= $condition;
		$sql .= " GROUP BY ".REPORT_DB_PREFIX."rpt_page_hit.page_id  ";
		if($orderby!='')
			$sql .=" order by ".$orderby;
		//echo $sql;
		$rs=mysql_query($sql);
		return $rs;
	}
	function datewisedetail($fromdate='',$todate='',$order='rds.tot_cnt',$client_id = "")
	{
		 $sql="SELECT * ,sum( tot_registration ) AS tot_cnt
		FROM ".REPORT_DB_PREFIX."rpt_date_source_reg rds
		left join ".REPORT_DB_PREFIX."rpt_client rc on rc.client_id=rds.client_id
		where 1=1 ";
		if($fromdate && $todate=='')
		{
			$sql .= " and reg_date>=".$fromdate;
		}	
		if($todate && $fromdate=='')
		{
			$sql .= " and reg_date<= ".$todate;
		}	
		if($todate!='' && $fromdate!='')
			$sql .= " and reg_date between '".$fromdate."' and '".$todate."'";
		if($client_id!='')
			$sql .=" and rds.client_id=".$client_id;
		
		$sql .= " GROUP BY rds.reg_date ";
		
		if($order!='')
			$sql .= " order by ".$order;
		else	
			$sql .= " order by rds.reg_date asc";
			
		$rs=mysql_query($sql);
		$i=0;
		$arrlist=array();
		while($arrpt= mysql_fetch_array($rs))
		{
			$arrlist[$i]["client_id"] = $arrpt["client_id"];
			$arrlist[$i]["reg_date"] = $arrpt["reg_date"];
			$arrlist[$i]["tot_cnt"] = $arrpt["tot_cnt"];
			$arrlist[$i]["client_name"] = $arrpt["client_name"];
			$arrlist[$i]["tot_cnt_website"] = $arrpt["tot_cnt_website"];
			$arrlist[$i]["tot_cnt_facebook"] = $arrpt["tot_cnt_facebook"];
			$arrlist[$i]["tot_cnt_gadget"] = $arrpt["tot_cnt_gadget"];
			$arrlist[$i]["tot_cnt_api"] = $arrpt["tot_cnt_api"];
			$i++;			
		}	
		return $arrlist;
	}
	function datewiseNextdetail($fromdate='',$client_id = "")
	{
		 $sql="SELECT * ,sum( tot_registration ) AS tot_cnt
		FROM ".REPORT_DB_PREFIX."rpt_date_source_reg rds
		left join ".REPORT_DB_PREFIX."rpt_client rc on rc.client_id=rds.client_id
		where 1=1 ";
		if($fromdate!='')
		{
			$sql .= " and reg_date > '".$fromdate."'";
		}	
		
		if($client_id!='')
			$sql .=" and rds.client_id=".$client_id;
		$sql .= " GROUP BY rds.reg_date ";
		$sql .= " order by reg_date asc limit 0,10";
		//echo $sql;
		$rs=mysql_query($sql);
		$i=0;
		$arrlist=array();
		while($arrpt= mysql_fetch_array($rs))
		{
			$arrlist[$i]["client_id"] = $arrpt["client_id"];
			$arrlist[$i]["reg_date"] = $arrpt["reg_date"];
			$arrlist[$i]["tot_cnt"] = $arrpt["tot_cnt"];
			$arrlist[$i]["client_name"] = $arrpt["client_name"];
			$arrlist[$i]["tot_cnt_website"] = $arrpt["tot_cnt_website"];
			$arrlist[$i]["tot_cnt_facebook"] = $arrpt["tot_cnt_facebook"];
			$arrlist[$i]["tot_cnt_gadget"] = $arrpt["tot_cnt_gadget"];
			$arrlist[$i]["tot_cnt_api"] = $arrpt["tot_cnt_api"];
			$i++;			
		}	
		return $arrlist;
	}
	function datewisePrevdetail($fromdate='',$client_id="")
	{
		 $sql="SELECT * ,sum( tot_registration ) AS tot_cnt
		FROM ".REPORT_DB_PREFIX."rpt_date_source_reg rds
		left join ".REPORT_DB_PREFIX."rpt_client rc on rc.client_id=rds.client_id
		where 1=1 ";
		if($fromdate!='')
		{
			$sql .= " and reg_date <= '".$fromdate."'";
		}	
		
		if($client_id!='')
			$sql .=" and rds.client_id=".$client_id;
		$sql .= " GROUP BY rds.reg_date ";
		$sql .= " order by reg_date asc limit 0,10";
		//echo $sql;
		$rs=mysql_query($sql);
		$i=0;
		$arrlist=array();
		while($arrpt= mysql_fetch_array($rs))
		{
			$arrlist[$i]["client_id"] = $arrpt["client_id"];
			$arrlist[$i]["reg_date"] = $arrpt["reg_date"];
			$arrlist[$i]["tot_cnt"] = $arrpt["tot_cnt"];
			$arrlist[$i]["client_name"] = $arrpt["client_name"];
			$arrlist[$i]["tot_cnt_website"] = $arrpt["tot_cnt_website"];
			$arrlist[$i]["tot_cnt_facebook"] = $arrpt["tot_cnt_facebook"];
			$arrlist[$i]["tot_cnt_gadget"] = $arrpt["tot_cnt_gadget"];
			$arrlist[$i]["tot_cnt_api"] = $arrpt["tot_cnt_api"];
			$i++;			
		}	
		return $arrlist;
	}
	function monthwisedetail($id="",$condition="",$orderby='tot_cnt')
	{
		 $sql="SELECT * ,sum( rds.tot_cnt ) AS tot_cnt,Monthname(reg_date) as month,year(reg_date) as year
		FROM ".REPORT_DB_PREFIX."rpt_state_reg rds
		left join ".REPORT_DB_PREFIX."rpt_client rc on rc.client_id=rds.client_id
		where 1=1 ".$condition;
		$sql .= " GROUP BY month,year  ";
		if($orderby!='')
			$sql .= " order by ".$orderby;
		//echo $sql;
		$rs=mysql_query($sql);
		
		return $rs;
	}
	function statedetail($client_id)
	{
		$sql="select DISTINCT(state_id)as state_id,state_name,state_code from ".REPORT_DB_PREFIX."rpt_state_reg rsr where client_id= ".$client_id." order by state_name";
		$rs=mysql_query($sql);
		$i=0;
		$arrlist=array();
		while($arrpt= mysql_fetch_array($rs))
		{
			$arrlist[$i]["state_id"] = $arrpt["state_id"];
			$arrlist[$i]["state_name"] = $arrpt["state_name"];
			$arrlist[$i]["state_code"] = $arrpt["state_code"];
			$i++;
		}	
		return $arrlist;
	}
	function activedaysdetail($id="",$condition="",$orderby='tot_cnt',$limit=10)
	{
		$sql="SELECT * ,sum( rds.tot_cnt ) AS tot_cnt
		FROM ".REPORT_DB_PREFIX."rpt_datetiming_reg rds
		left join ".REPORT_DB_PREFIX."rpt_client rc on rc.client_id=rds.client_id
		where 1=1 ".$condition;
		$sql .= " GROUP BY reg_date ";
		if($orderby!='')
			$sql .= " order by ".$orderby;
		$sql .=" limit 0,".$limit;	
		//echo $sql;
		$rs=mysql_query($sql);
		return $rs;
	}
	function activenextdaysdetail($condition="",$limit=10,$orderby='tot_cnt')
	{
		$sql="SELECT * ,sum( rds.tot_cnt ) AS tot_cnt
		FROM ".REPORT_DB_PREFIX."rpt_datetiming_reg rds
		left join ".REPORT_DB_PREFIX."rpt_client rc on rc.client_id=rds.client_id
		where 1=1 ".$condition;
		$sql .= " GROUP BY reg_date ";
		if($orderby!='')
			$sql .= " order by ".$orderby;
		$sql .=" limit 0,".$limit;	
	
		//echo $sql;
		$rs=mysql_query($sql);
		$i=0;
		$arrlist=array();
		while($arrpt= mysql_fetch_array($rs))
		{
			$arrlist[$i]["reg_date"] = $arrpt["reg_date"];
			$arrlist[$i]["tot_cnt"] = $arrpt["tot_cnt"];
			$i++;
		}	
		return $arrlist;
	}
	function registrantdetail($id="",$condition="",$order="voter_email",$fields='*')
	{
		$sql="select ".$fields." rpt_reg_id,client_id,voter_email from ".REPORT_DB_PREFIX."rpt_registration
		left join ".REPORT_DB_PREFIX."rpt_state on ".REPORT_DB_PREFIX."rpt_state.state_id=".REPORT_DB_PREFIX."rpt_registration.voter_state_id
		where 1=1";
		$sql .= $condition;
		
		$sql .=" order by ".$order;
		//echo "<br><br>".$sql."<br><br>";
		return mysql_query($sql);
	}
	function activeprevdaysdetail($condition="",$limit=10,$orderby='tot_cnt')
	{
		$sql="SELECT * ,sum( rds.tot_cnt ) AS tot_cnt
		FROM ".REPORT_DB_PREFIX."rpt_datetiming_reg rds
		left join ".REPORT_DB_PREFIX."rpt_client rc on rc.client_id=rds.client_id
		where 1=1 ".$condition;
		$sql .= " GROUP BY reg_date ";
		if($orderby!='')
			$sql .= " order by ".$orderby;
		$sql .=" limit 0,".$limit;	
		//echo $sql;
		$rs=mysql_query($sql);
		$i=0;
		$arrlist=array();
		while($arrpt= mysql_fetch_array($rs))
		{
			$arrlist[$i]["reg_date"] = $arrpt["reg_date"];
			$arrlist[$i]["tot_cnt"] = $arrpt["tot_cnt"];
			$i++;
		}	
		return $arrlist;
	}
	function exporttoexcel($function)
	{
		$result_excel=$this->$function();
		$k=0;
		$file="test.xls";
		header("Content-Type: application/msexcel");
		header("Content-Disposition: attachment;filename=".$file );
		header('Expires: 0');
		header('Pragma: no-cache');
		$columns=mysql_num_fields($result_excel);
		for ($i = 0; $i < mysql_num_fields($result_excel); $i++)
        {
			print mysql_field_name($result_excel,$i)."\t";
        }
		echo "\n";
		While ($myrow = mysql_fetch_array($result_excel))
		{
            for ($i = 0; $i < ($columns); $i++)
            {
				echo str_replace(" ","&nbsp;",$myrow[$i])." ";
            }
			echo "\n";
        }
	}
	
	function getAllStateByStateReport($client_id)
	{
		$sql="select sum(rsr.tot_cnt) as tot_cnt,s.state_name,s.state_code from ".REPORT_DB_PREFIX."rpt_state as s left join ".REPORT_DB_PREFIX."rpt_state_reg rsr on s.state_id = rsr.state_id where 1=1 and rsr.client_id = '".$client_id."'";		
		$sql .=" group by s.state_id";
		$sql .=" order by s.state_code";
		//echo $sql;
		return mysql_query($sql);
	}
	
	function fetchFields($client_id=0)
	{
		$sql = "select * from ".REPORT_DB_PREFIX."rpt_field 
		 where 1=1 and (client_id = ".$client_id." or client_id=0) and field_header_field = 0 and field_name <> '' and field_isactive=1 and reg_type='General' ORDER BY client_id, field_order ";	
		
		$rs= mysql_query($sql);
		$i=0;
		$arrlist=array();
		
		if(mysql_num_rows($rs) > 0)
		{
			while($arrpt= mysql_fetch_array($rs))
			{
				$sql1 = "select * from ".REPORT_DB_PREFIX."rpt_field 
				where 1=1 and (client_id = ".$client_id." or client_id=0) and field_header_field = '".$arrpt['rpt_field_id']."' and field_name <> '' and field_isactive=1 and reg_type='General' ORDER BY field_order ";	
		
				$rs1= mysql_query($sql1);
			
				if(mysql_num_rows($rs1) > 0)
				{
					while($arrpt1= mysql_fetch_array($rs1))
					{
						$arrlist[$i]['field_id']=$arrpt1['rpt_field_id'];
						$arrlist[$i]['field'.$arrpt1['rpt_field_id']]='';
						$arrlist[$i]['field_caption']="<strong>".$arrpt['field_caption']."</strong>: ".$arrpt1['field_caption'];
						$arrlist[$i]['field_order']=$arrpt1['field_order'];
						$i++;
					}
				}
			}
		}	
			
		return $arrlist;
	}
	
	function selectedfield($reportid,$client_id=0)
	{
		$sql="select * from ".REPORT_DB_PREFIX."rpt_selected_field 
		left join ".REPORT_DB_PREFIX."rpt_field on ".REPORT_DB_PREFIX."rpt_field.rpt_field_id=".REPORT_DB_PREFIX."rpt_selected_field.field_id 
		where report_id=".$reportid." and field_isactive=1 and ".REPORT_DB_PREFIX."rpt_selected_field.client_id=".$client_id;
		//echo $sql;
		$rs= mysql_query($sql);
		$i=0;
		$arrlist=array();
		while($arrpt= mysql_fetch_array($rs))
		{
			$arrlist[$i]['field_id']=$arrpt['field_id'];
			$arrlist[$i]['report_id']=$arrpt['report_id'];
			$arrlist[$i]['rpt_selected_field_id']=$arrpt['rpt_selected_field_id'];
			$arrlist[$i]['field_caption']=$arrpt['field_caption'];
			$i++;
		}
		return $arrlist;
	}
	function saveselectedfield($post,$client_id=0)
	{
		$sql="delete from ".REPORT_DB_PREFIX."rpt_selected_field where client_id=".$client_id;
		mysql_query($sql);

		if(isset($post['field']))
		{	
			for($i=0;$i<count($post['field']);$i++)
			{
				$sql="insert into ".REPORT_DB_PREFIX."rpt_selected_field set
					report_id=".$post['report_id'].",
					client_id=".$client_id.",
					field_id=".$post['field'][$i];
					//echo $sql."<br>";
				mysql_query($sql);
			}
		}			
	}
	
	
	function topResourceDetailDashboard($regtype = "")
	{
		if($regtype==30)
		{
			$condition.= " AND reg_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 30 DAY ) AND '".currentScriptDate()."' ";
		}
		else if($regtype=="today")
		{
			$condition.= " AND reg_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 1 DAY ) AND '".currentScriptDate()."' ";
		}
		else if($regtype==7)
		{
			$condition.= " AND reg_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 7 DAY ) AND '".currentScriptDate()."' ";
		}
		else if($regtype=="Month")
		{
			$condition.= " AND reg_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 1 MONTH ) AND '".currentScriptDate()."' ";
		}
		else if($regtype=="Year")
		{
			$condition.= " AND reg_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 1 YEAR ) AND '".currentScriptDate()."' ";
		}
		
		$sql="SELECT sum( tot_cnt_website ) AS tot_cnt_website,sum( tot_cnt_facebook ) AS tot_cnt_facebook,sum(tot_cnt_gadget) AS tot_cnt_gadget,sum(tot_registration) AS tot_registration
		FROM ".REPORT_DB_PREFIX."rpt_date_source_reg where 1=1 ".$condition;
				
		$rs=mysql_query($sql);
		$i=0;
		$arrlist=array();
		while($arrpt= mysql_fetch_array($rs))
		{
			$arrlist[$i]["tot_cnt_website"] = $arrpt["tot_cnt_website"];
			$arrlist[$i]["tot_cnt_facebook"] = $arrpt["tot_cnt_facebook"];
			$arrlist[$i]["tot_cnt_gadget"] = $arrpt["tot_cnt_gadget"];
			$arrlist[$i]["tot_registration"] = $arrpt["tot_registration"];			
		}	
		return $arrlist;
	}
	
}