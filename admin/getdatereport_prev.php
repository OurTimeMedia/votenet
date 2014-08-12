<?php
//include base file
require_once 'include/general_includes.php';

//check admin login 
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

//create class object
$objpaging = new paging();
$objTopClient = new topclientreport();

$condition = "";
//get date detail for searching criteria
if(isset($_GET['txtdatefrom']) && $_GET['txtdatefrom']!='')
{
	$txtdatefrom=$_GET['txtdatefrom'];
	$fromdate=explode("/",$_GET['txtdatefrom']);
	$frmdate=$fromdate[2]."-".$fromdate[0]."-".$fromdate[1];
}
else
{
	$frmdate='';
	$txtdatefrom='';
}

//fetch date wise usage data
$datedata=$objTopClient->datewisePrevdetail($frmdate);
$str ='';
 
//create string of all source data
 for($i=0;$i<count($datedata);$i++)
		{ 
			$dt=explode("-",$datedata[$i]['reg_date']);
			$regdate=$dt[1]."/".$dt[2]."/".$dt[0];
		$str.= 'data.addRow(["'.$regdate.'",'.$datedata[$i]['tot_cnt_facebook'].','.$datedata[$i]['tot_cnt_gadget'].','.$datedata[$i]['tot_cnt_website'].' ]);';
		}
		
//generate google map		
if($_GET['flag']==1)
{	
	echo "  var data = new google.visualization.DataTable();data.addColumn('string', 'Year');data.addColumn('number', 'Facebook');data.addColumn('number', 'Gadget');data.addColumn('number', 'Site');".$str."new google.visualization.AreaChart(document.getElementById('visualization')).draw(data, {curveType: 'function',width: chartwidth, height: 250, chartArea:{left: 70, width:chartareawidth}, vAxis: {title: 'Registrants', titleTextStyle: {color: 'black'}}, hAxis: {maxValue:10,maxAlternation:2}});";
}
else
{
	echo "  var data = new google.visualization.DataTable();data.addColumn('string', 'Year');data.addColumn('number', 'Facebook');data.addColumn('number', 'Gadget');data.addColumn('number', 'Site');".$str."new google.visualization.ColumnChart(document.getElementById('visualization1')).draw(data, {curveType: 'function',width: chartwidth, height: 250, chartArea:{left: 70, width:chartareawidth}, vAxis: {title: 'Registrants', titleTextStyle: {color: 'black'}}, hAxis: {maxValue:10,maxAlternation:2}});";
}
?>
