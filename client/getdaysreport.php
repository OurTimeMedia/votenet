<?php
require_once 'include/general_includes.php';
$objTopClient = new topclientreport();
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

$objpaging = new paging();
if(isset($_POST['txtdatefrom']) && $_POST['txtdatefrom']!='')
{
	$txtdatefrom=$_POST['txtdatefrom'];
	$fromdate=explode("/",$_POST['txtdatefrom']);
	$frmdate=$fromdate[2]."-".$fromdate[0]."-".$fromdate[1];
}
else
{
	$frmdate='';
	$txtdatefrom='';
}
if(isset($_POST['txtdateto']) && $_POST['txtdateto']!='')
{
	$txtdateto=$_POST['txtdateto'];
	$dateto=explode("/",$_POST['txtdateto']);
	$todate=$dateto[2]."-".$dateto[0]."-".$dateto[1];
}
else
{
	$todate='';
	$txtdateto='';
}
$condition='';
if($frmdate && $todate=='')
{
	$condition .= " and reg_date>=".$frmdate;
}	
if($todate && $frmdate=='')
{
	$condition .= " and reg_date<= ".$todate;
}	
if($todate!='' && $frmdate!='')
	$condition .= " and reg_date between '".$frmdate."' and '".$todate."'";
if($client_id!='')
	$condition .=" and rds.client_id=".$client_id;
if(isset($_REQUEST['noofdays']) && $_REQUEST['noofdays']!='')
	$noofdays =	$_REQUEST['noofdays'];
else	
	$noofdays = 5;
$objTopClient->pagingType = "activedays";
$objpaging->strorderby = "tot_cnt";
$objpaging->strorder = "desc";
$ActiveDays = $objpaging->setPageDetails($objTopClient,"usage_statistics_report.php",PAGESIZE,$condition,'','',$noofdays);
//echo count($ActiveDays);
$displaydays = 5;
 $noofpages = ceil(count($ActiveDays)/$displaydays);
$regdate='';
$str='';
$regstartdate='';
$curpage=$_GET['currentpage'];
//echo count($ActiveDays);
if(count($ActiveDays)>1 && $ActiveDays[0]['reg_date']!='')
{
	$start=($displaydays*$curpage)-$displaydays;
	if((count($ActiveDays)-$start)>=$displaydays)
		$dis=$displaydays;
	else
		$dis=(count($ActiveDays)-$start);
		//echo count($ActiveDays)."==".(count($ActiveDays)-$start)."==".$displaydays."--".$dis;
	for($i=$start;$i<($start+$dis);$i++)
	{ 
		$dt=explode("-",$ActiveDays[$i]['reg_date']);
		$regdate=$dt[1]."/".$dt[2]."/".$dt[0];
		if($i==0)
			$regstartdate=$regdate;
		$str.= "data.addRow(['".$regdate."',".$ActiveDays[$i]['tot_cnt']."]);";
	}
}
	echo " var data = new google.visualization.DataTable();
    data.addColumn('string', 'date');
    data.addColumn('number', 'Score');
    ".$str."new google.visualization.ColumnChart(document.getElementById('visualization')).
        draw(data, {curveType: 'function',width: chartwidth, height: 230, chartArea:{left: 70, width:chartareawidth}, vAxis: {title: 'Registrations', titleTextStyle: {color: 'black'}},hAxis: {title: 'Dates', titleTextStyle: {color: 'black'}}});|^|".$regdate."|^|".$regstartdate;
?>
