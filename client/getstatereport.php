<?php
	require_once 'include/general_includes.php';
$objTopClient = new topclientreport();
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);
	$objpaging = new paging();
$currentpage=1;
$condition='';
	if($client_id!='')
	$condition .= " and client_id=".$client_id;	
$objTopClient->pagingType ="statebystaterpt";
$objpaging->strorderby = "tot_cnt";
$objpaging->strorder = "desc";

$statewisedata = $objpaging->setPageDetails($objTopClient,"state_by_state_report.php",PAGESIZE,$condition);
//print "<pre>";
//print_r($statewisedata);
$displaystate = 5;
$curpage=$_GET['curpage'];
$val=($curpage-1)*$displaystate;

if((count($statewisedata)-$val)>=$displaystate)
	$loop=$displaystate;
else
	$loop=(count($statewisedata)-$val);
	$str = "";
	for($i=$val;$i<($val+$loop);$i++)
	{ 
		$str .= "data.addRow(['".$statewisedata[$i]['state_name']."',".$statewisedata[$i]['tot_cnt']."]);";
	}
	echo " var data = new google.visualization.DataTable();data.addColumn('string', 'States');data.addColumn('number', 'Registrations');".$str."new google.visualization.ColumnChart(document.getElementById('visualization')).draw(data,{curveType: 'function',width: chartwidth, height: 230, chartArea:{left: 70, width:chartareawidth}, vAxis: {title: 'Registrants', titleTextStyle: {color: 'black'}}, hAxis: {maxValue:10,maxAlternation:2}});";
	
?>
