<?php 
header('Content-Type: application/x-msexcel; name=mostactivedays.xls');
header('Content-Disposition: inline;filename=mostactivedays.xls');
header("Content-Transfer-Encoding: binary ");
	
require_once 'include/general_includes.php';

$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$objpaging = new paging();
$condition = "";

$objTopClient = new topclientreport();
//print_r($_POST);

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
if(isset($_POST['txtdateto']) && $_POST['txtdateto']!='' )
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
if($frmdate && $todate=='')
{
	$condition .= " and reg_date>=".$frmdate;
}	
else if($todate && $frmdate=='')
{
	$condition .= " and reg_date<= ".$todate;
}	
else if($todate!='' && $frmdate!='')
	$condition .= " and reg_date between '".$frmdate."' and '".$todate."'";
	
$objTopClient->pagingType ="mostactivedays";
$objTopClient->noofdays ="10";
$objpaging->strorderby = "tot_cnt";
$objpaging->strorder = "desc";

$mostActiveDays = $objpaging->setPageDetails($objTopClient,"reports_state_by_state_summary.php",-1,$condition);
	
$objExcelWriter = new excelwriter();
// start the file
$objExcelWriter->xlsBOF();
// these will be used for keeping things in order.
$col = 0;
$row = 0;
// This tells us that we are on the first row
$first = true;
$str1 = "Days ^^^Total Registration###";
	if(count($mostActiveDays)>0 && is_array($mostActiveDays) && $mostActiveDays[0]['reg_date']!=''){
for ($i=0;$i<count($mostActiveDays);$i++)
{
	 
	 $str1.= $cmn->readValueDetail($mostActiveDays[$i]['reg_date']);
	$str1.="^^^".$cmn->readValueDetail($mostActiveDays[$i]['tot_cnt'])."###";
//echo $str1;exit;
}}
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