<?php
require_once 'include/general_includes.php';
$objTopClient = new topclientreport();

// check if user us logged in.
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$userID = $cmn->getSession(ADMIN_USER_ID);
$objTopClient = new topclientreport();
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

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

$datedata=$objTopClient->datewiseNextdetail($frmdate,$client_id);
$str ='';

 for($i=0;$i<count($datedata);$i++)
		{ 
			$dt=explode("-",$datedata[$i]['reg_date']);
			$regdate=$dt[1]."/".$dt[2]."/".$dt[0];
		$str.= 'data.addRow(["'.$regdate.'",'.$datedata[$i]['tot_cnt_facebook'].','.$datedata[$i]['tot_cnt_gadget'].','.$datedata[$i]['tot_cnt_website'].']);';
		}
if($_GET['flag']==1)
{			
echo "  var data = new google.visualization.DataTable();data.addColumn('string', 'Year');data.addColumn('number', 'Facebook');data.addColumn('number', 'Gadget');data.addColumn('number', 'Site');".$str."new google.visualization.AreaChart(document.getElementById('visualization')).draw(data, {curveType: 'function',width: chartwidth, height: 250, chartArea:{left: 70, width:chartareawidth}, vAxis: {title: 'Registrants', titleTextStyle: {color: 'black'}}, hAxis: {maxValue:10,maxAlternation:2}});";
}
else
{
	echo "  var data = new google.visualization.DataTable();data.addColumn('string', 'Year');data.addColumn('number', 'Facebook');data.addColumn('number', 'Gadget');data.addColumn('number', 'Site');".$str.";new google.visualization.ColumnChart(document.getElementById('visualization1')).draw(data, {curveType: 'function',width: chartwidth, height: 250, chartArea:{left: 70, width:chartareawidth}, vAxis: {title: 'Registrants', titleTextStyle: {color: 'black'}}, hAxis: {maxValue:10,maxAlternation:2}});";
}
?>