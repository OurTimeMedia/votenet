<?php 
header('Content-Type: application/x-msexcel; name=activeday.xls');
header('Content-Disposition: inline;filename=activeday.xls');
header("Content-Transfer-Encoding: binary ");

require_once 'include/general_includes.php';
$objTopClient = new topclientreport();

// check if user has logged in
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

$objpaging = new paging();
$currentpage=1;

$state=$objTopClient->statedetail($client_id);
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
if(isset($_POST['noofdays']) && $_POST['noofdays']!='')
	$noofdays =$_POST['noofdays'];
else	
	$noofdays = 5;
$objTopClient->pagingType = "activedays";
$objpaging->strorderby = "tot_cnt";
$objpaging->strorder = "desc";
$ActiveDays = $objpaging->setPageDetails($objTopClient,"usage_statistics_report.php",-1,$condition,'','',$noofdays);
	
$objExcelWriter = new excelwriter();
// start the file
$objExcelWriter->xlsBOF();
// these will be used for keeping things in order.
$col = 0;
$row = 0;
// This tells us that we are on the first row
$first = true;
$str1 = "Active Days^^^Total Registration###";
for ($i=0;$i<count($ActiveDays);$i++)
{
	$str1.= $cmn->readValueDetail($ActiveDays[$i]['reg_date']);
	$str1.="^^^".$cmn->readValueDetail($ActiveDays[$i]['tot_cnt'])."###";
//echo $str1;exit;
}
$str1 = substr($str1,0,-3);
//echo $str1."<br><Br>";
$aTest = explode('###', $str1);
for ($i=0; $i<count($aTest); $i++)
{
	$aItems = explode('^^^', $aTest[$i]);
	// go through the data
    foreach($aItems as $value)
    {
        // write it out
        $objExcelWriter->xlsWriteLabel( $row, $col, $value );
        $col++;
    }
    // reset col and goto next row
    $col = 0;
    $row++;
}
$objExcelWriter->xlsEOF();
exit();
?>